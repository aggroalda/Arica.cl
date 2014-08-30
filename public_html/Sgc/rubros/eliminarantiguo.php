<?php require_once('../../0_SOURCE/Connections/cnx_arica.php'); ?>
<? ob_start();?>
<?php
$id_cat=$_GET['id_cat'];
if ((isset($_GET['id_del'])) && ($_GET['id_del'] != "")) {
	
	mysql_select_db($database_cnx_arica, $cnx_arica);
	$query_rsClasificados = "SELECT * FROM empresa_rubro WHERE Id_Rubro = ".$_GET['id_del'];
	$rsClasificados = mysql_query($query_rsClasificados, $cnx_arica) or die(mysql_error());
	$row_rsClasificados = mysql_fetch_assoc($rsClasificados);
	$totalRows_rsClasificados = mysql_num_rows($rsClasificados);
	
	$deleteSQL = "DELETE FROM empresa_rubro WHERE Id_Rubro = ".$_GET['id_del'];
	mysql_select_db($database_cnx_arica, $cnx_arica);
	mysql_query($deleteSQL, $cnx_arica) or die(mysql_error());
	
	
}
?>


<script language="javascript" type="text/javascript">window.top.window.cargar("listado.php","tabla");</script> 


<? ob_end_flush()?>