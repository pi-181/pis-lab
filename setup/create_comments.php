<?php
$db_user = "admin";
$link = mysqli_connect ("localhost", $db_user, $db_user, "pis_blog");
echo ($link ? "З'єднання з сервером встановлено" : "Немає з'єднання з сервером") . "<br>";

$db_name = "pis_blog";
$select = mysqli_select_db($link, $db_name);
echo ($select ? "База даних обрана" : "База даних не обрана") . "<br>";

$query = "CREATE TABLE `comments` ( `id` SMALLINT NOT NULL AUTO_INCREMENT , `created` DATE NOT NULL , `author` VARCHAR(20) NOT NULL , `comment` VARCHAR(256) NOT NULL , `art_id` INT NOT NULL , PRIMARY KEY (`id`))";
$result = mysqli_query($link, $query);
echo ($result ? "Таблиця comments успішно створена" : "Не вдалось створити таблицю comments") . "<br>";

$query = "ALTER TABLE `comments` ADD FOREIGN KEY (`art_id`) REFERENCES `notes`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT";
$result = mysqli_query($link, $query);
echo ($result ? "Обмеження зовнішього ключа успішно створені" : "Не вдалось створити обжмеження") . "<br>";