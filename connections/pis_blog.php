<?php
$localhost = "localhost";
$db = "pis_blog";
$user = "admin";
$password = "admin";

$connection = mysqli_connect($localhost, $user, $password, $db);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}