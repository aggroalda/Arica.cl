<? require_once('../../Connections/cnx_arica.php'); ?>
<? require_once('../includes/funciones.php'); ?>
<? require_once('../includes/restriccion2.php');?>

<?
	
	$orden= $_GET['orden'];		
		 
  $insertSQL = sprintf("INSERT INTO empresa_rubro_sub (Rubro_Id, Rubro_Sub_Nombre, Rubro_Sub_Orden) VALUES (%s,%s,%s)",
                         GetSQLValueString($_GET['tipo'], "int"),
					   GetSQLValueString(utf8_decode($_GET['nombre']), "text"),
					    GetSQLValueString($orden, "text"));
;
  mysql_select_db($database_cnx_arica, $cnx_arica);
  $Result1 = mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
 
  $result=1
  ?>

<?  echo "SI" ;?>