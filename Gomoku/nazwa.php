<?PHP

$uzytkownik=$_REQUEST['uzytkownik'];

$otworz = fopen("txt/".$uzytkownik.".txt","r+");
echo fgets($otworz);
fclose($otworz);
?>