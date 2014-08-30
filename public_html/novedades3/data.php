<? session_start(); ?>
<?php require('../Connections/cnx_arica.php'); ?>
<?

	

$comentario=$_POST['comentario'];
$comentario=utf8_decode($comentario);
$nombre=$_POST['nombre'];
$now=$_POST['now'];
$id_not=$_POST['id_not'];	
$id_usu=$_SESSION['MM_IdUser'];
/*$id_not=86;
$id_usuario =9;*/

$insertSQL = "INSERT INTO comentarios (Id_Noticia_Com,Id_Usuario_Com,Descripcion_Comentario,Fecha_Comentario) VALUES ($id_not,$id_usu,'$comentario',now())";

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
	 

?>



<!-- Le damos formato al comentario (html) -->



	
<div class="comentario">

	<img class="avatar" src="../img/icognito.png" />

	<div class="contenido">

		<h4 id="margin_titulo"><?=$nombre?></h4>
		<p id="margin_parrafo"><? echo utf8_encode($comentario)?></p><br />
		 <small id="margin_fecha"><?php /*?><?=$now?><?php */?></small>
	</div>

	<div class="clear">

</div>

