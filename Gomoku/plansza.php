<?php session_start();
require_once "laczzbaza.php";
if (isset($_SESSION['gra'])){
if ($_SESSION['gra']=="true"){
$otworz = fopen("txt/txt-".$_SESSION['plik'],"a+");
fwrite($otworz,"Gracz ".$_SESSION['uzytkownik']." został wyrzucony!".PHP_EOL);
fclose($otworz);
 header("location: pokoj0.php");
}else{
$otworz = fopen("txt/txt-".$_SESSION['plik'],"a+");
fwrite($otworz,$_SESSION['uzytkownik'].": Cześć, właśnie dołączyłem do gry! :)".PHP_EOL);
fclose($otworz);
}
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

}
}



echo "<img src='images/logo.png' id='logo'>";
echo "<input class='textbox' id='twojLogin' type='text' value='Jesteś zalogowany jako ".$_SESSION['uzytkownik']."' disabled>";
echo "<input class='textbox' id='twojPrzeciwnik' type='text' value='Twój przeciwnik to ".$_SESSION['przeciwnik']."' disabled>";
echo "<input class='textbox' id='twojKolor' type='text' value='Twój kolor to ".$_SESSION['kolor']."' disabled>";
echo "<input class='textbox' id='czyj' type='text' value='' disabled>";
echo "<input class='textbox' id='sekundy' type='text' value='' disabled>";

$zalogowany=true;
$otworz = fopen("txt/".$_SESSION['plik'],"a+");
fwrite($otworz,"");
fclose($otworz);

echo "<div id='Ty' style='display: none;'>".$_SESSION['uzytkownik']."</div>";
echo "<div id='Przeciwnik' style='display: none;'>".$_SESSION['przeciwnik']."</div>";
echo "<div id='kolor' style='display: none;'>".$_SESSION['kolor']."</div>";
echo "<div id='nazwaPl' style='display: none;'>".$_SESSION['plik']."</div>";

$_SESSION['gra']=true;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
#logo{ position: absolute; left: 50%; top: 3%; margin-left:-31%; width:60%;  }
#twojLogin{ position: absolute; left: 50%; top: 35%; width: 30%; text-align: center;  }
#wylogujbtn{ position: absolute; left: 50%; top: 80%; width: 30%; text-align: center;  }
#twojPrzeciwnik{ position: absolute; left: 50%; top: 38%; width: 30%; text-align: center;  }
#twojKolor{ position: absolute; left: 50%; top: 44%; width: 15%; text-align: center;  }
#wyswiad{ position: absolute; left: 50%; top: 47%; width: 15%; text-align: center;  }
#wiad{ position: absolute; left: 50%; top: 50%; width: 30%; text-align: center;  }
#czyj{ position: absolute; left: 50%; top: 41%; width: 15%; text-align: center;  }
#sekundy{ position: absolute; left: 65%; top: 41%; width: 15%; text-align: center;height:9%; font-size: 35px; color: black;  }
.plansza td { padding:0; margin: 0; }
#rozmowaGlowna{ position: absolute; left: 50%; top: 53%; height:29%; width: 30%; resize: none;    }
#sel{ position: absolute; left: 50%; top: 35%; width: 30%; text-align: center; height: 30%;  }
.plansza{ background-color:#e9e9e9; position: absolute; left: 50%; top: 35%; margin-left:-32%; width:30%; height:39%;
padding: 0;
border: 1px solid #CCC;
border-radius: 5px;
box-shadow: 0 1px 1px #CCC inset, 0 1px 0 #FFF;
}
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
<style type="text/css">
.tg  {border-spacing:0; padding:-4; border:2px solid black;}

