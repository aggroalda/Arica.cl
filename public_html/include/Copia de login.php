<?php  
$texto = "Texto que tiene que medir mas de 50 caracteres. dfsfdsfd
sfdsf sfds sdfs sfdfdsfsdf dfsdsf sd ds fsd  sdfssf sd f";  
$car = "50";  

function justificarTexto($texto, $car) {  
      if(strlen($texto) > $car) {  // comprobamos que el texto tiene mas de 50 caracteres  
        $texto = wordwrap($texto,$car,"<br />",1);  } // inserta el salto a los 50 caracteres  
      else $texto=$texto; // si no es mas largo de 50 caracteres, se deja igual  
  return $texto;        
}  

echo justificarTexto($texto, $car);

?>