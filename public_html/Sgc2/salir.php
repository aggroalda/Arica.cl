<?php require_once('../Connections/cnx_arica.php'); ?>
<?php

session_start();
$nivel= $_SESSION['MM_IdNivel'];
$usuario=$_SESSION['MM_IdUser'];


if (!function_exists("GetSQLValueString")) {
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

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc, soporte_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);
?>
<!DOCTYPE html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS Versión 5.0</title>
<link href="css/sgc.css" rel="stylesheet" type="text/css">
<meta http-equiv="refresh" content="3;URL=<? if ($_GET['nivel']=='3'){?>../index/index.php<? }else{?>index.php<? }?>">
</head>

<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="258" align="center" valign="middle"><blockquote>
          <p><span class="titles">Usted finaliz&oacute; correctamente su sesi&oacute;n en el sistema.</span></p>
          <p class="fuente">Vuelva pronto</p>
          <p>&nbsp;</p>
        </blockquote></td>
      </tr>
    </table></td>
  </tr>
  <? include("option/footer.php"); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsOptions);
?>