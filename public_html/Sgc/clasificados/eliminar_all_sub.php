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
<?php
if ((isset($_GET['id_del'])) && ($_GET['id_del'] != "")) {
	
	mysql_select_db($database_cnx_arica, $cnx_arica);
	$query_rsSubcategoria = "SELECT * FROM subcategoria WHERE Id_Subcategoria = '".$_GET['id_del']."'";
	$rsSubcategoria = mysql_query($query_rsSubcategoria, $cnx_arica) or die(mysql_error());
	$row_rsSubcategoria = mysql_fetch_assoc($rsSubcategoria);
	$totalRows_rsSubcategoria= mysql_num_rows($rsSubcategoria);


	mysql_select_db($database_cnx_arica, $cnx_arica);
	$query_rsProducto = "SELECT * FROM productos WHERE IdSubcategoria_Pro = '".$_GET['id_del']."'";
	$rsProducto = mysql_query($query_rsProducto, $cnx_arica) or die(mysql_error());
	$row_rsProducto = mysql_fetch_assoc($rsProducto);
	$totalRows_rsProducto = mysql_num_rows($rsProducto);
	
if ($totalRows_rsProducto>0){
	do {
		
		$id_pro = $row_rsProducto['Id_Productos'];
	
		mysql_select_db($database_cnx_arica, $cnx_arica);
		$query_rsFoto = "SELECT * FROM galeria WHERE IdProducto_Gal = '$id_pro'";
		$rsFoto = mysql_query($query_rsFoto, $cnx_arica) or die(mysql_error());
		$row_rsFoto = mysql_fetch_assoc($rsFoto);
		$totalRows_rsFoto = mysql_num_rows($rsFoto);
		
		if ($totalRows_rsFoto > 0) {
			if (file_exists("../../productos/img/".$row_rsFoto['Archivo_Gal'])) {
				unlink("../../productos/img/".$row_rsFoto['Archivo_Gal']);
			}
		}
		
		$delete = "DELETE FROM galeria WHERE IdProducto_Gal = '$id_pro'";

		mysql_select_db($database_cnx_arica, $cnx_arica);
		mysql_query($delete, $cnx_arica) or die(mysql_error());	
		
		
		
		mysql_select_db($database_cnx_arica, $cnx_arica);
	$query_rsProductoColor = "SELECT * FROM productos_color WHERE IdProducto_PCol= ".$id_pro;
	$rsProductoColor = mysql_query($query_rsProductoColor, $cnx_arica) or die(mysql_error());
	$row_rsProductoColor = mysql_fetch_assoc($rsProductoColor);
	$totalRows_rsProductoColor = mysql_num_rows($rsProductoColor);
	
	
	if ($totalRows_rsProductoColor > 0) {
		
		
	              $deleteSQL2 = "DELETE FROM productos_color WHERE IdProducto_PCol = ".$id_pro;
	
					mysql_select_db($database_cnx_arica, $cnx_arica);
					mysql_query($deleteSQL2, $cnx_arica) or die(mysql_error());
	 
			
	}
		
		
	
	} while ($row_rsProducto = mysql_fetch_assoc($rsProducto));
}
				
	$deleteSQL2 = "DELETE FROM productos WHERE IdSubcategoria_Pro = '".$_GET['id_del']."'";
	
	mysql_select_db($database_cnx_arica, $cnx_arica);
	mysql_query($deleteSQL2, $cnx_arica) or die(mysql_error());
	
	$deleteSQL = "DELETE FROM subcategoria WHERE Id_Subcategoria = '".$_GET['id_del']."'";

	mysql_select_db($database_cnx_arica, $cnx_arica);
	mysql_query($deleteSQL, $cnx_arica) or die(mysql_error());		
	$id_cat= $_GET['id_cat'];
	header("Location: categorias.php?id_cat=".$id_cat);
}
?>