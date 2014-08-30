<?php require_once('../../0_SOURCE/Connections/cnx_arica.php'); ?>
<? 
if ($_GET['cantidad']!='') {
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsColor = "SELECT * FROM color";
$rsColor = mysql_query($query_rsColor, $cnx_arica) or die(mysql_error());
$row_rsColor = mysql_fetch_assoc($rsColor);
$totalRows_rsColor = mysql_num_rows($rsColor);

} /*FIN totalrows_rscolor >0 */ 
?>
      <? for ($i=1;$i<=$_GET['cantidad'];$i++) { ?> 
                <tr>
                  <td width="38%" align="right" valign="top" class="fuente" ><strong>Color  <? echo $i; ?></strong></td>
              
                        <?   if ($totalRows_rsColor>0) { ?>
                        <td>
                       <select name= "colores[<?=$i?>]" class="fuente" id="colores[<?=$i?>]" onChange= "precio_Txt.focus()" >
                       <option value="">-- Seleccione --</option>
                        <?php do {  ?>
                        <option value="<?php echo $row_rsColor['Id_Color'];?>"> <?php echo $row_rsColor['Nombre_Col'];?></option>
                           <?php } while ($row_rsColor = mysql_fetch_assoc($rsColor));
						  $rows = mysql_num_rows($rsColor);
						  if($rows > 0) {
							  mysql_data_seek($rsColor, 0);
							  $row_rsColor = mysql_fetch_assoc($rsColor);
						                } ?>
                          </select></td>
	                                                <? } ?>
               
                 </tr>
              
                <? } ?>
         