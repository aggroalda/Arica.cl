<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php
//initialize the session
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
	
  $logoutGoTo = "../index.php";
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
$MM_authorizedUsers = "";
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

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$colname_rsBanner = "-1";
if (isset($_GET['id_ban'])) {
  $colname_rsBanner = $_GET['id_ban'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsBanner = sprintf("SELECT * FROM banners WHERE Id_Banner = %s", GetSQLValueString($colname_rsBanner, "int"));
$rsBanner = mysql_query($query_rsBanner, $cnx_arica) or die(mysql_error());
$row_rsBanner = mysql_fetch_assoc($rsBanner);
$totalRows_rsBanner = mysql_num_rows($rsBanner);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
    	<strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../banners/index.php">M&oacute;dulo de Banners</a> / <a href="#" id="guia_titulos">Detalles</a></p></strong>
      <p class="titles">&raquo; M&oacute;dulo de Banners / Detalles</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><blockquote>
          <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
            <td width="11" height="11" id="cdo_top_izq"></td>
                  <td width="849" height="11" id="cdo_top_fnd"></td>
                  <td width="11" height="11" id="cdo_top_der"></td>
            </tr>
            <tr>
              <td background="../img/cdo_izq_fnd.jpg"></td>
              <td bgcolor="#EBEBEB"><table width="100%">
                <tr>
                  <td width="37%" align="right" class="fuente"><strong>Ubicaci&oacute;n:</strong></td>
                  <td width="63%" class="fuente"><?php $ubica = $row_rsBanner['Ubicacion_Ban'];
				if ($ubica == 1) { 
				echo "Arriba ";
				}
				if ($ubica == 2) { 
				echo "Izquierda Medio";
				}
				if ($ubica == 3) { 
				echo "Izquierda Abajo";
				}
				 ?></td>
                </tr>
                <tr>
                  <td align="right" class="fuente"><strong>Nombre del Banner:</strong></td>
                  <td class="fuente"><?php echo utf8_encode($row_rsBanner['Titulo_Ban']); ?></td>
                </tr>
                
                       <?  $ext = strtolower(substr($row_rsBanner['Archivo_Ban'], -3));
						if ($ext == "jpg" || ($ext == "gif") || ($ext == "png") ) { ?>
                <tr>
                  <td colspan="2" align="center" class="fuente"><strong>Visualizaci&oacute;n de Imagen:</strong></td>
                </tr>
               <tr>
                  <td colspan="2" align="center" class="fuente"><img src="../../banners/<?php echo $row_rsBanner['Archivo_Ban']; ?>" alt=""></td>
                </tr>
                <tr><td class="fuente" align="right"><strong>Url de Imagen:</strong></td><td class="fuente"><? echo $row_rsBanner['Url_Ban']?></td>
                </tr>
                
                
                <? } else {?>
                 <tr>
                  <td colspan="2" align="center" class="fuente"><strong>Visualizaci&oacute;n de Video:</strong></td>
                </tr>
               <tr>
                  <td colspan="2" align="center" class="fuente"><div id="embed" >
                   <? echo utf8_encode($row_rsBanner['Archivo_Ban']);?>
                   </div> </td>
                </tr>
                <tr>
                
                <? }?> 
                  <td align="right" class="fuente"><strong>Estado:</strong></td>
                  <td align="left" class="fuente"><?php $estado = $row_rsBanner['Estado_Ban'];
					if ($estado == 1) {
					echo "Habilitado";
					} else {
					echo "Deshabilitado";
					}
					?></td>
                </tr>
                <tr>
                  <td colspan="2" class="fuente"><a href="editar.php?id_ban=<?php echo $row_rsBanner['Id_Banner']; ?>" class="linksRojo"><strong>EDITAR BANNER</strong></a></td>
                  </tr>
              </table></td>
              <td background="../img/cdo_der_fnd.jpg"></td>
            </tr>
            <tr>
               <td id="cdo_dwn_izq" height="11" width="11"></td>
                  <td id="cdo_dwn_fnd" height="11"></td>
                  <td id="cdo_dwn_der"></td>
            </tr>
          </table>
          <p><a href="index.php" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Banners</strong></a></p>
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