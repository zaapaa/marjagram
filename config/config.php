<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Tietokanta
$user = 'marjagradmin';        //Käytäjänimi 
$pass = 'mansikat';        //Salasana
$host = 'localhost';  //Tietokantapalvelin
$dbname = 'marjagram';        //Tietokanta
// Muodostetaan yhteys tietokantaan
try {     //Avataan yhteys tietokantaan ($DBH on nyt luotu yhteysolio, nimi vapaasti valittavissa)
	$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		   // virheenkäsittely: virheet aiheuttavat poikkeuksen
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	// käytetään  merkistöä utf8
	$DBH->exec("SET NAMES utf8;");
} catch(PDOException $e) {
	echo "Yhteysvirhe.";  
			//Kirjoitetaan mahdollinen virheviesti tiedostoon
	file_put_contents('log/DBErrors.txt', 'Connection: '.$e->getMessage()."\n", FILE_APPEND);
} //HUOM hakemistopolku!
?>