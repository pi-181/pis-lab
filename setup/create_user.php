<?php
$link = mysqli_connect ("localhost", "root", "root");
echo ($link ? "З'єднання з сервером встановлено" : "Немає з'єднання з сервером") . "<br>";

$db_user = "admin";
$query = "GRANT ALL PRIVILEGES ON *.* TO '$db_user'@'localhost' IDENTIFIED BY '$db_user' WITH GRANT OPTION";
$result = mysqli_query($link, $query);
echo ($result ? "Користувач $db_user успішно створений" : "Користувач не створений") . "<br>";