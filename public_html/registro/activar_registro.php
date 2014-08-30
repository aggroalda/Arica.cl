<?php require_once('../Connections/cnx_arica.php'); ?>
<?php require_once('../include/header.php'); ?>

<div id="cuerpo">
    <div id="principal" class="principal">
    <div id="page"><div id="titulo_buscar_div"><h1 id="titulo_buscar">BUSCADOR</h1></div>
         <div id="resultsDiv"></div>
     </div>
     <div id="accion_ocultar">
 <?php 

//recogemos los valores enviados por el link de activacion que mandamos por mail
if (isset($_GET['id'])) {

$idval=$_GET['id'];
$activate2=$_GET['activateKey'];  ;

//y aqui es donde cambiamos el valor 1=desactivado  por valor 0=activado

$query = "UPDATE usuarios
            SET Estado_Usu = 1 WHERE Id_Usuario = $idval AND Activar_Usu ='$activate2'" ;
                mysql_query($query) or die(mysql_error());
  
if($query){
	?>
    <div id="activacion_cuerpo_izquierda">
    <table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td id="padding_encabezado">
	<div class="encabezado_activacion">
        <h1 id="titulo_activacion">Activación de cuenta exitosa</h1>
        <p><text id="subtitulo_activacion_1">Escrito por arica.cl</text>
           <text id="subtitulo_activacion_2">| El Verdadero portal Web de Arica</text>
        </p>
    </div>
   </td></tr>
   <tr><td id="padding_cuerpo">
    <div class="cuerpo_activación">
   		 <h2 id="agradecimiento_activacion_titulo"></h2>
         <p align="justify" id="agradecimiento_activacion_cuerpo">Te has registrado exitosamente. Desde hoy eres usuario de arica.cl
        <br><br>Estamos permanentemente preocupados de la mejora continua de nuestros servicios y es por eso que tu opinión nos importa y es fundamental en este proceso, esperamos ser un aporte a cada uno de ustedes.
         <br><br>
         Muchas Gracias
         <br><br>
         El equipo de arica.cl
         </p>
    </div>
      </td></tr></table>
    </div>
    
    <div id="activacion_cuerpo_derecha"><img id="aprobado" align="middle" src="../img/aprobacion.jpg" width="208" height="211" alt="aprobacion"></div>
	<? }                
else{
?>   <div id="activacion_cuerpo_izquierda">
    <table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td id="padding_encabezado">
	<div class="encabezado_activacion">
        <h1 id="titulo_activacion">Activación de cuenta errónea</h1>
        <p><text id="subtitulo_activacion_1">Escrito por arica.cl</text>
           <text id="subtitulo_activacion_2">| El Verdadero portal Web de Arica</text>
        </p>
    </div>
   </td></tr>
   <tr><td id="padding_cuerpo">
    <div class="cuerpo_activación">
   		 <h2 id="agradecimiento_activacion_titulo"></h2>
         <p align="justify" id="agradecimiento_activacion_cuerpo">Te has registrado erróneamente, vuelve a intentarlo más tarde, por favor.
        <br><br>Estamos permanentemente preocupados de la mejora continua de nuestros servicios y es por eso que tu opinión nos importa y es fundamental en este proceso, esperamos ser un aporte a cada uno de ustedes.
         <br><br>
         Muchas Gracias
         <br><br>
         El equipo de arica.cl
         </p>
    </div>
      </td></tr></table>
    </div>
    
    <div id="activacion_cuerpo_derecha"><img id="aprobado" align="middle" src="../img/desaprobacion.png" width="208" height="211" alt="aprobacion"></div>
	  <? 

}
}

        
        

?></div></div>
<div class="lateral"> <? include('../include/lateral.php')?></div>
</div>

<? include('../include/pie_pagina.php')?>
</body>
</html>
