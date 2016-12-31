<?PHP
$wygrany=$_REQUEST['wygrany'];
$przegrany=$_REQUEST['przegrany'];
$pliczek=$_REQUEST['plik'];

$otworz = fopen("txt/log-".$pliczek.".txt","a+");
fwrite($otworz,$wygrany.":".$przegrany);
fclose($otworz);
echo "<div> ddasodjasodjasodj </div>";
?>