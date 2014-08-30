<?php
require('../Connections/cnx_arica.php');

$calificacion = $_GET['calificacion'];
$id_emp = $_GET['id_emp'];
$id_rub = $_GET['id_rub'];
$id_usu = $_GET['id_usu'];



mysql_select_db($database_cnx_arica, $cnx_arica); 
$query_rsRanking = "SELECT * FROM ranking WHERE Id_Empresa_Ranking=$id_emp";
$rsRanking  = mysql_query($query_rsRanking, $cnx_arica) or die(mysql_error());
$row_rsRanking  = mysql_fetch_assoc($rsRanking);
$totalRows_rsRanking  = mysql_num_rows($rsRanking);

$query_rsRubro = "SELECT *  FROM empresa, empresa_rubro WHERE empresa.Id_Empresa=$id_emp  AND empresa.Id_Rubro_Empresa=empresa_rubro.Id_Rubro";
$rsRubro  = mysql_query($query_rsRubro, $cnx_arica) or die(mysql_error());
$row_rsRubro  = mysql_fetch_assoc($rsRubro);
$totalRows_rsRubro  = mysql_num_rows($rsRubro);

$query_rsRanking_Detalle = "SELECT * FROM ranking_detalle WHERE Id_Empresa_Ranking_Detalle=$id_emp";
$rsRanking_Detalle  = mysql_query($query_rsRanking_Detalle, $cnx_arica) or die(mysql_error());
$row_rsRanking_Detalle  = mysql_fetch_assoc($rsRanking_Detalle);
$totalRows_rsRanking_Detalle  = mysql_num_rows($rsRanking_Detalle);

$puntaje_antiguo=$row_rsRanking['Puntaje_Ranking'];

$id_rubro=$row_rsRubro['Id_Rubro'];

if (($row_rsRanking['Id_Empresa_Ranking']!=$id_emp)){
$insertSQL = "INSERT INTO ranking (Id_Empresa_Ranking,Puntaje_Ranking,Id_Rubro_Ranking,Id_Usuario_Ranking) VALUES ($id_emp,$calificacion,$id_rubro,$id_usu)";

  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
}
 elseif(($row_rsRanking['Id_Empresa_Ranking']=$id_emp)and($row_rsRanking['Id_Usuario_Ranking']=$id_usu))
 {echo"nada";}
 
elseif(($row_rsRanking['Id_Empresa_Ranking']=$id_emp)and($row_rsRanking['Id_Empresa_Ranking']!=$id_usu))
{

$insertSQL = "INSERT INTO ranking (Id_Empresa_Ranking,Puntaje_Ranking,Id_Rubro_Ranking,Id_Usuario_Ranking) VALUES ($id_emp,$calificacion,$id_rubro,$id_usu)" ;
echo $insertSQL;
  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($insertSQL, $cnx_arica) or die(mysql_error());
  
  }
  elseif(($row_rsRanking['Id_Empresa_Ranking']!=$id_emp)and($row_rsRanking['Id_Usuario_Ranking']=$id_usu))
{

$updateSQL = "UPDATE ranking SET Puntaje_Ranking = $calificacion + $puntaje_antiguo  where Id_Empresa_Ranking=$id_emp";
 echo $updateSQL;
  mysql_select_db($database_cnx_arica, $cnx_arica);
  mysql_query($updateSQL, $cnx_arica) or die(mysql_error());
  
  }
