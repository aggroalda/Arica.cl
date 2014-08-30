<? include('../../Connections/cnx_arica.php');?>
<? 

$cantidadporpagina = 10;
$numerodepagina = 0;
if (isset($_GET['numerodepagina'])) {
  $numerodepagina = $_GET['numerodepagina'];
}
$startRow_rsNoticias = $numerodepagina * $cantidadporpagina;
if($_GET['id_cat_cat']){
	$id_cat_cat=$_GET['id_cat_cat'];

	$ConsultaClasificados = "SELECT * FROM articulos_clasificados, clasificados, categoria_clasificado WHERE articulos_clasificados.Id_Clasificados = clasificados.Id_Clasificados AND clasificados.IdCategoriaCla_Cla = categoria_clasificado.Id_CategoriaClasificado AND clasificados.IdCategoriaCla_Cla = $id_cat_cat ORDER BY articulos_clasificados.Id_Articulo DESC";	

}
	
elseif ($_GET['id_tip']){
	$id_tip=$_GET['id_tip'];
	$ConsultaClasificados = "SELECT * FROM articulos_clasificados, clasificados, categoria_clasificado WHERE articulos_clasificados.Id_Clasificados = clasificados.Id_Clasificados AND clasificados.IdCategoriaCla_Cla = categoria_clasificado.Id_CategoriaClasificado AND clasificados.IdCategoriaCla_Cla = $id_tip ORDER BY articulos_clasificados.Id_Articulo DESC";
	}
	elseif ($_GET['id_sub_tip']){
		$id_sub_tip=$_GET['id_sub_tip'];
		$ConsultaClasificados = "SELECT * FROM articulos_clasificados, clasificados, categoria_clasificado WHERE articulos_clasificados.Id_Clasificados = clasificados.Id_Clasificados AND clasificados.IdCategoriaCla_Cla = categoria_clasificado.Id_CategoriaClasificado AND clasificados.Id_Clasificados = $id_sub_tip ORDER BY articulos_clasificados.Id_Articulo DESC";
		}
		
	else {
		$ConsultaClasificados = "SELECT * FROM articulos_clasificados, clasificados, categoria_clasificado WHERE articulos_clasificados.Id_Clasificados = clasificados.Id_Clasificados AND clasificados.IdCategoriaCla_Cla = categoria_clasificado.Id_CategoriaClasificado ORDER BY articulos_clasificados.Id_Articulo DESC";
		}

mysql_select_db($database_cnx_arica, $cnx_arica);
$consultaporpagina_articulos = sprintf("%s LIMIT %d, %d", $ConsultaClasificados, $startRow_rsNoticias, $cantidadporpagina);
$rsConsultaClasificados = mysql_query($consultaporpagina_articulos, $cnx_arica) or die(mysql_error());
$row_rsConsultaClasificados= mysql_fetch_assoc($rsConsultaClasificados);
$totalRows_rsConsultaClasificado = mysql_num_rows($rsConsultaClasificados);

