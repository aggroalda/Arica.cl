<?php require_once('../../Connections/cnx_arica.php'); ?>
<? if (isset($_GET['id_emp'])) {
	
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCiudad = "SELECT * FROM ciudad,pais where ciudad.IdPais_Ciu= pais.Id_Pais";
$rsCiudad = mysql_query($query_rsCiudad, $cnx_arica) or die(mysql_error());
$row_rsCiudad = mysql_fetch_assoc($rsCiudad);
$totalRows_rsCiudad = mysql_num_rows($rsCiudad);

$id_destinoempresa=$_GET['id_destinoempresa'];
mysql_select_db($database_cnx_arica, $cnx_arica);
// $query_rsDestinoEmp = "SELECT * FROM destino_empresa,destino WHERE Id_DestinoEmpresa= $id_destinoempresa";
$query_rsDestinoEmp ="SELECT destino_empresa.* , empresa.* ,  destino.*, ciudad1.Id_Ciudad AS idciudad1,ciudad1.Nombre_Ciu as nombreciudad1, ciudad2.Id_Ciudad as idciudad2,ciudad2.Nombre_Ciu as nombreciudad2, pais1.Nombre_Pai as nombrepais1 , pais2.Nombre_Pai as nombrepais2
FROM destino_empresa,empresa,destino 
inner join ciudad ciudad1 on destino.IdDesde_Des= ciudad1.Id_Ciudad
 inner join pais pais1 on ciudad1.IdPais_Ciu= pais1.Id_Pais 
inner join ciudad ciudad2 on destino.IdHasta_Des= ciudad2.Id_Ciudad
 inner join pais pais2 on ciudad2.IdPais_Ciu= pais2.Id_Pais 
WHERE destino_empresa.Id_DestinoEmpresa= $id_destinoempresa AND 
destino_empresa.IdEmpresa_DestinoEmp= $id_emp AND empresa.Id_Empresa=$id_emp AND destino_empresa.IdDestino_DestinoEmp= destino.Id_Destino ORDER BY Id_DestinoEmpresa
";
$rsDestinoEmp = mysql_query($query_rsDestinoEmp, $cnx_arica) or die(mysql_error());
$row_rsDestinoEmp = mysql_fetch_assoc($rsDestinoEmp);
$totalRows_rsDestinoEmp = mysql_num_rows($rsDestinoEmp);


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
     <tr>
        <td colspan="2" width="38%" align="center" class="fuente linksRojo"><strong>Detalle Destino:</strong></td>
        </tr>
      <tr>
        <td width="38%" align="right" class="fuente linksRojo"><strong>Desde:</strong></td>
        <td class="fuente" width="62%">
        
        <input name="id_emp" type="hidden"  id="id_emp" value="<? echo $_GET['id_emp'];?>">
         <? echo $row_rsDestinoEmp['nombreciudad1']?>
          </td>
      </tr>
       <tr>
        <td width="38%" align="right" class="fuente linksRojo"><strong>Hasta:</strong></td>
        <td class="fuente" width="62%"><? echo $row_rsDestinoEmp['nombreciudad2']?>
          </td>
      </tr>
     
      <tr>
        <td width="38%" align="right" class="fuente linksRojo"><strong>Detalle:</strong></td>
        <td class="fuente" width="62%">
          <? if ($row_rsDestinoEmp['Detalle_DestinoEmp']!=""){echo $row_rsDestinoEmp['Detalle_DestinoEmp'];}
		  else {echo "No hay detalle";}
		  ?>
          </td>
      </tr>
            <tr>
        <td width="38%" align="right" class="fuente linksRojo"><strong>Precio:</strong></td>
         <td  class="fuente" width="62%">
        
          <? if ($row_rsDestinoEmp['Precio_DestinoEmp']!=""){echo $row_rsDestinoEmp['Precio_DestinoEmp'];}
		  else { echo "No se ha registrado precio";}
		  ?>
          </td>
      </tr>
      <tr>
        <td width="38%" align="right" class="fuente linksRojo"><strong>Foto:</strong></td>
         <td class="fuente" width="62%">
         <? if ($row_rsDestinoEmp['Foto_DestinoEmp']){?>
        <img src="../../destinos/img/<? echo $row_rsDestinoEmp['Foto_DestinoEmp']?>" width="140" height="120">
        <? } else { echo "No hay imagen agregada";}?>
          </td>
      </tr>
       <tr>
        <td width="38%" align="right" class="fuente linksRojo"><strong>
        
        
        <?  if (!$row_rsDestinoEmp['Foto_DestinoEmp']){?>
        <a href="imagenes.php?id_pro=<? echo $row_rsDestinoEmp['Id_DestinoEmpresa']?>&cantidad=1&id_emp=<? echo $row_rsDestinoEmp['Id_Empresa']?>">Agregar Imagen:</a>
        <? } else {?>
         <a href="imagenes.php?id_pro=<? echo $row_rsDestinoEmp['Id_DestinoEmpresa']?>&cantidad=1&id_emp=<? echo $row_rsDestinoEmp['Id_Empresa']?>">Cambiar Imagen:</a>
        
        <? }?>
        </strong></td>
         <td  class="fuente" width="62%">
         </td>
      </tr>
        <tr>
        <td align="right"></td>
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
mysql_free_result($rsPiso);
?>