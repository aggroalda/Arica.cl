<? require_once('../../Connections/cnx_arica.php'); ?>
<? require_once('../includes/funciones.php'); ?>
<? require_once('../includes/restriccion2.php');?>
<?
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



  $updateSQL = sprintf("UPDATE categoria SET Nombre_Cat=%s, Estado_Cat=%s WHERE Id_Categoria=%s",
                       GetSQLValueString(utf8_decode($_POST['nombre_Txt']), "text"),
                       GetSQLValueString(isset($_POST['estado_Txt']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['id_cat'], "int"));

  mysql_select_db($database_cnx_arica, $cnx_arica);
  $Result1 = mysql_query($updateSQL, $cnx_arica) or die(mysql_error());

  


?>
<script language="javascript" type="text/javascript">window.top.window.cargar("listado.php","tabla");</script> 