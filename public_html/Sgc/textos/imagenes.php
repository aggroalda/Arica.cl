<?php require_once('../../0_SOURCE/Connections/cnx_arica.php'); ?>
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
	
  $logoutGoTo = "../../0_SOURCE/SGC_INTERNET/index.php";
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

$MM_restrictGoTo = "../../0_SOURCE/SGC_INTERNET/index.php?error=2";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	$image = $_FILES['archivo_fot']['name'];
	$tempora = $_FILES['archivo_fot']['tmp_name'];
	$num = $_POST['cantidad'];
	$idpro = $_POST['id_producto'];
	$width = 600;
	
	for ($i=1;$i<=$num;$i++) {
	
		if ($image[$i]) { // si el campo de foto tiene contenido
		
			$ext = strtolower(substr($image[$i], -3));
			
			if (($ext == "jpg") || ($ext == "gif")) { // si la imagen es jpg
			
				if (move_uploaded_file($tempora[$i], "../../productos/images/".$image[$i])) { // intentamos guardar la imagen en el servidor
				
					list($ancho, $alto, $tipo, $atr) = getimagesize("../../productos/images/".$image[$i]);
					
					if ($ancho > $width) { // si ancho es mas que el permitodo
					
						$file = "../../productos/images/".$image[$i];
					
						$height = ($alto/$ancho)*$width;
							if ($ext=="jpg") {
							$imSrc  = imagecreatefromjpeg($file);
							}
							if ($ext=="gif") {
							$imSrc  = imagecreatefromgif($file);
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
					} // fin de si ancho es mas que el permitodo
			
				}  // fin de que si no se pudo guardar en el servidor la imagen 
			
		}  // fin de si la imagen no es jpg
	  
  $insertSQL = sprintf("INSERT INTO galeria (Tipo_Gal, IdProducto_Gal, Archivo_Gal) VALUES (%s, %s, %s)",
   					   GetSQLValueString($_POST['id_tipo'], "int"),
					   GetSQLValueString($idpro, "int"),
                       GetSQLValueString($image[$i], "text"));

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());

	  } // fin de si la foto tiene contenido

  } // termina el for
  
  if ($_GET['tipo']==3) {	
		header("Location: ../textos/ver.php?pagina=casa");
	} elseif ($_GET['tipo']==2) {
		header("Location: ../galeria/ver.php?id_alb=$idpro");
	} else {
		header("Location: ver.php?id_pro=$idpro");
	}
}

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

