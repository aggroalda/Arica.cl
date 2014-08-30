<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php


if ( (isset($_GET['titulo_Txt'])) && (isset($_GET['descrip_Txt'])) ) {

mysql_select_db($database_cnx_arica, $cnx_arica);
$updateSQL = "UPDATE mensaje SET tituloMensaje =" ."'".utf8_decode($_GET['titulo_Txt'])."'" .", DescripMensaje =" ."'".utf8_decode($_GET['descrip_Txt'])."'" . " WHERE IdMensaje=1";
	mysql_query($updateSQL, $cnx_arica) or die(mysql_error());
	
	echo "Mensaje Actualizado.";

}
?>
