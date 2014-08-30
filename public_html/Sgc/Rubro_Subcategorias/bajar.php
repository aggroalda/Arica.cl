<?php require_once('../../Connections/cnx_arica.php'); ?>
<?
ob_start();
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
} ?>





<?php
session_start();
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Userjapan set equal to their username. 
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
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../0_SOURCE/SGC_INTERNET/error.php";
if (!((isset($_SESSION['MM_arica'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_arica'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>









<?
if ((isset($_GET['id_cat'])) && ($_GET['id_cat'] != "")) {
// bajar orden del menu
	$orden= $_GET['orden'];
    $id_cat = $_GET['id_cat'];
    $ordenSubir = $_GET['orden'] - 1;  
    $ordenBajar = $_GET['orden'] + 1;  

	        mysql_select_db($database_cnx_arica, $cnx_arica);
			$query_rscategoria_clasificado = "SELECT * FROM empresa_rubro_sub WHERE Rubro_Sub_Orden= ".$ordenBajar;
			$rscategoria_clasificado = mysql_query($query_rscategoria_clasificado, $cnx_arica) or die(mysql_error());
			$row_rscategoria_clasificado = mysql_fetch_assoc($rscategoria_clasificado);
			$totalRows_rscategoria_clasificado = mysql_num_rows($rscategoria_clasificado);
			
			$total = $totalRows_rscategoria_clasificado;
				$id_antiguo = $row_rscategoria_clasificado['Rubro_Sub_Id'];
			


	
    mysql_select_db($database_cnx_arica, $cnx_arica);
     mysql_query("UPDATE empresa_rubro_sub SET Rubro_Sub_Orden = $ordenBajar
                             WHERE Rubro_Sub_Id = $id_cat", $cnx_arica)
                             or die(mysql_error());
	mysql_select_db($database_cnx_arica, $cnx_arica);
     mysql_query("UPDATE empresa_rubro_sub SET Rubro_Sub_Orden = $orden
                             WHERE Rubro_Sub_Id = $id_antiguo", $cnx_arica)
                             or die(mysql_error());
		
	header('Location: index.php');
	
}
	?>
<?
ob_end_flush();
?>