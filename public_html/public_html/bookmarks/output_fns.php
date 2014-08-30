<?
$email = $_POST['email'];
$username = $_POST['username'];
$passwd = $_POST['passwd'];
$passwd2 = $_POST['passwd2'];

function do_html_header($title)
{
  // print an HTML header
?>
  <html>
  <head>
    <title><?=$title?></title>
    <style>
      body { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      li, td { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      hr { color: #3333cc; width=300; text-align=left}
      a { color: #000000 }
    </style>
  </head>
  <body>
  <img src="marcador.gif" alt="PHPbookmark logo" border=0
       align=left valign=bottom height = 50 width = 150>
  <h1>&nbsp;CompartElinks</h1>
  <hr>
<?
  if($title)
    do_html_heading($title);
}

function do_html_footer()
{
  // print an HTML footer
?>
  </body>
  </html>
<?
}

function do_html_heading($heading)
{
  // print heading
?>
  <h2><?=$heading?></h2>
<?
}

function do_html_URL($url, $name)
{
  // output URL as link and br
?>
  <br><a href="<?=$url?>"><?=$name?></a><br>
<?
}

function display_site_info()
{
  // display some marketing info
?>
  <ul>
  <li>¡Almacena tus marcadores online con nosotros!
  <li>¡Conoce los que usan otros usuarios!
  <li>¡Comparte tus enlaces favoritos con otros!
  </ul>
<?
}

function display_login_form()
{
?>
  <a href="register_form.php">¿No eres un miembro aún?</a>
  <form method="post" action="member.php">
  <table bgcolor=#cccccc>
   <tr>
     <td colspan=2>Miembros identificarse aquí:</td>
   <tr>
     <td>Nombre Usuario:</td>
     <td><input type="text" name="username"></td></tr>
   <tr>
     <td>Contraseña:</td>
     <td><input type="password" name="passwd"></td></tr>
   <tr>
     <td colspan=2 align=center>
     <input type="submit" value="Log in"></td></tr>
   <tr>
     <td colspan=2><a href="forgot_form.php">¿Olvidastes tu Contraseña?</a></td>
   </tr>
 </table></form>
<?
}

function display_registration_form()
{
?>
 <form method=post action="register_new.php">
 <table bgcolor=#cccccc>
   <tr>
     <td>Dirección email:</td>
     <td><input type="text" name="email" size="30" maxlength="100"></td></tr>
   <tr>
     <td>Nombre usuario preferido <br>(max 16 caract):</td>
     <td valign=top><input type="text" name="username"
                     size="16" maxlength="16"></td></tr>
   <tr>
     <td>Contraseña <br>(entre 6 y 16 caract):</td>
     <td valign=top><input type="password" name="passwd"
                     size="16" maxlength="16"></td></tr>
   <tr>
     <td>Confirmar contraseña:</td>
     <td><input type="password" name="passwd2" size="16" maxlength="16"></td></tr>
   <tr>
     <td colspan=2 align=center>
     <input type="submit" value="Register"></td></tr>
 </table></form>
<?

}


function display_user_urls($url_array)
{
  //display the table of URLs

  // set global variable, so we can test later if this is on the page
  global $bm_table;
  $bm_table = true;
?>
  <br>
  <form name=bm_table action="delete_bms.php" method=post>
  <table width=300 cellpadding=2 cellspacing=0>
  <?
  $color = "#cccccc";
  echo "<tr bgcolor=$color><td><strong>Marcador</strong></td>";
  echo "<td><strong>¿Borrar?</strong></td></tr>";
  if (is_array($url_array) && count($url_array)>0)
  {
    foreach ($url_array as $url)
    {
      if ($color == "#cccccc")
        $color = "#ffffff";
      else
        $color = "#cccccc";
      // remember to call htmlspecialchars() when we are displaying user data
      echo "<tr bgcolor=$color><td><a href=\"$url\">".htmlspecialchars($url)."</a></td>";
      echo "<td><input type=checkbox name=\"del_me[]\"
             value=\"$url\"></td>";
      echo "</tr>";
    }
  }
  else
    echo "<tr><td>No hay marcadores guardados</td></tr>";
?>
  </table>
  </form>
<?
}

function display_user_menu()
{
  // display the menu options on this page
?>
<hr>
<a href="member.php">Inicio</a> &nbsp;|&nbsp;
<a href="add_bm_form.php">Ad.EN</a> &nbsp;|&nbsp;
<?
  // only offer the delete option if bookmark table is on this page
  global $bm_table;
  if($bm_table==true)
    echo "<a href='#' onClick='bm_table.submit();'>Borrar EN</a>&nbsp;|&nbsp;";
  else
    echo "<font color='#cccccc'>Borrar EN</font>&nbsp;|&nbsp;";
?>
<a href="change_passwd_form.php">Cambiar contraseña</a>
<br>
<a href="recommend.php">Recomendarme URLs</a> &nbsp;|&nbsp;
<a href="logout.php">Logout</a>
<hr>

<?
}

function display_add_bm_form()
{
  // display the form for people to ener a new bookmark in
?>
<form name=bm_table action="add_bms.php" method=post>
<table width=250 cellpadding=2 cellspacing=0 bgcolor=#cccccc>
<tr><td>Nuevo EN:</td><td><input type=text name=new_url  value="http://"
                        size=30 maxlength=255></td></tr>
<tr><td colspan=2 align=center><input type=submit value="Añadir marcador"></td></tr>
</table>
</form>
<?
}

function display_password_form()
{
  // display html change password form
?>
   <br>
   <form action="change_passwd.php" method=post>
   <table width=250 cellpadding=2 cellspacing=0 bgcolor=#cccccc>
   <tr><td>Vieja Contraseña:</td>
       <td><input type=password name=old_passwd size=16 maxlength=16></td>
   </tr>
   <tr><td>Nueva Contraseña:</td>
       <td><input type=password name=new_passwd size=16 maxlength=16></td>
   </tr>
   <tr><td>Repite Nueva Contraseña:</td>
       <td><input type=password name=new_passwd2 size=16 maxlength=16></td>
   </tr>
   <tr><td colspan=2 align=center><input type=submit value="Cambiar Contraseña">
   </td></tr>
   </table>
   <br>
<?
};

function display_forgot_form()
{
  // display HTML form to reset and email password
?>
   <br>
   <form action="forgot_passwd.php" method=post>
   <table width=250 cellpadding=2 cellspacing=0 bgcolor=#cccccc>
   <tr><td>Escribe tu nombre de usuario</td>
       <td><input type=text name=username size=16 maxlength=16></td>
   </tr>
   <tr><td colspan=2 align=center><input type=submit value="Change password">
   </td></tr>
   </table>
   <br>
<?
};

function display_recommended_urls($url_array)
{
  // similar output to display_user_urls
  // instead of displaying the users bookmarks, display recomendation
?>
  <br>
  <table width=300 cellpadding=2 cellspacing=0>
<?
  $color = "#cccccc";
  echo "<tr bgcolor=$color><td><strong>Recomendaciones</strong></td></tr>";
  if (is_array($url_array) && count($url_array)>0)
  {
    foreach ($url_array as $url)
    {
      if ($color == "#cccccc")
        $color = "#ffffff";
      else
        $color = "#cccccc";
      echo "<tr bgcolor=$color><td><a href=\"$url\">".htmlspecialchars($url)."</a></td></tr>";
    }
  }
  else
    echo "<tr><td>No hay recomendaciones para ti de momento.</td></tr>";
?>
  </table>
<?
};

?>