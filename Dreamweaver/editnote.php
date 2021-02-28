<?php require_once('../Connections/Dreamweaver.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "a,u";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "edit_note")) {
  $updateSQL = sprintf("UPDATE notes SET title=%s, article=%s WHERE id=%s",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['article'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Dreamweaver, $Dreamweaver);
  $Result1 = mysql_query($updateSQL, $Dreamweaver) or die(mysql_error());
}

$colname_note = "-1";
if (isset($_GET['note'])) {
  $colname_note = $_GET['note'];
}
mysql_select_db($database_Dreamweaver, $Dreamweaver);
$query_note = sprintf("SELECT * FROM notes WHERE id = %s", GetSQLValueString($colname_note, "int"));
$note = mysql_query($query_note, $Dreamweaver) or die(mysql_error());
$row_note = mysql_fetch_assoc($note);
$totalRows_note = mysql_num_rows($note);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Note</title>
<body>
</head>
<h1>Привіт!</h1>
<b>Це міні-варіант мого сайта про подорожі</b>
<hr>
<a href="login.php">Вхід</a><br>
<a href="main.php">Головна</a><br>
<a href="addnew.php">Додати замітку</a><br>
<a href="users.php">Адміністратору</a><br>
<a href="logout.php">Вихід</a><br>
<hr>
<form action="<?php echo $editFormAction; ?>" method="POST" name="edit_note">
<input name="id" type="hidden" value="<?php echo $row_note['id']; ?>" /><br />
<input name="title" type="text" size="20" maxlength="100" value="<?php echo $row_note['id']; ?>" /><br />
<textarea name="article" cols="" rows=""><?php echo $row_note['article']; ?></textarea>
<br />
<input name="sumbit" type="submit" value="Редагувати" />
<input type="hidden" name="MM_update" value="edit_note" />
</form>
<hr>
<a href="comm.php?note=<?php echo $row_note['id']; ?>">Повернутись до замітки</a><br>
<body>
</body>
</html>
<?php
mysql_free_result($note);
?>
