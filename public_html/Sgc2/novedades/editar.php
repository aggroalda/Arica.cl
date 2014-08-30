<?php require_once('../../Connections/cnx_arica.php'); ?>
<? ob_start(); ?>
<?php require('../../include/funciones.php'); ?>
<?php require('../includes/funciones.php'); ?>
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
  $QUERY_STRING=$_SERVER['QUERY_STRING'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?> 
<?
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

	if($_POST['portada']==1 ) {
	$portada= 1;
	
	 } else {
	$portada= 0;
	
	 }
	
	if($_POST['estado_Txt']==1 ){
		$estado=1;
		}else{
			$estado=0;
			
			}
		
		
		
	$image = $_FILES['foto_Txt']['name'];	
	$image2 = $_POST['foto_Ext'];
	
	if($image!=""){
        $imagen = $_FILES['foto_Txt']['name'];
	    $tempora = $_FILES['foto_Txt']['tmp_name'];
		}/* fin de  image!=""*/ 
	
		if ($imagen) { // si el campo de foto tiene contenido
		
			$ext = strtolower(substr($image, -3));
			if (($ext == "jpg") || ($ext == "gif")) { // si la imagen es jpg
			if (move_uploaded_file($tempora, "../../novedades/img/".$imagen)) { // intentamos guardar la imagen en el servidor
				  if (file_exists("../../novedades/img/".$image2)) {
			  unlink("../../novedades/img/".$image2);}
			
				    list($ancho, $alto, $tipo, $atr) = getimagesize("../../novedades/img/".$imagen);
						$file = "../../novedades/img/".$imagen;
						$width = 400;
						$height = ($alto/$ancho)*400;
							if ($ext=="jpg") {
							$imSrc  = imagecreatefromjpeg($file);
							}
							if ($ext=="gif") {
							$imSrc  = imagecreatefromgif($file);
							}

						$w      = imagesx($imSrc);
						$h      = imagesy($imSrc);
						
							if($width/$height>$w/$h) {
								$nh = ($h/$w)*$width;
								$nw = $width;
							} else {
								$nw = ($w/$h)*$height;
								$nh = $height;
							}
						
						$dx = ($width/2)-($nw/2);
						$dy = ($height/2)-($nh/2);
						$imTrg  = imagecreatetruecolor($width, $height);
						imagecopyresampled($imTrg, $imSrc, 0, 0, 0, 0, $width, $height, $w, $h);
							if ($ext=="jpg") { 
							imagejpeg($imTrg, $file);
							}
							if ($ext=="gif") { 
							imagegif($imTrg, $file); 
							}
				}  // fin de que si no se pudo guardar en el servidor la imagen 
			}  // fin de si la imagen no es jpg
	  	  } // fin de si la foto tiene contenido
	 
	  else{
	  	$imagen = $image2;
		}

	$updateSQL = sprintf("UPDATE noticias SET IdCategoria_Not=%s, Titulo_Not=%s,  Desarrollo_Not=%s, Fecha_Not=%s, Estado_Not=%s, Portada_Not=%s  WHERE Id_Noticia=%s" ,
	 					 GetSQLValueString(utf8_decode($_POST['tipo_Txt']), "int"),
                       GetSQLValueString(utf8_decode($_POST['titulo_Txt']), "text"),
						GetSQLValueString(utf8_decode($_POST['desarrollo_Txt']), "text"),
                       GetSQLValueString($_POST['fecha_Txt'], "text"),
					   GetSQLValueString(isset($_POST['estado_Txt']) ? "true" : "", "defined","1","0"),
					   GetSQLValueString(isset($_POST['portada']) ? "true" : "", "defined","1","0"),
					    GetSQLValueString($_POST['id_not'], "int")
						
						);

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL, $cnx_arica) or die(mysql_error());
  
$updateGoTo = "ver.php?id_not=".$_POST['id_not'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  										}
										
if(($_SESSION['MM_IdNivel']==2)||($_SESSION['MM_IdNivel']==4)){ 
session_start();

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOpciones = "SELECT * FROM opciones";
$rsOpciones = mysql_query($query_rsOpciones, $cnx_arica) or die(mysql_error());
$row_rsOpciones = mysql_fetch_assoc($rsOpciones);
$totalRows_rsOpciones = mysql_num_rows($rsOpciones);

$id_not=$_POST['id_not'];

$path="http://www.arica.cl/Sgc/novedades/"; 
   
$noticiaLink=$path."ver.php?id_not=$id_not";

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCorreos = "SELECT * FROM usuarios WHERE IdNivel_Usu=5 OR IdNivel_Usu=1";
$rsCorreos = mysql_query($query_rsCorreos, $cnx_arica) or die(mysql_error());
$row_rsCorreos = mysql_fetch_assoc($rsCorreos);
$totalRows_rsCorreos = mysql_num_rows($rsCorreos);do 
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
	<p>Noticia editada por $elola $srosra. ".utf8_encode($row_rsUser['Nombres_Per'])." ".utf8_encode($row_rsUser['Paterno_Per'])." ".utf8_encode($row_rsUser['Materno_Per'])."</p>
	<p align='justify'>para ver la noticia completa y realizar alguna operación debe hacer click en el siguiente enlace:</p>
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
										
  header(sprintf("Location: %s", $updateGoTo));

}  /*fin de post update */ 




mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_Opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$colname_rsNoticias = "-1";
if (isset($_GET['id_not'])) {
  $colname_rsNoticias = $_GET['id_not'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsNoticias = sprintf("SELECT * FROM noticias,categoria WHERE noticias.IdCategoria_Not=categoria.Id_Categoria AND noticias.Id_Noticia = %s", GetSQLValueString($colname_rsNoticias, "int"));
$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
$totalRows_rsNoticias = mysql_num_rows($rsNoticias);

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTipo = "SELECT * from categoria";
$rsTipo = mysql_query($query_rsTipo, $cnx_arica) or die(mysql_error());
$row_rsTipo = mysql_fetch_assoc($rsTipo);
$totalRows_rsTipo = mysql_num_rows($rsTipo);



?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<link href="../css/CalendarControl.css" rel="stylesheet" type="text/css">
<script src="../js/CalendarControl.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
<!--
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
//-->
</script>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript">
$.validator.methods.equal = function(value, element, param) {
		return value == param;
	};
	$(document).ready(function(){
				
		$("#form1").validate({
				rules: {
					titulo_Txt: "required",
					tipo_Txt: "required",
					desarrollo_Txt:"required",
				},
				messages: {
					titulo_Txt: "Requerido",
					tipo_Txt: "Requerido",
					desarrollo_Txt: "Requerido",
					
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
    	<strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../novedades/index.php">M&oacute;dulo de Noticia</a> / <a id="guia_titulos" href="#">Editar</a></p></strong>
      <p class="titles">&raquo; M&oacute;dulo de Noticia / Editar</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><blockquote>
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
            <td width="11" height="11" id="cdo_top_izq"></td>
            <td width="1003" height="11" id="cdo_top_fnd"></td>
            <td  width="11" height="11" id="cdo_top_der"></td>
            </tr>
            <tr>
              <td background="../img/cdo_izq_fnd.jpg"></td>
              <td bgcolor="#EBEBEB"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
                <table width="100%">
                  <tr>
                    <td width="37%" align="right" class="fuente"><strong>T&iacute;tulo de la Novedad:</strong></td>
                    <td width="63%">
                      <input name="titulo_Txt" type="text" class="fuente" id="titulo_Txt" title="Titulo de la Novedad" value="<?php echo utf8_encode($row_rsNoticias['Titulo_Not']); ?>" size="60">
                      <input name="id_not" type="hidden" id="id_not" value="<?php echo utf8_encode($row_rsNoticias['Id_Noticia']); ?>"><input name="fecha_Txt" type="hidden" class="fuente" id="fecha_Txt" size="35" title="Fecha" value="<? $fecha=date('Y-m-d H:i:s');echo $fecha;?>"></td>
                  </tr>
                  
                  <tr>
                    <td align="right" class="fuente"><strong>Tipo de Noticia:</strong></td>
                    <td>
                    <select name="tipo_Txt" class="fuente" id="tipo_Txt" >
                    <? do {?>
                    <option value="<?php echo $row_rsTipo['Id_Categoria']?>" 
					<?php if (!(strcmp($row_rsTipo['Id_Categoria'], $row_rsNoticias['Id_Categoria']))) {echo "selected=\"selected\"";} ?>>
                    
                     <? echo utf8_encode($row_rsTipo['Nombre_Cat']);?> 
                    
                    </option>
                    <? }while ($row_rsTipo=mysql_fetch_assoc($rsTipo));
					
					
						$rows = mysql_num_rows($rsTipo);
 							 if($rows > 0) {
						  mysql_data_seek($rsTipo, 0);
						  $row_rsTipo = mysql_fetch_assoc($rsTipo);
					  }
					?>
                    </select>
               
               
               
                </td>
                  </tr>
                  
                  
                  
                  <tr>
                    <td align="right" valign="top" class="fuente"><strong>Desarrollo:</strong></td>
                    <td>
                      <textarea name="desarrollo_Txt" cols="50" rows="15" class="fuente" id="desarrollo_Txt" title="Desarrollo"><?php echo utf8_encode($row_rsNoticias['Desarrollo_Not']); ?></textarea>
                    </td>
                  </tr>
                  
                  
                                    
                     <? if(($_SESSION['MM_IdNivel']==5) || ($_SESSION['MM_IdNivel']==1)){  ?>
                  <tr>
                    <td align="right" class="fuente"><strong>Estado:</strong></td>
                    <td align="left">
                      <input <?php if (!(strcmp($row_rsNoticias['Estado_Not'],1))) {echo "checked=\"checked\"";} ?> name="estado_Txt" type="checkbox" id="estado_Txt" value="1">
                    </td>
                  </tr>
                  
                  
                   <tr>
                      <td align="right" class="fuente"><strong>En portada:</strong></td>
                      <td align="left"><span class="fuente">
        
					<input <?php if (!(strcmp($row_rsNoticias['Portada_Not'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="portada" id="portada" value="1" >
  </span></td>
  
  </tr>
                   <?	}
			else{
				echo"";
				} ?>
                  
                  
                  <tr>
                    <td colspan="2" align="center">
                      <input type="hidden" name="MM_update" value="form1">
                      <input name="SendForm" type="submit" id="SendForm" value=" Guardar ">
                      </td>
                  </tr>
                </table>
              </form></td>
              <td id="cdo_der_fnd" width="14"></td>
            </tr>
            <tr>
             <td id="cdo_dwn_izq" height="11" width="11"></td>
            <td id="cdo_dwn_fnd" height="11" width="1003"></td>
            <td id="cdo_dwn_der" height="11" width="11"></td>
            </tr>
          </table>
          <p><a href="index.php" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Noticia</strong></a></p>
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

mysql_free_result($rsNoticias);

mysql_free_result($rsTipo);

ob_end_flush;

?>


 