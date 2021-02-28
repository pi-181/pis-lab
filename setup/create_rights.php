<?php
$db_user = "admin";
$link = mysqli_connect ("localhost", $db_user, $db_user, "pis_blog");
echo ($link ? "З'єднання з сервером встановлено" : "Немає з'єднання з сервером") . "<br>";

$db_name = "pis_blog";
$select = mysqli_select_db($link, $db_name);
echo ($select ? "База даних обрана" : "База даних не обрана") . "<br>";

$query = 'create table privileges ('
    .'id int auto_increment,'
    .'name varchar(20) unique not null,'
    .'password varchar(20) not null,'
    .'rights varchar(1) not null,'
    .'constraint privileges_pk primary key (id));';
$result = mysqli_query($link, $query);
echo ($result ? "Таблиця privileges успішно створена" : "Не вдалось створити таблицю privileges") . "<br>";

$query = "INSERT INTO privileges(name, password, rights) VALUES ('admin', 'admin', 'a');";
$result = mysqli_query($link, $query);
echo ($result ? "Привілегія admin успішно створена" : "Не вдалось створити привілегію admin") . "<br>";

