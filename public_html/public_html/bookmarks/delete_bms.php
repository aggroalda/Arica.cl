<?
 require_once("bookmark_fns.php");
 session_start();
 do_html_header("Borrar Marcadores");
 check_valid_user();
 if (!filled_out($HTTP_POST_VARS))
 {
   echo "No has escrito ningún marcador para borrar.
         Prueba de nuevo por favor.";
   display_user_menu();
   do_html_footer();
   exit;
 }
 else
 {
    if (count($del_me) >0)
    {
      foreach($del_me as $url)
      {
         if (delete_bm($valid_user, $url))
           echo "Borrado ".htmlspecialchars($url).".<br>";
         else
           echo "No pudo borrarse ".htmlspecialchars($url).".<br>";
      }
    }
    else
      echo "No hay marcador seleccionado para borrarse";
 }

 // get the bookmarks this user has saved
 if ($url_array = get_user_urls($valid_user));
   display_user_urls($url_array);

 display_user_menu();
 do_html_footer();
?>