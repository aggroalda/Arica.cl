<?php require_once('../../Connections/cnx_arica.php'); ?>
<? ob_start()?>
<?php 
include('../includes/salida2.php');
include('../includes/restriccion2.php');
include('../includes/funciones.php');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_rsBanner = "-1";
if (isset($_GET['id_ban'])) {
  $colname_rsBanner = $_GET['id_ban'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsBanner = sprintf("SELECT * FROM banners WHERE Id_Banner = %s", GetSQLValueString($colname_rsBanner, "int"));
$rsBanner = mysql_query($query_rsBanner, $cnx_arica) or die(mysql_error());
$row_rsBanner = mysql_fetch_assoc($rsBanner);
$totalRows_rsBanner = mysql_num_rows($rsBanner);


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $ext = strtolower(substr($row_rsBanner['Archivo_Ban'], -3));
						if ($ext == "jpg" || ($ext == "gif") || ($ext == "png")) {


	$image = $_FILES['archivo_Txt']['name'];
	$tempora = $_FILES['archivo_Txt']['tmp_name'];
	$file = "../../banners/".$row_rsBanner['Archivo_Ban'];
	$ubicacion = "../../banners/";
	$tamaño =$_POST['ubicacion_Txt'];
		if ( $tamaño == 1 ){ 
	$width = 245;
	$height = 180 ;
	} 
			if ($tamaño == 2){ 
	$width = 470;
	$height= 50;
	} 
		if ($tamaño == 3){ 
	$width = 700;
	$height= 90;
	} 
	 
	 if ($_POST['radio']==1){
	 
	    if ($image) { // si el campo de foto tiene contenido
		
			$ext = strtolower(substr($image, -3));
			
			if ($ext == "jpg" || ($ext == "gif") || ($ext == "png")) { // si la imagen es jpg
			
			    if(file_exists($ubicacion.$image))
  			           {  $ultimo= $_GET['id_ban'];
       			          $nombre = $ultimo.$image;
   				       }
                    else {$ultimo= $_GET['id_ban'];
		   		          $nombre= $ultimo.$image;
			             }
			
				if (move_uploaded_file($tempora, $ubicacion.$nombre)) { // intentamos guardar la imagen en el servidor
				list($ancho, $alto, $tipo, $atr) = getimagesize("../../banners/".$nombre);
						$file = "../../banners/".$nombre;
					
					
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
		
		
		if (file_exists("../../banners/".$row_rsBanner['Archivo_Ban'])) {
			unlink("../../banners/".$row_rsBanner['Archivo_Ban']);
		}
	
	
  $updateSQL = sprintf("UPDATE banners SET Titulo_Ban=%s, Ubicacion_Ban=%s, Archivo_Ban=%s, Url_Ban=%s WHERE Id_Banner=%s",
                       GetSQLValueString(utf8_decode($_POST['nombre_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['ubicacion_Txt']), "int"),
                       GetSQLValueString(utf8_decode($nombre), "text"),
					    GetSQLValueString(utf8_decode($_POST['url_Txt']), "text"),
                       GetSQLValueString($_POST['id_ban'], "int"));

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL, $cnx_arica) or die(mysql_error());

 
  }  // fin si foto tiene contenido  
  
  }
  
    else {
		
		$file = "../../banners/".$row_rsBanner['Archivo_Ban'];
		$ext = strtolower(substr($file, -3));
					$file2= $row_rsBanner['Archivo_Ban'];
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
							if ($ext=="png") { 
							imagepng($imTrg, $file);
							}
							
 $updateSQL = sprintf("UPDATE banners SET Titulo_Ban=%s, Ubicacion_Ban=%s, Archivo_Ban=%s, Url_Ban =%s WHERE Id_Banner=%s",
                       GetSQLValueString(utf8_decode($_POST['nombre_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['ubicacion_Txt']), "int"),
                       GetSQLValueString(utf8_decode($file2), "text"),
					   GetSQLValueString(utf8_decode($_POST['url_Txt']), "text"),
                       GetSQLValueString($_POST['id_ban'], "int"));
 mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL, $cnx_arica) or die(mysql_error());

 } /* fin else */
		
	
}// SI es imagen el archivo
else {
	
	 $updateSQL = sprintf("UPDATE banners SET Titulo_Ban=%s, Ubicacion_Ban=%s, Archivo_Ban=%s WHERE Id_Banner=%s",
                       GetSQLValueString(utf8_decode($_POST['nombre_Txt']), "text"),
                       GetSQLValueString(utf8_decode($_POST['ubicacion_Txt']), "int"),
                       GetSQLValueString(utf8_decode($_POST['video_Txt']), "text"),
                       GetSQLValueString($_POST['id_ban'], "int"));
 mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL, $cnx_arica) or die(mysql_error());
	
	}
		
		
		
		
		
		

 header("Location: ver.php?id_ban=".$_POST['id_ban']);

}

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$colname_rsBanner = "-1";
if (isset($_GET['id_ban'])) {
  $colname_rsBanner = $_GET['id_ban'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsBanner = sprintf("SELECT * FROM banners WHERE Id_Banner = %s", GetSQLValueString($colname_rsBanner, "int"));
$rsBanner = mysql_query($query_rsBanner, $cnx_arica) or die(mysql_error());
$row_rsBanner = mysql_fetch_assoc($rsBanner);
$totalRows_rsBanner = mysql_num_rows($rsBanner);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">


<script src="../js/jquery-1.5.1.min.js" type="text/javascript" language="javascript"></script>
<script src="../js/jquery.validate.min.js" type="text/javascript" language="javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>

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
</script>

<script type="text/javascript" src="../js/td_over.js"></script>
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
</head>
<body>
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
    	<strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../banners/index.php">M&oacute;dulo de Banners</a> / <a href="#" id="guia_titulos">Editar</a></p></strong>
      <p class="titles">&raquo; M&oacute;dulo de Banners / Editar</p>
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
                      <select name="ubicacion_Txt" class="fuente" id="ubicacion_Txt">
                        <option value="" <?php if (!(strcmp(0, utf8_encode($row_rsBanner['Ubicacion_Ban'])))) {echo "selected=\"selected\"";} ?>>-- Elegir --</option>
                        <option value="1" <?php if (!(strcmp(1, utf8_encode($row_rsBanner['Ubicacion_Ban'])))) {echo "selected=\"selected\"";} ?>>Derecha [245px de ANCHO x 180px de ALTO]</option>
                         <option value="2" <?php if (!(strcmp(2, utf8_encode($row_rsBanner['Ubicacion_Ban'])))) {echo "selected=\"selected\"";} ?>>Izquierda Medio [470px de ANCHO x 50px de ALTO]</option>
                          <option value="3" <?php if (!(strcmp(3,utf8_encode( $row_rsBanner['Ubicacion_Ban'])))) {echo "selected=\"selected\"";} ?>>Izquierda Abajo [700px de ANCHO x 90px de ALTO]</option>
                                             
                      </select></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente"><strong>Nombre del Banner:</strong></td>
                    <td>
                    
                    <input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" title="Nombre del Banner" value="<?php echo utf8_encode($row_rsBanner['Titulo_Ban']); ?>"></td>
                 
                  </tr>
                  
                  
                       <?  $ext = strtolower(substr($row_rsBanner['Archivo_Ban'], -3));
						if ($ext == "jpg" || ($ext == "gif") || ($ext == "png")) { ?>
                  
                  <tr>
                    <td colspan="2" align="center" class="fuente"><strong>Visualizaci&oacute;n de Imagen:</strong></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" class="fuente"><img src="../../banners/<?php echo utf8_encode($row_rsBanner['Archivo_Ban']); ?>"></td>
                    </tr>
                    <tr>
                  <td class="fuente" align="right"><strong>Url de Imagen:</strong></td><td>  <input name="url_Txt" type="text" class="fuente" id="url_Txt" value="<? echo utf8_encode($row_rsBanner['Url_Ban']);?>" title="Url de Imagen" size="50" ></td>
                  </tr>
                  
                   <tr>
             <td class="fuente" align="right" ><strong> Imagen:</strong></td> 
             <td align="left" class="fuente" >
                 <label for="color">
                   <input type="radio" name="radio" id="cambiar_imagen" value="1" onClick="mostrar('cambiarimagen')"/>
                   Cambiar imagen </label>  
                    <input type="radio" name="radio" id="nocambiar_imagen" value="2" onClick="ocultar('cambiarimagen')"/>
                   No cambiar imagen</label></td>
              <td align="left" class="fuente" >&nbsp;</td>
            </tr>
                  
                   <tbody id ="cambiarimagen"  style="display:none">
                  <tr>
                    <td align="right" class="fuente"><strong>Cambiar Imagen:</strong></td>
                    <td align="left">
                      <input name="archivo_Txt" type="file" class="fuente"  id="archivo_Txt" title="Imagen" onChange=" imagenval(this.id)"></td>
                      
                  </tr>
                  </tbody>
                  <? } else {?>
                   <tr>
                    <td colspan="2" align="center" class="fuente"><strong>Visualizaci&oacute;n de Video:</strong></td>
                  </tr>
                  
                  <tr>
                    <td align="right" class="fuente"><strong>Url de Video:</strong></td>
                    <td align="left" >
                      <textarea name="video_Txt" class="fuente" id="video_Txt"  cols="45" rows="3"title="Video" value="" onClick="this.select()"
                    ><? echo utf8_encode($row_rsBanner['Archivo_Ban']);?></textarea>  <a href="javascript:document.getElementById('embed').innerHTML =document.getElementById('video_Txt').value;mostrar('embed')"><img src="../img/icono_lupa.png" width="20" height="15"></a>
                      
                      
                 
                    </td>
                  </tr>
                   <tr>
                  <td colspan="2" align="center">
                   <div id="embed" style="display:none">
                   
                   </div> 
                  </td></tr>
                  
                  <? }?>
                  
                  
                  
                  
                  
                  
                  
                  
                  
              <tr>
                    <td colspan="2" align="center">
                      <input name="id_ban" type="hidden" id="id_ban" value="<?php echo $row_rsBanner['Id_Banner']; ?>">
                      <input name="SendForm" type="submit" id="SendForm"  value=" Guardar ">
                      </td>
                  </tr>
                </table>
                <input type="hidden" name="MM_update" value="form1">
              </form></td>
              <td background="../img/cdo_der_fnd.jpg"></td>
            </tr>
            <tr>
             <td id="cdo_dwn_izq" height="11" width="11"></td>
                  <td id="cdo_dwn_fnd" height="11"></td>
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

mysql_free_result($rsBanner);
ob_end_flush()
?>