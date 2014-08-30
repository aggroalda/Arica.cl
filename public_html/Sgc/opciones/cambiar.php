<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php


$usuario=$_GET['usuario'];

if ( (isset($_GET['actual'])) && (isset($_GET['usuario'])) && (isset($_GET['nueva'])) && (isset($_GET['repetir'])) ) {

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsActual = "SELECT * FROM usuarios where Id_Usuario='".$usuario."'";
$rsActual = mysql_query($query_rsActual, $cnx_arica) or die(mysql_error());
$row_rsActual = mysql_fetch_assoc($rsActual);
$totalRows_rsActual = mysql_num_rows($rsActual);

if ($row_rsActual['Passw_Usu']!=($_GET['actual'])) {
	
	echo "La contrase&ntilde;a actual no coincide.";
	
	} elseif ( ($_GET['nueva']) != ($_GET['repetir']) ) {
		
		echo "La contrase&ntilde;a nueva no coincide.";
		
	} else {
		
	$updateSQL = "UPDATE usuarios SET Passw_Usu = '".$_GET['repetir']."' "."WHERE Id_Usuario=$usuario";
	mysql_query($updateSQL, $cnx_arica) or die(mysql_error());
	
	echo "Contrase&ntilde;a Actualizada.";
		
	}

mysql_free_result($rsActual);

}
?>
