<?php require_once('../Connections/cnx_arica.php'); ?>
<?php require_once('../include/header.php'); ?>

		<script type="text/javascript" charset="utf-8" src="ranking/js/jquery.raty.min.js"></script>
	
	<div id="cuerpo">
    <div class="principal" id="principal">

<div id="page"><div id="titulo_buscar_div"><h1 id="titulo_buscar">BUSCADOR</h1></div>
         <div id="resultsDiv"></div>
     </div>
     <div id="accion_ocultar">

<? 
 $id_emp=$_GET['id_emp'];
 $id_rub=$_GET['id_rub'];
 
 if(isset($_SESSION['MM_IdUser'])){
 $id_usu=$_SESSION['MM_IdUser'];
 }
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsEmpresas = "SELECT *  FROM empresa,usuarios,empresa_rubro,personas where empresa.Estado_Emp='1' AND empresa.Id_Empresa='".$_GET['id_emp']."' AND empresa.IdUsuario_Emp = usuarios.Id_Usuario AND usuarios.IdPersona_Usu = personas.Id_Persona AND empresa.Id_Rubro_Empresa=empresa_rubro.Id_Rubro";
$rsEmpresas = mysql_query($query_rsEmpresas, $cnx_arica) or die(mysql_error());
$row_rsEmpresas = mysql_fetch_assoc($rsEmpresas);
$totalRows_rsEmpresas = mysql_num_rows($rsEmpresas);

$query_rsTopRanking = "SELECT * FROM ranking, empresa WHERE ranking.Id_Rubro_Ranking=$id_rub AND ranking.Id_Empresa_Ranking=$id_emp";
$rsTopRanking = mysql_query($query_rsTopRanking, $cnx_arica) or die(mysql_error());
$rows_rsTopRanking = mysql_fetch_assoc($rsTopRanking);
$totalRows_rsTopRanking =mysql_num_rows($rsTopRanking);	

$query_rsTotalEmpresas = "SELECT * FROM empresa WHERE Id_Rubro_Empresa=$id_rub";
$rsTotalEmpresas = mysql_query($query_rsTotalEmpresas, $cnx_arica) or die(mysql_error());
$rows_rsTotalEmpresas = mysql_fetch_assoc($rsTotalEmpresas);
$totalRows_rsTotalEmpresas =mysql_num_rows($rsTotalEmpresas);	

if($_SESSION){
$query_rsComprobacion = "SELECT * FROM ranking WHERE Id_Empresa_Ranking=$id_emp AND Id_Usuario_Ranking = $id_usu";
$rsComprobacion = mysql_query($query_rsComprobacion, $cnx_arica) or die(mysql_error());
$rows_rsComprobacion = mysql_fetch_assoc($rsComprobacion);
$totalRows_rsComprobacion =mysql_num_rows($rsComprobacion);

$query_rsContarFilas= "SELECT * FROM ranking WHERE Id_Empresa_Ranking=$id_emp";
$rsContarFilas = mysql_query($query_rsContarFilas, $cnx_arica) or die(mysql_error());
$rows_rsContarFilas = mysql_fetch_assoc($rsContarFilas);
$totalRows_rsContarFilas =mysql_num_rows($rsContarFilas);

}
elseif(!$_SESSION){ echo "";}
?>
<div id="featured3">
<h2>&nbsp;</h2>
<h1><? echo utf8_encode($row_rsEmpresas['Nombre_Emp'])?></h1>
<p>&nbsp;</p>
Empresa Registrada por <? echo utf8_encode($row_rsEmpresas['Nombres_Per'])?> <? echo utf8_encode($row_rsEmpresas['Paterno_Per'])?> <? echo utf8_encode( $row_rsEmpresas['Materno_Per']);
$porcentaje=20;
$calificacion_tope=($totalRows_rsTotalEmpresas)*5;
$resultado= $calificacion_tope * ($porcentaje/100);
?><p>&nbsp;</p> 

<table width="50%" cellpadding="4" cellspacing="4" align="center" style="margin:auto auto auto 15%">
<tr>
<td width="41%">Ranking actual de la empresa:</td>

<td id="td_estrella_padding" align="left">
<div id="score" data-rating="<? 
if($totalRows_rsContarFilas=1){$puntaje=$rows_rsTopRanking['Puntaje_Ranking'];}
elseif($totalRows_rsContarFilas>1){$puntaje=$rows_rsTopRanking['Puntaje_Ranking']+(($totalRows_rsContarFilas-1)*5);
}
 if ($puntaje>($calificacion_tope-$resultado)){echo "5";} 
 elseif($puntaje<($calificacion_tope-$resultado) && $puntaje>=($calificacion_tope-$resultado*2) ){echo "4";}
  elseif($puntaje<($calificacion_tope-$resultado*2) && $puntaje>=($calificacion_tope-$resultado*3) ){echo "3";}
   elseif($puntaje<($calificacion_tope-$resultado*3) && $puntaje>=($calificacion_tope-$resultado*4) ){echo "2";}
    elseif($puntaje<($calificacion_tope-$resultado*4) && $puntaje>=($calificacion_tope-$resultado*5) ){echo "1";}
 
?>" style="cursor: pointer; width: 100px;">
<img src="ranking/img/star-on.png" alt="1" title="P&eacute;simo">
<img src="ranking/img/star-on.png" alt="2" title="Malo">
<img src="ranking/img/star-on.png" alt="3" title="Regular">
<img src="ranking/img/star-off.png" alt="4" title="Bueno">
<img src="ranking/img/star-off.png" alt="5" title="Excelente">
</div>
</td>
</tr>
<tr><td colspan="2">
<div id="titulo_not">
        
