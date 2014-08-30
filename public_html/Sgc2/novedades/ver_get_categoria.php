<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php include('../includes/salida2.php');?>
<?php include('../includes/restriccion2.php');?>
<?php include("../includes/funciones.php");

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);


if (isset($_GET['id_not'])) {
  $colname_rsProducto = $_GET['id_not'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsProducto = sprintf("SELECT * FROM noticias,categoria,usuarios,personas WHERE noticias.IdCategoria_Not= categoria.Id_Categoria AND noticias.IdUsuario_Not=usuarios.Id_Usuario AND usuarios.IdPersona_Usu= personas.Id_Persona AND noticias.Id_Noticia='%s' ", GetSQLValueString($colname_rsProducto, "int"));
$rsProducto = mysql_query($query_rsProducto, $cnx_arica) or die(mysql_error());
$row_rsProducto = mysql_fetch_assoc($rsProducto);
$totalRows_rsProducto = mysql_num_rows($rsProducto);

$colname_rsFotos = "-1";
if (isset($_GET['id_not'])) {
  $colname_rsFotos = $_GET['id_not'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsFotos = sprintf("SELECT * FROM galeria WHERE IdNoticia_Gal = '%s' ORDER BY Id_Galeria ASC", GetSQLValueString($colname_rsFotos, "int"));
$rsFotos = mysql_query($query_rsFotos, $cnx_arica) or die(mysql_error());
$row_rsFotos = mysql_fetch_assoc($rsFotos);
$totalRows_rsFotos = mysql_num_rows($rsFotos);


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsNoticias ="SELECT * FROM noticias WHERE Id_Noticia=".$_GET['id_not'];
$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
$totalRows_rsNoticias = mysql_num_rows($rsNoticias);



?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript" src="../js/justcorners.js"></script>
<script type="text/javascript" src="../js/corner.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>

<script type="text/javascript" src="../js/mootools-yui-compressed.js"></script>
<script type="text/javascript" src="../js/sexylightbox.v2.3.mootools.min.js"></script>
<link rel="stylesheet" href="../css/sexylightbox.css" type="text/css" media="all" />
<script type="text/javascript">
    window.addEvent('domready', function(){
      SexyLightbox = new SexyLightBox({color:'black', dir: '../img/'});
    });
</script>


</head>
<body>
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td>
    <blockquote>
    <strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../categorias/index.php">M&oacute;dulo de Categor&iacute;a de Noticia</a> / <a id="guia_titulos" href="../novedades/index_get_categoria.php?id_cat_cat=<? echo $row_rsProducto['Id_Categoria'];?>">Categor&iacute;a <? echo utf8_encode($row_rsProducto['Nombre_Cat']); ?></a> / <a id="guia_titulos" href="#">Detalles</a></p></strong>
          <p class="titles">&raquo; Categor&iacute;a <? echo utf8_encode($row_rsProducto['Nombre_Cat']); ?> / Detalles</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
          <td width="11" height="11" id="cdo_top_izq"></td>
            <td colspan="2" height="11" id="cdo_top_fnd"></td>
            <td  width="11" height="11" id="cdo_top_der"></td>
          </tr>
          <tr>
            <td rowspan="3" background="../img/cdo_izq_fnd.jpg"></td>
            <td width="589" valign="top" bgcolor="#EBEBEB"><table width="100%" align="center" >
              <tr >
                <td align="right" valign="middle" class="fuente"><strong>Titulo:</strong></td>
                <td align="left" class="fuente"><?php echo utf8_encode( $row_rsProducto['Titulo_Not']); ?></td>
              </tr>
             <tr>
                <td align="right" class="fuente" ><strong>Categor&iacute;a:</strong></td>
                <td align="left" class="fuente" ><?php echo utf8_encode($row_rsProducto['Nombre_Cat']); ?></td>
              </tr>
               <tr>
                <td align="right" class="fuente" ><strong>Descripci&oacute;n:</strong></td>
                <td align="left" class="fuente" >
                <?php 
					$row_rsProducto['Desarrollo_Not'] = str_replace("\n", "<br>", $row_rsProducto['Desarrollo_Not']);
					echo utf8_encode($row_rsProducto['Desarrollo_Not']); ?>
                
                </td>
              </tr>
              
              <tr>
                <td align="right" valign="top" class="fuente" ><strong>Escrita por:</strong></td>
                <td align="left" valign="top" class="fuente" ><?php echo utf8_encode($row_rsProducto['Nombres_Per']);
				?> <?php echo utf8_encode($row_rsProducto['Paterno_Per']);
				?> <?php echo utf8_encode($row_rsProducto['Materno_Per']);
				?></td>
              </tr>
              
               <tr>
                <td align="right" valign="top" class="fuente" ><strong>Estado:</strong></td>
               <?php /*?> <td align="left" valign="top" class="fuente" ><?php $estado = $row_rsProducto['Estado_Not'];
				if ($estado == 1) {
				echo "Habilitado";
				} else {
				echo "Deshabilitado";
				}
				?></td> <?php */?>
                <? 
				if(($_SESSION['MM_IdNivel']==1) || ($_SESSION['MM_IdNivel']==5)){ ?>
				 <td align="left"><select name="estado<?php echo $row_rsNoticias['Id_Noticia']; ?>" class="fuente" id="estado<?php echo $row_rsNoticias['Id_Noticia']; ?>" onChange="cargar('estado.php?id_not=<?php echo $row_rsNoticias['Id_Noticia']; ?>&estado='+this.value,'estado<?php echo $row_rsNoticias['Id_Noticia']; ?>')">
                  <option value="1" <?php if (!(strcmp(1, $row_rsNoticias['Estado_Not']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
                  <option value="0" <?php if (!(strcmp(0, $row_rsNoticias['Estado_Not']))) {echo "selected=\"selected\"";} ?>>Deshabilitado</option>
                </select></td>
			<?	}
			else{
				?> 
				<td align="left" valign="top" class="fuente" ><?php $estado = $row_rsProducto['Estado_Not'];
				if ($estado == 1) {
				echo "Habilitado";
				} else {
				echo "Deshabilitado";
				}
				?></td>
				<?
				}?>
               
               
              </tr>
              
                <tr>
                <td align="right" valign="top" class="fuente" ><strong>Portada:</strong></td>
               <?php /*?> <td align="left" valign="top" class="fuente" ><?php $portada = $row_rsProducto['Portada_Not'];
				if ($portada == 1) {
				echo "Habilitado";
				} else {
				echo "Deshabilitado";
				}
				?></td><?php */?>
                <?
                if(($_SESSION['MM_IdNivel']==1) || ($_SESSION['MM_IdNivel']==5)){ ?>
			 <td id="portada<?php echo $row_rsNoticias['Id_Noticia'];?>" align="left">
                
                <?  $portada= $row_rsNoticias['Portada_Not'] ;
				if ($portada==1)  { ?>
                
                    <input type="checkbox" checked name="portada" id="portada" value="1" onChange="cargar('portada.php?Id_Noticia=<?php echo $row_rsNoticias['Id_Noticia']; ?>&portada=<?php echo $row_rsNoticias['Portada_Not']; ?>','portada<?php echo $row_rsNoticias['Id_Noticia'];?>')" >
                  
               <? } else  {?>
               
                <input type="checkbox" name="portada" id="portada" value="0" onChange="cargar('portada.php?Id_Noticia=<?php echo $row_rsNoticias['Id_Noticia']; ?>&portada=<?php echo $row_rsNoticias['Portada_Not']; ?>','portada<?php echo $row_rsNoticias['Id_Noticia'];?>')">
                  
               <? }  ?>
         </td>
         <?	}
			else{
				?>
                 <td align="left" valign="top" class="fuente" ><?php $portada = $row_rsProducto['Portada_Not'];
				if ($portada == 1) {
				echo "Habilitado";
				} else {
				echo "Deshabilitado";
				}
				?></td>
                 <?
				} ?>
              </tr>
              
            </table></td>
            <td width="340" valign="top" bgcolor="#EBEBEB"><table width="100%">
              <tr>
                <td align="center" class="fuente"><p><strong>Im&aacute;genes Agregadas:</strong></p>
                  <?php if ($totalRows_rsFotos == 0) { // Show if recordset empty ?>
  <p>Sin imagenes agregadas por el momento</p>
  <?php } // Show if recordset empty ?>
<?php if ($totalRows_rsFotos>0) {
				  $i=1;
				  do { ?>
                  <p><strong>Foto <? echo $i; ?> </strong><br>
                  
                  
                  	<a href="../../novedades/img/<?php echo $row_rsFotos['Archivo_Gal']; ?>" rel="sexylightbox[]" title="<?php echo  utf8_encode($row_rsProducto['Titulo_Not']) ." / ".utf8_encode($row_rsFotos['Descripcion_Gal']); ?> ">
                            <img src="../includes/imagen.php?nw=150&foto=<?php echo $row_rsFotos['Archivo_Gal']; ?>&ubica=../../novedades/img/" border="0"/>
                        </a>
                  </p>
                  <p><?php echo utf8_encode($row_rsFotos['Descripcion_Gal']); ?></p>
                  <p>
    				<div id= "portadadiv<?php echo $row_rsFotos['Id_Galeria'];?>">
                 Imagen en Portada<? $portada= $row_rsFotos['Portada_Gal'] ;
				if ($portada==1)  { ?>
                  <input type="checkbox" checked name="portada<?php echo $row_rsFotos['Id_Galeria'];?>" id="portada<?php echo $row_rsFotos['Id_Galeria'];?>" value="1" onChange="cargar2('portadaimagen.php?id_pro=<?php echo $row_rsProducto['Id_Noticia']; ?>&portada=<?php echo $row_rsFotos['Portada_Gal']; ?>&id_gal=<? echo $row_rsFotos['Id_Galeria']?>','portadadiv<?php echo $row_rsFotos['Id_Galeria'];?>');  "
                  >  
                <? } else  {?>
                <input type="checkbox" name="portada<?php echo $row_rsFotos['Id_Galeria'];?>" id="portada<?php echo $row_rsFotos['Id_Galeria'];?>" value="0" onChange="cargar2('portadaimagen.php?id_pro=<?php echo $row_rsProducto['Id_Noticia']; ?>&portada=<?php echo $row_rsFotos['Portada_Gal']; ?>&id_gal=<? echo $row_rsFotos['Id_Galeria']?>','portadadiv<?php echo $row_rsFotos['Id_Galeria'];?>');  ">
                <? } ?>
                </div>
                  <br>
                  <a href="editar_foto_get_categoria.php?id_not=<?php echo $row_rsProducto['Id_Noticia']; ?>&id_gal=<?php echo $row_rsFotos['Id_Galeria']; ?>&id_cat_cat=<?php echo $row_rsProducto['Id_Categoria']; ?>" class="fuente linksRojo">[-] Editar Descripci&oacute;n </a><a href="javascript:preguntarfoto_get_categoria('<?php echo $row_rsFotos['Id_Galeria']; ?>','<?=$i?>','<? echo $row_rsProducto['Id_Noticia']; ?>')" class="fuente linksRojo">[X] Eliminar</a></p>
                  </div>
                  <?php 
					$i++;
					} while ($row_rsFotos = mysql_fetch_assoc($rsFotos)); ?>
                  <p><strong>___________________<br><? } ?>
                    <a href="imagenes_get_categoria.php?cantidad=1&id_not=<?php echo $row_rsProducto['Id_Noticia']; ?>&id_cat_cat=<?php echo $row_rsProducto['Id_Categoria']; ?>" class="linksRojo"> <br>
                      [+] Agregar Imagen</a></strong></p>
                      
                      
                   
                      
                  &nbsp;</td>
              </tr>
            </table></td>
            <td rowspan="3" background="../img/cdo_der_fnd.jpg"></td>
          </tr>
           <tr>
             
           </tr>
          
          <tr>
            <td height="11" colspan="2" align="left" bgcolor="#EBEBEB"><a href="editar_get_categoria.php?id_cat_cat=<? echo $row_rsProducto['Id_Categoria']; ?>&id_not=<?php echo $row_rsProducto['Id_Noticia']; ?>" class="fuente linksRojo"><strong>EDITAR ESTA NOTICIA</strong></a></td>
            </tr>
          <tr>
         <td id="cdo_dwn_izq" height="11" width="11"></td>
            <td colspan="2" id="cdo_dwn_fnd" height="11"></td>
            <td id="cdo_dwn_der"></td>
          </tr>
        </table>
          <blockquote>
          <?php /*?><p><a href="../novedades/agregar.php" class="fuente linksRojo"><strong>[+] Agregar Nuevo Noticia</strong></a></p><?php */?>
         
 
      <p><a href="index_get_categoria.php?id_cat_cat=<? echo $row_rsProducto['Id_Categoria']; ?>" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Noticias / Categor&iacute;a <? echo utf8_encode($row_rsProducto['Nombre_Cat']); ?></strong></a></p>
          <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
          <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
        </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table></td>
  </tr>
  <? include("../option/footer.php"); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsOptions);

mysql_free_result($rsProducto);

mysql_free_result($rsFotos);




?>