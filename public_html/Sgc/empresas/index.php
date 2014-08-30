<?php require_once('../../Connections/cnx_arica.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
  $nivel= $_SESSION['MM_IdNivel'];
$usuario=$_SESSION['MM_IdUser'];
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
	
  $logoutGoTo = "../salir.php?nivel=$nivel";
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
$MM_authorizedUsers = "1,4,5";
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
if (!((isset($_SESSION['MM_arica'])) && (isAuthorized("2",$MM_authorizedUsers, $_SESSION['MM_arica'], $_SESSION['MM_UserGroup'])))) {   
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
<?php include('../includes/funciones.php');

$currentPage = $_SERVER["PHP_SELF"];

?>
<?
if ($_POST['codigo_Txt']) {
	$buscar= $_POST['codigo_Txt'];
$query_rsProductos = " SELECT * FROM empresa WHERE empresa.Nombre_Emp like '%$buscar%' ";
	}
	else {
$query_rsProductos = "SELECT * FROM empresa  WHERE empresa.IdUsuario_Emp='$usuario' ORDER BY empresa.Id_Empresa ASC";
	}
if (!$_GET['id_tip']){
$query_rsProductos2 = "SELECT * FROM empresa, empresa_rubro WHERE empresa.Id_Rubro_Empresa = empresa_rubro.Id_Rubro ORDER BY Id_Empresa ASC";
}
elseif($_GET['id_tip']){
	$id_tip=$_GET['id_tip'];
	$query_rsProductos2 = "SELECT * FROM empresa, empresa_rubro WHERE empresa.Id_Rubro_Empresa = empresa_rubro.Id_Rubro AND  empresa_rubro.Id_Rubro=$id_tip ORDER BY Id_Empresa ASC";
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

$maxRows_rsProductos = 30;
$pageNum_rsProductos = 0;
if (isset($_GET['pageNum_rsProductos'])) {
  $pageNum_rsProductos = $_GET['pageNum_rsProductos'];
}
$startRow_rsProductos = $pageNum_rsProductos * $maxRows_rsProductos;

mysql_select_db($database_cnx_arica, $cnx_arica);

if($_SESSION['MM_IdNivel']==1){
$query_limit_rsProductos = sprintf("%s LIMIT %d, %d", $query_rsProductos2, $startRow_rsProductos, $maxRows_rsProductos);
$rsProductos = mysql_query($query_limit_rsProductos, $cnx_arica) or die(mysql_error());
$row_rsProductos = mysql_fetch_assoc($rsProductos);
				
if (isset($_GET['totalRows_rsProductos'])) {
  $totalRows_rsProductos = $_GET['totalRows_rsProductos'];
} else {
  $all_rsProductos = mysql_query($query_rsProductos2);
  $totalRows_rsProductos = mysql_num_rows($all_rsProductos);
}
$totalPages_rsProductos = ceil($totalRows_rsProductos/$maxRows_rsProductos)-1;

$queryString_rsProductos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsProductos") == false && 
        stristr($param, "totalRows_rsProductos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsProductos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsProductos = sprintf("&totalRows_rsProductos=%d%s", $totalRows_rsProductos, $queryString_rsProductos);				
				
				}
else
				{
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

$queryString_rsProductos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsProductos") == false && 
        stristr($param, "totalRows_rsProductos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsProductos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsProductos = sprintf("&totalRows_rsProductos=%d%s", $totalRows_rsProductos, $queryString_rsProductos);	
				}



?>
 
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA GESTOR DE CONTENIDOS</title>
<link href="../css/sgc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" language="javascript">
function ordenar(id,i,antiguo) { 
var indice = document.getElementById('orden_Txt['+i+']').selectedIndex;
var valor = document.getElementById('orden_Txt['+i+']').options[indice].value 
var nuevo = document.getElementById('orden_Txt['+i+']').value;
	
document.location=('orden.php?id_pro='+id+'&orden='+valor+'&antiguo='+antiguo);
}
</script>
</head>

<body>

<table width="1003" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes" id="tbnoticia">
  <? include("../option/header.php"); ?>
  <tr>
    <td height="14" valign="top" class="fuente">&nbsp;</td>
  </tr>
  <tr>
    <td><blockquote>
     <strong><p id="raqueo">&raquo <a id="guia_titulos" href="../login.php">Inicio</a> / <a id="guia_titulos" href="../empresas/index.php">M&oacute;dulo de Empresa</a> / <a id="guia_titulos" href="#">Listado</a></p></strong>
      <p class="titles">&raquo; M&oacute;dulo de Empresa</p>
    
    </blockquote>    
  
      <table width="1000" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle">

  <? if ($totalRows_rsProductos>0) { ?>
<table width="100%" align="center" class="bordes2" >
          <tr align="center" bgcolor="#660000" class="blanco11">
            <td width="27%" bgcolor="#003366" class="blanco12">Nombre de Empresa</td>
            <td width="27%" bgcolor="#003366" class="blanco12">Rubro de Empresa</td>
             
       <td width="10%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Estado</strong></td>
      
            <td width="12%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Editar</strong></td>
            <td width="12%" bgcolor="#003366" class="blanco12"><strong class="blanco11">Eliminar</strong></td>
          </tr>
            <tbody class="tabla">          
          <?php 
		  $i = 0;
		  do { 
		  $i = $i+1;
		  ?>
            <tr class="odd">
                <td class="fuente">&nbsp;<a href="ver.php?id_pro=<?php echo $row_rsProductos['Id_Empresa']; ?>" class="fuente">
                
                
                
           <strong><?php echo utf8_encode($row_rsProductos['Nombre_Emp']); ?></strong></a>
<?php /*?><!--        <a id="abajo<?php echo $row_rsProductos['Id_Empresa']; ?>" href="javascript:cargar('destinos.php?id_emp=<?php echo $row_rsProductos['Id_Empresa']; ?>','dv<?php echo $row_rsProductos['Id_Empresa']; ?>')
               
                ; mostrar('arriba<?php echo $row_rsProductos['Id_Empresa']; ?>')
                ; mostrar('tr<?php echo $row_rsProductos['Id_Empresa']; ?>'); 
                ;  ocultar('abajo<?php echo $row_rsProductos['Id_Empresa']; ?>') "               
                style="float:left;" class="fuente"><img src="../img/abajo.png" width="16" height="16" border="0" align="absbottom"></a>--><?php */?>
            <a id="arriba<?php echo $row_rsProductos['Id_Empresa']; ?>" href="javascript:ocultar('tr<?php echo $row_rsProductos['Id_Empresa']; ?>')
                ;ocultar('arriba<?php echo $row_rsProductos['Id_Empresa']; ?>');mostrar('abajo<? echo $row_rsProductos['Id_Empresa']?>')" 
                class="fuente" style="display:none;float:left;"><img src="../img/arriba.png" alt="" width="16" height="16" align="absbottom"></a>&nbsp;
           
                 </td>
          
            <td class="fuente">&nbsp;<a id="subrayado_cat_not" href="javascript:cargar('../empresas/index.php?id_tip=<? echo $row_rsProductos['Id_Rubro']?>','tbnoticia')">
           <strong><?php echo utf8_encode($row_rsProductos['Nombre_Rubro']); ?></strong></a>

             </td>
                   
                <td align="center"><select name="estado<?php echo $row_rsProductos['Id_Empresa'];?>" class="fuente" id="estado<?php echo $row_rsProductos['Id_Empresa']; ?>" onChange="cargar('estado.php?id_pro=<?php echo $row_rsProductos['Id_Empresa']; ?>&estado='+this.value,'estado<?php echo $row_rsProductos['Id_Empresa']; ?>')">
                  <option value="1" <?php if (!(strcmp(1, $row_rsProductos['Estado_Emp']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
                  <option value="0" <?php if (!(strcmp(0, $row_rsProductos['Estado_Emp']))) {echo "selected=\"selected\"";} ?>>Deshabilitado</option>
                </select></td>
                
                 <td align="center"><a href="editar.php?id_pro=<?php echo $row_rsProductos['Id_Empresa'];?>&rubro_sub=<? echo $row_rsProductos['Rubro_Sub_Id'];?>"><img src="../img/icon_edit.png" width="20" height="20" border="0"></a></td>
            <td align="center"><a href="javascript:preguntarempresa('<?php echo $row_rsProductos['Id_Empresa']; ?>','<?php echo utf8_encode($row_rsProductos['Nombre_Emp']); ?>','<? echo $_GET['id_tip'];?>')"><img src="../img/icon_del.png" width="19" height="20" border="0"></a></td>
            </tr>
            
             <tr class="nocolor" id="tr<?php echo $row_rsProductos['Id_Empresa']; ?>" style="display:none">
            <td colspan="4"><div id="dv<?php echo $row_rsProductos['Id_Empresa']; ?>"></div></td>
            </tr>
            
            
            <?php } while ($row_rsProductos = mysql_fetch_assoc($rsProductos)); ?>
              </tbody>
        </table>  
          <? } ?>           
          <blockquote>
          
          
          
          <? if ($_GET['id_emp']){
			  ?> 
			  <script> cargar('destinover.php?id_emp=<? echo $_GET['id_emp']?>&id_destinoempresa=<? echo $_GET['id_destinoempresa']?>','dv<? echo $_GET['id_emp'] ?>');mostrar('arriba<? echo $_GET['id_emp'] ?>');mostrar('tr<? echo $_GET['id_emp'] ?>');ocultar('abajo<? echo $_GET['id_emp'] ?>')
</script>			  
			  <?
			  }?>
          
          
        <table border="0">
              <tr>
           <? if ($totalRows_rsProductos>=1){?>
              
                <td colspan="4" class="fuente">
Empresas del <?php echo ($startRow_rsProductos + 1) ?> al <?php echo min($startRow_rsProductos + $maxRows_rsProductos, $totalRows_rsProductos) ?> de <?php echo $totalRows_rsProductos ?> en total</td>
 <? } else {?> <td colspan="4" class="fuente"> Ud. no ha registrado su empresa</td> <? } ?>
                </tr>
              <tr>
                <td align="center"><?php if ($pageNum_rsProductos > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsProductos=%d%s", $currentPage, 0, $queryString_rsProductos); ?>"><img src="../img/First.gif" border="0"></a>
                  <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_rsProductos > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsProductos=%d%s", $currentPage, max(0, $pageNum_rsProductos - 1), $queryString_rsProductos); ?>"><img src="../img/Previous.gif" border="0"></a>
                  <?php } // Show if not first page ?></td>
                <td align="center"><?php if ($pageNum_rsProductos < $totalPages_rsProductos) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsProductos=%d%s", $currentPage, min($totalPages_rsProductos, $pageNum_rsProductos + 1), $queryString_rsProductos); ?>"><img src="../img/Next.gif" border="0"></a>
                  <?php } // Show if not last page ?></td>
                <td align="center"><?php if ($pageNum_rsProductos < $totalPages_rsProductos) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsProductos=%d%s", $currentPage, $totalPages_rsProductos, $queryString_rsProductos); ?>"><img src="../img/Last.gif" border="0"></a>
                  <?php } // Show if not last page ?></td>
              </tr>
          </table>
<p><a href="../empresas/index.php" class="fuente linksRojo"><strong>Módulo de Empresa Lista Original</strong></a></p>
            <p><a href="agregar.php" class="fuente linksRojo"><strong>[+] Agregar  Empresa</strong></a></p>
            <?  if ($_POST['codigo_Txt']) { ?>
            <p><a href="index.php" class="fuente linksRojo"><strong>&laquo; Volver a Listado de Empresas  </strong></a></p>
            <? }?> 
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

mysql_free_result($rsProductos);
?>