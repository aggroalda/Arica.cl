<?php require_once('../../0_SOURCE/Connections/cnx_arica.php'); ?>
<? 
if ($_GET['id_sub']!='') {
	
	$sub = $_GET['id_sub'];

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsSubcategoria = "SELECT * FROM subcategoria WHERE IdCategoria_Sub = ".$sub." ";
$rsSubcategoria = mysql_query($query_rsSubcategoria, $cnx_arica) or die(mysql_error());
$row_rsSubcategoria = mysql_fetch_assoc($rsSubcategoria);
$totalRows_rsSubcategoria = mysql_num_rows($rsSubcategoria);

if ($totalRows_rsSubcategoria>0) {
	?>
		<option value="">-- Seleccione --</option>
        <?php do {  ?>
        <option value="<?php echo $row_rsSubcategoria['Id_Subcategoria']?>"><?php echo utf8_encode($row_rsSubcategoria['Nombre_Sub'])?></option>
        <?php } while ($row_rsSubcategoria = mysql_fetch_assoc($rsSubcategoria));
		$rows = mysql_num_rows($rsSubcategoria);
		if($rows > 0) {
		mysql_data_seek($rsSubcategoria, 0);
		$row_rsSubcategoria = mysql_fetch_assoc($rsSubcategoria);
		              }
	?>  
	<? }
 else { ?>
<option value="">- No hay Subcategorias -</option>
<? }}
?>