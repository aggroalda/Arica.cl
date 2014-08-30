<?php require_once('../Connections/cnx_arica.php'); ?>
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>arica.cl | El verdadero portal de Arica</title>

<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.min.js"> </script>
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
<link href="../css/estilo.css" rel="stylesheet" type="text/css" />
<link href="../css/slider.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/slider.js"></script>
<link href="../css/desliza.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/desliza.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$(".ui-tabs-nav").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);
});
</script>



<script type="text/javascript" src="../js/mootools-yui-compressed.js"></script>
<script type="text/javascript" src="../js/sexylightbox.v2.3.mootools.min.js"></script>
<link rel="stylesheet" href="../css/sexylightbox.css" type="text/css" media="all" />
<script type="text/javascript">
    window.addEvent('domready', function(){
      SexyLightbox = new SexyLightBox({color:'black', dir: '../img/'});
    });
</script>




</head>
<body>
<div id="contenedor">
  <div id="cabeza">
  <div id="estado">
  <? include('../include/estado.php');?>
        </div>
      <div id="top">
        <div class="banner">  <h1><a href="../index/"><span>arica.cl, el verdadero portal de Arica</span></a></h1></div>
     <? include('../include/form_login.php');?>
     </div>
    	    <? include('../include/menu.php');?>
                
  </div>

    <div id="colores">
      <div class="a"></div><div class="b"></div><div class="c"></div><div class="d"></div><div class="e"></div><div class="f"></div><div class="g"></div><div class="h"></div></div>

	<div id="cuerpo">
    
    	<div class="principal">
        <div id="page"><div id="titulo_buscar_div"><h1 id="titulo_buscar">BUSCADOR</h1></div>
         <div id="resultsDiv"></div>
     </div>
     <div id="accion_ocultar">
		<? 
	
		 mysql_select_db($database_cnx_arica, $cnx_arica);
		$query_rsImagen = "SELECT *  FROM galeria where IdNoticia_Gal='$id_not'";
		$rsImagen = mysql_query($query_rsImagen, $cnx_arica) or die(mysql_error());
		$row_rsImagen = mysql_fetch_assoc($rsImagen);
		$totalRows_rsImagen = mysql_num_rows($rsImagen);
?>
 <div style="width:700px" id="featured">
<h2>&nbsp;</h2>
<h1><? echo utf8_encode($row_rsImagen2['Titulo_Not'])?></h1>
<p>&nbsp;</p>
<? echo $row_rsImagen2['Nombres_Per']?> <? echo $row_rsImagen2['Paterno_Per']?> <? echo $row_rsImagen2['Materno_Per']?>  | <? echo date("d-m-Y  h:i a",strtotime($row_rsImagen2['Fecha_Not']))?> 
 <p>&nbsp;</p>

 <h2 style="color:#FF6600; font-size:13px; font-weight:bold;"> <a href="javascript:cargar('../novedades/noticiaspaginacion.php?id_tip=<? echo $row_rsImagen2['Id_Categoria']?>','featured');seleccionado(li<? echo $row_rsImagen2['Id_Categoria']?>)"><? echo utf8_encode($row_rsImagen2['Nombre_Cat'])?> </a> </h2>
 <p>&nbsp;</p>

	<p align="justify" >	
	<div style="float:left;width:400px;margin-right:12px">
    
    
    

    
     <a style="cursor:hand;" rel="sexylightbox[group1]" title="<? echo $row_rsImagen2['Titulo_Not'] ; echo "<br>".$row_rsImagen['Descripcion_Gal'];?>"  href="img/<?php echo $row_rsImagen2['Archivo_Gal']; ?>">
     <img src="../novedades/img/<?php echo $row_rsImagen2['Archivo_Gal']; ?>" class="corners iradius8 iborder1 icolor999999" border="0" style="margin:5px 0 5px 0;" width="400" height="250"  >
     </a>
     
     
     <div style="display:none">
     <? 
	 
	 if ($totalRows_rsImagen>1){
	 
	 do {
		 ?>
		 <a style="cursor:hand;" rel="sexylightbox[group1]" title="<? echo $row_rsImagen2['Titulo_Not'] ; echo "<br>".$row_rsImagen['Descripcion_Gal'];?>"  href="img/<?php echo $row_rsImagen['Archivo_Gal']; ?>">
 <?php /*?>    <img src="../include/imagen.php?ubica=../novedades/img/&nw=400&foto=<?php echo $row_rsImagen['Archivo_Gal']; ?>" class="corners iradius8 iborder1 icolor999999" border="0" style="margin:5px 0 5px 0;" width="400" height="250"  ><?php */?>
   <img style="margin:5px 0 5px 0;" src="../include/imagen.php?nw=400&foto=<?php echo $row_rsImagen2['Archivo_Gal']; ?>&ubicacion=../novedades/img/" border="0"/>
 
     </a>
		 <? }while ($row_rsImagen=mysql_fetch_assoc($rsImagen));
		 
		 }?>
     </div>
    
    
    
    
    
    
    
		
          <div style="font-style:italic;"><?php echo utf8_encode($row_rsImagen2['Descripcion_Gal']); ?> </div>
       </div>
	    
