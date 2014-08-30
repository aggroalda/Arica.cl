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
  $QUERY_STRING=$_SERVER['QUERY_STRING'];
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

if (isset($_GET['rubro'])) {
  $colname_rsProducto2 = $_GET['rubro'];
}



mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsProducto = sprintf("SELECT * FROM empresa,empresa_rubro WHERE empresa.Id_Empresa  = %s  AND empresa.Id_Rubro_Empresa = empresa_rubro.Id_Rubro", GetSQLValueString($colname_rsProducto, "int"));
$rsProducto = mysql_query($query_rsProducto, $cnx_arica) or die(mysql_error());
$row_rsProducto = mysql_fetch_assoc($rsProducto);
$totalRows_rsProducto = mysql_num_rows($rsProducto);

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsProducto2 = sprintf("SELECT * FROM empresa_rubro WHERE empresa_rubro.Id_Rubro = %s ", GetSQLValueString($colname_rsProducto2, "int"));
$rsProducto2 = mysql_query($query_rsProducto2, $cnx_arica) or die(mysql_error());
$row_rsProducto2 = mysql_fetch_assoc($rsProducto2);
$totalRows_rsProducto2 = mysql_num_rows($rsProducto2);



?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript" src="../js/justcorners.js"></script>
<script type="text/javascript" src="../js/corner.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
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
       <strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../empresas/index.php">M&oacute;dulo de Empresa</a> / <a id="guia_titulos" href="#">Detalles</a></p></strong>
      <p class="titles">&raquo; M&oacute;dulo de Empresas / Detalles</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
             <td width="11" height="11" id="cdo_top_izq"></td>
                  <td colspan="2" height="11" id="cdo_top_fnd"></td>
                  <td width="11" height="11" id="cdo_top_der"></td>
          </tr>
          <tr>
            <td rowspan="3" background="../img/cdo_izq_fnd.jpg"></td>
            <td width="1000" valign="top" bgcolor="#EBEBEB"><table width="100%" align="center" >
              
              <tr>
                <td align="right" valign="middle" class="fuente" width="20%"><strong>Nombre de Empresa :</strong></td>
                <td align="left" class="fuente"><?php echo utf8_encode($row_rsProducto['Nombre_Emp']); ?></td>
                </tr>
                
                 <tr>
                    <td align="right" class="fuente"><strong>Imagen Adjunta :</strong></td>
                    <td class="fuente"><? if ($row_rsProducto['Foto_Emp']) { ?><img id="img_padding_ver" src="../includes/imagen.php?ubica=../../empresas/img/&nw=300&foto=<?php echo $row_rsProducto['Foto_Emp']; ?>"><? } else { ?>No existe imagen adjunta<? } ?></td>
                    <td><input type="hidden" id="fotoNoticia" name="fotoNoticia" value="<?=$row_rsProducto['Foto_Emp']?>"></td>
                  </tr>
                 <tr>
                    <td align="right" class="fuente"><strong>Descripci&oacute;n :</strong></td>
                    <td align="left" class="fuente"><p  id="p_descripcion_ver" align="justify"><?php echo utf8_encode($row_rsProducto['Descripcion_Emp']); ?></p></td>
                  </tr>
                  
                   <tr>
                    <td align="right" class="fuente"><strong>Rubro :</strong></td>
                    <td align="left" class="fuente"><?php echo utf8_encode($row_rsProducto['Nombre_Rubro']); ?></td>
                  </tr>
     
     
     			 <tr>
                <td align="right" valign="top" class="fuente" ><strong>Estado :</strong></td>
                <td align="left" valign="top" class="fuente" ><?php $estado = $row_rsProducto['Estado_Emp'];
				if ($estado == 1) {
				echo "Habilitado";
				} else {
				echo "Deshabilitado";
				}
				?></td>
              </tr>
                  <? if(($row_rsProducto['Ciudad_Emp'])!=NULL){ ?> 
                  <tr>
                    <td align="right" class="fuente"><strong>Ciudad :</strong></td>
                    <td align="left" class="fuente"><?php echo utf8_encode($row_rsProducto['Ciudad_Emp']); ?></td>
                  </tr>
       <? }?>
       <? if(($row_rsProducto['Direccion_Emp'])!=NULL){ ?>
         <tr>
                    <td align="right" class="fuente"><strong>Dirección:</strong></td>
                    <td align="left" class="fuente"><?php echo utf8_encode($row_rsProducto['Direccion_Emp']); ?></td>
                  </tr>
                 <? }?>
                 <? if(($row_rsProducto['Telefono_Emp'])!=NULL){ ?>
         <tr>
                    <td align="right" class="fuente"><strong>Teléfono :</strong></td>
                    <td align="left" class="fuente"><?php echo utf8_encode($row_rsProducto['Telefono_Emp']); ?></td>
                  </tr>
     
         <tr>
         <? }?>
              <? if(($row_rsProducto['Correo_Emp'])!=NULL){ ?>
                    <td align="right" class="fuente"><strong>Correo :</strong></td>
                    <td align="left" class="fuente"><?php echo utf8_encode($row_rsProducto['Correo_Emp']); ?></td>
                  </tr>
                  <? }?>
     
            </table></td>
            <td ></td>
            <td rowspan="3" width="13" background="../img/cdo_der_fnd.jpg"></td>
          </tr>
           <tr>
             <td height="11" colspan="2" align="left" bgcolor="#EBEBEB"></td>
           </tr>
          
          <tr>
            <td height="11" colspan="2" align="left" bgcolor="#EBEBEB"><a href="../empresas/editar.php?id_pro=<?php echo $row_rsProducto['Id_Empresa']; ?>" class="fuente linksRojo"><strong>EDITAR ESTE EMPRESA</strong></a></td>
            </tr>
            
          <tr>
            <td id="cdo_dwn_izq" height="11" width="11"></td>
                  <td id="cdo_dwn_fnd" height="11" colspan="2" ></td>
                  <td id="cdo_dwn_der"></td>
          </tr>
        </table>
          <blockquote>
          <p><a href="../empresas/agregar.php" class="fuente linksRojo"><strong>[+] Agregar Nuevo Empresa</strong></a></p>
         
            <p><a href="../empresas/index.php" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Empresas</strong></a></p>
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





?>