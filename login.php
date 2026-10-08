<?php

include_once './config.php';

session_start();

$error = '';

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email == '' || $password == '') {

        $error = "Please enter both email and password.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        $email = mysqli_real_escape_string($conn, $email);

        $query = "SELECT user_id, name, email, password, image
                  FROM users
                  WHERE email = '$email'
                  LIMIT 1";

        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {

            $user = mysqli_fetch_assoc($result);

            $userId = $user['user_id'];
            $userName = $user['name'];
            $userEmail = $user['email'];
            $userPassword = $user['password'];
            $userImage = $user['image'];

            if (password_verify($password, $userPassword)) {

                $_SESSION['user_id'] = $userId;
                $_SESSION['user_name'] = $userName;
                $_SESSION['user_email'] = $userEmail;
                $_SESSION['user_image'] = $userImage;

                header('Location: home.php');
                exit();

            } else {

                $error = "Invalid email or password.";
            }

        } else {

            $error = "Invalid email or password.";
        }
    }
}

$pageTitle = 'Login';
$bodyClass = 'page-solid';

include_once 'includes/header.php';
?>

<div class="login-page">

    <div class="login-modal-card">

        <div class="login-modal-header">

            <img
                src="assets/images/audio-zone-logo.png"
                alt="Audio Zone"
                class="login-modal-logo">

            <h2 id="loginModalTitle">Welcome back</h2>

            <p>Sign in to continue listening.</p>

        </div>

        <form
            method="POST"
            action="login.php"
            class="login-modal-form">

            <?php if ($error != '') { ?>

                <p class="login-modal-error">
                    <?php echo htmlspecialchars($error); ?>
                </p>

            <?php } ?>

            <div class="field">

                <label for="loginEmail">Email</label>

                <div class="input-wrap">

                    <svg
                        class="field-icon"
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
                        id="loginEmail"
                        type="email"
                        name="email"
                        required
                        placeholder="you@example.com"
                        autocomplete="email">

                </div>

            </div>

            <div class="field">

                <label for="loginPassword">Password</label>

                <div class="input-wrap has-toggle">

                    <svg
                        class="field-icon"
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
                        id="loginPassword"
                        type="password"
                        name="password"
                        required
                        placeholder="Your password"
                        autocomplete="current-password">

                    <button
                        type="button"
                        class="toggle-pass"
                        aria-label="Show password">

                        <svg
                            class="icon-eye"
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

                        <svg
                            class="icon-eye-off"
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

            <button
                type="submit"
                name="login"
                class="gold-btn login-modal-submit">
                Sign in
            </button>

            <p class="login-modal-alt">
                Don't have an account?
                <a href="register.php">Create one</a>
            </p>

        </form>

    </div>

</div>

<?php include_once 'includes/footer.php'; ?>