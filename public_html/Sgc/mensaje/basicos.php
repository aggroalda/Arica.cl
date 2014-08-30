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
$nivel= $_SESSION['MM_IdNivel'];
$usuario=$_SESSION['MM_IdUser'];

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE opciones SET email_opc=%s, direccion_opc=%s,direccion2_opc=%s, celular_opc=%s, telefono_opc=%s, telefono2_opc=%s",
                       GetSQLValueString($_POST['email_Txt'], "text"),
                       GetSQLValueString($_POST['direccion_Txt'], "text"),
					   GetSQLValueString($_POST['direccion2_Txt'], "text"),
                       GetSQLValueString($_POST['celular_Txt'], "text"),
                       GetSQLValueString($_POST['telefono_Txt'], "text"),
					   GetSQLValueString($_POST['telefono2_Txt'], "text"));

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL, $cnx_arica) or die(mysql_error());

  $updateGoTo = "ver_basicos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);




mysql_select_db($database_cnx_arica, $cnx_arica);
// $query_rsBasicos = "SELECT email_opc, direccion_opc, direccion2_opc, celular_opc, telefono_opc, telefono2_opc FROM opciones";
$query_rsBasicos = "SELECT * from usuarios,personas,pais WHERE usuarios.Id_Usuario= $usuario AND usuarios.IdPersona_Usu= personas.Id_Persona AND personas.IdPais_Per= pais.Id_Pais";
$rsBasicos = mysql_query($query_rsBasicos, $cnx_arica) or die(mysql_error());
$row_rsBasicos = mysql_fetch_assoc($rsBasicos);
$totalRows_rsBasicos = mysql_num_rows($rsBasicos);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript">
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.title; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es requerido.\n'; }
    } if (errors) alert('Ocurrieron los siguientes errores:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
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
      <p class="titles"><? echo $totalRows_rsBasicos;?>&raquo; M&oacute;dulo de Opciones Generales - Datos B&aacute;sicos</p>
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
                  <td width="45%" align="right" class="fuente"><strong>Nombres:</strong></td>
                  <td width="55%" class="fuente"><input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" title="Direcci�n2" value="<?php echo $row_rsBasicos['Nombres_Per']; ?>" size="40"></td>
                </tr>
                <tr>
                  <td width="45%" align="right" class="fuente"><strong>Apellido Paterno:</strong></td>
                  <td width="55%" class="fuente"><input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" title="Direcci�n2" value="<?php echo $row_rsBasicos['Paterno_Per']; ?>" size="40"></td>
                </tr>
                <tr>
                  <td width="45%" align="right" class="fuente"><strong>Apellido Materno:</strong></td>
                  <td width="55%" class="fuente"><input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" title="Direcci�n2" value="<?php echo $row_rsBasicos['Materno_Per']; ?>" size="40"></td>
                </tr>
                 <tr>
                  <td align="right" class="fuente"><strong>Pais:</strong></td>
                  <td class="fuente"><input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" title="Direcci�n2" value="<?php echo $row_rsBasicos['Nombre_Pai']; ?>" size="40"></td>
                </tr>
                <tr>
                  <td align="right" class="fuente"><strong>Numero de Documento:</strong></td>
                  <td class="fuente"><input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" title="Direcci�n2" value="<?php echo $row_rsBasicos['NumeroDoc_Per']; ?>" size="40"></td>
                </tr>
                 <tr>
                  <td align="right" class="fuente"><strong>Ciudad:</strong></td>
                  <td class="fuente"><input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" title="Direcci�n2" value="<?php echo $row_rsBasicos['Ciudad_Per']; ?>" size="40"></td>
                </tr>
                <tr>
                  <td align="right" class="fuente"><strong>Tel&eacute;fono:</strong></td>
                  <td class="fuente"><input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" title="Direcci�n2" value="<?php echo $row_rsBasicos['Direccion_Per']; ?>" size="40"></td>
                </tr>
              <tr>
                  <td align="right" class="fuente"><strong>Correo:</strong></td>
                  <td class="fuente"><input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" title="Direcci�n2" value="<?php echo $row_rsBasicos['Usern_Usu']; ?>" size="40"></td>
                </tr>
                
                
                
                
                
                
                
                
                
                
                
                
                
                  <td colspan="2" align="center"><input type="hidden" name="MM_update" value="form1">
                    <input type="hidden" name="MM_insert" value="form1">
                    <input name="SendForm" type="submit" id="SendForm" onClick="MM_validateForm('direccion_Txt','','R','celular_Txt','','R','telefono_Txt','','R','email_Txt','','RisEmail');return document.MM_returnValue" value=" Guardar "></td>
                </tr>
              </table>
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

mysql_free_result($rsBasicos);
?>