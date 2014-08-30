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
	
	header("Location: index.php");
}
?>