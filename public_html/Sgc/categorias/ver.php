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

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$colname_rsProducto = "-1";
if (isset($_GET['id_pro'])) {
  $colname_rsProducto = $_GET['id_pro'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsProducto = sprintf("SELECT * FROM productos, categoria WHERE Id_Productos = %s AND productos.IdSubcategoria_Pro = categoria.Id_Categoria", GetSQLValueString($colname_rsProducto, "int"));
$rsProducto = mysql_query($query_rsProducto, $cnx_arica) or die(mysql_error());
$row_rsProducto = mysql_fetch_assoc($rsProducto);
$totalRows_rsProducto = mysql_num_rows($rsProducto);

$colname_rsFotos = "-1";
if (isset($_GET['id_pro'])) {
  $colname_rsFotos = $_GET['id_pro'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsFotos = sprintf("SELECT * FROM galeria WHERE IdProducto_Gal = %s ORDER BY Id_Galeria ASC", GetSQLValueString($colname_rsFotos, "int"));
$rsFotos = mysql_query($query_rsFotos, $cnx_arica) or die(mysql_error());
$row_rsFotos = mysql_fetch_assoc($rsFotos);
$totalRows_rsFotos = mysql_num_rows($rsFotos);

$colname_rsColores = "-1";
if (isset($_GET['id_pro'])) {
  $colname_rsColores = $_GET['id_pro'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsColores = sprintf("SELECT * FROM productos_color, color WHERE productos_color.IdProducto_PCol = %s AND color.Id_Color = productos_color.IdColor_PCol", GetSQLValueString($colname_rsColores, "int"));
$rsColores = mysql_query($query_rsColores, $cnx_arica) or die(mysql_error());
$row_rsColores = mysql_fetch_assoc($rsColores);
$totalRows_rsColores = mysql_num_rows($rsColores);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript" src="../js/justcorners.js"></script>
<script type="text/javascript" src="../js/corner.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.3/mootools-yui-compressed.js"></script>
<script type="text/javascript" src="../js/sexylightbox.v2.3.mootools.min.js"></script>
<link rel="stylesheet" href="../css/sexylightbox.css" type="text/css" media="all" />
<script type="text/javascript">
    window.addEvent('domready', function(){
      SexyLightbox = new SexyLightBox({color:'black', dir: '../img/'});
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
      <p class="titles">&raquo; M&oacute;dulo de Productos - Detalles</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="11"><img src="../img/cdo_top_izq.jpg"/></td>
            <td colspan="2" background="../img/cdo_top_fnd.jpg"></td>
            <td width="11"><img src="../img/cdo_top_der.jpg"/></td>
          </tr>
          <tr>
            <td rowspan="2" background="../img/cdo_izq_fnd.jpg"></td>
            <td width="589" valign="top" bgcolor="#EBEBEB"><table width="100%" align="center" >
              <tr >
                <td align="right" valign="middle" class="fuente"><strong>Categor&iacute;a:</strong></td>
                <td align="left" class="fuente"><?php echo $row_rsProducto['Nombre_Cat']; ?> / <?php echo $row_rsProducto['Name_Cat']; ?></td>
              </tr>
              <tr >
                <td align="right" valign="middle" class="fuente"><strong>Nombre:</strong></td>
                <td align="left" class="fuente"><?php echo $row_rsProducto['Nombre_Pro']; ?></td>
                </tr>
              <tr >
                <td width="25%" align="right" valign="top" class="fuente"><strong>Largo:</strong></td>
                <td width="35%" align="left" class="fuente"><?php echo $row_rsProducto['Largo_Pro']; ?></td>
              </tr>
              <tr>
                <td align="right" class="fuente" ><strong>Ancho:</strong></td>
                <td align="left" class="fuente" ><?php echo $row_rsProducto['Ancho_Pro']; ?></td>
                </tr>
              <tr>
                <td align="right" class="fuente" ><strong>Alto:</strong></td>
                <td align="left" class="fuente" ><?php echo $row_rsProducto['Alto_Pro']; ?></td>
              </tr>
              <tr>
                <td align="right" class="fuente" ><strong>Colores:</strong></td>
                <td align="left" class="fuente" ><?php do { ?>
                    <div style="width:15px; height:15px; display:block; background:<?php echo $row_rsColores['Valor_Col']; ?>"></div> 
                    &nbsp;
                    <?php } while ($row_rsColores = mysql_fetch_assoc($rsColores)); ?></td>
              </tr>
              <tr>
                <td align="right" class="fuente" ><strong>Descripci&oacute;n:</strong></td>
                <td align="left" class="fuente" ><?php echo $row_rsProducto['Descripcion_Pro']; ?></td>
              </tr>
              <tr>
                <td align="right" class="fuente" ><strong>Precio:</strong></td>
                <td align="left" class="fuente" >S/. <?php echo $row_rsProducto['Precio_Pro']; ?></td>
              </tr>
              <tr>
                <td align="right" valign="top" class="fuente" ><strong>Estado:</strong></td>
                <td align="left" valign="top" class="fuente" ><?php $visible = $row_rsProducto['Estado_Pro'];
				if ($visible == 1) {
				echo "Habilitado";
				} else {
				echo "Deshabilitado";
				}
				?></td>
              </tr>
            </table></td>
            <td width="340" valign="top" bgcolor="#EBEBEB"><table width="100%">
              <tr>
                <td align="center" class="fuente"><p><strong>Im&aacute;genes Agregadas:</strong></p>
                  <?php if ($totalRows_rsFotos == 0) { // Show if recordset empty ?>
  <p>Sin imagenes agregadas por el momento</p>
  <?php } // Show if recordset empty ?>
<?php if ($totalRows_rsFotos > 0) {
				  $i=1;
				  do { ?>
                  <p><strong>Foto
                    <? echo $i; ?>
                    </strong><br>
                    <a style="cursor:hand;" rel="sexylightbox[group1]" title="<? echo $row_rsProducto['Nombre_Pro'];?>"  href="../../productos/images/<?php echo $row_rsFotos['Archivo_Gal']; ?>"><img src="../../0_SOURCE/inc/productos/images/&nw=150&foto=<?php echo $row_rsFotos['Archivo_Gal']; ?>" class="corners iradius8 iborder1 icolor999999" border="0" style="margin:5px 0 5px 0;"></a><br>
                    <a href="javascript:preguntarfoto('<?php echo $row_rsFotos['Id_Galeria']; ?>','<?=$i?>','<? echo $row_rsProducto['Id_Productos']; ?>')" class="fuente linksRojo">[X] Eliminar</a></p>
                  </div>
                  <?php 
					$i++;
					} while ($row_rsFotos = mysql_fetch_assoc($rsFotos)); } ?>
                  <p><strong>___________________<br>
                    <a href="../../0_SOURCE/SGC_INTERNET/categorias/imagenes.php?cantidad=1&id_pro=<?php echo $row_rsProducto['Id_Productos']; ?>" class="linksRojo"> <br>
                      [+] Agregar Imagen</a></strong></p>
                  &nbsp;</td>
              </tr>
            </table></td>
            <td rowspan="2" background="../img/cdo_der_fnd.jpg"></td>
          </tr>
          <tr>
            <td height="11" colspan="2" align="left" bgcolor="#EBEBEB"><a href="editar.php?id_pro=<?php echo $row_rsProducto['Id_Productos']; ?>" class="fuente linksRojo"><strong>EDITAR ESTE PRODUCTO</strong></a></td>
            </tr>
          <tr>
            <td height="11"><img src="../img/cdo_dwn_izq.jpg" width="11" height="11"/></td>
            <td colspan="2" background="../img/cdo_dwn_fnd.jpg"></td>
            <td><img src="../img/cdo_dwn_der.jpg" width="11" height="11"/></td>
          </tr>
        </table>
          <blockquote>
          <p><a href="agregar.php" class="fuente linksRojo"><strong>[+] Agregar Nuevo Producto</strong></a></p>
          <p><a href="index.php" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Productos</strong></a></p>
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

mysql_free_result($rsProducto);

mysql_free_result($rsFotos);

mysql_free_result($rsColores);
?>