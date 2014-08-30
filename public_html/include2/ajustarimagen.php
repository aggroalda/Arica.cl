
    
    <? 
$ubicacion = $_GET['ubica'];
$file = $ubicacion.$_GET['foto'];
							
$ext = strtolower(substr($file, -3));
if ($ext=="jpg") {
header("Content-type: image/jpeg");
}
if ($ext=="gif") {
header("Content-type: image/gif");
}
// list($ancho, $altura, $tipo, $atr) = getimagesize($file);
$width = $_GET['ancho'];
	$height= $_GET['alto'];

//$width = $_GET['nw'];
if ($ext=="jpg") {
	$imSrc  = imagecreatefromjpeg($file);
	}
	
	if ($ext=="gif") {
	$imSrc  = imagecreatefromgif($file);
	}
																	
$imTrg  = imagecreatetruecolor($width, $height);
	$w      = imagesx($imSrc);
	$h      = imagesy($imSrc);


 imagecopyresampled($imTrg, $imSrc, 0, 0, 0, 0, $width, $height, $w, $h);





if ($ext=="jpg") {
imagejpeg($imTrg,$file);
}
if ($ext =="gif") {
imagegif($imTrg);
}
imagedestroy($imTrg);
?>