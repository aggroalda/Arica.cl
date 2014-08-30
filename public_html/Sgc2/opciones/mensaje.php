<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
    $nivel= $_SESSION['MM_IdNivel'];
$usuario=$_SESSION['MM_IdUser'];
  
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
session_start();
$nivel= $_SESSION['MM_IdNivel'];
$usuario=$_SESSION['MM_IdUser'];

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT * FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$query_rsMensaje = "SELECT * FROM mensaje";
$rsMensaje = mysql_query($query_rsMensaje, $cnx_arica) or die(mysql_error());
$row_rsMensaje = mysql_fetch_assoc($rsMensaje);
$totalRows_rsMensaje = mysql_num_rows($rsMensaje);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript">
</script>
</head>
<body onLoad="document.form1.titulo_Txt.focus();">
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
      <p class="titles">&raquo; M&oacute;dulo de Opciones Generales - Actualizar Mensaje</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
             <td width="11" height="11" id="cdo_top_izq"></td>
                  <td width="929" height="11" id="cdo_top_fnd"></td>
                  <td width="11" height="11" id="cdo_top_der"></td>
          </tr>
          <tr><td width="20" background="../img/cdo_izq_fnd.jpg"></td>
            <td bgcolor="#EBEBEB"><form  method="GET" name="form1" id="form1">
              <table width="100%">
                    <tr>
                  <td colspan="2" align="center" class="fuente" id="tdR"> <? include("cambiar_mensaje.php");?></td>
                </tr>          
                <tr>
                  <td align="right" class="fuente"><strong> T&iacute;tulo del Mensaje de Bienvenida:</strong></td>
                  <td><input name="titulo_Txt" type="text" class="fuente input_mensaje" id="titulo_Txt" value="<? echo utf8_encode($row_rsMensaje['tituloMensaje']); ?>" ></td>
                </tr>
               <tr>
                  <td align="right" class="fuente"><strong>Descripci&oacute;n del Mensaje de Bienvenida:</strong></td>
 <td><textarea name="descrip_Txt" type="text" class="fuente text_area_mensaje" id="descrip_Txt"><? echo utf8_encode($row_rsMensaje['DescripMensaje']);?></textarea></td>
                </tr>
				
              
                  <td colspan="2" align="center">
                    <input name="btnGuardar" type="button" id="btnGuardar" onClick="cambiarMensaje_m();" value=" Cambiar "></td>
                </tr>
              </table>
            </form></td>
            <td width="35" background="../img/cdo_der_fnd.jpg"></td>
          </tr>
          <tr>
                <td id="cdo_dwn_izq" height="11" width="11"></td>
                  <td id="cdo_dwn_fnd" height="11"></td>
                  <td id="cdo_dwn_der"></td>
          </tr>
        </table>
          <blockquote>
          <p><a href="index.php" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Opciones Generales</strong></a></p>
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
?>