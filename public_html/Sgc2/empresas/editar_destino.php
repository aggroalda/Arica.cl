<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php
if ((isset($_GET['id_del'])) && ($_GET['id_del'] != "")) {


$detalle= $_GET['detalle'];
$precio= $_GET['precio'];
//  $foto= $_GET['foto'];
	// $deleteSQL1 = "UPDATE destino_empresa SET Detalle_DestinoEmp= '$detalle',Precio_DestinoEmp= '$precio ', Foto_DestinoEmp= '$foto' WHERE Id_DestinoEmpresa = ".$_GET['id_del'];
	
	$deleteSQL1 = "UPDATE destino_empresa SET Detalle_DestinoEmp= '$detalle',Precio_DestinoEmp= '$precio ' WHERE Id_DestinoEmpresa = ".$_GET['id_del'];
	mysql_select_db($database_cnx_arica, $cnx_arica);
	mysql_query($deleteSQL1, $cnx_arica) or die(mysql_error());	




	
	echo "SI";
}
?>