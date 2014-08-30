<?php require_once('../Connections/cnx_arica.php'); ?>
<?php require_once('../include/header.php'); ?>

<div id="cuerpo">
    
    <div class="principal" id="principal">
	<div id="page"><div id="titulo_buscar_div"><h1 id="titulo_buscar">BUSCADOR</h1></div>
         <div id="resultsDiv"></div>
     </div>
     <div id="accion_ocultar">
	
    <div id="featured">
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
			  	do { 
				
			$i=$i+1;	?>
             <? mysql_select_db($database_cnx_arica, $cnx_arica);
                $id_not=$row_rsNoticias['Id_Noticia'];
                $query_rsImagen2 = "SELECT *  FROM noticias,galeria where galeria.IdNoticia_Gal='$id_not' and galeria.IdNoticia_Gal= noticias.Id_Noticia AND galeria.Portada_Gal='1' AND noticias.Portada_Not=1 ORDER BY Id_Noticia DESC";
                $rsImagen2 = mysql_query($query_rsImagen2, $cnx_arica) or die(mysql_error());
                $row_rsImagen2 = mysql_fetch_assoc($rsImagen2);
                $totalRows_rsImagen2 = mysql_num_rows($rsImagen2);
?>
<li class="ui-tabs-nav-item"  id="nav-fragment-<? echo $i?>">
     <a href="#fragment-<? echo $i?>">
	       <img src="../include/imagen.php?nw=80&foto=<?php echo $row_rsImagen2['Archivo_Gal']; ?>&ubicacion=../novedades/img/" border="0"/><span>  <?php $palabra=$row_rsNoticias['Titulo_Not'];
						$largo=strlen($palabra); 
						if ($largo <=80)
						{echo utf8_encode($palabra);}
						else
						{$palabra_cortada=substr($palabra,0,80);
						echo utf8_encode($palabra_cortada)."...";}
						?>   </span></a></li>
	      </a>
        </li>
    		 <?php }
			  while ($row_rsNoticias = mysql_fetch_assoc($rsNoticias)); ?>   
	      
                  		
	      </ul>

	    <!-- First Content -->
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
<a href="../novedades/detalle.php?id_not=<? echo $id_not?>">
        <img class="imagen_ui" src="../include/imagen.php?nw=400&foto=<?php echo $row_rsImagen2['Archivo_Gal']; ?>&ubicacion=../novedades/img/" border="0"/></a>
            
			 <div class="info" >
				<h2 id="justificado"><? 
				$palabra=$row_rsImagen2['Titulo_Not'];
						$largo=strlen($palabra); 
						if ($largo <= 100 )
						{
						 ?> <a id="leer_mas_noticia" href="../novedades/detalle.php?id_not=<? echo $id_not?>">
						<? echo utf8_encode($palabra);?></a><? }
						else
						{
							$palabra_cortada=substr($palabra,0,100);?> 
                         <a id="leer_mas_noticia" href="../novedades/detalle.php?id_not=<? echo $id_not?>">
						<? utf8_encode($palabra_cortada)."  ..."; ?></a><? }
							?>
                            </h2>
               	<p class="parrafo_stop" align="justify">
				<? $palabra=$row_rsImagen2['Desarrollo_Not'];
						$largo=strlen($palabra); 
						if ($largo <= 230 )
						{echo utf8_encode($palabra);}
						else
						{$palabra_cortada=substr($palabra,0,230);
						echo utf8_encode($palabra_cortada)."  ...";}
				
				 ?> &nbsp;<a id="leer_mas_noticia2" href="../novedades/detalle.php?id_not=<? echo $id_not?>">Leer M&aacute;s</a></p>
			 </div>
	    </div>
   <?php }
		 while ($row_rsNoticias = mysql_fetch_assoc($rsNoticias)); ?>    

	    
      </div>

		
<? mysql_select_db($database_cnx_arica, $cnx_arica);
			$query_rsBanner = "SELECT * from banners where Ubicacion_Ban= 3 AND Estado_Ban=1";
			$rsBanner = mysql_query($query_rsBanner, $cnx_arica) or die(mysql_error());
			$row_rsBanner = mysql_fetch_assoc($rsBanner);
			$totalRows_rsBanner = mysql_num_rows($rsBanner);
?>
<?	
 mysql_select_db($database_cnx_arica, $cnx_arica);
			$query_rsBannerMedio = "SELECT * from banners where Ubicacion_Ban= 2 AND Estado_Ban=1";
			$rsBannerMedio = mysql_query($query_rsBannerMedio, $cnx_arica) or die(mysql_error());
			$row_rsBannerMedio = mysql_fetch_assoc($rsBannerMedio);
			$totalRows_rsBannerMedio = mysql_num_rows($rsBannerMedio);
?>
 <? if ($totalRows_rsBannerMedio>0){?>
<div id="banner_medio"><a target="_blank" href="<?php echo $row_rsBannerMedio['Url_Ban'];?>"><img src="../banners/<? echo $row_rsBannerMedio['Archivo_Ban']; ?>" title="<? echo $row_rsBannerMedio['Titulo_Ban']; ?>" alt="banner_medio" /></a></div>   
<? } ?>
  <? if ($totalRows_rsBanner>0){?>
<div class="banner"><a target="_blank" href="<?php echo $row_rsBanner['Url_Ban'];?>"><img src="../banners/<? echo $row_rsBanner['Archivo_Ban']; ?>" title="<? echo $row_rsBanner['Titulo_Ban']; ?>" alt="banner_abajo" /></a></div>
<? } ?>
           	<? /* <div id="clasificados">
            include("../include/clasificados.php")
            </div>*/?>
          <div id="iframe_megusta"> 
            <iframe src="https://www.facebook.com/plugins/like.php?href=https://www.facebook.com/aricacl"
        scrolling="no" frameborder="0"
        style="border:none; width:450px; height:80px"></iframe></div>
        
		
	</div>
		
</div>
       <div class="lateral">
        <? include('../include/lateral.php')?>
           </div>	
        </div>
        
      	 <?php require_once('../include/pie_pagina.php'); ?>
    </div>
   
</body>
</html>
<script type="text/javascript">

var _gaq = _gaq || [];

_gaq.push(['_setAccount', 'UA-2694970-1']);

_gaq.push(['_setDomainName', 'arica.cl']);

_gaq.push(['_trackPageview']);

(function() {

var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

})();

</script>