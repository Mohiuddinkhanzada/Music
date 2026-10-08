<?php
include_once '../config.php';
$query = "SELECT * FROM albums";
$result = mysqli_query($conn, $query);


$pageTitle = 'All Albums';
$adminPage = 'all-albums';
include_once 'includes/header.php';
?>

      <div class="page-heading">
        <div>
          <div class="eyebrow">Albums</div>
          <h1>All Albums</h1>
          <p>Albums organized by language.</p>
        </div>
        <a class="gold-btn" href="add-album.php">＋ Add Album</a>
      </div>

      <div class="admin-table-wrap">
        <div class="admin-table-header">
          <h2>All Albums</h2>
        </div>
        <table class="admin-table">
          <thead>
            <tr>
              <th>Albums Name</th>
              <th>Albums Image</th>
              <th>Artists Name</th>
              <th>Language</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
         <?php
while ($album = mysqli_fetch_assoc($result)) {
?>

<tr>

    <td>
        <?php echo $album['album_name']; ?>
    </td>

    <td>
        <?php if (!empty($album['image'])) { ?>
            <div class="avatar">
                <img src="<?php echo $album['image']; ?>" alt="">
            </div>
        <?php } ?>
    </td>

    <td>
        <?php echo $album['artist_name']; ?>
    </td>

    <td>
        <?php echo $album['language']; ?>
    </td>

    <td style="min-width: 140px; white-space: nowrap;">

        <a href="edit album.php?id=<?php echo $album['album_id']; ?>"
           class="text-btn"
           style="display: inline-block;">
            Edit
        </a>

        <a href="delete album.php?id=<?php echo $album['album_id']; ?>"
           class="text-btn danger"
           style="display: inline-block; margin-left: 8px;"
            onclick="return confirm('Are you sure you want to delete this album?')">
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
