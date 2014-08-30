<?

function db_connect()
{
   $result = mysql_pconnect("mysql5.000webhost.com", "a3188071_bookmar", "adrian2890a");
   if (!$result)
      return false;
   if (!mysql_select_db("a3188071_bookmar"))
      return false;

   return $result;
}

?>