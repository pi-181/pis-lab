<?php
$link = mysqli_connect ("localhost", "root", "root");
echo ($link ? "З'єднання з сервером встановлено" : "Немає з'єднання з сервером") . "<br>";

$db_name = "pis_blog";
$query = "CREATE DATABASE $db_name";
$create_db = mysqli_query($link, $query);
echo ($create_db ? "База даних $db_name успішно створена" : "База не створена") . "<br>";
