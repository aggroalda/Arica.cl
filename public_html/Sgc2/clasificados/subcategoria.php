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
	$id_sub=$_GET['id_sub'];
	$buscar= $_POST['codigo_Txt'];
$query_rsProductos = "SELECT * FROM productos, subcategoria, categoria WHERE  productos.IdSubcategoria_Pro = '$id_sub' AND productos.Nombre_Pro like '%$buscar%' AND subcategoria.Id_Subcategoria= '$id_sub' AND subcategoria.IdCategoria_Sub = '$id_cat' AND categoria.Id_Categoria= '$id_cat' ORDER BY  categoria.Nombre_Cat ASC ";
	
	}
	
	else {
	$id_cat= $_GET['id_cat'];
	$id_sub=$_GET['id_sub'];
$query_rsProductos = "SELECT * FROM productos, subcategoria, categoria WHERE productos.IdSubcategoria_Pro ='$id_sub' AND  subcategoria.Id_Subcategoria='$id_sub' AND subcategoria.IdCategoria_Sub = categoria.Id_Categoria  ORDER BY  categoria.Nombre_Cat ASC ";


	}
	

?>

<?

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$maxRows_rsSubCategoria = 30;
$pageNum_rsSubCategoria = 0;
if (isset($_GET['pageNum_rsSubCategoria'])) {
  $pageNum_rsSubCategoria = $_GET['pageNum_rsSubCategoria'];
}
$startRow_rsSubCategoria = $pageNum_rsSubCategoria * $maxRows_rsSubCategoria;

