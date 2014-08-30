<html>
<head>
  <title>Resultados de la Búsqueda en la Librería Online</title>
</head>
<body>
<h1>Resultados de la Búsqueda en la Librería Online</h1>
<?

  //Obtener los datos del form por metodo POST
  $tipobusqueda = $_POST['tipobusqueda'];
  $terminobusqueda = $_POST['terminobusqueda'];
  /////////////////////////////////////////////
  
  trim ($terminobusqueda);
  if (!$tipobusqueda || !$terminobusqueda)
  {
     echo "No has introducido los detalles de la busqueda.  Por favor vuelve e inténtalo de nuevo.";
     exit;
  }

  $tipobusqueda = addslashes($tipobusqueda);
  $terminobusqueda = addslashes($terminobusqueda);

  @ $db = mysql_pconnect("mysql5.000webhost.com", "a3188071_root", "adrian2890@");

  if (!$db)
  {
     echo "Error: No se ha podido conectar a la base de datos.  Por favor, prueba de nuevo más tarde.";
     exit;
  }

  mysql_select_db("a3188071_libros");
  $consulta = "select * from libros where ".$tipobusqueda." like '%".$terminobusqueda."%'";
  $resultado = mysql_query($consulta);

  $num_resultados = mysql_num_rows($resultado);

  echo "<p>Número de libros encontrados: ".$num_resultados."</p>";

  for ($i=0; $i <$num_resultados; $i++)
  {
     $row = mysql_fetch_array($resultado);
     echo "<p><strong>".($i+1).". Título: ";
     echo stripslashes($row["titulo"]);
     echo "</strong><br>Autor: ";
     echo stripslashes($row["autor"]);
     echo "<br>ISBN: ";
     echo stripslashes($row["isbn"]);
     echo "<br>Precio: ";
     echo stripslashes($row["precio"]);
     echo "</p>";
  }

?>

</body>
</html>