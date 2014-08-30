<?php require_once('../Connections/cnx_arica.php'); ?>
<?php require_once('../include/header.php'); ?>
<?php require('twitteroauth.php');?>

	<div id="cuerpo">
    
    <div class="principal" id="principal">

<div id="page"><div id="titulo_buscar_div"><h1 id="titulo_buscar">BUSCADOR</h1></div>
         <div id="resultsDiv"></div>
     </div>
     <div id="accion_ocultar">

<div id="featured3">
<? mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsNoticias = "SELECT *  FROM noticias where Estado_Not='1' AND Id_Noticia='".$_GET['id_not']."'";
$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
$totalRows_rsNoticias = mysql_num_rows($rsNoticias);

	 $id_not=$_GET['id_not'];
?>
<? mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsImagen2 = "SELECT *  FROM noticias,categoria,galeria,usuarios,personas where  noticias.IdCategoria_Not= categoria.Id_Categoria AND galeria.IdNoticia_Gal='$id_not' and galeria.IdNoticia_Gal= noticias.Id_Noticia AND galeria.Portada_Gal='1' AND noticias.IdUsuario_Not= usuarios.Id_Usuario AND usuarios.IdPersona_Usu= personas.Id_Persona";
$rsImagen2 = mysql_query($query_rsImagen2, $cnx_arica) or die(mysql_error());
$row_rsImagen2 = mysql_fetch_assoc($rsImagen2);
$totalRows_rsImagen2 = mysql_num_rows($rsImagen2);


