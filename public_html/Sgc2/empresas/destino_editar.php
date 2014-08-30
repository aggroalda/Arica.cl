<?php require_once('../../Connections/cnx_arica.php'); ?>
<? if (isset($_GET['id_emp'])) {
	
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCiudad = "SELECT * FROM ciudad,pais where ciudad.IdPais_Ciu= pais.Id_Pais";
$rsCiudad = mysql_query($query_rsCiudad, $cnx_arica) or die(mysql_error());
$row_rsCiudad = mysql_fetch_assoc($rsCiudad);
$totalRows_rsCiudad = mysql_num_rows($rsCiudad);
$id_des= $_GET['id_destinoempresa'];
$id_emp = $_GET['id_emp'];
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsNumero ="SELECT destino_empresa.* , empresa.* ,  destino.*, ciudad1.Nombre_Ciu as nombreciudad1, ciudad2.Nombre_Ciu as nombreciudad2, pais1.Nombre_Pai as nombrepais1 , pais2.Nombre_Pai as nombrepais2
FROM destino_empresa,empresa,destino 
 inner join ciudad ciudad1 on destino.IdDesde_Des= ciudad1.Id_Ciudad 
 inner join pais pais1 on ciudad1.IdPais_Ciu= pais1.Id_Pais 
inner join ciudad  ciudad2  on destino.IdHasta_Des= ciudad2.Id_Ciudad inner join pais pais2 on ciudad2.IdPais_Ciu= pais2.Id_Pais 
WHERE destino_empresa.Id_DestinoEmpresa=$id_des AND destino_empresa.IdEmpresa_DestinoEmp= $id_emp AND empresa.Id_Empresa=$id_emp AND destino_empresa.IdDestino_DestinoEmp= destino.Id_Destino
";
$rsNumero = mysql_query($query_rsNumero, $cnx_arica) or die(mysql_error());
$row_rsNumero = mysql_fetch_assoc($rsNumero);
$totalRows_rsNumero = mysql_num_rows($rsNumero);
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
        <td width="38%" align="right" class="fuente linksRojo"><strong>Detalle:</strong></td>
        <td width="62%"> <input name="id_emp" type="hidden"  id="id_emp" value="<? echo $_GET['id_emp'];?>">
		
	<input type="text" id="detalle_Txt" name="detalle_Txt" value="<? echo $row_rsNumero['Detalle_DestinoEmp'];?>"> 	
		
          </input>
          </td>
      </tr>
          <tr>
        <td width="38%" align="right" class="fuente linksRojo"><strong>Precio:</strong></td>
        <td width="62%">
		
		<input type="textarea" cols="4" rows="4" id="precio_Txt" name="precio_Txt" value="<? echo $row_rsNumero['Precio_DestinoEmp'];?>"> 
		
          
          </td>
      </tr>
      <? /*?>
          <tr>
        <td width="38%" align="right" class="fuente linksRojo"><strong>Foto:</strong></td>
        <td width="62%">
        <img width="140" height="120" src="../../destinos/img/<? echo $row_rsNumero['Foto_DestinoEmp']?>">
      
           <input name="foto_Txt" type="file" class="fuente"  id="foto_Txt" title="Imagen" accept="image/jpeg">
          </td>
      </tr>
      <? */ ?>
      <tr>
        <td align="right">
        
        <a href="javascript:editar_destino_proceso(<?=$row_rsNumero['Id_Empresa']?>,<?=$row_rsNumero['Id_DestinoEmpresa']?>,'<?=$row_rsNumero['Numero_Num']?>')"><img src="../img/actualizar.png"  border="0">
                  
                  </a>
       </td>
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