<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php include('../includes/restriccion2.php');
?>
<?php
if ((isset($_GET['id_del'])) && ($_GET['id_del'] != "")) {
	
	mysql_select_db($database_cnx_arica, $cnx_arica);
	$query_rsNews = sprintf("SELECT * FROM articulos_clasificados WHERE Id_Articulo=$id_del");
	$rsNews = mysql_query($query_rsNews, $cnx_arica) or die(mysql_error());
	$row_rsNews = mysql_fetch_assoc($rsNews);
	$totalRows_rsNews = mysql_num_rows($rsNews);
	
	/*if ($row_rsNews['Foto_Not']!="") {
		  if (file_exists("../../novedades/img/".$row_rsNews['Foto_Not'])) {
			  unlink("../../novedades/img/".$row_rsNews['Foto_Not']);}
	}*/
    	

	$deleteSQL = "DELETE FROM articulos_clasificados WHERE Id_Articulo=".$_GET['id_del'];
	mysql_select_db($database_cnx_arica, $cnx_arica);
	mysql_query($deleteSQL, $cnx_arica) or die(mysql_error());
	
	if($_GET['id_sub_tip']){
	$id_sub_tip=$_GET['id_sub_tip'];
	mysql_select_db($database_cnx_arica, $cnx_arica);
	$query_rsCat = sprintf("SELECT * FROM clasificados, categoria_clasificado WHERE clasificados.Id_Clasificados= $id_sub_tip AND clasificados.IdCategoriaCla_Cla=categoria_clasificado.Id_CategoriaClasificado");
	$rsCat = mysql_query($query_rsCat, $cnx_arica) or die(mysql_error());
	$row_rsCat = mysql_fetch_assoc($rsCat);
	$totalRows_rsCat = mysql_num_rows($rsCat);
	
	}
	
	header("Location: index_get_cat.php?id_cat_cat=".$row_rsCat['Id_CategoriaClasificado']);
}
?>