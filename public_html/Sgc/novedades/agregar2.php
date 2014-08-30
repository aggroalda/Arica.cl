<?php session_start();?>
<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php require('../../include/funciones.php'); ?>
<?php require('../includes/funciones.php'); ?>
<? ob_start();?>
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
  $QUERY_STRING=$_SERVER['QUERY_STRING'];
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<link rel="stylesheet" type="text/css" href="../css/notificacion/notificacion.css"/>
<script type="text/javascript">
$.validator.methods.equal = function(value, element, param) {
		return value == param;
	};
	$(document).ready(function(){
				
		$("#form1").validate({
				rules: {
					nombre_Txt: "required",
					tipo_Txt: "required",
					descripcion_Txt:"required",
				},
				messages: {
					nombre_Txt: "Requerido",
					tipo_Txt: "Requerido",
					descripcion_Txt: "Requerido",
					
					}
				});
				
			
		});
		

	
// TODO ESTE CODIGO ES DE MI AUTORIA Y ES TOTALMENTE GRATIS, CON LA UNICA CONDICION DE DARME EL CREDITO DEL CODIGO.


</script>



<?
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$nivel= $_SESSION['MM_IdNivel'];
$usuario=$_SESSION['MM_IdUser'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	if ($_POST["portada"]=="1" ) {
	$portada= 1;
	
	 } else {
	$portada= 0;
	
	 }
	
	if ($_POST['radio_oferta']=="1" ) {
	$oferta= 1;
	
	 } else {
	$oferta= 0;
	
	 }

	
  $insertSQL = sprintf("INSERT INTO noticias (Titulo_Not,IdUsuario_Not,IdCategoria_Not,  Desarrollo_Not,Fecha_Not, Portada_Not ) VALUES (%s,%s,%s,%s,%s,%s)",
                     GetSQLValueString(utf8_decode($_POST['nombre_Txt']), "text"),
					 GetSQLValueString($usuario, "int"),
					 GetSQLValueString($_POST['tipo_Txt'], "int"),
                     GetSQLValueString(utf8_decode($_POST['descripcion_Txt']), "text"),
					 GetSQLValueString($_POST['fecha_Txt'], "text"),
					 GetSQLValueString($portada, "int")
					  
                      
					   );

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
  $id_not = mysql_insert_id($cnx_arica);


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOpciones = "SELECT * FROM opciones";
$rsOpciones = mysql_query($query_rsOpciones, $cnx_arica) or die(mysql_error());
$row_rsOpciones = mysql_fetch_assoc($rsOpciones);
$totalRows_rsOpciones = mysql_num_rows($rsOpciones);

if(($_SESSION['MM_IdNivel']==2)||($_SESSION['MM_IdNivel']==4)){ 

$path="http://www.arica.cl/Sgc/novedades/"; 
   
$noticiaLink=$path."ver.php?id_not=$id_not";


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCorreos = "SELECT * FROM usuarios WHERE IdNivel_Usu=5 OR IdNivel_Usu=1";
$rsCorreos = mysql_query($query_rsCorreos, $cnx_arica) or die(mysql_error());
$row_rsCorreos = mysql_fetch_assoc($rsCorreos);
$totalRows_rsCorreos = mysql_num_rows($rsCorreos);

do 
{
	$correo = $row_rsCorreos['Usern_Usu'].",";
	$correos .= $correo;
} while
($row_rsCorreos=mysql_fetch_assoc($rsCorreos));        
   // Datos del email
   
$para = $correos."anthonny2890@gmail.com";
  	$subject = "Nueva Noticia Agregada desde el Gestor";
	$header = "From: ".$row_rsOpciones['email_opc']." \r\n";
	$header .= "Mime-Version: 1.0 \r\n";
	$header .= "Content-type: text/html; charset=iso-8859-1\r\n";

 mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsImagen2 = "SELECT * FROM noticias where Id_Noticia=$id_not";
$rsImagen2 = mysql_query($query_rsImagen2, $cnx_arica) or die(mysql_error());
$row_rsImagen2 = mysql_fetch_assoc($rsImagen2);
$totalRows_rsImagen2 = mysql_num_rows($rsImagen2);

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsUser = "SELECT * FROM personas WHERE Id_Persona=".$_SESSION['MM_IdUser'];
$rsUser  = mysql_query($query_rsUser, $cnx_arica) or die(mysql_error());
$row_rsUser  = mysql_fetch_assoc($rsUser);
$totalRows_rsUser  = mysql_num_rows($rsUser);
 
if ($row_rsUser['Sexo_Per']=="Masculino"){$elola="el";$srosra="Sr";}
elseif ($row_rsUser['Sexo_Per']=="Femenino") {$elola="la";$srosra="Sra";}	
$titulo_not=utf8_encode($row_rsImagen2['Titulo_Not']);
$desarrollo_not=utf8_encode($row_rsImagen2['Desarrollo_Not']);
$desarrollo_not= truncate($desarrollo_not,300);




$msg = "<!DOCTYPE html><html><meta http-equiv='Content-Type' content='text/html; charset=utf-8'/><title>arica.cl | El verdadero portal de Arica</title><head><body>
	<h2 style='font-family:Arial; color:#333333;'>Bienvenido al Portal Web de Arica.cl</h2>
	<h3 style='font-family:Arial; color:#333333;'>Mensaje enviado desde el Sistema Gestor</h3>
	<h4>".$titulo_not."</h4>
	<p>".$desarrollo_not."</p>
	<p>Noticia agregada por $elola $srosra. ".utf8_encode($row_rsUser['Nombres_Per'])." ".utf8_encode($row_rsUser['Paterno_Per'])." ".utf8_encode($row_rsUser['Materno_Per'])."</p>
	<p align='justify'>para verla completa y realizar alguna operación debe hacer click en el siguiente enlace:</p>
	<ul>
    <li>link:".$noticiaLink."</li>
    </ul>
	<p>&nbsp;</p>
    <a href='http://www.arica.cl/'><img alt='firma' src='http://arica.cl/img/arica_firma.png' width='659' height='48' border='0'/></a></body></head></html>";
			
			
		
			mail($para, $subject, $msg, $header);
			
	if (mail) {
		$msg = "Noticia envíada correctamente, Esperar porfavor la habilitacion del editor o administrador para su publicacíon";
	
	} else {
		$msg = "Ocurrió un error al enviar intentelo más tarde.";	
	}
	?><script type="text/javascript">alert("<? echo $msg; ?>");</script><?
}

 header("Location: imagenes.php?id_not=".$id_not."&cantidad=".$_POST['cantidad_Txt']."&tipo=1");
   
	 
}


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTipo = "SELECT * FROM categoria";
$rsTipo = mysql_query($query_rsTipo, $cnx_arica) or die(mysql_error());
$row_rsTipo = mysql_fetch_assoc($rsTipo);
$totalRows_rsTipo = mysql_num_rows($rsTipo);



