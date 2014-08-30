<? ob_start();?>
<?php require_once('../../Connections/cnx_arica.php'); ?>
<? require_once('../../include/funciones.php');?>

<script type="text/javascript">
function mostrarResultado(box,num_max,campospan){
	var contagem_carac = box.length;
	if (contagem_carac != 0){
		document.getElementById(campospan).innerHTML = contagem_carac + " caracteres digitados";
		if (contagem_carac == 1){
			document.getElementById(campospan).innerHTML = contagem_carac + " caracter digitado";
		}
		if (contagem_carac >= num_max){
			document.getElementById(campospan).innerHTML = "Limite de caracteres excedido!";
		}
	}else{
		document.getElementById(campospan).innerHTML = "No tenemos nada escribiendo..";
	}
}

function contarCaracteres(box,valor,campospan){
	var conta = valor - box.length;
	document.getElementById(campospan).innerHTML = "Ud. puede digitar " + conta + " caracteres";
	if(box.length >= valor){
		document.getElementById(campospan).innerHTML = "Opss.. Ud. no puede digitar más caracteres..";
		document.getElementById("campo").value = document.getElementById("campo").value.substr(0,valor);
	}	
}
</script>

<script>
contenido_textarea = ""
num_caracteres_permitidos = 140

function valida_longitud(){
   num_caracteres = document.form1.descripcion_Txt.value.length

   if (num_caracteres > num_caracteres_permitidos){
      document.form1.descripcion_Txt.value = contenido_textarea
   }else{
      contenido_textarea = document.form1.descripcion_Txt.value
   }

   if (num_caracteres >= num_caracteres_permitidos){
      document.form1.descripcion_Txt.style.color="#FF0000";
   }else{
      document.form1.descripcion_Txt.style.color="#002448";
   }

   cuenta()
}
function cuenta(){
   document.forms[0].caracteres.value=document.forms[0].descripcion_Txt.value.length
}
</script> 

<?php
//initialize the session

if (!isset($_SESSION)) {
  session_start();
}

$nivel= $_SESSION['MM_IdNivel'];
$usuario=$_SESSION['MM_IdUser'];

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_arica'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_arica']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
    $nivel= $_SESSION['MM_IdNivel'];
