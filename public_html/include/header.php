<?php  if (!isset($_SESSION)) {
 session_start();
}

if(isset($_SESSION['MM_IdPersona'])){
	$id_per=$_SESSION['MM_IdPersona'];}
if(isset($_SESSION['MM_IdNivel'])){
	$nivel=$_SESSION['MM_IdNivel'];}
	if($_SESSION['MM_IdUser']){
	$id_usu=$_SESSION['MM_IdUser'];}

?>
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


<? mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsNoticias = "SELECT *  FROM noticias where Estado_Not= 1 ORDER BY Id_Noticia DESC";
$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
$totalRows_rsNoticias = mysql_num_rows($rsNoticias);
?>

<!DOCTYPE html><head>
<? 
if (isset($_GET['id_not'])) {
  $colname_rsProducto = $_GET['id_not'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsProducto = sprintf("SELECT * FROM noticias,categoria,usuarios,personas WHERE noticias.IdCategoria_Not= categoria.Id_Categoria AND noticias.IdUsuario_Not=usuarios.Id_Usuario AND usuarios.IdPersona_Usu= personas.Id_Persona AND noticias.Id_Noticia='%s' ", GetSQLValueString($colname_rsProducto, "int"));
$rsProducto = mysql_query($query_rsProducto, $cnx_arica) or die(mysql_error());
$row_rsProducto = mysql_fetch_assoc($rsProducto);
$totalRows_rsProducto = mysql_num_rows($rsProducto);

?>

<?php 
date_default_timezone_set("America/Santiago");
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? if(isset($_GET['id_not'])){echo utf8_encode($row_rsProducto['Titulo_Not']);} else {?> arica.cl | El verdadero portal de Arica<? } ?></title>
<meta name="description" content="<? echo utf8_encode(substr($row_rsProducto['Desarrollo_Not'],0,300));?>">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" type="text/css" href="../css/buscadorestilo.css">
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/estilo.css" rel="stylesheet" type="text/css" />
<link href="../css/slider.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../MenuAzul/menu.css">
<script type="text/javascript" src="../MenuAzul/jquery.js"> </script>
 <script type="text/javascript" src="../MenuAzul/menu.js"></script>
<script type="text/javascript" src="../js/jquery-1.8.2.js"> </script>

<script type="text/javascript" src="../js/jquery-ui-1.9.0.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-tabs-rotate.js"></script>
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
		
	 $("#featured").tabs({ fx: { opacity: 'toggle' } }).tabs('rotate', 5000);
    $('#featured').hover(function(){
            $(this).tabs('rotate', 0, false);
        },function(){
            $(this).tabs({ fx: { opacity: 'toggle' } }).tabs('rotate', 5000);
        }
    );
	
window.onload = function() {
    var frames = document.getElementsByTagName("iframe");
    for (var i = 0; i < frames.length; i++) {
        frames[i].src += "?wmode=transparent";
    }
}

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
<link href="../css/dcmegamenu.css" rel="stylesheet" type="text/css" />

<script type='text/javascript' src='../js/jquery.hoverIntent.minified.js'></script>
<script type='text/javascript' src='../js/jquery.dcmegamenu.1.2.js'></script>
<script type="text/javascript">
    window.addEvent('domready', function(){
      SexyLightbox = new SexyLightBox({color:'black', dir: '../img/'});
    });
</script>

<script type="text/javascript"> 
          function ocultar(campo) {
	document.getElementById(campo).style.display="none";
}

function mostrar_titulo(campo) {
	document.getElementById(campo).style.display="table-row-group";
	document.getElementById(campo).style.margin="0px 0px 20px 8px";
}	

function mostrar_titulo_div(campo) {
	document.getElementById(campo).style.display="block";
	document.getElementById(campo).style.margin="0px 0px 20px 8px";
}	

function mostrar_video_div(campo) {
	document.getElementById(campo).style.display="block";
}	
          </script>


<link rel="stylesheet" href="//www.google.com/cse/style/look/default.css" type="text/css" />

</head>


<body <? if (isset($_GET['idsubcategoria'])){ ?> onload="cargar('../clasificados/cargar_subcategorias.php?idsubcategoria=<? echo $_GET['idsubcategoria'];?>','lado_ofrecidos')" <? }?>>

<div id="contenedor">
  <div id="cabeza">
  <div id="estado">
  <?  include('../include/estado.php');?>
        </div>
    <div id="top">
    	<div class="banner">  <h1><a href="../index/"><span>
        
        arica.cl, el verdadero portal de Arica</span></a></h1></div>
       
     <? ?>
<? 

if (isset($_SESSION['MM_IdUser'])){

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsUsuarios = "SELECT *  FROM usuarios,personas where Estado_Usu=1 AND usuarios.Id_Usuario=$id_usu AND usuarios.IdPersona_Usu=personas.Id_Persona";
$rsUsuarios = mysql_query($query_rsUsuarios, $cnx_arica) or die(mysql_error());
$row_rsUsuarios = mysql_fetch_assoc($rsUsuarios);
$totalRows_rsUsuarios = mysql_num_rows($rsUsuarios);
	?> <div id="login" class="login">
    <br>
    <h3 id="Bienvenido_a_arica">Bienvenido a arica.cl</h3><br>
     <text id="Bienvenido_nombre_usuario">Sr(a). <? echo utf8_encode($row_rsUsuarios['Nombres_Per']);?> <? echo utf8_encode($row_rsUsuarios['Paterno_Per']);?> <? echo utf8_encode($row_rsUsuarios['Materno_Per']);?></text>
     <br>
     
<a href="../include/logout.php">
<div class="botonside margin_subir">
<input type="submit" class="boton" value="Cerrar Sesión"/>
</div>
</a>
<a href="#">
<div class="botonside margin_subir">
<input type="submit" class="boton" value="Ir al Gestor" onClick="window.open('../Sgc/login.php', '_blank');"/>
</div>
</a></div>
   <? }
 
elseif (!isset($_SESSION['MM_IdUser'])) {?>
   <div id="login" class="login">
   
   <form id="recordarform" action="../include/login.php" method="post">
        	<div class="datos">
              <div class="titulo">Usuario</div>
                <input name="usuario_Txt" id="usuario_Txt" type="text" class="caja" />            
              <div class="titulo">Contraseña</div>
                <input type="password" id="password_Txt" name="password_Txt" class="caja" />
            </div>
            <div class="botonside"><input type="submit" class="boton" value="Iniciar Sesión"/></div>
            <div class="botonside"><input type="submit" class="boton" value="Ir al Gestor" onClick="window.open('../Sgc/index.php', '_blank');"/></div>
            
            
      <div class="enlaces"><a href="#" onclick="mostrar('forgotbox'); ocultar('login')">¿Olvidó su Contraseña?</a>
     <a href="../registro/index.php">Regístrate</a> 
    <!-- ../registro/index.php--> 
     
      </div>
		
        </form>
        </div> 
        <div id="forgotbox" class="login" style="display:none">
		<div style="color:#FFFFFF">Escriba su Correo para enviarle una nueva contraseña.</div>
		<!--  start forgot-inner -->
		<div id="forgot-inner">
        <form  action="../include/recordar.php" method="post" id="correo_form">
		<table border="0" cellpadding="0" cellspacing="0">
        <tr>
			<td align="left"><span id="msgbox1" style="display:none; margin:auto;"></span></td>
		</tr>
		<tr >
			<th class="titulo">Correo:</th>
			<td><input type="text" value=""  id="correo_Txt" name="correo_Txt"   class="login-inp" /></td>
		</tr>
		<tr>
			<th> </th>
			<td ><input style="top:15px" type="submit" class="boton" name="enviar2" value="Enviar" id="enviar2" /></td>
		</tr>
		</table>
        </form>
		</div>
		<!--  end forgot-inner -->
		<div class="clear"></div>
		<a  href="#" onClick="ocultar('forgotbox');mostrar('login')" class="back-login">Volver</a>
	</div>
        
        <? }?>
  
      </div>
       <? include('../include/menu.php');?>
   </div>