</style>
<script>
var plansza=[[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]]
var id=0.0;
var planszaPlik="";
var nazwaPlanszy=document.getElementById("nazwaPl").innerHTML;
var kolor=document.getElementById("kolor").innerHTML;
var ty=document.getElementById("Ty").innerHTML;
var przeciwnik=document.getElementById("Przeciwnik").innerHTML;
var ruch=0;
var gra=true;
var czyWyszedl="";
var rozpoczety=false;
var mojczas=0;
var iloscNaPlanszy=0;
var poprzedniaRozmowa="";
if (kolor=="czarny") {ruch=0}else{ruch=1};
window.onload = function what(){
if (ruch==0) document.getElementById("czyj").value="Twój ruch!";
if (ruch==1) document.getElementById("czyj").value="Ruch gracza "+przeciwnik;

};
var minutki = document.getElementById("minutes");
var sekundki = document.getElementById("sekundy");
var wsumieSekund = 0;
setInterval(ustawCzas, 1000);
setInterval(function() {

if ((ruch==1) && (gra==true)){
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

            if (ajax.responseText != String(planszaPlik)) {          
               if(<?PHP echo $zalogowany ?>==true)
               {
			
			   
                planszaPlik = ajax.responseText;
				zPlikuDoPlanszy(ajax.responseText.split(","));
				rozpoczety=true;
				mojczas=0;
				wsumieSekund=0;
				if (kolor=="czarny") czyKoniecOn("O");
				if (kolor=="bialy") czyKoniecOn("X"); 
				czyRemis();
				
			    ruch=0;
				if (gra==true)
			    document.getElementById("czyj").value="Twój ruch";
            }                            
            }              
        }
    };

    ajax.open("POST", "txt/"+nazwaPlanszy, true);
    ajax.send();

}}, 111);


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

    ajax.open("POST", "txt/txt-"+nazwaPlanszy, true);
    ajax.send();

}, 111);


function koniecWiad(wiad){
document.getElementById("czyj").value=wiad;
}
function wstaw(a,b){
if(plansza[a][b]=="0"){
if (gra==true){
if(ruch==0){
if ((a==11) && (b>=0) && (b<=4))
{
if (kolor=="czarny"){ document.getElementById(String(a)+String(b)+"x").src="images/czarny.png"; plansza[a][b]="X"; wstawDoPliku(); czyRemis(); czyKoniecJa("X");  }
if (kolor=="bialy") {document.getElementById(String(a)+String(b)+"x").src="images/bialy.png"; plansza[a][b]="O"; wstawDoPliku(); czyRemis(); czyKoniecJa("O");  }
}else{
if (kolor=="czarny"){ document.getElementById(String(a)+String(b)).src="images/czarny.png"; plansza[a][b]="X"; wstawDoPliku(); czyRemis(); czyKoniecJa("X");  }
if (kolor=="bialy") {document.getElementById(String(a)+String(b)).src="images/bialy.png"; plansza[a][b]="O"; wstawDoPliku(); czyRemis(); czyKoniecJa("O");  }

}



}
}
}
}
function sprse(){
str="";
for (i=0;i<14;i++)
{
for (j=0;j<14;j++)
{
str+=plansza[i][j];
}
}

}
function wstawDoPliku(){
czyRemis();
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

planszaPlik=plansza;
ruch=1;
wsumieSekund=0;
rozpoczety=true;
mojczas=1;

if (gra==true) document.getElementById("czyj").value="Ruch Twojego przeciwnika";
}
}
xmlhttp.open("GET", "wstaw.php?plansza="+plansza+"&gra="+gra, true);
xmlhttp.send();
}
function czyKoniecJa(znak){
for (i=0;i<=14;i++){
for (j=0;j<=14;j++){
if (j<=10) if ((plansza[i][j]==znak) && (plansza[i][j+1]==znak) && (plansza[i][j+2]==znak) && (plansza[i][j+3]==znak) && (plansza[i][j+4]==znak)) { koniecGry(ty,przeciwnik,nazwaPlanszy,1); }
if (i<=10) if ((plansza[i][j]==znak) && (plansza[i+1][j]==znak) && (plansza[i+2][j]==znak) && (plansza[i+3][j]==znak) && (plansza[i+4][j]==znak)) { koniecGry(ty,przeciwnik,nazwaPlanszy,1); }
if ((j<=10)&&(i<=10)) if ((plansza[i][j]==znak) && (plansza[i+1][j+1]==znak) && (plansza[i+2][j+2]==znak) && (plansza[i+3][j+3]==znak) && (plansza[i+4][j+4]==znak)) { koniecGry(ty,przeciwnik,nazwaPlanszy,1); }
if ((j>=4)&&(i<=10)) if ((plansza[i][j]==znak) && (plansza[i+1][j-1]==znak) && (plansza[i+2][j-2]==znak) && (plansza[i+3][j-3]==znak) && (plansza[i+4][j-4]==znak)) { koniecGry(ty,przeciwnik,nazwaPlanszy,1); }

}

}
}

