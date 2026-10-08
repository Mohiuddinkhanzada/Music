<?php

include_once './config.php';

$pageTitle = 'Play Music — Audio Zone';
$activePage = 'music';
$bodyClass = 'play-music-page';

include_once 'includes/header.php';

$id = $_GET['id'];

$query = "SELECT music.*, albums.album_name, genre.genre_name, years.year_duration
          FROM music
          JOIN albums ON music.album_id = albums.album_id
          JOIN genre ON music.genre_id = genre.genre_id
          JOIN years ON music.year_id = years.year_id
          WHERE music.music_id='$id'";

$result = mysqli_query($conn, $query);

$music = mysqli_fetch_assoc($result);

?>

<div class="page-heading">
    <div style="padding-left: 10px;">
        <div class="eyebrow">Music Player</div>
        <h1><?php echo htmlspecialchars($music['music_name']); ?></h1>
        <p>Listen and enjoy the track.</p>
    </div>

    <a class="ghost-btn" href="music.php">← Back to All Music</a>
</div>

<div class="music-player-card">

    <div class="music-player-top" style="align-items: flex-start; padding: 34px 28px 30px;">

        <?php if (!empty($music['image'])) { ?>
            <div class="music-cover-wrap">
                <img src="<?php echo htmlspecialchars($music['image']); ?>"
                     alt="<?php echo htmlspecialchars($music['music_name']); ?>">
            </div>
        <?php } ?>

        <div class="music-player-info">

            <div class="music-player-title" style="display: block; margin-bottom: 28px;">
                <span class="music-badge" style="display: inline-block;">Music</span>
                <h2 style="margin-top: 12px;"><?php echo htmlspecialchars($music['music_name']); ?></h2>
            </div>

            <?php if (!empty($music['music_file'])) { ?>

                <div class="music-audio-wrap" style="background: transparent; border: 0; padding: 0; border-radius: 0; margin-top: 64px;">
                    <audio controls preload="auto" style="width: 100%;">
                        <source src="./admin/uploads/music/<?php echo htmlspecialchars($music['music_file']); ?>">
                        Your browser does not support the audio element.
                    </audio>
                </div>

            <?php } else { ?>

                <div class="music-empty">
                    No audio file is available for this entry.
                </div>

            <?php } ?>

        </div>

    </div>

    <div class="music-details" style="padding-bottom: 36px;">
        <div class="music-detail-item">
            <span class="music-detail-label">Album</span>
            <span class="music-detail-value"><?php echo htmlspecialchars($music['album_name']); ?></span>
        </div>
        <div class="music-detail-item">
            <span class="music-detail-label">Genre</span>
            <span class="music-detail-value"><?php echo htmlspecialchars($music['genre_name']); ?></span>
        </div>
        <div class="music-detail-item">
            <span class="music-detail-label">Year</span>
            <span class="music-detail-value"><?php echo htmlspecialchars($music['year_duration']); ?></span>
        </div>
        <div class="music-detail-item">
            <span class="music-detail-label">Music Name</span>
            <span class="music-detail-value"><?php echo htmlspecialchars($music['music_file']); ?></span>
        </div>
    </div>

</div>

<?php include_once 'includes/footer.php'; ?>
