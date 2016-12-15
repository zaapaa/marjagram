<?php
session_start();
require_once '../functions/functions.php';
require_once '../config/config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$MediaID = $_SESSION['mediaID'];
$UserID = $_SESSION['userID'];
$rating = $_GET['rating'];
if($rating>5 || $rating<0){
	$_SESSION['message'] = "Väärä rating";
	redirect('../media.php?id='.$MediaID);
}

try {
		if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == "yes")
		{
	$STR = $DBH->prepare("SELECT * FROM marjagram_rating WHERE UserID= $UserID AND MediaID=$MediaID;");
	$STR->execute();
	$STR->setFetchMode(PDO::FETCH_OBJ);
	$row = $STR->fetch();
	if($STR->rowCount() == 0){
		try{
			$sql="INSERT INTO marjagram_rating (MediaID, UserID, Rating) VALUES(".$MediaID.", ".$UserID.", '".$rating."');";
			$stm=$DBH->prepare($sql);
			if($stm->execute()){
				$_SESSION['message'] = "Media arvioitu.";
				redirect('../media.php?id='.$MediaID);
			}
		} catch(PDOException $e){
			$_SESSION['message'] = "Tietokantaongelma";
			file_put_contents('../log/DBErrors.txt', 'newRating.php: '.$e->getMessage()."\n", FILE_APPEND);
			redirect('../media.php?id='.$MediaID);
		}
	} else {
		$_SESSION['message'] = "Olet jo arvioinut median.";
		redirect('../media.php?id='.$MediaID);
	}
		}
		else {
			$MediaID = $_SESSION['mediaID'];
			redirect('../media.php?id='.$MediaID);
			$_SESSION['message'] = "Kirjaudu ensin sisään arvioidaksesi";
		}
} catch(PDOException $e) {
	$_SESSION['message'] = "Tietokantaongelma";
	file_put_contents('../log/DBErrors.txt', 'newRating.php: '.$e->getMessage()."\n", FILE_APPEND);
}	
?>