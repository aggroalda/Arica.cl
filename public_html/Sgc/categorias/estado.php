<?php require_once('../../Connections/cnx_arica.php'); ?>
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

$MM_restrictGoTo = "../../error.php";
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
<?php
if ((isset($_GET['id_cat'])) && ($_GET['id_cat'] != "")) {
  $esta = $_GET['estado'];


  $updateSQL = "UPDATE categoria SET Estado_Cat = '$esta' WHERE Id_Categoria = ".$_GET['id_cat'];
  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL, $cnx_arica) or die(mysql_error());
  
  
  
  $id_cat= $_GET['id_cat'];
  $updateSQL2 = "UPDATE noticias,categoria SET Estado_Not= '$esta' WHERE categoria.Id_Categoria = '$id_cat'
                 AND noticias.IdCategoria_Not= categoria.Id_Categoria ";
  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL2, $cnx_arica) or die(mysql_error());
 
  
}
?>

<?
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoria = "SELECT * FROM categoria where Id_Categoria= '$id_cat'";
$rsCategoria = mysql_query($query_rsCategoria, $cnx_arica) or die(mysql_error());
$row_rsCategoria = mysql_fetch_assoc($rsCategoria);
$totalRows_rsCategoria= mysql_num_rows($rsCategoria);
 
?>



<option value="1" <?php if (!(strcmp(1, $row_rsCategoria['Estado_Cat']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
<option value="0" <?php if (!(strcmp(0, $row_rsCategoria['Estado_Cat']))) {echo "selected=\"selected\"";} ?>>Deshabilitado</option>