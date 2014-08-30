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
if ((isset($_GET['id_pro'])) && ($_GET['id_pro'] != "")) {
	
	$id_cat=$_GET['id_cat'];
	
	
	
  $porta = $_GET['portada'];
  if ($porta == 1) {
    $porta = 0;
} else {
  $porta = 1;
}
  $updateSQL = "UPDATE productos SET Portada_Pro = '$porta' WHERE Id_Productos  = ".$_GET['id_pro'];

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL, $cnx_arica) or die(mysql_error());





$id_pro= $_GET['id_pro'];
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsProductos = "SELECT * FROM productos where Id_Productos= $id_pro";
$rsProductos = mysql_query($query_rsProductos, $cnx_arica) or die(mysql_error());
$row_rsProductos = mysql_fetch_assoc($rsProductos);
}

?>

   <?  $portada= $row_rsProductos['Portada_Pro'] ;
				if ($portada==1)  { ?>
                
                    <input type="checkbox" checked name="portada" id="portada" value="1" onChange="cargar('portada.php?id_pro=<?php echo $row_rsProductos['Id_Productos']; ?>&portada=<?php echo $row_rsProductos['Portada_Pro']; ?>','portada<?php echo $row_rsProductos['Id_Productos'];?>')" >
                  
               <? } else  {?>
               
                <input type="checkbox" name="portada" id="portada" value="0" onChange="cargar('portada.php?id_pro=<?php echo $row_rsProductos['Id_Productos']; ?>&portada=<?php echo $row_rsProductos['Portada_Pro']; ?>','portada<?php echo $row_rsProductos['Id_Productos'];?>')">
                  
               <? }  ?>