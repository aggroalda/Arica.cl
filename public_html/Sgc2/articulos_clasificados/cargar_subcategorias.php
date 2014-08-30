<?php require_once('../../Connections/cnx_arica.php'); ?>

<?php
if ((isset($_GET['Id_CategoriaClasificado'])) && ($_GET['Id_CategoriaClasificado'] != "")) {
  $Id_CategoriaClasificado = $_GET['Id_CategoriaClasificado'];

}
?>


<? 
 mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsSub= "SELECT * FROM categoria_clasificado,clasificados WHERE categoria_clasificado.Id_CategoriaClasificado = $Id_CategoriaClasificado AND clasificados.IdCategoriaCla_Cla= categoria_clasificado.Id_CategoriaClasificado";
$rsSub= mysql_query($query_rsSub, $cnx_arica) or die(mysql_error());
$row_rsSub= mysql_fetch_assoc($rsSub);
$totalRows_rsSub= mysql_num_rows($rsSub);
?>


<option value="">-- Seleccione --</option>
                    <? do {?>
<option value="<? echo $row_rsSub['Id_Clasificados'];?>"><? echo utf8_encode($row_rsSub['titulo_clasificado'])?></option>
                    <? }while ($row_rsSub=mysql_fetch_assoc($rsSub));
					 
					
						  if($totalRows_rsSub > 0) {
							  mysql_data_seek($rsSub, 0);
							  $row_rsSub = mysql_fetch_assoc($rsSub);
						                } ?>
					
					
				




