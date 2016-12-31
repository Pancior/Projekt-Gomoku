<?PHP
if (file_exists("txt/624ccfffffc4caa4727b1f4473194a47.txt")){
$otworz = fopen("txt/624ccfffffc4caa4727b1f4473194a47.txt","a+");
$dane=fgets($otworz);
fclose($otworz);
$dane=base64_decode($dane);

$dane=split(":",$dane);

$nazwaServera=$dane[0];
$nazwaUzytkownikaDB=$dane[1];
$hasloDB=$dane[2];

mysql_connect($nazwaServera,$nazwaUzytkownikaDB,$hasloDB);
mysql_select_db("gomoku") or die("B³¹d przy wyborze bazy danych");
}else{
header("Location: instalacja.php");
}
?>