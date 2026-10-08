<?php
include_once '../config.php';

$id = (int) $_GET['id'];

$countQuery = "SELECT COUNT(*) AS total FROM music WHERE genre_id='$id'";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);

$videoCount = "SELECT COUNT(*) AS total FROM videos WHERE genre_id='$id'";
$videoRow = mysqli_fetch_assoc(mysqli_query($conn, $videoCount));

if ($countRow['total'] > 0 || $videoRow['total'] > 0) {
    header('location:all-genres.php');
    exit();
}

$query = "DELETE FROM genre WHERE genre_id='$id'";

mysqli_query($conn, $query);

header('location:all-genres.php');
exit();
?>
