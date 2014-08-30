<?php require_once('../../Connections/cnx_arica.php'); ?>

<script language="text/javascript" src="../js/ajax.js"></script>


<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript">
$.validator.methods.equal = function(value, element, param) {
		return value == param;
	};
	$(document).ready(function(){
				
		$("#form1").validate({
				rules: {
					nombre_Txt: "required",
					
				},
				messages: {
					nombre_Txt: "Requerido",
					
					
					}
			});
	});
</script>

<?php
//initialize the session

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_arica'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_arica']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php


?>
<?php include('../includes/funciones.php');


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);


mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOrden = "SELECT max(Orden_Rubro) FROM empresa_rubro";
$rsOrden = mysql_query($query_rsOrden, $cnx_arica) or die(mysql_error());



?>


<?
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsTipo2 = "SELECT * FROM empresa ORDER BY Nombre_Emp ASC";
$rsTipo2 = mysql_query($query_rsTipo2, $cnx_arica) or die(mysql_error());
$row_rsTipo2 = mysql_fetch_assoc($rsTipo2);
$totalRows_rsTipo2 = mysql_num_rows($rsTipo2);

?>


<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/ajax.js">

</script>


<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
      <p class="titles">&raquo; M&oacute;dulo de Rubro de Empresa- Agregar</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><blockquote>
          <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
            <td width="11" height="11" id="cdo_top_izq"></td>
                  <td width="849" height="11" id="cdo_top_fnd"></td>
                  <td width="11" height="11" id="cdo_top_der"></td>
            </tr>
            <tr>
              <td background="../img/cdo_izq_fnd.jpg"></td>
              <td bgcolor="#EBEBEB"><form action="" method="POST" enctype="multipart/form-data" name="form1" target="frameSave"  id="form1">
                <table width="100%">
                  <tr>
                    <td width="46%" align="right" class="fuente"><strong>Rubro:</strong></td>
                    <td width="54%">
                     
                      <input type="text" name="nombre_Txt" id="nombre_Txt" title="Nombre de Categor&iacute;a">
                      <input type="hidden" value="<? echo $_GET['orden']?>" id="orden" name="orden">
                      
                      
                      </td>
                  </tr>
                  
                 
                  
                  
                  
                  <tr>
                    <td colspan="2" align="center">
                      <input type="hidden" name="MM_insert" value="form1">
                      <input name="SendForm" type="submit" id="SendForm" value=" Guardar " onClick="agregar_categoriaclasificado()">
                      </td>
                  </tr>
                </table>
              </form></td>
              <iframe id="frameSave" name="frameSave"  style="width:0;height:0;border:0; display:none"></iframe>
              <td background="../img/cdo_der_fnd.jpg"></td>
            </tr>
            <tr>
             <td id="cdo_dwn_izq" height="11" width="11"></td>
                  <td id="cdo_dwn_fnd" height="11"></td>
                  <td id="cdo_dwn_der"></td>
            </tr>
          </table>
          <p><a href="javascript:cargar('listado.php','tabla')" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Rubro de Empresa</strong></a></p>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table></td>
  </tr>
 
</table>
