<?php
include_once '../config.php';
$query = "SELECT * FROM genre";
$result = mysqli_query($conn, $query);

$pageTitle = 'All Genres';
$adminPage = 'all-genres';
include_once 'includes/header.php';
?>

      <div class="page-heading">
        <div>
          <div class="eyebrow">Genres</div>
          <h1>All Genres</h1>
          <p>Music genres available on the platform.</p>
        </div>
        <a class="gold-btn" href="add-genre.php">＋ Add Genre</a>
      </div>

<?php if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'cannot_delete') { ?>
      <div style="background:#fdf2f2;border-left:4px solid #b00020;color:#8a0000;padding:12px 16px;margin-bottom:20px;border-radius:4px;font-size:14px;">This genre cannot be deleted because music is associated with it.</div>
    <?php }
} ?>

      <div class="admin-table-wrap">
        <div class="admin-table-header">
          <h2>All Genres</h2>
        </div>
        <table class="admin-table">
          <thead>
            <tr>
              <th>Genre Name</th>
              <th>Genre Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
<?php
 while ($genre = mysqli_fetch_assoc($result)) {
?>
<tr>
  <td>
   <strong><?php echo $genre['genre_name']; ?></strong>
    </td>
    
<td>
    <?php if (!empty($genre['image'])) { ?>
        <div class="avatar">
            <img src="<?php echo $genre['image']; ?>" alt="">
        </div>
    <?php } ?>
</td>


    <td>
       <a href="genre edit.php?id=<?php echo $genre['genre_id']; ?>"
   class="text-btn">
    Edit
</a>

<a href="genre delete.php?id=<?php echo $genre['genre_id']; ?>"
   class="text-btn danger"
   onclick="return confirm('Are you sure you want to delete this genre?')">
    Delete
</a>
  </td>
</tr>

<?php
}
?>
          </tbody>
        </table>
      </div>

<?php include_once 'includes/footer.php'; ?>
