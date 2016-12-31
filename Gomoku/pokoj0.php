<?php session_start();;
require_once "laczzbaza.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<style>
#sel{ position: absolute; left: 50%; top: 35%; width: 30%; text-align: center; height: 30%;  }
#rozmowaGlowna { position: absolute; left: 50%; top: 35%; width: 30%; margin-left:-30%; height: 30%;  }
#doWiad{ position: absolute; top:65%; left:50%; margin-left:-40%;width:50%; }
#grajbtn{ position: absolute; top:32%; left:50%; width:30%; }
#wylogujbtn{ position: absolute; top:65%; left:50%; width:30%; }
#wiad{ width:51%; }
#twojLogin{ position: absolute; top:26%; left:50%;width:30%; text-align: center; }
#twojeWygrane{ position: absolute; left: 50%; top: 29%; width: 15%; text-align: center;  }
#twojePrzegrane{ position: absolute; left: 65%; top: 29%; width: 15%; text-align: center;  }
#logo{ position: absolute; left: 50%; top: 3%; margin-left:-31%;  }
#oczekuje{ position: absolute; top:67%; left:50%; margin-left:-37%;width:55%; }
#oczekuje2{ position: absolute; top:67%; left:50%; margin-left:-42%;width:55%; }
#btng { position: relative; top:45px; width:27%; }
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
.btn {
color: white;
background-color: #6f8b6a;
padding: 5px 5px 5px 5px;
border: 2px solid #5d745a;
border-radius: 5px;
box-shadow: 0 1px 1px #CCC inset, 0 1px 0 #FFF;
}

.btn:focus {
color: black;
background-color: #FFF;
border-color: #5d745a;
outline: none;
box-shadow: 0 0 0 1px #E8C291 inset;
}


</style>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-2" /></meta>
<title>Gomoku</title>
<?php
echo "<img src='images/logo.png' id='logo'>";
$zalogowany=false;
$id=0;
$uzytkownik="";
$wiersze=array();
$_SESSION['plik']="";
function aktywuj()
{
$uzytkownik=$_SESSION['uzytkownik'];
if(mysql_query("UPDATE `users` SET ACTIVE = '1' WHERE LOGIN='$uzytkownik'")==1){
} else echo "Błąd w aktywacji!".mysql_error();
}

function dezaktywuj()
{
$uzytkownik=$_SESSION['uzytkownik'];
if(mysql_query("UPDATE `users` SET ACTIVE = '0' WHERE LOGIN='$uzytkownik'")==1){

return 1;
}else echo "Błąd w dezaktywacji!".mysql_error()."uz".$uzytkownik;
}
function zapisz($msg)
{
$jestem=0;
$otworz = fopen("ruch.txt","a+");
fwrite($otworz,date('Y/m/d H:i:s')." ".$_SESSION['uzytkownik'].$msg.PHP_EOL);
fclose($otworz);
}

function wyslijLog($log)
{
$open = fopen("log.txt","a+");
fwrite($open,date('Y/m/d H:i:s')." ".$log.PHP_EOL);
fclose($open);
}
if (isset($_POST['Wyloguj'])) {

if (dezaktywuj()==1){
zapisz(" został wylogowany");
$_SESSION['uzytkownik'] = "";
$_SESSION['auth'] = false;
$zalogowany=false;
session_destroy();
echo '<meta http-equiv="refresh" content="0; URL=index.php">';
echo '<center> Następuje przekierowanie na strone Logowanie2.php</center>';

}
}

if (isset($_SESSION['auth'])){
global $uzytkownik;
if ($_SESSION['auth'] == TRUE) {
			$uzytkownik=$_SESSION['uzytkownik'];
			$zalogowany=true;
            aktywuj();
			zapisz(" został zalogowany");
			$otworz = fopen("txt/".$uzytkownik.".txt","a+");
			fwrite($otworz,"");
			fclose($otworz);
			echo "<input class='textbox' id='twojLogin' type='text' value='Jesteś zalogowany jako $uzytkownik!' disabled>";
			echo '<div id="info" style="display: none;">Jesteś zalogowany jako <p id="nazwaUzytkownika">'.$_SESSION['uzytkownik'].'</p>!</div><br>';
			$otworz = fopen("txt/rozmowaGlowna.txt","a+");
			fwrite($otworz,$_SESSION['uzytkownik']." wszedł do pokoju! ".PHP_EOL);
			fclose($otworz);
			$zapytanie=mysql_query("SELECT WIN FROM `users` WHERE LOGIN='$uzytkownik';");
			$index = 0;
			while($wiersz = mysql_fetch_assoc($zapytanie)) 
				{	
					$wiersze[$index] = $wiersz;
					$index++;
				}
				echo "<input class='textbox' id='twojeWygrane' type='text' value='Wygranych {$wiersze[0]['WIN']}' disabled>";
				
			$index = 0;
			$zapytanie=mysql_query("SELECT LOST FROM `users` WHERE LOGIN='$uzytkownik';");
			while($wiersz = mysql_fetch_assoc($zapytanie)) 
				{	
					$wiersze[$index] = $wiersz;
					$index++;
				}
				echo "<input class='textbox' id='twojePrzegrane' type='text' value='Przegranych {$wiersze[0]['LOST']}' disabled>";
				
      }
      else {
			  
              echo '<meta http-equiv="refresh" content="0; URL=index.php">';
			  echo "Nie jesteś zalogowany!";
      
      }}
	  else {
			  
              echo '<meta http-equiv="refresh" content="0; URL=index.php">';
			  echo "Nie jesteś zalogowany! Nastąpi przekierowanie do strony logowanie2.php";
      
      }

