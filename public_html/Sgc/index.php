<?   session_start(); ?>
<?php require_once('../Connections/cnx_arica.php'); ?>
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
$query_rsOptions = "SELECT licencia_opc, soporte_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usuario_Txt'])) {
  $loginUsername=$_POST['usuario_Txt'];
  
  $password=$_POST['password_Txt'];
  //$password=md5($passtemp);
  
  $MM_fldUserAuthorization = "IdNivel_Usu";
  $MM_redirectLoginSuccess = "login.php";
  $MM_redirectLoginFailed = "index.php?error=1";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_cnx_arica, $cnx_arica);
  
  

$LoginRS__query=sprintf("SELECT * FROM usuarios WHERE Estado_Usu = 1 AND Usern_Usu=%s AND Passw_Usu=%s AND (IdNivel_Usu= 1 OR IdNivel_Usu=2 OR IdNivel_Usu=4 OR IdNivel_Usu=5)",
  GetSQLValueString($loginUsername, "text"),
  GetSQLValueString($password, "text")
  );   
  $LoginRS = mysql_query($LoginRS__query, $cnx_arica) or die(mysql_error());
  $loginUsers = mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
 
  if ($loginFoundUser) {
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_arica'] = $loginUsers['Usern_Usu'];
    $_SESSION['MM_UserGroup'] = $loginUsers['IdNivel_Usu'];
	$_SESSION['MM_IdUser'] = $loginUsers['Id_Usuario'];
	$_SESSION['MM_IdNivel'] = $loginUsers['IdNivel_Usu'];

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
  
}
  
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS Versi�n 5.0</title>
<link href="css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.title; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' debe contener un correo electr�nico.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es un campo requerido.\n'; }
    } 
	code1 = document.frmLogin.code.value;
	code2 = document.frmLogin.codigo.value;
	if ((code1 != code2) && (code1)) errors += '- El codigo no coincide.\n'; 
	
	if (errors) alert('Ocurrieron los siguientes errores:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
//-->
</script>
</head>
<body onLoad="document.frmLogin.usuario_Txt.focus();">
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="372" height="259" valign="middle"><blockquote>
          <p class="fuente">La mejor forma de actualizar su Sitio Web. Seguro, facil, intuitivo y r&aacute;pido.<br>
                  <br>
            Si usted necesita soporte por favor contéctese a: <a href="mailto:<?php echo $row_rsOptions['soporte_opc']; ?>" class="fuente"><strong>soporte@idw.com.pe</strong></a></p>
        </blockquote></td>
        <td width="406" align="center" class="fuente"><form id="frmLogin" name="frmLogin" method="POST" action="<?php echo $loginFormAction; ?>">
          <table width="100%" align="center">
            <tr height="11">
              <td width="200%" align="center"><table width="383" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="11" height="11" id="cdo_top_izq"></td>
                  <td width="361" height="11" id="cdo_top_fnd"></td>
                  <td width="11" height="11" id="cdo_top_der"></td>
                </tr>
                <tr>
                  <td background="img/cdo_izq_fnd.jpg"></td>
                  <td bgcolor="#EBEBEB"><table width="100%">
                    <? if ($_GET['error']==2) { ?><tr>
                      <td colspan="2" align="right" class="fuente">Usted no tiene acceso al sistema</td>
                      </tr><? } ?>
                    <tr>
                      <td width="45%" align="right" class="fuente"><strong>Correo Electr&oacute;nico:</strong></td>
                      <td width="55%"><label>
                        <input name="usuario_Txt" type="text" class="fuente" id="usuario_Txt" title="Correo Electrónico" size="30"/>
                      </label></td>
                    </tr>
                    <tr>
                      <td align="right" class="fuente"><strong>Contrase&ntilde;a:</strong></td>
                      <td><input name="password_Txt" type="password" class="fuente" id="password_Txt" title="Contraseña"/></td>
                    </tr>
                    <tr>
                      <td align="right"><? include("includes/code.php"); ?>
                                  <img src="includes/generador.php?code=<? echo $codigo; ?>" width="70" height="20" /></td>
                      <td><input name="code" type="text" class="fuente" id="code" size="5" maxlength="5" title="Code"/>
                                  <input name="codigo" type="hidden" id="codigo" value="<? echo $codigo; ?>" />                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><input name="enviar" type="submit" id="enviar" onClick="MM_validateForm('usuario_txt','','RisEmail','password_txt','','R','code','','R');return document.MM_returnValue" value=" Ingresar " />                      </td>
                    </tr>
                  </table></td>
                  <td background="img/cdo_der_fnd.jpg"></td>
                </tr>
                <tr>
                  <td id="cdo_dwn_izq" height="11" width="11"></td>
                  <td id="cdo_dwn_fnd" height="11" width="360" ></td>
                  <td id="cdo_dwn_der"></td>
                </tr>
                
              </table></td>
            </tr>
          </table>
        </form>
          <br>
          <a href="recordar.php" class="linksRojo"><strong>Olvidó su contraseña?</strong></a></td>
      </tr>
    </table></td>
  </tr>
  <? include("option/footer.php"); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsOptions);
?>