<? include('../Connections/cnx_arica.php');?>
<? 
$cantidadporpagina = 10;
$numerodepagina = 0;
if (isset($_GET['numerodepagina'])) {
  $numerodepagina = $_GET['numerodepagina'];
}
$startRow_rsNoticias = $numerodepagina * $cantidadporpagina;
$id_tip=$_GET['id_tip'];
if ($_GET['id_tip']){
	$consultadetotal_noticias = "SELECT *  FROM noticias where Estado_Not=1 AND IdCategoria_Not=$id_tip ORDER BY Id_Noticia DESC";
	}
	else {
		$consultadetotal_noticias = "SELECT *  FROM noticias where Estado_Not= 1 ORDER BY Id_Noticia DESC";
		}

mysql_select_db($database_cnx_arica, $cnx_arica);

$consultaporpagina_noticia = sprintf("%s LIMIT %d, %d", $consultadetotal_noticias, $startRow_rsNoticias, $cantidadporpagina);
$rsNoticias = mysql_query($consultaporpagina_noticia, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);

if (isset($_GET['totalRows_rsNoticias'])) {
  $totalRows_rsNoticias = $_GET['totalRows_rsNoticias'];
} else {
  $all_rsNoticias = mysql_query($consultadetotal_noticias);
  $totalRows_rsNoticias = mysql_num_rows($all_rsNoticias);
}
$totalPages_rsNoticias = ceil($totalRows_rsNoticias/$cantidadporpagina)-1;

$queryString_rsNoticias = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "numerodepagina") == false && 
        stristr($param, "totalRows_rsNoticias") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsNoticias = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsNoticias = sprintf("&totalRows_rsNoticias=%d%s", $totalRows_rsNoticias, $queryString_rsNoticias);

?>

<div id="featured2" >

		 <p>
		   <?php 
			 if ($row_rsNoticias){
               $i=0;
			    do { 
			$i=$i+1;	?>
		   <? 
		  		mysql_select_db($database_cnx_arica, $cnx_arica);
                $id_not=$row_rsNoticias['Id_Noticia'];
                $query_rsImagen2 = "SELECT *  FROM noticias,categoria,galeria where  noticias.IdCategoria_Not= categoria.Id_Categoria AND galeria.IdNoticia_Gal=$id_not and galeria.IdNoticia_Gal= noticias.Id_Noticia AND galeria.Portada_Gal=1 ";
                $rsImagen2 = mysql_query($query_rsImagen2, $cnx_arica) or die(mysql_error());
                $row_rsImagen2 = mysql_fetch_assoc($rsImagen2);
                $totalRows_rsImagen2 = mysql_num_rows($rsImagen2);
				$id_cat=$row_rsImagen2['Id_Categoria'];
?>
	    </p>
		 <p>&nbsp; </p>
	
        <div id="noticia-<? echo $i?>" class="divnoticia" >
	<div style="height:160px;width:260px;display:inline;float:left;margin-right:10px; overflow:hidden;">
    <img style="margin-right:10px" src="../include/imagen.php?nw=260&foto=<?php echo $row_rsImagen2['Archivo_Gal']; ?>&ubicacion=../novedades/img/" border="0"/>&nbsp;<? 
$palabra=$row_rsImagen2['Descripcion_Gal'];
						$largo=strlen($palabra); 
						if ($largo <= 35 )
						{echo $palabra;}
						else
						{$palabra_cortada=substr($palabra,0,35);
						echo utf8_encode($palabra_cortada)."  ...";} 
 
 ?>
 </div>
				<h3><a class="alink" id="noticias-titulo"  href="../novedades/detalle.php?id_not=<? echo $row_rsImagen2['Id_Noticia']?>"> 
				<? echo utf8_encode($row_rsImagen2['Titulo_Not'])?>
                
                </a></h3>
                 <text id="titulo_categoria"> 
				
                
				 <a  href="javascript:cargar('../novedades/noticiaspaginacion.php?id_tip=<? echo $id_cat?>','featured2')
                 ;seleccionado(li<? echo $row_rsImagen2['Id_Categoria']?>)" >
				 <? echo utf8_encode($row_rsImagen2['Nombre_Cat']);?>  </a></text><div id="padding_margin"><? echo '<text >'. date("d-m-Y\n",strtotime($row_rsImagen2['Fecha_Not'])).'</text>';
echo '<text>'. date("h:i a",strtotime($row_rsImagen2['Fecha_Not'])).'</text>'; ?></div>
             
<br />
			<div style="float:right;text-align:justify;width:420px; margin-right:10px;font-size:11px;font-family:Arial">
            
            	<?
				$palabra=$row_rsImagen2['Desarrollo_Not'];
						$largo=strlen($palabra); 
						if ($largo <= 400 )
						{echo utf8_encode($palabra)."...";}
						else
						{$palabra_cortada=substr($palabra,0,400);
						echo "<p id='padding_margin2'>".utf8_encode($palabra_cortada)."  ...";}?>
                        
<a style="color:#814E62; font-weight:bold;" href="../novedades/detalle.php?id_not=<? echo $id_not?>"<? /*"javascript:cargar('../novedades/detalle_noticia.php?id_not=<? echo $id_not?>','featured') */ ?>> 
Leer M&aacute;s</a>
		  </p>
          </p>
          </div>
          
	    </div>
        
        
        
   <?php }
		 
		   while ($row_rsNoticias = mysql_fetch_assoc($rsNoticias)); ?>    
           
 <? if ($totalPages_rsNoticias>0){?>
    <div style="width:700px;height:50px;float:left">
  
       <? if (($numerodepagina-1) >=0){?>
        <a href="javascript:cargar('../novedades/noticiaspaginacion.php?<? if ($id_tip){?>id_tip=<?=$id_tip?><? } ?>&numerodepagina=<? echo ($numerodepagina - 1);?>','featured2')">
      Anterior</a> <? }?>
                <? for ($i=0; $i<=$totalPages_rsNoticias;$i++){?>
                
    <a href="javascript:cargar('../novedades/noticiaspaginacion.php?<? if ($id_tip){?>id_tip=<?=$id_tip?><? } ?>&numerodepagina=<? echo $i;?>','featured2')" >
			   <? echo $i+1?>
                </a>
              
                <? }?>
               
          <? if (($numerodepagina+1)<=$totalPages_rsNoticias){?>   <a href="javascript:cargar('../novedades/noticiaspaginacion.php?<? if ($id_tip){?>id_tip=<?=$id_tip?><? } ?>&numerodepagina=<? echo ($numerodepagina + 1);?>','featured2')">Siguiente</a><? }?>
 
 
		</div> 
        <? }?>

<? } else {?> <br><div class="fuente">No hay Noticias de ese categor&iacute;a</div><br><? }?>  
  

</div>

        






