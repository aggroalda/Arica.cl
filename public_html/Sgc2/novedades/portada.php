<?php require_once('../../Connections/cnx_arica.php'); ?>


<?php
if ((isset($_GET['Id_Noticia'])) && ($_GET['Id_Noticia'] != "")) {
  $porta = $_GET['portada'];
  if ($porta == 1) {
    $porta = 0;
} else {
  $porta = 1;
}
  $updateSQL = "UPDATE noticias SET Portada_Not = '$porta' WHERE Id_Noticia  = ".$_GET['Id_Noticia'];

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL, $cnx_arica) or die(mysql_error());


$id_pro= $_GET['Id_Noticia'];
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsProductos = "SELECT * FROM noticias where Id_Noticia= $id_pro";
$rsProductos = mysql_query($query_rsProductos, $cnx_arica) or die(mysql_error());
$row_rsProductos = mysql_fetch_assoc($rsProductos);

}
?>

   <?  $portada= $row_rsProductos['Portada_Not'] ;
				if ($portada==1)  { ?>
                
                    <input type="checkbox" checked name="portada" id="portada" value="1" onChange="cargar('portada.php?Id_Noticia=<?php echo $row_rsProductos['Id_Noticia']; ?>&portada=<?php echo $row_rsProductos['Portada_Not']; ?>','portada<?php echo $row_rsProductos['Id_Noticia'];?>')" >
                  
               <? } else  {?>
               
                <input type="checkbox" name="portada" id="portada" value="0" onChange="cargar('portada.php?Id_Noticia=<?php echo $row_rsProductos['Id_Noticia']; ?>&portada=<?php echo $row_rsProductos['Portada_Not']; ?>','portada<?php echo $row_rsProductos['Id_Noticia'];?>')">
                  
               <? }  ?>