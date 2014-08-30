<?php require_once('../Connections/cnx_arica.php'); ?>
<?php require_once('../include/header.php'); ?>
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


/*$fecnacimiento_text= convertir_fecha($fecnacimiento_text,'-','dma');

Function convertir_fecha($fecha,$separador='/',$formato='mda'){
 // el separador se podria obtener como el unico caracter no-numerico de la fecha

 $p  = explode ($separador,$fecha);
 $dd =   $p[strpos($formato,'d')];
 $mm =   $p[strpos($formato,'m')];
 $aaaa = $p[strpos($formato,'a')];
 
  
 if (strlen($dd)<2) $dd="0$dd";
 if (strlen($mm)<2) $mm="0$mm"; 
 
 $fecha = trim("$aaaa-$mm-$dd"); 
 return ($fecha);
}
*/


list($dia, $mes, $year) = split('[/.-]', $_POST['fecnacimiento_text']);
	$fecha = "$year-$mes-$dia";

	
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	//añadimos la funcion que se encargara de generar un numero aleatorio
function genera_random($longitud){ 
    $exp_reg="[^A-Z0-9]"; 
    return substr(eregi_replace($exp_reg, "", md5(rand())) . 
       eregi_replace($exp_reg, "", md5(rand())) . 
       eregi_replace($exp_reg, "", md5(rand())), 
       0, $longitud); 
}

	   //agregamos la variable $activate que es un numero aleatorio de 
                  //20 digitos crado con la funcion genera_random de mas arriba
                  
                  $activate = genera_random(20);  
                  
                  //aqui es donde insertamos los nuevos valosres en la BD  activate y el valor 1 que es desactivado
$insertSQL = sprintf("INSERT INTO personas (Nombres_Per, Paterno_Per, Materno_Per, FechaNac_Per, Sexo_Per, IdDocumento_Per, NumeroDoc_Per, Ciudad_Per, Direccion_Per, Telefono_Per) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString(utf8_decode($_POST['nombres_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['paterno_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['materno_Txt']), "text"),
					   GetSQLValueString($fecha, "date"),
					   GetSQLValueString($_POST['sexo_text'], "text"),
                       GetSQLValueString($_POST['tipodoc_Txt'], "int"),
                       GetSQLValueString($_POST['numerodoc_Txt'], "text"),
                       GetSQLValueString($_POST['ciudad_Txt'], "text"),
                       GetSQLValueString($_POST['direccion_Txt'], "text"),
                       GetSQLValueString($_POST['telefono_Txt'], "text")
					    );
					  
  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());

  $id_persona = mysql_insert_id($cnx_arica);
 $nivel=3;
  include("../include/pass.php");
 
$insert = 
"INSERT INTO usuarios(IdNivel_Usu,IdPersona_Usu,Usern_Usu,Passw_Usu,Activar_Usu) 
 VALUES (".$nivel.",".$id_persona.",'".$_POST['usuario2_Txt']."','$codigo','$activate')";
    
  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insert, $cnx_arica) or die(mysql_error());  

  $id_persona = mysql_insert_id($cnx_arica);

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsMensaje = "SELECT * FROM mensaje";
$rsMensaje = mysql_query($query_rsMensaje, $cnx_arica) or die(mysql_error());
$row_rsMensaje = mysql_fetch_assoc($rsMensaje);
$totalRows_rsMensaje = mysql_num_rows($rsMensaje);

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOpciones = "SELECT * FROM opciones";
$rsOpciones = mysql_query($query_rsOpciones, $cnx_arica) or die(mysql_error());
$row_rsOpciones = mysql_fetch_assoc($rsOpciones);
$totalRows_rsOpciones = mysql_num_rows($rsOpciones);
 $username=$_POST['usuario2_Txt'];
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsUser= "SELECT * FROM usuarios WHERE Usern_Usu='$username'";
$rsUser = mysql_query($query_rsUser, $cnx_arica) or die(mysql_error());
$row_rsUser = mysql_fetch_assoc($rsUser);
$totalRows_rsUser = mysql_num_rows($rsUser);

        
         $path="http://arica.cl/registro/"; 
		 //creamos nuestra direccion, con las carpetas que sean si hay
         //armamos nuestro link para enviar por mail en la variable $activateLink
$activateLink=$path."activar_registro.php?id=".$row_rsUser['Id_Usuario']."&activateKey=".$activate."";
                
                          // Datos del email

