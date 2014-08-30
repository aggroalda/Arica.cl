<?php require_once('../../Connections/cnx_arica.php'); ?>
<? ob_start(); ?>
<?php include('../includes/salida2.php');?>
<?php include('../includes/restriccion2.php');?>
<?php  include('../includes/funciones.php');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsGalerias = sprintf("SELECT MAX(Id_Galeria) as 'maxban' FROM galeria;");
$rsGalerias = mysql_query($query_rsGalerias, $cnx_arica) or die(mysql_error());
$row_rsGalerias = mysql_fetch_assoc($rsGalerias);
$ultimo= $row_rsGalerias['maxban'];


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	$image = $_FILES['archivo_fot']['name'];
	$descripcion= $_POST['descripcion_Txt'];
	$ubicacion = "../../novedades/img/";
	$tempora = $_FILES['archivo_fot']['tmp_name'];
	$num = $_POST['cantidad'];
	$idnot = $_POST['id_noticia'];
	$id_cat = $_POST['id_cat'];
	$id_sub = $_POST['id_sub'];

	$width = 800;
	$height=600;
	
	for ($i=1;$i<=$num;$i++) {
	$ultimo= $ultimo+1;
		if ($image[$i]) { // si el campo de foto tiene contenido
		$ext = strtolower(substr($image[$i], -3));
			
			if(file_exists($ubicacion.$image[$i]))
  			  {  
       			 $nombre[$i] = $ultimo.$image[$i];
   				 }
           else {$nombre[$i]= $image[$i];
			   }
		if (($ext == "jpg") || ($ext == "gif")) { // si la imagen es jpg
			if (move_uploaded_file($tempora[$i], "../../novedades/img/".$nombre[$i])) { // intentamos guardar la imagen en el servidor
					
					list($ancho, $alto, $tipo, $atr) = getimagesize("../../novedades/img/".$nombre[$i]);
					$file = "../../novedades/img/".$nombre[$i];
					$imSrc  = imagecreatefromjpeg($file);
					$imTrg = imagecreatetruecolor($width, $height);
					
					    $w = imagesx($imSrc);
						$h = imagesy($imSrc);
						imagecopyresampled($imTrg, $imSrc, 0, 0, 0, 0, $width, $height, $w, $h);
			imagejpeg($imTrg, $file);
		
// fin de si ancho es mas que el permitodo
			
				}  // fin de que si no se pudo guardar en el servidor la imagen 
			
		}  // fin de si la imagen no es jpg
		
		mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsPortada = "SELECT * FROM galeria WHERE IdNoticia_Gal =".$_GET['id_not'];
$rsPortada = mysql_query($query_rsPortada, $cnx_arica) or die(mysql_error());
$row_rsPortada = mysql_fetch_assoc($rsPortada);
$totalRows_rsPortada = mysql_num_rows($rsPortada);
if ($totalRows_rsPortada<1 && $i==1){$portada=1;} else{$portada=0;}
	  
  $insertSQL = sprintf("INSERT INTO galeria (Tipo_Gal, IdNoticia_Gal, Archivo_Gal, Descripcion_Gal,Portada_Gal) VALUES (%s,%s, %s, %s, %s)",
   					   GetSQLValueString($_POST['id_tipo'], "int"),
					   GetSQLValueString($idnot, "int"),
                       GetSQLValueString(utf8_decode($nombre[$i]), "text"),
					    GetSQLValueString(utf8_decode($descripcion[$i]), "text"),
						GetSQLValueString($portada, "int"));

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());

	  } // fin de si la foto tiene contenido

  } // termina el for
  
		
		header("Location: ver_get_categoria.php?id_not=$idnot");
	
		
	}

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

if($_GET['id_cat_cat']){
$id_cat_cat=$_GET['id_cat_cat'];

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoriaNot = "SELECT * FROM categoria WHERE Id_Categoria=$id_cat_cat";
$rsCategoriaNot = mysql_query($query_rsCategoriaNot, $cnx_arica) or die(mysql_error());
$row_rsCategoriaNot = mysql_fetch_assoc($rsCategoriaNot);
$totalRows_rsCategoriaNot= mysql_num_rows($rsCategoriaNot);
}

