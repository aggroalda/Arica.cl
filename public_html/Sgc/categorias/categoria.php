<?php require_once('../../0_SOURCE/Connections/cnx_arica.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_arica'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_arica']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_arica set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php?error=2";
if (!((isset($_SESSION['MM_arica'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_arica'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
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

$currentPage = $_SERVER["PHP_SELF"];

?> 

<? 
if ($_POST['codigo_Txt']) {
	
	$id_cat= $_GET['id_cat'];
	
	$buscar= $_POST['codigo_Txt'];
$query_rsProductos = "SELECT * FROM noticias, categoria WHERE  noticias.IdCategoria_Not = '$id_cat' AND noticias.Titulo_Not like '%$buscar%' AND   categoria.Id_Categoria= '$id_cat' ORDER BY  categoria.Nombre_Cat ASC ";
	
	}
	
	else {
	$id_cat= $_GET['id_cat'];
	
$query_rsProductos = "SELECT * FROM noticias, categoria WHERE noticias.IdCategoria_Not ='$id_cat' AND categoria.Id_Categoria= '$id_cat'    ORDER BY  categoria.Nombre_Cat ASC ";


	}
	

?>

<?php
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);
?>
<?

?>
<?php
$maxRows_rsCategoria = 30;
$pageNum_rsCategoria = 0;
if (isset($_GET['pageNum_rsCategoria'])) {
  $pageNum_rsCategoria = $_GET['pageNum_rsCategoria'];
}
$startRow_rsCategoria = $pageNum_rsCategoria * $maxRows_rsCategoria;

$colname_rsCategoria = "-1";
if (isset($_GET['id_cat'])) {
  $colname_rsCategoria = $_GET['id_cat'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoria = sprintf("SELECT * FROM categoria WHERE Id_Categoria = %s ", GetSQLValueString($colname_rsCategoria, "int"));
$query_limit_rsCategoria = sprintf("%s LIMIT %d, %d", $query_rsCategoria, $startRow_rsCategoria, $maxRows_rsCategoria);
$rsCategoria = mysql_query($query_limit_rsCategoria, $cnx_arica) or die(mysql_error());
$row_rsCategoria = mysql_fetch_assoc($rsCategoria);

if (isset($_GET['totalRows_rsCategoria'])) {
  $totalRows_rsCategoria = $_GET['totalRows_rsCategoria'];
} else {
  $all_rsCategoria = mysql_query($query_rsCategoria);
  $totalRows_rsCategoria = mysql_num_rows($all_rsCategoria);
}
$totalPages_rsCategoria = ceil($totalRows_rsCategoria/$maxRows_rsCategoria)-1;
?>
<?

$maxRows_rsProductos = 30;
$pageNum_rsProductos = 0;
if (isset($_GET['pageNum_rsProductos'])) {
  $pageNum_rsProductos = $_GET['pageNum_rsProductos'];
}
$startRow_rsProductos = $pageNum_rsProductos * $maxRows_rsProductos;

$colname_rsProductos = "-1";
if (isset($_GET['id_sub'])) {
  $colname_rsProductos = $_GET['id_sub'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);

$query_limit_rsProductos = sprintf("%s LIMIT %d, %d", $query_rsProductos, $startRow_rsProductos, $maxRows_rsProductos);
$rsProductos = mysql_query($query_limit_rsProductos, $cnx_arica) or die(mysql_error());
$row_rsProductos = mysql_fetch_assoc($rsProductos);

if (isset($_GET['totalRows_rsProductos'])) {
  $totalRows_rsProductos = $_GET['totalRows_rsProductos'];
} else {
  $all_rsProductos = mysql_query($query_rsProductos);
  $totalRows_rsProductos = mysql_num_rows($all_rsProductos);
}
$totalPages_rsProductos = ceil($totalRows_rsProductos/$maxRows_rsProductos)-1;

$colname_rsCategoriaProducto = "-1";
if (isset($_GET['id_sub'])) {
  $colname_rsCategoriaProducto = $_GET['id_sub'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoriaProducto = sprintf("SELECT * FROM noticias,categoria WHERE noticias.IdCategoria_Not= %s  AND noticias.IdCategoria_Not = categoria.Id_Categoria", GetSQLValueString($colname_rsCategoriaProducto, "int"));
$rsCategoriaProducto = mysql_query($query_rsCategoriaProducto, $cnx_arica) or die(mysql_error());
$row_rsCategoriaProducto = mysql_fetch_assoc($rsCategoriaProducto);
$totalRows_rsCategoriaProducto = mysql_num_rows($rsCategoriaProducto);

$queryString_rsCategoria = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsCategoria") == false && 
        stristr($param, "totalRows_rsCategoria") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsCategoria = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsCategoria = sprintf("&totalRows_rsCategoria=%d%s", $totalRows_rsCategoria, $queryString_rsCategoria);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
</head>
<body>
 <div id= "divContenido">
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
      <p class="titles">&raquo; M&oacute;dulo de Categorias - Listado de Productos de la Categor&iacute;a: <?php echo $row_rsCategoria['Nombre_Cat']; ?></p>
    <?  $id_sub= $_GET['id_sub'];?>
   <?   $id_cat= $_GET['id_cat']?>
     <? if ($totalRows_rsProductos>0) { ?>
         <form action="categoria.php?id_cat=<? echo  $id_cat ?>" method="POST" id="form1">
                  <table width="570" cellpadding="3">
                    <tbody>
                      <tr>
                        <td width="35%" class="fuente" height="28" align="right">Buscar en esta Categor&iacute;a</td>
                        <td width="25%" class="amarillo"><input name="codigo_Txt" type="text" id="codigo_Txt" title="Buscar Producto"/></td>
                  <td><input style="border:none;" type="image" name="btnEnviar" id="btnEnviar" src="../img/icono_lupa.png"/></td>
                      </tr>
                    </tbody>
                  </table>
            </form>
      <? } ?>
    </blockquote>    
   
      
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle">
       <? if ($totalRows_rsProductos>0) { ?>
        <table width="100%" align="center" class="bordes2" >
          <tr align="center" bgcolor="#660000" class="blanco11">
            <td width="34%" bgcolor="#003366" class="blanco12">T&iacute;tulo del Producto</td>
            <td width="14%" bgcolor="#003366" class="blanco12">Categor�a</td>
            <td width="13%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Estado</strong></td>
             <td width="13%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Portada</strong></td>
            <td width="12%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Editar</strong></td>
             <td width="12%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Eliminar</strong></td>
            </tr>
          <tbody class="tabla">
             
            <?php do { ?>
            
            <tr class="odd">
              <td class="fuente">-&nbsp; <a href="../novedades/ver.php?id_not=<?php echo $row_rsProductos['Id_Noticia']; ?>&id_cat=<? echo $row_rsProductos['Id_Categoria'];?> " class="fuente">
            <strong><?  echo $row_rsProductos['Titulo_Not']; ?></strong></a></td>
             <td class="fuente"> 
			  
              <a href="categoria.php?id_cat=<?php echo $row_rsProductos['Id_Categoria']; ?>" class="fuente"><?php echo $row_rsProductos['Nombre_Cat']; ?>
                
          </a>
              
     
			    </td>
          
              <td align="center"><select name="estado<?php echo $row_rsProductos['Id_Noticia'];?>" class="fuente" id="estado<?php echo $row_rsProductos['Id_Noticia']; ?>" onChange="cargar('../productos/estado.php?id_pro=<?php echo $row_rsProductos['Id_Noticia']; ?>&estado='+this.value,'estado<?php echo $row_rsProductos['Id_Noticia']; ?>')">
                  <option value="1" <?php if (!(strcmp(1, $row_rsProductos['Estado_Not']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
                  <option value="0" <?php if (!(strcmp(0, $row_rsProductos['Estado_Not']))) {echo "selected=\"selected\"";} ?>>Deshabilitado</option>
                </select></td>
              
                  <td id="portada<?php echo $row_rsProductos['Id_Noticia'];?>" align="center">
                
                <?  $portada= $row_rsProductos['Portada_Pro'] ;
				if ($portada==1)  { ?>
                
                  <input type="checkbox" checked name="portada" id="portada" value="1" onChange="cargar('portada.php?id_pro=<?php echo $row_rsProductos['Id_Noticia']; ?>&portada=<?php echo $row_rsProductos['Portada_Pro']; ?>','portada<?php echo $row_rsProductos['Id_Productos'];?>')" >
                  
               <? } else  {?>
               
                <input type="checkbox" name="portada" id="portada" value="0" onChange="cargar('portada.php?id_pro=<?php echo $row_rsProductos['Id_Noticia']; ?>&portada=<?php echo $row_rsProductos['Portada_Pro']; ?>','portada<?php echo $row_rsProductos['Id_Noticia'];?>')">
                  
               <? }  ?>
             
               
               </td>
              
              
              <td align="center"><a href="../../0_SOURCE/SGC_INTERNET/productos/editar.php?id_pro=<?php echo $row_rsProductos['Id_Noticia']; ?>>&id_cat=<?= $_GET['id_cat']?>"><img src="../img/icon_edit.png" width="20" height="20" border="0"></a></td>
                <td align="center"><a href="javascript:preguntarproducto('<?php echo $row_rsProductos['Id_Noticia']; ?>','<?php echo $row_rsProductos['Titulo_Not']; ?>')"><img src="../img/icon_del.png" width="19" height="20" border="0"></a></td>
              </tr>
            <?php } while ($row_rsProductos = mysql_fetch_assoc($rsProductos)); ?>
             
          </tbody>
        </table>
        <? }?>
        
        
          <blockquote>
            <table border="0">
              <tr>
                <? if ($totalRows_rsProductos>=1){?>
                <td colspan="4" class="fuente">
Productos del <?php echo ($startRow_rsProductos + 1) ?> al <?php echo min($startRow_rsProductos + $maxRows_rsProductos, $totalRows_rsProductos) ?> de <?php echo $totalRows_rsProductos ?> en total</td>


                <? } else {
					
					 if ($_POST['codigo_Txt']) { ?> <td colspan="4" class="fuente"> No se encontraron noticias  </td><? } else {?>
					
				    <td colspan="4" class="fuente"> No hay noticias  en  <?php echo $row_rsCategoria['Nombre_Cat']; ?></td> <? }} ?>
                </tr>
              <tr>
                <td align="center"><?php if ($pageNum_rsCategoria > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsCategoria=%d%s", $currentPage, 0, $queryString_rsCategoria); ?>"><img src="../img/First.gif" border="0"></a>
                  <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_rsCategoria > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsCategoria=%d%s", $currentPage, max(0, $pageNum_rsCategoria - 1), $queryString_rsCategoria); ?>"><img src="../img/Previous.gif" border="0"></a>
                  <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_rsCategoria < $totalPages_rsCategoria) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsCategoria=%d%s", $currentPage, min($totalPages_rsCategoria, $pageNum_rsCategoria + 1), $queryString_rsCategoria); ?>"><img src="../img/Next.gif" border="0"></a>
                  <?php } // Show if not last page ?></td>
                <td align="center"><?php if ($pageNum_rsCategoria < $totalPages_rsCategoria) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsCategoria=%d%s", $currentPage, $totalPages_rsCategoria, $queryString_rsCategoria); ?>"><img src="../img/Last.gif" border="0"></a>
                  <?php } // Show if not last page ?></td>
              </tr>
          </table>
            <p><a href="../novedades/agregar.php?id_cat=<? echo $id_cat?>" class="fuente linksRojo"><strong>[+] Agregar Nuevo Noticia</strong></a></p>
            
              <?  if ($_POST['codigo_Txt']) { ?>
            
              
            <p><a href="categoria.php?id_cat=<?php echo $id_cat ?> " class="fuente linksRojo"><strong>&laquo; Volver a Listado de Noticias de la Categoria <?php echo $row_rsCategoria['Nombre_Cat']; ?> </strong></a></p>
            <? }?> 
            
            <p><a href="index.php" class="fuente linksRojo"><strong>&laquo; Volver a la Lista de Categor&iacute;as</strong></a></p>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table>
    </td>
  </tr>
  <? include("../option/footer.php"); ?>
</table>
 </div>
</body>
</html>
<?php
mysql_free_result($rsOptions);

mysql_free_result($rsCategoria);

mysql_free_result($rsProductos);

mysql_free_result($rsCategoriaProducto);
?>