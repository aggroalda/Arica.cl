<? 
include('../../Connections/cnx_arica.php');


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$maxRows_rsCategoria = 30;
$pageNum_rsCategoria = 0;
if (isset($_GET['pageNum_rsCategoria'])) {
  $pageNum_rsCategoria = $_GET['pageNum_rsCategoria'];
}
$startRow_rsCategoria = $pageNum_rsCategoria * $maxRows_rsCategoria;

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoria = "SELECT * FROM categoria_clasificado ORDER by Orden_CatCla asc";
$query_limit_rsCategoria = sprintf("%s LIMIT %d, %d", $query_rsCategoria, $startRow_rsCategoria, $maxRows_rsCategoria);
$rsCategoria = mysql_query($query_limit_rsCategoria, $cnx_arica) or die(mysql_error());
$row_rsCategoria = mysql_fetch_assoc($rsCategoria);
$totalRows_rsCategoria= mysql_num_rows($rsCategoria);

if (isset($_GET['totalRows_rsCategoria'])) {
  $totalRows_rsCategoria = $_GET['totalRows_rsCategoria'];
} else {
  $all_rsCategoria = mysql_query($query_rsCategoria);
  $totalRows_rsCategoria = mysql_num_rows($all_rsCategoria);
}
$totalPages_rsCategoria = ceil($totalRows_rsCategoria/$maxRows_rsCategoria)-1;

$queryString_rsCategoria = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsCategoria") == false && 
        stristr($param, "totalRows_rsCategoria") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsCategoria = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsCategoria = sprintf("&totalRows_rsCategoria=%d%s", $totalRows_rsCategoria, $queryString_rsCategoria);

?>
  <tr>
    <td>
    <blockquote>
     <strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../clasificados/index.php">M&oacute;dulo Categoría de Clasificado</a>  / <a id="guia_titulos"href="#">Listado</a></p></strong>
      <p class="titles">&raquo; Módulo de Categoría de Clasificado / Listado</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><table width="100%" align="center" class="bordes2" >
          <tr align="center" bgcolor="#660000" class="blanco11">
            <td width="29%" bgcolor="#003366" class="blanco12">Categoría de Clasificado</td>
            <td width="18%" bgcolor="#003366" class="blanco12">Orden</td>
            <td width="15%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Estado</strong></td>
            <td width="18%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Editar</strong></td>
            <td width="20%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Eliminar</strong></td>
          </tr>
            <tbody class="tabla">          
          <?php do { ?>
            <tr class="odd">
                <td class="fuente">- 
                
               <? /* <a href="categoria.php?id_cat=<?php echo $row_rsCategoria['Id_CategoriaClasificado']; ?>" class="fuente"><strong><?php echo $row_rsCategoria['Nombre_Cat']; ?></strong></a><? */?>
                
                <strong><a id="subrayado_cat_not" href="../articulos_clasificados/index_get_cat.php?id_cat_cat=<? echo $row_rsCategoria['Id_CategoriaClasificado']; ?>"><?php echo utf8_encode($row_rsCategoria['Nombre_CatCla']); ?></a></strong>
                </td>
                <td class="fuente"   align="left"> <strong><? echo  $row_rsCategoria['Orden_CatCla'];?></strong>
             
     <? if($row_rsCategoria['Orden_CatCla']< $totalRows_rsCategoria){?>
<a href="#" onclick ="javascript:MM_goToURL('parent','bajar.php?id_cat=<?php echo $row_rsCategoria['Id_CategoriaClasificado'];?>&orden=<?php echo $row_rsCategoria['Orden_CatCla']; ?>')">
<img src="../img/down_icon.png" alt="Down to <?php echo $row_rsCategoria['Orden_CatCla']+1;?>"  width="19" height="17" border="0"></a> 
      <? } ?>        
  <? if ($row_rsCategoria['Orden_CatCla']>1){?>                 
<a href="javascript:MM_goToURL('parent','subir.php?id_cat=<?php echo $row_rsCategoria['Id_CategoriaClasificado']; ?>&orden=<?php echo $row_rsCategoria['Orden_CatCla'];?>')">
<img src="../img/up_icon.png" alt="A <?php echo $row_rsCategoria['Orden_CatCla']-1; ?>" width="19" height="17"></a>
          </td> <? } ?>
                <td align="center"><select name="estado<?php echo $row_rsCategoria['Id_CategoriaClasificado']; ?>" class="fuente" id="estado<?php echo $row_rsCategoria['Id_CategoriaClasificado']; ?>" onChange="cargar('estado.php?id_cat=<?php echo $row_rsCategoria['Id_CategoriaClasificado']; ?>&estado='+this.value,'estado<?php echo $row_rsCategoria['Id_CategoriaClasificado']; ?>')">
                  <option value="1" <?php if (!(strcmp(1, $row_rsCategoria['Estado_CatCla']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
                  <option value="0" <?php if (!(strcmp(0, $row_rsCategoria['Estado_CatCla']))) {echo "selected=\"selected\"";} ?>>Deshabilitado</option>
                </select></td>
              <td align="center"><a href="javascript:cargar('editar.php?id_cat=<?php echo $row_rsCategoria['Id_CategoriaClasificado']; ?>','tabla')"><img src="../img/icon_edit.png" width="20" height="20" border="0"></a></td>
              <td align="center"><a href="javascript:preguntar('<?php echo $row_rsCategoria['Id_CategoriaClasificado']; ?>','<?php echo utf8_encode($row_rsCategoria['Nombre_CatCla']); ?>','<?php echo $row_rsCategoria['Orden_CatCla']; ?>')"><img src="../img/icon_del.png" width="19" height="20" border="0"></a></td>
            </tr>
            <?php } while ($row_rsCategoria = mysql_fetch_assoc($rsCategoria)); ?>
              </tbody>
        </table>          
          <blockquote>
            <table border="0">
              <tr>
                <td colspan="4" class="fuente">
Categorías del <?php echo ($startRow_rsCategoria + 1) ?> al <?php echo min($startRow_rsCategoria + $maxRows_rsCategoria, $totalRows_rsCategoria) ?> de <?php echo $totalRows_rsCategoria ?> en total</td>
                </tr>
              <tr>
                <td align="center"><?php if ($pageNum_rsCategoria > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsCategoria=%d%s", $currentPage, 0, $queryString_rsCategoria); ?>"><img src="../img/First.gif" border="0"></a>
                <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_rsCategoria > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsCategoria=%d%s", $currentPage, max(0, $pageNum_rsCategoria - 1), $queryString_rsCategoria); ?>"><img src="../img/Previous.gif" border="0"></a>
                <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_rsCategoria < $totalPages_rsCategoria) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsCategoria=%d%s", $currentPage, min($totalPages_rsCategoria, $pageNum_rsCategoria + 1), $queryString_rsCategoria); ?>"><img src="../img/Next.gif" border="0"></a>
                <?php } // Show if not last page ?></td>
                <td align="center"><?php if ($pageNum_rsCategoria < $totalPages_rsCategoria) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsCategoria=%d%s", $currentPage, $totalPages_rsCategoria, $queryString_rsCategoria); ?>"><img src="../img/Last.gif" border="0"></a>
                <?php } // Show if not last page ?></td>
              </tr>
          </table>
            <? if ($totalRows_rsCategoria<=10) { ?>
            <p><a href="javascript:cargar('agregar.php?orden=<? echo $totalRows_rsCategoria +1 ?>','tabla')" class="fuente linksRojo"><strong>[+] Agregar Nueva Categor&iacute;a de Clasificado</strong></a></p><? } ?>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table>
   
    
    </td>
  </tr> 
 
