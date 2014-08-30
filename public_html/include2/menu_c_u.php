<? include('../Connections/cnx_arica.php');?>

<link rel="stylesheet" type="text/css" href="../css/css-base.css">	

<div id="menu-altern">
			<ul>
      <? //  echo $_SERVER['PHP_SELF'];?>      
          
<? mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoriasNot= "SELECT *  FROM categoria where Orden_Cat<10 ORDER BY Orden_Cat ASC";
$rsCategoriasNot = mysql_query($query_rsCategoriasNot, $cnx_arica) or die(mysql_error());
$row_rsCategoriasNot = mysql_fetch_assoc($rsCategoriasNot);
$totalRows_rsCategoriasNot = mysql_num_rows($rsCategoriasNot);
?>
	   <li class="<? if (!$_GET['ver'] && (!$_GET['id_not'])){?>selec<? }?>"><a href="../index.php" style="text-decoration:none"  onclick="seleccionado(this)">Inicio</a></li>
       <li><a id="linoticia" href= "../novedades/index.php?ver=noticias" class="<? if ($_GET['ver']=="noticias"){ echo "selec";}?>" onClick="seleccionado(this)"<? /* "javascript:cargar('../novedades/noticiaspaginacion.php','cuerpo');mostrar('featured');ocultar('noticias');ocultar('cse-hosted');ocultar('buscararica')" style="text-decoration:none" onclick="seleccionado(linoticia)" */ ?> >Noticias
       
       </a>
     
       </li>
       
     <?  
       mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoria = "SELECT * FROM empresa_rubro order by Nombre_Rubro asc limit 0,5";
			$rsCategoria = mysql_query($query_rsCategoria, $cnx_arica) or die(mysql_error());
			$row_rsCategoria = mysql_fetch_assoc($rsCategoria);
			$totalRows_rsCategoria = mysql_num_rows($rsCategoria);
			
			do{ ?>
    
		
		<li><a href="#" style="color:#FFF; font-weight:bold;"><?php echo $row_rsCategoria['Nombre_Rubro']; ?> <span class="flechaabajo"/></span></a>
		<?php /*?><li><a href="">Literatura <span class="flechaabajo"/></span></a><ul><?php */?>
				<ul>
                <? 	
				/*$id_rub=$row_rsCategoria['Id_Rubro'];
$query_rsNoticias = "SELECT * FROM empresa where Id_Rubro_Empresa='". mysql_real_escape_string($id_rub)."'";
					$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
					$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
					$totalRows_rsNoticias = mysql_num_rows($rsNoticias); */
				
				
$id_rub=$row_rsCategoria['Id_Rubro'];
$query_rsNoticias = sprintf("SELECT * FROM empresa where Id_Rubro_Empresa=%d", mysql_real_escape_string($id_rub));
$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
$totalRows_rsNoticias = mysql_num_rows($rsNoticias); 
					
					do{  ?>
                
<li><a href="index.php?id_sub=<?php echo $row_rsNoticias['Id_Empresa']; ?>"><?php echo $row_rsNoticias['Nombre_Emp']; ?></a></li>
                <? } while($row_rsNoticias=mysql_fetch_assoc($rsNoticias)) ?>
				
			</ul></li> <? } while($row_rsCategoria=mysql_fetch_assoc($rsCategoria)) ?>  
       
        <?php /*?>    <? do {?>    
            
            <? 
			if($_GET['id_not']){$id_not = $_GET['id_not'];}
			mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rstipo= "SELECT *  FROM noticias,categoria  where noticias.Id_Noticia= '$id_not' AND noticias.IdCategoria_Not= categoria.Id_Categoria";
$rsTipo = mysql_query($query_rstipo, $cnx_arica) or die(mysql_error());
$row_rsTipo = mysql_fetch_assoc($rsTipo);
$totalRows_rsTipo = mysql_num_rows($rsTipo);
?>
            
            
             <li><a class="<? if ($row_rsTipo['Id_Categoria']== $row_rsCategoriasNot['Id_Categoria']){?>selec<? }?>" id="li<? echo $row_rsCategoriasNot['Id_Categoria']?>" href="javascript:cargar('../novedades/noticiaspaginacion.php?id_tip=<? echo $row_rsCategoriasNot['Id_Categoria']?>','cuerpo');mostrar('featured');ocultar('noticias');ocultar('cse-hosted');ocultar('buscararica')"  style="text-decoration:none" onclick="seleccionado(this)"><? echo utf8_encode($row_rsCategoriasNot['Nombre_Cat'])?></a></li>
            
                <? }while ($row_rsCategoriasNot=mysql_fetch_assoc($rsCategoriasNot));?>
        <?php */?>
            
          <? /*?>  <li class="select"> <? */ ?>
            
            
            
            </ul>













        </div>