<? require_once("../Connections/cnx_arica.php");
require("mail/class.phpmailer.php");

$correo=$_POST['correo_Txt'];
if($correo!=''){


$password ="12345678";
if(count($reg)>0){
	$reg2=$usuario->editar_contrasena($reg[0]['usu_id'],$password);
    $mail = new PHPMailer();
    $mail->Host = "localhost";
     
    $mail->From = "no-responder@administrador.idw.com.pe";
    $mail->FromName = "Administrador";
    $mail->Subject = "Bienvenido a Arica.cl EL verdadero Portal de Arica";
    $mail->AddAddress("'".$correo."'","Nombre 01");
     
 $body  = utf8_decode("<h2 style='font-family:Arial; color:#333333;'>Bienvenido al Colegio WebApp 1.0</h2>
	<h3 style='font-family:Arial; color:#333;'>Hola ".$reg[0]['nombre']."</h3>
	<div style='font-size=12px; font-weight:bold; font-family:Arial; color:#C00;'>Por favor no responda este mensaje automático.</div><br>
	<span style='font-size=12px; font-family:Arial; color:#333333;'>
	Estimado usuario, este es un correo para reenviarle su usuario y contraseña. Recuerde que luego de ingresar puede cambiar su contraseña por una que le sea más facil de recordar.<br><br>
	<p>Usuario: <strong>".$reg[0]['usu_login']."</strong><br>
	Contraseña: <strong>$password</strong></p>
	<p>Ingrese a: <a href='http://idwcompaq-pc/sg_idw'><strong>http://idwcompaq-pc/sg_idw</strong></a> e ingrese sus datos. Si tiene alguna duda por favor escriba a soporte@idw.com.pe<br>
	_______________________________________________________________________________</p>
	Atentamente,<BR><BR>
	Administrador IDW  1.0<BR>
	Industria del Web<BR>
	</span>");
    $mail->Body = $body;
    $mail->AltBody = "Saludos";
    $mail->Send();
	
	echo 'yes';
}else{echo 'no';}
}else{echo 'cero';}
	?>

