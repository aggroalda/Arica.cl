<?php require_once('../../Connections/cnx_arica.php'); ?>
<? ob_start();?>
<?php
if ((isset($_GET['id_del'])) && ($_GET['id_del'] != "")) {
	
	mysql_select_db($database_cnx_arica, $cnx_arica);
	$query_rsFoto = "SELECT * FROM banners WHERE Id_Banner = ".$_GET['id_del'];
	$rsFoto = mysql_query($query_rsFoto, $cnx_arica) or die(mysql_error());
	$row_rsFoto = mysql_fetch_assoc($rsFoto);
	$totalRows_rsFoto = mysql_num_rows($rsFoto);
	
	
	 $ext = strtolower(substr($row_rsFoto['Archivo_Ban'], -3));
		if ($ext == "jpg") { 
			if ($totalRows_rsFoto > 0) {
				if (file_exists("../../banners/".$row_rsFoto['Archivo_Ban'])) {
					unlink("../../banners/".$row_rsFoto['Archivo_Ban']);
				}
	}
	}
		
	$deleteSQL = "DELETE FROM banners WHERE Id_Banner = ".$_GET['id_del'];
	mysql_select_db($database_cnx_arica, $cnx_arica);
	mysql_query($deleteSQL, $cnx_arica) or die(mysql_error());
	
	header("Location: index.php");
}
?>
<? ob_end_flush()?>