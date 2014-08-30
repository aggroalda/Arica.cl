<? include("../Connections/cnx_arica.php")?>
<?
$ip = $_SERVER['REMOTE_ADDR'];


mysql_select_db($database_cnx_arica, $cnx_arica);
$sql = "select ip, TIMEDIFF(NOW(), fecha), fecha, num_visitas from contador where ip='$ip'";
$rsContador = mysql_query($sql, $cnx_arica) or die(mysql_error());
/*$row_rsContador = mysql_fetch_assoc($rsContador);
$totalRows_rsContador = mysql_num_rows($rsContador);*/

$fila=mysql_fetch_array($rsContador);

$tiempo=$fila[1]; //Diferencia entre fecha guardada y fecha actual

$num_visitas=$fila[3]; //Número de visitas

$horas_t=substr($tiempo,0,2); //Número de horas transcurridas

$tiemRes = 5; //Varible de tiempo en horas para restringir la visita

/*Contamos el número de registros obtenidos en la consulta anterior, si el numero

* obtenido es igual a cero es porque dicho visitante es nuevo en el sito

* entonces agregamos su ip a la base de datos junto con un 1 y la fecha actual */

if (mysql_num_rows($rsContador)==0){

$sql="insert into contador(ip, num_visitas, fecha) values('$ip', 1, NOW())";

mysql_query($sql, $cnx_arica) or die(mysql_error());
}

/* Si el número de registros obtenidos es mayor a cero es porque dicho visitante ha vuelto a ingresar al

* sitio, y si su tiempo transcurrido es mayor a 5 horas desde la primera vez que ingreso

* entonces actualizamos su número de votos agregando sumando 1 al valor actual,

* tambien actualizamos la fecha de su ultimo ingreso a la fecha actual

* */

//Si la ip existe y han transcurrido 5hrs

elseif (mysql_num_rows($rsContador) > 0 && $horas_t > $tiemRes)

{

$sql="update contador set fecha=NOW(), num_visitas='$num_visitas'+1 where ip='$ip'";

mysql_query($sql, $cnx_arica) or die(mysql_error());
}

$sql="select SUM(num_visitas) from contador"; //Obtenemos la suma de todas las visitas

$rs=mysql_query($sql, $cnx_arica) or die(mysql_error());
$fila=mysql_fetch_array($rs); //Almacenanos el resultado de la consulta en un arreglo

$num_visitas=$fila[0]; //Número de visitas

/*mysql_close($link);*/

?>


<?php
/*function contador()
{

 $fichero = "../include/visitas.txt";
 
 $fptr = fopen($fichero,"r");
 

 $num = fread($fptr,filesize($fichero));
 $num++;
 
 $fptr = fopen($fichero,"w+");
 fwrite($fptr,$num);
 
 return $num;
}*/
?>