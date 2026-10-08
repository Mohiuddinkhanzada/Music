<?php
include_once '../config.php';

$query = "SELECT music.*, albums.album_name,albums.artist_name, genre.genre_name, years.year_duration
          FROM music
          JOIN albums ON music.album_id = albums.album_id
          JOIN genre ON music.genre_id = genre.genre_id
          JOIN years ON music.year_id = years.year_id";

$result = mysqli_query($conn, $query);

$pageTitle = 'All Music';
$adminPage = 'all-music';
include_once 'includes/header.php';
?>

<div class="page-heading">
    <div>
        <div class="eyebrow">Music</div>
        <h1>All Music</h1>
        <p>Complete music library across all artists and languages.</p>
    </div>

    <a class="gold-btn" href="add-music.php">＋ Add Music</a>
</div>

<div class="admin-table-wrap">

    <div class="admin-table-header">
        <h2>All Music</h2>
    </div>

    <table class="admin-table">

        <thead>
            <tr>
                <th>Track</th>
                <th>Album</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>Year</th>
                <th>Image</th>
                <th>Music File</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

<?php
while ($music = mysqli_fetch_assoc($result)) {
?>

<tr>

    <td>
        <strong><?php echo $music['music_name']; ?></strong>
    </td>

    <td>
        <?php echo $music['album_name']; ?>
    </td>
    <td>
        <?php echo $music['artist_name']; ?>
    </td>

    <td>
        <?php echo $music['genre_name']; ?>
    </td>

    <td>
        <?php echo $music['year_duration']; ?>
    </td>

    <td>
        <?php if (!empty($music['image'])) { ?>
            <div class="avatar">
                <img src="<?php echo $music['image']; ?>" alt="">
            </div>
        <?php } ?>
    </td>

    <td>
        <?php echo $music['music_file']; ?>
    </td>

    <td style="min-width: 140px; white-space: nowrap;">

     <a href="view music.php?id=<?php echo $music['music_id']; ?>"
       class="text-btn view-btn"
       style="display: inline-block;">
        View
    </a>

          <a href="edit music.php?id=<?php echo $music['music_id']; ?>"
       class="text-btn"
       style="display: inline-block;">
        Edit
    </a>

    <a href="delete music.php?id=<?php echo $music['music_id']; ?>"
       class="text-btn danger"
       style="display: inline-block; margin-left: 7px;"
        onclick="return confirm('Are you sure you want to delete this music?')">
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