?>


    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
    
    <strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../novedades/index.php">M&oacute;dulo de Noticia</a> / <a id="guia_titulos"  href="#">Agregar</a></p></strong>
      <p class="titles">&raquo; M&oacute;dulo de Noticia / Agregar </p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><blockquote>
          <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
             <td width="11" height="11" id="cdo_top_izq"></td>
                  <td width="849" height="11" id="cdo_top_fnd"></td>
                  <td width="11" height="11" id="cdo_top_der"></td>
            </tr>
            <tr>
              <td background="../img/cdo_izq_fnd.jpg"></td>
              <td bgcolor="#EBEBEB"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
                <table width="100%">
                          
                  <tr>
                    <td align="right" class="fuente"><strong>T&iacute;tulo de Noticia:</strong></td>
                    <td><input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" size="50" title="Nombre de Producto"><input name="fecha_Txt" type="hidden" class="fuente" id="fecha_Txt" size="35" title="Fecha" value="<? $fecha=date('Y-m-d H:i:s');echo $fecha;?>"></td>
                  </tr>
                  
                  
                  <tr>
                    <td align="right" class="fuente"><strong>Categor&iacute;a :</strong></td>
                    <td><select name="tipo_Txt" class="fuente" id="tipo_Txt"  title="Nombre tIPO">
                   <option value="">Seleccione</option>
                    <? do {?>
                    <option value="<? echo $row_rsTipo['Id_Categoria']?>"><? echo utf8_encode($row_rsTipo['Nombre_Cat']);?></option>
                    <? }while ($row_rsTipo=mysql_fetch_assoc($rsTipo));?>
                    </select>
                    </td>
                  </tr>
                  
                
                 
                    <td height="95" align="right" valign="top" class="fuente"><strong>Descripci&oacute;n:</strong></td>
                    <td align="left"><label for="descripcion_Txt"></label>
                      <textarea name="descripcion_Txt" id="descripcion_Txt" title="Descripci&oacute;n" cols="45" rows="5"></textarea></td>
                  </tr>
         				<tr>
                    <td align="right" class="fuente"><strong>Cantidad de Im&aacute;genes:</strong></td>
                    <td align="left"><label for="cantidad_Txt"></label>
                      <select name="cantidad_Txt" id="cantidad_Txt" >
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                      </select></td>
                  </tr>
                  
                 <? if(($_SESSION['MM_IdNivel']==5) || ($_SESSION['MM_IdNivel']==1)){ ?>
                    <tr>
                      <td align="right" class="fuente"><strong>En portada:</strong></td>
                      <td align="left"><span class="fuente">
        
					<input type="checkbox" name="portada" id="portada" value="1">
  </td>
  
  
  </tr>
 
                   <?	}
			else{
				echo"";
				} ?>
                
                  
                  <tr>
                    <td colspan="2" align="center">
                      <input type="hidden" name="MM_insert" value="form1">
                      <input name="SendForm" type="submit" id="SendForm"  value=" Guardar ">
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
         <!--  <div id="content">
    <p>Este es mi Contenido Web, click para 
    <a href="javascript:sendNotify();" id="sendNotify">Mandar Notificacion</a></p>
  </div>--><span id="span"></span>
          <p><a href="javascript:cargar('noticiapagina.php','tbnoticia')" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Noticia</strong></a></p>
          
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table></td>
<script>
// TODO ESTE CODIGO ES DE MI AUTORIA Y ES TOTALMENTE GRATIS, CON LA UNICA CONDICION DE DARME EL CREDITO DEL CODIGO.

$(document).ready(function() {

function sendNotify(){
  $("#span").append("<div class='notify'><p><a href='#' class='closeNotify'>X</a><a href='#' id='p_noti'>Nueva alerta creada</a><p></div>");
}

$("#sendNotify").click(function () { 
  sendNotify();
  return false;
});


$(".closeNotify").live("click", function(){
	$(this).parent().parent().hide("slow");
	return false;
});

});
</script>



<? ob_end_flush;?>