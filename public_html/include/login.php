<?php require_once('../Connections/cnx_arica.php'); ?>
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

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc, soporte_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);
?>
<?php

if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl_cli'] = $_GET['accesscheck'];
}

if (isset($_POST['usuario_Txt'])) {
  $loginUsername=$_POST['usuario_Txt'];
  $password=$_POST['password_Txt'];
  $MM_fldUserAuthorization = "IdNivel_Usu";
 //$MM_redirectLoginSuccess = "index.php?login=$id_usu";
  $MM_redirectLoginFailed = "../index/index.php?error=1";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_cnx_arica, $cnx_arica);
  
  $LoginRS__query=sprintf("SELECT * FROM usuarios WHERE Estado_Usu = 1 AND Usern_Usu=%s AND Passw_Usu=%s AND (IdNivel_Usu=3 OR IdNivel_Usu=4 OR IdNivel_Usu=5 OR IdNivel_Usu=2)",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));   
  $LoginRS = mysql_query($LoginRS__query, $cnx_arica) or die(mysql_error());
  $loginUsers = mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
 
  if ($loginFoundUser) {
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
	
    //declare two session variables and assign them
	
    $_SESSION['MM_arica'] = $loginUsers['Usern_Usu'];
    $_SESSION['MM_UserGroup'] = $loginUsers['IdNivel_Usu'];
	$_SESSION['MM_IdUser'] = $loginUsers['Id_Usuario'];
	$_SESSION['MM_IdPersona'] = $loginUsers['IdPersona_Usu'];
	$_SESSION['MM_IdNivel'] = $loginUsers['IdNivel_Usu'];
	$id_usu=$_SESSION['MM_IdUser'];
	
	if($_SESSION['MM_IdNivel']==3 || $_SESSION['MM_IdNivel']==5 || $_SESSION['MM_IdNivel']==4 || $_SESSION['MM_IdNivel']==2)
	{
		$MM_redirectLoginSuccess = "../index/index.php?&id_per=". $_SESSION['MM_IdPersona']."&id_usu=".$_SESSION['MM_IdUser'];
		
	
		}
		
	
    if (isset($_SESSION['PrevUrl_cli']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl_cli'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
	
  }
  else {
	  
  header("Location: ". $MM_redirectLoginFailed );
	
  }
}
?>