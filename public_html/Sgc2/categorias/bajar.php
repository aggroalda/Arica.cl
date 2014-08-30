<?php require_once('../../Connections/cnx_arica.php'); ?>
<?
ob_start();
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
} ?>





<?php
session_start();
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Userjapan set equal to their username. 
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

$MM_restrictGoTo = "../../error.php";
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









<?
if ((isset($_GET['id_cat'])) && ($_GET['id_cat'] != "")) {
// bajar orden del menu
	$orden= $_GET['orden'];
    $id_cat = $_GET['id_cat'];
    $ordenSubir = $_GET['orden'] - 1;  
    $ordenBajar = $_GET['orden'] + 1;  

	        mysql_select_db($database_cnx_arica, $cnx_arica);
			$query_rsCategoria = "SELECT * FROM categoria WHERE Orden_Cat= ".$ordenBajar;
			$rsCategoria = mysql_query($query_rsCategoria, $cnx_arica) or die(mysql_error());
			$row_rsCategoria = mysql_fetch_assoc($rsCategoria);
			$totalRows_rsCategoria = mysql_num_rows($rsCategoria);
			
			$total = $totalRows_rsCategoria;
				$id_antiguo = $row_rsCategoria['Id_Categoria'];
			


	
    mysql_select_db($database_cnx_arica, $cnx_arica);
     mysql_query("UPDATE categoria SET Orden_Cat = $ordenBajar
                             WHERE Id_Categoria = $id_cat", $cnx_arica)
                             or die(mysql_error());
	mysql_select_db($database_cnx_arica, $cnx_arica);
     mysql_query("UPDATE categoria SET Orden_Cat = $orden
                             WHERE Id_Categoria = $id_antiguo", $cnx_arica)
                             or die(mysql_error());
		
	
	
}
	?>
    
  <? 
include('../../Connections/cnx_arica.php');


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

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoria = "SELECT * FROM categoria ORDER BY Orden_CAT ASC";
$query_limit_rsCategoria = sprintf("%s LIMIT %d, %d", $query_rsCategoria, $startRow_rsCategoria, $maxRows_rsCategoria);
$rsCategoria = mysql_query($query_limit_rsCategoria, $cnx_arica) or die(mysql_error());
$row_rsCategoria = mysql_fetch_assoc($rsCategoria);
$totalRows_rsCategoria= mysql_num_rows($rsCategoria);

if (isset($_GET['totalRows_rsCategoria'])) {
  $totalRows_rsCategoria = $_GET['totalRows_rsCategoria'];
} else {
  $all_rsCategoria = mysql_query($query_rsCategoria);
  $totalRows_rsCategoria = mysql_num_rows($all_rsCategoria);
}
$totalPages_rsCategoria = ceil($totalRows_rsCategoria/$maxRows_rsCategoria)-1;

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
  <tr>
    <td>
    <blockquote>
    	<strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../categorias/index.php">M&oacute;dulo de Categor&iacute;a de Noticia</a></p></strong>
      <p class="titles">&raquo; Módulo de Categoría de Noticia</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><table width="100%" align="center" class="bordes2" id="">
          <tr align="center" bgcolor="#660000" class="blanco11">
            <td width="29%" bgcolor="#003366" class="blanco12">Categor&iacute;a</td>
            <td width="18%" bgcolor="#003366" class="blanco12">Orden</td>
            <td width="15%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Estado</strong></td>
            <td width="18%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Editar</strong></td>
            <td width="20%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Eliminar</strong></td>
          </tr>
            <tbody class="tabla">          
          <?php do { ?>
            <tr class="odd">
                <td class="fuente">- 
                
               <? /* <a href="categoria.php?id_cat=<?php echo $row_rsCategoria['Id_Categoria']; ?>" class="fuente"><strong><?php echo $row_rsCategoria['Nombre_Cat']; ?></strong></a><? */?>
                
               <strong><a id="subrayado_cat_not" href="../novedades/index_get_categoria.php?id_cat_cat=<? echo $row_rsCategoria['Id_Categoria']; ?>"><?php echo utf8_encode($row_rsCategoria['Nombre_Cat']); ?></a></strong>
                </td>
                <td class="fuente"   align="left"> <strong><? echo  $row_rsCategoria['Orden_Cat'];?></strong>
             
     <? if($row_rsCategoria['Orden_Cat']< $totalRows_rsCategoria){?>
<a href="#" id="subrayado_no" onclick ="javascript:cargar('bajar.php?id_cat=<?php echo $row_rsCategoria['Id_Categoria'];?>&orden=<?php echo $row_rsCategoria['Orden_Cat']; ?>','tabla')">
<img src="../img/down_icon.png"  onmouseover="this.src='../img/down_icon_hover.png'" onmouseout="this.src='../img/down_icon.png'" alt="Down to <?php echo $row_rsCategoria['Orden_Cat']+1;?>"  width="19" height="17" border="0">
</a> 
      <? } ?>        
  <? if ($row_rsCategoria['Orden_Cat']>1){?>   
                
<a id="subrayado_no" href="javascript:cargar('subir.php?id_cat=<?php echo $row_rsCategoria['Id_Categoria']; ?>&orden=<?php echo $row_rsCategoria['Orden_Cat'];?>','tabla')">
<img src="../img/up_icon.png"  onmouseover="this.src='../img/up_icon_hover.png'" onmouseout="this.src='../img/up_icon.png'" alt="A <?php echo $row_rsCategoria['Orden_Cat']-1; ?>" width="19" height="17" border="0">
</a>
          </td> <? } ?>
                <td align="center"><select name="estado<?php echo $row_rsCategoria['Id_Categoria']; ?>" class="fuente" id="estado<?php echo $row_rsCategoria['Id_Categoria']; ?>" onChange="cargar('estado.php?id_cat=<?php echo $row_rsCategoria['Id_Categoria']; ?>&estado='+this.value,'estado<?php echo $row_rsCategoria['Id_Categoria']; ?>')">
                  <option value="1" <?php if (!(strcmp(1, $row_rsCategoria['Estado_Cat']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
                  <option value="0" <?php if (!(strcmp(0, $row_rsCategoria['Estado_Cat']))) {echo "selected=\"selected\"";} ?>>Deshabilitado</option>
                </select></td>
              <td align="center"><a href="javascript:cargar('editar.php?id_cat=<?php echo $row_rsCategoria['Id_Categoria']; ?>','tabla')"><img src="../img/icon_edit.png" width="20" height="20" border="0"></a></td>
              <td align="center"><a href="javascript:preguntar('<?php echo $row_rsCategoria['Id_Categoria']; ?>','<?php echo $row_rsCategoria['Nombre_Cat']; ?>','<? echo $row_rsCategoria['Orden_Cat'];?>')"><img src="../img/icon_del.png" width="19" height="20" border="0"></a></td>
            </tr>
            <?php } while ($row_rsCategoria = mysql_fetch_assoc($rsCategoria)); ?>
              </tbody>
        </table>          
          <blockquote>
            <table border="0">
              <tr>
                <td colspan="4" class="fuente">
Categor&iacute;as del <?php echo ($startRow_rsCategoria + 1) ?> al <?php echo min($startRow_rsCategoria + $maxRows_rsCategoria, $totalRows_rsCategoria) ?> de <?php echo $totalRows_rsCategoria ?> en total</td>
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
            <? if ($totalRows_rsCategoria<=10) { ?>
            <p><a href="javascript:cargar('agregar.php?orden=<? echo $totalRows_rsCategoria +1 ?>','tabla')" class="fuente linksRojo"><strong>[+] Agregar Nueva Categor&iacute;a de Noticia</strong></a></p>
            <? } ?>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table>
   
    
    </td>
  </tr> 
 

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
<?
ob_end_flush();
?>