<?php require_once('../../0_SOURCE/Connections/cnx_arica.php'); ?>
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
	
  $logoutGoTo = "../../0_SOURCE/SGC_INTERNET/index.php";
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

$MM_restrictGoTo = "../../0_SOURCE/SGC_INTERNET/index.php?error=2";
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

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);
$id_texto=$_GET['id_txt'];
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTexto = "SELECT * FROM textos where Id_Texto=".$id_texto;
$rsTexto = mysql_query($query_rsTexto, $cnx_arica) or die(mysql_error());
$row_rsTexto = mysql_fetch_assoc($rsTexto);
$totalRows_rsTexto = mysql_num_rows($rsTexto);

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../../0_SOURCE/SGC_INTERNET/css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../0_SOURCE/SGC_INTERNET/js/td_over.js"></script>
<script type="text/javascript" src="../../0_SOURCE/SGC_INTERNET/js/justcorners.js"></script>
<script type="text/javascript" src="../../0_SOURCE/SGC_INTERNET/js/corner.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.3/mootools-yui-compressed.js"></script>
--><script type="text/javascript" src="../../0_SOURCE/SGC_INTERNET/js/sexylightbox.v2.3.mootools.min.js"></script>

<link rel="stylesheet" href="../../0_SOURCE/SGC_INTERNET/css/sexylightbox.css" type="text/css" media="all" />
<script type="text/javascript">
    window.addEvent('domready', function(){
      SexyLightbox = new SexyLightBox({color:'black', dir: '../img/'});
    });
</script>
</head>
<body>
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../../0_SOURCE/SGC_INTERNET/option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
      <p class="titles">&raquo; M&oacute;dulo de Textos - Detalles <? echo $row_rsTexto['Titulo_Txt']?></p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="11"><img src="../../0_SOURCE/SGC_INTERNET/img/cdo_top_izq.jpg"/></td>
            <td background="../../0_SOURCE/SGC_INTERNET/img/cdo_top_fnd.jpg"></td>
            <td width="11"><img src="../../0_SOURCE/SGC_INTERNET/img/cdo_top_der.jpg"/></td>
          </tr>
          <tr>
            <td rowspan="3" background="../../0_SOURCE/SGC_INTERNET/img/cdo_izq_fnd.jpg"></td>
            <td valign="top" bgcolor="#EBEBEB"><table width="100%" align="center" >
              <tr>
                <td width="27%" align="right" valign="top" class="fuente" ><strong>Texto de la P&aacute;gina:</strong></td>
                <td width="73%" align="left" class="fuente">
				
				<img style="margin-right:5px" src="../../img/<?php echo $row_rsTexto['Imagen_Txt']; ?>" align="left">
				<?php $row_rsTexto['Descripcion_Txt'] = str_replace("\n", "<br>", $row_rsTexto['Descripcion_Txt']);
				echo $row_rsTexto['Descripcion_Txt']; ?>
                
                </td>
              </tr>
             <? /* if ($_GET['pagina']=="casa") { ?>
              <tr>
                <td colspan="2" valign="top" class="fuente"><hr></td>
              </tr>
              <tr>
                <td colspan="2" valign="top" class="fuente"><strong>Imagenes Asociadas:</strong></td>
              </tr>
              <tr>
                <td colspan="2" valign="top" class="fuente">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" valign="top" class="fuente"><?php do { ?>
                  <div style="margin-right:10px; float:left;"> <img src="../../inc/imagen.php?nw=150&foto=<?php echo $row_rsGaleria['Archivo_Gal']; ?>" alt="">
                    <div align="center" class="linksRojo" style="margin-top:5px;"><strong>[<a href="../productos/eliminarfoto.php?id_del=<?php echo $row_rsGaleria['Id_Galeria']; ?>&pagina=casa" class="linksRojo">Eliminar</a>]</strong></div>
                  </div>
                  <?php } while ($row_rsGaleria = mysql_fetch_assoc($rsGaleria)); ?></td>
              </tr>
              <tr>
                <td colspan="2" valign="top" class="fuente" >&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" valign="top" class="fuente" ><a href="imagenes.php?id_pro=6&pagina=casa&tipo=3&cantidad=1" class="linksRojo"><strong>[+] Agregar Im&aacute;genes</strong></a></td>
              </tr>
              <? } */?>
            </table></td>
            <td rowspan="3" background="../../0_SOURCE/SGC_INTERNET/img/cdo_der_fnd.jpg"></td>
          </tr>
          <tr>
            <td height="11" align="left" bgcolor="#EBEBEB">&nbsp;</td>
          </tr>
          <tr>
            <td height="11" align="left" bgcolor="#EBEBEB"><a href="../../0_SOURCE/SGC_INTERNET/textos/editar.php?id_txt=<? echo $row_rsTexto['Id_Texto']?>" class="fuente linksRojo"><strong>EDITAR <? echo $row_rsTexto['Titulo_Txt']?></strong></a></td>
            </tr>
          <tr>
            <td height="11"><img src="../../0_SOURCE/SGC_INTERNET/img/cdo_dwn_izq.jpg" width="11" height="11"/></td>
            <td background="../../0_SOURCE/SGC_INTERNET/img/cdo_dwn_fnd.jpg"></td>
            <td><img src="../../0_SOURCE/SGC_INTERNET/img/cdo_dwn_der.jpg" width="11" height="11"/></td>
          </tr>
        </table>
          <blockquote>
          <p><a href="../../0_SOURCE/SGC_INTERNET/textos/index.php" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Textos</strong></a></p>
<p><a href="../../0_SOURCE/SGC_INTERNET/login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
          <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
        </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table></td>
  </tr>
  <? include("../../0_SOURCE/SGC_INTERNET/option/footer.php"); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsOptions);

mysql_free_result($rsTexto);

if ($totalRows_rsGaleria) {
mysql_free_result($rsGaleria);
}
?>