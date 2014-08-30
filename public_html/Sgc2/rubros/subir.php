<?php require_once('../../Connections/cnx_arica.php'); ?>
<?
ob_start();
?>
<?
// bajar orden del menu
	$orden= $_GET['orden'];
    $id_cat = $_GET['id_cat'];
    $ordenSubir = $_GET['orden'] - 1;  
    $ordenBajar = $_GET['orden'] + 1;  

	        mysql_select_db($database_cnx_arica, $cnx_arica);
			$query_rscategoria_clasificado = "SELECT * FROM empresa_rubro WHERE Orden_Rubro= ".$ordenSubir;
			$rscategoria_clasificado = mysql_query($query_rscategoria_clasificado, $cnx_arica) or die(mysql_error());
			$row_rscategoria_clasificado = mysql_fetch_assoc($rscategoria_clasificado);
			$totalRows_rscategoria_clasificado = mysql_num_rows($rscategoria_clasificado);
			
			$total = $totalRows_rscategoria_clasificado;
				$id_antiguo = $row_rscategoria_clasificado['Id_Rubro'];
			


	
    mysql_select_db($database_cnx_arica, $cnx_arica);
     mysql_query("UPDATE empresa_rubro SET Orden_Rubro = $ordenSubir
                             WHERE Id_Rubro = $id_cat", $cnx_arica)
                             or die(mysql_error());
	mysql_select_db($database_cnx_arica, $cnx_arica);
     mysql_query("UPDATE empresa_rubro SET Orden_Rubro = $orden
                             WHERE Id_Rubro = $id_antiguo", $cnx_arica)
                             or die(mysql_error());
		
	header("Location: index.php");
	?>
<?
ob_end_flush();
?>