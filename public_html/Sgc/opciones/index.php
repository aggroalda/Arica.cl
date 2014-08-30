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

$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$query_rsMensaje = "SELECT * FROM mensaje";
$rsMensaje = mysql_query($query_rsMensaje, $cnx_arica) or die(mysql_error());
$row_rsMensaje = mysql_fetch_assoc($rsMensaje);
$totalRows_rsMensaje = mysql_num_rows($rsMensaje);

$queryString_rsVideos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsVideos") == false && 
        stristr($param, "totalRows_rsVideos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsVideos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsVideos = sprintf("&totalRows_rsVideos=%d%s", $totalRows_rsVideos, $queryString_rsVideos);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/td_over.js"></script>
</head>
<body>
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
      <p class="titles">&raquo; M&oacute;dulo de Opciones Generales - Listado</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle">
          <table width="98%" align="center" class="bordes2" >
            
            <tr align="center" bgcolor="#660000" class="blanco11">
              <td width="32%" bgcolor="#003366" class="blanco12">Opci&oacute;n</td>
              <td width="13%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Cambiar</strong></td>
              </tr>
            <tbody class="tabla">
              <?  if($_SESSION['MM_IdNivel']==1){
                 ?>          
                <tr class="odd">
                  <td class="fuente"><strong>- <a href="ver_basicos.php" class="fuente">Direcci&oacute;n, Tel&eacute;fono, Correo de Administrador y Contacto</a></strong></td>
                  <td align="center"><a href="basicos.php"><img src="../img/icon_edit.png" width="20" height="20" border="0"></a></td>
                </tr>
                 <? } else { echo "";} ?>
                <tr class="odd">
                  <td class="fuente"><p><strong>- Contrase&ntilde;a de Acceso</strong></p></td>
                  <td align="center"><a href="password.php"><img src="../img/icon_edit.png" width="20" height="20" border="0"></a></td></tr>
                  
                 <?  if($_SESSION['MM_IdNivel']==1){
                 ?>
                  <tr class="odd">
                  <td height="22" class="fuente"><p><strong>- Mensaje de Bienvenida</strong></p></td>
                <td align="center"><a href="mensaje.php"><img src="../img/icon_edit.png" width="20" height="20" border="0"></a></td></tr>
           <? } else { echo "";} ?>
            </tbody>
          </table>          
          <blockquote>
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