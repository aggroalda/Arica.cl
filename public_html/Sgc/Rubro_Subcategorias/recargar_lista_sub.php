<?php 
$colname_rsRubro = "-1";
if (isset($_GET['id_rub'])) {
$colname_rsRubro = $_GET['id_rub'];
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTipo = "SELECT * FROM empresa_rubro_sub ORDER BY Rubro_Sub_Nombre ASC where Rubro_Id=".$id_rub;
$rsTipo = mysql_query($query_rsTipo, $cnx_arica) or die(mysql_error());
$row_rsTipo = mysql_fetch_assoc($rsTipo);
$totalRows_rsTipo = mysql_num_rows($rsTipo);
}

?>
 <tr>
     <td align="right" class="fuente"><strong>Categor&iacute;a :</strong></td>
     <td><select name="tipo_Txt" class="fuente" id="tipo_Txt"  title="Nombre de Subcategoría" required="required">
         <option value="">Seleccione</option>
             <? do {?>
               <option value="<? echo $row_rsTipo['Rubro_Sub_Id']?>"><? echo utf8_encode($row_rsTipo['Rubro_Sub_Nombre']);?></option>
              <? }while ($row_rsTipo=mysql_fetch_assoc($rsTipo));?>
                    </select> 
                                                   
                    </td>
                  </tr>