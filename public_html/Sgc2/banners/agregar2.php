<?php require_once('../../Connections/cnx_arica.php'); ?>
<? ob_start();?>
<?php

include('../includes/salida2.php');
include('../includes/restriccion2.php');
 include('../includes/funciones.php');
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsBanners = sprintf("SELECT MAX(Id_Banner) as 'maxban' FROM banners;");
$rsBanners = mysql_query($query_rsBanners, $cnx_arica) or die(mysql_error());
$row_rsBanners = mysql_fetch_assoc($rsBanners);
$ultimo= $row_rsBanners['maxban']+1;



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	if ($_POST['radio']==1) {
	
	$image = $_FILES['archivo_Txt']['name'];
	
	$tempora = $_FILES['archivo_Txt']['tmp_name'];
	$ubicacion = "../clasificados/img/";
	$tamaño =$_POST['ubicacion_Txt'];

	if ($tamaño == 1){ 
	$width = 245;
	} 
		if ($tamaño == 2){ 
	$width = 470;
	$height= 50;
	} 
		if ($tamaño == 3){ 
	$width = 700;
	$height= 90;
	} 
	

if ($image) { // si el campo de foto tiene contenido
		
			$ext = strtolower(substr($image, -3));
			
			if ($ext == "jpg" || ($ext == "gif") || ($ext == "png")) { // si la imagen es jpg
			 if(file_exists($ubicacion.$image))
  			  {  
       			 $nombre = $ultimo.$image;
   				 }
           else {$nombre= $image;
			   }
   			if (move_uploaded_file($tempora, $ubicacion.$nombre)) { // intentamos guardar la imagen en el servidor
				list($ancho, $alto, $tipo, $atr) = getimagesize("../clasificados/img/".$nombre);
					$file = "../clasificados/img/".$nombre;
				if ($ext=="jpg") {
							$imSrc  = imagecreatefromjpeg($file);
							}
							if ($ext=="gif") {
							$imSrc  = imagecreatefromgif($file);
							}
							
							if ($ext=="png") {
							$imSrc  = imagecreatefrompng($file);
							}	

						$w = imagesx($imSrc);
						$h = imagesy($imSrc);
					if ($tama�o==1){$height=$h;}
				$imTrg  = imagecreatetruecolor($width, $height);
						imagecopyresampled($imTrg, $imSrc, 0, 0, 0, 0, $width, $height, $w, $h);
							if ($ext=="jpg") { 
							imagejpeg($imTrg, $file);
							}
							if ($ext=="gif") { 
							imagegif($imTrg, $file); 
							}
							if ($ext=="png") { 
							imagepng($imTrg, $file); 
							}
							
				
							
							
							
				
				}  // fin de que si no se pudo guardar en el servidor la imagen 
			
		}  // fin de si la imagen no es jpg
	}
	 $insertSQL = sprintf("INSERT INTO banners (Titulo_Ban, Ubicacion_Ban, Archivo_Ban,Url_Ban) VALUES (%s, %s, %s,%s)",
                       GetSQLValueString(utf8_decode($_POST['nombre_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['ubicacion_Txt']), "int"),
                       GetSQLValueString(utf8_decode($nombre), "text"),
					   GetSQLValueString(utf8_decode($_POST['url_Txt']), "text"));
					     mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
  $id_ban=mysql_insert_id($cnx_arica);
	 header("Location: ver.php?id_ban=".$id_ban);
					   
	}
	
	if ($_POST['radio']==2) {

		
		
		$video=$_POST['video_Txt'];
		 $insertSQL = sprintf("INSERT INTO banners (Titulo_Ban, Ubicacion_Ban, Archivo_Ban) VALUES (%s, %s, %s)",
                       GetSQLValueString(utf8_decode($_POST['nombre_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['ubicacion_Txt']), "int"),
                       GetSQLValueString(utf8_decode($video), "text"));
		  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
  $id_ban=mysql_insert_id($cnx_arica);
	 header("Location: ver.php?id_ban=".$id_ban);
		
		}
		
	if ($_POST['radio']==3) {
		$swf = $_FILES['swf_txt']['name'];
		$tempora = $_FILES['swf_txt']['tmp_name'];	
/*	$directorio_swf=$swf['name'];
	$directorio_swf.=time();
	define("RUTA_SWF","swf/");
	chmod($swf['tmp_name'],0777);
	move_uploaded_file($swf["tmp_name"], RUTA_SWF);*/

		$ubicacion="../../banners/swf/".$swf;
		move_uploaded_file($tempora, $ubicacion);
		 $insertSQL = sprintf("INSERT INTO banners (Titulo_Ban, Ubicacion_Ban, Archivo_Ban) VALUES (%s, %s, %s)",
                       GetSQLValueString(utf8_decode($_POST['nombre_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['ubicacion_Txt']), "int"),
                       GetSQLValueString(utf8_decode($ubicacion), "text"));
		  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
  $id_ban=mysql_insert_id($cnx_arica);
	 header("Location: ver.php?id_ban=".$id_ban);
		
		
		
		}	


}

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$colname_rsUbicacion = "-1";
if (isset($_GET['id_ban'])) {
  $colname_rsUbicacion = $_GET['id_ban'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsUbicacion = sprintf("SELECT * FROM banners where Id_Banner= %s", GetSQLValueString($colname_rsUbicacion, "int"));
$rsUbicacion = mysql_query($query_rsUbicacion, $cnx_arica) or die(mysql_error());
$row_rsUbicacion = mysql_fetch_assoc($rsUbicacion);
$totalRows_rsUbicacion = mysql_num_rows($rsUbicacion);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">

<script src="../js/jquery-1.5.1.min.js" type="text/javascript" language="javascript"></script>
<script src="../js/jquery.validate.min.js" type="text/javascript" language="javascript"></script>

<script src="../js/ajax.js" type="text/javascript" ></script>
<script type="text/javascript">
$.validator.methods.equal = function(value, element, param) {
		return value == param;
	};
	$(document).ready(function(){
				
		$("#form1").validate({
				rules: {
					ubicacion_Txt: "required",
					nombre_Txt: "required",
					
					
				},
				messages: {
					ubicacion_Txt: "Requerido",
					nombre_Txt: "Requerido",
					
					
					}
			});
	});
	
	
	function imagenovideo(){
		
		if (document.getElementById('imagenovideo').value=="1"){
			mostrar('imagen');
			
			}
		else {
			mostrar('video');
			}
		}
</script>



<script type="text/javascript">
function verificarembed(){
	var frame= document.getElementsByTagName("iframe");
	if (frame.readyState == "complete"){

alert("Iframe is now loaded.");
return true
}	else {return false}
	}
</script>
<?




?>

<? // preg_match('/^<iframe (?<width_height>width="[[:digit:]]+" height="[[:digit:]]+") src=(?P=url) allowFullScreen><\/iframe>$/', $yt);


?>
</head>
<body>
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
    	<strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../banners/index.php">M&oacute;dulo de Banners</a> / <a href="#" id="guia_titulos">Agregar</a></p></strong>
      <p class="titles">&raquo; M&oacute;dulo de Banners / Agregar</p>
    </blockquote><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                  <td colspan="2">
                   <p id="parrafo_banners">&raquo; Se recomienda que el tamaño de los banners sea de las siguientes proporciones:
                  <ul id="ul_banners">
                  <li id="list_deco">Derecha [245px de ANCHO x 180px de ALTO]</li>
                  <li id="list_deco">Izquierda Medio [470px de ANCHO x 50px de ALTO]</li>
                  <li id="list_deco">Izquierda Abajo [700px de ANCHO x 90px de ALTO]</li>
                  </ul>
                  </p>
                  </td>
                  </tr>
                  
                  <tr>
                       <td width="37%" align="right" class="fuente"><strong>Ubicaci&oacute;n:</strong></td>
                    <td width="63%">
                      <select name="ubicacion_Txt" class="fuente" id="ubicacion_Txt" onChange= "nombre_Txt.focus()" title="Tamaño de Banner">
                        <option value="">-- Elegir --</option>
                        <option value="1">Derecha [245px de ANCHO x 180px de ALTO]</option>
                         <option value="2">Izquierda Medio [470px de ANCHO x 50px de ALTO]</option>
                          <option value="3">Izquierda Abajo [700px de ANCHO x 90px de ALTO]</option>
                       </select></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Nombre del Banner:</strong></td>
                    <td><input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" title="Nombre de Banner" size="40"></td>
                  </tr>
                  
                   <tr>
                    <td align="right" class="fuente"><strong>Imagen o video:</strong></td>
                    <td class="fuente" align="left">
                      <input name="radio" type="radio" class="fuente" id="imagenovideo" onClick="mostrar('imagen');ocultar('video');ocultar('swf')" value="1" title="Archivo de Imagen">Imagen
                      <input name="radio" type="radio" class="fuente" id="imagenovideo2" onClick="mostrar('video');ocultar('imagen');ocultar('swf')" value="2" title="Video">Video  
 <input name="radio" type="radio" class="fuente" id="imagenovideo3" onClick="mostrar('swf');ocultar('imagen');ocultar('video');" value="3" title="Swf">Swf</td>
                      
                  </tr>
                 <tbody id="imagen" style="display:none">
                  <tr>
                    <td align="right" class="fuente"><strong>Imagen:</strong></td>
                    <td align="left" >
                      <input name="archivo_Txt" type="file" class="fuente" id="archivo_Txt"  title="Archivo de Imagen" onChange=" imagenval(this.id)">
                      
                     
                    </td>
                  </tr>
                  <tr>
                  <td class="fuente" align="right"><strong>Url de Imagen:</strong></td><td>  <input name="url_Txt" type="text" class="fuente" id="url_Txt"  title="Url de Imagen" size="50" ></td>
                  </tr>
                  </tbody>
                  
                  
                  <tbody id="video" style="display:none">
                      <tr>
                    <td align="right" class="fuente"><strong>Url de Video:</strong></td>
                    <td align="left" >
                      <textarea name="video_Txt" class="fuente" id="video_Txt"  cols="45" rows="3"title="Video" onClick="this.select()" value="" 
                    <? // parent.embed.location.href=this.value?>  
                      ></textarea>  <a href="javascript:document.getElementById('embed').innerHTML =document.getElementById('video_Txt').value;mostrar('embed')"><img src="../img/icono_lupa.png" width="20" height="15"></a>
                      
                      
                 
                    </td>
                  </tr>
                  </tbody>
                  
                  
                   <tbody id="swf" style="display:none">
                      <tr>
                    <td align="right" class="fuente"><strong>Url de SWF:</strong></td>
                    <td align="left" >
                    <input type="file" name="swf_txt" id="swf_txt" />
                    
                     
                      
                 
                    </td>
                  </tr>
                  </tbody>
                  
                  
                  
                  
                  <tr>
                  <td colspan="2" align="center">
                   <div id="embed" style="display:none">
                   
                   </div> 
                  </td></tr>
                  <tr>
                    <td colspan="2" align="center">
                      <input type="hidden" name="MM_insert" value="form1">
                      <input name="SendForm" type="submit" id="SendForm"  value=" Guardar " >
                    </td>
                  </tr>
                </table>
              </form></td>
              <td background="../img/cdo_der_fnd.jpg"></td>
            </tr>
            <tr>
               <td id="cdo_dwn_izq" height="11" width="11"></td>
                  <td id="cdo_dwn_fnd" height="11" ></td>
                  <td id="cdo_dwn_der"></td>
            </tr>
          </table>
          <p><a href="index.php" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Banners</strong></a></p>
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

mysql_free_result($rsUbicacion);
ob_end_flush();
?>