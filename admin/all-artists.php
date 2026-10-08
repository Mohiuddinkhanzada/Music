<?php
include_once '../config.php';
$query = "SELECT * FROM artists";
$result = mysqli_query($conn, $query);



$pageTitle = 'All Artists';
$adminPage = 'all-artists';
include_once 'includes/header.php';
?>

      <div class="page-heading">
        <div>
          <div class="eyebrow">Artists</div>
          <h1>All Artists</h1>
          <p>Manage artists across all languages.</p>
        </div>
        <a class="gold-btn" href="add-artist.php">＋ Add Artist</a>
      </div>

      <div class="admin-table-wrap">
        <div class="admin-table-header">
          <h2>30 Artists</h2>
        </div>
        <table class="admin-table">
          <thead>
            <tr>
              <th>Artist</th>
              <th>artist image</th>
              <th>Followers</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
           <?php
while ($artist = mysqli_fetch_assoc($result)) {
?>

<tr>
    <td>
    <?php echo $artist['artist_name']; ?></td>
    <td>
    <?php if (!empty($artist['image'])) { ?>
     <div class="avatar">
     <img src="<?php echo $artist['image']; ?>" alt="">
     </div>
    <?php } ?>
    </td>
    <td>
  <?php echo $artist['followers']; ?></td>
  <td style="min-width: 100px; white-space: nowrap;">
  <a href="edit artist.php?id=<?php echo $artist['artist_id']; ?>" class="text-btn">
      Edit
  </a>
   <a href="delete artist.php?id=<?php echo $artist['artist_id']; ?>"  
   class="text-btn danger"
   onclick="return confirm('Are you sure you want to delete this artist?')">
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
