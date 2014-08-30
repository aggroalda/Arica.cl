<?php  

function justificarTexto($texto, $car) {  
      if(strlen($texto) > $car) {  // comprobamos que el texto tiene mas de 50 caracteres  
        $texto = wordwrap($texto,$car,"<br />",1);  } // inserta el salto a los 50 caracteres  
      else $texto=$texto; // si no es mas largo de 50 caracteres, se deja igual  
  return $texto;        
}  

function truncate($string, $len, $hard=false) 
{        
     if(!$len || $len>strlen($string))
          return $string;
        
     $string = substr($string,0,$len);

     return $hard?$string:(substr($string,0,strrpos($string,' '))/*.'...'*/);
}

function truncate2($string, $len, $hard=false) 
{        
     if(!$len || $len>strlen($string))
          return $string;
        
     $string = substr($string,0,$len);

     return $hard?$string:(substr($string,0,strrpos($string,' ')).'...');
}


function descripcion_noticia($id_not,$palabra)
{

 
 return $num;

}

function formato_fecha($fecha)
{
	return date("d-m-Y\n",strtotime($fecha));
	
}

function formato_hora($fecha)
{
	return date("h:i a",strtotime($fecha));
	
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




?>