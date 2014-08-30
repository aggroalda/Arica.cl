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

$colname_rsCategoria = "-1";
if (isset($_GET['id_del'])) {
  $colname_rsCategoria = $_GET['id_del'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoria = sprintf("SELECT * FROM categoria WHERE Id_Categoria = %s", GetSQLValueString($colname_rsCategoria, "int"));
$rsCategoria = mysql_query($query_rsCategoria, $cnx_arica) or die(mysql_error());
$row_rsCategoria = mysql_fetch_assoc($rsCategoria);
$totalRows_rsCategoria = mysql_num_rows($rsCategoria);

$colname_rsSubcategoria = "-1";
if (isset($_GET['id_del'])) {
  $colname_rsSubcategoria = $_GET['id_del'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsSubcategoria = sprintf("SELECT * FROM subcategoria WHERE Id_Subcategoria = %s", GetSQLValueString($colname_rsSubcategoria, "int"));
$rsSubcategoria = mysql_query($query_rsSubcategoria, $cnx_arica) or die(mysql_error());
$row_rsSubcategoria = mysql_fetch_assoc($rsSubcategoria);
$totalRows_rsSubcategoria = mysql_num_rows($rsSubcategoria);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function preguntarsub(id,name,id_cat) {
confirmar=confirm("�Est� seguro de eliminar esta Subcategor�a "+ name +"?. Eliminar� los productos relacionados a esta subcategor�a."); 
if (confirmar) {
//Aqu� pones lo que quieras si da a Aceptar 
document.location=("eliminar_all_sub.php?id_del="+id+"&id_cat="+id_cat)
}
} 
</script>
</head>
<body>
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
      <p class="titles">&raquo; M&oacute;dulo de SubCategor&iacute;as - Eliminar</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><blockquote>
          <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="11"><img src="../img/cdo_top_izq.jpg"/></td>
              <td width="849" background="../img/cdo_top_fnd.jpg"></td>
              <td width="11"><img src="../img/cdo_top_der.jpg"/></td>
            </tr>
            <tr>
              <td background="../img/cdo_izq_fnd.jpg"></td>
              <td bgcolor="#EBEBEB">
                <table width="100%">
                  <tr>
                    <td width="46%" align="right" class="fuente"><strong>SubCategor&iacute;a:</strong></td>
                    <td width="54%" class="fuente"><?php echo $row_rsSubcategoria['Nombre_Sub']; ?></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" class="linksRojo fuente"><strong>&iquest;Est&aacute; seguro de eliminar esta Subcategor&iacute;a? Eliminar&aacute; los productos relacionados a esta SubCategor&iacute;a.</strong></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"><input name="SendForm" type="submit" id="SendForm" value=" Eliminar " onClick="javascript:preguntarsub('<?php echo $row_rsSubcategoria['Id_Subcategoria']; ?>','<?php echo $row_rsSubcategoria['Nombre_Sub']; ?>','<?php echo $row_rsSubcategoria['IdCategoria_Sub']; ?>')">
                      </td>
                  </tr>
                </table>
              </td>
              <td background="../img/cdo_der_fnd.jpg"></td>
            </tr>
            <tr>
              <td height="11"><img src="../img/cdo_dwn_izq.jpg" width="11" height="11"/></td>
              <td background="../img/cdo_dwn_fnd.jpg"></td>
              <td><img src="../img/cdo_dwn_der.jpg" width="11" height="11"/></td>
            </tr>
          </table>
          <p><a href="index.php" class="fuente linksRojo"><strong>&laquo; Volver al Listado de SubCategor&iacute;as</strong></a></p>
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

mysql_free_result($rsCategoria);

mysql_free_result($rsSubcategoria);
?>