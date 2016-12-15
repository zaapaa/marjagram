<?php
session_start();
require_once '../config/config.php';
require_once '../functions/functions.php';
if(isset($_POST['login'])){
	$user=login($_POST["givenUser"],$_POST["givenPw"],$DBH);
	if($user){
		$_SESSION['loggedIn'] = 'yes';
		$_SESSION['username'] = $user->Username;
		$_SESSION['email'] = $user->Email;
		$_SESSION['userID'] = $user->UserID;
		unset($_SESSION['message']);
		redirect("../index.php");
	} else {
		$_SESSION['message'] = "Väärä käyttäjätunnus tai salasana";
		redirect("../kirjaudu.php");
	}
}else if (isset($_POST['cancel'])){
	redirect("../index.php");
}
?>