<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php
session_start();
$nivel= $_SESSION['MM_IdNivel'];
$usuario=$_SESSION['MM_IdUser'];

if (!isset($_SESSION)) {
  session_start();

}
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_arica'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_arica']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../salir.php?nivel=$nivel";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_arica set equal to their username. 
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

$MM_restrictGoTo = "../index.php?error=2";
if (!((isset($_SESSION['MM_arica'])) && (isAuthorized("5,4,2",$MM_authorizedUsers, $_SESSION['MM_arica'], $_SESSION['MM_UserGroup'])))) {   
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

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$maxRows_rsBanner = 20;
$pageNum_rsBanner = 0;
if (isset($_GET['pageNum_rsBanner'])) {
  $pageNum_rsBanner = $_GET['pageNum_rsBanner'];
}
$startRow_rsBanner = $pageNum_rsBanner * $maxRows_rsBanner;

if($_GET['cat_ban']){
$cat_ban=$_GET['cat_ban'];
$query_rsBanner = "SELECT * FROM banners WHERE Ubicacion_Ban=$cat_ban ORDER BY Id_Banner DESC";
}
else{
$query_rsBanner = "SELECT * FROM banners ORDER BY Id_Banner DESC";
}

mysql_select_db($database_cnx_arica, $cnx_arica);

$query_limit_rsBanner = sprintf("%s LIMIT %d, %d", $query_rsBanner, $startRow_rsBanner, $maxRows_rsBanner);
$rsBanner = mysql_query($query_limit_rsBanner, $cnx_arica) or die(mysql_error());
$row_rsBanner = mysql_fetch_assoc($rsBanner);

if (isset($_GET['totalRows_rsBanner'])) {
  $totalRows_rsBanner = $_GET['totalRows_rsBanner'];
} else {
  $all_rsBanner = mysql_query($query_rsBanner);
  $totalRows_rsBanner = mysql_num_rows($all_rsBanner);
}
$totalPages_rsBanner = ceil($totalRows_rsBanner/$maxRows_rsBanner)-1;

$queryString_rsBanner = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsBanner") == false && 
        stristr($param, "totalRows_rsBanner") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsBanner = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsBanner = sprintf("&totalRows_rsBanner=%d%s", $totalRows_rsBanner, $queryString_rsBanner);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
</head>
<body>

<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes" id="tbnoticia">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
     	<strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../banners/index.php">M&oacute;dulo de Banners</a> / <a href="#" id="guia_titulos">Listado</a></p></strong>
      <p class="titles">&raquo; M&oacute;dulo de Banners / Listado</p>
    </blockquote>  
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle">

  <? if ($totalRows_rsBanner>0) { ?>
  <table width="100%" align="center" class="bordes2" >
          <tr align="center" bgcolor="#660000" class="blanco11">
            <td width="34%" bgcolor="#003366" class="blanco12">T&iacute;tulo del Banner</td>
            <td width="14%" bgcolor="#003366" class="blanco12">Ubicaci&oacute;n</td>
            <td width="13%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Estado</strong></td>
            <td width="12%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Editar</strong></td>
            <td width="12%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Eliminar</strong></td>
          </tr>
            <tbody class="tabla">          
          <?php do { ?>
            <tr class="odd">
                <td class="fuente">-&nbsp;<a href="ver.php?id_ban=<?php echo $row_rsBanner['Id_Banner']; ?>" class="fuente"> <strong><?php echo utf8_encode($row_rsBanner['Titulo_Ban']); ?></strong></a></td>
                <td class="fuente"><?php $ubica = $row_rsBanner['Ubicacion_Ban'];
				if ($ubica == 1) { 
				?> <a id="subrayado_cat_not" href="javascript:cargar('../banners/index.php?cat_ban=<? echo $row_rsBanner['Ubicacion_Ban']?>','tbnoticia')">Derecha</a><? 
				}
				if ($ubica == 2) { 
					?> <a id="subrayado_cat_not" href="javascript:cargar('../banners/index.php?cat_ban=<? echo $row_rsBanner['Ubicacion_Ban']?>','tbnoticia')">Izquierda al Medio</a><? 
				}
				if ($ubica == 3) { 
					?> <a id="subrayado_cat_not" href="javascript:cargar('../banners/index.php?cat_ban=<? echo $row_rsBanner['Ubicacion_Ban']?>','tbnoticia')">Izquierda Abajo</a><? 
				
				}
				?></td>
                <td align="center"><select name="estado<?php echo $row_rsBanner['Id_Banner'];?>" class="fuente" id="estado<?php echo $row_rsBanner['Id_Banner']; ?>" onChange="cargar('estado.php?id_ban=<?php echo $row_rsBanner['Id_Banner']; ?>&estado='+this.value,'estado<?php echo $row_rsBanner['Id_Banner']; ?>')">
                  <option value="1" <?php if (!(strcmp(1, $row_rsBanner['Estado_Ban']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
                  <option value="0" <?php if (!(strcmp(0, $row_rsBanner['Estado_Ban']))) {echo "selected=\"selected\"";} ?>>Deshabilitado</option>
              </select>
                 </td>
              <td align="center"><a href="editar.php?id_ban=<?php echo $row_rsBanner['Id_Banner']; ?>"><img src="../img/icon_edit.png" width="20" height="20" border="0"></a></td>
              <td align="center"><a href="javascript:preguntarbanner('<?php echo $row_rsBanner['Id_Banner']; ?>','<?php echo utf8_encode($row_rsBanner['Titulo_Ban']); ?>')"><img src="../img/icon_del.png" width="19" height="20" border="0"></a></td>
            </tr>
            <?php } while ($row_rsBanner = mysql_fetch_assoc($rsBanner)); ?>
              </tbody>
        </table>      
        
           <? } ?>    
          <blockquote>
            <table border="0">
              <tr>
              
                <? if ($totalRows_rsBanner>=1){?>
                <td colspan="4" class="fuente">
Banners del <?php echo ($startRow_rsBanner + 1) ?> al <?php echo min($startRow_rsBanner + $maxRows_rsBanner, $totalRows_rsBanner) ?> de <?php echo $totalRows_rsBanner ?> en total</td>
             
             <? } else {?> <td colspan="4" class="fuente"> No hay Banners Registrados </td> <? } ?>
                </tr>
              <tr>
                <td align="center"><?php if ($pageNum_rsBanner > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsBanner=%d%s", $currentPage, 0, $queryString_rsBanner); ?>"><img src="../img/First.gif" border="0"></a>
                  <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_rsBanner > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsBanner=%d%s", $currentPage, max(0, $pageNum_rsBanner - 1), $queryString_rsBanner); ?>"><img src="../img/Previous.gif" border="0"></a>
                  <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_rsBanner < $totalPages_rsBanner) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsBanner=%d%s", $currentPage, min($totalPages_rsBanner, $pageNum_rsBanner + 1), $queryString_rsBanner); ?>"><img src="../img/Next.gif" border="0"></a>
                  <?php } // Show if not last page ?></td>
                <td align="center"><?php if ($pageNum_rsBanner < $totalPages_rsBanner) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsBanner=%d%s", $currentPage, $totalPages_rsBanner, $queryString_rsBanner); ?>"><img src="../img/Last.gif" border="0"></a>
                  <?php } // Show if not last page ?></td>
              </tr>
          </table>
              <strong><p><a id="guia_titulos" href="../banners/index.php">M&oacute;dulo de Banners Lista Original</a></p></strong>
            <p><a href="agregar.php" class="fuente linksRojo"><strong>[+] Agregar Nuevo Banner</strong></a></p>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table></td>
  </tr>
  <? include("../option/footer.php"); ?>
</table>
</body>

</html>
<?php
mysql_free_result($rsOptions);

mysql_free_result($rsBanner);
?>