function czyKoniecOn(znak){
for (i=0;i<=14;i++){
for (j=0;j<=14;j++){
if (j<=10) if ((plansza[i][j]==znak) && (plansza[i][j+1]==znak) && (plansza[i][j+2]==znak) && (plansza[i][j+3]==znak) && (plansza[i][j+4]==znak)) {   koniecGry(przeciwnik,ty,nazwaPlanszy,0);  }
if (i<=10) if ((plansza[i][j]==znak) && (plansza[i+1][j]==znak) && (plansza[i+2][j]==znak) && (plansza[i+3][j]==znak) && (plansza[i+4][j]==znak)) {    koniecGry(przeciwnik,ty,nazwaPlanszy,0);  }
if ((j<=10)&&(i<=10)) if ((plansza[i][j]==znak) && (plansza[i+1][j+1]==znak) && (plansza[i+2][j+2]==znak) && (plansza[i+3][j+3]==znak) && (plansza[i+4][j+4]==znak)) {   koniecGry(przeciwnik,ty,nazwaPlanszy,0);  }
if ((j>=4)&&(i<=10)) if ((plansza[i][j]==znak) && (plansza[i+1][j-1]==znak) && (plansza[i+2][j-2]==znak) && (plansza[i+3][j-3]==znak) && (plansza[i+4][j-4]==znak)) {    koniecGry(przeciwnik,ty,nazwaPlanszy,0);  } 

}

}
}


function czyRemis(){
iloscNaPlanszy=0;
for (i=0;i<=14;i++){
for (j=0;j<=14;j++){
if (plansza[i][j]!="0") iloscNaPlanszy++;
}
}

if (iloscNaPlanszy==225){
document.getElementById('czyj').innerHTML="REMIS";
gra=false;

}
}


function zPlikuDoPlanszy(planszaTxt)
{
bylo = 0;
odl=0;

for (i=0;i<15;i++){
for (j=0;j<15;j++){
if (String(i)+String(j)=="110") bylo=1;
plansza[i][j]=planszaTxt[odl];
if ((i==11) && (j>=0) && (j<=4) && (bylo==1))
{
if (kolor=="czarny") if(planszaTxt[odl]=="O") document.getElementById(String(i)+String(j)+"x").src="images/bialy.png";
if (kolor=="bialy") if(planszaTxt[odl]=="X") document.getElementById(String(i)+String(j)+"x").src="images/czarny.png";
}else{
if (kolor=="czarny") if(planszaTxt[odl]=="O") document.getElementById(String(i)+String(j)).src="images/bialy.png";
if (kolor=="bialy") if(planszaTxt[odl]=="X") document.getElementById(String(i)+String(j)).src="images/czarny.png";
}
odl++;
}
}

}
function ustawCzas()
        {	if (gra==true){
			if (wsumieSekund<30){
			sekundki.style.color="black";
			}else {  sekundki.style.color="red"; }
			if (wsumieSekund==45){
			
			if (mojczas==0){
			
			document.getElementById("czyj").value="Przegrałeś";
			koniecGry(przeciwnik,ty,nazwaPlanszy,0);
			
			
			}else{
			
			document.getElementById("czyj").value="Wygrałeś!";
			koniecGry(ty,przeciwnik,nazwaPlanszy,1);
			}
			
			}
			if (rozpoczety==true){
			
            ++wsumieSekund;
            sekundki.value = pad(wsumieSekund%60);
			
        }
		}
		}
		

        function pad(val)
        {
            var string = val + "";
            if(string.length < 2)
            {
                return "0" + string;
            }
            else
            {
                return string;
            }
        }
	
function koniecGry(wygrany,przegrany,plik,kto){
if (gra==true){
gra=false;
if (kto==1){

document.getElementById("czyj").innerHTML="Wygrałeś!";
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
gra=false;
koniecWiad("Wygrałem!");

}
}
xmlhttp.open("GET", "koniecgry.php?wygrany="+wygrany+"&przegrany="+przegrany+"&plik="+plik, true);
xmlhttp.send();
}else
{
document.getElementById("czyj").innerHTML="Przegrałeś";
gra=false;
koniecWiad("Przegrałem!");
}
}
}

function wyslijWiadomosc(){
wiad=document.getElementById("wiad").value;

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

}
}
xmlhttp.open("GET", "wyslijwiadomosc.php?uzytkownik="+ty+"&plik=txt-"+nazwaPlanszy+"&wiad="+wiad, true);
xmlhttp.send();
}


</script>
</head>

<body bgcolor="#f5fede">
<center>


