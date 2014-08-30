<? require_once('../../Connections/cnx_arica.php'); ?>
<? require_once('../includes/funciones.php'); ?>
<? require_once('../includes/restriccion2.php');?>
 
<?

if (($_POST['nombre_Txt']!='') && (isset($_POST['nombre_Txt']))) {
		
	$orden= $_GET['orden'] ;
  $insertSQL = sprintf("INSERT INTO categoria (Nombre_Cat, Orden_Cat) VALUES (%s,%s)",
                       GetSQLValueString(utf8_decode($_POST['nombre_Txt']), "text"),
					    GetSQLValueString($_POST['orden'], "text"));
;
  mysql_select_db($database_cnx_arica, $cnx_arica);
  $Result1 = mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
 
  $result=1;

   } else {
	$result = 0;
	  }
  ?>



<script language="javascript" type="text/javascript">window.top.window.cargar("listado.php","tabla");</script> 