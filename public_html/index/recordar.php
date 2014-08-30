<? require_once('../Connections/cnx_arica.php'); ?>

<?

$correo= $_POST['correo_Txt'];

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsRecordar = "SELECT * FROM usuarios WHERE Usern_Usu = '$correo'";
$rsRecordar = mysql_query($query_rsRecordar, $cnx_arica) or die(mysql_error());
$row_rsRecordar = mysql_fetch_assoc($rsRecordar);
$totalRows_rsRecordar = mysql_num_rows($rsRecordar);


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsRecordar = "SELECT * FROM opciones ";
$rsRecordar = mysql_query($query_rsRecordar, $cnx_arica) or die(mysql_error());
$row_rsRecordar = mysql_fetch_assoc($rsRecordar);


if($totalRows_rsRecordar>0){
	
	
	$now= time();
	putenv("TZ=America/Lima");
	$hora = date ("g:i a", $now);
	$para =  $row_rsRecordar['correo_opc'];
	$nombre =$row_rsEmail['Nombres_Per']." ".$row_rsEmail['Paterno_Per'];
	$contraseña= $row_rsRecordar['Passwd_Usu'];
	$email = $row_rsCorreoEmperador['correo_opc'];
	$subject = "Recordatorio de Contraseña ";
	$comentario = "Su contraseña es : $contraseña";
	$asunto = "Recordatorio de Contraseña";	
	$fecha = date("d-m-Y");
	$ip = $_SERVER['REMOTE_ADDR'];
	$header = "From: ".$email." \r\n";
	$header .= "Mime-Version: 1.0 \r\n";
	$header .= "Content-type: text/html; charset=utf-8\r\n";
	$msg = "
	<h2 style='font-family:Arial; color:#333333;'>$asunto</h2>
	<div style='font-size=10px; font-weight:bold; font-family:Arial; color:#C00;'>Por favor no responda este mensaje automático.</div><br>
	<span style='font-size=12px; font-family:Arial; color:#333333;'>
	
	<div style='font-size=14px; font-weight:bold; font-family:Arial;'><p>$comentario</p></div>
	<p>Usuario: <strong>$email</strong><br>
	</p>
	<p>Código de Reserva: <strong>000$id_reserva </strong><br>
	</p>
	<p><br>
	_________________________________________________________________</p>
	Atentamente,<BR><BR>
	La Administración<BR>
	arica.cl<BR>
	Av. San Martín 558 - Tacna - Perú<br>
	Teléfonos: +5152 414291 | Fax: +5152 425782<br>
	<img src='http://www.hotelemperadortacna.com/img/logotipo.gif'>
	</span>";
	
	mail($para, $subject, $msg, $header);
	
	
	
	
	
	header("location: index.php");
	
	
	
	
	
	
	
	
	
	
	
	
	}

else {
	echo "<script>alert('Usuario No existe')</script>"
	;}





mysql_free_result($rsRecordar);
?>
