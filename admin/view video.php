<?php
include_once '../config.php';

$id = $_GET['id'];

$query = "SELECT videos.*, albums.album_name, genre.genre_name, years.year_duration
          FROM videos
          JOIN albums ON videos.album_id = albums.album_id
          JOIN genre ON videos.genre_id = genre.genre_id
          JOIN years ON videos.year_id = years.year_id
          WHERE videos.video_id='$id'";

$result = mysqli_query($conn, $query);

$video = mysqli_fetch_assoc($result);

$pageTitle = 'View Video';
$adminPage = 'all-videos';
include_once 'includes/header.php';
?>

<div class="page-heading">
    <div>
        <div class="eyebrow">Videos</div>
        <h1><?php echo htmlspecialchars($video['video_name']); ?></h1>
        <p>View video details and play the video.</p>
    </div>

    <a class="ghost-btn" href="all-videos.php">
        ← Back to All Videos
    </a>
</div>

<div class="admin-form-card">

    <div style="display: flex; gap: 24px; flex-wrap: wrap; align-items: flex-start;">

        <?php if (!empty($video['image'])) { ?>

            <div style="width: 220px; flex-shrink: 0;">

                <img src="<?php echo htmlspecialchars($video['image']); ?>"
                     alt=""
                     style="width: 100%; border-radius: 12px; display: block;">

            </div>

        <?php } ?>


        <div style="flex: 1; min-width: 260px;">

            <h2>Video Details</h2>

            <table class="admin-table" style="margin-top: 16px;">

                <tbody>

                    <tr>
                        <th style="width: 160px; text-align: left;">
                            Video Title
                        </th>

                        <td>
                            <?php echo htmlspecialchars($video['video_name']); ?>
                        </td>
                    </tr>


                    <tr>

                        <th style="text-align: left;">
                            Album
                        </th>

                        <td>
                            <?php echo htmlspecialchars($video['album_name']); ?>
                        </td>

                    </tr>


                    <tr>

                        <th style="text-align: left;">
                            Genre
                        </th>

                        <td>
                            <?php echo htmlspecialchars($video['genre_name']); ?>
                        </td>

                    </tr>


                    <tr>

                        <th style="text-align: left;">
                            Year
                        </th>

                        <td>
                            <?php echo htmlspecialchars($video['year_duration']); ?>
                        </td>

                    </tr>


                    <tr>

                        <th style="text-align: left;">
                            Video File
                        </th>

                        <td>
                            <?php echo htmlspecialchars($video['video_file']); ?>
                        </td>

                    </tr>

                </tbody>

            </table>


            <?php if (!empty($video['video_file'])) { ?>

                <div style="margin-top: 24px;">

                    <video controls preload="metadata"
                           style="width: 100%; border-radius: 12px; display: block;">

                        <source src="uploads/videos/<?php echo htmlspecialchars($video['video_file']); ?>">

                        Your browser does not support the video element.

                    </video>

                </div>

            <?php } ?>


            <div class="form-actions" style="margin-top: 24px;">

                <a class="gold-btn"
                   href="edit video.php?id=<?php echo $video['video_id']; ?>">

                    Edit Video

                </a>


                <a class="ghost-btn"
                   href="all-videos.php">

                    Cancel

                </a>

            </div>

        </div>

    </div>

</div>

<?php include_once 'includes/footer.php'; ?>