$colname_rsNoticias = "-1";
if (isset($_GET['id_not'])) {
  $colname_rsNoticias = $_GET['id_not'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsNoticias = sprintf("SELECT Id_Noticia, Titulo_Not FROM noticias WHERE Id_Noticia = %s", GetSQLValueString($colname_rsNoticias, "int"));
$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
$totalRows_rsNoticias = mysql_num_rows($rsNoticias);

$cantidadd= $_GET['cantidad'];
 
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript">

<!--
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

function validarimagendesc(cantidad) { //v4.0
	var error="";
	var can= document.getElementById(cantidad).value;
	for (i=1; i<=can; i++)
	{
		if (form1.elements['archivo_fot['+i+']'].value== "")
		{
	 	error+="Ingrese Imagen.\n";
 		}
		if (form1.elements['descripcion_Txt['+i+']'].value== "")
		{
	 	error+="Ingrese Descripci�n";
 		}
	if (error!="") 
 { alert('Ocurrieron los siguientes errores:.\n'+error);
return false;}}
return true;

 /*fin function validar */
	
	
}
//-->
</script>
</head>
<body onLoad="cargar('foto.php?cantidad= <? echo $cantidadd ?>','FotoDescripcion')">
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
      <strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../categorias/index.php">M&oacute;dulo de Categor&iacute;a de Noticia</a> / <a id="guia_titulos" href="../novedades/index_get_categoria.php?id_cat_cat=<? echo utf8_encode($row_rsCategoriaNot['Id_Categoria']);?>">Categor&iacute;a <? echo utf8_encode($row_rsCategoriaNot['Nombre_Cat']); ?></a> / <a id="guia_titulos" href="../novedades/ver_get_categoria.php?id_not=<? echo $_GET['id_not'];?>">Detalles</a></p></strong>
      <p class="titles">&raquo; Categor&iacute;a <? echo utf8_encode($row_rsCategoriaNot['Nombre_Cat']); ?> / Agregar Fotos</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
           <td width="11" height="11" id="cdo_top_izq"></td>
            <td width="929" height="11" id="cdo_top_fnd"></td>
            <td  width="11" height="11" id="cdo_top_der"></td>
          </tr>
          <tr>
            <td background="../img/cdo_izq_fnd.jpg"></td>
            <td bgcolor="#EBEBEB"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
              <table width="100%" align="center" >
                <tr>
                  <td colspan="2" align="center" class="fuente" >Agregando fotos a la noticia:  <strong>
                    <?php  echo utf8_encode($row_rsNoticias['Titulo_Not']);   ?></strong></td>
                  </tr>
                <tr>
                  <td width="50%" align="right" class="fuente" ><strong>N&uacute;mero de Fotos:</strong></td>
                  <td align="left" class="fuente" ><label>
                    <select name="cantidad" class="fuente" id="cantidad"   onChange=" cargar_fotos('foto.php?cantidad='+this.value,'FotoDescripcion')">
                     
                       <? for ($i=1;$i<=10;$i++) { ?>
                        <option value="<?=$i?>" <? if ($_GET['cantidad'] == $i) echo " selected"; ?>><?=$i?></option>
                      <? } ?>
                      </select>
                      
                  </label>
                  
                   </td>
                </tr>
                <tr>
                  <td colspan="2" align="center" valign="top" class="linksRojo" ><p id="ancho_p">&raquo; S&oacute;lo se aceptan im&aacute;genes con extensi&oacute;n JPG.<br> &raquo; Se recomienda que el tamaño de las imágenes sean de las siguientes  &nbsp;&nbsp;  proporciones:
                  <ul id="ancho_p2">
                  <li id="list_deco">1024px de ancho x 762px de alto</li>
                  <li id="list_deco">800px de ancho x 600px de alto</li>
                  <li id="list_deco">400px de ancho x 300px de alto</li>
                  </ul>
                  </p></td>
                  </tr>
                  
               <tbody id="FotoDescripcion"></tbody>
                  
                 <tr>
                  <td colspan="2" align="center" class="fuente" ><label>
                    <input type="submit" name="SendForm" id="SendForm" value=" Guardar " onClick="return validarimagendesc('cantidad')">
                  </label></td>
                </tr>
              </table>
              <input type="hidden" name="MM_insert" value="form1">
              <input name="id_noticia" type="hidden" id="id_noticia" value="<? echo $_GET['id_not'];?>">
             
           <?   if($_GET ['id_cat'])  {?> 
              <input name="id_cat" type="hidden" id="id_cat" value="<? echo $_GET['id_cat'];?>">
              <input name="id_sub" type="hidden" id="id_sub" value="<? echo $_GET['id_sub'];?>">
              
              <? }?> 
              <input name="id_tipo" type="hidden" id="id_tipo" value="1">
            </form></td>
            <td background="../img/cdo_der_fnd.jpg"></td>
          </tr>
          <tr>
            <td id="cdo_dwn_izq" height="11" width="11"></td>
            <td id="cdo_dwn_fnd" height="11"></td>
            <td id="cdo_dwn_der"></td>
          </tr>
        </table>
          <blockquote>
            <p><a href="ver_get_categoria.php?id_not=<? echo $_GET['id_not'];?>" class="fuente linksRojo">&laquo; <strong>Volver al Detalle de Noticia / <? echo utf8_encode($row_rsCategoriaNot['Nombre_Cat']); ?>
              </strong></a></p>
            <p><a href="index_get_categoria.php?id_cat_cat=<? echo $row_rsCategoriaNot['Id_Categoria'];?>" class="fuente linksRojo">&laquo; <strong>Volver al Listado de Noticias / <? echo utf8_encode($row_rsCategoriaNot['Nombre_Cat']); ?>
                  
            </strong></a> </p>
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

ob_end_flush();
?>