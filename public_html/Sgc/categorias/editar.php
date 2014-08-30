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
<?php include('../includes/funciones.php');



mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsOptions = "SELECT licencia_opc FROM opciones";
$rsOptions = mysql_query($query_rsOptions, $cnx_arica) or die(mysql_error());
$row_rsOptions = mysql_fetch_assoc($rsOptions);
$totalRows_rsOptions = mysql_num_rows($rsOptions);

$colname_rsCategoria = "-1";
if (isset($_GET['id_cat'])) {
  $colname_rsCategoria = $_GET['id_cat'];
}
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsCategoria = sprintf("SELECT * FROM categoria WHERE Id_Categoria = %s", GetSQLValueString($colname_rsCategoria, "int"));
$rsCategoria = mysql_query($query_rsCategoria, $cnx_arica) or die(mysql_error());
$row_rsCategoria = mysql_fetch_assoc($rsCategoria);
$totalRows_rsCategoria = mysql_num_rows($rsCategoria);
?>






    <td><blockquote>
      <p class="titles">&raquo; M&oacute;dulo de Categoria de Noticia- Editar</p>
    </blockquote>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle"><blockquote>
          <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="11" height="11" id="cdo_top_izq"></td>
                  <td width="849" height="11" id="cdo_top_fnd"></td>
                  <td width="11" height="11" id="cdo_top_der"></td>
            </tr>
            <tr>
              <td background="../img/cdo_izq_fnd.jpg"></td>
              <td bgcolor="#EBEBEB"><form action="editar_proceso.php" method="POST" enctype="multipart/form-data" name="form1" id="form1" target="frameSave">
                <table width="100%">
                  <tr>
                    <td align="right" class="fuente"><strong>Categor&iacute;a de Noticia:</strong></td>
                    <td><label for="categoria_Txt2"></label>
                      <label for="nombre_Txt"></label>
                      <input name="nombre_Txt" type="text" class="fuente" id="nombre_Txt" title="Nombre de Categor&iacute;a "value="<?php echo utf8_encode($row_rsCategoria['Nombre_Cat']); ?>"></td>
                  </tr>
                  <tr>
                    <td width="46%" align="right" class="fuente"><strong>Estado:</strong></td>
                    <td width="54%" class="fuente"><label for="categoria_Txt"></label>
                      <label for="nombre_Txt"></label>
                      <input <?php if (!(strcmp($row_rsCategoria['Estado_Cat'],1))) {echo "checked=\"checked\"";} ?> name="estado_Txt" type="checkbox" id="estado_Txt" value="1">
                      <label for="estado_Txt">Habilitado</label></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center">
                      <input type="hidden" name="MM_update" value="form1">
                      <input name="id_cat" type="hidden" id="id_cat" value="<?php echo $row_rsCategoria['Id_Categoria']; ?>">
                      <input name="SendForm" type="submit" id="SendForm"  value=" Guardar ">
                      </td>
                  </tr>
                </table>
              </form>
                
                 <iframe id="frameSave" name="frameSave"  style="width:0;height:0;border:0; display:none"></iframe> 
                
              
              </td>
              <td background="../img/cdo_der_fnd.jpg"></td>
            </tr>
              <td id="cdo_dwn_izq" height="11" width="11"></td>
                  <td id="cdo_dwn_fnd" height="11"></td>
                  <td id="cdo_dwn_der"></td>
            </tr>
          </table>
          <p><a href="javascript:cargar('listado.php','tabla')" class="fuente linksRojo"><strong>&laquo; Volver al Listado de Categoria de Noticia</strong></a></p>
            <p><a href="../login.php" class="fuente linksRojo"><strong>&laquo; Volver al Inicio</strong></a></p>
            <p><strong><a href="<?php echo $logoutAction ?>" class="fuente linksRojo">[X] Salir del SGC</a></strong></p>
          </blockquote>
          <p>&nbsp;</p></td>
        </tr>
    </table></td>


