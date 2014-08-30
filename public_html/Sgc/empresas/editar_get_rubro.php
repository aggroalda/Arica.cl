<?php require('../../Connections/cnx_arica.php'); ?>
<? ob_start(); ?>
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
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

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
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
		$image = $_FILES['foto_Txt']['name'];	
	$image2 = $_POST['foto_Ext'];
	
	if($image=!""){

		$imagen = $_FILES['foto_Txt']['name'];
		$tempora = $_FILES['foto_Txt']['tmp_name'];
	}/* fin de  image!=""*/ 
				
				if ($imagen) { // s
				$ext = strtolower(substr($imagen, -3));
				
				if (($ext == "jpg") || ($ext == "gif")|| ($ext == "png")) { // si la imagen es jpg
				    if (move_uploaded_file($tempora, "../../empresas/img/".$imagen)) { // intentamos guardar la imagen en el servidor
					list($ancho, $alto, $tipo, $atr) = getimagesize("../../empresas/img/".$imagen);
						
						if ($ancho > 800) { // si ancho es mas que el permitodo
						
							$file = "../../empresas/img/".$imagen;
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
		  		
	}  else{
		$imagen = $image2;
	}
	
$updateSQL = sprintf("UPDATE empresa SET Nombre_Emp=%s ,Foto_Emp=%s, Descripcion_Emp=%s,Ciudad_Emp=%s, Direccion_Emp=%s, Telefono_Emp=%s, Correo_Emp=%s,Rubro_Sub_Id=%s,Id_Rubro_Empresa=%s WHERE Id_Empresa=%s",
                       
                       	GetSQLValueString(utf8_decode($_POST['nombre_Txt']), "text"),
						GetSQLValueString(utf8_decode($imagen), "text"),
						GetSQLValueString(utf8_decode($_POST['descripcion_Txt']), "text"),
						GetSQLValueString(utf8_decode($_POST['ciudad_Txt']), "text"),
					    GetSQLValueString(utf8_decode($_POST['direccion_Txt']), "text"),
					    GetSQLValueString(utf8_decode($_POST['telefono_Txt']), "text"),
					    GetSQLValueString(utf8_decode($_POST['correo_Txt']), "text"),
					    GetSQLValueString(utf8_decode($_POST['tipo_Txt']), "int"),
						GetSQLValueString(utf8_decode($_POST['rubro']), "int"),
                        GetSQLValueString($_GET['id_pro'], "int")
						
						);

  mysql_select_db($database_cnx_arica, $cnx_arica);
  $Result1 = mysql_query($updateSQL, $cnx_arica) or die(mysql_error());

   $updateGoTo = "ver_get_rubro.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOpciones = "SELECT * FROM opciones";
$rsOpciones = mysql_query($query_rsOpciones, $cnx_arica) or die(mysql_error());
$row_rsOpciones = mysql_fetch_assoc($rsOpciones);
$totalRows_rsOpciones = mysql_num_rows($rsOpciones);

if(($_SESSION['MM_IdNivel']==4)){ 

$id_pro=$_GET['id_pro'];

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

  	$subject = "Empresa Editada desde el Gestor";
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
	<p>Empresa editada por $elola $srosra. ".utf8_encode($row_rsUser['Nombres_Per'])." ".utf8_encode($row_rsUser['Paterno_Per'])." ".utf8_encode($row_rsUser['Materno_Per'])."</p>
	<p align='justify'>para ver la informaci&oacute;n completa de la empresa y/o realizar alguna operaci&oacute;n debe hacer click en el siguiente enlace:</p>
	<ul>
    <li>link:".$empresaLink."</li>
    </ul>
	<p>&nbsp;</p>
    <a href='http://www.arica.cl/'><img alt='firma' src='http://arica.cl/img/arica_firma.png' width='659' height='48' border='0'/></a></body></head></html>";
			
			
		
			mail($para, $subject, $msg, $header);
			
	if (mail) {
		$msg = "Empresa editada correctamente.";
	
	} else {
		$msg = "Ocurrió un error, intentelo más tarde.";	
	}
	
	?><script type="text/javascript">alert("<? echo $msg; ?>");</script><?
	
}
  header("Location: $updateGoTo");
  
  
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$colname_rsProductos = "-1";
if (isset($_GET['id_pro'])) {
  $colname_rsProductos = $_GET['id_pro'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsProductos = sprintf("SELECT * FROM empresa WHERE Id_Empresa= %s", GetSQLValueString($colname_rsProductos, "int"));
$rsProductos = mysql_query($query_rsProductos, $cnx_arica) or die(mysql_error());
$row_rsProductos = mysql_fetch_assoc($rsProductos);
$totalRows_rsProductos = mysql_num_rows($rsProductos);

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTipo2 = "SELECT * FROM empresa_rubro, empresa WHERE empresa_rubro.Id_Rubro = empresa.Id_Rubro_Empresa AND empresa.Id_empresa='$colname_rsProductos'";
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
$query_rsRubroSub = "SELECT * FROM empresa_rubro_sub where Rubro_Id = ".$_GET['id_rub_rub'];
$rsRubroSub = mysql_query($query_rsRubroSub, $cnx_arica) or die(mysql_error());
$row_rsRubroSub = mysql_fetch_assoc($rsRubroSub);
$totalRows_rsRubroSub = mysql_num_rows($rsRubroSub);


?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script src="../js/ajax.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.title; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es requerido.\n'; }
    } if (errors) alert('Ocurrieron los siguientes errores:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
//-->
</script>
</head>
<body>
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td>
      <? 
	$colname_rsRubroE= $_GET['id_rub_rub'];
	mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsRubroE = sprintf("SELECT * FROM empresa_rubro WHERE empresa_rubro.Id_Rubro  = %s", GetSQLValueString($colname_rsRubroE, "int"));
$rsRubroE = mysql_query($query_rsRubroE, $cnx_arica) or die(mysql_error());
$row_rsRubroE = mysql_fetch_assoc($rsRubroE);
$totalRows_rsRubroE = mysql_num_rows($rsRubroE);
	?>
    <blockquote>
            <strong>
            <p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../rubros/index.php">M&oacute;dulo Rubro de Empresa</a> / <a id="guia_titulos" href="../empresas/index_get_rubro.php?id_rub_rub=<?php echo $_GET['id_rub_rub']; ?>">Rubro de Empresa <?php echo utf8_encode($row_rsRubroE['Nombre_Rubro']); ?></a> / <a id="guia_titulos" href="../empresas/ver_get_rubro.php?id_pro=<? echo $_GET['id_pro'];?>">Detalles</a> / <a id="guia_titulos" href="#">Editar</a></p></strong>
      <p class="titles">&raquo; Rubro de Empresa <?php echo utf8_encode($row_rsRubroE['Nombre_Rubro']); ?> / Detalles / Editar</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><blockquote>
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="11"><img src="../img/cdo_top_izq.jpg"/></td>
              <td width="895" background="../img/cdo_top_fnd.jpg"></td>
              <td width="11"><img src="../img/cdo_top_der.jpg"/></td>
            </tr>
            <tr>
              <td background="../img/cdo_izq_fnd.jpg"></td>
              <td bgcolor="#EBEBEB"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
                <table width="100%">
                  
                   
                  <tr>
                    <td align="right" class="fuente"><strong>Nombre de Empresa:</strong></td>
                    <td><input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" title="Nombre de Producto" value="<?php echo utf8_encode($row_rsProductos['Nombre_Emp']); ?>" size="35"></td>
                  </tr>
                     
                   <tr>
                    <td align="right" class="fuente"><strong>Imagen Adjunta:</strong></td>
                    <td class="fuente"><? if ($row_rsProductos['Foto_Emp']) { ?><img src="../includes/imagen.php?ubica=../../empresas/img/&nw=300&foto=<?php echo $row_rsProductos['Foto_Emp']; ?>"><? } else { ?>No existe imagen adjunta<? } ?></td>
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
                    <td align="right" class="fuente"><strong>Modificar imagen:</strong></td>
                    <td>
                      <input name="foto_Txt" type="file" class="fuente" id="foto_Txt">
                      <input name="foto_Ext" type="hidden"   id="foto_Ext" value="<?=$row_rsProductos['Foto_Emp']?>"></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" class="fuente"><strong>Descripci&oacute;n:</strong></td>
                    <? $variable= truncate($row_rsProductos['Descripcion_Emp'],140);?>
                    <td><textarea name="descripcion_Txt" cols="45" rows="3" class="fuente" id="descripcion_Txt" onkeyup="mostrarResultado(this.value,140,'spcontando');contarCaracteres(this.value,140,'sprestante')"><? echo utf8_encode($variable);?></textarea>
                    <br />
<span id="spcontando" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">No Tenemos nada escribiendo...</span><br />
<span id="sprestante" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;"></span>    
                    </td>
                       
                 </tr>                  
                   <tr>
                    <td align="right" class="fuente"><strong>Rubro :</strong></td>
                    <td align="left"><select name="rubro" class="fuente" id="rubro"  title="El campo Rubro" onChange="javascript:var id_rub=this.value; cargar('recargar_lista_sub.php?id_rub='+ id_rub,'recargar_lista')">
                 
                    <? do {?>
                    
                
                    
                    <option value="<? echo $row_rsTipo3['Id_Rubro']?>"
					<?php if (!(strcmp($row_rsTipo3['Id_Rubro'], $row_rsTipo2['Id_Rubro']))) {echo "selected=\"selected\"";} ?>><? echo utf8_encode($row_rsTipo3['Nombre_Rubro'])?></option>
                    <? }while ($row_rsTipo3=mysql_fetch_assoc($rsTipo3));
						 
						  if($row_rsTipo3 > 0) {
							  mysql_data_seek($row_rsTipo3, 0);
							  $row_rsTipo3 = mysql_fetch_assoc($row_rsTipo3);
						                }
					
					?>
                    </select>
                    </td>
                  </tr>
                  
                   <tbody id="recargar_lista">
                    <tr>
                    <td align="right" class="fuente"><strong>Subcategría de Rubro :</strong></td>
                    <td><select name="tipo_Txt" class="fuente" id="tipo_Txt"  title="Nombre de Subcategoría de Rubro" required="required">
                   <option value="">-- Seleccione --</option>
                    <? do {?>
                    <option <? if($row_rsRubroSub['Rubro_Sub_Id']==$_GET['rubro_sub']){echo "selected='selected'";}?> value="<? echo $row_rsRubroSub['Rubro_Sub_Id']?>"><? echo utf8_encode($row_rsRubroSub['Rubro_Sub_Nombre']);?></option>
                    <? }while ($row_rsRubroSub=mysql_fetch_assoc($rsRubroSub));?>
                    </select> 
                                                   
                    </td>
                  </tr>
                  </tbody>
                  
                     <tr>
                    <td align="right" class="fuente"><strong>Ciudad :</strong></td>
                    <td><input name="ciudad_Txt" type="text" class="fuente" id="ciudad_Txt" size="25" title="El campo Ciudad" value="<?php echo utf8_encode($row_rsProductos['Ciudad_Emp']); ?>"></td>
                  </tr>
                   <tr>
                    <td align="right" class="fuente"><strong>Dirección :</strong></td>
                    <td><input name="direccion_Txt" type="text" class="fuente" id="direccion_Txt" size="40" title="El campo Dirección" value="<?php echo utf8_encode($row_rsProductos['Direccion_Emp']); ?>"></td>
                  </tr>
                   <tr>
                    <td align="right" class="fuente"><strong>Teléfono :</strong></td>
                    <td><input name="telefono_Txt" type="text" class="fuente" id="telefono_Txt" size="20" title="El campo Teléfono" value="<?php echo utf8_encode($row_rsProductos['Telefono_Emp']); ?>"></td>
                  </tr>
                   <tr>
                    <td align="right" class="fuente"><strong>Correo :</strong></td>
                    <td><input name="correo_Txt" type="text" class="fuente" id="correo_Txt" size="25" title="El campo Correo" value="<?php echo utf8_encode($row_rsProductos['Correo_Emp']); ?>"></td>
                  </tr>                 
                  <tr>
                    <td colspan="2" align="center"><input name="id_pro" type="hidden" id="id_pro" value="<?php echo $row_rsProductos['Id_Empresa']; ?>">
                      <input name="SendForm" type="submit" id="SendForm" onClick="MM_validateForm('nombre_Txt','','R','descripcion_Txt','','R','rubro','','R','ciudad_Txt','','R','direccion_Txt','','R','telefono_Txt','','R','correo_Txt','','R');return document.MM_returnValue" value=" Guardar "></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_update" value="form1">
              </form></td>
              <td background="../img/cdo_der_fnd.jpg"></td>
            </tr>
            <tr>
              <td height="11"><img src="../img/cdo_dwn_izq.jpg" width="11" height="11"/></td>
              <td background="../img/cdo_dwn_fnd.jpg"></td>
              <td><img src="../img/cdo_dwn_der.jpg" width="11" height="11"/></td>
            </tr>
          </table>
          <p><a href="index_get_rubro.php?id_rub_rub=<?php echo $_GET['id_rub_rub']; ?>" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Empresas / Rubro de Empresa <?php echo utf8_encode($row_rsRubroE['Nombre_Rubro']); ?></strong></a></p>
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

mysql_free_result($rsProductos);




?>

<? ob_flush();