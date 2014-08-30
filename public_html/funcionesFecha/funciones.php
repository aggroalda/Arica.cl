<? if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
  	case "text":
    	$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
    break;    
    
	case "long":
    
	case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    
	case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
    break;
    
	case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
    break;
    
	case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
    break;
  }
  return $theValue;
}
}

function compararFechas($primera, $segunda){
	
  $valoresPrimera = explode ("-", $primera);   
  $valoresSegunda = explode ("-", $segunda); 

  $diaPrimera    = $valoresPrimera[0];  
  $mesPrimera  = $valoresPrimera[1];  
  $anyoPrimera   = $valoresPrimera[2]; 

  $diaSegunda   = $valoresSegunda[0];  
  $mesSegunda = $valoresSegunda[1];  
  $anyoSegunda  = $valoresSegunda[2];

  $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);  
  $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);     

  if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
    // "La fecha ".$primera." no es v&aacute;lida";
    return 0;
  }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    // "La fecha ".$segunda." no es v&aacute;lida";
    return 0;
  }else{
    return  $diasPrimeraJuliano - $diasSegundaJuliano;
  } 

}

function formatoFecha($fecha){
list($year1, $mes1,$dia1 ) = split('[/.-]', $fecha);
$fechapago = "$dia1-$mes1-$year1";
return $fechapago;
}

function resumen($frase_entrada,$cortar){ 
if (strlen($frase_entrada) > $cortar){ 
   $frase_corta=substr($frase_entrada,0,$cortar); // obtener la frase cortada. 
   $palabras=str_word_count($frase_corta,1); // obtener array con las palabras. 
   $total_palabras=count($palabras)-1; // contar total array elementos y restar 1 elementos 
   $palabras=array_splice($palabras,0,5); // le quitamos la ultima palabra. 
   $frase_salida=implode(' ',$palabras); //  y concatenamos con el espacio hacia una cadena. 
  
   $frase_salida .= " "; // se añaden los puntos suspensivos a la cadena obtenida.. 
   }else{
   $frase_salida=$frase_entrada;
   }
  return $frase_salida; 
}  

function resumen2($frase_entrada,$cortar){ 
if (strlen($frase_entrada) >5){ 
   $frase_corta=substr(($frase_entrada),0,$cortar); // obtener la frase cortada. 
   $palabras=str_word_count($frase_corta,1); // obtener array con las palabras. 
   $total_palabras=count($palabras)-1; // contar total array elementos y restar 1 elementos 
   $palabras=array_splice($palabras,5,$total_palabras); // le quitamos la ultima palabra. 
   $frase_salida=implode(' ',$palabras); //  y concatenamos con el espacio hacia una cadena. 
  
   $frase_salida .= "..."; // se añaden los puntos suspensivos a la cadena obtenida.. 
   }else{
   $frase_salida=$frase_entrada;
   }
  return $frase_salida; 
} 


function pasarMayusculas($cadena) {
$cadena = strtoupper($cadena);
$cadena = str_replace("á", "Á", $cadena);
$cadena = str_replace("é", "É", $cadena);
$cadena = str_replace("í", "Í", $cadena);
$cadena = str_replace("ó", "Ó", $cadena);
$cadena = str_replace("ú", "Ú", $cadena);
return ($cadena);
}  


function InvertStr($String){
    for($i=strlen($String);$i>0;$i--)
        $NewString .= substr($String,$i-1,1);
    return $NewString;
}
function script(){
echo"<script src=\"../CalendarControl/CalendarControl.js\" language=\"javascript\"> </script>";
echo"<link rel=\"stylesheet\" type=\"text/css\" href=\"../CalendarControl/CalendarControl.css\"/>";
}


?>