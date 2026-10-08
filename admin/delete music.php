<?php
include_once '../config.php';

$id = $_GET['id'];

$query = "SELECT * FROM music WHERE music_id='$id'";
$result = mysqli_query($conn, $query);

$music = mysqli_fetch_assoc($result);

if (!empty($music['music_file'])) {

    $file = 'uploads/music/' . $music['music_file'];

    if (file_exists($file)) {
        unlink($file);
    }
}

$query = "DELETE FROM music WHERE music_id='$id'";

$result = mysqli_query($conn, $query);

if ($result) {
    header('location:all-music.php');
    exit();
}
?>5