/*$nivel=$_POST['nivel_Txt'];*/
	$para = $_POST['usuario2_Txt'].",".$row_rsOpciones['email_opc'];
  $subject = $row_rsMensaje['tituloMensaje'];
	$header = "From: ".$row_rsOpciones['email_opc']." \r\n";
	$header .= "Mime-Version: 1.0 \r\n";
	$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
	/*
	if($nivel==3){
	$msg = "
	<h2 style='font-family:Arial; color:#333333;'>Bienvenido al Portal Web de Arica.cl</h2>
	<div style='font-size=10px; font-weight:bold; font-family:Arial; color:#C00;'>Por favor no responda este mensaje automático.</div><br>
	<span style='font-size=12px; font-family:Arial; color:#333333;'>
	 </br>
	<p>".$row_rsMensaje['DescripMensaje']."</p>
	<p>Usuario: <strong>$para</strong><br>
	Contrase&ntilde;a: <strong>$codigo</strong></p>
	<p>Ingrese a: <a href='http://www.arica.cl'>http://www.arica.cl</a> . Si tiene alguna duda por favor escriba a aricacl@hotmail.com<br>
	_________________________________________________________________</p>
	Atentamente,<BR><BR>
	La Administración<BR>
	arica<BR>
	Av. San Martín 558 - Arica - Chile<br>
	Teléfonos: +5152 414291 | Fax: +5152 425782<br>
	<img src='http://www.arica.cl/img/logotipo.gif'>
	</span>";
		}
		
		if($nivel==2){
	$msg = "
	<h2 style='font-family:Arial; color:#333333;'>Bienvenido al arica.cl El Verdadero Portal de Arica</h2>
	<div style='font-size=10px; font-weight:bold; font-family:Arial; color:#C00;'>Por favor no responda este mensaje automático.</div><br>
	<span style='font-size=12px; font-family:Arial; color:#333333;'>
	Estimado escritor del Arica cl, para ingresar al Sistema deberá ingresar a <a href='http://www.arica.cl/Sgc'>www.arica.cl/Sgc</a> e introducir su Usuario y Contraseña siguiente:
	</br>
	<p>".$row_rsMensaje['DescripMensaje']."</p>
	<p>Usuario: <strong>$para</strong><br>
	Contrase&ntilde;a: <strong>$codigo</strong></p>
	<p>Ingrese a: <a href='http://www.arica.cl/Sgc'>www.arica.cl/Sgc</a> .
	 Si tiene alguna duda por favor escriba a aricacl@hotmail.com<br>
	_________________________________________________________________</p>
	Atentamente,<BR><BR>
	La Administración<BR>
	 arica<BR>
	Av. San Martín 558 - Arica - Chile<br>
	Teléfonos: +5152 414291 | Fax: +5152 425782<br>
		<img src='http://www.arica.cl/img/logotipo.gif'>
	</span>";
		}
		
		
	if($nivel==1){
	$msg = "
	<h2 style='font-family:Arial; color:#333333;'>Bienvenido al arica.cl El Verdadero Portal de Arica</h2>
	<div style='font-size=10px; font-weight:bold; font-family:Arial; color:#C00;'>Por favor no responda este mensaje automático.</div><br>
	<span style='font-size=12px; font-family:Arial; color:#333333;'>
	Estimado Administrador del arica.cl, para ingresar al Sistema  vaya a <a href='http://www.arica.cl/Sgc'>www.arica.cl/Sgc</a> e introduzca su Usuario y Contraseña siguiente:
	</br>
	<p>".$row_rsMensaje['DescripMensaje']."</p>
	<p>Usuario: <strong>$para</strong><br>
	Contrase&ntilde;a: <strong>$codigo</strong></p>
	<p>Ingrese a: <a href='http://www.arica.cl/Sgc'>www.arica.cl/Sgc</a> .
	 Si tiene alguna duda por favor escriba a admin@arica.cl<br>
	_________________________________________________________________</p>
	Atentamente,<BR><BR>
	La Administración<BR>
	Arica cl <BR>
	Av. 558 - Arica - Chile<br>
	Teléfonos: +5152 414291 | Fax: +5152 425782<br>
	<img src='http://www.arica.cl/img/logotipo.gif'>
	</span>";
		}else{
			*/
			
			$msg = "<!DOCTYPE html><html><meta http-equiv='Content-Type' content='text/html; charset=utf-8'/><title>arica.cl | El verdadero portal de Arica</title><head><body>
			<p>Sr(a).".utf8_decode($_POST['nombres_Txt'])." ".utf8_decode($_POST['paterno_Txt'])." ".utf8_decode($_POST['materno_Txt'])."</p>
			<h2 style='font-family:Arial; color:#333333;'>Bienvenido al Portal Web de Arica.cl</h2>
	<h3 style='font-family:Arial; color:#333333;'>".$row_rsMensaje['tituloMensaje']."</h3>
	<p align='justify'>".$row_rsMensaje['DescripMensaje']."</p>
	<ul>
    <li style='list-style:upper-roman;'>Su Usuario: <strong>".$_POST['usuario2_Txt']."</strong></li>
	<li style='list-style:upper-roman;'>Su Contrase&ntilde;a: <strong>$codigo</strong></li>
    <li style='list-style:upper-roman;'>Su link de activaci&oacute;n:".$activateLink."</li>
    </ul>
    <p align='justify'>Por favor haga click en el link de arriba para activar su cuenta y acceder a la p&aacute;gina sin restricciones.</p>
    Gracias por Registrarse en <a href='http://www.arica.cl'>http://arica.cl</a></p>
    <p>Si tiene alguna duda por favor escriba a webmaster@arica.cl</p>
	<a href='http://www.arica.cl/'><img alt='firma' src='http://arica.cl/img/arica_firma.png' width='659' height='48' border='0'/></a></body></head></html>";
			
			
		
			mail($para, $subject, $msg, $header);
			
	if (mail) {
		/*$msg = "Inscripción realizada con éxito";*/
		/*header('Location: pasofinal.php');*/
		echo "<script language='javascript'>
			document.location.href='pasofinal.php';
		  </script>";
	
	} else {
		$msg = "Ocurrió un error al enviar intentelo más tarde.";	
	}
	

	/*echo "<script language='javascript'>
			alert(\"".$msg."\");
			document.location.href='index.php';
		  </script>";*/

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
$totalRows_rsDocumento = mysql_num_rows($rsDocumento);?>
<?
?>

