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