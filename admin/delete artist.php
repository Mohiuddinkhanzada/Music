<?php
include_once '../config.php';


$id = $_GET['id'];

$query = "DELETE FROM artists WHERE artist_id='$id'";

$result = mysqli_query($conn, $query);

if ($result) {
    header('location:all-artists.php');
    exit();
}



















































?>
