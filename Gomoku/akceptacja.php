<?PHP
$uzytkownik=$_REQUEST['uzytkownik'];
$przeciwnik=$_REQUEST['przeciwnik'];
$rnd=$_REQUEST['rnd'];
$otworz = fopen("txt/".$przeciwnik.".txt","a+");
fwrite($otworz,$rnd.":".$uzytkownik.":");
fclose($otworz);
?>