<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
error_reporting(E_ALL ^ (E_DEPRECATED | E_WARNING));
$hostname_Dreamweaver = "localhost";
$database_Dreamweaver = "pis_blog";
$username_Dreamweaver = "admin";
$password_Dreamweaver = "admin";
$Dreamweaver = mysql_pconnect($hostname_Dreamweaver, $username_Dreamweaver, $password_Dreamweaver) or trigger_error(mysql_error(),E_USER_ERROR); 
?>