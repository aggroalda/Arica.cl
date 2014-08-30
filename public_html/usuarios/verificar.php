<?php require_once('../Connections/cnx_arica.php'); ?>
<?php
if ((isset($_GET['Username'])) && ($_GET['Username'] != "")) {
		
	mysql_select_db($database_cnx_arica, $cnx_arica);
	$query_rsPersona = "SELECT * FROM usuarios WHERE Usern_Usu = '".$_GET['Username']."'";
	$rsPersona = mysql_query($query_rsPersona, $cnx_arica) or die(mysql_error());
	$row_rsPersona = mysql_fetch_assoc($rsPersona);
	$totalRows_rsPersona = mysql_num_rows($rsPersona);
	
	if ($totalRows_rsPersona>0) {  
		if ($row_rsPersona['Id_Usuario']==$_GET['id_usu']) {
		echo "IGUAL";
		} else {
		echo "SI";	
		}
		
	} else {
		echo "NO";
	}
	
}
?>