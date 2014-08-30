<?php require_once('../../Connections/cnx_arica.php'); ?>

<?
// subir orden del menu
if( isset($_GET['accion']) && $_GET['accion'] == 'subir'){
	$orden= $_GET['orden'];
    $id_cat = $_GET['id_cat'];
    $ordenSubir = $_GET['orden'] - 1;  
    $ordenBajar = $_GET['orden'] + 1;  
	 mysql_select_db($database_cnx_arica, $cnx_arica);
     mysql_query("UPDATE categoria SET Orden_Cat = $ordenBajar
                             WHERE Orden_Cat = $orden", $cnx_arica)
                             or die(mysql_error());
			 header("Location: index.php");
    mysql_select_db($database_cnx_arica, $cnx_arica);
     mysql_query("UPDATE categoria SET Orden_Cat = $ordenSubir
                             WHERE Id_Categoria = $id_cat", $cnx_arica)
                             or die(mysql_error());
	
	header("Location: index.php");
}


// bajar orden del menu
if(isset($_GET['accion']) && $_GET['accion'] == 'bajar'){
    $id_cat = $_GET['id_cat'];
    $ordenSubir = $_GET['orden'] - 1;
    $ordenBajar = $_GET['orden'] + 1;
    mysql_select_db($database_cnx_arica, $cnx_arica);
     mysql_query("UPDATE categoria SET Orden_Cat = '$ordenBajar'
                             WHERE Id_Categoria = '$id_cat'", $cnx_arica)
                             or die(mysql_error());
	 mysql_select_db($database_cnx_arica, $cnx_arica);
     mysql_query("UPDATE categoria SET Orden_Cat = '$ordenSubir'
                             WHERE Orden_Cat = '$orden'", $cnx_arica)
                             or die(mysql_error());
	header("Location: index.php");
}

?> 