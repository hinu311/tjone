<?php
include('config.php');
error_reporting(0);
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysqli_select_db( $conn,DB_DATABASE);
?>