<?php 

if($_SESSION['MM_IdPersona']!=NULL){$id_per=$_SESSION['MM_IdPersona'];}
if($_SESSION['MM_IdNivel']){;$nivel=$_SESSION['MM_IdNivel'];}
?>
<? mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsNoticias = "SELECT *  FROM noticias where Estado_Not= 1 ORDER BY Id_Noticia DESC";
$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
$totalRows_rsNoticias = mysql_num_rows($rsNoticias);
?>

	<div id="cuerpo">
    <div class="principal" id="principal">  
    <div id="page"><div id="titulo_buscar_div">
    <h1 id="titulo_buscar">BUSCADOR</h1></div>
         <div id="resultsDiv"></div>
     </div>
     <div id="accion_ocultar">
<div>
      <div>

	<div id="titulo_registro"> Formulario de Registro</div> 
    <div id="sub_titulo"> 
      <p>Registrese en nuestra web y se le enviara a su correo su cuenta para acceder a nuestro sistema.</p>
      <p>&nbsp;<div>
      
    <?php /*?>  <div id="fb-root"></div>
<script src="http://connect.facebook.net/es_LA/all.js"></script>
<script type="text/javascript">
    FB.init({appId: '358461087574712', status: true, cookie: true, xfbml: true});
</script>
<script type="text/javascript">
FB.getLoginStatus(function(response) { get_fb_user_data(response); });

FB.Event.subscribe('auth.login', function(response) { get_fb_user_data(response); });
</script>
<script type="text/javascript"> 
function get_fb_user_data(response){ 
    if (response.session) { 
        // logged in and connected user, someone you know 
        var uid = response.session.uid; 

        FB.api(uid, function(response) { 
            set_fb(document.forms.WBForm.Name, response.first_name); 
            set_fb(document.forms.WBForm.Surname, response.last_name); 
            set_fb(document.forms.WBForm.Email, response.email); 
            var birthdate = get_fb(response.birthday); 
			document.getElementById('nombres_Txt').value='sdasd'+birthdate;
            birthdateSplit = birthdate.split('/'); 
            set_fb(document.forms.WBForm.BirthDate, birthdateSplit[1]+'/'+birthdateSplit[0]+'/'+birthdateSplit[2]); 
      
		
	 //Envio las variables al archivo mi_php.php
$.post("mi_php.php",{Name:Name, Surname:Surname, Email:Email, BirthDate:BirthDate},function(respuesta){
alert("respuesta"); //Mostramos un alert del resultado devuelto por el php
});



	    }); 
    } else { 
        // no user session available, someone you dont know 
    } 
} 


function set_fb(elem, fb_elem){ 
    if (elem){ 
            if (elem.value == '' || (elem.value == '01/01/0001')){ 
                elem.value = get_fb(fb_elem); 
            } 
    } 
} 

function get_fb(elem){ 
    if (elem){ 
        if (typeof(elem) != 'undefined'){ 
            if (elem != 'undefined') { 
            return elem; 
            } 
        } 
    } 

    return ''; 
} 


</script>
<fb:login-button autologoutlink="true"></fb:login-button> <?php */?>
      </div></p>
    </div>
    
    
     <div id="fondo_registro">
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1" >
                           
  <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:12px;">
      
                  <tr>
                    <td width="43%" align="right" class="fuente2"><strong >Usuario / Correo Electr&oacute;nico:</strong></td>
                    <td width="57%" ><input name="usuario2_Txt" type="text" class="fuente" id="usuario2_Txt" size="35" style="float:left;" onBlur="verifyuser(0)"><div id="dvResultado"></div></td>
                  </tr>
                
                  <tr>
                    <td class="fuente2" align="right"  height="30px"><strong>Nombres:</strong></td>
                   <td align="left"   height="20px"><input name="nombres_Txt" type="text" class="fuente" id="nombres_Txt"></td>
                  
                  </tr>
                  <tr>
                    <td class="fuente2" align="right"   height="30px"><strong>Apellido Paterno:</strong></td>
                    <td align="left"   height="30px"><input name="paterno_Txt" type="text" class="fuente" id="paterno_Txt"></td>
                  </tr>
                  <tr>
                    <td class="fuente2" align="right"   height="30px"><strong>Apellido Materno:</strong></td>
                    <td align="left"  height="30px"><input name="materno_Txt" type="text" class="fuente" id="materno_Txt"></td>
                    
                  </tr>
                  
                   <tr>
                    <td class="fuente2" align="right" height="30px"><strong>Fecha de Nacimiento:</strong></td>
                    <td align="left"  height="30px"><input name="fecnacimiento_text" type="text" class="fuente" id="fecha_Txt" onFocus="showCalendarControl(this);"></td>
                    
                  </tr>
                  
                   <tr>
                    <td class="fuente2" align="right"  height="30px"><strong>Sexo:</strong></td>
                    <td align="left"  height="30px"><select name="sexo_text" class="fuente" id="sexo_text">
                    <option value="">-- Seleccione --</option>
                    <option>Masculino</option>
                    <option>Femenino</option>
                    </select>
                    </td>
                    
                  </tr>
                  
                  <tr>
                    <td align="right" class="fuente2"  height="30px"><strong>Tipo de Documento:</strong></td>
                    <td align="left"  class="fuente2" height="30px">
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
                    <td align="right" class="fuente2" height="30px"><strong>N&uacute;mero de Documento:</strong></td>
                    <td align="left" class="fuente2" height="30px"><input name="numerodoc_Txt" type="text" class="fuente" id="numerodoc_Txt" style="float:left;" onBlur="verifydni(0);"><div id="divDNI"></div></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente2" height="30px"><strong>Ciudad:</strong></td>
                    <td align="left"  height="30px"><input name="ciudad_Txt" type="text" class="fuente" id="ciudad_Txt" onKeyPress="ocultar('divDNI');"></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente2" height="30px"><strong>Direcci&oacute;n:</strong></td>
                    <td align="left"  height="30px"><input name="direccion_Txt" type="text" class="fuente" id="direccion_Txt"size="35"></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente2" height="30px"><strong>Tel&eacute;fono:</strong></td>
                    <td align="left"  height="30px"><input name="telefono_Txt" type="text" class="fuente" id="telefono_Txt" /></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"  height="30px">
                      <input type="hidden" name="MM_insert" value="form1">
                      <input name="SendForm" type="submit" id="SendForm" value=" Guardar "/></td>
                  </tr>
          </table>
           </form> 
           </div>
          <br />         

</table>
      </div>
 
 </div></div>
 
        </div>
        
      	<div class="lateral margen_arriba_contacto">
        <? include('../include/lateral.php')?>
           </div>
    </div>
     <? include('../include/pie_pagina.php')?>
</div>
</body>
</html>
