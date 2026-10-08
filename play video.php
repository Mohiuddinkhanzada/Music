<?php

include_once './config.php';

$pageTitle = 'Play Video — Audio Zone';
$activePage = 'videos';
$bodyClass = 'play-video-page';

include_once 'includes/header.php';

$id = $_GET['id'];

$query = "SELECT videos.*, albums.album_name, genre.genre_name, years.year_duration
          FROM videos
          JOIN albums ON videos.album_id = albums.album_id
          JOIN genre ON videos.genre_id = genre.genre_id
          JOIN years ON videos.year_id = years.year_id
          WHERE videos.video_id='$id'";

$result = mysqli_query($conn, $query);

$video = mysqli_fetch_assoc($result);

?>

<div class="page-heading">
    <div style="padding-left: 10px;">
        <div class="eyebrow">Video Player</div>
        <h1><?php echo htmlspecialchars($video['video_name']); ?></h1>
        <p>Watch and enjoy the video.</p>
    </div>

    <a class="ghost-btn" href="videos.php">← Back to All Videos</a>
</div>

<div class="video-player-card">

    <?php if (!empty($video['video_file'])) { ?>

      <div class="video-player-wrap" style="width:100%; height:420px;">
    <video
        controls
        preload="auto"
        poster="<?php echo htmlspecialchars($video['image'] ?? ''); ?>"
        style="display:block; width:100%; height:100%; object-fit:contain; object-position:center; background:#000; margin:0 auto;">

        <source src="./admin/uploads/videos/<?php echo htmlspecialchars($video['video_file']); ?>">
        Your browser does not support the video element.
    </video>
</div>

    <?php } else { ?>

        <div class="video-empty">
            No video file is available for this entry.
        </div>

    <?php } ?>

    <div class="video-player-meta">

        <div class="video-player-title">
            <h2><?php echo htmlspecialchars($video['video_name']); ?></h2>
            <span class="video-badge">Video</span>
        </div>

        <div class="video-details">
            <div class="video-detail-item">
                <span class="video-detail-label">Album</span>
                <span class="video-detail-value"><?php echo htmlspecialchars($video['album_name']); ?></span>
            </div>
            <div class="video-detail-item">
                <span class="video-detail-label">Genre</span>
                <span class="video-detail-value"><?php echo htmlspecialchars($video['genre_name']); ?></span>
            </div>
            <div class="video-detail-item">
                <span class="video-detail-label">Year</span>
                <span class="video-detail-value"><?php echo htmlspecialchars($video['year_duration']); ?></span>
            </div>
            <div class="video-detail-item">
                <span class="video-detail-label">Vedio Name</span>
                <span class="video-detail-value"><?php echo htmlspecialchars($video['video_file']); ?></span>
            </div>
        </div>

    </div>

</div>

<?php include_once 'includes/footer.php'; ?>
