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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE paginas SET Titulo_Pag=%s, Descripcion_Pag=%s, Keywords_Pag=%s WHERE Id_Pagina=%s",
                       GetSQLValueString($_POST['titulo_Txt'], "text"),
                       GetSQLValueString($_POST['descripcion_Txt'], "text"),
                       GetSQLValueString($_POST['clave_Txt'], "text"),
                       GetSQLValueString($_POST['id_pagina'], "int"));

  mysql_select_db($database_cnx_arica, $cnx_arica);
  $Result1 = mysql_query($updateSQL, $cnx_arica) or die(mysql_error());

  $updateGoTo = "ver_pagina.php?id_pag=" . $row_rsPaginas['Id_Pagina'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$colname_rsPaginas = "-1";
if (isset($_GET['id_pag'])) {
  $colname_rsPaginas = $_GET['id_pag'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsPaginas = sprintf("SELECT * FROM paginas WHERE Id_Pagina = %s", GetSQLValueString($colname_rsPaginas, "int"));
$rsPaginas = mysql_query($query_rsPaginas, $cnx_arica) or die(mysql_error());
$row_rsPaginas = mysql_fetch_assoc($rsPaginas);
$totalRows_rsPaginas = mysql_num_rows($rsPaginas);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript">
function limita(obj,elEvento, maxi) {
  var elem = obj;

  var evento = elEvento || window.event;
  var cod = evento.charCode || evento.keyCode;

    // 37 izquierda
	// 38 arriba
	// 39 derecha
	// 40 abajo
	// 8  backspace
	// 46 suprimir

  if(cod == 37 || cod == 38 || cod == 39
  || cod == 40 || cod == 8 || cod == 46)
  {
	return true;
  }

  if(elem.value.length < maxi) {
    return true;
  }

  return false;
}

function cuenta(obj,evento,maxi,div){
	var elem = obj.value;
	var info = document.getElementById(div);

	info.innerHTML = maxi-elem.length;
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
      <p class="titles">&raquo; M&oacute;dulo de Opciones Generales - Opciones en <?php echo $row_rsPaginas['Nombre_Pag']; ?></p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="11"><img src="../img/cdo_top_izq.jpg"/></td>
            <td width="929" background="../img/cdo_top_fnd.jpg"></td>
            <td width="11"><img src="../img/cdo_top_der.jpg"/></td>
          </tr>
          <tr>
            <td background="../img/cdo_izq_fnd.jpg"></td>
            <td bgcolor="#EBEBEB"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
              <table width="100%">
                <tr>
                  <td width="34%" align="right" class="fuente"><strong>T&iacute;tulo de P&aacute;gina:</strong></td>
                  <td width="66%" class="fuente"><input name="titulo_Txt" type="text" class="fuente" id="titulo_Txt" title="Direcci�n" value="<?php echo $row_rsPaginas['Titulo_Pag']; ?>" size="40" onKeyPress="return limita(this, event,255)" onKeyUp="cuenta(this, event,255,'contador0')"><br>
                    S&oacute;lo 255 Car&aacute;cteres. Quedan: <strong><span id="contador0" class="linksRojo"></span></strong></td>
                </tr>
                <tr>
                  <td align="right" valign="top" class="fuente"><strong>Descripci&oacute;n de P&aacute;gina:</strong></td>
                  <td class="fuente"><textarea name="descripcion_Txt" cols="40" rows="5" class="fuente" id="descripcion_Txt"onkeypress="return limita(this, event,255)" onKeyUp="cuenta(this, event,255,'contador1')">
<?php echo $row_rsPaginas['Descripcion_Pag']; ?></textarea> 
                    <br>
                    S&oacute;lo 255 Car&aacute;cteres. Quedan: <strong><span id="contador1" class="linksRojo"></span></strong></td>
                </tr>
                <tr>
                  <td align="right" valign="top" class="fuente"><strong>Palabras Claves de P&aacute;gina:</strong></td>
                  <td class="fuente"><textarea name="clave_Txt" cols="40" rows="5" class="fuente" id="clave_Txt" onKeyPress="return limita(this, event,500)" onKeyUp="cuenta(this, event,500,'contador2')"><?php echo $row_rsPaginas['Keywords_Pag']; ?></textarea>
                    <br>
                    Separar con una coma. S&oacute;lo 500 Car&aacute;cteres. Quedan: <strong><span id="contador2" class="linksRojo"></span></strong></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><input name="id_pagina" type="hidden" id="id_pagina" value="<?php echo $row_rsPaginas['Id_Pagina']; ?>">
                    <input type="hidden" name="MM_insert" value="form1">
                    <input name="SendForm" type="submit" id="SendForm" onClick="MM_validateForm('nombre_Txt','','R');return document.MM_returnValue" value=" Guardar "></td>
                </tr>
              </table>
              <input type="hidden" name="MM_update" value="form1">
            </form></td>
            <td background="../img/cdo_der_fnd.jpg"></td>
          </tr>
          <tr>
            <td height="11"><img src="../img/cdo_dwn_izq.jpg" width="11" height="11"/></td>
            <td background="../img/cdo_dwn_fnd.jpg"></td>
            <td><img src="../img/cdo_dwn_der.jpg" width="11" height="11"/></td>
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

mysql_free_result($rsPaginas);
?>