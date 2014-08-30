<? include('../Connections/cnx_arica.php'); ?>
<? $correo= $_POST['correo_Txt'];
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsRecordar = "SELECT * FROM usuarios WHERE Usern_Usu = '$correo'";
$rsRecordar = mysql_query($query_rsRecordar, $cnx_arica) or die(mysql_error());
$row_rsRecordar = mysql_fetch_assoc($rsRecordar);
$totalRows_rsRecordar = mysql_num_rows($rsRecordar);
/*
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsRecordar = "SELECT * FROM opciones ";
$rsRecordar = mysql_query($query_rsRecordar, $cnx_arica) or die(mysql_error());
$row_rsRecordar = mysql_fetch_assoc($rsRecordar);*/

if($totalRows_rsRecordar>0){
	$now= time();
	putenv("TZ=America/Lima");
	$hora = date ("g:i a", $now);
	$para =  $row_rsRecordar['Usern_Usu'];
	$nombre =$row_rsEmail['Nombres_Per']." ".$row_rsEmail['Paterno_Per'];
	$contrasenia= $row_rsRecordar['Passw_Usu'];
	$email = $row_rsCorreoEmperador['correo_opc'];
	$subject = "Recordatorio de Contraseña ";
	$comentario = "Su contraseña es : $contrasenia";
	$asunto = "Recordatorio de Contraseña";	
	$fecha = date("d-m-Y");
	$ip = $_SERVER['REMOTE_ADDR'];
	$header = "From: admin@arica.cl \r\n";
	$header .= "Mime-Version: 1.0 \r\n";
	$header .= "Content-type: text/html; charset=utf-8\r\n";
	$msg = "<h2 style='font-family:Arial; color:#333333;'>$asunto</h2>
	<div style='font-size=10px; font-weight:bold; font-family:Arial; color:#C00;'>Por favor no responda este mensaje automático.</div><br>
	<span style='font-size=12px; font-family:Arial; color:#333333;'>
	<div style='font-size=14px; font-weight:bold; font-family:Arial;'><p>$comentario</p></div>
	<p>Su usuario es : <strong>$para</strong><br>
	</p></p>
	<p><br>
	_________________________________________________________________</p>
	<BR>
	Atentamente,<BR><BR>
	La Administración<BR><BR>
		<a href='http://www.arica.cl/'><img alt='firma' src='http://arica.cl/img/arica_firma.png' width='659' height='48' border='0'/></a>
	</span>";
	mail($para, $subject, $msg, $header);
	header("location: ../index/");
	}
	else {
	echo "<script>alert('Usuario No existe')</script>"
	;}
?>