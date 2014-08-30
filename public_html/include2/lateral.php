<? include('../Connections/cnx_arica.php')?>

<script src="../Scripts/swfobject_modified.js" type="text/javascript"></script>

        <? 		mysql_select_db($database_cnx_arica, $cnx_arica);
				$query_rsBanners = "SELECT *  FROM banners where Estado_Ban=1 AND Ubicacion_Ban=1";
				$rsBanners = mysql_query($query_rsBanners, $cnx_arica) or die(mysql_error());
				$row_rsBanners = mysql_fetch_assoc($rsBanners);
				$totalRows_rsBanners = mysql_num_rows($rsBanners);?> 
                <? 
				do{ ?>
                
                <?   
			$ext = strtolower(substr($row_rsBanners['Archivo_Ban'], -3));
			
			if (($ext == "jpg") || ($ext=="gif") || ($ext=="png")) { ?>
     <div style="border-bottom:5px solid #FFFFFF;">
   <a href="<? if ($row_rsBanners['Url_Ban']){echo $row_rsBanners['Url_Ban'];};?>" target="_blank">  <img src="../include/imagen.php?nw=245&foto=<?php echo $row_rsBanners['Archivo_Ban']; ?>&ubicacion=../banners/" border="0"/></a>
     
     </div>
                   
                <? } 
				elseif ($ext == "swf")
				{
				 ?> <div id="banner_flash" >
				  <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="245" >
				    <param name="movie" value="../banners/swf/mapa.swf" />
				    <param name="quality" value="high" />
				    <param name="wmode" value="opaque" />
				    <param name="swfversion" value="9.0.45.0" />
				    <!-- Esta etiqueta param indica a los usuarios de Flash Player 6.0 r65 o posterior que descarguen la versión más reciente de Flash Player. Elimínela si no desea que los usuarios vean el mensaje. -->
				    <param name="expressinstall" value="../Scripts/expressInstall.swf" />
				    <!-- La siguiente etiqueta object es para navegadores distintos de IE. Ocúltela a IE mediante IECC. -->
				    <!--[if !IE]>-->
	 			    <object type="application/x-shockwave-flash" data="<?php echo $row_rsBanners['Archivo_Ban']; ?>" width="245" height="203" >
				      <!--<![endif]-->
				      <param name="quality" value="high" />
				      <param name="wmode" value="opaque" />
				      <param name="swfversion" value="9.0.45.0" />
				      <param name="expressinstall" value="../Scripts/expressInstall.swf" />
				
				      <!--[if !IE]>-->
			        </object>
				    <!--<![endif]-->
			      </object>
                </div> 
				 
				<?
					}
				else {?>     
					<div id="video">
                    <? echo $row_rsBanners['Archivo_Ban']?>
                    
		</div>
					<? }?>
					<?
					}while ($row_rsBanners= mysql_fetch_assoc($rsBanners))
				?>
	<script type="text/javascript">
	swfobject.registerObject("FlashID");
	</script>
