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


$fechanacimiento= date("Y-m-d",strtotime($_POST['fechanac_Txt']));
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO personas (Nombres_Per, Paterno_Per, Materno_Per,FechaNac_Per, Sexo_Per,IdDocumento_Per, NumeroDoc_Per, Ciudad_Per, Direccion_Per, Telefono_Per) VALUES (%s,  %s, %s, %s, %s, %s, %s, %s,%s,%s)",
                       GetSQLValueString(utf8_decode($_POST['nombres_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['paterno_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['materno_Txt']), "text"),
                       GetSQLValueString($fechanacimiento, "date"),
					   GetSQLValueString(utf8_decode($_POST['sexo_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['tipodoc_Txt']), "int"),
                       GetSQLValueString($_POST['numerodoc_Txt'], "text"),
                       GetSQLValueString(utf8_decode($_POST['ciudad_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['direccion_Txt']), "text"),
                       GetSQLValueString($_POST['telefono_Txt'], "text"));

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());

  $id_persona = mysql_insert_id($cnx_arica);
  
  include("../includes/pass.php");
 
 // $codigo = md5($codigo);
  
  $insert = "INSERT INTO usuarios (IdNivel_Usu, IdPersona_Usu, Usern_Usu, Passw_Usu) VALUES ('".utf8_decode($_POST['nivel_Txt'])."', '$id_persona', '".utf8_decode($_POST['usuario2_Txt'])."', '$codigo')";
    
  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insert, $cnx_arica) or die(mysql_error());  

  $id_persona = mysql_insert_id($cnx_arica);


$nivel=$_POST['nivel_Txt'];
	$para = $_POST['usuario2_Txt'];
  	$subject = "Bienvenido al arica.cl El Verdadero Portal de Arica";
	$header = "From: no-responder@arica.cl \r\n";
	$header .= "Mime-Version: 1.0 \r\n";
	$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
	
	if($nivel==3){
	$msg = "
	<h2 style='font-family:Arial; color:#333333;'>Bienvenido al Portal Web de Arica.cl</h2>
	<div style='font-size=10px; font-weight:bold; font-family:Arial; color:#C00;'>Por favor no responda este mensaje automático.</div><br>
	<span style='font-size=12px; font-family:Arial; color:#333333;'>
	 Estimado usuario de Arica cl, para ingresar al Sistema debería ingresar a <a href='http://www.arica.cl'>www.arica.cl</a> e introducir su Usuario y Contraseña siguiente:
	<p>Usuario: <strong>$para</strong><br>
	Contraseña: <strong>$codigo</strong></p>
	<p>Ingrese a: <a href='http://www.arica.cl'>http://www.arica.cl</a> . Si tiene alguna duda por favor escriba a aricacl@hotmail.com<br>
	_________________________________________________________________</p>
	Atentamente,<BR><BR>
	La Administración<BR>
	arica.cl<BR>
	 Arica - Chile<br>
	<br>
	<img src='http://www.arica.cl/img/logotipo.gif'>
	</span>";
		}
		
		if($nivel==2){
	$msg = "
	<h2 style='font-family:Arial; color:#333333;'>Bienvenido al arica.cl El Verdadero Portal de Arica</h2>
	<div style='font-size=10px; font-weight:bold; font-family:Arial; color:#C00;'>Por favor no responda este mensaje automático.</div><br>
	<span style='font-size=12px; font-family:Arial; color:#333333;'>
	Estimado escritor de Arica cl, para ingresar al Sistema deberá ingresar a <a href='http://www.arica.cl/Sgc'>www.arica.cl/Sgc</a> e introducir su Usuario y Contraseña siguiente:
	
	<p>Usuario: <strong>$para</strong><br>
	Contraseña: <strong>$codigo</strong></p>
	<p>Ingrese a: <a href='http://www.arica.cl/Sgc'>www.arica.cl/Sgc</a> .
	 Si tiene alguna duda por favor escriba a aricacl@hotmail.com<br>
	_________________________________________________________________</p>
	Atentamente,<BR><BR>
	La Administración<BR>
	 arica.cl<BR>
	 Arica - Chile<br>
	<br>
		<img src='http://www.arica.cl/img/logotipo.gif'>
	</span>";
		}
		
		
	if($nivel==1){
	$msg = "
	<h2 style='font-family:Arial; color:#333333;'>Bienvenido al arica.cl El Verdadero Portal de Arica</h2>
	<div style='font-size=10px; font-weight:bold; font-family:Arial; color:#C00;'>Por favor no responda este mensaje automático.</div><br>
	<span style='font-size=12px; font-family:Arial; color:#333333;'>
	Estimado Administrador del arica.cl, para ingresar al Sistema  vaya a <a href='http://www.arica.cl/Sgc'>www.arica.cl/Sgc</a> e introduzca su Usuario y Contraseña siguiente:
	
	<p>Usuario: <strong>$para</strong><br>
	Contraseña: <strong>$codigo</strong></p>
	<p>Ingrese a: <a href='http://www.arica.cl/Sgc'>www.arica.cl/Sgc</a> .
	 Si tiene alguna duda por favor escriba a admin@arica.cl<br>
	_________________________________________________________________</p>
	Atentamente,<BR><BR>
	La Administración<BR>
	Arica cl El Verdadero Portal de Arica<BR>
	Arica - Chile<br>
	<br>
	<img src='http://www.arica.cl/img/logotipo.gif'>
	</span>";
		}
		
		
	
	mail($para, $subject, $msg, $header);
  
  header("Location: ver.php?id_usu=$id_persona");
}

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

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
<script type="text/javascript" src="../js/ajax.js"></script>
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<link href="../css/CalendarControl.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" type="image/x-icon" href="../../0_SOURCE/SGC_INTERNET/img/sgc.ico" />
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
					usuario2_Txt: {
						equalTo: "#usuario_Txt"
					},
					nombres_Txt: "required",
					paterno_Txt: "required",
					materno_Txt: "required",
					
					tipodoc_Txt: "required",
					numerodoc_Txt: "required",
					ciudad_Txt: "required",
					direccion_Txt: "required",
					telefono_Txt: "required"
				},
				messages: {
					nivel_Txt: "Requerido",
					usuario_Txt: "Requerido",
					usuario2_Txt: "Usuarios No coinciden",
					nombres_Txt: "Requerido",
					paterno_Txt: "Requerido",
					materno_Txt: "Requerido",
					
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
     <strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../usuarios/index.php">M&oacute;dulo de Usuarios</a></p></strong>
      <p class="titles">&raquo; M&oacute;dulo de Usuarios  / Agregar</p>
    </blockquote><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
              <td bgcolor="#EBEBEB"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
                <table width="100%">
                  <tr>
                    <td width="32%" align="right" class="fuente"><strong>Nivel:</strong></td>
                    <td width="68%" class="fuente">
                      <select name="nivel_Txt" class="fuente" id="nivel_Txt">
                        <option value="">-- Seleccione --</option>
                        <?php do {  ?>
                        <option value="<?php echo $row_rsNivel['Id_Nivel']?>"><?php echo $row_rsNivel['Nombre_Niv']?></option>
                        <?php } while ($row_rsNivel = mysql_fetch_assoc($rsNivel));
						  $rows = mysql_num_rows($rsNivel);
						  if($rows > 0) {
							  mysql_data_seek($rsNivel, 0);
							  $row_rsNivel = mysql_fetch_assoc($rsNivel);
						  } ?>
                      </select></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Usuario / Correo Electr&oacute;nico:</strong></td>
                    <td class="fuente"><input name="usuario_Txt" type="text" class="fuente" id="usuario_Txt" size="35" style="float:left;" onBlur="verifyuser(0)"><div id="dvResultado"></div></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Repetir Usuario / Correo Electr&oacute;nico:</strong></td>
                    <td align="left" class="fuente"><input name="usuario2_Txt" type="text" class="fuente" id="usuario2_Txt" size="35" onKeyPress="ocultar('dvResultado');"></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Nombres:</strong></td>
                    <td align="left" class="fuente"><input name="nombres_Txt" type="text" class="fuente" id="nombres_Txt"></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Apellido Paterno:</strong></td>
                    <td align="left" class="fuente"><input name="paterno_Txt" type="text" class="fuente" id="paterno_Txt"></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Apellido Materno:</strong></td>
                    <td align="left" class="fuente"><input autocomplete="off" name="materno_Txt" type="text" class="fuente" id="materno_Txt"></td>
                  </tr>
                  
                  
                  <tr>
                    <td align="right" class="fuente"><strong>Fecha Nacimiento:</strong></td>
                    <td align="left" class="fuente">
                    
                   <input autocomplete="off" name="fechanac_Txt" type="text" class="fuente" id="fechanac_Txt" onClick="showCalendarControl(this)"> 
                   
  <?php /*?>        /*           <select name="dia_Txt" class="fuente" id="dia_Txt">
                    <option value="">D�a</option>
                  <? for ($i=1;$i<=31;$i++) {
					 ?>
                  <option value="<? if (strlen($i) == 1) { $diacmi = "0".$i; echo $diacmi; } else { $diacmi = $i; echo $diacmi; }?>"<? if ($diacm == $diacmi)
				   { echo " selected"; } ?>><? echo $diacmi; ?></option>
                  <? } ?>
                </select> - <select name="mes_llegada" class="fuente" id="mes_llegada">
                <option value="">Mes</option>
                  <? $mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"); ?>
                  <? // $mescm = date(m);
				   $mes_act=1;  
				  for ($i=$mes_act;$i<=12;$i++) { ?>
                  <option value="<? if (strlen($i) == 1) { $mescmi = "0".$i; echo $mescmi; } else { $mescmi = $i; echo $mescmi; }?>"<? if ($mescm == $mescmi) { echo " selected"; } ?>><? echo $mes[$i-1]; ?></option>
                  <? } ?>
                </select> - <? $yearhoy = date(Y); ?>
                <select name="year_llegada" class="fuente" id="year_llegada">
                <option value="">A�o</option>
                 <? for ($i=2012;$i>=1912;$i=$i-1) {?>
                  <option value="<?  $diacmi = $i; echo $diacmi; ?>"><? echo $diacmi; ?></option>
                  <? } ?>
                </select>
               
                <input name="year_llegada" id="year_llegada" type="hidden" value="<? echo $yearhoy; ?>" >
                
           */?>
                    
          
                    
                    
                    
                    </td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Sexo:</strong></td>
                    <td align="left" class="fuente"><select  name="sexo_Txt" class="fuente" id="sexo_Txt">
                    <option value="">-- Seleccione --</option>
                    <option>Masculino</option>
                    <option>Femenino</option>
                    </select></td>
                  </tr>
                  
                  
                  <tr>
                    <td align="right" class="fuente"><strong>Tipo de Documento:</strong></td>
                    <td align="left" class="fuente">
                      <select name="tipodoc_Txt" class="fuente" id="tipodoc_Txt">
                        <option value="">-- Seleccione --</option>
                        <?php do {  ?>
                        <option value="<?php echo $row_rsDocumento['Id_Documentos']?>"><?php echo utf8_encode($row_rsDocumento['Descripcion_Doc']);?></option>
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
                    <td align="left" class="fuente"><input name="numerodoc_Txt" type="text" class="fuente" id="numerodoc_Txt" style="float:left;" onBlur="verifydni(0);"><div id="divDNI"></div></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Ciudad:</strong></td>
                    <td align="left" class="fuente"><input name="ciudad_Txt" type="text" class="fuente" id="ciudad_Txt" onKeyPress="ocultar('divDNI');"></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Direcci&oacute;n:</strong></td>
                    <td align="left" class="fuente"><input name="direccion_Txt" type="text" class="fuente" id="direccion_Txt"size="35"></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Tel&eacute;fono:</strong></td>
                    <td align="left" class="fuente"><input name="telefono_Txt" type="text" class="fuente" id="telefono_Txt"></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center">
                      <input type="hidden" name="MM_insert" value="form1">
                      <input name="SendForm" type="submit" id="SendForm" value=" Guardar ">
                      </td>
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

mysql_free_result($rsNivel);

mysql_free_result($rsDocumento);
?>