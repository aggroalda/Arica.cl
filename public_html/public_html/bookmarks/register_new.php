<?
   // include function files for this application
   require_once("bookmark_fns.php");


   // start session which may be needed later
   // start it now because it must go before headers
   session_start();


   // check forms filled in
   if (!filled_out($HTTP_POST_VARS))
   {
      do_html_header("Problema:");
      echo "No has cubierto el formulario correctametne - Por favor vuelve"
           ." e inténtalo de nuevo.";
      do_html_footer();
      exit;
   }

   // email address not valid
   if (!valid_email($email))
   {
      do_html_header("Problema:");
      echo "No es una dirección email válida.  Por favor vuelve "
           ." e inténtalo de nuevo.";
      do_html_footer();
      exit;
   }

   // passwords not the same
   if ($passwd != $passwd2)
   {
      do_html_heading("Problema:");
      echo "La contraseña que has entrado no concuerda - por favor vuelve"
           ." e inténtalo de nuevo.";
      do_html_footer();
      exit;
   }

   // check password length is ok
   // ok if username truncates, but passwords will get
   // munged if they are too long.
   if (strlen($passwd)<6 || strlen($passwd) >16)
   {
      do_html_header("Problema:");
      echo "Tu contraseña debe tener entre 6 y 16 caracteres."
           ."Por favor vuelve e inténtalo de nuevo.";
      do_html_footer();
      exit;
   }
   // attempt to register
   $reg_result = register($username, $email, $passwd);
   if ($reg_result == "true")
   {
     // register session variable
     $valid_user = $username;
     session_register("valid_user");

     // provide link to members page
     do_html_header("Registro correcto");
     echo "Tu registro se ha hecho correctamente.  ¡Vete a la página de miembros"
          ."para empezar a configurar tus marcadores!";
     do_HTML_URL("member.php", "Ir a la página de miembros");
   }
   else
   {
     // otherwise provide link back, tell them to try again
     do_html_header("Problema:");
     echo $reg_result;
     do_html_footer();
     exit;
   }

   // end page
   do_html_footer();

?>