<?php require_once('../../Connections/cnx_arica.php'); ?>
<? if (isset($_GET['id_emp'])) {
	
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCiudad = "SELECT * FROM ciudad,pais where ciudad.IdPais_Ciu= pais.Id_Pais";
$rsCiudad = mysql_query($query_rsCiudad, $cnx_arica) or die(mysql_error());
$row_rsCiudad = mysql_fetch_assoc($rsCiudad);
$totalRows_rsCiudad = mysql_num_rows($rsCiudad);
?>
<blockquote>   
    	
<table width="500" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="11"><img src="../img/cdo_top_izq.jpg"/></td>
    <td width="478" background="../img/cdo_top_fnd.jpg"></td>
    <td width="11"><img src="../img/cdo_top_der.jpg"/></td>
  </tr>
  <tr>
    <td background="../img/cdo_izq_fnd.jpg"></td>
    <td bgcolor="#EBEBEB">
    <div id="divReserva">
    <table width="100%">
    <form id="file_upload_form" method="post" enctype="multipart/form-data" action="upload.php">
      <tr>
        <td width="38%" align="right" class="fuente linksRojo"><strong>Desde:</strong></td>
        <td width="62%">
        
        <input name="id_emp" type="hidden"  id="id_emp" value="<? echo $_GET['id_emp'];?>">
          <select name="ciudad1_Txt" id="ciudad1_Txt" class="fuente">
            <?php do { ?>
            <option value="<?php echo $row_rsCiudad['Id_Ciudad']?>"><?php echo $row_rsCiudad['Nombre_Ciu']?>  (<? echo $row_rsCiudad['Nombre_Pai']?>)</option>
            <?php } while ($row_rsCiudad = mysql_fetch_assoc($rsCiudad));
			  $rows = mysql_num_rows($rsCiudad);
			  if($rows > 0) {
				  mysql_data_seek($rsCiudad, 0);
				  $row_rsCiudad = mysql_fetch_assoc($rsCiudad);
			  } ?>
          </select>
          </td>
      </tr>
      
      
      <tr>
        <td width="38%" align="right" class="fuente linksRojo"><strong>Hasta:</strong></td>
        <td width="62%">
        
   
          <select name="ciudad2_Txt" id="ciudad2_Txt" class="fuente">
            <?php do { ?>
            <option value="<?php echo $row_rsCiudad['Id_Ciudad']?>"><?php echo $row_rsCiudad['Nombre_Ciu']?>(<? echo $row_rsCiudad['Nombre_Pai']?>)</option>
            <?php } while ($row_rsCiudad = mysql_fetch_assoc($rsCiudad));
			  $rows = mysql_num_rows($rsCiudad);
			  if($rows > 0) {
				  mysql_data_seek($rsCiudad, 0);
				  $row_rsCiudad = mysql_fetch_assoc($rsCiudad);
			  } ?>
          </select>
          </td>
      </tr>
      
      
       <tr>
        <td width="38%" align="right" class="fuente linksRojo"><strong>Detalle:</strong></td>
        <td width="62%">
         <input type="text" id="detalle_Txt" name="detalle_Txt">
          </td>
      </tr>
      
      
        <tr>
        <td width="38%" align="right" class="fuente linksRojo"><strong>Precio:</strong></td>
         <td width="62%">
         <input type="text" id="precio_Txt" name="precio_Txt">
          </td>
      </tr>
      <? /*?>
        <tr>
        <td width="38%" align="right" class="fuente linksRojo"><strong>Foto:</strong></td>
         <td width="62%">
       <input type="file" id="foto_Txt" name="foto_Txt">
          </td>
      </tr>
	  <? */ ?>
       <tr>
        <td align="right"><a href="javascript:agregarruta_proceso('<?=$_GET['id_emp']?>')" id="btnGuardar" ><img border="0" src="../img/guardar.png"/></a></td>
        <td><a href="javascript:cargar('destinos.php?id_emp=<?php echo $_GET['id_emp']; ?>','dv<?php echo $_GET['id_emp']; ?>')" id="btnGuardar" ><img border="0" src="../img/volver.png"/></a></td>
      </tr>
    </table>
    </div></td>
    <td background="../img/cdo_der_fnd.jpg"></td>
  </tr>
  <tr>
    <td><img src="../img/cdo_dwn_izq.jpg" width="11" height="11"/></td>
    <td background="../img/cdo_dwn_fnd.jpg"></td>
    <td><img src="../img/cdo_dwn_der.jpg" width="11" height="11"/></td>
  </tr>
</table>
</blockquote>
<? } ?>
<?php
mysql_free_result($rsCiudad);
?>
