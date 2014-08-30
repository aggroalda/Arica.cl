<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cnx_arica = "localhost";
$database_cnx_arica = "aricacl_bd";
$username_cnx_arica = "aricacl_userx";
$password_cnx_arica = "!arica123";
$cnx_arica = mysql_pconnect($hostname_cnx_arica, $username_cnx_arica, $password_cnx_arica) or trigger_error(mysql_error(),E_USER_ERROR); 
?>