<?php
$db_user = "admin";
$link = mysqli_connect ("localhost", $db_user, $db_user, "pis_blog");
echo ($link ? "З'єднання з сервером встановлено" : "Немає з'єднання з сервером") . "<br>";

$db_name = "pis_blog";
$select = mysqli_select_db($link, $db_name);
echo ($select ? "База даних обрана" : "База даних не обрана") . "<br>";

$query = "CREATE TABLE notes (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), created DATE, title VARCHAR (100), article TEXT (20000))";
$result = mysqli_query($link, $query);
echo ($result ? "Таблиця notes успішно створена" : "Не вдалось створити таблицю notes") . "<br>";