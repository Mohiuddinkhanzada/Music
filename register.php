<?php

include_once './config.php';

session_start();

$pageTitle = 'Register — Audio Zone';
$activePage = 'register';

$regError = '';
$regSuccess = '';

$name = '';
$address = '';
$phone = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name == '' || $address == '' || $phone == '' || $email == '' || $password == '') {

        $regError = 'All fields are required except image.';

    } elseif (strlen($name) > 100) {

        $regError = 'Name cannot be more than 100 characters.';

    } elseif (!preg_match('/^[A-Za-zÀ-ÿ ]+$/', $name)) {

        $regError = 'Name can contain letters and spaces only.';

    } elseif (!preg_match('/^[0-9]{11}$/', $phone)) {

        $regError = 'Phone number must be exactly 11 digits.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $regError = 'Please enter a valid email address.';

    } elseif (strlen($password) < 8) {

        $regError = 'Password must be at least 8 characters.';

    } else {

        $name = mysqli_real_escape_string($conn, $name);
        $address = mysqli_real_escape_string($conn, $address);
        $phone = mysqli_real_escape_string($conn, $phone);
        $email = mysqli_real_escape_string($conn, $email);

        $checkEmail = mysqli_query(
            $conn,
            "SELECT user_id FROM users WHERE email = '$email' LIMIT 1"
        );

        $checkPhone = mysqli_query(
            $conn,
            "SELECT user_id FROM users WHERE phone = '$phone' LIMIT 1"
        );

        if (!$checkEmail || !$checkPhone) {

            $regError = 'Something went wrong. Please try again.';

        } elseif (mysqli_num_rows($checkEmail) > 0) {

            $regError = 'This email address already exists.';

        } elseif (mysqli_num_rows($checkPhone) > 0) {

            $regError = 'This phone number already exists.';

        } else {

            $imageName = '';

            if (isset($_FILES['image']) && $_FILES['image']['error'] != 4) {

                if ($_FILES['image']['error'] != 0) {

                    $regError = 'There was a problem uploading the image.';

                } else {

                    $originalImageName = $_FILES['image']['name'];
                    $imageExtension = strtolower(pathinfo($originalImageName, PATHINFO_EXTENSION));

                    if ($imageExtension != 'jpg' &&
                        $imageExtension != 'jpeg' &&
                        $imageExtension != 'png' &&
                        $imageExtension != 'gif' &&
                        $imageExtension != 'webp') {

                        $regError = 'Please select a valid image file.';

                    } else {

                        $uploadFolder = 'assets/images/users/';

                        if (!is_dir($uploadFolder)) {
                            mkdir($uploadFolder, 0777, true);
                        }

                        $newImageName = time() . '_' . basename($originalImageName);
                        $imagePath = $uploadFolder . $newImageName;

                        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {

                            $regError = 'Image upload failed. Please try again.';

                        } else {

                            $imageName = $newImageName;
                        }
                    }
                }
            }

            if ($regError == '') {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $insertQuery = "INSERT INTO users
                                (name, address, phone, email, password, image)
                                VALUES
                                ('$name', '$address', '$phone', '$email', '$hashedPassword', '$imageName')";

                $insertResult = mysqli_query($conn, $insertQuery);

                if ($insertResult) {

                    $newUserId = mysqli_insert_id($conn);

                    $_SESSION['user_id'] = $newUserId;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_image'] = $imageName;

                    header('Location: home.php');
                    exit();

                } else {

                    $regError = 'Something went wrong. Please try again.';
                }
            }
        }
    }
}

include_once 'includes/header.php';
?>