$colname_rsSubCategoria = "-1";
if (isset($_GET['id_sub'])) {
  $colname_rsSubCategoria = $_GET['id_sub'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsSubCategoria = sprintf("SELECT * FROM subcategoria WHERE Id_Subcategoria = %s ", GetSQLValueString($colname_rsSubCategoria, "int"));
$query_limit_rsSubCategoria = sprintf("%s LIMIT %d, %d", $query_rsSubCategoria, $startRow_rsSubCategoria, $maxRows_rsSubCategoria);
$rsSubCategoria = mysql_query($query_limit_rsSubCategoria, $cnx_arica) or die(mysql_error());
$row_rsSubCategoria = mysql_fetch_assoc($rsSubCategoria);

if (isset($_GET['totalRows_rsSubCategoria'])) {
  $totalRows_rsSubCategoria = $_GET['totalRows_rsSubCategoria'];
} else {
  $all_rsSubCategoria = mysql_query($query_rsSubCategoria);
  $totalRows_rsSubCategoria = mysql_num_rows($all_rsSubCategoria);
}
$totalPages_rsSubCategoria = ceil($totalRows_rsSubCategoria/$maxRows_rsSubCategoria)-1;

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


$queryString_rsSubCategoria = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsSubCategoria") == false && 
        stristr($param, "totalRows_rsSubCategoria") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsSubCategoria = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsSubCategoria = sprintf("&totalRows_rsSubCategoria=%d%s", $totalRows_rsSubCategoria, $queryString_rsSubCategoria);
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
      <p class="titles">&raquo; M&oacute;dulo de Categorias - Listado de Productos de la SubCategor&iacute;a: <?php echo $row_rsSubCategoria['Nombre_Sub']; ?></p>
    <?  $id_sub= $_GET['id_sub'];?>
   <?   $id_cat= $_GET['id_cat']?>
     <? if ($totalRows_rsProductos>0) { ?>
         <form action="subcategoria.php?id_cat=<? echo  $id_cat ?>&id_sub=<? echo $id_sub ?>" method="POST" id="form1">
                  <table width="570" cellpadding="3">
                    <tbody>
                      <tr>
                        <td width="35%" class="fuente" height="28" align="right">Buscar en esta Subcategor�a</td>
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
            <td width="14%" bgcolor="#003366" class="blanco12">Sub Categor&iacute;a</td>
            <td width="13%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Estado</strong></td>
             <td width="13%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Portada</strong></td>
            <td width="12%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Editar</strong></td>
             <td width="12%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Eliminar</strong></td>
            </tr>
          <tbody class="tabla">
             
            <?php do { ?>
            
            <tr class="odd">
              <td class="fuente">-&nbsp; <a href="../../0_SOURCE/SGC_INTERNET/productos/ver.php?id_pro=<?php echo $row_rsProductos['Id_Productos']; ?>&id_cat=<? echo $row_rsProductos['Id_Categoria'];?> &id_sub=<?php echo $row_rsProductos['Id_Subcategoria']; ?>" class="fuente">
            <strong><?  echo $row_rsProductos['Nombre_Pro']; ?></strong></a></td>
             <td class="fuente"> 
			  
              <a href="categorias.php?id_cat=<?php echo $row_rsProductos['Id_Categoria']; ?>&id_sub= <?php echo $row_rsProductos['IdSubcategoria_Pro']; ?>&id_pro=<?php echo $row_rsProductos['Id_Productos']; ?> " class="fuente"><?php echo $row_rsProductos['Nombre_Cat']; ?>
                
          </a>
              
     
			    </td>
              <td class="fuente"> <?php echo $row_rsProductos['Nombre_Sub']; ?></td>
              <td align="center"><select name="estado<?php echo $row_rsProductos['Id_Productos'];?>" class="fuente" id="estado<?php echo $row_rsProductos['Id_Productos']; ?>" onChange="cargar('../productos/estado.php?id_pro=<?php echo $row_rsProductos['Id_Productos']; ?>&estado='+this.value,'estado<?php echo $row_rsProductos['Id_Productos']; ?>')">
                  <option value="1" <?php if (!(strcmp(1, $row_rsProductos['Estado_Pro']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
                  <option value="0" <?php if (!(strcmp(0, $row_rsProductos['Estado_Pro']))) {echo "selected=\"selected\"";} ?>>Deshabilitado</option>
                </select></td>
              
                <td align="center">
                
                <?  $portada= $row_rsProductos['Portada_Pro'] ;
				if ($portada==1)  { ?>
                
                  <input type="checkbox" name="portada" id="portada" checked="true"  onChange="MM_goToURL('parent','portada.php?id_pro=<?php echo $row_rsProductos['Id_Productos']; ?>&amp;portada=<?php echo $row_rsProductos['Portada_Pro']; ?>&amp;id_cat=<?php echo $row_rsSubCategoria['IdCategoria_Sub']; ?>&amp;id_sub=<?php echo $row_rsProductos['IdSubcategoria_Pro']; ?>');return document.MM_returnValue">
                  
               <? } else  {?>
               
                <input type="checkbox" name="portada" id="portada" onChange="MM_goToURL('parent','portada.php?id_pro=<?php echo $row_rsProductos['Id_Productos']; ?>&amp;portada=<?php echo $row_rsProductos['Portada_Pro']; ?>&amp;id_cat=<?php echo $row_rsSubCategoria['IdCategoria_Sub']; ?>&amp;id_sub=<?php echo $row_rsProductos['IdSubcategoria_Pro']; ?>');return document.MM_returnValue" >
                  
               <? }  ?>
             
               
               </td>
              
              
              
              
              
              
              
              
              
              
              
              
              
              
              <td align="center"><a href="../../0_SOURCE/SGC_INTERNET/productos/editar.php?id_pro=<?php echo $row_rsProductos['Id_Productos']; ?>&id_sub=<?= $_GET['id_sub']?>&id_cat=<?= $_GET['id_cat']?>"><img src="../img/icon_edit.png" width="20" height="20" border="0"></a></td>
                <td align="center"><a href="javascript:preguntarproducto('<?php echo $row_rsProductos['Id_Productos']; ?>','<?php echo $row_rsProductos['Nombre_Pro']; ?>')"><img src="../img/icon_del.png" width="19" height="20" border="0"></a></td>
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
					
					 if ($_POST['codigo_Txt']) { ?> <td colspan="4" class="fuente"> No se encontraron productos  </td><? } else {?>
					
				    <td colspan="4" class="fuente"> No hay productos en  <?php echo $row_rsSubCategoria['Nombre_Sub']; ?></td> <? }} ?>
                </tr>
              <tr>
                <td align="center"><?php if ($pageNum_rsSubCategoria > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsSubCategoria=%d%s", $currentPage, 0, $queryString_rsSubCategoria); ?>"><img src="../img/First.gif" border="0"></a>
                  <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_rsSubCategoria > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsSubCategoria=%d%s", $currentPage, max(0, $pageNum_rsSubCategoria - 1), $queryString_rsSubCategoria); ?>"><img src="../img/Previous.gif" border="0"></a>
                  <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_rsSubCategoria < $totalPages_rsSubCategoria) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsSubCategoria=%d%s", $currentPage, min($totalPages_rsSubCategoria, $pageNum_rsSubCategoria + 1), $queryString_rsSubCategoria); ?>"><img src="../img/Next.gif" border="0"></a>
                  <?php } // Show if not last page ?></td>
                <td align="center"><?php if ($pageNum_rsSubCategoria < $totalPages_rsSubCategoria) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsSubCategoria=%d%s", $currentPage, $totalPages_rsSubCategoria, $queryString_rsSubCategoria); ?>"><img src="../img/Last.gif" border="0"></a>
                  <?php } // Show if not last page ?></td>
              </tr>
          </table>
            <p><a href="../../0_SOURCE/SGC_INTERNET/productos/agregar.php?id_cat=<? echo $id_cat?>&id_sub=<? echo $id_sub?>" class="fuente linksRojo"><strong>[+] Agregar Nuevo Producto</strong></a></p>
            
              <?  if ($_POST['codigo_Txt']) { ?>
            
              
            <p><a href="subcategoria.php?id_cat=<?php echo $id_cat ?>&id_sub=<?php echo $id_sub ?> " class="fuente linksRojo"><strong>&laquo; Volver a Listado de Productos de la Subcategoria <?php echo $row_rsSubCategoria['Nombre_Sub']; ?> </strong></a></p>
            <? }?> 
            
            <p><a href="categorias.php?id_cat=<?php echo $row_rsSubCategoria['IdCategoria_Sub']; ?>" class="fuente linksRojo"><strong>&laquo; Volver a la Lista de SubCategor&iacute;as</strong></a></p>
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

mysql_free_result($rsSubCategoria);

mysql_free_result($rsProductos);


?>