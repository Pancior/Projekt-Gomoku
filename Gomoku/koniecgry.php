<?PHP session_start();
require_once "laczzbaza.php";
$wygrany=$_REQUEST['wygrany'];
$przegrany=$_REQUEST['przegrany'];
$plik=$_REQUEST['plik'];
if(mysql_query("UPDATE `users` SET WIN = WIN + 1 WHERE LOGIN='$wygrany'")==1){
} else echo "B��d w dodaniu warto�ci !".mysql_error();
 if(mysql_query("UPDATE `users` SET LOST = LOST + 1 WHERE LOGIN='$przegrany'")==1){
} else echo "B��d w dodaniu warto�ci !".mysql_error();
echo "L    ".$plik;
$otworz = fopen("txt/txt-".$plik.".txt","a+");
fwrite($otworz,"Wygrywa gracz $wygrany a przegrywa $przegrany! Brawa dla zawodnik�w! :)");
fclose($otworz);

?>