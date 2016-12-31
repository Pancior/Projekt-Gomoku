<?PHP session_start();
require_once "laczzbaza.php";
$uzytkownik=$_REQUEST['uzytkownik'];
$akcja=$_REQUEST['akcja'];
$gramy=$_REQUEST['gramy'];
$rnd=$_REQUEST['rnd'];
$kto=$_REQUEST['kto'];
$przeciwnik=$_REQUEST['przeciwnik'];
if ($akcja==1) file_put_contents("txt/".$przeciwnik.".txt","");
if ($gramy==1){
 $_SESSION['przeciwnik'] = $przeciwnik;
 if(mysql_query("UPDATE `users` SET ACTIVE = '0' WHERE LOGIN='$uzytkownik'")==1){
} else echo "Błąd w aktywacji!".mysql_error();
if ($kto==0){ $_SESSION['plik'] = $rnd."-".date('Y-m-d')."-gra-".$uzytkownik."-".$przeciwnik.".txt"; $_SESSION['kolor']="czarny"; }
if ($kto==1){ $_SESSION['plik'] = $rnd."-".date('Y-m-d')."-gra-".$przeciwnik."-".$uzytkownik.".txt"; $_SESSION['kolor']="bialy"; }
}
$_SESSION['gra']="false";
 echo $przeciwnik;

?>