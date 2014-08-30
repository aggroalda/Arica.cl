<? include('../Connections/cnx_arica.php');?>

<div class="wrap">

<div class="demo-container">

<div class="blue">  
<ul id="mega-menu-1" class="mega-menu">
<?php /*?><li><a href="../index.php">Inicio</a></li><?php */?>
<?     
		
$query_rsTotal ="SELECT *  FROM categoria";
$rsTotal = mysql_query($query_rsTotal, $cnx_arica) or die(mysql_error());
$row_rsTotal = mysql_fetch_assoc($rsTotal);
$totalRows_Total = mysql_num_rows($rsTotal); 
if($totalRows_Total<6){$columnas=1;}
else{$columnas=round($totalRows_Total/5);}?>	

		
<li><a href="../novedades/index.php?ver=noticias">Noticia<span id="flecha" class="flecha_abajo"></span></a>
<ul>
	  <? 
 		$inicio=0;
	   $hasta=5;
 
   for($i=0;$i<$columnas; $i++){
	  
$query_rsNoticias = "SELECT *  FROM categoria LIMIT $inicio,$hasta";
$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
$totalRows_rsNoticias = mysql_num_rows($rsNoticias); 
?>	

    <li>
    <? if ($hasta<=5) {?>
    <a  href="../novedades/index.php?ver=noticias">Noticias &raquo;</a>
		<? }else {?>
		
		 <a href="#"></a> <? } ?>
		<ul id="ul_empresa">
       
        <? do{  ?>
    	<li><a  href="../novedades/index.php?id_tip=<? echo $row_rsNoticias['Id_Categoria'];?>"><?php echo utf8_encode($row_rsNoticias['Nombre_Cat']); ?></a></li>
        <? } while($row_rsNoticias=mysql_fetch_assoc($rsNoticias))?>
			
		</ul>
   	</li>
   <? $inicio=$inicio+5;
		$hasta=$hasta+5;
	} ?>
		
</ul>

</li>

<!--<li><a href="#">Clasificados<span id="flecha" class="flecha_abajo"></span></a>
<ul>
		<? 	/*$query_rsClasificados = "SELECT *  FROM categoria_clasificado WHERE Estado_CatCla=1 order by Id_CategoriaClasificado ASC";
			$rsClasificados = mysql_query($query_rsClasificados, $cnx_arica) or die(mysql_error());
			$row_rsClasificados = mysql_fetch_assoc($rsClasificados);
			$totalRows_rsClasificados = mysql_num_rows($rsClasificados); 
			
			do {*/?>
   
     <li><a href="#"><? /*echo utf8_encode($row_rsClasificados['Nombre_CatCla']);*/?> &raquo;</a>
		
        <ul id="ul_empresa">
		<? /*
			$query_rsClasificados_sub = "SELECT *  FROM clasificados WHERE IdCategoriaCla_Cla=".$row_rsClasificados['Id_CategoriaClasificado'];
			$rsClasificados_sub = mysql_query($query_rsClasificados_sub, $cnx_arica) or die(mysql_error());
			$row_rsClasificados_sub = mysql_fetch_assoc($rsClasificados_sub);
			$totalRows_rsClasificados_sub = mysql_num_rows($rsClasificados_sub); 
		
		do{ */?>
        <li><a href="../clasificados/index.php?idsubcategoria=<? /* echo $row_rsClasificados_sub['Id_Clasificados'];?>"><? echo utf8_encode($row_rsClasificados_sub['titulo_clasificado']);*/ ?></a></li>
         <?/* } while($row_rsClasificados_sub=mysql_fetch_assoc($rsClasificados_sub))*/?>
        </ul>
      
	</li>
	  <? /*} while($row_rsClasificados=mysql_fetch_assoc($rsClasificados)) */?>
