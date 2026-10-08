<?php

include_once './config.php';

session_start();

if (!isset($_SESSION['user_id'])) {

    header('Location: login.php');
    exit();

}

$userId = $_SESSION['user_id'];

$error = '';

$name = '';
$address = '';
$phone = '';
$email = '';
$image = '';


$query = "SELECT name, address, phone, email, image
          FROM users
          WHERE user_id = '$userId'
          LIMIT 1";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {

    $user = mysqli_fetch_assoc($result);

    $name = $user['name'];
    $address = $user['address'];
    $phone = $user['phone'];
    $email = $user['email'];
    $image = $user['image'];
}


if (isset($_POST['update_profile'])) {

    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $newPassword = $_POST['password'];

    if ($name == '' || $address == '' || $phone == '' || $email == '') {

        $error = 'All fields are required.';

    } elseif (!preg_match('/^[A-Za-zÀ-ÿ ]+$/', $name)) {

        $error = 'Name can contain letters and spaces only.';

    } elseif (!preg_match('/^[0-9]{11}$/', $phone)) {

        $error = 'Phone number must be exactly 11 digits.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = 'Please enter a valid email address.';

    } elseif ($newPassword != '' && strlen($newPassword) < 8) {

        $error = 'Password must be at least 8 characters.';

    } else {

        $name = mysqli_real_escape_string($conn, $name);
        $address = mysqli_real_escape_string($conn, $address);
        $phone = mysqli_real_escape_string($conn, $phone);
        $email = mysqli_real_escape_string($conn, $email);

        $emailQuery = "SELECT user_id
                       FROM users
                       WHERE email = '$email'
                       AND user_id != '$userId'
                       LIMIT 1";

        $emailResult = mysqli_query($conn, $emailQuery);

        $phoneQuery = "SELECT user_id
                       FROM users
                       WHERE phone = '$phone'
                       AND user_id != '$userId'
                       LIMIT 1";

        $phoneResult = mysqli_query($conn, $phoneQuery);

        if ($emailResult && mysqli_num_rows($emailResult) > 0) {

            $error = 'This email address already exists.';

        } elseif ($phoneResult && mysqli_num_rows($phoneResult) > 0) {

            $error = 'This phone number already exists.';

        } else {

            $imageName = $image;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

                $imageName = $_FILES['image']['name'];
                $imageTmp = $_FILES['image']['tmp_name'];
                $imageSize = $_FILES['image']['size'];
                $imageType = $_FILES['image']['type'];

                $allowedTypes = array(
                    'image/jpeg',
                    'image/png',
                    'image/jpg',
                    'image/webp'
                );

                if (!in_array($imageType, $allowedTypes)) {

                    $error = 'Please select a valid image.';

                } elseif ($imageSize > 5000000) {

                    $error = 'Image size must be less than 5MB.';

                } else {

                    $uploadFolder = 'assets/images/users/';

                    if (!is_dir($uploadFolder)) {

                        mkdir($uploadFolder, 0777, true);
                    }

                    $imageName = time() . '_' . basename($imageName);

                    move_uploaded_file(
                        $imageTmp,
                        $uploadFolder . $imageName
                    );
                }
            }


            if ($error == '') {

                if ($newPassword == '') {

                    $updateQuery = "UPDATE users SET
                                    name = '$name',
                                    address = '$address',
                                    phone = '$phone',
                                    email = '$email',
                                    image = '$imageName'
                                    WHERE user_id = '$userId'";

                } else {

                    $hashedPassword = password_hash(
                        $newPassword,
                        PASSWORD_DEFAULT
                    );

                    $updateQuery = "UPDATE users SET
                                    name = '$name',
                                    address = '$address',
                                    phone = '$phone',
                                    email = '$email',
                                    password = '$hashedPassword',
                                    image = '$imageName'
                                    WHERE user_id = '$userId'";
                }


                $updateResult = mysqli_query($conn, $updateQuery);

                if ($updateResult) {

                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_image'] = $imageName;

                    header('Location: home.php');
                    exit();

                } else {

                    $error = 'Profile could not be updated.';
                }
            }
        }
    }
}


$pageTitle = 'Edit Profile — Audio Zone';
$activePage = '';

include_once 'includes/header.php';

?>

<section class="page">

    <div class="auth-wrap">

        <div class="auth-form">

            <h1>Edit Profile</h1>

            <p>Update your account information.</p>


            <?php if ($error != '') { ?>

                <p style="color:#f87171;font-size:12.5px;margin-bottom:14px;">

                    <?php echo htmlspecialchars($error); ?>

                </p>

            <?php } ?>


            <form
                method="POST"
                action="edit-profile.php"
                enctype="multipart/form-data">


                

                <div class="field">

                    <label for="editName">Name</label>

                    <div class="input-wrap">

                        <input
                            id="editName"
                            name="name"
                            type="text"
                            maxlength="100"
                            value="<?php echo htmlspecialchars($name); ?>"
                            required
                            placeholder="Your full name">

                    </div>

                </div>


                

                <div class="field">

                    <label for="editImage">Profile Image</label>

                    <div class="input-wrap">

                        <input
                            id="editImage"
                            name="image"
                            type="file"
                            accept="image/*">

                    </div>

                </div>


                

                <div class="field">

                    <label for="editAddress">Address</label>

                    <div class="input-wrap">

                        <input
                            id="editAddress"
                            name="address"
                            type="text"
                            value="<?php echo htmlspecialchars($address); ?>"
                            required
                            placeholder="Your address">

                    </div>

                </div>


                

                <div class="field">

                    <label for="editPhone">Phone Number</label>

                    <div class="input-wrap">

                        <input
                            id="editPhone"
                            name="phone"
                            type="tel"
                            maxlength="11"
                            value="<?php echo htmlspecialchars($phone); ?>"
                            required
                            placeholder="Your phone number">

                    </div>

                </div>


                

                <div class="field">

                    <label for="editEmail">Email</label>

                    <div class="input-wrap">

                        <input
                            id="editEmail"
                            name="email"
                            type="email"
                            value="<?php echo htmlspecialchars($email); ?>"
                            required
                            placeholder="you@example.com">

                    </div>

                </div>


                

                <div class="field">

                    <label for="editPassword">Password</label>

                    <div class="input-wrap">

                        <input
                            id="editPassword"
                            name="password"
                            type="password"
                            minlength="8"
                            placeholder="Enter new password (optional)">

                    </div>

                </div>


                

                <div
                    style="
                        display:flex;
                        gap:12px;
                        margin-top:20px;
                    ">

                    <button
                        class="gold-btn"
                        type="submit"
                        name="update_profile"
                        style="
                            width:50%;
                        ">

                        Update Profile

                    </button>


                    <a
                        href="home.php"
                        class="ghost-btn"
                        style="
                            width:50%;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            text-decoration:none;
                            box-sizing:border-box;
                        ">

                        Cancel

                    </a>

                </div>


            </form>

        </div>

    </div>

</section>


<?php

include_once 'includes/footer.php';

?>