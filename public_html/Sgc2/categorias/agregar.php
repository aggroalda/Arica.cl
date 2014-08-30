<?php include('../../Connections/cnx_arica.php'); ?>

<?php 

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOrden = "SELECT max(Orden_Cat) FROM categoria";
$rsOrden = mysql_query($query_rsOrden, $cnx_arica) or die(mysql_error());
?>


 
  <tr>
    <td><blockquote><strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../categorias/index.php">M&oacute;dulo de Categor&iacute;a de Noticia</a> / <a id="guia_titulos" href="#">Agregar</a></p></strong>
      <p class="titles">&raquo; M&oacute;dulo de Categoria de Noticia / Agregar</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><blockquote>
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
               <td width="11" height="11" id="cdo_top_izq"></td>
                  <td width="849" height="11" id="cdo_top_fnd"></td>
                  <td width="11" height="11" id="cdo_top_der"></td>
            </tr>
            <tr>
              <td background="../img/cdo_izq_fnd.jpg"></td>
              <td bgcolor="#EBEBEB"><form action="agregar_proceso.php" method="POST" enctype="multipart/form-data" name="form1" target="frameSave"  id="form1">
                <table width="100%">
                  <tr>
                    <td width="46%" align="right" class="fuente"><strong>Categor&iacute;a de Noticia:</strong></td>
                    <td width="54%">
                     
                      <input type="text" name="nombre_Txt" id="nombre_Txt" title="Nombre de Categor&iacute;a">
                      <input type="hidden" value="<? echo $_GET['orden']?>" id="orden" name="orden"></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center">
                      <input type="hidden" name="MM_insert" value="form1">
                      <input name="SendForm" type="submit" id="SendForm" value=" Guardar ">
                      </td>
                  </tr>
                </table>
              </form>
         
                 <iframe id="frameSave" name="frameSave"  style="width:0;height:0;border:0; display:none"></iframe> 
                
              </td>
            
              <td background="../img/cdo_der_fnd.jpg"></td>
            </tr>
               <td id="cdo_dwn_izq" height="11" width="11"></td>
                  <td id="cdo_dwn_fnd" height="11"></td>
                  <td id="cdo_dwn_der"></td>
            </tr>
          </table>
          <p><a href="javascript:cargar('listado.php','tabla')" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Categoria de Noticia</strong></a></p>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table></td>
  </tr>
 

