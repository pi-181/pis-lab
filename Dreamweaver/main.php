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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_notes = 10;
$pageNum_notes = 0;
if (isset($_GET['pageNum_notes'])) {
  $pageNum_notes = $_GET['pageNum_notes'];
}
$startRow_notes = $pageNum_notes * $maxRows_notes;

mysql_select_db($database_Dreamweaver, $Dreamweaver);
$query_notes = "SELECT * FROM notes ORDER BY created DESC";
$query_limit_notes = sprintf("%s LIMIT %d, %d", $query_notes, $startRow_notes, $maxRows_notes);
$notes = mysql_query($query_limit_notes, $Dreamweaver) or die(mysql_error());
$row_notes = mysql_fetch_assoc($notes);

if (isset($_GET['totalRows_notes'])) {
  $totalRows_notes = $_GET['totalRows_notes'];
} else {
  $all_notes = mysql_query($query_notes);
  $totalRows_notes = mysql_num_rows($all_notes);
}
$totalPages_notes = ceil($totalRows_notes/$maxRows_notes)-1;

$queryString_notes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_notes") == false && 
        stristr($param, "totalRows_notes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_notes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_notes = sprintf("&totalRows_notes=%d%s", $totalRows_notes, $queryString_notes);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Main Page</title>
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
<?php do { ?>
  <?php echo $row_notes['id']; ?><br>
  <a href="comm.php?note=<?php echo $row_notes['id'] ?>"><?php echo $row_notes['created']; ?></a><br>
  <?php echo $row_notes['title']; ?><br>
  <?php echo $row_notes['article']; ?><br>
  <?php } while ($row_notes = mysql_fetch_assoc($notes)); ?>
  <a href="<?php printf("%s?pageNum_notes=%d%s", $currentPage, max(0, $pageNum_notes - 1), $queryString_notes); ?>">&lt; Назад</a> | <a href="<?php printf("%s?pageNum_notes=%d%s", $currentPage, min($totalPages_notes, $pageNum_notes + 1), $queryString_notes); ?>">Вперед &gt;</a>
  <br>
Замітки з <?php echo ($startRow_notes + 1) ?> по <?php echo min($startRow_notes + $maxRows_notes, $totalRows_notes) ?>, всього <?php echo $totalRows_notes ?>
</body>
</html>
<?php
mysql_free_result($notes);
?>
