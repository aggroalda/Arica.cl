<?php require_once('../Connections/cnx_arica.php'); ?>
<?php require_once('../include/header2.php'); ?>
<div id="featured" >
		 <?php 
				$maxRows_rsNoticias = 4;
				$pageNum_rsNoticias = 0;
				if (isset($_GET['pageNum_rsNoticias'])) {
				  $pageNum_rsNoticias = $_GET['pageNum_rsNoticias'];
				}
				$startRow_rsNoticias = $pageNum_rsNoticias * $maxRows_rsNoticias;
				
				mysql_select_db($database_cnx_arica, $cnx_arica);
				$query_rsNoticias = "SELECT * FROM noticias WHERE Estado_Not = 1 AND Portada_Not=1 ORDER BY Id_Noticia DESC";
				$query_limit_rsNoticias = sprintf("%s LIMIT %d, %d", $query_rsNoticias, $startRow_rsNoticias, $maxRows_rsNoticias);
				$rsNoticias = mysql_query($query_limit_rsNoticias, $cnx_arica) or die(mysql_error());
				$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
				
				if (isset($_GET['totalRows_rsNoticias'])) {
				  $totalRows_rsNoticias = $_GET['totalRows_rsNoticias'];
				} else {
				  $all_rsNoticias = mysql_query($query_rsNoticias);
				  $totalRows_rsNoticias = mysql_num_rows($all_rsNoticias);
				}
				$totalPages_rsNoticias = ceil($totalRows_rsNoticias/$maxRows_rsNoticias)-1;
		
				 $i=0;
			    do { 
			$i=$i+1;	?>
             <? mysql_select_db($database_cnx_arica, $cnx_arica);
                $id_not=$row_rsNoticias['Id_Noticia'];
                $query_rsImagen2 = "SELECT *  FROM noticias,categoria,galeria where  noticias.IdCategoria_Not= categoria.Id_Categoria AND galeria.IdNoticia_Gal='$id_not' and galeria.IdNoticia_Gal= noticias.Id_Noticia AND galeria.Portada_Gal='1' AND noticias.Portada_Not=1";
                $rsImagen2 = mysql_query($query_rsImagen2, $cnx_arica) or die(mysql_error());
                $row_rsImagen2 = mysql_fetch_assoc($rsImagen2);
                $totalRows_rsImagen2 = mysql_num_rows($rsImagen2);
?>

 <div id="fragment-<? echo $i?>" class="ui-tabs-panel">
			<?php /*?><img width="430" height="250" src="../novedades/img/<?php echo $row_rsImagen2['Archivo_Gal']; ?>" alt="" /><?php */?>
        <img src="../include/imagen.php?nw=430&foto=<?php echo $row_rsImagen2['Archivo_Gal']; ?>&ubicacion=../novedades/img/" border="0"/>
            
			 <div class="info" >
				<h2  style="margin-right:20px"><? 
				$palabra=$row_rsImagen2['Titulo_Not'];
						$largo=strlen($palabra); 
						if ($largo <= 100 )
						{echo utf8_encode($palabra);}
						else
						{$palabra_cortada=substr($palabra,0,100);
						echo utf8_encode($palabra_cortada)."  ...";}
				
				
				//echo utf8_encode($row_rsImagen2['Titulo_Not']);?></h2>
                 <h4> <? echo utf8_encode($row_rsImagen2['Nombre_Cat'])?>  </h4>
				<p align="justify">
				<? $palabra=$row_rsImagen2['Desarrollo_Not'];
						$largo=strlen($palabra); 
						if ($largo <= 262 )
						{echo utf8_encode($palabra);}
						else
						{$palabra_cortada=substr($palabra,0,262);
						echo utf8_encode($palabra_cortada)."  ...";}
				
				 ?><a style="color:#814E62; font-weight:bold;" href="../novedades/detalle.php?id_not=<? echo $id_not?><? /* javascript:cargar('../novedades/detalle_noticia.php?id_not=<? echo $id_not?>','cuerpo');seleccionado(li<? echo $row_rsImagen2['Id_Categoria']?>);ocultar('noticias')  */ ?> " > Leer M&aacute;s</a></p>
			 </div>
	    </div>
   <?php }
		 while ($row_rsNoticias = mysql_fetch_assoc($rsNoticias)); ?>    

	<ul class="ui-tabs-nav">
           <?php 
				$maxRows_rsNoticias = 4;
				$pageNum_rsNoticias = 0;
				if (isset($_GET['pageNum_rsNoticias'])) {
				  $pageNum_rsNoticias = $_GET['pageNum_rsNoticias'];
				}
				$startRow_rsNoticias = $pageNum_rsNoticias * $maxRows_rsNoticias;
				
				mysql_select_db($database_cnx_arica, $cnx_arica);
				$query_rsNoticias = "SELECT * FROM noticias WHERE Estado_Not = 1 AND Portada_Not=1 ORDER BY Id_Noticia DESC";
				$query_limit_rsNoticias = sprintf("%s LIMIT %d, %d", $query_rsNoticias, $startRow_rsNoticias, $maxRows_rsNoticias);
				$rsNoticias = mysql_query($query_limit_rsNoticias, $cnx_arica) or die(mysql_error());
				$row_rsNoticias = mysql_fetch_assoc($rsNoticias);

			if (isset($_GET['totalRows_rsNoticias'])) {
			  $totalRows_rsNoticias = $_GET['totalRows_rsNoticias'];
			} else {
			  $all_rsNoticias = mysql_query($query_rsNoticias);
			  $totalRows_rsNoticias = mysql_num_rows($all_rsNoticias);
			}
			$totalPages_rsNoticias = ceil($totalRows_rsNoticias/$maxRows_rsNoticias)-1;
               $i=0;
			   $px=0;
			    do { 
				
			$i=$i+1;	?>
             <? mysql_select_db($database_cnx_arica, $cnx_arica);
                $id_not=$row_rsNoticias['Id_Noticia'];
                $query_rsImagen2 = "SELECT *  FROM noticias,galeria where  galeria.IdNoticia_Gal='$id_not' and galeria.IdNoticia_Gal= noticias.Id_Noticia AND galeria.Portada_Gal='1' AND noticias.Portada_Not=1 ORDER BY Id_Noticia DESC";
                $rsImagen2 = mysql_query($query_rsImagen2, $cnx_arica) or die(mysql_error());
                $row_rsImagen2 = mysql_fetch_assoc($rsImagen2);
                $totalRows_rsImagen2 = mysql_num_rows($rsImagen2);
?>
     <li class="ui-tabs-nav-item ui-tabs-selected"  id="nav-fragment-<? echo $i?>">
     <a href="#fragment-<? echo $i?>">
  <? /*   <div style="width:172px;height:135px;overflow:hidden;z-index:-10px;right:<? if ($i==1){echo '0';}else {echo $px;} ?>px;<? if ($i==1){echo "border:0px";}?> border-right:7px solid #FFFFFF;" ><img style="" width="500" height="300"  src="../novedades/img/<?php echo $row_rsImagen2['Archivo_Gal']; ?>" alt="" /></div>
     
     */?>
     
      <div style="float:left;width:169px;height:135px;z-index:-10px;right:<? if ($i==1){echo '0';}else {echo $px;} ?>px;<? if ($i==1){echo "border:0px";}?> border-right:4px solid #FFFFFF; overflow:hidden;" >
  <?php /*?><img style="" width="169" height="135"  src="../novedades/img/<?php echo $row_rsImagen2['Archivo_Gal']; ?>" alt="" /><?php */?>
  <img src="../include/imagen.php?nw=169&foto=<?php echo $row_rsImagen2['Archivo_Gal']; ?>&ubicacion=../novedades/img/" border="0"/>   
     </div>
     
     </a>
        </li>
    		 <?php  $px= $px+173; }
		  while ($row_rsNoticias = mysql_fetch_assoc($rsNoticias)); ?>    
              
	      </ul>
   
      
 </div>
