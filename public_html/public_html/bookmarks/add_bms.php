<?
 require_once("bookmark_fns.php");
 session_start();
 do_html_header("Añadir Marcadores");
 check_valid_user();
 if (!filled_out($HTTP_POST_VARS))
 {
   echo "No has cubierto el formulario completamente.
         Prueba de nuevo por favor.";
   display_user_menu();
   do_html_footer();
   exit;
 }
 else
 {
   // check URL format
   if (strstr($new_url, "http://")===false)
      $new_url = "http://".$new_url;

   // check URL is valid
   if (@fopen($new_url, "r"))
   {
     // try to add bm
     if (add_bm($new_url))
       echo "Marcador añadido.";
     else
       echo "No se ha podido añadir marcador.";
   }
   else
     echo "No es un URL válido.";
 }

  // get the bookmarks this user has saved
  if ($url_array = get_user_urls($valid_user));
    display_user_urls($url_array);


   display_user_menu();
   do_html_footer();
?>