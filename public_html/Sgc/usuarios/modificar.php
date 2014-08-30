<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php
if ((isset($_GET['id_user'])) && ($_GET['id_user'] != "")) {
		
	mysql_select_db($database_cnx_arica, $cnx_arica);
	$query_rsPersona = "SELECT * FROM usuarios WHERE Id_Usuario = ".$_GET['id_user'];
	$rsPersona = mysql_query($query_rsPersona, $cnx_arica) or die(mysql_error());
	$row_rsPersona = mysql_fetch_assoc($rsPersona);
	$totalRows_rsPersona = mysql_num_rows($rsPersona);
	
	include('../includes/pass.php');
		
	$updateSQL = "UPDATE usuarios SET Passw_Usu = '$codigo' WHERE Id_Usuario = ".$_GET['id_user'];

  	mysql_select_db($database_cnx_arica, $cnx_arica);
	mysql_query($updateSQL, $cnx_arica) or die(mysql_error());
	  
	$para = $row_rsPersona['Usern_Usu'];
  	$subject = "Generación de nueva Contraseña";
	$header = "From: no-responder@arica.cl\r\n";
	$header .= "Mime-Version: 1.0 \r\n";
	$header .= "Content-type: text/html; charset=utf-8\r\n";
	
	$msg = "
	<h2 style='font-family:Arial; color:#333333;'>Generación de nueva Contraseña</h2>
	<div style='font-size=10px; font-weight:bold; font-family:Arial; color:#C00;'>Por favor no responda este mensaje automático.</div><br>
	<span style='font-size=12px; font-family:Arial; color:#333333;'>
	Estimado usuario del arica.cl, su contraseña ha sido actualizada y le informamos la nueva a continuación.
	<p>Usuario: <strong>$para</strong><br>
	Contraseña: <strong>$codigo</strong></p>
	<p>Ingrese a: <a href='http://www.arica.cl/Sgc'>http://www.arica.cl/Sgc</a>. Si tiene alguna duda por favor escriba a admin@arica.cl<br>
	_________________________________________________________________</p>
	Atentamente,<BR><BR>
	La Administración<BR>
	Arica.cl<BR>
	Arica-Chile<br>
	<br>
	<img src='http://www.arica.cl/img/logotipo.gif'>
	</span>";
		
	mail($para, $subject, $msg, $header);
	  
	echo "Contraseña actualizada y enviada al Usuario por Correo";
	
}
?>