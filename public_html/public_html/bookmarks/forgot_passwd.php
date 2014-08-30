<?
 require_once("bookmark_fns.php");
 do_html_header("Recuperar Contraseña");

 if ($password=reset_password($username))
 {
    if (notify_password($username, $password))
      echo "Tu nueva Contraseña ha sido enviada a tu dirección email.";
    else
      echo "Tu contraseña no ha podiso ser enviada por email."
           ." Prueba pulsando actualizar.";
 }
 else
   echo "Tu contraseña no ha podido modificarse - Prueba de nuevo más tarde por favor.";

  do_html_url("login.php", "Login");

 do_html_footer();
?>