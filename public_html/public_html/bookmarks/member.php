<?

// include function files for this application
require_once("bookmark_fns.php");
session_start();

if ($username && $passwd)
// they have just tried logging in
{
    if (login($username, $passwd))
    {
      // if they are in the database register the user id
      $valid_user = $username;
      session_register("valid_user");
    }
    else
    {
      // unsuccessful login
      do_html_header("Problema:");
      echo "No has podido hacer logged in.
            Debes estar logged in para ver esta página.";
      do_html_url("login.php", "Login");
      do_html_footer();
      exit;
    }
}

do_html_header("Inicio");
check_valid_user();
// get the bookmarks this user has saved
if ($url_array = get_user_urls($valid_user));
  display_user_urls($url_array);

// give menu of options
display_user_menu();

do_html_footer();

?>