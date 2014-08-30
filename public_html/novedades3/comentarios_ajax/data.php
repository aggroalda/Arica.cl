
<?php
require('../Connections/cnx_arica.php');

$comentario=$_POST['comentario'];
$nombre=$_POST['nombre'];
$now=$_POST['now'];

$id_not=86;
$id_usuario =9;
$insertSQL = "INSERT INTO comentarios (Id_Noticia_Com,Id_Usuario_Com,Descripcion_Comentario,Fecha_Comentario) VALUES ($id_not,$id_usuario,'$comentario',now())";

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
	 

?>



<!-- Le damos formato al comentario (html) -->



	
<div class="comentario">

	<img class="avatar" src="http://www.delibertad.com/static/images/avatars/eva.png" />

	<div class="contenido">

		<h4 id="margin_titulo"><?=$nombre?></h4>
		<p id="margin_parrafo"><?=$comentario?></p><br />
		 <small id="margin_fecha"><?=$now?></small>
	</div>

	<div class="clear">

</div>