?>
<script>
var oczekuje=false;
var chat=0;
var poprzedni="";
var usr="";
var przeciwnik="";
var poprzedniPrzeciwnik="";
var zapytanie=0;
var oczekuje=false;
var txtprzeciwnika="";
var coKtoGdzie=[];
var inicjator;
var mojRandom = unikalneId();
var jegoRandom=0;
var poprzedniaRozmowa="";
uzytkownik=document.getElementById("nazwaUzytkownika").innerHTML;
setInterval(function() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            if (ajax.responseText != poprzedni) {          
               if(<?PHP echo $zalogowany ?>==true)
               {
                poprzedni = ajax.responseText;
				zwrPHP("aktywni.php",0);				 
            }                            
            }              
        }
    };

    ajax.open("POST", "ruch.txt", true);
    ajax.send();
}, 111);
function unikalneId()
{
    var text = "";
    var mozliwosc = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 10; i++ )
        text += mozliwosc.charAt(Math.floor(Math.random() * mozliwosc.length));

    return text;
}
setInterval(function() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {

	if (zapytanie==0){
        if (ajax.readyState == 4) {
            if (ajax.responseText != poprzedniPrzeciwnik) {          
               if(<?PHP echo $zalogowany ?>==true)
               {
			   	zapytanie=1;        
                poprzedniPrzeciwnik = ajax.responseText;
document.getElementById("oczekuje").innerHTML="<input class='textbox' id='oczekuje' type='text' value='Gracz "+inicjator+" chce z Tobą zagrać, zgadzasz się?' disabled><br>"				
document.getElementById("oczekuje2").innerHTML+='<button class="btn" id="btng" type="button" onClick="gram()">Gram!</button>';
document.getElementById("oczekuje2").innerHTML+='<button class="btn" id="btng" type="button" onClick="niegram()">Nie gram!</button>';


            }                            
            }              
        }
		}
    };
	if (zapytanie==0){
    ajax.open("POST", "txt/"+uzytkownik+".txt", true);
    ajax.send();
	}
}, 311);
setInterval(function() {
	nazwaPrzeciwnika();
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
	if (oczekuje==true){
        if (ajax.readyState == 4) {
            if (ajax.responseText != txtprzeciwnika) {          
               if(<?PHP echo $zalogowany ?>==true)
               {
			       
                txtprzeciwnika = ajax.responseText;
				
			if (ajax.responseText==mojRandom+":"+uzytkownik+":t"){
			 
			
			czysc(1,1,1,przeciwnik,0);
			}else{
			
			czysc(0,1,0,przeciwnik,0);
			}

            }                            
            }              
        }
		}
    };
	if (oczekuje==true){
    ajax.open("POST", "txt/"+przeciwnik+".txt", true);
    ajax.send();
	}
}, 111);

setInterval(function() {

    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            if (ajax.responseText != poprzedniaRozmowa) {          
               if(<?PHP echo $zalogowany ?>==true)
               {
			       
                poprzedniaRozmowa = ajax.responseText;
				document.getElementById("rozmowaGlowna").innerHTML=ajax.responseText;
				document.getElementById("rozmowaGlowna").scrollTop=document.getElementById("rozmowaGlowna").scrollHeight;
            }                            
            }              
        }
		
    };

    ajax.open("POST", "txt/rozmowaGlowna.txt", true);
    ajax.send();

}, 111);