<div id="noticias">
            
            <span><hr /><h2>Noticias</h2></span>
            <? 		$maxRows_rsNoticias = 4;
					$pageNum_rsNoticias = 0;
					if (isset($_GET['pageNum_rsNoticias'])) {
					  $pageNum_rsNoticias = $_GET['pageNum_rsNoticias'];
					}
					$startRow_rsNoticias = $pageNum_rsNoticias * $maxRows_rsNoticias;

					mysql_select_db($database_cnx_arica, $cnx_arica);
					$query_rsNoticias = "SELECT * FROM noticias,categoria WHERE noticias.IdCategoria_Not = categoria.Id_Categoria AND Estado_Not = 1 AND Portada_Not=1 ORDER BY Id_Noticia DESC";
					$query_limit_rsNoticias = sprintf("%s LIMIT %d, %d", $query_rsNoticias, $startRow_rsNoticias, $maxRows_rsNoticias);
					$rsNoticias = mysql_query($query_limit_rsNoticias, $cnx_arica) or die(mysql_error());
					$row_rsNoticias = mysql_fetch_assoc($rsNoticias);

				if (isset($_GET['totalRows_rsNoticias'])) {
				  $totalRows_rsNoticias = $_GET['totalRows_rsNoticias'];
				} else {
				  $all_rsNoticias = mysql_query($query_rsNoticias);
				  $totalRows_rsNoticias = mysql_num_rows($all_rsNoticias);
				}
				$totalPages_rsNoticias = ceil($totalRows_rsNoticias/$maxRows_rsNoticias)-1;
		?>
            <?  $i=0; 
			do {
				
				$i=$i+1?>
            <?  $query_rsGaleria = "SELECT *  FROM galeria,noticias where Portada_Gal='1' AND galeria.IdNoticia_Gal='".$row_rsNoticias['Id_Noticia']."' AND galeria.IdNoticia_Gal='$id_not' and galeria.IdNoticia_Gal= noticias.Id_Noticia AND noticias.Portada_Not=1";
				$rsGaleria = mysql_query($query_rsGaleria, $cnx_arica) or die(mysql_error());
				$row_rsGaleria = mysql_fetch_assoc($rsGaleria);
				$totalRows_rsGaleria = mysql_num_rows($rsGaleria);?>
          
          
            <div class="item" id="nav-fragment-<? echo $i?>" >
             <h3 >
            <?php 	$palabra=$row_rsNoticias['Titulo_Not'];
						$largo=strlen($palabra); 
						if ($largo <= 33 )
						{echo utf8_encode($palabra);}
						else
						{$palabra_cortada=substr($palabra,0,33);
						echo utf8_encode($palabra_cortada)."";}
						?>   
             </h3>
           
             <p style=" text-align:justify">
                        <?php 	$id_not=$row_rsNoticias['Id_Noticia'];
						$palabra=$row_rsNoticias['Desarrollo_Not'];
									$largo=strlen($palabra); 
									if ($largo < 61 or $largo ==61)
									{echo utf8_encode($palabra)?> <a href="../novedades/detalle.php?id_not=<? echo $id_not; ?>"<? /* 'javascript:cargar("../novedades/detalle_noticia.php?id_not=<? echo $id_not?>","cuerpo");seleccionado(li<? echo $row_rsNoticias['Id_Categoria']?>)' */ ?>> Leer m&aacute;s</a><? ;
									}
									else
									{$palabra_cortada=substr($palabra,0,61);
									echo utf8_encode($palabra_cortada) ?>  ...<a href="../novedades/detalle.php?id_not=<? echo $id_not; ?>"<? /* 'javascript:cargar("../novedades/detalle_noticia.php?id_not=<? echo $id_not?>","cuerpo");seleccionado(li<? echo $row_rsNoticias['Id_Categoria']?>)' */ ?>> Leer m&aacute;s</a><? 
									}
								?>   
           </p></div>
            <? } while ($row_rsNoticias= mysql_fetch_assoc($rsNoticias))?>
            	
           
      
     
    
</div>
</body>
</html>
