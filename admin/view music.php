<?php
include_once '../config.php';

$id = $_GET['id'];

$query = "SELECT music.*, albums.album_name, genre.genre_name, years.year_duration
          FROM music
          JOIN albums ON music.album_id = albums.album_id
          JOIN genre ON music.genre_id = genre.genre_id
          JOIN years ON music.year_id = years.year_id
          WHERE music.music_id='$id'";

$result = mysqli_query($conn, $query);

$music = mysqli_fetch_assoc($result);

$pageTitle = 'View Music';
$adminPage = 'all-music';
include_once 'includes/header.php';
?>

<div class="page-heading">
    <div>
        <div class="eyebrow">Music</div>
        <h1><?php echo htmlspecialchars($music['music_name']); ?></h1>
        <p>View music details and play the track.</p>
    </div>

    <a class="ghost-btn" href="all-music.php">← Back to All Music</a>
</div>

<div class="admin-form-card">

    <div style="display: flex; gap: 24px; flex-wrap: wrap; align-items: flex-start;">

        <?php if (!empty($music['image'])) { ?>
            <div style="width: 220px; flex-shrink: 0;">
                <img src="<?php echo htmlspecialchars($music['image']); ?>"
                     alt=""
                     style="width: 100%; border-radius: 12px; display: block;">
            </div>
        <?php } ?>

        <div style="flex: 1; min-width: 260px;">

            <h2>Track Details</h2>

            <table class="admin-table" style="margin-top: 16px;">

                <tbody>
                    <tr>
                        <th style="width: 160px; text-align: left;">Track Title</th>
                        <td><?php echo htmlspecialchars($music['music_name']); ?></td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Album</th>
                        <td><?php echo htmlspecialchars($music['album_name']); ?></td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Genre</th>
                        <td><?php echo htmlspecialchars($music['genre_name']); ?></td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Year</th>
                        <td><?php echo htmlspecialchars($music['year_duration']); ?></td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Music File</th>
                        <td><?php echo htmlspecialchars($music['music_file']); ?></td>
                    </tr>
                </tbody>

            </table>

            <?php if (!empty($music['music_file'])) { ?>

                <div style="margin-top: 24px;">
                    <audio controls preload="auto" style="width: 100%;">
                        <source src="uploads/music/<?php echo htmlspecialchars($music['music_file']); ?>">
                        Your browser does not support the audio element.
                    </audio>
                </div>

            <?php } ?>

            <div class="form-actions" style="margin-top: 24px;">

                <a class="gold-btn"
                   href="edit music.php?id=<?php echo $music['music_id']; ?>">
                    Edit Music
                </a>

                <a class="ghost-btn"
                   href="all-music.php">
                    Cancel
                </a>

            </div>

        </div>

    </div>

</div>

<?php include_once 'includes/footer.php'; ?>