<p style="text-align:justify; font-size:12px; margin-right:10px;" >
     <? $row_rsImagen2['Desarrollo_Not'] = str_replace("\n", "<br>", $row_rsImagen2['Desarrollo_Not']);
					echo utf8_encode($row_rsImagen2['Desarrollo_Not']); 
	 
	 
	 ?> </p>
       </p>
 
<p>&nbsp;</p>

<p>&nbsp;</p>
   
   </div>
   
         <div style="width:700px;height:241px">
            <div id="recomen" style="margin-top:4px;border-top:1px dashed #CCCCCC"><h1>Nosotros Recomendamos</h1>
            	<div class="izq">
                    <h2>Restaurantes</h2>               
                    <div class="item e3">CARNES Y POLLO CHAVE</div>
                    <div class="item e3">CARBONES Y ANZUELOS</div>
                    <h2>Tiendas de Ropa y Vestir</h2>
                    <div class="item sinback">Dmoda</div>
                    <div class="item sinback">Topitop</div>
                    <div class="item sinback">Hush pipe</div>
                    <div class="item sinback">Bata</div>                
                    <h2>Alojamiento</h2>
                    <div class="item e3">HOTEL arica</div>
                    <div class="item e2">HOTEL CENTRAL TACNA</div>
                    <div class="item e1">APART HOTEL LUXOR</div>                    
				</div>
            	<div class="der">
                    <h2>Discotecas, Bares y Pubs</h2>
                    <div class="item e3">D'CAJOON</div>
                    <div class="item sinback">MÜCHNER</div>
                    <div class="item sinback">Jehtro's Pub</div>
                    <div class="item sinback">Eurobar</div>
                    <div class="item sinback">Jazuu</div>
                    <div class="item sinback">Bocatto di Cardinale</div>
                    <div class="item sinback">Leonardos Bar</div>
                    <div class="item sinback">KM 0</div>
                    <h2>Atención Médica</h2>  
                    <div class="item">POLICLINICO DENTAL DENTUS</div>
                    <div class="item sinback">Ceinco</div>
                    <div class="item sinback">Clínica de Ojos de Tacna</div>
                    <div class="item sinback">Oftalmosur</div>
                    <div class="item sinback">Óptica GMO</div>                                              
            	</div>                
          </div>
            <div id="mapas" style="border-top:1px dashed #CCCCCC;margin-top:4px"><h1>Mapas de Arica</h1><p>La más completa guia de calles en mapas de tacna, también busca todos los establecimientos de comercio, restaurantes, tiendas de ropa, y todo lo que un visitante puediera necesitar, ¿te gustaria participar? <a href="#">registrate ya!</a></p><img src="../img/mapa.jpg" alt="Mapas de arica" />
          </div>
          </div>
            <div id="turismo">
              <h1>Turismo en Arica</h1>
            	<div class="item"><img src="../img/noticias/tur1.jpg" alt="bolo campeon" />
           	  <h3>Arica, Tour en la ciudad</h3><p>Visita al Alto de la Alianza, Campiña de Pocollay, Ruta del Pisco, Centro Histórico, Petroglifos de Miculla.<a href="#">Desde S/. 70.00 x P.</a></p></div>
            	<div class="item"><img src="../img/noticias/tur2.jpg" alt="mis tacna en ayuda social" />
           	  <h3>Putre, Baños termales</h3><p>Visita a 3 Baños Termales en la provincia, visita a iglesias, zonas incaicas y al camino inca de la zona.<a href="#">Desde S/. 130.00 x P.</a></p></div>
            	<div class="item"><img src="../img/noticias/tur3.jpg" alt="hugo ordonhez desaparecido" />
           	  <h3>Ite, Playas y Fauna</h3><p>Visita a las playas más bonitas de Ite, Humedales de Ite y todo el recorrido montado en finos caballos.<a href="#">Desde S/. 100.00 x P</a></p></div>
            	<div class="item sinborde"><img src="../img/noticias/tur4.jpg" alt="carnaval de tacna" />
           	  <h3>Ilabaya, Eco-Aventura </h3><p>Trecking en la zona aridas de las alturas de Ilabaya, visita a bellas cataratas y escalada básica en rocas.<a href="#">Desde S/. 100.00 x P.</a></p></div>                       
            </div>
            <div id="compras">
	            <h1>Compra en Arica</h1>
                <div class="item"><img src="../img/noticias/compras.jpg" alt="compras" /><h3>MORRO DE ARICA</h3><div class="tag">Artesanias</div><p>Morro de Arica de yeso, para regalos y recuerdo personales.</p><div class="precio">$ 6 000</div></div>
                <div class="item"><img src="../img/noticias/compras.jpg" alt="compras" /><h3>PIEDRA MICULLA</h3><div class="tag">Ceramicas</div><p>Variadas replicas de antiguos petroglifos de miculla.</p><div class="precio">$ 5 000</div></div>
                <div class="item"><img src="../img/noticias/compras.jpg" alt="compras" /><h3>PINTURA ARIQUEÑA</h3><div class="tag">Pintura</div><p>Oleo realizado por artistas tacneños.</p><div class="precio">$ 40 000</div></div>                                
            </div>       
                
            <div id="publicidad"><img src="../img/banner2.jpg" alt="muebles" /><img src="../img/adsense.jpg" alt="adsense" /></div>
            <div id="cole"><h1>El blog de tu cole</h1><img src="../img/cole.jpg" alt="El blog de tu cole" /><p>Tener un blog escolar no es algo muy complicado, más... <a href="#">ver más</a></p></div>
			
            <div class="banner"><img src="../img/banner3.jpg" alt="DirecTV" /></div>
            
			<div id="clasificados">
            <? include('../include/clasificados.php')?>
            </div>
           
            <div id="encuesta">
                <h1>Encuesta</h1>
                <p>¿Está de acuerdo con las leyes que promueven la construcción de servicios turísticos en los bienes inmuebles integrantes del patrimonio cultural?</p>
                <div class="opc"><input type="radio" id="opc1" class="encuesta"/><label for="opc1">Si</label></div>
                <div class="opc"><input type="radio" id="opc2" class="encuesta"/><label for="opc2">No</label></div>
                <div class="resultado">999 votos</div>
                <div class="enlaces"><a href="#">Votar</a> <a href="#">Resultados</a></div>
			</div>

      </div>
        
      	<div class="lateral">
        <? include('../include/lateral.php')?>
         </div>
    </div></div>
    
	<div id="pie"><span><hr /></span><p><a href="index.html">arica.cl</a> es una marca registrada de <a href="#">Darwin Alarcón</a><br />Todos los derechos reservados<br />Prohibida su copia o reproducción bajo las sanciones que impongan las leyes chilenas e internacionales<br /></p></div>
</div>
</body>
</html>
