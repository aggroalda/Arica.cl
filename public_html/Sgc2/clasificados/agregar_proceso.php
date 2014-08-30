<? require_once('../../Connections/cnx_arica.php'); ?>
<? require_once('../includes/funciones.php'); ?>
<? require_once('../includes/restriccion2.php');?>
 
<?
	$orden= $_GET['orden'] ;
  $insertSQL = sprintf("INSERT INTO categoria_clasificado (Nombre_CatCla, Orden_CatCla) VALUES (%s,%s)",
                       GetSQLValueString(utf8_decode($_GET['nombre']), "text"),
					    GetSQLValueString($orden, "text"));
;
  mysql_select_db($database_cnx_arica, $cnx_arica);
  $Result1 = mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
 
  $result=1
  ?>

<?  echo "SI" ;?>