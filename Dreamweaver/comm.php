<?php require_once('../Connections/Dreamweaver.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_notes = "-1";
if (isset($_GET['note'])) {
  $colname_notes = $_GET['note'];
}
mysql_select_db($database_Dreamweaver, $Dreamweaver);
$query_notes = sprintf("SELECT * FROM notes WHERE id = %s", GetSQLValueString($colname_notes, "int"));
$notes = mysql_query($query_notes, $Dreamweaver) or die(mysql_error());
$row_notes = mysql_fetch_assoc($notes);
$totalRows_notes = mysql_num_rows($notes);

$colname_comments = "-1";
if (isset($_GET['note'])) {
  $colname_comments = $_GET['note'];
}
mysql_select_db($database_Dreamweaver, $Dreamweaver);
$query_comments = sprintf("SELECT * FROM comments WHERE art_id = %s ORDER BY created DESC", GetSQLValueString($colname_comments, "int"));
$comments = mysql_query($query_comments, $Dreamweaver) or die(mysql_error());
$row_comments = mysql_fetch_assoc($comments);
$totalRows_comments = mysql_num_rows($comments);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Comments</title>
</head>
<body>
<h1>Привіт!</h1>
<b>Це міні-варіант мого сайта про подорожі</b>
<hr>
<a href="login.php">Вхід</a><br>
<a href="main.php">Головна</a><br>
<a href="addnew.php">Додати замітку</a><br>
<a href="users.php">Адміністратору</a><br>
<a href="logout.php">Вихід</a><br>
<hr>
<?php echo $row_notes['created']; ?><br>
<?php echo $row_notes['title']; ?><br>
<?php echo $row_notes['article']; ?><br>
<hr>
<a href="delnote.php?note=<?php echo $row_notes['id']?>">Видалити</a><br>
<a href="editnote.php?note=<?php echo $row_notes['id']?>">Редагувати</a><br>
<hr>
<?php do { ?>
  <?php echo $row_comments['created']; ?><br>
  <?php echo $row_comments['author']; ?><br>
  <?php echo $row_comments['comment']; ?><br>
  <?php } while ($row_comments = mysql_fetch_assoc($comments)); ?>
</body>
</html>
<?php
mysql_free_result($notes);
mysql_free_result($comments);
?>