if (isset($_GET['id_not'])) {
  $colname_rsProducto = $_GET['id_not'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsProducto = sprintf("SELECT * FROM noticias,categoria,usuarios,personas WHERE noticias.IdCategoria_Not= categoria.Id_Categoria AND noticias.IdUsuario_Not=usuarios.Id_Usuario AND usuarios.IdPersona_Usu= personas.Id_Persona AND noticias.Id_Noticia='%s' ", GetSQLValueString($colname_rsProducto, "int"));
$rsProducto = mysql_query($query_rsProducto, $cnx_arica) or die(mysql_error());
$row_rsProducto = mysql_fetch_assoc($rsProducto);
$totalRows_rsProducto = mysql_num_rows($rsProducto);

$colname_rsFotos = "-1";
if (isset($_GET['id_not'])) {
  $colname_rsFotos = $_GET['id_not'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsFotos = sprintf("SELECT * FROM galeria WHERE IdNoticia_Gal = '%s' ORDER BY Id_Galeria ASC", GetSQLValueString($colname_rsFotos, "int"));
$rsFotos = mysql_query($query_rsFotos, $cnx_arica) or die(mysql_error());
$row_rsFotos = mysql_fetch_assoc($rsFotos);
$totalRows_rsFotos = mysql_num_rows($rsFotos);
?>


   	<? 
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsImagen = "SELECT *  FROM galeria where IdNoticia_Gal='$id_not'";
$rsImagen = mysql_query($query_rsImagen, $cnx_arica) or die(mysql_error());
$row_rsImagen = mysql_fetch_assoc($rsImagen);
$totalRows_rsImagen = mysql_num_rows($rsImagen);
?>
<h2>&nbsp;</h2>
<h1><? echo utf8_encode($row_rsImagen2['Titulo_Not'])?></h1>
<h2>&nbsp;</h2>
<p  id="padding_creado_por">
Creado por <? echo $row_rsImagen2['Nombres_Per']?> <? echo $row_rsImagen2['Paterno_Per']?> <? echo $row_rsImagen2['Materno_Per']?>  el <? echo '<text>'. date("d-m-Y\n",strtotime($row_rsImagen2['Fecha_Not'])).'</text>';
echo '<text style="color:#fff; background-color:#002448; font-weight:bold;">'. date("h:i a",strtotime($row_rsImagen2['Fecha_Not'])).'</text>'

?> </p>

<div id="fotoNoticia">
<table width="60%" cellpadding="0" cellspacing="0" align="center">
<tr>
<td>

</td>
</tr>

<tr>
<td>

<div id="titulo_not">        

 <div>

 <div id="arc_gal">
  <div id="archivo_gal">


 </div>
   <?php if ($totalRows_rsFotos == 0) { // Show if recordset empty ?>
  <p>Sin imagenes agregadas por el momento</p>
  <?php } // Show if recordset empty ?>
<?php if ($totalRows_rsFotos>0) {
				  $i=1;
				  do { ?>
                  <p><strong><? if($i<1){echo "Foto";} ?></strong><br>
 <a <? if($i>1){echo"style='display:none'";} ?> style="cursor:hand; z-index:0; position:relative;" rel="sexylightbox[]" 
 title="<? echo utf8_encode($row_rsProducto['Titulo_Not'])."."."\n-".utf8_encode($row_rsFotos['Descripcion_Gal']);?>"  href="../novedades/img/<?php echo $row_rsFotos['Archivo_Gal']; ?>">
 <div id="color_td" class="hover">
 <h3 id="tit_h3">&nbsp;<? echo utf8_encode($row_rsImagen2['Nombre_Cat']);?>&nbsp;</h3>
 </div>
 <div style="position:relative; z-index:0; width:auto">
 <img id="img_mar" src="../include/imagen.php?nw=400&foto=<?php echo $row_rsFotos['Archivo_Gal']; ?>&ubicacion=../novedades/img/" border="0"/></div></a>
  </div>
  </div>  
  
     
   <div id="descripcion_gal"><i><?php if($i<2){echo utf8_encode($row_rsImagen2['Descripcion_Gal']);} ?> </i></div>
       </div>
    <?   $i++;
		} while ($row_rsFotos = mysql_fetch_assoc($rsFotos)); ?><? } ?>
</td>
</tr>
</table>
</div>

<div class="contenedor_thumbs"> 

<? $colname_rsFotos = "-1";
if (isset($_GET['id_not'])) {
  $colname_rsFotos = $_GET['id_not'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsFotos = sprintf("SELECT * FROM galeria WHERE IdNoticia_Gal = '%s' ORDER BY Id_Galeria ASC", GetSQLValueString($colname_rsFotos, "int"));
$rsFotos = mysql_query($query_rsFotos, $cnx_arica) or die(mysql_error());
$row_rsFotos = mysql_fetch_assoc($rsFotos);
$totalRows_rsFotos = mysql_num_rows($rsFotos);

if (isset($_GET['id_not'])) {
  $colname_rsProducto = $_GET['id_not'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsProducto = sprintf("SELECT * FROM noticias,categoria,usuarios,personas WHERE noticias.IdCategoria_Not= categoria.Id_Categoria AND noticias.IdUsuario_Not=usuarios.Id_Usuario AND usuarios.IdPersona_Usu= personas.Id_Persona AND noticias.Id_Noticia='%s' ", GetSQLValueString($colname_rsProducto, "int"));
$rsProducto = mysql_query($query_rsProducto, $cnx_arica) or die(mysql_error());
$row_rsProducto = mysql_fetch_assoc($rsProducto);
$totalRows_rsProducto = mysql_num_rows($rsProducto);
?>

   <?php if ($totalRows_rsFotos == 0) { // Show if recordset empty ?>
  <p>Sin imagenes agregadas por el momento</p>
  <?php } // Show if recordset empty ?>
<?php if ($totalRows_rsFotos>0) {
				  $i=1;
				  do { ?>
<div class="thumbs_not" id="arc_gal_thumbs" >
                 
 <a style="cursor:hand;" rel="sexylightbox[]" 
 title="<? echo utf8_encode($row_rsProducto['Titulo_Not'])."."."\n-".utf8_encode($row_rsFotos['Descripcion_Gal']);?>"  href="../novedades/img/<?php echo $row_rsFotos['Archivo_Gal']; ?>">
 <img src="../include/imagen.php?nw=80&foto=<?php echo $row_rsFotos['Archivo_Gal']; ?>&ubicacion=../novedades/img/" border="0"/></a>
  </div>
  
  		<? } while ($row_rsFotos = mysql_fetch_assoc($rsFotos)); ?><? } ?>


</div>
     <br>
 <?php /*?>   <div id="div_comentario_1">
     
			 <?	 
            $row_rsImagen2['Desarrollo_Not'] = str_replace("\n", "<br>", $row_rsImagen2['Desarrollo_Not']);
            
			$columna1 = substr($row_rsImagen2['Desarrollo_Not'],0,1000);
             
            $indiceUltimoEspacio = strrpos($columna1," ");
         
            $columna1_1= substr($row_rsImagen2['Desarrollo_Not'],0, $indiceUltimoEspacio);
        
            ?> <p align="justify"> <? echo utf8_encode($columna1_1); ?> </p>
        
     </div><?php */?>
        
    <div id="div_comentario_2">
    
		   <? 
		   
           $columna2 = $row_rsImagen2['Desarrollo_Not']; 
           
		   ?> 
           
           <p align="justify"> <? echo utf8_encode($columna2);?> </p>
           
     </div>
    
<script src="http://platform.twitter.com/anywhere.js?id=wDBIpnmYdx6kTioZp48Xg&v=1"></script>

 
     <div id="iframe_twitter"> 
<?


define('_CONSUMER_KEY','wDBIpnmYdx6kTioZp48Xg'); //La obtenes en el paso 1
define('_CONSUMER_SECRET','ZJOOuRIKJIBefHDT3aDTkX3fkSIRJfosEYrY1AtTucY'); //La obtenes en el paso 1
define('_OAUTH_TOKEN','215468566-qaHReo3O3LHeP3clraICZcaln49VBv0Ju9RZEjwj'); //La obtenes en el paso 1
define('_OAUTH_TOKEN_SECRET','HSPzhYqQli2TheMCbkrxxI8GUYaNhislAfIOPVBWSk'); //La obtenes en el paso 1
 
		$bit=tinyurl($link); //reducimos el link con la api de bit.ly
		$quedan=(140-strlen($bit))-4; // calculo los caracteres restantes que me quedan para publicar restando los puntos suspensivo
		$mensaje=substr($mensaje,0,$quedan).' ...'.$bit; // corto el mensaje en caso de que sea muy largo
 
//declaramos la función que realiza la conexión a tu aplicación de twitter
		function getConnectionWithAccessToken() {
                    $connection = new TwitterOAuth(_CONSUMER_KEY, _CONSUMER_SECRET,_OAUTH_TOKEN, _OAUTH_TOKEN_SECRET);
                   return $connection;
                }
//Realizamos la conexión
$connection = getConnectionWithAccessToken();
//Publicamos el mensaje en twitter
$twitter=$connection->post('statuses/update', array('status' =>utf8_encode($mensaje)));
//Función para acortar URL con bit.ly . Primero debemos registrarnos en http://bit.ly para obtener clave api y usuario
 function tinyurl($url_larga){
$tiny = "http://api.bit.ly/v3/shorten?login=o_3tp23r37p4&apiKey=R_5d4bb1271dc717c4e370c38e70cb5eb6&format=txt&longUrl=".$url_larga;
$sesion = curl_init();
curl_setopt ( $sesion, CURLOPT_URL, $tiny );
curl_setopt ( $sesion, CURLOPT_RETURNTRANSFER, 1 );
$url_tiny = curl_exec ( $sesion );
curl_close( $sesion );
return($url_tiny);
} 



?>

<script language="javascript" type="text/javascript">
<!--
   function VaciarDIV(){
      var obj = document.getElementById('tweetControls');
      obj.innerHTML = "";
   }
   
   function limpiar(){
   document.getElementById("tweetControls").value="";
	}

//-->
</script>
</head>
 


<div id="tweetControls"></div>
<script type="text/javascript">


 twttr.anywhere(function (T) {
 
  
 var me = this; 

    var a = T('#tweetControls').tweetBox({
		
		
	   label:"Twiteando desde http://arica.cl", 
		
       height :100, 

       width : 630, 
		
       defaultContent : '', 

       counter : true, 

       complete : function (tweetBox) {

          me.tweetBox = tweetBox; 

          try {

             me.tweetBox.$editor.css({

                resize : 'none', 

                color : '#9B9B9B', 

                'font-family': 'Arial', 

                'font-size': '14px', 

                border : '1px solid #ccc',
				
                 background : 'transparent', 

                'border-radius': 0, 

                '-webkit-border-radius': 0, 

                '-moz-border-radius': 0 

             }); 
			 

             me.tweetBox.$button.css( {

                cursor : 'hand', 

                cursor : 'pointer' 

             }); 
			 
			   
	      } catch (e) {

       
	      }

       }, 
			 
       onTweet : function () {

          me.tweetBox.setContent('Restore default text'); 

       }

    }); 
	
 });

</script>
     </div>
   <div id="redes_sociales">
<table width="auto" height="auto" cellpadding="0" cellspacing="0" border="0">
<tr>
 <td>
   <div><a href="https://twitter.com/share" class="twitter-share-button" data-lang="es" data-size="medium" data-count='vertical'>Twittear</a></div>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </td>
    <td>
    <div id="twitter_compartir" >
    <a name="fb_share" type="box_count"></a> 
   </div>
    <script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>    
    </td>
 <td>
 <!--   <a href="https://plus.google.com/share?url={URL}" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img
  src="https://www.gstatic.com/images/icons/gplus-64.png" alt="Share on Google+"/></a>-->
 <script src="https://apis.google.com/js/plusone.js"></script>
<div id="twitter_compartir"><g:plus action="share" annotation="vertical-bubble"></g:plus></div>
    </td>
   

    <td>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <div id="twitter_compartir" class="fb-like" data-send="true" data-layout="box_count" data-width="auto" data-show-faces="true" data-font="verdana"></div>
    </td>
   

</tr>
</table>
</div>

        <div id="dsqus_coment">
             <div id="disqus_thread"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'aricadarwinalarcon'; // required: replace example with your forum shortname

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
        
      
      
      </div>
      


   
</div> 



</div>
 </div> 
 <div  class="lateral">
        <? include('../include/lateral.php')?>
           </div>
  
               <div id="div_nombre_cat"></div>
      
        <div id="div_nombre_cat2"><table width="auto" height="100%" cellpadding="4" cellspacing="0" border="0"><tr><td><text id="text_style">categoria:&nbsp;</text><i><text id="tipo_letra"><a onClick="document.getElementById('aparece_lateral').style.display='block'" id="href_styles" href="javascript:cargar('../novedades/noticiaspaginacion.php?id_tip=<? echo $row_rsImagen2['Id_Categoria']?>','featured4');seleccionado(li<? echo $row_rsImagen2['Id_Categoria']?>)"><? echo utf8_encode($row_rsImagen2['Nombre_Cat']);?> </a> </text></i></td></tr></table></div>
    </div>
    
 <? include('../include/pie_pagina.php')?>
</body>
</html>