<?PHP 
require_once "laczzbaza.php";
$wiersze=array();
$zapytanie=mysql_query("SELECT LOGIN FROM `users` WHERE ACTIVE=1;");
$index = 0;
while($wiersz = mysql_fetch_assoc($zapytanie)) 
{
     $wiersze[$index] = $wiersz;
     $index++;
}

echo mysql_error();
echo json_encode($wiersze);

?>