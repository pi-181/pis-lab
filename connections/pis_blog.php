<?php
$localhost = "localhost";
$db = "pis_blog";
$user = "admin";
$password = "admin";

//$mysqli = mysqli_init();
$link = mysqli_connect($localhost, $user, $password);
//or trigger_error(mysqli_error($mysqli),E_USER_ERROR);

//mysqli_query($link, "SET NAMES cp1251;") or die(mysqli_error($link));
//mysqli_query($link, "SET CHARACTER SET cp1251;") or die(mysqli_error($link));
