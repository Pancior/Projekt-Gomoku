<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
.textbox {
padding: 5px 5px 5px 5px;
border: 1px solid #CCC;
border-radius: 5px;
box-shadow: 0 1px 1px #CCC inset, 0 1px 0 #FFF;
}

.textbox:focus {
background-color: #FFF;
border-color: #E8C291;
outline: none;
box-shadow: 0 0 0 1px #E8C291 inset;
}
#btn {
color: white;
background-color: #6f8b6a;
padding: 5px 5px 5px 5px;
border: 2px solid #5d745a;
border-radius: 5px;
box-shadow: 0 1px 1px #CCC inset, 0 1px 0 #FFF;
}

#btn:focus {
color: black;
background-color: #FFF;
border-color: #5d745a;
outline: none;
box-shadow: 0 0 0 1px #E8C291 inset;
}
</style>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-2" /></meta>
</head>
<?PHP

$nazwaServera="";
$nazwaUzytkownika="";
$haslo="";
if (isset($_POST['tworzBaze'])){

$nazwaServera=$_POST['nazwaServera'];
$nazwaUzytkownika=$_POST['nazwUzytkownika'];
$haslo=$_POST['haslo'];
$dane="$nazwaServera:$nazwaUzytkownika:$haslo";
$dane=base64_encode($dane);
$otworz = fopen("txt/624ccfffffc4caa4727b1f4473194a47.txt","a+");
fwrite($otworz,$dane);
$conn = new mysqli($nazwaServera, $nazwaUzytkownika, $haslo);
if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error. "<br>");
} 
$str = "CREATE DATABASE IF NOT EXISTS Gomoku ";
if ($conn->query($str) === TRUE) {
$conn = new mysqli($nazwaServera, $nazwaUzytkownika, $haslo,"Gomoku");
$str=" CREATE TABLE IF NOT EXISTS `USERS` (
      `ID_USER` smallint(6) NOT NULL AUTO_INCREMENT,
      `LOGIN` varchar(128) COLLATE utf8_polish_ci NOT NULL,
      `PWD` varchar(128) COLLATE utf8_polish_ci NOT NULL,
	  `WIN` INT NOT NULL,
	  `LOST` INT NOT NULL,
	  `ACTIVE` INT NOT NULL,
      PRIMARY KEY (`id_user`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2;";
	if ($conn->query($str) === TRUE) {
	echo '<meta http-equiv="refresh" content="3; URL=index.php">';
	echo '<center><div style="width:100%; height:100%; margin:0; padding:0;  background-color: yellow; color:red" ;="">Tworzenie bazy powiodło się! Nastąpi przekierowanie do logowania :)</div></center><br>';
	}
}
}
?>
<body bgcolor="#f5fede">
<center>

<img src='images/logoinstalacja.png' id='logo'>
<div class="textbox" style="width:200px">
Pierwsze uruchomienie, wypełnij poniższe pola by stworzyć potrzebną bazę danych Gomoku.
</div>
<FORM name ="log" method ="post">
Adres servera<br>
<input class="textbox" type="text" name="nazwaServera" value="localhost"><br>
Nazwa użytkownika<br>
<input class="textbox" type="text" name="nazwUzytkownika" value="root"><br>
Hasło<br>
<input class="textbox" type="password" name="haslo" value=""><br>
<Input id="btn" type = "Submit" Name = "tworzBaze" VALUE = "Twórz bazę!!"><br><br>
</FORM>
</center>
</body>
</html>