<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php
if ((isset($_GET['id_del'])) && ($_GET['id_del'] != "")) {

	$deleteSQL1 = "DELETE FROM destino_empresa WHERE Id_DestinoEmpresa = ".$_GET['id_del'];
	
	mysql_select_db($database_cnx_arica, $cnx_arica);
	mysql_query($deleteSQL1, $cnx_arica) or die(mysql_error());	


	
	echo "SI";
}
?>