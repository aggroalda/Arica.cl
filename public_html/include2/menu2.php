<? include('../Connections/cnx_arica.php');?>

<link href="../css/dcmegamenu.css" rel="stylesheet" type="text/css" />
<!--<link href="../css/blue.css" rel="stylesheet" type="text/css" />-->
<!--libreria en conflicto con otro js <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
<script type='text/javascript' src='../js/jquery.hoverIntent.minified.js'></script>
<script type='text/javascript' src='../js/jquery.dcmegamenu.1.2.js'></script>
<script type="text/javascript">

</script>

<div class="wrap">

<div class="demo-container">

<div class="blue">  
<ul id="mega-menu-1" class="mega-menu">
<li><a href="../index.php">Inicio</a></li>
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

<li><a href="../clasificados/index.php">Clasificados<span id="flecha" class="flecha_abajo"></span></a>
<ul>
		<? 	$query_rsClasificados = "SELECT *  FROM categoria_clasificado WHERE Estado_CatCla=1 order by Id_CategoriaClasificado ASC";
			$rsClasificados = mysql_query($query_rsClasificados, $cnx_arica) or die(mysql_error());
			$row_rsClasificados = mysql_fetch_assoc($rsClasificados);
			$totalRows_rsClasificados = mysql_num_rows($rsClasificados); 
			
			do {?>
   
     <li><a href="#"><? echo utf8_encode($row_rsClasificados['Nombre_CatCla']);?> &raquo;</a>
		
        <ul id="ul_empresa">
		<? 
			$query_rsClasificados_sub = "SELECT *  FROM clasificados WHERE IdCategoriaCla_Cla=".$row_rsClasificados['Id_CategoriaClasificado'];
			$rsClasificados_sub = mysql_query($query_rsClasificados_sub, $cnx_arica) or die(mysql_error());
			$row_rsClasificados_sub = mysql_fetch_assoc($rsClasificados_sub);
			$totalRows_rsClasificados_sub = mysql_num_rows($rsClasificados_sub); 
		
		do{ ?>
        <li><a href="../clasificados/index.php?idsubcategoria=<? echo $row_rsClasificados_sub['Id_Clasificados'];?>"><? echo utf8_encode($row_rsClasificados_sub['titulo_clasificado']); ?></a></li>
         <? } while($row_rsClasificados_sub=mysql_fetch_assoc($rsClasificados_sub))?>
        </ul>
      
	</li>
	  <? } while($row_rsClasificados=mysql_fetch_assoc($rsClasificados))?>
</ul>
</li>

 <?  
       mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoria = "SELECT * FROM empresa_rubro order by Nombre_Rubro asc limit 0,5";
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
	if($totalRows_Total<6){$columnas=1;}else
	{
	$columnas=round($totalRows_Total/5);
			
	}?>	
		
	<li><a href="#"><?php echo utf8_encode($row_rsCategoria['Nombre_Rubro']); ?><span id="flecha" class="flecha_abajo"></span></a>
<ul>
	  <? 
 		$inicio=0;
	   $hasta=5;
 
   for($i=0;$i<$columnas; $i++){
	  
 $id_rub=$row_rsCategoria['Id_Rubro'];
$query_rsNoticias = sprintf("SELECT * FROM empresa where Id_Rubro_Empresa=%d LIMIT $inicio,$hasta", mysql_real_escape_string($id_rub));
$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
$totalRows_rsNoticias = mysql_num_rows($rsNoticias); 
?>	

    <li>
    <? if ($hasta<=5) {?>
    <a href="#">Empresas &raquo;</a>
		<? }else {?>
		
		 <a href="#"></a> <? } ?>
		<ul id="ul_empresa">
       
        <? if(isset($row_rsNoticias['Nombre_Emp'])){ do{?>  
		   	
		<li><a href="#"><? echo $row_rsNoticias['Nombre_Emp']; ?></a></li>
		
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
<? } while($row_rsCategoria=mysql_fetch_assoc($rsCategoria)) ?>

<li><a href="#">Contacto</a></li>
</ul>
</div>
</div>
</div>