$usuario=$_SESSION['MM_IdUser'];
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_arica set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php?error=2";
if (!((isset($_SESSION['MM_arica'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_arica'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $QUERY_STRING=$_SERVER['QUERY_STRING'];
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php include('../includes/funciones.php');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	
	
		$image = $_FILES['foto_Txt']['name'];
	$tempora = $_FILES['foto_Txt']['tmp_name'];
	
		if ($image) { // si el campo de foto tiene contenido
		
			$ext = strtolower(substr($image, -3));
			
			if (($ext == "jpg") || ($ext == "gif")|| ($ext == "png")) { // si la imagen es jpg
			
				if (move_uploaded_file($tempora, "../../empresas/img/".$image)) { // intentamos guardar la imagen en el servidor
				
					list($ancho, $alto, $tipo, $atr) = getimagesize("../../empresas/img/".$image);
					
					if ($ancho > 800) { // si ancho es mas que el permitodo
					
						$file = "../../empresas/img/".$image;
						$width = 800;
						$height = ($alto/$ancho)*$width;
							if ($ext=="jpg") {
							$imSrc  = imagecreatefromjpeg($file);
							}
							if ($ext=="gif") {
							$imSrc  = imagecreatefromgif($file);
							}
							if ($ext=="png") {
							$imSrc  = imagecreatefrompng($file);
							}

						$w      = imagesx($imSrc);
						$h      = imagesy($imSrc);
						
							if($width/$height>$w/$h) {
								$nh = ($h/$w)*$width;
								$nw = $width;
							} else {
								$nw = ($w/$h)*$height;
								$nh = $height;
							}
						
						$dx = ($width/2)-($nw/2);
						$dy = ($height/2)-($nh/2);
						
						$imTrg  = imagecreatetruecolor($width, $height);
						imagecopyresampled($imTrg, $imSrc, 0, 0, 0, 0, $width, $height, $w, $h);
							if ($ext=="jpg") { 
							imagejpeg($imTrg, $file);
							}
							if ($ext=="gif") { 
							imagegif($imTrg, $file); 
							}
							if ($ext=="png") { 
							imagepng($imTrg, $file); 
							}
					} // fin de si ancho es mas que el permitodo
			
				}  // fin de que si no se pudo guardar en el servidor la imagen 
			
		}  // fin de si la imagen no es jpg
		
	
	  } // fin de si la foto tiene contenido
  $fecha = $_POST['fecha_Txt'];
   $rubro = $_POST['rubro'];
  $descripcionfoto= $_POST['descripcion_Txt'];

			 $insertSQL = sprintf("INSERT INTO empresa (Nombre_Emp,  Foto_Emp, Descripcion_Emp,Ciudad_Emp, Direccion_Emp, Telefono_Emp, Correo_Emp,IdUsuario_Emp,Rubro_Sub_Id, Id_Rubro_Empresa) VALUES ( %s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
                       GetSQLValueString(utf8_decode($_POST['nombre_Txt']), "text"),
					  GetSQLValueString(utf8_decode($image), "text"),
					   GetSQLValueString(utf8_decode($_POST['descripcion_Txt']), "text"),
					     GetSQLValueString(utf8_decode($_POST['ciudad_Txt']), "text"),
					   GetSQLValueString(utf8_decode($_POST['direccion_Txt']), "text"),
					   GetSQLValueString(utf8_decode($_POST['telefono_Txt']), "text"),
					   GetSQLValueString(utf8_decode($_POST['correo_Txt']), "text"),
                        GetSQLValueString(utf8_decode($usuario), "text"),
						GetSQLValueString(utf8_decode($_POST['tipo_Txt']), "int"),
						GetSQLValueString(utf8_decode($_POST['rubro']), "int")
                   		);			   
			 mysql_select_db($database_cnx_arica, $cnx_arica);
 		 	mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
  			$id_pro = mysql_insert_id($cnx_arica);

  

  $insertGoTo = "imagenes.php?id_pro=".$id_pro."&cantidad=".$cantidad."";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  
   mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOpciones = "SELECT * FROM opciones";
$rsOpciones = mysql_query($query_rsOpciones, $cnx_arica) or die(mysql_error());
$row_rsOpciones = mysql_fetch_assoc($rsOpciones);
$totalRows_rsOpciones = mysql_num_rows($rsOpciones);

if(($_SESSION['MM_IdNivel']==4)){ 

$path="http://www.arica.cl/Sgc/empresas/"; 
   
$empresaLink=$path."ver.php?id_pro=$id_pro";
                
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCorreos = "SELECT * FROM usuarios WHERE IdNivel_Usu=5 OR IdNivel_Usu=1";
$rsCorreos = mysql_query($query_rsCorreos, $cnx_arica) or die(mysql_error());
$row_rsCorreos = mysql_fetch_assoc($rsCorreos);
$totalRows_rsCorreos = mysql_num_rows($rsCorreos);do 
{
	$correo = $row_rsCorreos['Usern_Usu'].",";
	$correos .= $correo;
} while
($row_rsCorreos=mysql_fetch_assoc($rsCorreos));        
   // Datos del email
   
$para = $correos."anthonny2890@gmail.com";

  	$subject = "Nueva Empresa Agregada desde el Gestor";
	$header = "From: ".$row_rsOpciones['email_opc']." \r\n";
	$header .= "Mime-Version: 1.0 \r\n";
	$header .= "Content-type: text/html; charset=iso-8859-1\r\n";

 mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsImagen2 = "SELECT * FROM empresa where Id_Empresa=$id_pro";
$rsImagen2 = mysql_query($query_rsImagen2, $cnx_arica) or die(mysql_error());
$row_rsImagen2 = mysql_fetch_assoc($rsImagen2);
$totalRows_rsImagen2 = mysql_num_rows($rsImagen2);

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsUser = "SELECT * FROM personas WHERE Id_Persona=".$_SESSION['MM_IdUser'];
$rsUser  = mysql_query($query_rsUser, $cnx_arica) or die(mysql_error());
$row_rsUser  = mysql_fetch_assoc($rsUser);
$totalRows_rsUser  = mysql_num_rows($rsUser);
 
if ($row_rsUser['Sexo_Per']=="Masculino"){$elola="el";$srosra="Sr";}
elseif ($row_rsUser['Sexo_Per']=="Femenino") {$elola="la";$srosra="Sra";}	
$nombre_emp=utf8_encode($row_rsImagen2['Nombre_Emp']);
$descripcion_emp=utf8_encode($row_rsImagen2['Descripcion_Emp']);
$descripcion_emp= truncate($descripcion_emp,300);

$msg = "<!DOCTYPE html><html><meta http-equiv='Content-Type' content='text/html; charset=utf-8'/><title>arica.cl | El verdadero portal de Arica</title><head><body>
	<h2 style='font-family:Arial; color:#333333;'>Bienvenido al Portal Web de Arica.cl</h2>
	<h3 style='font-family:Arial; color:#333333;'>Mensaje enviado desde el Sistema Gestor</h3>
	<h4>".$nombre_emp."</h4>
	<p>".$descripcion_emp."</p>
	<p>Empresa agregada por $elola $srosra. ".utf8_encode($row_rsUser['Nombres_Per'])." ".utf8_encode($row_rsUser['Paterno_Per'])." ".utf8_encode($row_rsUser['Materno_Per'])."</p>
	<p align='justify'>para ver la informaci&oacute;n completa de la empresa y/o realizar alguna operaci&oacute;n debe hacer click en el siguiente enlace:</p>
	<ul>
    <li>link:".$empresaLink."</li>
    </ul>
	<p>&nbsp;</p>
    <a href='http://www.arica.cl/'><img alt='firma' src='http://arica.cl/img/arica_firma.png' width='659' height='48' border='0'/></a></body></head></html>";
			
			
		
			mail($para, $subject, $msg, $header);
			
	if (mail) {
		$msg = "Empresa agregada correctamente.";
	
	} else {
		$msg = "Ocurrió un error, intentelo más tarde.";	
	}
		?><script type="text/javascript">alert("<? echo $msg; ?>");</script><?
}
  
   header("Location:ver_get_rubro.php?id_pro=$id_pro&rubro=$rubro");
}
	
	mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTipo2 = "SELECT * FROM empresa_rubro ORDER BY Nombre_Rubro ASC";
$rsTipo2 = mysql_query($query_rsTipo2, $cnx_arica) or die(mysql_error());
$row_rsTipo2 = mysql_fetch_assoc($rsTipo2);
$totalRows_rsTipo2 = mysql_num_rows($rsTipo2);


$id_rub_rub =$_GET['id_rub_rub'];
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTipo3 = "SELECT * FROM empresa_rubro WHERE Id_Rubro=$id_rub_rub ORDER BY Id_Rubro";
$rsTipo3 = mysql_query($query_rsTipo3, $cnx_arica) or die(mysql_error());
$row_rsTipo3 = mysql_fetch_assoc($rsTipo3);
$totalRows_rsTipo3 = mysql_num_rows($rsTipo3);


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTipo = "SELECT * FROM empresa_rubro_sub";
$rsTipo = mysql_query($query_rsTipo, $cnx_arica) or die(mysql_error());
$row_rsTipo = mysql_fetch_assoc($rsTipo);
$totalRows_rsTipo = mysql_num_rows($rsTipo);
?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.js" type="text/javascript" language="javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript">
<!--
 function activa()
{
if (document.getElementById('colorcheck').checked==true )
{mostrar('agregarcolor');mostrar('divContenido');mostrar('primero');
}
else
{ocultar('agregarcolor');ocultar('divContenido');ocultar('primero');
}
}

 function validaragregarprod()
{ var error= "";
	if (document.getElementById('nombre_Txt').value==""){
		error+="Nombre de Producto es requerido.\n";}
	if (document.getElementById('categoria_Txt').value==""){
		error+="Nombre de Categoria es requerido.\n";}
	if (document.getElementById('descripcion_Txt').value==""){
		error+="Descripci�n de Producto es requerido.\n";}
	if (document.getElementById('precio_Txt').value==""){
		error+="Precio es requerido.\n";}
if (error!="") 
 { alert('Ocurrieron los siguientes errores:.\n'+error);
return false;}

return true;
} /*fin function validar */

 function validarcbo(cantidad) { //v4.0
var can= document.getElementById(cantidad).value;

for (i=1; i<=can; i++)
{
if (form1.elements['archivo_fot['+i+']'].value== "")
{
 alert("Ingrese una Imagen");
        return false;   }
  } 
  return true;
   }
//-->
</script>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript">
$.validator.methods.equal = function(value, element, param) {
		return value == param;
	};
	$(document).ready(function(){
				
		$("#form1").validate({
				rules: {
					nombre_Txt: "required",
					foto_Txt: "required",
					descripcion_Txt:"required",
					rubro:"required",
					ciudad_Txt:"required",
					direccion_Txt:"required",
					telefono_Txt:"required",
					correo_Txt:"required",
				},
				messages: {
					nombre_Txt: "Requerido",
					foto_Txt: "Requerido",
					descripcion_Txt: "Requerido",
					rubro:"Requerido",
					ciudad_Txt:"Requerido",
					direccion_Txt:"Requerido",
					telefono_Txt:"Requerido",
					correo_Txt:"Requerido",

					
					}
			});
	});
</script>
</head>
<body>
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
        <? 
	$colname_rsRubroE= $_GET['id_rub_rub'];
	mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsRubroE = sprintf("SELECT * FROM empresa_rubro WHERE empresa_rubro.Id_Rubro  = %s", GetSQLValueString($colname_rsRubroE, "int"));
$rsRubroE = mysql_query($query_rsRubroE, $cnx_arica) or die(mysql_error());
$row_rsRubroE = mysql_fetch_assoc($rsRubroE);
$totalRows_rsRubroE = mysql_num_rows($rsRubroE);
	?>
        <strong>
         <p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../rubros/index.php">M&oacute;dulo Rubro de Empresa</a> / <a id="guia_titulos" href="../empresas/index_get_rubro.php?id_rub_rub=<?php echo $_GET['id_rub_rub']; ?>">Rubro de Empresa <?php echo utf8_encode($row_rsRubroE['Nombre_Rubro']); ?></a> / <a id="guia_titulos" href="ver_get_rubro.php?id_pro=40">Detalles</a> / <a id="guia_titulos" href="#">Agregar</a></p></strong>
      <p class="titles">&raquo; Rubro de Empresa <?php echo utf8_encode($row_rsRubroE['Nombre_Rubro']);?> / Detalles / Agregar </p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><blockquote>
          <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="11"><img src="../img/cdo_top_izq.jpg"/></td>
              <td width="849" background="../img/cdo_top_fnd.jpg"></td>
              <td width="11"><img src="../img/cdo_top_der.jpg"/></td>
            </tr>
            <tr>
              <td background="../img/cdo_izq_fnd.jpg"></td>
              <td bgcolor="#EBEBEB"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
                <table width="100%">
                 
                
                  <tr>
                    <td align="right" class="fuente"><strong>Nombre de Empresa:</strong></td>
                    <td><input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" size="35" title="Nombre de Producto"></td>
                  </tr>
                     <tr>
                  <td colspan="2" align="center" valign="top" class="linksRojo" ><p id="ancho_p"><br> &raquo; Se recomienda que el tamaño de las imágenes sean de las siguientes  proporciones:
                  <ul id="ancho_p2">
                  <li id="list_deco">1024px de ancho x 762px de alto</li>
                  <li id="list_deco">800px de ancho x 600px de alto</li>
                  <li id="list_deco">400px de ancho x 300px de alto</li>
                  </ul>
                  </p>
                  
                  </td>
                  </tr>
                    
                  
                  <tr>
                    <td align="right" class="fuente"><strong>Imagen Empresa:</strong></td>
                    <td>
                <input name="foto_Txt" type="file" class="fuente" id="foto_Txt" onChange="imagenval(this.id)">
                    </td>
                  </tr>
                  
                  <tr>
                    <td align="right" valign="top" class="fuente"><strong>Descripci&oacute;n:</strong></td>
                    <td><textarea name="descripcion_Txt" cols="45" rows="3" class="fuente" id="descripcion_Txt" onkeyup="mostrarResultado(this.value,140,'spcontando');contarCaracteres(this.value,140,'sprestante');valida_longitud()" onKeyDown="valida_longitud()"><? echo truncate($row_rsProductos['Descripcion_Emp'],140);?></textarea>
                    <br />
<span id="spcontando" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">No Tenemos nada escribiendo...</span><br />
<span id="sprestante" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;"></span></td>
                  </tr>
                  
        		   <tr>
                    <td align="right" class="fuente"><strong>Rubro:</strong></td>
                    <td align="left"><select name="rubro" class="fuente" id="rubro"  title="Nombre de Rubro" onChange="javascript:var id_rub=this.value; cargar('recargar_lista_sub.php?id_rub='+ id_rub,'recargar_lista')">
                 
                                  <option value="<? echo $row_rsTipo3['Id_Rubro']?>">
					<? echo utf8_encode($row_rsTipo3['Nombre_Rubro'])?></option>
                   
						 
                    </select>
                    </td>
                  </tr>
                  
                   <tbody id="recargar_lista">
                    <tr>
                    <td align="right" class="fuente"><strong>Subcategría de Rubro :</strong></td>
                    <td><select name="tipo_Txt" class="fuente" id="tipo_Txt"  title="Nombre de Subcategoría de Rubro"  required="required" disabled="disabled">
                   <option value="">-- Seleccione --</option>
                    <? do {?>
                    <option value="<? echo $row_rsTipo['Rubro_Sub_Id']?>"><? echo utf8_encode($row_rsTipo['Rubro_Sub_Nombre']);?></option>
                    <? }while ($row_rsTipo=mysql_fetch_assoc($rsTipo));?>
                    </select> 
                                                   
                    </td>
                  </tr>
                  </tbody>
                      <tr>
                    <td align="right" class="fuente"><strong>Ciudad:</strong></td>
                    <td><input name="ciudad_Txt" type="text" class="fuente" id="ciudad_Txt" size="25" title="Nombre de Producto"></td>
                  </tr>
                   <tr>
                    <td align="right" class="fuente"><strong>Dirección:</strong></td>
                    <td><input name="direccion_Txt" type="text" class="fuente" id="direccion_Txt" size="40" title="Nombre de Producto"></td>
                  </tr>
                   <tr>
                    <td align="right" class="fuente"><strong>Teléfono:</strong></td>
                    <td><input name="telefono_Txt" type="text" class="fuente" id="telefono_Txt" size="20" title="Nombre de Producto"></td>
                  </tr>
                   <tr>
                    <td align="right" class="fuente"><strong>Correo:</strong></td>
                    <td><input name="correo_Txt" type="text" class="fuente" id="correo_Txt" size="25" title="Nombre de Producto"></td>
                  </tr>
                  
                  	<tr>
                    <td colspan="2" align="center">
                      <input type="hidden" name="MM_insert" value="form1">
                      <input name="SendForm" type="submit" id="SendForm"  value=" Guardar ">
                      </td>
                 	 </tr>
                </table>
              </form></td>
              <td background="../img/cdo_der_fnd.jpg"></td>
            </tr>
            <tr>
              <td height="11"><img src="../img/cdo_dwn_izq.jpg" width="11" height="11"/></td>
              <td background="../img/cdo_dwn_fnd.jpg"></td>
              <td><img src="../img/cdo_dwn_der.jpg" width="11" height="11"/></td>
            </tr>
          </table>
          <p><a href="index_get_rubro.php?id_rub_rub=<? echo $_GET['id_rub_rub']; ?>" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Empresas / Rubro de Empresa <?php echo utf8_encode($row_rsRubroE['Nombre_Rubro']); ?></strong></a></p>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table></td>
  </tr>
  <? include("../option/footer.php"); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsOptions);
?>

<? ob_flush();?>