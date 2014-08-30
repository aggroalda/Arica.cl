<?php require_once('../Connections/cnx_arica.php'); ?>
<?php require_once('../include/header.php'); ?>

	<div id="cuerpo">
    <div class="principal" id="principal">
 <div id="page"><div id="titulo_buscar_div"><h1 id="titulo_buscar">BUSCADOR</h1></div>
         <div id="resultsDiv"></div>
     </div>
     <div id="accion_ocultar">
  <? include('../include/buscargoogle2.php')?>
  

<div id="buscararica" style="display:none;width:700px">
<gcse:search></gcse:search>
</div>
<div id="featured2">
<? include('noticiaspaginacion.php')?>
</div>

  
  
            
             <div style="width:700px;height:241px;display:none"  >
            <div id="recomen"><h1>Nosotros Recomendamos</h1>
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
            <div id="mapas"><h1>Mapas de Arica</h1><p>La más completa guia de calles en mapas de tacna, también busca todos los establecimientos de comercio, restaurantes, tiendas de ropa, y todo lo que un visitante puediera necesitar, ¿te gustaria participar? <a href="#">registrate ya!</a></p><img src="../img/mapa.jpg" alt="Mapas de arica" />
          </div>
          </div>
          
            <div id="turismo" style="display:none">
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
            <div id="compras" style="display:none">
	            <h1>Compra en Arica</h1>
                <div class="item"><img src="../img/noticias/compras.jpg" alt="compras" /><h3>MORRO DE ARICA</h3><div class="tag">Artesanias</div><p>Morro de Arica de yeso, para regalos y recuerdo personales.</p><div class="precio">$ 6 000</div></div>
                <div class="item"><img src="../img/noticias/compras.jpg" alt="compras" /><h3>PIEDRA MICULLA</h3><div class="tag">Ceramicas</div><p>Variadas replicas de antiguos petroglifos de miculla.</p><div class="precio">$ 5 000</div></div>
                <div class="item"><img src="../img/noticias/compras.jpg" alt="compras" /><h3>PINTURA ARIQUEÑA</h3><div class="tag">Pintura</div><p>Oleo realizado por artistas tacneños.</p><div class="precio">$ 40 000</div></div>                                
            </div>       
                
            <div id="publicidad" style="display:none"><img src="../img/banner2.jpg" alt="muebles" /><img src="../img/adsense.jpg" alt="adsense" /></div>
            <div id="cole" style="display:none"><h1>El blog de tu cole</h1><img src="../img/cole.jpg" alt="El blog de tu cole" /><p>Tener un blog escolar no es algo muy complicado, más... <a href="#">ver más</a></p></div>
			
            <div class="banner" style="display:none"><img src="../img/banner3.jpg" alt="DirecTV" /></div>
            
			
           
         </div>
        </div>
        
      	<div class="lateral">
        <? include('../include/lateral.php')?>
           </div>
    </div>
    
              <? include('../include/pie_pagina.php')?>
</div>
</body>
</html>
