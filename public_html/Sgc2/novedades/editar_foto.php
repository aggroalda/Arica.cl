<? ob_start(); ?>
<?php require_once('../../Connections/cnx_arica.php'); ?>
<?
include('../includes/salida2.php');


include('../includes/restriccion2.php');
include('../includes/funciones.php');

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE galeria SET Descripcion_Gal=%s WHERE Id_Galeria=%s",
                      
                       GetSQLValueString(utf8_decode($_POST['descripcion_gal']), "text"),
                       GetSQLValueString(utf8_decode($_POST['id_gal']), "int"));

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL, $cnx_arica) or die(mysql_error());

  header("Location: ver.php?id_not=".$_GET['id_not']);
}

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT * FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$colname_rsGaleria = "-1";
if (isset($_GET['id_gal'])) {
  $colname_rsGaleria = $_GET['id_gal'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsGaleria = sprintf("SELECT * FROM galeria where Id_Galeria = %s", GetSQLValueString($colname_rsGaleria, "int"));
$rsGaleria = mysql_query($query_rsGaleria, $cnx_arica) or die(mysql_error());
$row_rsGaleria = mysql_fetch_assoc($rsGaleria);
$totalRows_rsGaleria = mysql_num_rows($rsGaleria);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
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
    <td><blockquote>
      <strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../novedades/index.php"> M&oacute;dulo de Noticia</a> / <a id="guia_titulos" href="ver.php?id_not=<? echo $_GET['id_not'];  ?>"> Detalles </a> </p></strong>
      <p class="titles">&raquo; M&oacute;dulo de Noticia / Editar Fotos</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle">
          <table width="83%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
             <td width="11" height="11" id="cdo_top_izq"></td>
                <td width="749" height="11" id="cdo_top_fnd"></td>
                <td width="11" height="11" id="cdo_top_der"></td>
            </tr>
            <tr>
              <td background="../img/cdo_izq_fnd.jpg"></td>
              <td bgcolor="#EBEBEB"><form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
                <table width="100%">
                   <tr>
                  <td colspan="2" align="center" class="fuente"><strong>Visualizaci&oacute;n de Imagen:</strong></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" class="fuente"><img src="../../novedades/img/<?php echo $row_rsGaleria['Archivo_Gal']; ?>" alt=""></td>
                </tr>
                  <tr>
                    <td align="right" valign="top" class="fuente"><p>&nbsp;</p>
                      <p><strong>Descripci&oacute;n Foto:</strong></p></td>
                    <td><label>
                      <textarea name="descripcion_gal" cols="45" rows="5" class="fuente" id="descripcion_gal" title="Descripción"><?php echo utf8_encode($row_rsGaleria['Descripcion_Gal']); ?></textarea>
                    </label></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center">
                      <input type="hidden" name="id_gal" value="<?php echo $row_rsGaleria['Id_Galeria']; ?>">
                      <input name="Enviar" type="submit" class="fuente" id="Enviar" onClick="MM_validateForm('nombre_gal','','R','descripcion_gal','','R');return document.MM_returnValue" value="  Guardar Cambios  ">
                    </td>
                    </tr>
                </table>
                <input name="MM_update" type="hidden" id="MM_update" value="form1">
              </form></td>
              <td background="../img/cdo_der_fnd.jpg"></td>
            </tr>
            <tr>
               <td id="cdo_dwn_izq" height="11" width="11"></td>
                  <td id="cdo_dwn_fnd" height="11"></td>
                  <td id="cdo_dwn_der"></td>
            </tr>
          </table>
            <blockquote>
              <p>&nbsp;</p>
              <p><a href="ver.php?id_not=<? echo $_GET['id_not'];  ?>" class="fuente linksRojo"><strong>&laquo; Volver a Detalle de Noticia</strong></a></p>
              <p><a href="index.php" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Noticia</strong></a></p>
              <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
              </blockquote>          
            </blockquote>
            </td>
        </tr>
    </table></td>
  </tr>
  <? include("../option/footer.php"); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsOptions);

mysql_free_result($rsGaleria);
?>
<? ob_flush(); ?>