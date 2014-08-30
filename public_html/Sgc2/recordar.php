<? ob_start();?>
<?php require_once('../Connections/cnx_arica.php'); ?>


<? 
	if ($_POST['usuario_Txt']!='') {

	mysql_select_db($database_cnx_arica, $cnx_arica);
	$query_rsEmail = "SELECT usuario_opc, email_opc, password_opc FROM opciones WHERE email_opc = '".$_POST['usuario_Txt']."'";
	$rsEmail = mysql_query($query_rsEmail, $cnx_arica) or die(mysql_error());
	$row_rsEmail = mysql_fetch_assoc($rsEmail);
	$totalRows_rsEmail = mysql_num_rows($rsEmail);

	if ($totalRows_rsEmail > 0) {
	$para = $row_rsEmail['email_opc'];
	$usuario = $row_rsEmail['usuario_opc'];
	$pass = $row_rsEmail['password_opc'];
	$ip = $_SERVER['REMOTE_ADDR'];
	$subject = "Recordatorio de Contrase�a";
	$header = "From: no-reply@mueblesarica.com \r\n";
	$header .= "Mime-Version: 1.0 \r\n";
	$header .= "Content-type: text/html; \r\n";
	$msg = "
	<font face=\"Arial\" size=\"2\" color=\"#333333\"><h2 face=\"Arial\" color=\"#333333\">Recordatorio de Contraseña</h2></font>
	<font face=\"Arial\" size=\"2\" color=\"#333333\">
	<p>Estimado cliente, este es un correo recordatorio de su contraseña para acceder al SGC de Muebles arica. Recuerde que debe ingresar a <a href='http://www.mueblesarica.com/Sgc'>http://www.mueblesarica.com/Sgc</a> con los siguientes datos:</p>
	<p>Correo Electrónico: <strong>$usuario</strong><br>
	Contraseña: <strong>$pass</strong></p>
	<p>IP: $ip</p>----------------------------------------------------------------------
	</font>";
		
	mail($para, $subject, $msg, $header);
	
	header("Location: enviado.php");
	
	}

}
?>
<?php

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc, soporte_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);
?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS Versión 5.0</title>
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
            Si usted necesita soporte por favor contáctese a: <a href="mailto:<?php echo $row_rsOptions['soporte_opc']; ?>" class="fuente"><strong>soporte@idw.com.pe</strong></a></p>
        </blockquote></td>
        <td width="406" align="center" class="fuente"><form id="frmLogin" name="frmLogin" method="POST" action="enviado.php">
          <table width="100%" align="center">
            <tr>
              <td width="200%" align="center"><table width="383" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="11"><img src="img/cdo_top_izq.jpg"/></td>
                  <td width="360" background="img/cdo_top_fnd.jpg"></td>
                  <td width="11"><img src="img/cdo_top_der.jpg"/></td>
                </tr>
                <tr>
                  <td background="img/cdo_izq_fnd.jpg"></td>
                  <td bgcolor="#EBEBEB"><table width="100%" >
                    <? if ($_GET['error']==2) { ?><tr>
                      <td colspan="2" align="center" class="fuente">Correo Electr&oacute;nico Invalido</td>
                      </tr><? } ?>
                    <tr>
                      <td width="45%" align="right" class="fuente"><strong>Correo Electr&oacute;nico:</strong></td>
                      <td width="55%"><label>
                        <input name="usuario_Txt" type="text" class="fuente" id="usuario_Txt" title="Correo Electrónico" size="30"/>
                      </label></td>
                    </tr>
                    <tr>
                      <td align="right"><? include("includes/code.php"); ?>
                        <img src="includes/generador.php?code=<? echo $codigo; ?>" width="70" height="20" /></td>
                      <td><input name="code" type="text" class="fuente" id="code" size="5" maxlength="5" title="Code"/>
                        <input name="codigo" type="hidden" id="codigo" value="<? echo $codigo; ?>" />                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><input name="enviar" type="submit" id="enviar" onClick="MM_validateForm('usuario_Txt','','R','code','','R');return document.MM_returnValue" value=" Ingresar " /> </td>
                    </tr>
                  </table></td>
                  <td background="img/cdo_der_fnd.jpg"></td>
                </tr>
                <tr>
                  <td><img src="img/cdo_dwn_izq.jpg" width="11" height="11"/></td>
                  <td background="img/cdo_dwn_fnd.jpg"></td>
                  <td><img src="img/cdo_dwn_der.jpg" width="11" height="11"/></td>
                </tr>
              </table></td>
            </tr>
          </table>
        </form>
          <p><a href="index.php" class="linksRojo"><strong>Volver al Inicio</strong></a></p></td>
      </tr>
    </table></td>
  </tr>
  <? include("option/footer.php"); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsOptions);

mysql_free_result($rsEmail);
?>

<? ob_flush();?>