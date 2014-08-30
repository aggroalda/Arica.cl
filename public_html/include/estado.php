			<div class="fecha" style="float:left">
            <?
			$fecha= date('d-m-Y');
			$meses = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');
			list($dia, $mes, $year) = split('[/.-]', $fecha); 
			$cero = substr($mes,0,1);
			if ($cero==0) { $mesreal = substr($mes,-1,1); } else { $mesreal = $mes; }
			   echo $dia." de ".$meses[$mesreal]." de ".$year;
			?>
            |
           <?
		@ini_set('session.save_handler', 'files');
		@ini_set('session.save_path', '/usr/home/sessions/');
		@ini_set('session.auto_start', 1);
		echo ((int)count(explode("\n",shell_exec('ls /usr/home/sessions')))) . ' Usuario online';
		   ?>
           | <?  
		 include('contador.php');
			echo $num_visitas;
		   ?> Visitas en Total desde Septiembre 2012
         <!--  <div style="color:#000;float:right"> Cambio Dolar: Venta

<IFRAME SRC="http://www.preciodolar.com/preciodolar_cl.php?get=7" TITLE="Dolar" WIDTH=50 ALIGN=top FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=no NAME=COP-USD1 ALLOWTRANSPARENCY="true"></IFRAME>
 Compra 
<IFRAME SRC="http://www.preciodolar.com/preciodolar_cl.php?get=6" TITLE="Dolar"  WIDTH=50  ALIGN=top FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=no NAME=COP-USD1 ALLOWTRANSPARENCY="true"></IFRAME>
</div>-->

<!--venta
<div id="preciodolar-cl7">

<p><a href="http://www.preciodolar.com/dolar-hoy">Dolar hoy</a></div>
<script type="text/javascript" src="http://www.preciodolar.com/js/get_preciodolar_cl7.js"></script>-->
<!-- Precio Dolar com -->
<!-- Precio Dolar com -->
<!-- Precio Dolar com -->
			<!--|  21ºC  |  10 Usuarios Online  |  200 Visitantes Online  |   Cambio Dolar: Venta S/. 2.91 , Compra S/. 2.95 -->
      <!--  <div id="c_b75c8938c9088b4e43cc2d48d8f9e17a" class="ancho"></div><script type="text/javascript" src="../js/b75c8938c9088b4e43cc2d48d8f9e17a"></script>-->
<!--  <div id="c_b75c8938c9088b4e43cc2d48d8f9e17a" class="ancho"></div><script type="text/javascript" src="../js/b75c8938c9088b4e43cc2d48d8f9e17a"></script>-->
      
         </div>
                <form id="searchForm" method="post" onsubmit="ocultar('accion_ocultar'); document.getElementById('page').style.margin='50px auto 0'; mostrar_titulo('titulo_buscar');mostrar_titulo_div('titulo_buscar_div'); mostrar_video_div('aparece_lateral');">
		  <div id="searchInContainer">
          
            <input type="radio" name="check" value="site" id="searchSite" checked  />
            <label for="searchSite" id="siteNameLabel"></label>
             <input type="radio" name="check" value="web" id="searchWeb" />
           	<label for="searchWeb">Google</label>
          </div>  
            
       <input id="s" type="text" class="input_busqueda"/>
    	   
          
        <div id="buscador_por_tipo">
         <ul class="icons">
                <li class="web" title="Buscar Información" data-searchType="web">Web</li>
                <li class="images" title="Buscar Imágenes" data-searchType="images">Imágenes</li>
                <li class="news" title="Buscar Noticias" data-searchType="news">Noticias</li>
                <li class="videos" title="Buscar videos" data-searchType="video">Videos</li>
         </ul>
         </div> 
            
          
    </form>
  
      <script src="../js/script.js"></script>      
            
           
            
     