</ul>
</li>-->

 <?  
       mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoria = "SELECT * FROM empresa_rubro WHERE Estado_Rubro = 1 order by Nombre_Rubro asc limit 0,5";
			$rsCategoria = mysql_query($query_rsCategoria, $cnx_arica) or die(mysql_error());
			$row_rsCategoria = mysql_fetch_assoc($rsCategoria);
			$totalRows_rsCategoria = mysql_num_rows($rsCategoria);
		
			do{ ?>
            
       <?     
$id_rub=$row_rsCategoria['Id_Rubro'];		
$query_rsTotal = sprintf("SELECT * FROM empresa where Id_Rubro_Empresa=%d", mysql_real_escape_string($id_rub));
$rsTotal = mysql_query($query_rsTotal, $cnx_arica) or die(mysql_error());
$row_rsTotal = mysql_fetch_assoc($rsTotal);
$totalRows_Total = mysql_num_rows($rsTotal); 

 $id_rub=$row_rsCategoria['Id_Rubro'];
$query_rsNoticias = sprintf("SELECT * FROM empresa,empresa_rubro where empresa.Id_Rubro_Empresa=%d AND empresa_rubro.Id_Rubro=%d AND Estado_Emp=1", mysql_real_escape_string($id_rub),mysql_real_escape_string($id_rub));
$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
$totalRows_rsNoticias = mysql_num_rows($rsNoticias); 


	if($totalRows_Total<6){$columnas=1;}else
	{
	$columnas=round($totalRows_Total/5);
			
	}
	
	if($totalRows_rsNoticias>0) {?>	
		
	<li><a href="#"><?php echo utf8_encode($row_rsCategoria['Nombre_Rubro']); ?><span id="flecha" class="flecha_abajo"></span></a>
<ul>
	  <? 
 		$inicio=0;
	   $hasta=5;
 
   for($i=0;$i<$columnas; $i++){
	  
 $id_rub=$row_rsCategoria['Id_Rubro'];
$query_rsNoticias = sprintf("SELECT * FROM empresa,empresa_rubro where empresa.Id_Rubro_Empresa=%d AND empresa_rubro.Id_Rubro=%d AND Estado_Emp=1 LIMIT $inicio,$hasta", mysql_real_escape_string($id_rub),mysql_real_escape_string($id_rub));
$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
$totalRows_rsNoticias = mysql_num_rows($rsNoticias); 
?>	

    <li>
    <? if ($hasta<=5) {?>
    <a href="#"><!--Empresas &raquo;--></a>
		<? }else {?>
		<a href="#"></a> <? } ?>
		<ul id="ul_empresa">
       
        <? if(isset($row_rsNoticias['Nombre_Emp'])){ do{?>  
		   	
		<li><a href="../empresas/detalle.php?id_emp=<? echo $row_rsNoticias{'Id_Empresa'}; ?>&id_rub=<? echo $row_rsNoticias{'Id_Rubro'}; ?>&id_usu=<? echo $_SESSION['MM_IdUser']; ?>"><? echo utf8_encode($row_rsNoticias['Nombre_Emp']); ?></a>
        <ul><li>li</li></ul>
        </li>
		
		<? } while($row_rsNoticias=mysql_fetch_assoc($rsNoticias))?>
		
		<?  } else { ?>			
		<li><a href="#">No existen empresas registradas</a></li>
		<? }?>        
		
		
			
		</ul>
   	</li>
   <? $inicio=$inicio+5;
		$hasta=$hasta+5;
	} ?>
	
</ul>
</li>
<? } } while($row_rsCategoria=mysql_fetch_assoc($rsCategoria)) ?>


</ul>
</div>
</div>
</div>


















<?

  function que_hacer()
  {   
     $menu_vertical = $this->categorys_model->getCategorysMenu();
  if ($menu_vertical != FALSE) : ?>
  <?  $con_cat = 1;?>
    
	<?php foreach ($menu_vertical->result() as $row_cat) : ?>
   <?php if ($con_cat<2){ $imprimir = '<li><a href="#">'.$row_cat->CAT_nombre.'</a><ul>';}
   else{
	   $imprimir .= '<li><a href="#">'.$row_cat->CAT_nombre.'</a><ul>';
	   } ?>

  <?php 
  $id_cat = $row->CAT_nombre;
  $sub_menu_vertical = $this->subcategorys_model->getSubCategorysMenu($id_cat);?>
 <?php foreach ($sub_menu_vertical->result() as $row_sub) : ?>
  <? $imprimir .= '<li><a href="#">'.$row_sub->SUB_nombre.'</a></li>'; ?>
 <?php endforeach; ?>

  <? $imprimir .= '</ul></li>';?>
 <?php  $con_cat = $con_cat + 1; endforeach; ?>
<?php endif;
     $this->load->view('sitio/que-hacer/que-hacer', $imprimir);
     $this->load->view('inc/fotos'); 
     $this->load->view('inc/mapas');
     $this->load->view('inc/footer');  
  } 




 ?>
