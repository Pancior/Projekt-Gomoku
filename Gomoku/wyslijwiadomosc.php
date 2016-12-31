<?PHP
$plik=$_REQUEST['plik'];
$wiadomosc=$_REQUEST['wiad'];
$uzytkownik=$_REQUEST['uzytkownik'];
$otworz = fopen("txt/$plik","a+");
fwrite($otworz,$uzytkownik." : ".$wiadomosc.PHP_EOL);
fclose($otworz);
?>