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

	
  $insertSQL = sprintf("INSERT INTO articulos_clasificados (Titulo_Articulo,Id_Clasificados,Descripcion_Articulo,Contacto_Telefono,Contacto_Correo,Fecha_Articulo) VALUES (%s,%s,%s,%s,%s,%s)",
                     GetSQLValueString(utf8_decode($_POST['titulo_Txt']), "text"),
					 GetSQLValueString(utf8_decode($_POST['tiposub_Txt']), "int"),
                     GetSQLValueString(utf8_decode($_POST['descripcion_Txt']), "text"),
					 GetSQLValueString($_POST['telefono_Txt'], "text"),
					 GetSQLValueString(utf8_decode($_POST['correo_Txt']), "text"),
                       GetSQLValueString($_POST['fecha_Txt'], "text")
					);

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
  $id_not = mysql_insert_id($cnx_arica);


 header("Location: index.php");
   
	 
}


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTipo = "SELECT * FROM clasificados ORDER BY titulo_clasificado ASC";
$rsTipo = mysql_query($query_rsTipo, $cnx_arica) or die(mysql_error());
$row_rsTipo = mysql_fetch_assoc($rsTipo);
$totalRows_rsTipo = mysql_num_rows($rsTipo);
?>
<?
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTipo2 = "SELECT * FROM categoria_clasificado ORDER BY Nombre_CatCla ASC";
$rsTipo2 = mysql_query($query_rsTipo2, $cnx_arica) or die(mysql_error());
$row_rsTipo2 = mysql_fetch_assoc($rsTipo2);
$totalRows_rsTipo2 = mysql_num_rows($rsTipo2);

?>


    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
     <strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../articulos_clasificados/index.php">M&oacute;dulo Anuncio de Clasificado</a></p></strong>
      <p class="titles">&raquo; M&oacute;dulo Anuncio de Clasificado / Agregar</p>
    
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><blockquote>
          <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <td width="11" height="11" id="cdo_top_izq"></td>
                  <td width="849" height="11" id="cdo_top_fnd"></td>
                  <td width="11" height="11" id="cdo_top_der"></td>
            </tr>
            <tr>
              <td background="../img/cdo_izq_fnd.jpg"></td>
              <td bgcolor="#EBEBEB"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
                <table width="100%">
                  
               
                                  
                  <tr>
                    <td align="right" class="fuente"><strong>Titulo de Art&iacute;culo:</strong></td>
 <td align="left"><label for="titulo_Txt"></label><input name="titulo_Txt" type="text" class="fuente" id="titulo_Txt" size="50" title="Titulo"><input name="fecha_Txt" type="hidden" class="fuente" id="fecha_Txt" size="35" title="Fecha" value="<? $fecha=date('Y-m-d H:i:s');echo $fecha;?>"></td>
                  </tr>
                  
                  
                  <tr>
                    <td align="right" class="fuente"><strong>Categor&iacute;a Clasificado:</strong></td>
                    <td align="left"><label for="tipo_Txt"></label><select name="tipo_Txt" class="fuente" id="tipo_Txt"  title="Nombre tIPO"  onChange=" cargar('cargar_subcategorias.php?Id_CategoriaClasificado='+this.value,'tiposub_Txt')">
                   <option value="">-- Seleccione --</option>
                    <? do {?>
                    <option value="<? echo $row_rsTipo2['Id_CategoriaClasificado']?>"><? echo utf8_encode($row_rsTipo2['Nombre_CatCla'])?></option>
                    <? }while ($row_rsTipo2=mysql_fetch_assoc($rsTipo2));
						 
						  if($totalRows_rsTipo2 > 0) {
							  mysql_data_seek($rsTipo2, 0);
							  $row_rsTipo2 = mysql_fetch_assoc($rsTipo2);
						                }
					
					?>
                    </select>
                    </td>
                  </tr>
                  
                  <tr>
                    <td align="right" class="fuente"><strong>Sub Categor&iacute;a Clasificado:</strong></td>
                     <td align="left"><label for="tiposub_Txt"></label><select name="tiposub_Txt" class="fuente" id="tiposub_Txt"  title="Nombre tIPOsub">
                   <option value=""><!---- Seleccione ----></option>
                    <?php /*?><? do {?>
                    <option value="<? echo $row_rsTipo['Id_Clasificados']?>"><? echo utf8_encode($row_rsTipo['titulo_clasificado'])?></option>
                    <? }while ($row_rsTipo=mysql_fetch_assoc($rsTipo));
						  
						  if($totalRows_rsTipo> 0) {
							  mysql_data_seek($rsTipo, 0);
							  $row_rsTipo = mysql_fetch_assoc($rsTipo);
						                }
					
					?><?php */?>
                    </select>
                    </td>
                  </tr>
                  
                <tr>
                 
                    <td height="95" align="right" valign="top" class="fuente"><strong>Descripci&oacute;n:</strong></td>
                    <td align="left"><label for="descripcion_Txt"></label>
                      <textarea name="descripcion_Txt" id="descripcion_Txt" title="Descripción" cols="45" rows="5"></textarea></td>
                  </tr>
                  
                  
                   <tr>
                    <td align="right" class="fuente"><strong>Tel&eacute;fono Contacto:</strong></td>
<td><input name="telefono_Txt" type="text" class="fuente" id="telefono_Txt" size="30" title="Telefono">
</td>
                  </tr>
                  
                  
                   <tr>
                    <td align="right" class="fuente"><strong>Correo Contacto:</strong></td>
<td><input name="correo_Txt" type="text" class="fuente" id="correo_Txt" size="40" title="Telefono">
</td>
                  </tr>
         				<?php /*?><tr>
                    <td align="right" class="fuente"><strong>Cantidad de Im&aacute;genes:</strong></td>
                    <td align="left"><label for="cantidad_Txt"></label>
                      <select name="cantidad_Txt" id="cantidad_Txt" >
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                      </select></td>
                  </tr><?php */?>
                  
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
              <td id="cdo_dwn_izq" height="11" width="11"></td>
                  <td id="cdo_dwn_fnd" height="11"></td>
                  <td id="cdo_dwn_der"></td>
            </tr>
          </table>
          <p><a href="javascript:cargar('noticiapagina.php','tbnoticia')" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Articulos</strong></a></p>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table></td>



<? ob_end_flush;?>