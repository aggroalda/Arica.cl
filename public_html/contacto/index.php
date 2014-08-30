<?php require_once('../Connections/cnx_arica.php'); ?>
<?php require_once('../include/header.php'); ?>
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
?>
<? 
			mysql_select_db($database_cnx_arica, $cnx_arica);
			$query_rsOpcion = "SELECT * from opciones";
			$rsOpcion = mysql_query($query_rsOpcion, $cnx_arica) or die(mysql_error());
			$row_rsOpcion = mysql_fetch_assoc($rsOpcion);
			$totalRows_rsOpcion = mysql_num_rows($rsOpcion);?>


	<div id="cuerpo">
    <div class="principal" id="principal">
     <div id="page"><div id="titulo_buscar_div"><h1 id="titulo_buscar">BUSCADOR</h1></div>
         <div id="resultsDiv"></div>
     </div>
     <div id="accion_ocultar">
<div >
      <div>

	<div id="titulo_registro"> 
	 Información de Contacto
      <p style="font-family: 'ArimoRegular';
font-size: 12px !important;
color: #333333;">Teléfono: <? echo $row_rsOpcion['telefono_opc']; ?><br>
        Dirección: <? echo $row_rsOpcion['direccion_opc']; ?> <br>
        Sitio Web: <strong><a style="color:#FF6600"  href="http://www.fulldent.cl">http://www.arica.cl</a></strong><a href="http://www.fulldent.cl"><br>
  </a>Correo electrónico:<strong> <a style="color:#FF6600"  href="mailto:<? echo $row_rsOpcion['email_contacto_opc'];?>"><? echo $row_rsOpcion['email_contacto_opc'];?></a></strong><br>
       <?php /*?> Cuenta en el Facebook: <a href="#"><strong>http://www.facebook.com/aricacl</strong></a><?php */?></p>
      <p>&nbsp;</p>
      Formulario de Contacto</div>
	<div id="fondo_registro">
	  <form  onSubmit="ValidarCampoCorreo(this);" action="envio_email.php" method="POST" enctype="multipart/form-data" name="form1" id="form1" >
                           
  <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:12px;">
      
                  <tr>
                    <td width="43%" align="right" class="fuente2"><strong >Usuario / Correo Electr&oacute;nico:</strong></td>
<td width="57%" ><input name="usuario2_Txt" type="text" class="fuente" id="usuario2_Txt" size="35" style="float:left;"></td>
                  </tr>
                
                  <tr>
                    <td class="fuente2" align="right"  height="30px"><strong>Nombres:</strong></td>
                   <td align="left"   height="20px"><input name="nombres_Txt" type="text" class="fuente" id="nombres_Txt"></td>
                  
                  </tr>
                  <tr>
                    <td class="fuente2" align="right"   height="30px"><strong>Apellido Paterno:</strong></td>
                    <td align="left"   height="30px"><input name="paterno_Txt" type="text" class="fuente" id="paterno_Txt"></td>
                  </tr>
                  <tr>
                    <td class="fuente2" align="right"   height="30px"><strong>Apellido Materno:</strong></td>
                    <td align="left"  height="30px"><input name="materno_Txt" type="text" class="fuente" id="materno_Txt"></td>
                    
                  </tr>
                  
                   <tr>
                    <td class="fuente2" align="right" height="30px"><strong>Fecha de Nacimiento:</strong></td>
                    <td align="left"  height="30px"><input name="fecha_Txt" type="text" class="fuente" id="fecha_Txt" onFocus="showCalendarControl(this);"></td>
                    
                  </tr>
                  
                   <tr>
                    <td class="fuente2" align="right"  height="30px"><strong>Sexo:</strong></td>
                    <td align="left"  height="30px"><select name="sexo_text" class="fuente" id="sexo_text">
                    <option value="">-- Seleccione --</option>
                    <option>Masculino</option>
                    <option>Femenino</option>
                    </select>
                    </td>
                    
                  </tr>
                  
        <tr>
                    <td align="right" class="fuente2" height="30px"><strong>Ciudad:</strong></td>
                    <td align="left"  height="30px"><input name="ciudad_Txt" type="text" class="fuente" id="ciudad_Txt"></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente2" height="30px"><strong>País:</strong></td>
                    <td align="left"  height="30px"><input name="direccion_Txt" type="text" class="fuente" id="direccion_Txt"size="35"></td>
                  </tr>
                  <tr>
                    <td align="right" class="fuente2" height="30px"><strong>Asunto:</strong></td>
                    <td align="left"  height="30px"><input name="asunto_Txt" type="text" class="fuente" id="asunto_Txt" /></td>
                  </tr>
                  
                    <tr>
                    <td align="right" class="fuente2" height="30px"><strong>Mensaje:</strong></td>
                    <td align="left"  height="30px"><textarea name="mensaje_Txt" type="text" class="fuente" id="mensaje_Txt"></textarea></td>
          </tr>
                  <tr>
                    <td colspan="2" align="center"  height="30px">
                  <input name="SendForm" type="submit" id="SendForm" value=" Enviar "/></td>
                  </tr>
          </table>
           </form> 
         </div>
          <br />         

</table>
      </div>
 
 </div>
 </div>
        </div>
        
      	<div class="lateral margen_arriba_contacto">
        <? include('../include/lateral.php');?>
           </div>
    </div>
   <? include('../include/pie_pagina.php');?>
   
</div>
</body>
</html>
