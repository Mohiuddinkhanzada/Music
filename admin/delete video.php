<?php
include_once '../config.php';

$id = $_GET['id'];

$query = "SELECT * FROM videos WHERE video_id='$id'";
$result = mysqli_query($conn, $query);

$video = mysqli_fetch_assoc($result);

if (!empty($video['video_file'])) {

    $file = 'uploads/videos/' . $video['video_file'];

    if (file_exists($file)) {
        unlink($file);
    }
}

$query = "DELETE FROM videos WHERE video_id='$id'";

$result = mysqli_query($conn, $query);

if ($result) {
    header('location:all-videos.php');
    exit();
}
?>