if ($_GET['tipo']!=2) {
	
$colname_rsProductos = "-1";
if (isset($_GET['id_pro'])) {
  $colname_rsProductos = $_GET['id_pro'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsProductos = sprintf("SELECT Id_Productos, Nombre_Pro FROM productos WHERE Id_Productos = %s", GetSQLValueString($colname_rsProductos, "int"));
$rsProductos = mysql_query($query_rsProductos, $cnx_arica) or die(mysql_error());
$row_rsProductos = mysql_fetch_assoc($rsProductos);
$totalRows_rsProductos = mysql_num_rows($rsProductos);

} else {

$colname_rsProductos = "-1";
if (isset($_GET['id_pro'])) {
  $colname_rsProductos = $_GET['id_pro'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsProductos = sprintf("SELECT Id_Album, Nombre_Alb FROM album WHERE Id_Album = %s", GetSQLValueString($colname_rsProductos, "int"));
$rsProductos = mysql_query($query_rsProductos, $cnx_arica) or die(mysql_error());
$row_rsProductos = mysql_fetch_assoc($rsProductos);
$totalRows_rsProductos = mysql_num_rows($rsProductos);

}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../../0_SOURCE/SGC_INTERNET/css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../0_SOURCE/SGC_INTERNET/js/td_over.js"></script>
</head>
<body>
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../../0_SOURCE/SGC_INTERNET/option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
      <p class="titles">&raquo; M&oacute;dulo de <?php if ($_GET['tipo']==1) { ?>Productos<? } if ($_GET['tipo']==2) { ?>Galer�a de Fotos<? } if ($_GET['tipo']==3) { ?>Textos<? } ?> - Agregar Fotos</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="11"><img src="../../0_SOURCE/SGC_INTERNET/img/cdo_top_izq.jpg"/></td>
            <td width="929" background="../../0_SOURCE/SGC_INTERNET/img/cdo_top_fnd.jpg"></td>
            <td width="11"><img src="../../0_SOURCE/SGC_INTERNET/img/cdo_top_der.jpg"/></td>
          </tr>
          <tr>
            <td background="../../0_SOURCE/SGC_INTERNET/img/cdo_izq_fnd.jpg"></td>
            <td bgcolor="#EBEBEB"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
              <table width="100%" align="center" >
                <tr>
                  <td colspan="2" align="center" class="fuente" >Agregando fotos al <?php if ($_GET['tipo']==1) { ?>producto: <? } if ($_GET['tipo']==2) { ?>album: <? } if ($_GET['tipo']==3) ?> texto de: <strong><?php if ($_GET['tipo']==1) { echo $row_rsProductos['Nombre_Pro'];  } if ($_GET['tipo']==2) { echo $row_rsProductos['Nombre_Alb']; } if ($_GET['tipo']==3) { if ($_GET['pagina']=="casa") { echo "Casa Eventos"; } else { "Nosotros"; } } ?></strong></td>
                  </tr>
                <tr>
                  <td align="right" class="fuente" ><strong>N&uacute;mero de Fotos:</strong></td>
                  <td align="left" class="fuente" ><label>
                    <select name="cantidad" class="fuente" id="cantidad" onChange="document.location=('imagenes.php?tipo=<?=$_GET['tipo']?>&id_pro=<?=$_GET['id_pro']?>&cantidad=' + form1.cantidad.options[form1.cantidad.selectedIndex].value)">
                      <? for ($i=1;$i<=10;$i++) { ?>
                        <option value="<?=$i?>" <? if ($_GET['cantidad'] == $i) echo " selected"; ?>><?=$i?></option>
                      <? } ?>
                      </select>
                  </label></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" valign="top" class="linksRojo" >S&oacute;lo se aceptan im&aacute;genes con extensi&oacute;n JPG</td>
                  </tr>
                <? for ($i=1;$i<=$_GET['cantidad'];$i++) { ?> 
                <tr>
                  <td width="38%" align="right" valign="top" class="fuente" ><strong>Foto <? echo $i; ?></strong></td>
                  <td width="62%" align="left" class="fuente" ><label>
                    <input name="archivo_fot[<?=$i?>]" type="file" class="fuente" id="archivo_fot[<?=$i?>]" accept="image/jpeg">
                  </label></td>
                </tr>
                <? } ?>
                <tr>
                  <td colspan="2" align="center" class="fuente" ><label>
                    <input type="submit" name="SendForm" id="SendForm" value="  Guardar  ">
                  </label></td>
                </tr>
              </table>
              <input type="hidden" name="MM_insert" value="form1">
              <input name="id_producto" type="hidden" id="id_producto" value="<? echo $_GET['id_pro'];?>">
              <input name="id_tipo" type="hidden" id="id_tipo" value="<? echo $_GET['tipo'];?>">
            </form></td>
            <td background="../../0_SOURCE/SGC_INTERNET/img/cdo_der_fnd.jpg"></td>
          </tr>
          <tr>
            <td height="11"><img src="../../0_SOURCE/SGC_INTERNET/img/cdo_dwn_izq.jpg" width="11" height="11"/></td>
            <td background="../../0_SOURCE/SGC_INTERNET/img/cdo_dwn_fnd.jpg"></td>
            <td><img src="../../0_SOURCE/SGC_INTERNET/img/cdo_dwn_der.jpg" width="11" height="11"/></td>
          </tr>
        </table>
          <blockquote><a href="javascript:history.back(1)" class="fuente linksRojo">&laquo; <strong>Volver al Listado de <?php if ($_GET['tipo']==1) { ?>Productos<? } if ($_GET['tipo']==2) { ?>Galer�a de Fotos<? } if ($_GET['tipo']==3) { ?>Textos<? } ?></strong></a>
<p><a href="../../0_SOURCE/SGC_INTERNET/login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
          <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
        </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table></td>
  </tr>
  <? include("../../0_SOURCE/SGC_INTERNET/option/footer.php"); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsOptions);

mysql_free_result($rsProductos);
?>
