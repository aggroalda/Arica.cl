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

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsUsuarios = "SELECT * FROM usuarios, personas, nivel, documentos WHERE usuarios.Id_Usuario = '".$_GET['id_usu']."' AND usuarios.IdPersona_Usu = personas.Id_Persona  AND usuarios.IdNivel_Usu = nivel.Id_Nivel AND personas.IdDocumento_Per = documentos.Id_Documentos";
$rsUsuarios = mysql_query($query_rsUsuarios, $cnx_arica) or die(mysql_error());
$row_rsUsuarios = mysql_fetch_assoc($rsUsuarios);
$totalRows_rsUsuarios = mysql_num_rows($rsUsuarios);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" type="image/x-icon" href="../../0_SOURCE/SGC_INTERNET/img/sgc.ico" />
<script type="text/javascript" src="../js/ajax.js"></script>
</head>
<body>
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
    <strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../usuarios/index.php">M&oacute;dulo de Usuarios</a> / <a id="guia_titulos" href="#">Detalles</a></p></strong>
          <p class="titles">&raquo; M&oacute;dulo de Usuarios  / Detalles</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><blockquote>
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="11" height="11" id="cdo_top_izq"></td>
              <td width="895" height="11" id="cdo_top_fnd"></td>
              <td width="11" height="11" id="cdo_top_der"></td>
            </tr>
            <tr>
              <td background="../img/cdo_izq_fnd.jpg"></td>
              <td bgcolor="#EBEBEB"><table width="100%">
                <tr>
                  <td width="29%" align="right" class="fuente"><strong>Nivel:</strong></td>
                  <td width="71%" class="fuente"><?php echo $row_rsUsuarios['Nombre_Niv']; ?>
                    <input name="id_usu" type="hidden" id="id_usu" value="<?php echo $row_rsUsuarios['Id_Usuario']; ?>"></td>
                </tr>
                <tr>
                  <td align="right" class="fuente"><strong>Usuario:</strong></td>
                  <td class="fuente"><?php echo utf8_encode($row_rsUsuarios['Usern_Usu']); ?></td>
                </tr>
                <tr>
                  <td align="right" class="fuente"><strong>Contrase&ntilde;a:</strong></td>
                  <td align="left" class="fuente"><strong><div id="dvResultado" class="linksRojo"><a href="#" class="linksRojo" onClick="cambiarpass()">Modificar Contrase&ntilde;a</a><? include("modificar.php"); ?></div></strong></td>
                </tr>
                <tr>
                  <td align="right" class="fuente"><strong>Nombres:</strong></td>
                  <td align="left" class="fuente"><?php echo utf8_encode($row_rsUsuarios['Nombres_Per']); ?></td>
                </tr>
                <tr>
                  <td align="right" class="fuente"><strong>Apellido Paterno:</strong></td>
                  <td align="left" class="fuente"><?php echo utf8_encode($row_rsUsuarios['Paterno_Per']); ?></td>
                </tr>
                <tr>
                  <td align="right" class="fuente"><strong>Apellido Materno:</strong></td>
                  <td align="left" class="fuente"><?php echo utf8_encode($row_rsUsuarios['Materno_Per']); ?></td>
                </tr>
                        <tr>
                  <td align="right" class="fuente"><strong>Fecha de Nacimiento:</strong></td>
                  <td align="left" class="fuente"><?php 
				  
				  	
$fechanacimiento= date("d-m-Y",strtotime($row_rsUsuarios['FechaNac_Per']));
				  echo $fechanacimiento; ?></td>
                </tr>
                
                    <tr>
                  <td align="right" class="fuente"><strong>Sexo:</strong></td>
                  <td align="left" class="fuente"><?php echo $row_rsUsuarios['Sexo_Per']; ?></td>
                </tr>
                
                <tr>
                  <td align="right" class="fuente"><strong>Tipo de Documento:</strong></td>
                  <td align="left" class="fuente"><?php echo utf8_encode($row_rsUsuarios['Descripcion_Doc']); ?></td>
                </tr>
                <tr>
                  <td align="right" class="fuente"><strong>N&uacute;mero de Documento:</strong></td>
                  <td align="left" class="fuente"><?php echo $row_rsUsuarios['NumeroDoc_Per']; ?></td>
                </tr>
                <tr>
                  <td align="right" class="fuente"><strong>Ciudad:</strong></td>
                  <td align="left" class="fuente"><?php echo utf8_encode($row_rsUsuarios['Ciudad_Per']); ?></td>
                </tr>
                <tr>
                  <td align="right" class="fuente"><strong>Direcci&oacute;n:</strong></td>
                  <td align="left" class="fuente"><?php echo utf8_encode($row_rsUsuarios['Direccion_Per']); ?></td>
                </tr>
                <tr>
                  <td align="right" class="fuente"><strong>Tel&eacute;fono:</strong></td>
                  <td align="left" class="fuente"><?php echo $row_rsUsuarios['Telefono_Per']; ?></td>
                </tr>
                <tr>
                  <td colspan="2" align="right" class="fuente"><a href="editar.php?id_usu=<?php echo $row_rsUsuarios['Id_Usuario']; ?>" class="linksRojo"><strong>EDITAR USUARIO</strong></a></td>
                </tr>
              </table></td>
              <td background="../img/cdo_der_fnd.jpg"></td>
            </tr>
            <tr>
              <td id="cdo_dwn_izq" height="11" width="11"></td>
              <td id="cdo_dwn_fnd" height="11" width="895" ></td>
              <td id="cdo_dwn_der" height="11" width="11"></td>
            </tr>
          </table>
          <p><a href="index.php" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Usuarios </strong></a></p>
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

mysql_free_result($rsUsuarios);
?>