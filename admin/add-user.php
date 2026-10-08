<?php

include_once '../config.php';

$error = '';

if (isset($_POST['submit'])) {

    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $role = htmlspecialchars($_POST['role']);

    if ($name == '' || $address == '' || $phone == '' || $email == '') {

        $error = 'Please fill all required fields.';

    } elseif (!preg_match('/^[A-Za-z\s]+$/', $name)) {

        $error = 'Name can contain letters and spaces only.';

    } elseif (strlen($name) > 20) {

        $error = 'Name cannot be more than 20 characters.';

    } elseif (!preg_match('/^[0-9]{11}$/', $phone)) {

        $error = 'Phone number must be exactly 11 digits.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = 'Please enter a valid email address.';

    } else {

        $name = mysqli_real_escape_string($conn, $name);
        $address = mysqli_real_escape_string($conn, $address);
        $phone = mysqli_real_escape_string($conn, $phone);
        $email = mysqli_real_escape_string($conn, $email);
        $role = mysqli_real_escape_string($conn, $role);

       

        $checkQuery = "SELECT user_id
                       FROM users
                       WHERE email = '$email'
                       AND phone = '$phone'
                       AND status = 'pending'
                       LIMIT 1";

        $checkResult = mysqli_query($conn, $checkQuery);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {

            $pendingUser = mysqli_fetch_assoc($checkResult);

            $userId = $pendingUser['user_id'];

          

            $updateQuery = "UPDATE users SET
                            name = '$name',
                            address = '$address',
                            phone = '$phone',
                            email = '$email',
                            role = '$role',
                            status = 'approved'
                            WHERE user_id = '$userId'";

            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {

                header('Location: all-users.php');
                exit();

            } else {

                $error = 'User could not be approved.';
            }

        } else {

            $error = 'Pending user not found. Please check email and phone number.';
        }
    }
}

$pageTitle = 'Add User';
$adminPage = 'add-user';

include_once 'includes/header.php';

?>

<div class="page-heading">

    <div>

        <div class="eyebrow">Users</div>

        <h1>Add User</h1>

        <p>Approve a registered user account.</p>

    </div>

    <a class="ghost-btn" href="all-users.php">
        ← Back to Users
    </a>

</div>


<div class="admin-form-card">

    <h2>User Details</h2>

    <form method="POST" action="" id="addUserForm">

        <div class="form-row">

            <div class="form-group">

                <label for="userName">Full Name</label>

                <input
                    type="text"
                    id="userName"
                    name="name"
                    placeholder="Enter full name"
                    maxlength="20"
                    required>

                <div
                    class="field-error"
                    id="userNameError">
                </div>

            </div>


            <div class="form-group">

                <label for="userEmail">Email Address</label>

                <input
                    type="email"
                    id="userEmail"
                    name="email"
                    placeholder="user@example.com"
                    required>

                <div
                    class="field-error"
                    id="userEmailError">
                </div>

            </div>

        </div>


        <div class="form-row">

            <div class="form-group">

                <label for="userPhone">Phone Number</label>

                <input
                    type="text"
                    id="userPhone"
                    name="phone"
                    placeholder="03001234567"
                    maxlength="11"
                    required>

                <div
                    class="field-error"
                    id="userPhoneError">
                </div>

            </div>


            <div class="form-group">

                <label for="userAddress">Address</label>

                <input
                    type="text"
                    id="userAddress"
                    name="address"
                    placeholder="Enter address"
                    maxlength="30"
                    required>

                <div
                    class="field-error"
                    id="userAddressError">
                </div>

            </div>

        </div>


        <div class="form-group">

            <label for="userRole">Role</label>

            <select
                id="userRole"
                name="role">

                <option value="user">User</option>

                <option value="admin">Admin</option>

            </select>

        </div>


        <div class="form-actions">

            <button
                type="submit"
                name="submit"
                class="gold-btn">

                Approve 

            </button>


            <a
                class="ghost-btn"
                href="all-users.php">

                Cancel

            </a>

        </div>


        <?php if ($error != '') { ?>

            <div class="field-error">

                <?php echo htmlspecialchars($error); ?>

            </div>

        <?php } ?>

    </form>

</div>


<script>

document.getElementById('addUserForm').addEventListener('submit', function(e) {

    var valid = true;

    var name = document.getElementById('userName').value.trim();
    var email = document.getElementById('userEmail').value.trim();
    var phone = document.getElementById('userPhone').value.trim();
    var address = document.getElementById('userAddress').value.trim();

    var ne = document.getElementById('userNameError');
    var ee = document.getElementById('userEmailError');
    var phe = document.getElementById('userPhoneError');
    var ade = document.getElementById('userAddressError');

    ne.textContent = '';
    ee.textContent = '';
    phe.textContent = '';
    ade.textContent = '';


    if (!name) {

        ne.textContent = 'Name is required';
        valid = false;

    } else if (!/^[A-Za-z\s]+$/.test(name)) {

        ne.textContent = 'Letters and spaces only';
        valid = false;

    } else if (name.length > 20) {

        ne.textContent = 'Max 20 characters';
        valid = false;
    }


    if (!email) {

        ee.textContent = 'Email is required';
        valid = false;

    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email)) {

        ee.textContent = 'Enter a valid email';
        valid = false;
    }


    if (!phone) {

        phe.textContent = 'Phone number is required';
        valid = false;

    } else if (!/^\d+$/.test(phone)) {

        phe.textContent = 'Numbers only';
        valid = false;

    } else if (phone.length !== 11) {

        phe.textContent = 'Phone number must be exactly 11 digits';
        valid = false;
    }


    if (!address) {

        ade.textContent = 'Please enter your address.';
        valid = false;

    } else if (!/^[A-Za-z0-9\s,.\-\/'#():]+$/.test(address)) {

        ade.textContent =
            'Only letters, numbers and common address characters allowed';

        valid = false;

    } else if (address.length > 30) {

        ade.textContent = 'Max 30 characters';
        valid = false;
    }


    if (!valid) {

        e.preventDefault();
    }

});


document.getElementById('userName').addEventListener('input', function() {

    var err = document.getElementById('userNameError');

    if (this.value.length > 20) {

        err.textContent = 'Max 20 characters';

    } else {

        err.textContent = '';
    }

});


document.getElementById('userPhone').addEventListener('input', function() {

    var err = document.getElementById('userPhoneError');

    var v = this.value;

    if (!/^\d*$/.test(v)) {

        err.textContent = 'Numbers only';

    } else if (v.length > 11) {

        err.textContent = 'Max 11 digits';

    } else {

        err.textContent = '';
    }

});


document.getElementById('userAddress').addEventListener('input', function() {

    var err = document.getElementById('userAddressError');

    var v = this.value;

    if (!/^[A-Za-z0-9\s,.\-\/'#():]*$/.test(v)) {

        err.textContent =
            'Only letters, numbers and common address characters allowed';

    } else if (v.length > 30) {

        err.textContent = 'Max 30 characters';

    } else {

        err.textContent = '';
    }

});

</script>


<?php include_once 'includes/footer.php'; ?>