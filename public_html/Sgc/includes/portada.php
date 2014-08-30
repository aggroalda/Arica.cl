<script src="../../0_SOURCE/SGC_INTERNET/js/jquery.js" type="text/javascript" language="javascript"></script>
<script src="../../0_SOURCE/SGC_INTERNET/js/ajax.js" type="text/javascript"></script>

<script type="text/javascript" src="../../0_SOURCE/SGC_INTERNET/js/td_over.js"></script>
<? 


$portada= $_GET['color'];


if ($portada == 1) {
	
	
	mostrar('agregarcolor');mostrar('divContenido');mostrar('primero');
	
	
	
    
} else {
  $portada = 0;
  
  ocultar('agregarcolor');ocultar('divContenido');ocultar('primero');
  
}



?>
