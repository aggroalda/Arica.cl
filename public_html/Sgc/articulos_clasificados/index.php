<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php include('../includes/salida2.php');?>
<?php include('../includes/restriccion2.php');?>
<?php include ("../includes/funciones.php");


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsNovedad = "SELECT * FROM articulos_clasificados ORDER BY Id_Articulo DESC";
$rsNovedad = mysql_query($query_rsNovedad, $cnx_arica) or die(mysql_error());
$row_rsNovedad = mysql_fetch_assoc($rsNovedad);
$totalRows_rsNovedad = mysql_num_rows($rsNovedad);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript">
$.validator.methods.equal = function(value, element, param) {
		return value == param;
	};
	$(document).ready(function(){
				
		$("#form1").validate({
				rules: {
					titulo_Txt: "required",
					fecha_Txt: "required",
					tipo_Txt: "required",
					tiposub_Txt:"required",
					descripcion_Txt:"required",
					
				},
				messages: {
					titulo_Txt: "Requerido",
					fecha_Txt: "Requerido",
					tipo_Txt: "Requerido",
					tiposub_Txt:"Requerido",
					descripcion_Txt: "Requerido",
					
					}
			});
	});
</script>
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/mootools-yui-compressed.js"></script>
<script type="text/javascript" src="../js/sexylightbox.v2.3.mootools.min.js"></script>
<link rel="stylesheet" href="../css/sexylightbox.css" type="text/css" media="all" />
</head>
<body>
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tbody id="tbnoticia">

        <? include('noticiapagina.php')?>
  </tbody>
  <? include("../option/footer.php"); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsOptions);

mysql_free_result($rsNovedad);
?>