<?php
session_start();
require_once '../functions/functions.php';
require_once '../config/config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
try{
		if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == "yes")
		{
	$MediaID = $_SESSION['mediaID'];
	$UserID = $_SESSION['userID'];
	$sql="INSERT INTO marjagram_comment (MediaID, UserID, MComment) VALUES(".$MediaID.", ".$UserID.", '".$_POST['comment']."');";
	$stm=$DBH->prepare($sql);		
	if($stm->execute()){
		$_SESSION['message'] = "Kommentti lähetetty.";
		redirect('../media.php?id='.$MediaID);
	}
		} else
		{
			$MediaID = $_SESSION['mediaID'];
			redirect('../media.php?id='.$MediaID);
			$_SESSION['message'] = "Kirjaudu ensin sisään kommentoidaksesi";
		}
	} catch(PDOException $e){
	file_put_contents('../log/DBErrors.txt', 'newComment.php: '.$e->getMessage()."\n", FILE_APPEND);
	redirect('../media.php?id='.$MediaID);
}




?>