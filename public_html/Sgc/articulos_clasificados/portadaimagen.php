<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php include('../includes/restriccion2.php')
;
?>
<?php
if ((isset($_GET['id_pro'])) && ($_GET['id_pro'] != "")) {
  $porta = $_GET['portada'];
  if ($porta == 1) {
    $porta = 0;
} else {
  $porta = 1;
}

$id_gal= $_GET['id_gal'];
    $updateSQL = "UPDATE galeria SET Portada_Gal = 0 WHERE IdNoticia_Gal  = ".$_GET['id_pro'];
  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL, $cnx_arica) or die(mysql_error());


  $updateSQL = "UPDATE galeria SET Portada_Gal = '$porta' WHERE Id_Galeria  = ".$_GET['id_gal'];
  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL, $cnx_arica) or die(mysql_error());

	$id_pro= $_GET['id_pro'];
	mysql_select_db($database_cnx_arica, $cnx_arica);
	$query_rsFotos = "SELECT * FROM galeria where IdNoticia_Gal= $id_pro";
	$rsFotos = mysql_query($query_rsFotos, $cnx_arica) or die(mysql_error());
	$row_rsFotos = mysql_fetch_assoc($rsFotos);
}

$id_pro= $_GET['id_pro'];
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsProducto = "SELECT * FROM noticias,categoria WHERE noticias.Id_Noticia= $id_pro  AND noticias.IdCategoria_Not = categoria.Id_Categoria  ";
$rsProducto = mysql_query($query_rsProducto, $cnx_arica) or die(mysql_error());
$row_rsProducto = mysql_fetch_assoc($rsProducto);
$totalRows_rsProducto = mysql_num_rows($rsProducto);

?>  Imagen en Cat&aacute;logo<? $portada= $porta ;
				if ($portada==1)  { ?>
                  <input type="checkbox" checked name="portada<?php echo $id_gal?>" id="portada<?php echo $id_gal?>" value="1" onChange="cargar2('portadaimagen.php?id_pro=<?php echo $row_rsProducto['Id_Noticia']; ?>&portada=<?php echo $porta; ?>&id_gal=<? $id_gal= $_GET['id_gal']; echo $id_gal;?>','portadadiv<?php echo $id_gal?>');
                  
                  " >
                <? } else  {?>
                <input type="checkbox" name="portada<?php echo $id_gal?>" id="portada<?php echo $id_gal?>" value="0" onChange="cargar2('portadaimagen.php?id_pro=<?php echo $row_rsProducto['Id_Noticia']; ?>&portada=<?php echo $porta; ?>&id_gal=<? $id_gal= $_GET['id_gal']; echo $id_gal;?>','portadadiv<?php echo $id_gal?>');
              
                ">
                
               <?   }  ?>
			   
               