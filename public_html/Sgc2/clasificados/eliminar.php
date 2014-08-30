<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php include('../includes/funciones.php');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$colname_rsCategoria = "-1";
if (isset($_GET['id_del'])) {
  $colname_rsCategoria = $_GET['id_del'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoria = sprintf("SELECT * FROM categoria_clasificado WHERE Id_CategoriaClasificado =%s", GetSQLValueString($colname_rsCategoria, "int"));
$rsCategoria = mysql_query($query_rsCategoria, $cnx_arica) or die(mysql_error());
$row_rsCategoria = mysql_fetch_assoc($rsCategoria);
$totalRows_rsCategoria = mysql_num_rows($rsCategoria);
?>





  <tr>
    <td><blockquote>
      <p class="titles">&raquo; M&oacute;dulo de Categor&iacute;as - Eliminar</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><blockquote>
          <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="11"><img src="../img/cdo_top_izq.jpg"/></td>
              <td width="849" background="../img/cdo_top_fnd.jpg"></td>
              <td width="11"><img src="../img/cdo_top_der.jpg"/></td>
            </tr>
            <tr>
              <td background="../img/cdo_izq_fnd.jpg"></td>
              <td bgcolor="#EBEBEB">
                <table width="100%">
                  <tr>
                    <td width="46%" align="right" class="fuente"><strong>Categor&iacute;a de Noticia:</strong></td>
                    <td width="54%" class="fuente">
                      <?php echo utf8_encode($row_rsCategoria['Nombre_CatCla']); ?></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" class="linksRojo fuente"><strong>&iquest;Est&aacute; seguro de eliminar esta categor&iacute;a de clasificado? Eliminar&aacute; las noticias relacionadas a esta categor&iacute;a.</strong></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center">
                    <form action="eliminar_all.php" method="POST" enctype="multipart/form-data" name="form1" target="frameSave"  id="form1">
                    <input type="hidden" value="<? echo $_GET['id_del']?>" id="id_del" name="id_del">
                      <input type="hidden" value="<? echo $_GET['orden']?>" id="orden" name="orden">
                      <input name="SendForm" type="submit" id="SendForm" value=" Eliminar " onClick="javascript:return eliminar_categoria_clasificado('<?php echo $row_rsCategoria['Id_CategoriaClasificado']; ?>','<?php echo utf8_encode($row_rsCategoria['Nombre_CatCla']); ?>','<?php echo $row_rsCategoria['Orden_CatCla']; ?>')">
                      </form>
                          <iframe id="frameSave" name="frameSave"  style="width:0;height:0;border:0; display:none"></iframe> 
                      </td>
                  </tr>
                </table>
              </td>
              <td background="../img/cdo_der_fnd.jpg"></td>
            </tr>
            <tr>
              <td height="11"><img src="../img/cdo_dwn_izq.jpg" width="11" height="11"/></td>
              <td background="../img/cdo_dwn_fnd.jpg"></td>
              <td><img src="../img/cdo_dwn_der.jpg" width="11" height="11"/></td>
            </tr>
          </table>
          <p><a href="javascript:cargar('listado.php','tabla')" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Categor&iacute;a de Clasificado</strong></a></p>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table></td>
  </tr>
