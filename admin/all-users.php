<?php
include_once '../config.php';
$query = "SELECT * FROM users WHERE status = 'approved'";
$result = mysqli_query($conn, $query);

$pageTitle = 'All Users';
$adminPage = 'all-users';
include_once 'includes/header.php';
?>

      <div class="page-heading">
        <div>
          <div class="eyebrow">Users</div>
          <h1>All Users</h1>
          <p>Manage registered users on Audio Zone.</p>
        </div>
        <a class="gold-btn" href="add-user.php">＋ Add User</a>
      </div>

      <div class="admin-table-wrap">
        <div class="admin-table-header">
          <h2>ALL Users</h2>
        </div>
        <table class="admin-table">
          <thead>
            <tr>
              <th>User Name</th>
               <th>Image</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Address</th>
              <th>role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            
        <?php
while ($user = mysqli_fetch_assoc($result)) {
?>

<tr>
    <td><?php echo $user['name']; ?></td>
  <td>
    <?php if (!empty($user['image'])) { ?>
        <div class="avatar">
            <img src="<?php echo $user['image']; ?>" alt="">
        </div>
    <?php } ?>
</td>
    </td>
    <td><?php echo $user['email']; ?></td>
    <td><?php echo $user['phone']; ?></td>
    <td><?php echo $user['address']; ?></td>
    <td><?php echo $user['role']; ?></td>
    
   <td>
    <div style="display: flex; align-items: center; gap: 8px; white-space: nowrap;">
        
        <a href="useredit.php?id=<?php echo $user['user_id']; ?>" class="text-btn">
            Edit
        </a>

        <a href="user delet.php?id=<?php echo $user['user_id']; ?>" 
        class="text-btn danger"
         onclick="return confirm('Are you sure you want to delete this user?')">
            Delete
        </a>

    </div>
</td>
</tr>

<?php
}
?>


















          </tbody>
        </table>
      </div>

<?php include_once 'includes/footer.php'; ?>
