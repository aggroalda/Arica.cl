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

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

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
$query_rsCategoria = sprintf("SELECT * FROM categoria WHERE Id_Categoria = %s", GetSQLValueString($colname_rsCategoria, "int"));
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

$maxRows_rsSubcategoria = 30;
$pageNum_rsSubcategoria = 0;
if (isset($_GET['pageNum_rsSubcategoria'])) {
  $pageNum_rsSubcategoria = $_GET['pageNum_rsSubcategoria'];
}
$startRow_rsSubcategoria = $pageNum_rsSubcategoria * $maxRows_rsSubcategoria;

$colname_rsSubcategoria = "-1";
if (isset($_GET['id_cat'])) {
  $colname_rsSubcategoria = $_GET['id_cat'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsSubcategoria = sprintf("SELECT * FROM subcategoria WHERE IdCategoria_Sub = %s ORDER BY Id_Subcategoria DESC", GetSQLValueString($colname_rsSubcategoria, "int"));
$query_limit_rsSubcategoria = sprintf("%s LIMIT %d, %d", $query_rsSubcategoria, $startRow_rsSubcategoria, $maxRows_rsSubcategoria);
$rsSubcategoria = mysql_query($query_limit_rsSubcategoria, $cnx_arica) or die(mysql_error());
$row_rsSubcategoria = mysql_fetch_assoc($rsSubcategoria);

if (isset($_GET['totalRows_rsSubcategoria'])) {
  $totalRows_rsSubcategoria = $_GET['totalRows_rsSubcategoria'];
} else {
  $all_rsSubcategoria = mysql_query($query_rsSubcategoria);
  $totalRows_rsSubcategoria = mysql_num_rows($all_rsSubcategoria);
}
$totalPages_rsSubcategoria = ceil($totalRows_rsSubcategoria/$maxRows_rsSubcategoria)-1;

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
</head>
<body>
<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
      <p class="titles">&raquo; M&oacute;dulo de Categor&iacute;as - Listado de SubCategor&iacute;as de Categor&iacute;a: <?php echo $row_rsCategoria['Nombre_Cat']; ?></p>
    </blockquote>      
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle">
        
        
           <? if ($totalRows_rsSubcategoria>0) { ?>
        <table width="100%" align="center" class="bordes2" >
          <tr align="center" bgcolor="#660000" class="blanco11">
            <td width="34%" bgcolor="#003366" class="blanco12">T&iacute;tulo de la Subcategor&iacute;a</td>
            <td width="14%" bgcolor="#003366" class="blanco12">Categor&iacute;a</td>
            <td width="13%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Estado</strong></td>
            <td width="12%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Editar</strong></td>
            <td width="12%" bgcolor="#003366" class="blanco12">Eliminar</td>
            </tr>
          <tbody class="tabla">
        
            <?php do { ?>
            
            
            
            <tr class="odd">
              <td class="fuente">-&nbsp; <a href="subcategoria.php?id_cat=<? echo $row_rsCategoria['Id_Categoria'];?>&id_sub=<?php echo $row_rsSubcategoria['Id_Subcategoria'];?>" class="fuente"><strong><?php  echo $row_rsSubcategoria['Nombre_Sub'];?></strong></a></td>
              <td class="fuente">
			  <a href="categorias.php?id_cat= <? echo $row_rsCategoria['Id_Categoria'];?>" class="fuente">
			  
			  <?php echo $row_rsCategoria['Nombre_Cat']; ?></a></td>
              <td align="center"><select name="estado" class="fuente" id="estado" onChange="MM_goToURL('parent','../../0_SOURCE/SGC_INTERNET/categorias/estado_sub.php?id_sub=<?php echo $row_rsSubcategoria['Id_Subcategoria']; ?>&amp;estado=<?php echo $row_rsSubcategoria['Estado_Sub']; ?>&amp;id_cat=<? echo $row_rsCategoria['Id_Categoria'] ; ?>');return document.MM_returnValue">
                <option value="1" <?php if (!(strcmp(1, $row_rsSubcategoria['Estado_Sub']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
                <option value="0" <?php if (!(strcmp(0, $row_rsSubcategoria['Estado_Sub']))) {echo "selected=\"selected\"";} ?>>Deshabilitado</option>
              </select></td>
              <td align="center"><a href="subeditar.php?id_cat=<? echo $row_rsCategoria['Id_Categoria']?>&id_sub=<?php echo $row_rsSubcategoria['Id_Subcategoria']; ?>"><img src="../img/icon_edit.png" width="20" height="20" border="0"></a></td>
              <td align="center"><a href="javascript:preguntarsub('<?php echo $row_rsSubcategoria['Id_Subcategoria']; ?>','<?php echo $row_rsSubcategoria['Nombre_Sub']; ?>','<? echo $row_rsCategoria['Id_Categoria']?>')"><img src="../img/icon_del.png" width="19" height="20" border="0"></a></td>
            </tr>
            <?php } while ($row_rsSubcategoria = mysql_fetch_assoc($rsSubcategoria)); ?>
            
            
          </tbody>
        </table>
        <? } ?>
          <blockquote>
            <table border="0">
              <tr>
               <? if ($totalRows_rsSubcategoria>=1){?>
                <td colspan="4" class="fuente">
SubCategor�as del <?php echo ($startRow_rsSubcategoria + 1) ?> al <?php echo min($startRow_rsSubcategoria + $maxRows_rsSubcategoria, $totalRows_rsSubcategoria) ?> de <?php echo $totalRows_rsSubcategoria ?> en total</td>

<? } else {?> <td colspan="4" class="fuente"> No hay subcategorias en  <? echo $row_rsCategoria['Nombre_Cat'];?></td> <? } ?>
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
            <p><a href="agregar_sub.php?id_cat=<?php echo $row_rsCategoria['Id_Categoria']; ?>" class="fuente linksRojo"><strong>[+] Agregar Nueva Subcategor&iacute;a</strong></a>            </p>
            <p><strong><a href="index.php" class="fuente linksRojo">&laquo; Volver a la Lista de Categor&iacute;as</a></strong></p>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table></td>
  </tr>
  <? include("../option/footer.php"); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsOptions);

mysql_free_result($rsCategoria);

mysql_free_result($rsSubcategoria);
?>