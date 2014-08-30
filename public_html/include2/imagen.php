<? 
if ($_GET['foto']) {
$file = $_GET['ubicacion'].$_GET['foto'];
}
							
$ext = strtolower(substr($file, -3));
if ($ext=="jpg") {
header("Content-type: image/jpeg");
}
if ($ext=="gif") {
header("Content-type: image/gif");
}
list($ancho, $altura, $tipo, $atr) = getimagesize($file);
$width = $_GET['nw'];

if ($width > $ancho) {
	$width = $ancho;
	}
$height = ($altura/$ancho)*$width;
								
	if ($ext=="jpg") {
	$imSrc  = imagecreatefromjpeg($file);
	}
	
	if ($ext=="gif") {
	$imSrc  = imagecreatefromgif($file);
	}
	
	$w      = imagesx($imSrc);
	$h      = imagesy($imSrc);
									
		if($width/$height>$w/$h) {
		$nh = ($h/$w)*$width;
		$nw = $width;
		} else {
		$nw = ($w/$h)*$height;
		$nh = $height;
		}
	$dx = ($width/2)-($nw/2);
	$dy = ($height/2)-($nh/2);
																
$imTrg  = imagecreatetruecolor($width, $height);
imagecopyresampled($imTrg, $imSrc, $dx, $y, 0, 0, $width, $height, $w, $h);
if ($ext=="jpg") {
imagejpeg($imTrg);
}
if ($ext =="gif") {
imagegif($imTrg);
}
imagedestroy($imTrg);
?>