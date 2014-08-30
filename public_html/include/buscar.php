<? 
$buscar=$_GET['buscar'];

// header("http://www.google.com/search?hl=en&q=casa");

?>

<?php
$file = file_get_contents('http://www.google.com/search?q='.$buscar,false);
echo $file;
?>