<section class="page">

    <div class="auth-wrap">

        <aside class="auth-side">

            <div class="auth-copy">

                <div class="eyebrow">Audio Zone</div>

                <h2>Feel the sound everywhere you go.</h2>

                <p>
                    Your music, your videos, your artists — take them anywhere
                    and keep the sound playing all day.
                </p>

            </div>

            <svg
                class="auth-side-art"
                viewBox="0 0 640 460"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                role="img"
                aria-label="Premium over-ear studio headphones emitting glowing green sound waves">

                <defs>

                    <radialGradient id="hpGlow" cx="50%" cy="46%" r="62%">
                        <stop offset="0" stop-color="#1ed760" stop-opacity=".32"/>
                        <stop offset=".55" stop-color="#1ed760" stop-opacity=".10"/>
                        <stop offset="1" stop-color="#1ed760" stop-opacity="0"/>
                    </radialGradient>

                    <linearGradient id="bandMetal" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0" stop-color="#3f3f43"/>
                        <stop offset=".5" stop-color="#212124"/>
                        <stop offset="1" stop-color="#0e0e10"/>
                    </linearGradient>

                    <linearGradient id="leather" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0" stop-color="#17181b"/>
                        <stop offset="1" stop-color="#060607"/>
                    </linearGradient>

                    <radialGradient id="cupShell" cx=".32" cy=".22" r="1.15">
                        <stop offset="0" stop-color="#333337"/>
                        <stop offset=".45" stop-color="#1b1b1e"/>
                        <stop offset="1" stop-color="#09090b"/>
                    </radialGradient>

                    <linearGradient id="cupRim" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0" stop-color="rgba(255,255,255,.35)"/>
                        <stop offset=".5" stop-color="rgba(255,255,255,.06)"/>
                        <stop offset="1" stop-color="rgba(0,0,0,.65)"/>
                    </linearGradient>

                    <radialGradient id="padRing" cx=".4" cy=".3" r="1.15">
                        <stop offset="0" stop-color="#191a1d"/>
                        <stop offset="1" stop-color="#050506"/>
                    </radialGradient>

                    <radialGradient id="emblem" cx=".35" cy=".3" r="1.2">
                        <stop offset="0" stop-color="#3d3d42"/>
                        <stop offset=".6" stop-color="#1f1f23"/>
                        <stop offset="1" stop-color="#0f0f12"/>
                    </radialGradient>

                    <radialGradient id="cupGlow" cx="50%" cy="50%" r="50%">
                        <stop offset="0" stop-color="#1ed760" stop-opacity=".5"/>
                        <stop offset=".55" stop-color="#1ed760" stop-opacity=".16"/>
                        <stop offset="1" stop-color="#1ed760" stop-opacity="0"/>
                    </radialGradient>

                </defs>

                <ellipse cx="320" cy="252" rx="302" ry="188" fill="url(#hpGlow)"/>
                <ellipse cx="320" cy="432" rx="198" ry="15" fill="#000000" opacity=".55"/>
                <ellipse cx="320" cy="432" rx="130" ry="8" fill="#1ed760" opacity=".14"/>

                <g class="glow-green">
                    <ellipse class="sound-ring" cx="215" cy="314" rx="96" ry="118" stroke="#1ed760" stroke-width="1.6" fill="none"/>
                    <ellipse class="sound-ring r2" cx="215" cy="314" rx="96" ry="118" stroke="#1ed760" stroke-width="1.2" fill="none"/>
                    <ellipse class="sound-ring r3" cx="215" cy="314" rx="96" ry="118" stroke="#1ed760" stroke-width="1" fill="none"/>
                </g>

                <g class="glow-green">
                    <ellipse class="sound-ring" cx="425" cy="314" rx="96" ry="118" stroke="#1ed760" stroke-width="1.6" fill="none"/>
                    <ellipse class="sound-ring r2" cx="425" cy="314" rx="96" ry="118" stroke="#1ed760" stroke-width="1.2" fill="none"/>
                    <ellipse class="sound-ring r3" cx="425" cy="314" rx="96" ry="118" stroke="#1ed760" stroke-width="1" fill="none"/>
                </g>

                <g class="glow-green" stroke="#1ed760" fill="none">
                    <path class="wave-stream" stroke-width="2" d="M136 278 q-8 -12 -16 0 t-16 0 t-16 0 t-16 0 t-16 0"/>
                    <path class="wave-stream" stroke-width="1.6" d="M136 314 q-8 -12 -16 0 t-16 0 t-16 0 t-16 0 t-16 0"/>
                    <path class="wave-stream" stroke-width="2" d="M136 350 q-8 -12 -16 0 t-16 0 t-16 0 t-16 0 t-16 0"/>
                </g>

                <g class="glow-green" stroke="#1ed760" fill="none">
                    <path class="wave-stream" stroke-width="2" d="M504 278 q8 -12 16 0 t16 0 t16 0 t16 0 t16 0"/>
                    <path class="wave-stream" stroke-width="1.6" d="M504 314 q8 -12 16 0 t16 0 t16 0 t16 0 t16 0"/>
                    <path class="wave-stream" stroke-width="2" d="M504 350 q8 -12 16 0 t16 0 t16 0 t16 0 t16 0"/>
                </g>

                <g class="glow-green" stroke="#1ed760" stroke-width="2" stroke-linecap="round">
                    <path class="ray" d="M320 72 L272 16"/>
                    <path class="ray r2" d="M320 72 L320 10"/>
                    <path class="ray r3" d="M320 72 L368 16"/>
                    <path class="ray r4" d="M320 72 L288 12"/>
                    <path class="ray r5" d="M320 72 L352 12"/>
                </g>

                <path d="M215 262 C 200 132, 258 90, 320 90 C 382 90, 440 132, 425 262"
                      stroke="url(#bandMetal)"
                      stroke-width="24"
                      stroke-linecap="round"
                      fill="none"/>

                <path d="M222 254 C 210 136, 262 96, 320 96 C 378 96, 430 136, 418 254"
                      stroke="rgba(255,255,255,.20)"
                      stroke-width="4"
                      stroke-linecap="round"
                      fill="none"/>

                <path d="M237 246 C 228 150, 266 110, 320 110 C 374 110, 412 150, 403 246"
                      stroke="url(#leather)"
                      stroke-width="18"
                      stroke-linecap="round"
                      fill="none"/>

                <path d="M252 236 C 247 172, 276 134, 320 134 C 364 134, 393 172, 388 236"
                      stroke="rgba(255,255,255,.08)"
                      stroke-width="2.5"
                      stroke-linecap="round"
                      fill="none"/>

                <rect x="206" y="248" width="18" height="26" rx="9" fill="url(#bandMetal)"/>
                <rect x="210" y="256" width="10" height="4" rx="2" fill="rgba(255,255,255,.14)"/>

                <rect x="416" y="248" width="18" height="26" rx="9" fill="url(#bandMetal)"/>
                <rect x="420" y="256" width="10" height="4" rx="2" fill="rgba(255,255,255,.14)"/>

                <g transform="rotate(-6 215 314)">
                    <ellipse cx="215" cy="314" rx="92" ry="118" fill="url(#cupGlow)"/>

                    <rect x="163" y="248" width="104" height="132" rx="30"
                          fill="url(#cupShell)"
                          stroke="url(#cupRim)"
                          stroke-width="2"/>

                    <path d="M175 252 h80 l-6 14 h-68 z"
                          fill="url(#bandMetal)"/>

                    <path d="M178 262 Q 168 314 178 366"
                          stroke="rgba(255,255,255,.28)"
                          stroke-width="6"
                          stroke-linecap="round"
                          fill="none"/>

                    <path d="M250 262 Q 258 314 250 366"
                          stroke="rgba(0,0,0,.5)"
                          stroke-width="10"
                          stroke-linecap="round"
                          fill="none"/>

                    <path d="M168 314 h94"
                          stroke="rgba(255,255,255,.07)"
                          stroke-width="1.4"/>

                    <ellipse cx="215" cy="314" rx="30" ry="52"
                             fill="url(#padRing)"/>

                    <ellipse cx="215" cy="314" rx="30" ry="52"
                             fill="none"
                             stroke="rgba(30,215,96,.30)"
                             stroke-width="1.3"/>

                    <ellipse cx="215" cy="314" rx="13" ry="13"
                             fill="url(#emblem)"
                             stroke="rgba(255,255,255,.22)"
                             stroke-width="1.4"/>

                    <ellipse cx="215" cy="314" rx="7.5" ry="7.5"
                             fill="none"
                             stroke="rgba(255,255,255,.18)"
                             stroke-width="1"/>

                    <circle cx="215" cy="314" r="5"
                            fill="#1ed760"
                            opacity=".22"/>

                    <circle cx="215" cy="314" r="2.2"
                            fill="#1ed760"
                            opacity=".95"/>
                </g>

                <g transform="rotate(6 425 314)">
                    <ellipse cx="425" cy="314" rx="92" ry="118" fill="url(#cupGlow)"/>

                    <rect x="373" y="248" width="104" height="132" rx="30"
                          fill="url(#cupShell)"
                          stroke="url(#cupRim)"
                          stroke-width="2"/>

                    <path d="M385 252 h80 l6 14 h-68 z"
                          fill="url(#bandMetal)"/>

                    <path d="M462 262 Q 472 314 462 366"
                          stroke="rgba(255,255,255,.28)"
                          stroke-width="6"
                          stroke-linecap="round"
                          fill="none"/>

                    <path d="M390 262 Q 382 314 390 366"
                          stroke="rgba(0,0,0,.5)"
                          stroke-width="10"
                          stroke-linecap="round"
                          fill="none"/>

                    <path d="M378 314 h94"
                          stroke="rgba(255,255,255,.07)"
                          stroke-width="1.4"/>

                    <ellipse cx="425" cy="314" rx="30" ry="52"
                             fill="url(#padRing)"/>

                    <ellipse cx="425" cy="314" rx="30" ry="52"
                             fill="none"
                             stroke="rgba(30,215,96,.30)"
                             stroke-width="1.3"/>

                    <ellipse cx="425" cy="314" rx="13" ry="13"
                             fill="url(#emblem)"
                             stroke="rgba(255,255,255,.22)"
                             stroke-width="1.4"/>

                    <ellipse cx="425" cy="314" rx="7.5" ry="7.5"
                             fill="none"
                             stroke="rgba(255,255,255,.18)"
                             stroke-width="1"/>

                    <circle cx="425" cy="314" r="5"
                            fill="#1ed760"
                            opacity=".22"/>

                    <circle cx="425" cy="314" r="2.2"
                            fill="#1ed760"
                            opacity=".95"/>
                </g>

            </svg>

        </aside>

        <form class="auth-form" method="POST" action="register.php" enctype="multipart/form-data">

            <h1>Create account</h1>

            <?php if ($regError != '') { ?>
                <p style="color:#f87171;font-size:12.5px;margin-bottom:14px;">
                    <?php echo htmlspecialchars($regError); ?>
                </p>
            <?php } ?>

            <?php if ($regSuccess != '') { ?>
                <p style="color:#1ed760;font-size:12.5px;margin-bottom:14px;">
                    <?php echo htmlspecialchars($regSuccess); ?>
                </p>
            <?php } ?>

            <div class="field">
                <label for="regName">Name</label>

                <div class="input-wrap">

                    <svg class="field-icon"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         aria-hidden="true">

                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 21c1.4-3.6 4.3-5.4 8-5.4s6.6 1.8 8 5.4"/>

                    </svg>

                    <input
                        id="regName"
                        name="name"
                        type="text"
                        maxlength="100"
                        value="<?php echo htmlspecialchars($name); ?>"
                        required
                        placeholder="Your full name">

                </div>
            </div>

            <div class="field">
                <label for="regImage">Profile Image</label>

                <div class="input-wrap">

                    <input
                        id="regImage"
                        name="image"
                        type="file"
                        accept="image/*">

                </div>
            </div>

     <div class="field">
    <label for="regAddress">Address</label>

    <div class="input-wrap">

        <svg class="field-icon"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="1.8"
             stroke-linecap="round"
             stroke-linejoin="round"
             aria-hidden="true">

            <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0z"/>
            <circle cx="12" cy="10" r="2.5"/>

        </svg>

        <input
            id="regAddress"
            name="address"
            type="text"
            value="<?php echo htmlspecialchars($address); ?>"
            required
            placeholder="Your address">

    </div>
