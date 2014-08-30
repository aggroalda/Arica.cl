<?   

session_start();
$_SESSION['MM_arica_cli'] = NULL;
  //  $_SESSION['MM_UserGroup_cli'] = NULL;
//	$_SESSION['MM_IdUser_cli'] = NULL;
	$_SESSION['MM_IdPersona'] = NULL;
//	$_SESSION['MM_IdNivel'] = NULL;
 unset($_SESSION['MM_arica_cli']);
 // unset($_SESSION['MM_UserGroup_cli']);
 // unset($_SESSION['MM_IdUser_cli']);
   unset($_SESSION['MM_IdPersona']);
   // unset($_SESSION['MM_IdNivel']);



session_destroy();



	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
  
  ?>