if (isset($_GET['totalRows_rsNoticias'])) {
  $totalRows_rsNoticias = $_GET['totalRows_rsNoticias'];
} else {
  $all_rsNoticias = mysql_query($ConsultaClasificados);
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


  <tr>
    <td><blockquote>
    <strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../articulos_clasificados/index.php">M&oacute;dulo Anuncio de Clasificado</a> / <a id="guia_titulos" href="#">Listado</a></p></strong>
      <p class="titles">&raquo; M&oacute;dulo Anuncio de Clasificado / Listado</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle" id="novedadpag">
        


 <? if ($totalRows_rsNoticias>0){?>
        
        <table  width="100%" align="center" class="bordes2" >

          <tr align="center" bgcolor="#660000" class="blanco11">
            <td width="37%" bgcolor="#003366" class="blanco12">T&iacute;tulo</td>
             <td width="11%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Categor&iacute;a</strong></td>
            <td width="11%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Subcategoria</strong></td>
                <td width="11%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Fecha</strong></td>
            
              <td width="5%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Estado</strong></td>
            <td width="3%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Editar</strong></td>
            <td width="4%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Eliminar</strong></td>
          </tr>
            <tbody class="tabla">          
          <?php do { ?>
            <tr class="odd">
    
                <td class="fuente" style="color:#333"> 
              

<?php /*?><a class="fuente" href="#ver.php?id_not=<?=$row_rsConsultaClasificados['Id_Articulo']?>"><?php */?><b><text><?php echo utf8_encode($row_rsConsultaClasificados['Titulo_Articulo']); ?></text></b><!--</a>--></td>
<?


?>

<td align="center" class="fuente" > <a id="subrayado_cat_not" href="javascript:cargar('../articulos_clasificados/noticiapagina.php?id_tip=<? echo $row_rsConsultaClasificados['IdCategoriaCla_Cla'] ?>','tbnoticia')"><? echo utf8_encode($row_rsConsultaClasificados['Nombre_CatCla']);?></a></td>
 <td align="center" class="fuente" ><a id="subrayado_cat_not" href="javascript:cargar('../articulos_clasificados/noticiapagina.php?id_sub_tip=<? echo $row_rsConsultaClasificados['Id_Clasificados'] ?>','tbnoticia')"><? echo utf8_encode($row_rsConsultaClasificados['titulo_clasificado']);?></a></td>                
                 <td align="center" class="fuente" ><? echo $row_rsConsultaClasificados['Fecha_Articulo'];?></td>
                <td align="center">
                <select name="estado<?php echo $row_rsConsultaClasificados['Id_Articulo']; ?>" class="fuente" id="estado<?php echo $row_rsConsultaClasificados['Id_Articulo']; ?>" onChange="cargar('estado.php?id_art=<?php echo $row_rsConsultaClasificados['Id_Articulo']; ?>&estado='+this.value,'estado<?php echo $row_rsConsultaClasificados['Id_Articulo']; ?>')">
                  <option value="1" <?php if (!(strcmp(1, $row_rsConsultaClasificados['Estado_Articulo']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
                  <option value="0" <?php if (!(strcmp(0, $row_rsConsultaClasificados['Estado_Articulo']))) {echo "selected=\"selected\"";} ?>>Deshabilitado</option>
                </select></td>
              <td align="center"><a href="editar.php?id_art=<?php echo $row_rsConsultaClasificados['Id_Articulo']; ?>"><img src="../img/icon_edit.png" width="20" height="20" border="0"></a></td>
              <td align="center"><a href="javascript:preguntarArticulos('<?php echo $row_rsConsultaClasificados['Id_Articulo']; ?>','<?php echo $row_rsConsultaClasificados['titulo_clasificado']; ?>')"><img src="../img/icon_del.png" width="19" height="20" border="0"></a></td>
            </tr>
            <?php } while ($row_rsConsultaClasificados= mysql_fetch_assoc($rsConsultaClasificados)); ?>
            </tbody>
        </table>  
        
        
              <blockquote>
              <table border="0">
                  <tr>
                    <td colspan="4" class="fuente"> Noticias del <?php echo ($startRow_rsNoticias + 1) ?> al <?php echo min($startRow_rsNoticias + $cantidadporpagina, $totalRows_rsNoticias) ?> de <?php echo $totalRows_rsNoticias ?> en total</td>
                  </tr>
                  <tr>
                    <td align="center"><?php if ($numerodepagina > 0) { // Show if not first page ?>
                 
                      <a href="javascript:cargar('noticiapagina.php?numerodepagina=0','tbnoticia')">
                      <img src="../img/First.gif" border="0"></a>
                      <?php } // Show if not first page ?></td>
                      
                      
                    <td align="center"><?php if ($numerodepagina > 0) { // Show if not first page ?>
                      <a href="javascript:cargar('noticiapagina.php?numerodepagina=<? echo ($numerodepagina - 1);?>','tbnoticia')"><img src="../img/Previous.gif" border="0" /></a>
                      <?php } // Show if not first page ?></td>
                   
                    <td align="center"><?php if ($numerodepagina < $totalPages_rsNoticias) { // Show if not last page ?>
                     <a href="javascript:cargar('noticiapagina.php?numerodepagina=<? echo ($numerodepagina + 1);?>','tbnoticia')">
                      <img src="../img/Next.gif" border="0"></a>
                      <?php } // Show if not last page ?></td>
                      
                      
                    <td align="center"><?php if ($numerodepagina < $totalPages_rsNoticias) { // Show if not last page ?>
                    <a href="javascript:cargar('noticiapagina.php?numerodepagina=<? echo $totalPages_rsNoticias;?>','tbnoticia')">
                      <img src="../img/Last.gif" border="0"></a>
                      <?php } // Show if not last page ?></td>
                  </tr>
                </table></blockquote>
        
        
        
        <? } else {?>    
        <blockquote>
          <strong><p><a id="guia_titulos" href="../articulos_clasificados/index.php">M&oacute;dulo Anuncio de Clasificado Lista Original</a></p></strong>
     <div class="fuente">No hay Artículos Agregados
        </div></blockquote>
        <? }?>    
          <blockquote>
            <strong>
            <p><a id="guia_titulos" href="../articulos_clasificados/index.php">M&oacute;dulo Anuncio de Clasificado Lista Original</a></p></strong>
            <p><a href="javascript:cargar_noticias('agregar.php','tbnoticia')" class="fuente linksRojo"><strong>[+] Agregar Nuevo Articulo</strong></a></p>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p>

</td>
        </tr>
    </table></td>
  </tr>

