</div>




           
<div class="field">
    <label for="regPhone">Phone Number</label>

    <div class="input-wrap">

        <svg class="field-icon"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="1.8"
             stroke-linecap="round"
             stroke-linejoin="round"
             aria-hidden="true">

            <rect x="6" y="3" width="12" height="18" rx="2"/>
            <path d="M9 7h6"/>
            <path d="M10 18h4"/>

        </svg>

        <input
            id="regPhone"
            name="phone"
            type="tel"
            maxlength="11"
            pattern="[0-9]{11}"
            inputmode="numeric"
            value="<?php echo htmlspecialchars($phone); ?>"
            required
            placeholder="Your phone number">

    </div>
</div>

            <div class="field">
                <label for="regEmail">Email</label>

                <div class="input-wrap">

                    <svg class="field-icon"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         aria-hidden="true">

                        <rect x="3" y="5" width="18" height="14" rx="3"/>
                        <path d="m3 7.5 9 6 9-6"/>

                    </svg>

                    <input
                        id="regEmail"
                        name="email"
                        type="email"
                        value="<?php echo htmlspecialchars($email); ?>"
                        required
                        placeholder="you@example.com">

                </div>
            </div>

            <div class="field">
                <label for="regPassword">Password</label>

                <div class="input-wrap has-toggle">

                    <svg class="field-icon"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         aria-hidden="true">

                        <rect x="5" y="11" width="14" height="9" rx="2"/>
                        <path d="M8 11V7a4 4 0 0 1 8 0v4"/>

                    </svg>

                    <input
                        id="regPassword"
                        name="password"
                        type="password"
                        minlength="8"
                        required
                        placeholder="At least 8 characters">

                    <button
                        type="button"
                        class="toggle-pass"
                        aria-label="Show password">

                        <svg class="icon-eye"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             aria-hidden="true">

                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                            <circle cx="12" cy="12" r="3"/>

                        </svg>

                        <svg class="icon-eye-off"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             aria-hidden="true">

                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                            <line x1="3.5" y1="3.5" x2="20.5" y2="20.5"/>

                        </svg>

                    </button>

                </div>
            </div>

            <button class="gold-btn" type="submit">
                Create account
            </button>

        </form>

    </div>

</section>

<script>
document.querySelectorAll(".toggle-pass").forEach(function(button) {

    button.addEventListener("click", function() {

        var wrap = button.closest(".input-wrap");
        var input = wrap.querySelector("input");

        if (input.type == "password") {

            input.type = "text";
            wrap.classList.add("show-pass");
            button.setAttribute("aria-label", "Hide password");

        } else {

            input.type = "password";
            wrap.classList.remove("show-pass");
            button.setAttribute("aria-label", "Show password");
        }
    });

});
</script>

<?php
include_once 'includes/footer.php';
?>