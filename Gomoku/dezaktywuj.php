<?PHP
require_once "laczzbaza.php";
$uzytkownik=$_REQUEST['uzytkownik'];
if(mysql_query("UPDATE `users` SET ACTIVE = '0' WHERE LOGIN='$uzytkownik'")==1){
echo "OK";
} else echo "B³¹d w aktywacji!".mysql_error();

?>