<a style="cursor:hand;" rel="sexylightbox[group1]" title="<? echo utf8_encode($row_rsEmpresas['Nombre_Emp']).":"."\n ".utf8_encode($row_rsEmpresas['Descripcion_Emp']);?>"  href="img/<?php echo $row_rsEmpresas['Foto_Emp']; ?>">
   
     <div><div id="archivo_gal"><table width="auto" height="100%" cellpadding="4" cellspacing="0" border="0"><tr><td id="color_td" class="hover"><h3 id="tit_h3">&nbsp;<? echo utf8_encode($row_rsEmpresas['Nombre_Rubro']);?>&nbsp;</h3></td></tr></table></div><div id="arc_gal"><img id="img_mar" src="../include/imagen.php?nw=400&foto=<?php echo $row_rsEmpresas['Foto_Emp']; ?>&ubicacion=../empresas/img/" border="0"/>
  </div></div>  
     </a>
     
   <div ><i><?php echo utf8_encode($row_rsEmpresas['Nombre_Emp']); ?> </i></div>
  <? /* if (!is_null($rows_rsComprobacion)){ echo"Ud. ya ingreso su calificación";}*/?>  
  <? if($_SESSION) { ?>  		
<table width="auto" cellpadding="4" cellspacing="4" id="margin_table" 
<? /* if (!is_null($rows_rsComprobacion)){ echo"style='display:none'";}*/?>>
<tr>
<td>Vota:</td>
		<td><div id="content">
		<div id="click">
<img src="ranking/img/star-on.png" alt="1" width="0" id="img1" title="P&eacute;simo">
<img src="ranking/img/star-on.png" alt="2" title="Malo" id="img1">
<img src="ranking/img/star-on.png" alt="3" title="Regular" id="img1">
<img src="ranking/img/star-on.png" alt="4" title="Bueno" id="img1">
<img src="ranking/img/star-on.png" alt="5" title="Excelente" id="img1">
<input type="hidden" name="score" value="5">
</div>
		</div></td></tr></table>
	
        
<? } ?>
		

		<script type="text/javascript">
			$(function() {
				

			
				$('#click').raty({
					click: function(score, evt) {
						'ID: ' + $(this).attr('id') + '\nscore: ' + score + '\nevent: ' + evt;						

						var variables = getURLValues();
					
						$.ajax({
							type: 'GET',
url: 'insertar_ranking.php?calificacion=' + score + "&id_emp=" + variables.id_emp + "&id_rub=" +variables.id_rub + "&id_usu=" +variables.id_usu,                    
							success: function(resp) {
								alert("Tu calificacion ha sido concretada.")                   
							}
		                });
					}
				});
				
				function getURLValues() {
					var search = window.location.search.replace(/^\?/,'').replace(/\+/g,' ');
					var values = {};
					
					if (search.length) {
					var part, parts = search.split('&');
					
						for (var i=0, iLen=parts.length; i<iLen; i++ ) {
						  part = parts[i].split('=');
						  values[part[0]] = window.decodeURIComponent(part[1]);
						}
					}
					return values;
				}
			
			});
			
		</script>
          
          
       </div>
</td></tr>
</table>

<script type="text/javascript">      
$('#score').raty({
  score: function() {
    return $(this).attr('data-rating');
  }
});</script>



       
<!--<div id="div_empresa">
<p id="p_empresa" >
     
	 <? 
	/*		
$row_rsEmpresas['Descripcion_Emp'] = str_replace("\n", "<br>", $row_rsEmpresas['Descripcion_Emp']);
	echo utf8_encode($row_rsEmpresas['Descripcion_Emp']);
*/	?>
     </div>-->
     <div id="descripcion_empresa">

 <p align="justify"><? $row_rsEmpresas['Descripcion_Emp'] = str_replace("\n", "<br>", $row_rsEmpresas['Descripcion_Emp']);
 echo utf8_encode($row_rsEmpresas['Descripcion_Emp']);?></p>
</div>
      
         </div>
    <? if($row_rsEmpresas['Ciudad_Emp']!=NULL){?> 
    
     <table width="50%" cellpadding="3" cellspacing="3" border="0" align="center" id="contacto_empresa">
     <tr><td colspan="2"><h2 id="Datos_Empresa">Datos De contacto</h2></td></tr>
     <tr><td colspan="2">&nbsp;</td></tr>
     <tr><td width="20%">Ciudad : </td><td align="left"><p><?  echo utf8_encode($row_rsEmpresas['Ciudad_Emp']);?></p></td></tr>
     <tr><td width="20%">Dirección : </td><td align="left"><p><?  echo utf8_encode($row_rsEmpresas['Direccion_Emp']);?></p></td></tr>
     <tr><td width="20%">Teléfono : </td><td align="left"><p><?  echo utf8_encode($row_rsEmpresas['Telefono_Emp']);?></p></td></tr>
     <tr><td width="20%">Correo : </td><td align="left"><p><?  echo utf8_encode($row_rsEmpresas['Correo_Emp']);?></p></td></tr>
     </table>
     <? }?>
 

</div>

   
 </div> 
 
   <div  class="lateral">
        <? include('../include/lateral.php');?>
           </div>
           
            <div id="div_nombre_cat"></div>
      
        <div id="div_nombre_cat2"><table width="auto" height="100%" cellpadding="4" cellspacing="0" border="0"><tr><td><text id="text_style">Categoría de Rubro:&nbsp;</text><i><text id="tipo_letra"><a id="href_styles" href="#"><? echo utf8_encode($row_rsEmpresas['Nombre_Rubro']);?> </a> </text></i></td></tr></table>
         </div>
    </div>
   <? include('../include/pie_pagina.php')?>
   
</body>
</html>