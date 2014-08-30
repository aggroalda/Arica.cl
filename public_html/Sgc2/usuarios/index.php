<?php require_once('../../Connections/cnx_arica.php'); ?>
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
$MM_authorizedUsers = "1";
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
if (!((isset($_SESSION['MM_arica'])) && (isAuthorized("5,4,2",$MM_authorizedUsers, $_SESSION['MM_arica'], $_SESSION['MM_UserGroup'])))) {   
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

$maxRows_rsUsuarios = 30;
$pageNum_rsUsuarios = 0;
if (isset($_GET['pageNum_rsUsuarios'])) {
  $pageNum_rsUsuarios = $_GET['pageNum_rsUsuarios'];
}
$startRow_rsUsuarios = $pageNum_rsUsuarios * $maxRows_rsUsuarios;

mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsUsuarios = "SELECT * FROM usuarios, nivel, personas WHERE usuarios.IdPersona_Usu = personas.Id_Persona AND usuarios.IdNivel_Usu = nivel.Id_Nivel ORDER BY Id_Usuario DESC";
$query_limit_rsUsuarios = sprintf("%s LIMIT %d, %d", $query_rsUsuarios, $startRow_rsUsuarios, $maxRows_rsUsuarios);
$rsUsuarios = mysql_query($query_limit_rsUsuarios, $cnx_arica) or die(mysql_error());
$row_rsUsuarios = mysql_fetch_assoc($rsUsuarios);

if (isset($_GET['totalRows_rsUsuarios'])) {
  $totalRows_rsUsuarios = $_GET['totalRows_rsUsuarios'];
} else {
  $all_rsUsuarios = mysql_query($query_rsUsuarios);
  $totalRows_rsUsuarios = mysql_num_rows($all_rsUsuarios);
}
$totalPages_rsUsuarios = ceil($totalRows_rsUsuarios/$maxRows_rsUsuarios)-1;

$queryString_rsUsuarios = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsUsuarios") == false && 
        stristr($param, "totalRows_rsUsuarios") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsUsuarios = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsUsuarios = sprintf("&totalRows_rsUsuarios=%d%s", $totalRows_rsUsuarios, $queryString_rsUsuarios);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" type="image/x-icon" href="../../0_SOURCE/SGC_INTERNET/img/sgc.ico" />
<script type="text/javascript" src="../js/ajax.js"></script>
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
    <strong>
    <p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../usuarios/index.php">M&oacute;dulo de Usuarios</a> / <a id="guia_titulos" href="#">Listado</a></p></strong>
      <p class="titles">&raquo; M&oacute;dulo de Usuarios  / Listado</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><table width="100%" align="center" class="bordes2" >

          <tr align="center" bgcolor="#660000" class="blanco11">
            <td width="27%" bgcolor="#003366" class="blanco12">Nombres y Apellidos</td>
            <td width="13%" bgcolor="#003366" class="blanco12">Nivel  de Usuario</td>
            <td width="13%" bgcolor="#003366" class="blanco12">Ciudad</td>
            <td width="13%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Estado</strong></td>
            <td width="17%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Editar</strong></td>
            <td width="17%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Eliminar</strong></td>
          </tr>
            <tbody class="tabla">          
          <?php do { ?>
            <tr class="odd">
                <td class="fuente">&nbsp;<a href="ver.php?id_usu=<?php echo $row_rsUsuarios['Id_Usuario']; ?>" class="fuente"><strong><?php echo utf8_encode($row_rsUsuarios['Nombres_Per']); ?> <?php echo utf8_encode($row_rsUsuarios['Paterno_Per']); ?> <?php echo utf8_encode($row_rsUsuarios['Materno_Per']); ?></strong></a></td>
                <td class="fuente">&nbsp;<?php echo $row_rsUsuarios['Nombre_Niv']; ?></td>
                <td class="fuente">&nbsp;<?php echo utf8_encode($row_rsUsuarios['Ciudad_Per']); ?></td>
                <td align="center"><select name="estado<? echo $row_rsUsuarios['Id_Usuario']?>" class="fuente" id="estado<? echo $row_rsUsuarios['Id_Usuario']?>" onChange="cargar('estado.php?id_usu=<?php echo $row_rsUsuarios['Id_Usuario']; ?>&estado='+this.value,'estado<? echo $row_rsUsuarios['Id_Usuario']?>')">
                  <option value="1" <?php if (!(strcmp(1, $row_rsUsuarios['Estado_Usu']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
                  <option value="0" <?php if (!(strcmp(0, $row_rsUsuarios['Estado_Usu']))) {echo "selected=\"selected\"";} ?>>Deshabilitado</option>
                </select>
                </td>
              <td align="center"><a href="editar.php?id_usu=<?php echo $row_rsUsuarios['Id_Usuario']; ?>"><img src="../img/icon_edit.png" width="20" height="20" border="0"></a></td>
              <td align="center"><a href="javascript:preguntar('<?php echo $row_rsUsuarios['Id_Usuario']; ?>','<?php echo utf8_encode($row_rsUsuarios['Nombres_Per']); ?> <?php echo utf8_encode($row_rsUsuarios['Paterno_Per']); ?> <?php echo utf8_encode($row_rsUsuarios['Materno_Per']); ?>')"><img src="../img/icon_del.png" width="19" height="20" border="0"></a></td>
            </tr>
            <?php } while ($row_rsUsuarios = mysql_fetch_assoc($rsUsuarios)); ?>
              </tbody>
        </table>          
          <blockquote>
            <table border="0">
              <tr>
                <td colspan="4" class="fuente">
Usuarios del <?php echo ($startRow_rsUsuarios + 1) ?> al <?php echo min($startRow_rsUsuarios + $maxRows_rsUsuarios, $totalRows_rsUsuarios) ?> de <?php echo $totalRows_rsUsuarios ?> en total</td>
                </tr>
              <tr>
                <td align="center"><?php if ($pageNum_rsUsuarios > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsUsuarios=%d%s", $currentPage, 0, $queryString_rsUsuarios); ?>"><img src="../img/First.gif" border="0"></a>
                  <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_rsUsuarios > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsUsuarios=%d%s", $currentPage, max(0, $pageNum_rsUsuarios - 1), $queryString_rsUsuarios); ?>"><img src="../img/Previous.gif" border="0"></a>
                  <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_rsUsuarios < $totalPages_rsUsuarios) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsUsuarios=%d%s", $currentPage, min($totalPages_rsUsuarios, $pageNum_rsUsuarios + 1), $queryString_rsUsuarios); ?>"><img src="../img/Next.gif" border="0"></a>
                  <?php } // Show if not last page ?></td>
                <td align="center"><?php if ($pageNum_rsUsuarios < $totalPages_rsUsuarios) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsUsuarios=%d%s", $currentPage, $totalPages_rsUsuarios, $queryString_rsUsuarios); ?>"><img src="../img/Last.gif" border="0"></a>
                  <?php } // Show if not last page ?></td>
              </tr>
          </table>
            <p><a href="agregar.php" class="fuente linksRojo"><strong>[+] Agregar Nuevo Usuario</strong></a></p>
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

mysql_free_result($rsUsuarios);
?>