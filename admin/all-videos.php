<?php
include_once '../config.php';
$query = "SELECT videos.*, albums.album_name,albums.artist_name, genre.genre_name, years.year_duration
          FROM videos
          JOIN albums ON videos.album_id = albums.album_id
          JOIN genre ON videos.genre_id = genre.genre_id
          JOIN years ON videos.year_id = years.year_id";

$result = mysqli_query($conn, $query);
$pageTitle = 'All Videos';
$adminPage = 'all-videos';
include_once 'includes/header.php';
?>

      <div class="page-heading">
        <div>
          <div class="eyebrow">Videos</div>
          <h1>All Videos</h1>
          <p>Video content across all artists and languages.</p>
        </div>
        <a class="gold-btn" href="add-video.php">＋ Add Video</a>
      </div>

      <div class="admin-table-wrap">
        <div class="admin-table-header">
          <h2>All Videos</h2>
        </div>
        <table class="admin-table">
          <thead>
    <tr>
        <th>Video title</th>
        <th>Album</th>
        <th>Atrist</th>
        <th>Genre</th>
        <th>Year</th>
        <th>Image</th>
        <th>Video File</th>
        <th>Actions</th>
    </tr>
</thead>
          <tbody>
           <?php
while ($video = mysqli_fetch_assoc($result)) {
?>

<tr>

    <td>
        <strong><?php echo $video['video_name']; ?></strong>
    </td>

    <td>
        <?php echo $video['album_name']; ?>
    </td>

    <td>
        <?php echo $video['artist_name']; ?>
    </td>

    <td>
        <?php echo $video['genre_name']; ?>
    </td>

    <td>
        <?php echo $video['year_duration']; ?>
    </td>

    <td>
        <?php if (!empty($video['image'])) { ?>
            <div class="avatar">
                <img src="<?php echo $video['image']; ?>" alt="">
            </div>
        <?php } ?>
    </td>

    <td>
        <?php echo $video['video_file']; ?>
    </td>

    <td style="min-width: 140px; white-space: nowrap;">

    
    <a href="view video.php?id=<?php echo $video['video_id']; ?>"
       class="text-btn view-btn"
       style="display: inline-block;">
        View
    </a>

    <a href="edit video.php?id=<?php echo $video['video_id']; ?>"
       class="text-btn"
       style="display: inline-block;">
        Edit
    </a>

    <a href="delete video.php?id=<?php echo $video['video_id']; ?>"
       class="text-btn danger"
       style="display: inline-block; margin-left: 7px;"
        onclick="return confirm('Are you sure you want to delete this video?')">
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
