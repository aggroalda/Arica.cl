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
	
$fechanacimiento= date("Y-m-d",strtotime($_POST['fechanac_Txt']));
  $updateSQL = sprintf("UPDATE personas SET Nombres_Per=%s, Paterno_Per=%s, Materno_Per=%s, FechaNac_Per=%s, Sexo_Per=%s,IdDocumento_Per=%s, NumeroDoc_Per=%s, Ciudad_Per=%s, Direccion_Per=%s, Telefono_Per=%s WHERE Id_Persona=%s",
                       GetSQLValueString(utf8_decode($_POST['nombres_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['paterno_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['materno_Txt']), "text"),
					    GetSQLValueString($fechanacimiento, "date"),
						 GetSQLValueString($_POST['sexo_Txt'], "text"),
                       GetSQLValueString(utf8_decode($_POST['tipodoc_Txt']), "int"),
                       GetSQLValueString($_POST['numerodoc_Txt'], "text"),
                       GetSQLValueString(utf8_decode($_POST['ciudad_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['direccion_Txt']), "text"),
                       GetSQLValueString($_POST['telefono_Txt'], "text"),
                       GetSQLValueString($_POST['id_per'], "int"));

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL, $cnx_arica) or die(mysql_error());
  
  $update = sprintf("UPDATE usuarios SET IdNivel_Usu=%s, Usern_Usu=%s WHERE Id_Usuario=%s",
                       GetSQLValueString($_POST['nivel_Txt'], "text"),
                       GetSQLValueString(utf8_decode($_POST['usuario_Txt']), "text"),
                       GetSQLValueString($_POST['id_usu'], "int"));

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($update, $cnx_arica) or die(mysql_error());

  header("Location: ver.php?id_usu=".$_POST['id_usu']);
}


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsUsuarios = "SELECT * FROM usuarios, personas, nivel, documentos WHERE usuarios.Id_Usuario = '".$_GET['id_usu']."' AND usuarios.IdPersona_Usu = personas.Id_Persona AND usuarios.IdNivel_Usu = nivel.Id_Nivel AND personas.IdDocumento_Per = documentos.Id_Documentos";
$rsUsuarios = mysql_query($query_rsUsuarios, $cnx_arica) or die(mysql_error());
$row_rsUsuarios = mysql_fetch_assoc($rsUsuarios);
$totalRows_rsUsuarios = mysql_num_rows($rsUsuarios);

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsNivel = "SELECT * FROM nivel ORDER BY Id_Nivel ASC";
$rsNivel = mysql_query($query_rsNivel, $cnx_arica) or die(mysql_error());
$row_rsNivel = mysql_fetch_assoc($rsNivel);
$totalRows_rsNivel = mysql_num_rows($rsNivel);



mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsDocumento = "SELECT * FROM documentos ORDER BY Id_Documentos ASC";
$rsDocumento = mysql_query($query_rsDocumento, $cnx_arica) or die(mysql_error());
$row_rsDocumento = mysql_fetch_assoc($rsDocumento);
$totalRows_rsDocumento = mysql_num_rows($rsDocumento);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<link href="../css/CalendarControl.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" type="image/x-icon" href="../../0_SOURCE/SGC_INTERNET/img/sgc.ico" />
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../js/CalendarControl.js"></script>
<script type="text/javascript">
$.validator.methods.equal = function(value, element, param) {
		return value == param;
	};
	$(document).ready(function(){
				
		$("#form1").validate({
				rules: {
					nivel_Txt: "required",
					usuario_Txt: "email required",
					nombres_Txt: "required",
					paterno_Txt: "required",
					materno_Txt: "required",
					pais_Txt: "required",
					tipodoc_Txt: "required",
					numerodoc_Txt: "required",
					ciudad_Txt: "required",
					direccion_Txt: "required",
					telefono_Txt: "required"
				},
				messages: {
					nivel_Txt: "Requerido",
					usuario_Txt: "Requerido",
					nombres_Txt: "Requerido",
					paterno_Txt: "Requerido",
					materno_Txt: "Requerido",
					pais_Txt: "Requerido",
					tipodoc_Txt: "Requerido",
					numerodoc_Txt: "Requerido",
					ciudad_Txt: "Requerido",
					direccion_Txt: "Requerido",
					telefono_Txt: "Requerido"
					}
			});
	});
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
    
     <strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../usuarios/index.php">M&oacute;dulo de Usuarios</a> / <a id="guia_titulos" href="../usuarios/ver.php?id_usu=<? echo $_GET['id_usu']?>">Detalles</a></p></strong>
     
      <p class="titles">&raquo; M&oacute;dulo de Usuarios y Clientes / Editar</p>
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
              <td bgcolor="#EBEBEB"><form name="form1" method="POST" action="<?php echo $editFormAction; ?>" id="form1">
                <table width="100%">
                  <tr>
                    <td align="right" class="fuente"><strong>Nivel:</strong></td>
                    <td class="fuente"><select name="nivel_Txt" class="fuente" id="nivel_Txt">
                      <option value="" <?php if (!(strcmp("", $row_rsUsuarios['IdNivel_Usu']))) {echo "selected=\"selected\"";} ?>>-- Seleccione --</option>
                      <?php do {  ?>
						<option value="<?php echo $row_rsNivel['Id_Nivel']?>"<?php if (!(strcmp($row_rsNivel['Id_Nivel'], $row_rsUsuarios['IdNivel_Usu']))) {echo "selected=\"selected\"";} ?>><?php echo utf8_encode($row_rsNivel['Nombre_Niv']);?></option>
						<?php
                        } while ($row_rsNivel = mysql_fetch_assoc($rsNivel));
                          $rows = mysql_num_rows($rsNivel);
                          if($rows > 0) {
                              mysql_data_seek($rsNivel, 0);
                              $row_rsNivel = mysql_fetch_assoc($rsNivel);
                          } ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Usuario / Correo Electr&oacute;nico:</strong></td>
                    <td class="fuente"><input name="usuario_Txt" type="text" class="fuente" id="usuario_Txt" style="float:left;" onBlur="verifyuser(1)" value="<?php echo utf8_encode($row_rsUsuarios['Usern_Usu']); ?>" size="35" autocomplete="off">
                      <div id="dvResultado"></div></td>
                  </tr>
                  <tbody id="trRepetir" style="display:none;">
                  <tr>
                    <td align="right" class="fuente"><strong>Repetir Usuario / Correo Electr&oacute;nico:</strong></td>
                    <td align="left" class="fuente"><input name="usuario2_Txt" type="text" class="fuente" id="usuario2_Txt" onKeyPress="ocultar('dvResultado')" size="35" autocomplete="off" onBlur="usuarios();"></td>
                  </tr>
                  </tbody>
                  <tr>
                    <td width="31%" align="right" class="fuente"><strong>Nombres:</strong></td>
                    <td width="69%" align="left" class="fuente"><input name="nombres_Txt" type="text" class="fuente" id="nombres_Txt" value="<?php echo utf8_encode($row_rsUsuarios['Nombres_Per']); ?>">
                      <input name="id_per" type="hidden" id="id_per" value="<?php echo $row_rsUsuarios['IdPersona_Usu']; ?>">
                      <input name="id_usu" type="hidden" id="id_usu" value="<?php echo $row_rsUsuarios['Id_Usuario']; ?>"></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Apellido Paterno:</strong></td>
                    <td align="left" class="fuente">
                      <input name="paterno_Txt" type="text" class="fuente" id="paterno_Txt" value="<?php echo utf8_encode($row_rsUsuarios['Paterno_Per']); ?>"></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Apellido Materno:</strong></td>
                    <td align="left" class="fuente"><input name="materno_Txt" type="text" class="fuente" id="materno_Txt" value="<?php echo utf8_encode($row_rsUsuarios['Materno_Per']); ?>"></td>
                  </tr>
                    <tr>
                    <td align="right" class="fuente"><strong>Fecha de Nacimiento:</strong></td>
                    <td align="left" class="fuente"> <input name="fechanac_Txt" type="text" class="fuente" id="fechanac_Txt" onClick="showCalendarControl(this)" value="<? echo date("d-m-Y",strtotime($row_rsUsuarios['FechaNac_Per']))?>"> </td>
                  </tr>
                  
                  <tr>
                  <td align="right" class="fuente"><strong>Sexo:</strong></td>
                  <td align="left" class="fuente"><select name="sexo_Txt" class="fuente" id="sexo_Txt">
                    <option value="">-- Seleccione --</option>
                    <option <? if ($row_rsUsuarios['Sexo_Per']=="Masculino"){?>selected<? }?>>Masculino</option>
                    <option <? if ($row_rsUsuarios['Sexo_Per']=="Femenino"){?>selected<? }?>>Femenino</option>
                    </select></td>
                </tr>
                     
                  <tr>
                    <td align="right" class="fuente"><strong>Tipo de Documento:</strong></td>
                    <td align="left" class="fuente"><select name="tipodoc_Txt" class="fuente" id="tipodoc_Txt">
                      <?php do { ?>
                      <option value="<?php echo $row_rsDocumento['Id_Documentos']?>"<?php if (!(strcmp($row_rsDocumento['Id_Documentos'], $row_rsUsuarios['Id_Documentos']))) {echo "selected=\"selected\"";} ?>><?php echo utf8_encode($row_rsDocumento['Descripcion_Doc']);?></option>
                      <?php } while ($row_rsDocumento = mysql_fetch_assoc($rsDocumento));
					  $rows = mysql_num_rows($rsDocumento);
					  if($rows > 0) {
						  mysql_data_seek($rsDocumento, 0);
						  $row_rsDocumento = mysql_fetch_assoc($rsDocumento);
					  } ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>N&uacute;mero de Documento:</strong></td>
                    <td align="left" class="fuente">
                      <input name="numerodoc_Txt" type="text" class="fuente" id="numerodoc_Txt" value="<?php echo $row_rsUsuarios['NumeroDoc_Per']; ?>" style="float:left;" onBlur="verifydni(1)" autocomplete="off"><div id="divDNI"></div></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Ciudad:</strong></td>
                    <td align="left" class="fuente">
                      <input name="ciudad_Txt" type="text" class="fuente" id="ciudad_Txt" value="<?php echo utf8_encode($row_rsUsuarios['Ciudad_Per']); ?>" onKeyPress="ocultar('divDNI');"></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Direcci&oacute;n:</strong></td>
                    <td align="left" class="fuente"><input name="direccion_Txt" type="text" class="fuente" id="direccion_Txt" value="<?php echo utf8_encode($row_rsUsuarios['Direccion_Per']); ?>" size="35"></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Tel&eacute;fono:</strong></td>
                    <td align="left" class="fuente"><input name="telefono_Txt" type="text" class="fuente" id="telefono_Txt" value="<?php echo $row_rsUsuarios['Telefono_Per']; ?>" size="35"></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" class="fuente"><input type="hidden" name="MM_update" value="form1">                      <input name="SendForm" type="submit" class="fuente" id="SendForm" value="  Guardar Cambios  "></td>
                  </tr>
                </table>
              </form></td>
              <td background="../img/cdo_der_fnd.jpg"></td>
            </tr>
            <tr>
            <td id="cdo_dwn_izq" height="11" width="11"></td>
                  <td id="cdo_dwn_fnd" height="11"></td>
                  <td id="cdo_dwn_der"></td>
            </tr>
          </table>
          <p><a href="index.php" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Usuarios y Clientes</strong></a></p>
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

mysql_free_result($rsNivel);


mysql_free_result($rsDocumento);
?>