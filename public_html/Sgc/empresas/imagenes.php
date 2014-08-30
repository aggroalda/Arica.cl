<?php require_once('../../Connections/cnx_arica.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsGalerias = sprintf("SELECT MAX(Id_Galeria) as 'maxban' FROM galeria;");
$rsGalerias = mysql_query($query_rsGalerias, $cnx_arica) or die(mysql_error());
$row_rsGalerias = mysql_fetch_assoc($rsGalerias);
$ultimo= $row_rsGalerias['maxban'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	$image = $_FILES['archivo_fot']['name'];
	$tempora = $_FILES['archivo_fot']['tmp_name'];
	$descripcion= $_POST['descripcion_Txt'];
	$ubicacion = "../../destinos/img/";
	$num = $_POST['cantidad'];
	$idpro = $_POST['id_producto'];
	$width = 800;
	$height=600;
	
	for ($i=1;$i<=$num;$i++) {
	$ultimo= $ultimo+1;
		if ($image[$i]) { // si el campo de foto tiene contenido
		$ext = strtolower(substr($image[$i], -3));
		if(file_exists($ubicacion.$image[$i]))
  			  {  
       			 $nombre[$i] = $ultimo.$image[$i];
   				 }
           else {$nombre[$i]= $image[$i];
			   }
		if (($ext == "jpg") || ($ext == "gif")) { // si la imagen es jpg
			if (move_uploaded_file($tempora[$i], "../../destinos/img/".$nombre[$i])) { // intentamos guardar la imagen en el servidor
					
					list($ancho, $alto, $tipo, $atr) = getimagesize("../../destinos/img/".$nombre[$i]);
					$file = "../../destinos/img/".$nombre[$i];
					$imSrc  = imagecreatefromjpeg($file);
					$imTrg = imagecreatetruecolor($width, $height);
					
					    $w = imagesx($imSrc);
						$h = imagesy($imSrc);
						imagecopyresampled($imTrg, $imSrc, 0, 0, 0, 0, $width, $height, $w, $h);
						imagejpeg($imTrg, $file);
				
				// fin de si ancho es mas que el permitodo
			}  // fin de que si no se pudo guardar en el servidor la imagen 
			
		}  // fin de si la imagen no es jpg
	
	
						
	 $insertSQL = "UPDATE destino_empresa SET Foto_DestinoEmp= '$nombre[$i]' WHERE Id_DestinoEmpresa= ".$_GET['id_pro'];
		 mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());

	  } // fin de si la foto tiene contenido
 } // termina el for
  
    
		header("Location: index.php?id_emp=".$_GET['id_emp']."&id_destinoempresa=".$_GET['id_pro']);
		
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
$query_rsProductos = "SELECT * FROM destino_empresa where Id_DestinoEmpresa=".$_GET['id_pro'];
$rsProductos = mysql_query($query_rsProductos, $cnx_arica) or die(mysql_error());
$row_rsProductos = mysql_fetch_assoc($rsProductos);
$totalRows_rsProductos = mysql_num_rows($rsProductos);
 
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript">
<!--
//-->
function validarcbo(cantidad) { //v4.0
	var can= document.getElementById(cantidad).value;
	var error="";
	for (i=1; i<=can; i++){
	if (form1.elements['archivo_fot['+i+']'].value== "")
		{ error+="Ingrese Imagen.\n"; }
	if (form1.elements['descripcion_Txt['+i+']'].value== "")
	{ error+="Ingrese Descripci�n.\n";   }
	 } 
  if (error!="") 
 { alert('Ocurrieron los siguientes errores:.\n'+error);
return false;}
return true;
}
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
      <p class="titles">&raquo; M&oacute;dulo de Empresas - Agregar Fotos</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="11"><img src="../img/cdo_top_izq.jpg"/></td>
            <td width="929" background="../img/cdo_top_fnd.jpg"></td>
            <td width="11"><img src="../img/cdo_top_der.jpg"/></td>
          </tr>
          <tr>
            <td background="../img/cdo_izq_fnd.jpg"></td>
            <td bgcolor="#EBEBEB"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
              <table width="100%" align="center" >
                <tr>
                  <td colspan="2" align="center" class="fuente" >Agregando fotos al destino:  <strong>
                  <?php  echo $row_rsProductos['Nombre_Pro'];   ?></strong></td>
                  </tr>
                <tr>
                  <td align="right" class="fuente" ><strong>N&uacute;mero de Fotos:</strong></td>
                  <td align="left" class="fuente" ><label>
                    <select name="cantidad" class="fuente" id="cantidad" onChange="document.location=('imagenes.php?id_pro=<?=$_GET['id_pro']?>&cantidad=' + form1.cantidad.options[form1.cantidad.selectedIndex].value)">
                      <? for ($i=1;$i<=10;$i++) { ?>
                        <option value="<?=$i?>" <? if ($_GET['cantidad'] == $i) echo " selected"; ?>><?=$i?></option>
                      <? } ?>
                      </select>
                  </label></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" valign="top" class="linksRojo" >S&oacute;lo se aceptan im&aacute;genes con extensi&oacute;n JPG de 800px de Ancho x 600px de Alto</td>
                  </tr>
                <? for ($i=1;$i<=$_GET['cantidad'];$i++) { ?> 
                <tr>
                  <td width="38%" align="right" valign="top" class="fuente" ><strong>Foto <? echo $i; ?></strong></td>
                  <td width="62%" align="left" class="fuente" ><label>
                    <input name="archivo_fot[<?=$i?>]" type="file" class="fuente" id="archivo_fot[<?=$i?>]" accept="image/jpeg"   >
                  </label></td>
                </tr>
                
                <? /*?>
                <tr>
                  <td width="38%" align="right" valign="top" class="fuente" ><strong>Descripci&oacute;n Foto<? echo $i; ?></strong></td>
                  <td width="62%" align="left" class="fuente" ><label for="descripcion_Txt"></label>
                    <input type="text" name="descripcion_Txt[<?=$i?>]"  title="Decripci�n de la Imagen <?=$i?>"id="descripcion_Txt[<?=$i?>]"></td>
                </tr>
				
				
				<? */?>
                <? } ?>
               <tr>
                  <td colspan="2" align="center" class="fuente" ><label>
                    <input type="submit" name="SendForm" id="SendForm" value=" Guardar " onClick="return validarcbo('cantidad')">
                  </label></td>
                </tr>
              </table>
              <input type="hidden" name="MM_insert" value="form1">
              <input name="id_producto" type="hidden" id="id_producto" value="<? echo $_GET['id_pro'];?>">
          
              <input name="id_tipo" type="hidden" id="id_tipo" value="1">
            </form></td>
            <td background="../img/cdo_der_fnd.jpg"></td>
          </tr>
          <tr>
            <td height="11"><img src="../img/cdo_dwn_izq.jpg" width="11" height="11"/></td>
            <td background="../img/cdo_dwn_fnd.jpg"></td>
            <td><img src="../img/cdo_dwn_der.jpg" width="11" height="11"/></td>
          </tr>
        </table>
          <blockquote>
            <p><a href="ver.php?id_pro=<? echo $_GET['id_pro'];?>" class="fuente linksRojo">&laquo; <strong>Volver al Detalle de 
              Empresa
              </strong></a></p>
            <p><a href="index.php" class="fuente linksRojo">&laquo; <strong>Volver al Listado de
                  Empresas
              </strong></a> </p>
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