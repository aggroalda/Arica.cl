<?php

/*$im = imagecreatefromgif("imagen_codigo.gif");
$orange = imagecolorallocate($im, 220, 210, 60);
$px = (imagesx($im)-7.5*strlen($texto_boton))/2;
imagestring($im,3,$px,9,$texto_boton,$orange);
imagegif($im); 
imagedestroy($im);*/
header("Content-type: image/gif");

$codigo = $_GET['code'];

$imagen = imagecreatefromgif("imagen_codigo.gif");
$fondo=imagecolorallocate($imagen,255,255,255);
$color=imagecolorallocate($imagen,0,0,0); 

$font = 5;
imagestring($imagen, $font, 13, 1, $codigo, $color);
imagegif($imagen);
imagedestroy($imagen);
?>