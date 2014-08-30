<?php require_once('../../Connections/cnx_arica.php'); ?>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<?php
if (isset($_GET['id_emp'])) {
$id_emp = $_GET['id_emp'];
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsNumero ="SELECT destino_empresa.* , empresa.* ,  destino.*, ciudad1.Nombre_Ciu as nombreciudad1, ciudad2.Nombre_Ciu as nombreciudad2, pais1.Nombre_Pai as nombrepais1 , pais2.Nombre_Pai as nombrepais2
FROM destino_empresa,empresa,destino 
inner join ciudad ciudad1 on destino.IdDesde_Des= ciudad1.Id_Ciudad
 inner join pais pais1 on ciudad1.IdPais_Ciu= pais1.Id_Pais 
inner join ciudad ciudad2 on destino.IdHasta_Des= ciudad2.Id_Ciudad
 inner join pais pais2 on ciudad2.IdPais_Ciu= pais2.Id_Pais 
WHERE destino_empresa.IdEmpresa_DestinoEmp= $id_emp AND empresa.Id_Empresa=$id_emp AND destino_empresa.IdDestino_DestinoEmp= destino.Id_Destino ORDER BY Id_DestinoEmpresa
";
$rsNumero = mysql_query($query_rsNumero, $cnx_arica) or die(mysql_error());
$row_rsNumero = mysql_fetch_assoc($rsNumero);
$totalRows_rsNumero = mysql_num_rows($rsNumero);

if ($totalRows_rsNumero>0) { ?> 
    <blockquote>   
    	<BR>
		<table width="700" class="bordes2">
          <tr align="center" bgcolor="#660000" class="blanco11">
            <td width="47%" bgcolor="#CC0000" class="blanco12">Destinos</td>
            <td width="15%" bgcolor="#CC0000" class="blanco12">Desde</td>
            <td width="15%" bgcolor="#CC0000" class="blanco12">Hasta</td>
            <td width="25%" bgcolor="#CC0000" class="blanco12"><strong class="blanco11">Estado</strong></td>
              <td width="13%" bgcolor="#CC0000" class="blanco12"><strong class="blanco11">Editar</strong></td>
            <td width="13%" bgcolor="#CC0000" class="blanco12"><strong class="blanco11">Eliminar</strong></td>
          </tr>
          <tbody class="tabla2">
			  <?php do { 
			  $idnum = $row_rsNumero['Id_Numero'];
				?>
                <tr class="<? 	$estado=0;echo "boxverde";
				
				
				?>">
                    <td class="fuente" >-&nbsp;<a style="text-decoration:none;color:#000" href="javascript:cargar('destinover.php?id_emp=<? echo $row_rsNumero['Id_Empresa']?>&id_destinoempresa=<? echo $row_rsNumero['Id_DestinoEmpresa'];?>','dv<? echo $row_rsNumero['Id_Empresa']?>')"><strong><?php echo $row_rsNumero['nombreciudad1']; ?>(<? echo utf8_encode($row_rsNumero['nombrepais1']) ?>) - <?php echo $row_rsNumero['nombreciudad2']; ?>(<? echo  utf8_encode($row_rsNumero['nombrepais2']) ?>)  </strong></a></td>
                    <td class="fuente" align="center"><?php echo $row_rsNumero['nombreciudad1']; ?></td>
                    <td class="fuente" align="center"><?php echo $row_rsNumero['nombreciudad2']; ?></td>
               <td align="center">
               
               <select name="estadodestino<?php echo $row_rsNumero['Id_DestinoEmpresa'];?>" class="fuente" id="estadodestino<?php echo $row_rsNumero['Id_DestinoEmpresa']; ?>" onChange="cargar('estado_destinoempresa.php?id_destinoempresa=<?php echo $row_rsNumero['Id_DestinoEmpresa']; ?>&estado='+this.value,'estadodestino<?php echo $row_rsNumero['Id_DestinoEmpresa']; ?>')">
		  <option value="1" <?php if (!(strcmp(1, $row_rsNumero['Estado_DestinoEmp']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
		  <option value="0" <?php if (!(strcmp(0, $row_rsNumero['Estado_DestinoEmp']))) {echo "selected=\"selected\"";} ?>>Deshabilitado</option>
	  </select>
                     <input name="fechaman" type="hidden" id="fechaman" value="<? echo $hoy; ?>"></td>
                
                 <td align="center">
                  
                  <a href="javascript:editardestino(<?=$row_rsNumero['Id_Empresa']?>,<?=$row_rsNumero['Id_DestinoEmpresa']?>,'<?=$row_rsNumero['Numero_Num']?>')"><img src="../img/icon_edit.png" width="19" height="20" border="0">
                  
                  </a></td>
                
                  <td align="center">
                  
                  <a href="javascript:eliminar_numero(<?=$row_rsNumero['Id_Empresa']?>,<?=$row_rsNumero['Id_DestinoEmpresa']?>,'<?=$row_rsNumero['Numero_Num']?>')"><img src="../img/icon_del.png" width="19" height="20" border="0">
                  
                  </a></td>
                </tr>
                <?php } while ($row_rsNumero = mysql_fetch_assoc($rsNumero)); ?>
                </tbody>
                </table>
		
<p><a href="javascript:agregarruta('<? echo $id_emp ;?>') " class="fuente linksRojo"><strong>[+] Agregar Nuevo Destino</strong></a></p>
    </blockquote>
<?php
} // fin si encontro numeros


else {
	?> 
    <blockquote>  <p>
    <div class="fuente">No hay rutas registradas</div></p>
     <p><a class="fuente linksRojo" href="javascript:agregarruta('<? echo $id_emp ;?>')"><strong>[+] Agregar Nueva Destino</strong></a></p>
     </blockquote>
	
	<? }
mysql_free_result($rsNumero);
} // fin si id_hab tiene datos
?>