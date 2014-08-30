<?php require_once('../../Connections/cnx_arica.php'); ?>
<? if (isset($_GET['id_emp'])) {
	
	$ciudad1= $_GET['ciudad1'];
	$ciudad2= $_GET['ciudad2'];
	$id_emp= $_GET['id_emp'];
	
	$detalle= $_GET['detalle'];
	$precio= $_GET['precio'];
	// $foto= $_GET['foto'];
	$totalRows_rsPiso=-1;

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsDestino = "SELECT * FROM destino where IdDesde_Des=$ciudad1 AND IdHasta_Des= $ciudad2 ";
$rsDestino = mysql_query($query_rsDestino, $cnx_arica) or die(mysql_error());
$row_rsDestino = mysql_fetch_assoc($rsDestino);
$totalRows_rsDestino = mysql_num_rows($rsDestino);



mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsDestino = "SELECT * FROM destino_empresa,destino where destino_empresa.IdEmpresa_DestinoEmp= $id_emp AND destino_empresa.IdDestino_DestinoEmp= destino.Id_Destino
AND destino.IdDesde_Des=$ciudad1 AND IdHasta_Des= $ciudad2 ";
$rsDestino = mysql_query($query_rsDestino, $cnx_arica) or die(mysql_error());
$row_rsDestino = mysql_fetch_assoc($rsDestino);
$totalRows_rsDestino = mysql_num_rows($rsDestino);


if ($totalRows_rsDestino>0) { ?>
<div class="boxrojo curved" align="center">
<h3>DESTINO YA AGREGADO o USADO</h3>
<a href="javascript:agregarruta('<? echo $id_emp; ?>')"><img src="../img/volver.png" border="0"/></a><br /><br /><br /></div>
<? } else {
	
	/*
	
	$image = $_FILES['foto']['name'];
	$tempora = $_FILES['foto']['tmp_name'];
	$ubicacion = "../../destinos/img/";
	
	if ($image) { // si el campo de foto tiene contenido
		
			$ext = strtolower(substr($image, -3));
			
			if ($ext == "jpg") { // si la imagen es jpg
			 if(file_exists($ubicacion.$image))
  			  {  
       			 $nombre = $ultimo.$image;
   				 }
           else {$nombre= $image;
			   }
   			if (move_uploaded_file($tempora, $ubicacion.$nombre)) { // intentamos guardar la imagen en el servidor
				list($ancho, $alto, $tipo, $atr) = getimagesize("../../destinos/img/".$nombre);
					$file = "../../destinos/img/".$nombre;
				if ($ext=="jpg") {
							$imSrc  = imagecreatefromjpeg($file);
							}
							if ($ext=="gif") {
							$imSrc  = imagecreatefromgif($file);
							}

						$w = imagesx($imSrc);
						$h = imagesy($imSrc);
					$imTrg  = imagecreatetruecolor($width, $height);
						imagecopyresampled($imTrg, $imSrc, 0, 0, 0, 0, $width, $height, $w, $h);
							if ($ext=="jpg") { 
							imagejpeg($imTrg, $file);
							}
							if ($ext=="gif") { 
							imagegif($imTrg, $file); 
							}
				
			
					
				}  // fin de que si no se pudo guardar en el servidor la imagen 
			
		}  // fin de si la imagen no es jpg
	}
	*/
	
	
	mysql_select_db($database_cnx_arica, $cnx_arica);
$consultadestino =  "SELECT* FROM destino where IdDesde_Des= $ciudad1 AND IdHasta_Des= $ciudad2";
$rsDestino = mysql_query($consultadestino, $cnx_arica) or die(mysql_error());
$row_rsDestino = mysql_fetch_assoc($rsDestino);
$totalRows_rsDestino = mysql_num_rows($rsDestino);


	if ($totalRows_rsDestino>0){
		$id_destino= $row_rsDestino['Id_Destino'];}
	else {
	$SQL = "INSERT INTO destino (IdDesde_Des, IdHasta_Des) VALUES ('$ciudad1', '$ciudad2')";
	mysql_select_db($database_cnx_arica, $cnx_arica);
	mysql_query($SQL, $cnx_arica) or die(mysql_error());
	$id_destino=  mysql_insert_id($cnx_arica);}

	// $SQL2 = "INSERT INTO destino_empresa (IdDestino_DestinoEmp, 		IdEmpresa_DestinoEmp,Detalle_DestinoEmp,Precio_DestinoEmp, Foto_DestinoEmp) VALUES ('$id_destino', '$id_emp','$detalle','$precio','$nombre')";
	
	$SQL2 = "INSERT INTO destino_empresa (IdDestino_DestinoEmp, IdEmpresa_DestinoEmp,Detalle_DestinoEmp,Precio_DestinoEmp) VALUES ('$id_destino', '$id_emp','$detalle','$precio')";
	mysql_select_db($database_cnx_arica, $cnx_arica);
	mysql_query($SQL2, $cnx_arica) or die(mysql_error());



?>
	<blockquote><div class="boxverde curved" align="center">
    <h2>DESTINO AGREGADO</h2>
    <a href="javascript:tipoactive('<? echo $id_emp;?>')"><img src="../img/cerrar.png" border="0"/></a><BR/><BR/></div> </blockquote>
<? } ?>
<?php
mysql_free_result($rsPiso);
}
?>