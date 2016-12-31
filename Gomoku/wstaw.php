<?PHP session_start();
$plansza=$_REQUEST['plansza'];
$gra=$_REQUEST['gra'];
if ($gra==true){
$otworz = fopen("txt/".$_SESSION['plik'],"a+");
file_put_contents("txt/".$_SESSION['plik'],"");
fwrite($otworz,$plansza);
fclose($otworz);
}
?>