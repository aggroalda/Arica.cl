    <? include("../Connections/cnx_arica.php")?>
    <?  mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoriaClasificado = "SELECT *  FROM categoria_clasificado where Estado_CatCla= 1 ORDER BY Orden_CatCla 	asc";
$rsCategoriaClasificado = mysql_query($query_rsCategoriaClasificado, $cnx_arica) or die(mysql_error());
$row_rsCategoriaClasificado = mysql_fetch_assoc($rsCategoriaClasificado);
$totalRows_rsCategoriaClasificado = mysql_num_rows($rsCategoriaClasificado);?>
    <h1>Clasificados</h1>
        <ol>
            <?
			$b=0;
			 do {?>
                  <li><a style="font-weight:bold" class="<? if ($b==0){?> selec <? }?>select"href="javascript:mostrarclasificado('clasificados<? echo $row_rsCategoriaClasificado['Id_CategoriaClasificado'] ?>')" onClick="seleccionadoclasificado(this)"><? echo $row_rsCategoriaClasificado['Nombre_CatCla']?> </a></li>
                 <? $b=$b+1;
				 } while ($row_rsCategoriaClasificado= mysql_fetch_assoc($rsCategoriaClasificado));?>
                 
                 
                 
                 
                 
                 
            <?  mysql_select_db($database_cnx_arica, $cnx_arica);
				$query_rsCategoriaClasificado = "SELECT *  FROM categoria_clasificado where Estado_CatCla= 1 ORDER BY Orden_CatCla ASC";
				$rsCategoriaClasificado = mysql_query($query_rsCategoriaClasificado, $cnx_arica) or die(mysql_error());
				$row_rsCategoriaClasificado = mysql_fetch_assoc($rsCategoriaClasificado);
				$totalRows_rsCategoriaClasificado = mysql_num_rows($rsCategoriaClasificado);?>
                 
              <div id="divclasificados" >
				<?  $a=0;?>
              <? do {?>
              		<?  $id_cat= $row_rsCategoriaClasificado['Id_CategoriaClasificado'];
                    	$maxRows_rsClasificados = 8;
				$pageNum_rsClasificados = 0;
				if (isset($_GET['pageNum_rsClasificados'])) {
				  $pageNum_rsClasificados = $_GET['pageNum_rsClasificados'];
				}
				$startRow_rsClasificados = $pageNum_rsClasificados * $maxRows_rsClasificados;
				
				mysql_select_db($database_cnx_arica, $cnx_arica);
				$query_rsClasificados = "SELECT *  FROM categoria_clasificado,clasificados where Estado_CatCla= 1 AND clasificados.IdCategoriaCla_Cla = $id_cat AND clasificados.IdCategoriaCla_Cla= categoria_clasificado.Id_CategoriaClasificado AND clasificados.Estado_Cla=1 ORDER BY Orden_CatCla DESC";
				$query_limit_rsClasificados = sprintf("%s LIMIT %d, %d", $query_rsClasificados, $startRow_rsClasificados, $maxRows_rsClasificados);
				$rsClasificados = mysql_query($query_limit_rsClasificados, $cnx_arica) or die(mysql_error());
				$row_rsClasificados = mysql_fetch_assoc($rsClasificados);
				
				if (isset($_GET['totalRows_rsClasificados'])) {
				  $totalRows_rsClasificados = $_GET['totalRows_rsClasificados'];
				} else {
				  $all_rsClasificados = mysql_query($query_rsClasificados);
				  $totalRows_rsClasificados = mysql_num_rows($all_rsClasificados);
				}
				$totalPages_rsClasificados = ceil($totalRows_rsClasificados/$maxRows_rsClasificados)-1;
					
					/*mysql_select_db($database_cnx_arica, $cnx_arica);
                    $query_rsClasificado = "SELECT *  FROM categoria_clasificado,clasificados where Estado_CatCla= 1 AND clasificados.IdCategoriaCla_Cla = $id_cat AND clasificados.IdCategoriaCla_Cla= categoria_clasificado.Id_CategoriaClasificado AND clasificados.Estado_Cla=1 ORDER BY Orden_CatCla DESC";
                    $rsClasificado  = mysql_query($query_rsClasificado, $cnx_arica) or die(mysql_error());
                    $row_rsClasificado  = mysql_fetch_assoc($rsClasificado);
                    $totalRows_rsClasificado  = mysql_num_rows($rsClasificado) ;*/ ?>
                    
              <ul id="clasificados<? echo $row_rsCategoriaClasificado['Id_CategoriaClasificado']?>" class="<? if ($a==0){?>visible<? }else{?>oculto<? }?>">
                 	<? do {?>
<li>- <a id="enlace_sub" href="../clasificados/index.php?idsubcategoria=<? echo $row_rsClasificados['Id_Clasificados'];?>"> <? echo $row_rsClasificados['titulo_clasificado'];?> </a></li>
               			 <? } while ($row_rsClasificados= mysql_fetch_assoc($rsClasificados));?>
                <? $totalclasificados[$a]=$totalRows_rsClasificados; 
					if ($totalclasificados[$a]>7){?>
              		  
                      <!--href="javascript:cargar('../include/vermas.php?pageNum_rsClasificados=1&totalRows_rsClasificados=<? echo $totalRows_rsClasificados ?>&id_cat=<? echo $id_cat?>','clasificados<? echo $row_rsCategoriaClasificado['Id_CategoriaClasificado']?>')"-->
                      
                			<? }?>
                           
                      
                   </ul>
                   
                 <? $a=$a+1;
				 } while ($row_rsCategoriaClasificado= mysql_fetch_assoc($rsCategoriaClasificado));?>
                 
                  <div>     <a  href="../clasificados/index.php" style="font-weight:bold" class="vermas">Ver más</a></div>
                 </div>
                 
             </ol>
           