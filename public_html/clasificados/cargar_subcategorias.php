<?php require_once('../Connections/cnx_arica.php'); ?>
<? include("../include/funciones.php");?>

<? 
if (isset($_GET['idsubcategoria']))
{
$idsubcategoria= $_GET['idsubcategoria'];

}
?> 


<?

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsSubcategoria= "SELECT *  FROM articulos_clasificados, categoria_clasificado,clasificados WHERE articulos_clasificados.Id_Clasificados=clasificados.Id_Clasificados AND clasificados.IdCategoriaCla_Cla=categoria_clasificado.Id_CategoriaClasificado AND articulos_clasificados.Estado_Articulo=1 AND clasificados.Id_Clasificados= $idsubcategoria order by Id_Articulo ASC";
$rsSubcategoria= mysql_query($query_rsSubcategoria, $cnx_arica) or die(mysql_error());
$row_rsSubcategoria= mysql_fetch_assoc($rsSubcategoria);
$totalRows_rsSubcategoria= mysql_num_rows($rsSubcategoria);

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsSubcategoria2= "SELECT *  FROM categoria_clasificado,clasificados WHERE clasificados.IdCategoriaCla_Cla=categoria_clasificado.Id_CategoriaClasificado AND clasificados.Id_Clasificados= $idsubcategoria";
$rsSubcategoria2= mysql_query($query_rsSubcategoria2, $cnx_arica) or die(mysql_error());
$row_rsSubcategoria2= mysql_fetch_assoc($rsSubcategoria2);
$totalRows_rsSubcategoria2= mysql_num_rows($rsSubcategoria2);

if ($row_rsSubcategoria){

?>

<div id="lado_ofrecidos_ajax">

  <? 	
				
		do{ $id_art=$row_rsSubcategoria['Id_Articulo'];?>
        
<div id="<? echo "float_tabla".$row_rsSubcategoria['Nombre_CatCla']; ?>">   
<table width="97%" cellpadding="4" cellspacing="5" id="fondo_tabla" align="right">

<tr>
<td id="fecha_articulo"><? echo utf8_encode($row_rsSubcategoria['Fecha_Articulo']);?></td><td id="visita" align="right">visitas:0</td>
</tr>

<tr>
<td colspan="3" id="<? echo "titulo_Articulo".$row_rsSubcategoria['Nombre_CatCla']; ?>"><? echo utf8_encode($row_rsSubcategoria['Titulo_Articulo']);?></td>
</tr>

<tr>
<td colspan="3" id="descripcion_clasificado"><?
	$descripcion=truncate2($row_rsSubcategoria['Descripcion_Articulo'],100);
 echo utf8_encode($descripcion);?><a style="color:#333; font-weight:bold;" href="../clasificados/detalle.php?id_art=<? echo $id_art?>"<? /*"javascript:cargar('../novedades/detalle_noticia.php?id_not=<? echo $id_not?>','featured') */ ?>> 
Leer M&aacute;s</a> </td>
</tr>

<tr>
<td colspan="3" id="contacto_clasificado" align="right">contacto:<? echo utf8_encode($row_rsSubcategoria['Contacto_Telefono']);?>&nbsp;<? echo $row_rsSubcategoria['Contacto_Correo'];?></td>
</tr>

</table>
</div> 
<? } while($row_rsSubcategoria=mysql_fetch_assoc($rsSubcategoria));
	?>			
	
</div>
<?

 }
 
else{?>

<div class="desaparecer" id="errorNoexistenArticulos"><p id="errorClasificados">No se encontraron Artículos, en la Subcategoría "<? echo $row_rsSubcategoria2['titulo_clasificado'];?>" de <? echo $row_rsSubcategoria2['Nombre_CatCla'];?>.

</p>
  
</div>


<? }?>

  





  
