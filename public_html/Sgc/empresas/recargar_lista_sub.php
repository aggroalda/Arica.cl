<?php require_once('../../Connections/cnx_arica.php'); ?>
<link rel="stylesheet" type="text/css" href="../css/sgc.css"/>
<?php 
$colname_rsRubro = "-1";
if ($_GET['id_rub']!='') {
$colname_rsRubro = $_GET['id_rub'];
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTipo = "SELECT * FROM empresa_rubro_sub WHERE Rubro_Id = ".$colname_rsRubro;
$rsTipo = mysql_query($query_rsTipo, $cnx_arica) or die(mysql_error());
$row_rsTipo = mysql_fetch_assoc($rsTipo);
$totalRows_rsTipo = mysql_num_rows($rsTipo);
?> 

<tr>
     <td align="right" class="fuente"><strong>Categor&iacute;a :</strong></td>
     <td><select name="tipo_Txt" class="fuente" id="tipo_Txt" title="Nombre Subcategoría de Rubro" required="required" <?   if($totalRows_rsTipo==''){echo "disabled='disabled'";}?>>
         <option value="">-- Seleccione --</option>
             <? do {?>
               <option value="<? echo $row_rsTipo['Rubro_Sub_Id']?>"><? echo utf8_encode($row_rsTipo['Rubro_Sub_Nombre']);?></option>
              <? }while ($row_rsTipo=mysql_fetch_assoc($rsTipo));?>
                    </select> 
                                                   
                    </td>
                  </tr> 
               <?   if($totalRows_rsTipo==''){
				   		?>
						<tr align="center"><td><span>&nbsp;</span></td><td>
      <label class="error">Usted debe Seleccionar otro Rubro.</label>
      </td></tr> 
						<?
				   }
			   
			   ?>
              
<? 

}elseif($_GET['id_rub']==''){
	?>
<tr>
     <td align="right" class="fuente"><strong>Categor&iacute;a :</strong></td>
     <td><select name="tipo_Txt" class="fuente" id="tipo_Txt"  title="Nombre de Subcategoría de Rubro" required="required" disabled="disabled">            
               <option value="">-- Seleccione --</option>            
                    </select> 
                                                   
                    </td>
                  </tr>
     	<tr align="center"><td><span>&nbsp;</span></td><td>
 <label class="error">Usted debe Seleccionar otro Rubro.</label>
      </td></tr>  
<?
}

?>

 	
                  
                  
				  
                