<? include("../Connections/cnx_arica.php");

if ((isset($_POST["SendForm"])) && ($_POST["SendForm"] != "")) {

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOpciones = "SELECT * FROM opciones";
$rsOpciones = mysql_query($query_rsOpciones, $cnx_arica) or die(mysql_error());
$row_rsOpciones = mysql_fetch_assoc($rsOpciones);
$totalRows_rsOpciones = mysql_num_rows($rsOpciones);
	
	$subject =  "Bienvenido al Portal de Arica.cl";	
    $para = $row_rsOpciones['email_opc'];
	$usuario2_Txt = $_POST['usuario2_Txt'];
	$nombres_Txt = $_POST['nombres_Txt'];
	$paterno_Txt = $_POST['paterno_Txt'];
	$materno_Txt = $_POST['materno_Txt'];
	$fecha_Txt = $_POST['fecha_Txt'];
	$sexo_text = $_POST['sexo_text'];
	$ciudad_Txt = $_POST['ciudad_Txt'];
	$direccion_Txt = $_POST['direccion_Txt'];
	$asunto_Txt = $_POST['asunto_Txt'];	
	$mensaje_Txt = $_POST['mensaje_Txt'];
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$header = "From: ".$usuario2_Txt." \r\n";
	$header .= "Mime-Version: 1.0 \r\n";
	$header .= "Content-type: text/html; charset=utf-8\r\n";
	
	$msg = "<h2 face=\"Arial\" color=\"#333333\">Bienvenido al Portal de Arica.cl</h2>
	<font face=\"Arial\" size=\"2\" color=\"#333333\">
	</br>
	<p>CORREO:\n".$_POST['usuario2_Txt']."</p>
	<p>NOMBRES:\n".$_POST['nombres_Txt']."</p>
	<p>APELLIDO PATERNO:\n".$_POST['paterno_Txt']."</p>
	<p>APELLIDO MATERNO:\n".$_POST['materno_Txt']."</p>
	<p>FECHA DE NACIMIENTO:\n".$_POST['fecha_Txt']."</p>
	<p>SEXO:\n".$_POST['sexo_text']."</p>
	<p>CIUDAD:\n".$_POST['ciudad_Txt']."</p>
	<p>PAÍS:\n".$_POST['direccion_Txt']."</p>
	<p>ASUNTO:\n".$_POST['asunto_Txt']."</p>
	<p>MENSAJE:\n".$_POST['mensaje_Txt']."</p>
	<p>IP:\n".$ip."</p>----------------------------------------------------------------------
	</font>";
		
	mail($para, $subject, $msg, $header);
	}
	
	if (mail) {
		$msg = "Formulario enviado exitosamente.";
	
	} else {
		$msg = "Ocurrió un error al enviar intentelo más tarde.";	
	}
	

	echo "<script language='javascript'>
			alert(\"".$msg."\");
			document.location.href='index.php';
		  </script>";

?>