<table class="plansza">
<tr><td> </td>
        <td>A</td>
        <td>B</td>
        <td>C</td>
        <td>D</td>
        <td>E</td>
        <td>F</td>
        <td>G</td>
        <td>H</td>
        <td>I</td>
        <td>J</td>
        <td>K</td>
        <td>L</td>
        <td>M</td>
        <td>N</td>
        <td>O</td>
    </tr>     
    <tr><td>1</td>
        <td><img id="00" src="images/puste.png" onClick="wstaw(0,0)"></td>
        <td><img id="01" src="images/puste.png" onClick="wstaw(0,1)"></td>
        <td><img id="02" src="images/puste.png" onClick="wstaw(0,2)"></td>
        <td><img id="03" src="images/puste.png" onClick="wstaw(0,3)"></td>
        <td><img id="04" src="images/puste.png" onClick="wstaw(0,4)"></td>
        <td><img id="05" src="images/puste.png" onClick="wstaw(0,5)"></td>
        <td><img id="06" src="images/puste.png" onClick="wstaw(0,6)"></td>
        <td><img id="07" src="images/puste.png" onClick="wstaw(0,7)"></td>
        <td><img id="08" src="images/puste.png" onClick="wstaw(0,8)"></td>
        <td><img id="09" src="images/puste.png" onClick="wstaw(0,9)"></td>
        <td><img id="010" src="images/puste.png" onClick="wstaw(0,10)"></td>
        <td><img id="011" src="images/puste.png" onClick="wstaw(0,11)"></td>
        <td><img id="012" src="images/puste.png" onClick="wstaw(0,12)"></td>
        <td><img id="013" src="images/puste.png" onClick="wstaw(0,13)"></td>
        <td><img id="014" src="images/puste.png" onClick="wstaw(0,14)"></td>
    </tr>                           
    <tr><td>2</td>                         
        <td><img id="10" src="images/puste.png" onClick="wstaw(1,0)"></td>
        <td><img id="11" src="images/puste.png" onClick="wstaw(1,1)"></td>
        <td><img id="12" src="images/puste.png" onClick="wstaw(1,2)"></td>
        <td><img id="13" src="images/puste.png" onClick="wstaw(1,3)"></td>
        <td><img id="14" src="images/puste.png" onClick="wstaw(1,4)"></td>
        <td><img id="15" src="images/puste.png" onClick="wstaw(1,5)"></td>
        <td><img id="16" src="images/puste.png" onClick="wstaw(1,6)"></td>
        <td><img id="17" src="images/puste.png" onClick="wstaw(1,7)"></td>
        <td><img id="18" src="images/puste.png" onClick="wstaw(1,8)"></td>
        <td><img id="19" src="images/puste.png" onClick="wstaw(1,9)"></td>
        <td><img id="110" src="images/puste.png" onClick="wstaw(1,10)"></td>
        <td><img id="111" src="images/puste.png" onClick="wstaw(1,11)"></td>
        <td><img id="112" src="images/puste.png" onClick="wstaw(1,12)"></td>
        <td><img id="113" src="images/puste.png" onClick="wstaw(1,13)"></td>
        <td><img id="114" src="images/puste.png" onClick="wstaw(1,14)"></td>
    </tr>                           
    <tr><td>3</td>                            
        <td><img id="20" src="images/puste.png" onClick="wstaw(2,0)"></td>
        <td><img id="21" src="images/puste.png" onClick="wstaw(2,1)"></td>
        <td><img id="22" src="images/puste.png" onClick="wstaw(2,2)"></td>
        <td><img id="23" src="images/puste.png" onClick="wstaw(2,3)"></td>
        <td><img id="24" src="images/puste.png" onClick="wstaw(2,4)"></td>
        <td><img id="25" src="images/puste.png" onClick="wstaw(2,5)"></td>
        <td><img id="26" src="images/puste.png" onClick="wstaw(2,6)"></td>
        <td><img id="27" src="images/puste.png" onClick="wstaw(2,7)"></td>
        <td><img id="28" src="images/puste.png" onClick="wstaw(2,8)"></td>
        <td><img id="29" src="images/puste.png" onClick="wstaw(2,9)"></td>
        <td><img id="210" src="images/puste.png" onClick="wstaw(2,10)"></td>
        <td><img id="211" src="images/puste.png" onClick="wstaw(2,11)"></td>
        <td><img id="212" src="images/puste.png" onClick="wstaw(2,12)"></td>
        <td><img id="213" src="images/puste.png" onClick="wstaw(2,13)"></td>
        <td><img id="214" src="images/puste.png" onClick="wstaw(2,14)"></td>
    </tr>                          
    <tr><td>4</td>                           
        <td><img id="30" src="images/puste.png" onClick="wstaw(3,0)"></td>
        <td><img id="31" src="images/puste.png" onClick="wstaw(3,1)"></td>
        <td><img id="32" src="images/puste.png" onClick="wstaw(3,2)"></td>
        <td><img id="33" src="images/puste.png" onClick="wstaw(3,3)"></td>
        <td><img id="34" src="images/puste.png" onClick="wstaw(3,4)"></td>
        <td><img id="35" src="images/puste.png" onClick="wstaw(3,5)"></td>
        <td><img id="36" src="images/puste.png" onClick="wstaw(3,6)"></td>
        <td><img id="37" src="images/puste.png" onClick="wstaw(3,7)"></td>
        <td><img id="38" src="images/puste.png" onClick="wstaw(3,8)"></td>
        <td><img id="39" src="images/puste.png" onClick="wstaw(3,9)"></td>
        <td><img id="310" src="images/puste.png" onClick="wstaw(3,10)"></td>
        <td><img id="311" src="images/puste.png" onClick="wstaw(3,11)"></td>
        <td><img id="312" src="images/puste.png" onClick="wstaw(3,12)"></td>
        <td><img id="313" src="images/puste.png" onClick="wstaw(3,13)"></td>
        <td><img id="314" src="images/puste.png" onClick="wstaw(3,14)"></td>
    </tr>                           
    <tr><td>5</td>                            
        <td><img id="40" src="images/puste.png" onClick="wstaw(4,0)"></td>
        <td><img id="41" src="images/puste.png" onClick="wstaw(4,1)"></td>
        <td><img id="42" src="images/puste.png" onClick="wstaw(4,2)"></td>
        <td><img id="43" src="images/puste.png" onClick="wstaw(4,3)"></td>
        <td><img id="44" src="images/puste.png" onClick="wstaw(4,4)"></td>
        <td><img id="45" src="images/puste.png" onClick="wstaw(4,5)"></td>
        <td><img id="46" src="images/puste.png" onClick="wstaw(4,6)"></td>
        <td><img id="47" src="images/puste.png" onClick="wstaw(4,7)"></td>
        <td><img id="48" src="images/puste.png" onClick="wstaw(4,8)"></td>
        <td><img id="49" src="images/puste.png" onClick="wstaw(4,9)"></td>
        <td><img id="410" src="images/puste.png" onClick="wstaw(4,10)"></td>
        <td><img id="411" src="images/puste.png" onClick="wstaw(4,11)"></td>
        <td><img id="412" src="images/puste.png" onClick="wstaw(4,12)"></td>
        <td><img id="413" src="images/puste.png" onClick="wstaw(4,13)"></td>
        <td><img id="414" src="images/puste.png" onClick="wstaw(4,14)"></td>
    </tr>                           
    <tr><td>6</td>                            
        <td><img id="50" src="images/puste.png" onClick="wstaw(5,0)"></td>
        <td><img id="51" src="images/puste.png" onClick="wstaw(5,1)"></td>
        <td><img id="52" src="images/puste.png" onClick="wstaw(5,2)"></td>
        <td><img id="53" src="images/puste.png" onClick="wstaw(5,3)"></td>
        <td><img id="54" src="images/puste.png" onClick="wstaw(5,4)"></td>
        <td><img id="55" src="images/puste.png" onClick="wstaw(5,5)"></td>
        <td><img id="56" src="images/puste.png" onClick="wstaw(5,6)"></td>
        <td><img id="57" src="images/puste.png" onClick="wstaw(5,7)"></td>
        <td><img id="58" src="images/puste.png" onClick="wstaw(5,8)"></td>
        <td><img id="59" src="images/puste.png" onClick="wstaw(5,9)"></td>
        <td><img id="510" src="images/puste.png" onClick="wstaw(5,10)"></td>
        <td><img id="511" src="images/puste.png" onClick="wstaw(5,11)"></td>
        <td><img id="512" src="images/puste.png" onClick="wstaw(5,12)"></td>
        <td><img id="513" src="images/puste.png" onClick="wstaw(5,13)"></td>
        <td><img id="514" src="images/puste.png" onClick="wstaw(5,14)"></td>
    </tr>                          
    <tr><td>7</td>                           
        <td><img id="60" src="images/puste.png" onClick="wstaw(6,0)"></td>
        <td><img id="61" src="images/puste.png" onClick="wstaw(6,1)"></td>
        <td><img id="62" src="images/puste.png" onClick="wstaw(6,2)"></td>
        <td><img id="63" src="images/puste.png" onClick="wstaw(6,3)"></td>
        <td><img id="64" src="images/puste.png" onClick="wstaw(6,4)"></td>
        <td><img id="65" src="images/puste.png" onClick="wstaw(6,5)"></td>
        <td><img id="66" src="images/puste.png" onClick="wstaw(6,6)"></td>
        <td><img id="67" src="images/puste.png" onClick="wstaw(6,7)"></td>
        <td><img id="68" src="images/puste.png" onClick="wstaw(6,8)"></td>
        <td><img id="69" src="images/puste.png" onClick="wstaw(6,9)"></td>
        <td><img id="610" src="images/puste.png" onClick="wstaw(6,10)"></td>
        <td><img id="611" src="images/puste.png" onClick="wstaw(6,11)"></td>
        <td><img id="612" src="images/puste.png" onClick="wstaw(6,12)"></td>
        <td><img id="613" src="images/puste.png" onClick="wstaw(6,13)"></td>
        <td><img id="614" src="images/puste.png" onClick="wstaw(6,14)"></td>
    </tr>                           
    <tr><td>8</td>                           
        <td><img id="70" src="images/puste.png" onClick="wstaw(7,0)"></td>
        <td><img id="71" src="images/puste.png" onClick="wstaw(7,1)"></td>
        <td><img id="72" src="images/puste.png" onClick="wstaw(7,2)"></td>
        <td><img id="73" src="images/puste.png" onClick="wstaw(7,3)"></td>
        <td><img id="74" src="images/puste.png" onClick="wstaw(7,4)"></td>
        <td><img id="75" src="images/puste.png" onClick="wstaw(7,5)"></td>
        <td><img id="76" src="images/puste.png" onClick="wstaw(7,6)"></td>
        <td><img id="77" src="images/puste.png" onClick="wstaw(7,7)"></td>
        <td><img id="78" src="images/puste.png" onClick="wstaw(7,8)"></td>
        <td><img id="79" src="images/puste.png" onClick="wstaw(7,9)"></td>
        <td><img id="710" src="images/puste.png" onClick="wstaw(7,10)"></td>
        <td><img id="711" src="images/puste.png" onClick="wstaw(7,11)"></td>
        <td><img id="712" src="images/puste.png" onClick="wstaw(7,12)"></td>
        <td><img id="713" src="images/puste.png" onClick="wstaw(7,13)"></td>
        <td><img id="714" src="images/puste.png" onClick="wstaw(7,14)"></td>
    </tr>                            
    <tr><td>9</td>                             
        <td><img id="80" src="images/puste.png" onClick="wstaw(8,0)"></td>
        <td><img id="81" src="images/puste.png" onClick="wstaw(8,1)"></td>
        <td><img id="82" src="images/puste.png" onClick="wstaw(8,2)"></td>
        <td><img id="83" src="images/puste.png" onClick="wstaw(8,3)"></td>
        <td><img id="84" src="images/puste.png" onClick="wstaw(8,4)"></td>
        <td><img id="85" src="images/puste.png" onClick="wstaw(8,5)"></td>
        <td><img id="86" src="images/puste.png" onClick="wstaw(8,6)"></td>
        <td><img id="87" src="images/puste.png" onClick="wstaw(8,7)"></td>
        <td><img id="88" src="images/puste.png" onClick="wstaw(8,8)"></td>
        <td><img id="89" src="images/puste.png" onClick="wstaw(8,9)"></td>
        <td><img id="810" src="images/puste.png" onClick="wstaw(8,10)"></td>
        <td><img id="811" src="images/puste.png" onClick="wstaw(8,11)"></td>
        <td><img id="812" src="images/puste.png" onClick="wstaw(8,12)"></td>
        <td><img id="813" src="images/puste.png" onClick="wstaw(8,13)"></td>
        <td><img id="814" src="images/puste.png" onClick="wstaw(8,14)"></td>
    </tr>                           
    <tr><td>10</td>                            
        <td><img id="90" src="images/puste.png" onClick="wstaw(9,0)"></td>
        <td><img id="91" src="images/puste.png" onClick="wstaw(9,1)"></td>
        <td><img id="92" src="images/puste.png" onClick="wstaw(9,2)"></td>
        <td><img id="93" src="images/puste.png" onClick="wstaw(9,3)"></td>
        <td><img id="94" src="images/puste.png" onClick="wstaw(9,4)"></td>
        <td><img id="95" src="images/puste.png" onClick="wstaw(9,5)"></td>
        <td><img id="96" src="images/puste.png" onClick="wstaw(9,6)"></td>
        <td><img id="97" src="images/puste.png" onClick="wstaw(9,7)"></td>
        <td><img id="98" src="images/puste.png" onClick="wstaw(9,8)"></td>
        <td><img id="99" src="images/puste.png" onClick="wstaw(9,9)"></td>
        <td><img id="910" src="images/puste.png" onClick="wstaw(9,10)"></td>
        <td><img id="911" src="images/puste.png" onClick="wstaw(9,11)"></td>
        <td><img id="912" src="images/puste.png" onClick="wstaw(9,12)"></td>
        <td><img id="913" src="images/puste.png" onClick="wstaw(9,13)"></td>
        <td><img id="914" src="images/puste.png" onClick="wstaw(9,14)"></td>
    </tr>                          
    <tr><td>11</td>                           
        <td><img id="100" src="images/puste.png" onClick="wstaw(10,0)"></td>
        <td><img id="101" src="images/puste.png" onClick="wstaw(10,1)"></td>
        <td><img id="102" src="images/puste.png" onClick="wstaw(10,2)"></td>
        <td><img id="103" src="images/puste.png" onClick="wstaw(10,3)"></td>
        <td><img id="104" src="images/puste.png" onClick="wstaw(10,4)"></td>
        <td><img id="105" src="images/puste.png" onClick="wstaw(10,5)"></td>
        <td><img id="106" src="images/puste.png" onClick="wstaw(10,6)"></td>
        <td><img id="107" src="images/puste.png" onClick="wstaw(10,7)"></td>
        <td><img id="108" src="images/puste.png" onClick="wstaw(10,8)"></td>
        <td><img id="109" src="images/puste.png" onClick="wstaw(10,9)"></td>
        <td><img id="1010" src="images/puste.png" onClick="wstaw(10,10)"></td>
        <td><img id="1011" src="images/puste.png" onClick="wstaw(10,11)"></td>
        <td><img id="1012" src="images/puste.png" onClick="wstaw(10,12)"></td>
        <td><img id="1013" src="images/puste.png" onClick="wstaw(10,13)"></td>
        <td><img id="1014" src="images/puste.png" onClick="wstaw(10,14)"></td>
    </tr>                           
    <tr><td>12</td>                            
        <td><img id="110x" src="images/puste.png" onClick="wstaw(11,0)"></td>
        <td><img id="111x" src="images/puste.png" onClick="wstaw(11,1)"></td>
        <td><img id="112x" src="images/puste.png" onClick="wstaw(11,2)"></td>
        <td><img id="113x" src="images/puste.png" onClick="wstaw(11,3)"></td>
        <td><img id="114x" src="images/puste.png" onClick="wstaw(11,4)"></td>
        <td><img id="115" src="images/puste.png" onClick="wstaw(11,5)"></td>
        <td><img id="116" src="images/puste.png" onClick="wstaw(11,6)"></td>
        <td><img id="117" src="images/puste.png" onClick="wstaw(11,7)"></td>
        <td><img id="118" src="images/puste.png" onClick="wstaw(11,8)"></td>
        <td><img id="119" src="images/puste.png" onClick="wstaw(11,9)"></td>
        <td><img id="1110" src="images/puste.png" onClick="wstaw(11,10)"></td>
        <td><img id="1111" src="images/puste.png" onClick="wstaw(11,11)"></td>
        <td><img id="1112" src="images/puste.png" onClick="wstaw(11,12)"></td>
        <td><img id="1113" src="images/puste.png" onClick="wstaw(11,13)"></td>
        <td><img id="1114" src="images/puste.png" onClick="wstaw(11,14)"></td>
    </tr>                            
    <tr><td>13</td>                             
        <td><img id="120" src="images/puste.png" onClick="wstaw(12,0)"></td>
        <td><img id="121" src="images/puste.png" onClick="wstaw(12,1)"></td>
        <td><img id="122" src="images/puste.png" onClick="wstaw(12,2)"></td>
        <td><img id="123" src="images/puste.png" onClick="wstaw(12,3)"></td>
        <td><img id="124" src="images/puste.png" onClick="wstaw(12,4)"></td>
        <td><img id="125" src="images/puste.png" onClick="wstaw(12,5)"></td>
        <td><img id="126" src="images/puste.png" onClick="wstaw(12,6)"></td>
        <td><img id="127" src="images/puste.png" onClick="wstaw(12,7)"></td>
        <td><img id="128" src="images/puste.png" onClick="wstaw(12,8)"></td>
        <td><img id="129" src="images/puste.png" onClick="wstaw(12,9)"></td>
        <td><img id="1210" src="images/puste.png" onClick="wstaw(12,10)"></td>
        <td><img id="1211" src="images/puste.png" onClick="wstaw(12,11)"></td>
        <td><img id="1212" src="images/puste.png" onClick="wstaw(12,12)"></td>
        <td><img id="1213" src="images/puste.png" onClick="wstaw(12,13)"></td>
        <td><img id="1214" src="images/puste.png" onClick="wstaw(12,14)"></td>
    </tr>                            
    <tr><td>14</td>                             
        <td><img id="130" src="images/puste.png" onClick="wstaw(13,0)"></td>
        <td><img id="131" src="images/puste.png" onClick="wstaw(13,1)"></td>
        <td><img id="132" src="images/puste.png" onClick="wstaw(13,2)"></td>
        <td><img id="133" src="images/puste.png" onClick="wstaw(13,3)"></td>
        <td><img id="134" src="images/puste.png" onClick="wstaw(13,4)"></td>
        <td><img id="135" src="images/puste.png" onClick="wstaw(13,5)"></td>
        <td><img id="136" src="images/puste.png" onClick="wstaw(13,6)"></td>
        <td><img id="137" src="images/puste.png" onClick="wstaw(13,7)"></td>
        <td><img id="138" src="images/puste.png" onClick="wstaw(13,8)"></td>
        <td><img id="139" src="images/puste.png" onClick="wstaw(13,9)"></td>
        <td><img id="1310" src="images/puste.png" onClick="wstaw(13,10)"></td>
        <td><img id="1311" src="images/puste.png" onClick="wstaw(13,11)"></td>
        <td><img id="1312" src="images/puste.png" onClick="wstaw(13,12)"></td>
        <td><img id="1313" src="images/puste.png" onClick="wstaw(13,13)"></td>
        <td><img id="1314" src="images/puste.png" onClick="wstaw(13,14)"></td>
    </tr>                           
    <tr><td>15</td>                            
        <td><img id="140" src="images/puste.png" onClick="wstaw(14,0)"></td>
        <td><img id="141" src="images/puste.png" onClick="wstaw(14,1)"></td>
        <td><img id="142" src="images/puste.png" onClick="wstaw(14,2)"></td>
        <td><img id="143" src="images/puste.png" onClick="wstaw(14,3)"></td>
        <td><img id="144" src="images/puste.png" onClick="wstaw(14,4)"></td>
        <td><img id="145" src="images/puste.png" onClick="wstaw(14,5)"></td>
        <td><img id="146" src="images/puste.png" onClick="wstaw(14,6)"></td>
        <td><img id="147" src="images/puste.png" onClick="wstaw(14,7)"></td>
        <td><img id="148" src="images/puste.png" onClick="wstaw(14,8)"></td>
        <td><img id="149" src="images/puste.png" onClick="wstaw(14,9)"></td>
        <td><img id="1410" src="images/puste.png" onClick="wstaw(14,10)"></td>
        <td><img id="1411" src="images/puste.png" onClick="wstaw(14,11)"></td>
        <td><img id="1412" src="images/puste.png" onClick="wstaw(14,12)"></td>
        <td><img id="1413" src="images/puste.png" onClick="wstaw(14,13)"></td>
        <td><img id="1414" src="images/puste.png" onClick="wstaw(14,14)"></td>
    </tr>
</table>
<textarea id="rozmowaGlowna" class="textbox" rows="10" cols="50" disabled>
</textarea>
<button class="btn" id="wyswiad" type='button' onclick='wyslijWiadomosc()'>Wyślij wiadomość!</button>
<input class="textbox" id='wiad' type='text' value='Wpisz wiadomość...'><br>
<FORM name ="Wyloguj" method ="post">
<Input class='btn' id="wylogujbtn" type = "Submit" Name = "Wyloguj" VALUE = "Wyloguj mnie!"><br>
</FORM>
</center>
</body>
</html>