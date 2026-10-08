<?php
include_once '../config.php';

$id = (int) $_GET['id'];

$countQuery = "SELECT COUNT(*) AS total FROM reviews WHERE user_id='$id'";
$countRow = mysqli_fetch_assoc(mysqli_query($conn, $countQuery));

if ($countRow['total'] > 0) {
    header('location:all-users.php');
    exit();
}

$query = "DELETE FROM users WHERE user_id='$id'";

mysqli_query($conn, $query);

header('location:all-users.php');
exit();
?>

















?>
