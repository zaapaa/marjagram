<?php

$username = "";
$fname = "";
$lname = "";
$gender = "";
$email = "";
$bdate = "";

error_reporting(E_ALL);
ini_set('display_errors', 1);
try {
	$STH = $DBH->prepare("SELECT * FROM marjagram_user WHERE UserID=".$_SESSION['userID'].";");
	$STH->execute();
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$row = $STH->fetch();
	if($STH->rowCount() > 0){
		$username = $row->Username;
		$fname = $row->Firstname;
		$lname = $row->Lastname;
		$gender = $row->Gender;
		$email = $row->Email;
		$bdate = $row->Birthdate;
		
	} else {
		echo("Virhe! käyttäjällesi ei löytynyt tietoja! hax");
	}
} catch(PDOException $e) {
	$_SESSION['message'] = "Tietokantaongelma";
	file_put_contents('log/DBErrors.txt', 'get user info: '.$e->getMessage()."\n", FILE_APPEND);
}

?>