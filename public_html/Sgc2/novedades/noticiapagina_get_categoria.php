<? include('../../Connections/cnx_arica.php');?>
<? session_start(); ?>

<? 

$cantidadporpagina = 10;
$numerodepagina = 0;
if (isset($_GET['numerodepagina'])) {
  $numerodepagina = $_GET['numerodepagina'];
}
$startRow_rsNoticias = $numerodepagina * $cantidadporpagina;
if($_GET['id_tip']){
$id_tip=$_GET['id_tip'];}
if($_GET['id_cat_cat']){
$id_cat_cat=$_GET['id_cat_cat'];}

if ($_GET['id_tip']){
	$consultadetotal_noticias = "SELECT * FROM noticias,categoria WHERE noticias.IdCategoria_Not= $id_tip AND noticias.IdCategoria_Not= categoria.Id_Categoria ORDER BY Id_Noticia DESC";
	}
elseif ($_GET['id_cat_cat']){
$consultadetotal_noticias = "SELECT * FROM noticias,categoria WHERE noticias.IdCategoria_Not= $id_cat_cat AND noticias.IdCategoria_Not= categoria.Id_Categoria ORDER BY Id_Noticia DESC";
	}
	else {
		$consultadetotal_noticias = "SELECT * FROM noticias,categoria WHERE noticias.IdCategoria_Not= categoria.Id_Categoria ORDER BY Id_Noticia DESC";
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


  <tr>
    <td><blockquote>
    	<strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../categorias/index.php">M&oacute;dulo de Categor&iacute;a de Noticia</a> / <a id="guia_titulos" href="../novedades/index_get_categoria.php?id_cat_cat=<? echo $_GET['id_cat_cat']; ?>"> Categor&iacute;a <? echo utf8_encode($row_rsNoticias['Nombre_Cat']); ?></a> / <a id="guia_titulos" href="#">Listado</a></p></strong>
      <p class="titles">&raquo; Categor&iacute;a <? echo utf8_encode($row_rsNoticias['Nombre_Cat']); ?> / Listado</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle" id="novedadpag">
        


 <? if ($totalRows_rsNoticias>0){?>
        
        <table  width="100%" align="center" class="bordes2" id="change" >

          <tr align="center" bgcolor="#660000" class="blanco11">
            <td width="37%" bgcolor="#003366" class="blanco12">T&iacute;tulo</td>
             <td width="11%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Categor&iacute;a</strong></td>
            
                <td width="11%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Fecha</strong></td>
            <? 
				if(($_SESSION['MM_IdNivel']==5) || ($_SESSION['MM_IdNivel']==1)){
				echo "<td width='5%' bgcolor='#003366' class='blanco12'><strong class='blanco11'>Estado</strong></td>";
				}
				else
				{
				echo "";
				}
			
			
			
			  if(($_SESSION['MM_IdNivel']==1) || ($_SESSION['MM_IdNivel']==5) ){
				echo "<td width='5%' bgcolor='#003366' class='blanco12'><strong class='blanco11'>Portada</strong></td>";
				}
				else
				{
				echo "";
				}
          
			 ?>
              
            
              
              
              
            <td width="3%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Editar</strong></td>
            <td width="4%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Eliminar</strong></td>
          </tr>
            <tbody class="tabla">          
          <?php do { ?>
            <tr class="odd">
    
                <td class="fuente" style="color:#333"> 
              
<strong>
<a class="fuente" href="ver_get_categoria.php?id_not=<?=$row_rsNoticias['Id_Noticia']?>"><?php echo utf8_encode($row_rsNoticias['Titulo_Not']); ?></a></strong></td>
                 <td align="center" class="fuente" ><a id="subrayado_cat_not" href="javascript:cargar('../novedades/noticiapagina_get_categoria.php?id_tip=<? echo $row_rsNoticias['Id_Categoria'] ?>','tbnoticia')"><? echo utf8_encode($row_rsNoticias['Nombre_Cat']);?></a></td>
                 
                 <td align="center" class="fuente" ><? echo $row_rsNoticias['Fecha_Not'];?></td>
               
               
                <? 
				if(($_SESSION['MM_IdNivel']==1) || ($_SESSION['MM_IdNivel']==5)){ ?>
				 <td align="center"><select name="estado<?php echo $row_rsNoticias['Id_Noticia']; ?>" class="fuente" id="estado<?php echo $row_rsNoticias['Id_Noticia']; ?>" onChange="cargar('estado.php?id_not=<?php echo $row_rsNoticias['Id_Noticia']; ?>&estado='+this.value,'estado<?php echo $row_rsNoticias['Id_Noticia']; ?>')">
                  <option value="1" <?php if (!(strcmp(1, $row_rsNoticias['Estado_Not']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
                  <option value="0" <?php if (!(strcmp(0, $row_rsNoticias['Estado_Not']))) {echo "selected=\"selected\"";} ?>>Deshabilitado</option>
                </select></td>
			<?	}
			else{
				echo"";
				}
			
			if(($_SESSION['MM_IdNivel']==1) || ($_SESSION['MM_IdNivel']==5)){ ?>
			 <td id="portada<?php echo $row_rsNoticias['Id_Noticia'];?>" align="center">
                
                <?  $portada= $row_rsNoticias['Portada_Not'] ;
				if ($portada==1)  { ?>
                
                    <input type="checkbox" checked name="portada" id="portada" value="1" onChange="cargar('portada.php?Id_Noticia=<?php echo $row_rsNoticias['Id_Noticia']; ?>&portada=<?php echo $row_rsNoticias['Portada_Not']; ?>','portada<?php echo $row_rsNoticias['Id_Noticia'];?>')" >
                  
               <? } else  {?>
               
                <input type="checkbox" name="portada" id="portada" value="0" onChange="cargar('portada.php?Id_Noticia=<?php echo $row_rsNoticias['Id_Noticia']; ?>&portada=<?php echo $row_rsNoticias['Portada_Not']; ?>','portada<?php echo $row_rsNoticias['Id_Noticia'];?>')">
                  
               <? }  ?>
         </td>
         <?	}
			else{
				echo"";
				} ?>
                
                
              <td align="center"><a href="editar_get_categoria.php?id_not=<?php echo $row_rsNoticias['Id_Noticia']; ?>&id_cat_cat=<? echo $row_rsNoticias['Id_Categoria']; ?>"><img src="../img/icon_edit.png" width="20" height="20" border="0"></a></td>
              <td align="center"><a href="javascript:preguntarNoticias_Get('<?php echo $row_rsNoticias['Id_Noticia']; ?>','<?php echo utf8_encode($row_rsNoticias['Titulo_Not']); ?>','<?php echo $row_rsNoticias['Id_Categoria']; ?>')"><img src="../img/icon_del.png" width="19" height="20" border="0"></a></td>
            </tr>
            <?php } while ($row_rsNoticias = mysql_fetch_assoc($rsNoticias)); ?>
            </tbody>
        </table>  
        
        
              <blockquote>
              <table border="0">
                  <tr>
                    <td colspan="4" class="fuente"> Noticias del <?php echo ($startRow_rsNoticias + 1) ?> al <?php echo min($startRow_rsNoticias + $cantidadporpagina, $totalRows_rsNoticias) ?> de <?php echo $totalRows_rsNoticias ?> en total</td>
                  </tr>
                  <tr>
                    <td align="center"><?php if ($numerodepagina > 0) { // Show if not first page ?>
                 
                      <a href="javascript:cargar('noticiapagina_get_categoria.php?id_cat_cat=<? echo $_GET['id_cat_cat']; ?>&id_tip=<? echo $_GET['id_tip']; ?>&numerodepagina=0','tbnoticia')">
                      <img src="../img/First.gif" border="0"></a>
                      <?php } // Show if not first page ?></td>
                      
                      
                    <td align="center"><?php if ($numerodepagina > 0) { // Show if not first page ?>
                      <a href="javascript:cargar('noticiapagina_get_categoria.php?id_cat_cat=<? echo $_GET['id_cat_cat']; ?>&id_tip=<? echo $_GET['id_tip']; ?>&numerodepagina=<? echo ($numerodepagina - 1);?>','tbnoticia')"><img src="../img/Previous.gif" border="0" /></a>
                      <?php } // Show if not first page ?></td>
                   
                    <td align="center"><?php if ($numerodepagina < $totalPages_rsNoticias) { // Show if not last page ?>
                     <a href="javascript:cargar('noticiapagina_get_categoria.php?id_cat_cat=<? echo $_GET['id_cat_cat']; ?>&id_tip=<? echo $_GET['id_tip']; ?>&numerodepagina=<? echo ($numerodepagina + 1);?>','tbnoticia')">
                      <img src="../img/Next.gif" border="0"></a>
                      <?php } // Show if not last page ?></td>
                      
                      
                    <td align="center"><?php if ($numerodepagina < $totalPages_rsNoticias) { // Show if not last page ?>
                    <a href="javascript:cargar('noticiapagina_get_categoria.php?id_cat_cat=<? echo $_GET['id_cat_cat']; ?>&id_tip=<? echo $_GET['id_tip']; ?>&numerodepagina=<? echo $totalPages_rsNoticias;?>','tbnoticia')">
                      <img src="../img/Last.gif" border="0"></a>
                      <?php } // Show if not last page ?></td>
                  </tr>
                </table></blockquote>
           <blockquote>
      <!--    <strong><p><a id="guia_titulos" href="../novedades/index_get_categoria.php">M&oacute;dulo de Novedades Lista Original</a></p></strong>-->
      <? mysql_select_db($database_cnx_arica, $cnx_arica);
$consultaporpagina_noticia = sprintf("%s LIMIT %d, %d", $consultadetotal_noticias, $startRow_rsNoticias, $cantidadporpagina);
$rsNoticias = mysql_query($consultaporpagina_noticia, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
?>
            <p><a href="javascript:cargar_noticias('agregar_get_categoria.php?id_cat_cat=<? echo $row_rsNoticias['Id_Categoria']; ?>','tbnoticia')" class="fuente linksRojo"><strong>[+] Agregar Nueva Noticia / Categor&iacute;a <? echo $row_rsNoticias['Nombre_Cat']; ?></strong></a></p>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p>

</td>
        </tr>
    </table></td>
  </tr>

        
        
        <? } else {
			mysql_select_db($database_cnx_arica, $cnx_arica);
$consultaporpagina_noticia = sprintf("%s LIMIT %d, %d", $consultadetotal_noticias, $startRow_rsNoticias, $cantidadporpagina);
$rsNoticias = mysql_query($consultaporpagina_noticia, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
			?>    
        <blockquote>
     <div class="fuente">No hay Noticias Agregadas
        </div></blockquote>
        
           <blockquote>
      <!--    <strong><p><a id="guia_titulos" href="../novedades/index_get_categoria.php">M&oacute;dulo de Novedades Lista Original</a></p></strong>-->
            <p><a href="javascript:cargar_noticias('agregar_get_categoria.php?id_cat_cat=<? echo $row_rsNoticias['Id_Categoria']; ?>','tbnoticia')" class="fuente linksRojo"><strong>[+] Agregar Nueva Noticia / Categor&iacute;a <? echo $row_rsNoticias['Nombre_Cat']; ?></strong></a></p>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p>

</td>
        </tr>
    </table></td>
  </tr>

        <? }?>    
       
























