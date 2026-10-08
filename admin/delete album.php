<?php
include_once '../config.php';

$id = (int) $_GET['id'];

$musicCount = "SELECT COUNT(*) AS total FROM music WHERE album_id='$id'";
$musicRow = mysqli_fetch_assoc(mysqli_query($conn, $musicCount));

$videoCount = "SELECT COUNT(*) AS total FROM videos WHERE album_id='$id'";
$videoRow = mysqli_fetch_assoc(mysqli_query($conn, $videoCount));

if ($musicRow['total'] > 0 || $videoRow['total'] > 0) {
    header('location:all-albums.php');
    exit();
}

$query = "DELETE FROM albums WHERE album_id='$id'";

mysqli_query($conn, $query);

header('location:all-albums.php');
exit();
?>

