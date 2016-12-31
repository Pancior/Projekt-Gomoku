<?PHP
session_start();
require_once "laczzbaza.php";
 ?>
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
<title>Zadanie 4 php</title>
</head>
<?PHP
$uzytkownik="";
$haslo="";
function wyslijLog($log)
{
$open = fopen("log.txt","a+");
fwrite($open,date('Y/m/d H:i:s')." ".$log.PHP_EOL);
fclose($open);
}
if (isset($_POST['Loguj'])) {
echo '<meta http-equiv="refresh" content="0; URL=index.php">';
}
if (isset($_POST['Rejestruj'])) {
$uzytkownik=$_POST['login'];
$haslo=md5($_POST['pwd']);
$str="INSERT INTO users (ID_USER, LOGIN, PWD, WIN, LOST, ACTIVE ) VALUES ('','".$uzytkownik."','".$haslo."','0','0','0');";
if(mysql_num_rows(mysql_query("SELECT * FROM users WHERE LOGIN = '$uzytkownik' AND PWD = '$haslo'"))==0){
echo mysql_num_rows(mysql_query("SELECT * FROM users WHERE LOGIN = '$uzytkownik' AND PWD = '$haslo';"));
if(mysql_query($str)==1){

	echo '<center> Użytkownik został zarejestrowany!</center>';
}else
{

echo 'Błąd rejestracji '.mysql_error();
}
}else{
echo mysql_num_rows(mysql_query("SELECT * FROM users WHERE LOGIN = '$uzytkownik' AND PWD = '$haslo';"));
echo 'Użytkownik istnieje! '.mysql_error();
}
}
?>
<body bgcolor="#f5fede">
<center>
<img src='images/logorejestruj.png' id='logo'>
<FORM name ="log" method ="post">
Nazwa użytkownika<br>
<input class="textbox" type="text" name="login" value="nazwa"><br>
Hasło<br>
<input class="textbox" type="password" name="pwd" value="hasło"><br>
<Input id="btn" type = "Submit" Name = "Rejestruj" VALUE = "Zarejestruj się!"><Input id="btn" type = "Submit" Name = "Loguj" VALUE = "Przejdź do logowania!"><br>
</FORM>
</center>
</body>
</html>