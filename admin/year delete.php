<?php
include_once '../config.php';

$id = (int) $_GET['id'];

$musicCount = "SELECT COUNT(*) AS total FROM music WHERE year_id='$id'";
$musicRow = mysqli_fetch_assoc(mysqli_query($conn, $musicCount));

$videoCount = "SELECT COUNT(*) AS total FROM videos WHERE year_id='$id'";
$videoRow = mysqli_fetch_assoc(mysqli_query($conn, $videoCount));

if ($musicRow['total'] > 0 || $videoRow['total'] > 0) {
    header('location:all-years.php');
    exit();
}

$query = "DELETE FROM years WHERE year_id='$id'";

mysqli_query($conn, $query);

header('location:all-years.php');
exit();
?>
