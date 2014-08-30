<? ob_start(); ?>
<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php include('../includes/salida2.php');?>
<?php include('../includes/restriccion.php');?>
<?php include('../includes/funciones.php');

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
	
$updateGoTo = "ver_get_categoria.php?id_not=".$_POST['id_not'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
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

$id_cat_cat=$_GET['id_cat_cat'];
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTipo = "SELECT * FROM categoria where Id_Categoria=$id_cat_cat";
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
    <strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../categorias/index.php">M&oacute;dulo de Categor&iacute;a de Noticia</a> / <a id="guia_titulos" href="../novedades/index_get_categoria.php?id_cat_cat=<? echo $_GET['id_cat_cat']; ?>"> Categor&iacute;a <? echo utf8_encode($row_rsNoticias['Nombre_Cat']); ?></a> / <a id="guia_titulos" href="#">Editar</a></p></strong>
      <p class="titles">&raquo; Categor&iacute;a <? echo utf8_encode($row_rsNoticias['Nombre_Cat']); ?> / Editar</p>
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
                    <td width="37%" align="right" class="fuente"><strong>T&iacute;tulo de la Noticia:</strong></td>
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
          <p><a href="index_get_categoria.php?id_cat_cat=<? echo $row_rsNoticias['Id_Categoria'];?>" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Noticia / <? echo utf8_encode($row_rsNoticias['Nombre_Cat']); ?></strong></a> </p>
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


 