function dezaktywuj(){
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

}
}
xmlhttp.open("GET", "dezaktywuj.php?uzytkownik="+uzytkownik, true);
xmlhttp.send();


}
function gram(){
wbr("t",1,uzytkownik);
nazwaPrzeciwnika();
czysc(1,0,1,inicjator,1);
}
function niegram(){
wbr("n",1,uzytkownik);
czysc(0,0,0,inicjator,1);
}
function nazwaPrzeciwnika(){
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
inicjator2=xmlhttp.responseText.split(":");
inicjator=inicjator2[1];
jegoRandom=inicjator2[0];

}
}
xmlhttp.open("GET", "nazwa.php?uzytkownik="+uzytkownik, true);
xmlhttp.send();
}
function czysc(x,y,z,p,kto){

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

if (x==0) location.reload();
if (x==1) window.location.href = "plansza.php";
}
}
if (kto==1){
xmlhttp.open("GET", "czysc.php?uzytkownik="+uzytkownik+"&akcja="+y+"&gramy="+z+"&przeciwnik="+p+"&kto="+kto+"&rnd="+jegoRandom, true);
}else{
xmlhttp.open("GET", "czysc.php?uzytkownik="+uzytkownik+"&akcja="+y+"&gramy="+z+"&przeciwnik="+p+"&kto="+kto+"&rnd="+mojRandom, true);
}
xmlhttp.send();

}

function zwrPHP(plik,akcja)
{
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
wiersze=JSON.parse(xmlhttp.responseText);
if (akcja==0){
czyscSel();
czyscSel();
for (i=0;i<wiersze.length;i++)
{
wypSel(wiersze[i]['LOGIN']);
}
}
}
}
xmlhttp.open("GET", plik, true);
xmlhttp.send();

}
function wypSel(obj){
jest=0;
elem = document.getElementById("sel");
dl = elem.options.length;
for (i = 0; i < dl; i++) {
  if (elem.options[i].text==obj) jest=1;
}
if (jest==0){
opcja = document.createElement("option");
opcja.text = obj;
opcja.id=obj;
opcja.value=obj;
elem.add(opcja);
document.getElementById(obj).addEventListener("click", function() {if ((this.id!=document.getElementById("nazwaUzytkownika").innerHTML)&&(this.id!="")) przeciwnik=this.id;});
}
}
function czyscSel(){
elem = document.getElementById("sel");
dl = elem.options.length;
for (i = 0; i < dl; i++) {
  elem.options[i] = null;
}
}
function wyslijZapytanie(){
if (przeciwnik!=""){
if (oczekuje==false){
uzytkownik=document.getElementById("nazwaUzytkownika").innerHTML;

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
txtprzeciwnika=mojRandom+":"+uzytkownik+":";
oczekuje=true;
document.getElementById("oczekuje").innerHTML="<input class='textbox' id='oczekuje' type='text' value='Oczekuję na decyzję gracza "+przeciwnik+"' disabled><br>"

}
}
xmlhttp.open("GET", "akceptacja.php?uzytkownik="+uzytkownik+"&przeciwnik="+przeciwnik+"&rnd="+mojRandom, true);
xmlhttp.send();
}else if (oczekuje==true){


}
}
}
function wbr(x,zwr,uzy){
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
coKtoGdzie=xmlhttp.responseText.split(":");
return 1;
}
}
xmlhttp.open("GET", "wbr.php?uzytkownik="+uzy+"&wbr="+x+"&zwr="+zwr, true);
xmlhttp.send();
}

function wyslijWiadomosc(){
wiad=document.getElementById("wiad").value;
//alert(wiad);
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
//alert(xmlhttp.responseText);
}
}
xmlhttp.open("GET", "wyslijwiadomosc.php?uzytkownik="+uzytkownik+"&plik=rozmowaGlowna.txt&wiad="+wiad, true);
xmlhttp.send();
}

</script>
</head>

<body bgcolor="#f5fede">
<center>

<FORM name ="Wyloguj" method ="post">
<Input class='btn' id="wylogujbtn" type = "Submit" Name = "Wyloguj" VALUE = "Wyloguj mnie!"><br>
</FORM>
<button class='btn' id="grajbtn" type="button" onClick="wyslijZapytanie()">Wybierz gracza z listy i graj!</button>
<select id='sel' class='textbox'  size='20' >
</select>
<div id="oczekuje"></div>
<div id="oczekuje2"></div>
<textarea id="rozmowaGlowna" class="textbox" disabled >
</textarea>
<div id="doWiad">
<button class='btn' id="wwiad" type='button' onclick='wyslijWiadomosc()'>Wyślij!</button>
<input class='textbox' id='wiad' type='text' value='Wiadomosc'><br>
</div>
</center>
</body>
</html>