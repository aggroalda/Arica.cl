<?php require_once('../Connections/cnx_arica.php'); ?>
<?php require_once('../include/funciones.php');

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

 ?>



<?php  //   session_start();
if (!isset($_SESSION)) {
 // session_start();
}

if($_SESSION['MM_IdPersona']!=NULL){$id_per=$_SESSION['MM_IdPersona'];}
if($_SESSION['MM_IdNivel']){;$nivel=$_SESSION['MM_IdNivel'];}
?>
<? mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsNoticias = "SELECT *  FROM noticias where Estado_Not= 1 ORDER BY Id_Noticia DESC";
$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
$totalRows_rsNoticias = mysql_num_rows($rsNoticias);
?>
<!DOCTYPE html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>arica.cl | El verdadero portal de Arica</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/estilo.css" rel="stylesheet" type="text/css" />
<link href="../css/slider.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.min.js"> </script>
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/slider.js"></script>
<link href="../css/desliza.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/desliza.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$('#mega-menu-1').dcMegaMenu({
		rowItems: '3',
		speed: 'fast',
		effect: 'fade'
	});

$(".ui-tabs-nav").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);
});


</script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../js/validar.js"></script>
<script type="text/javascript" src="../js/mootools-yui-compressed.js"></script>
<script type="text/javascript" src="../js/sexylightbox.v2.3.mootools.min.js"></script>
<link rel="stylesheet" href="../css/sexylightbox.css" type="text/css" media="all" />
<script src="../js/CalendarControl.js" type="text/javascript"> </script>
<link rel="stylesheet" type="text/css" href="../css/CalendarControl.css"/>
<link rel="stylesheet" type="text/css" href="../css/normalize.css">
<!--<script>
  (function() {
    var cx = '012666961532172197167:ra4xdflq9eu';
    var gcse = document.createElement('script'); gcse.type = 'text/javascript'; gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.es/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s);
  })();
</script>-->

<link rel="stylesheet" href="../css/sexylightbox.css" type="text/css" media="all" />
<script type="text/javascript">
    window.addEvent('domready', function(){
      SexyLightbox = new SexyLightBox({color:'black', dir: '../img/'});
    });
</script>







<!-- <script type="text/javascript" src="http://www.google.com.ni/jsapi"></script>-->
<!--<script type="text/javascript">
google.load('search', '1', {language : 'es'});
function searchLoaded() {
var options = {};
options[google.search.Search.RESTRICT_SAFESEARCH] = google.search.Search.SAFESEARCH_STRICT;
options['adoptions'] = {'cseGoogleHosting': 'full'};
var customSearchControl = new google.search.CustomSearchControl(
"partner-pub-0449606115453329:2sqtncu4xiz"
, options);
customSearchControl.setRefinementStyle("link");
customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
customSearchControl.setMoreAds();
var options = new google.search.DrawOptions();
options.setSearchFormRoot('cse-search-form');
customSearchControl.draw('cse', options);
if (customSearchControl.startHistoryManagement(init)) {
customSearchControl.setLinkTarget(
google.search.Search.LINK_TARGET_SELF);
}
}
function init(customSearchControl) {
var num = customSearchControl.getWebSearcher().getNumResultsPerPage();
customSearchControl.execute("");
}
google.setOnLoadCallback(searchLoaded, true);
</script>-->

<link rel="stylesheet" href="//www.google.com/cse/style/look/default.css" type="text/css" />

</head>

<?php
if (isset($idsubcategoria)) {
 
?>
<body onload="cargar('../clasificados/cargar_subcategorias.php?idsubcategoria=<? echo $_GET['idsubcategoria'];?>','lado_ofrecidos')">
<? }
else{
 echo"<body>";

}

?>

<div id="contenedor">
  <div id="cabeza">
  <div id="estado">
  <?  include('../include/estado.php');?>
        </div>
    <div id="top">
    	<div class="banner">  <h1><a href="../index/"><span>arica.cl, el verdadero portal de Arica</span></a></h1></div>
       
        <? include('../include/form_login.php');?>
  
      </div>
       <? include('../include/menu.php');?>
   </div>
<div id="colores" style="margin-left:20px"><div class="a"></div><div class="b"></div><div class="c"></div><div class="d"></div><div class="e"></div><div class="f"></div><div class="g"></div><div class="h"></div></div>

	

