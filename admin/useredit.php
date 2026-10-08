<?php
include_once '../config.php';

$id = $_GET['id'];

$query = "SELECT * FROM users WHERE user_id='$id'";
$result = mysqli_query($conn, $query);

$user = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $role = htmlspecialchars($_POST['role']);
    $image = htmlspecialchars($_POST['image']);

    $query = "UPDATE users SET
    name='$name',
    email='$email',
    phone='$phone',
    address='$address',
    role='$role',
    image='$image'
    WHERE user_id='$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:all-users.php');
        exit();
    }
}











$pageTitle = 'Edit User';
$adminPage = 'all-users';
include_once 'includes/header.php';
?>



<div class="page-heading">
    <div>
        <div class="eyebrow">Users</div>
        <h1>Edit User</h1>
        <p>Update user information.</p>
    </div>
</div>

<div class="admin-form-card">
    <h2>User Details</h2>

    <form method="POST" action="">

        <div class="form-row">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name"
                       value="<?php echo $user['name']; ?>">
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email"
                       value="<?php echo $user['email']; ?>">
            </div>

        </div>

        <div class="form-row">

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone"
                       value="<?php echo $user['phone']; ?>">
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address"
                       value="<?php echo $user['address']; ?>">
            </div>

        </div>

        <div class="form-row">

            <div class="form-group">
                <label>Role</label>

                <select name="role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>

            </div>

            <div class="form-group">
                <label>Image URL</label>
                <input type="url" name="image"
                       value="<?php echo $user['image']; ?>">
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" name="update" class="gold-btn">
                Update User
            </button>

            <a class="ghost-btn" href="all-users.php">
                Cancel
            </a>
        </div>

    </form>
</div>


<?php include_once 'includes/footer.php'; ?>
