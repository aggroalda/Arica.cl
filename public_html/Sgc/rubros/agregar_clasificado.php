<?php require_once('../../Connections/cnx_arica.php'); ?>
<? ob_start();?>
<?php include('../includes/salida2.php');?>
<?php include('../includes/restriccion2.php');?>
<?php include('../includes/funciones.php');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
session_start();
$nivel= $_SESSION['MM_IdNivel'];
$usuario=$_SESSION['MM_IdUser'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	if ($_POST["portada"]=="1" ) {
	$portada= 1;
	
	 } else {
	$portada= 0;
	
	 }
	
	if ($_POST['radio_oferta']=="1" ) {
	$oferta= 1;
	
	 } else {
	$oferta= 0;
	
	 }

	
  $insertSQL = sprintf("INSERT INTO clasificados(titulo_clasificado,Descripcion_Cla,fecha_clasificado,IdCategoriaCla_Cla) VALUES (%s,%s,%s,%s)",
                GetSQLValueString($_POST['titulo_Txt'], "text"),
				GetSQLValueString($_POST['descripcion_Txt'], "text"),
				GetSQLValueString($_POST['fecha_Txt'], "text"),
				GetSQLValueString($_POST['tipo_Txt'], "int") );
mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
  $id_not = mysql_insert_id($cnx_arica);


 header("Location: categoria.php?id_cat=".$_GET['id_cat']);
   
	 
}


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTipo = "SELECT * FROM categoria_clasificado";
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
					nombre_Txt: "required",
					fecha_Txt: "required",
					tipo_Txt: "required",
					descripcion_Txt:"required",
				},
				messages: {
					titulo_Txt: "Requerido",
					nombre_Txt: "Requerido",
					fecha_Txt: "Requerido",
					tipo_Txt: "Requerido",
					descripcion_Txt: "Requerido",
					
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
      <p class="titles">&raquo; M&oacute;dulo de Clasificados- Agregar</p>
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
                  
                    <td align="right" class="fuente"><strong>Categor�a :</strong></td>
                    <td><select name="tipo_Txt" class="fuente" id="tipo_Txt"  title="Nombre tIPO">
                   <option value="">Seleccione</option>
                    <? do {?>
                    <option value="<? echo $row_rsTipo['Id_CategoriaClasificado']?>"><? echo $row_rsTipo['Nombre_CatCla']?></option>
                    <? }while ($row_rsTipo=mysql_fetch_assoc($rsTipo));?>
                    </select>
                    </td>
                    
                  </tr>
                  
                  
                     <tr>
                 
                       <td align="right" class="fuente"><strong>T&iacute;tulo Clasificado:</strong></td>
                    <td><label for="categoria_Txt2"></label>
                      <label for="nombre_Txt"></label>
      <input name="titulo_Txt" type="text" class="fuente" id="titulo_Txt" title="Nombre de Categor�a" value=""/>
      </td>
                 </tr>
                  
                <tr>
                 
                    <td height="95" align="right" valign="top" class="fuente"><strong>Descripci&oacute;n:</strong></td>
                    <td align="left"><label for="descripcion_Txt"></label>
                      <textarea name="descripcion_Txt" id="descripcion_Txt" title="Descripci�n" cols="45" rows="5"></textarea>
                      <input name="fecha_Txt" type="hidden" class="fuente" id="fecha_Txt" size="35" title="Fecha" value="<? $fecha=date('Y-m-d H:i:s');echo $fecha;?>">
                      </td>
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
          <p><a href="index.php" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Clasificados</strong></a></p>
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


ob_end_flush();

?>