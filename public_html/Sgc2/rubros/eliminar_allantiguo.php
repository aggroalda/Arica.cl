<?php require_once('../../0_SOURCE/Connections/cnx_arica.php'); ?>
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
if ((isset($_POST['id_del'])) && ($_POST['id_del'] != "")) {
	


	
	mysql_select_db($database_cnx_arica, $cnx_arica);
	$query_rsProducto = "SELECT * FROM clasificados, categoria_clasificado WHERE clasificados.IdCategoriaCla_Cla= '".$_POST['id_del']."' AND categoria_clasificado.Id_CategoriaClasificado = '".$_POST['id_del']."'";
	$rsProducto = mysql_query($query_rsProducto, $cnx_arica) or die(mysql_error());
	$row_rsProducto = mysql_fetch_assoc($rsProducto);
	$totalRows_rsProducto = mysql_num_rows($rsProducto);
	
	
		$id_del = $_POST_['id_del'];
		
		
		if($totalRows_rsProducto>0){
		$delete = "DELETE FROM clasificados WHERE IdCategoriaCla_Cla= '$id_del'";
		mysql_select_db($database_cnx_arica, $cnx_arica);
		mysql_query($delete, $cnx_arica) or die(mysql_error());	
}


			
$deleteSQL = "DELETE FROM categoria_clasificado WHERE Id_CategoriaClasificado = '".$_POST['id_del']."'";
	mysql_select_db($database_cnx_arica, $cnx_arica);
	mysql_query($deleteSQL, $cnx_arica) or die(mysql_error());	
	
	   $id_borrar= $_POST['orden'];
	   $query_rsCategorias = "UPDATE categoria_clasificado SET Orden_CatCla= Orden_CatCla-1 where Orden_CatCla>$id_borrar";
		mysql_select_db($database_cnx_arica, $cnx_arica);  
		mysql_query($query_rsCategorias, $cnx_arica) or die(mysql_error());

	
//	header("Location: index.php");
}
?>




<script language="javascript" type="text/javascript">window.top.window.cargar("listado.php","tabla");</script> 