 <? include('../Connections/cnx_arica.php');?>
 <?php 
					

                $maxRows_rsClasificados = 8;
				$pageNum_rsClasificados = 0;
				if (isset($_GET['pageNum_rsClasificados'])) {
				  $pageNum_rsClasificados = $_GET['pageNum_rsClasificados'];
				}
				$startRow_rsClasificados = $pageNum_rsClasificados * $maxRows_rsClasificados;
				
				mysql_select_db($database_cnx_arica, $cnx_arica);
				$query_rsClasificados = "SELECT *  FROM categoria_clasificado,clasificados where Estado_CatCla= '1' AND clasificados.IdCategoriaCla_Cla = '$id_cat' AND clasificados.IdCategoriaCla_Cla= categoria_clasificado.Id_CategoriaClasificado AND clasificados.Estado_Cla='1' ORDER BY Orden_CatCla DESC";
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

 do {?>
                <li>- <? echo $row_rsClasificados['titulo_clasificado'];?> </li>
               	<? } while ($row_rsClasificados= mysql_fetch_assoc($rsClasificados));?>
                <? $totalclasificados[$a]=$totalRows_rsClasificados; 
					if ($pageNum_rsClasificados<$totalPages_rsClasificados){?>
              		<a href="javascript:cargar('../include/vermas.php?pageNum_rsClasificados=1&totalRows_rsClasificados=<? echo $totalRows_rsClasificados ?>&id_cat=<? echo $id_cat?>','clasificados<? echo $id_cat?>')" style="font-weight:bold" class="vermas">
                      Ver más</a>
                			<? }?>
							
                            
                           <? if ($pageNum_rsClasificados>0){?>
              		   <a href="javascript:cargar('../include/vermas.php?pageNum_rsClasificados=0&totalRows_rsClasificados=<? echo $totalRows_rsClasificados ?>&id_cat=<? echo $id_cat?>','clasificados<? echo $id_cat?>')" style="font-weight:bold" class="vermas">Atrás</a>
                			<? }?>