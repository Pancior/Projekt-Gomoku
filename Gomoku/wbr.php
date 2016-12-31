<?PHP
$zwr=$_REQUEST['zwr'];
$uzytkownik=$_REQUEST['uzytkownik'];
$wbr=$_REQUEST['wbr'];
if ($zwr==1){
$otworz = fopen("txt/".$uzytkownik.".txt","a+");
fwrite($otworz,$wbr);
fclose($otworz);
}
$otworz = fopen("txt/".$uzytkownik.".txt","r+");
echo fgets($otworz);
fclose($otworz);
?>