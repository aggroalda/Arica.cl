<?php require_once('../Connections/cnx_arica.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>Sistema de comentarios con AJAX</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="mx.js"></script>
    
<link rel="stylesheet" type="text/css" href="mx.css">
	</head>

	<body>
<h4>Sistema de comentarios con AJAX</h4>
	<? 

$id_not=86;	
$id_usu=9;		

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsComentario2 = "SELECT * FROM usuarios,noticias where noticias.Id_Noticia=$id_not AND usuarios.Id_Usuario=$id_usu";
$rsComentario2  = mysql_query($query_rsComentario2, $cnx_arica) or die(mysql_error());
$row_rsComentario2  = mysql_fetch_assoc($rsComentario2);
$totalRows_rsComentario2  = mysql_num_rows($rsComentario2); 

$nombre_bd=utf8_encode($row_rsComentario2['Usern_Usu']);
$nombre_bd_post=$_POST['nombre_bd'];
?>
		
       <div id="contenedor">

			<form action="#">

<p>Nombre:<input type="hidden" id="nombre" value="<? echo $nombre_bd; ?>"/><? echo $nombre_bd;?></p>

				<p>Comentario:<br/> <textarea class="editor" id="comentario"></textarea></p>

				<p><input id="boton-enviar" type="submit" value="enviar" /></p>
			
			</form>

		</div>

		<h5>Los comentarios:</h5>


		
		<strong id="mensaje"></strong>
        
        <div id="comentarios">

			<!-- aca apareceran los nuevos comentarios -->

		</div>

		
           <? 

mysql_select_db($database_cnx_arica, $cnx_arica); 
$query_rsComentario = "SELECT *  FROM  comentarios,usuarios,noticias where comentarios.Id_Noticia_Com=$id_not AND comentarios.Id_Noticia_Com= noticias.Id_Noticia AND comentarios.Id_Usuario_Com= usuarios.Id_Usuario order by Fecha_Comentario desc LIMIT 0,10";
$rsComentario  = mysql_query($query_rsComentario, $cnx_arica) or die(mysql_error());
$row_rsComentario  = mysql_fetch_assoc($rsComentario);
$totalRows_rsComentario  = mysql_num_rows($rsComentario);


if(isset($row_rsComentario['Id_Comentario']))
{	
  
	do{
$nombre_bd=utf8_encode($row_rsComentario['Usern_Usu']);
$nombre_bd1=utf8_encode($row_rsComentario['Usern_Usu']);
$comentario_bd1=utf8_encode($row_rsComentario['Descripcion_Comentario']);
$fecha_bd=utf8_encode($row_rsComentario['Fecha_Comentario']);

		 ?> 
    
     <div class="comentario">

	<img class="avatar" src="http://www.delibertad.com/static/images/avatars/eva.png" />

	<div class="contenido">

		<h4 id="margin_titulo"><?=$nombre_bd1?></h4>
		<p id="margin_parrafo"><?=$comentario_bd1?></p><br />
        <small id="margin_fecha"><?  echo date("d-m-Y", strtotime($fecha_bd)) . "\n"; ?> 
				<? echo	date("h:m:s", strtotime($fecha_bd)) . "\n"; ?></small>

	</div>

</div>
 <? } while($row_rsComentario=mysql_fetch_assoc($rsComentario)); ?>

<? } else {?>

<strong id="mensaje">No hay comentarios</strong>

<? }?>
   
        

	</body>

</html>