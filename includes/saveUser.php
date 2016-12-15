<?php
session_start();
require_once '../functions/functions.php';
require_once '../config/config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['register'])){
	$data['fname'] = $_POST['givenFName'];
	$data['username'] = $_POST['givenUser'];
	$data['email'] = $_POST['givenEmail'];
	//$data['password'] = hash('sha256', $_POST['givenPw']."abc");
	$data['password'] = password_hash($_POST['givenPw'], PASSWORD_BCRYPT);
	$data['admin'] = false;
	
	
	$nameAvailable=false;
	$emailAvailable=false;
	if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
		//onko email/username jo käytössä? lab note sivu 8
		try {
			$datauser = array('username' => $data['username']);
			$STH = $DBH->prepare("SELECT Username FROM marjagram_user WHERE Username= :username");
			$STH->execute($datauser);
			$STH->setFetchMode(PDO::FETCH_OBJ);
			$row = $STH->fetch();
			if($STH->rowCount() == 0){
				$nameAvailable=true;
			} else {
				$_SESSION['message'] = "Tämä käyttäjänimi on jo käytössä.";
				redirect("../luo.php");
			}
			
			$dataemail = array('email' => $data['email']);
			$STB = $DBH->prepare("SELECT Email FROM marjagram_user WHERE Email= :email");
			$STB->execute($dataemail);
			$STB->setFetchMode(PDO::FETCH_OBJ);
			$row = $STB->fetch();
			if($STB->rowCount() == 0){
				$emailAvailable=true;
			} else {
				$_SESSION['message'] = "Tämä sähköpostiosoite on jo käytössä.";
				redirect("../luo.php");
			}
		} catch(PDOException $e) {
			$_SESSION['message'] = "Tietokantaongelma";
			file_put_contents('../log/DBErrors.txt', 'Register-name/emailcheck: '.$e->getMessage()."\n", FILE_APPEND);
		}
		
		if($nameAvailable&&$emailAvailable){
			try{
				$stm=$DBH->prepare("INSERT INTO marjagram_user (Username, Password, Email, Firstname, Admin) VALUES(:username,:password,:email, :fname, :admin);");
				if($stm->execute($data)){
					$_SESSION['message'] = "Rekisteröityminen onnistui, tervetuloa marjagramiin, " . $data['fname'];
					redirect('../kirjaudu.php');
				}
			} catch(PDOException $e){
				$_SESSION['message'] = "Tietokantaongelma";
				file_put_contents('log/DBErrors.txt', 'Register-saveuser: '.$e->getMessage()."\n", FILE_APPEND);
				redirect('../luo.php');
			}
		} else {
			$_SESSION['message'] = "Virhe";
			redirect('../luo.php');
		}
		
	} else{
		$_SESSION['message'] = "Väärä email";
		redirect('../luo.php');
	}
}




?>