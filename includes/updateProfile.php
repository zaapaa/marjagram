<?php
session_start();
require_once '../functions/functions.php';
require_once '../config/config.php';

if(isset($_POST['updateProfile'])){
	
	if(!empty($_POST['newFName'])){
		$data1['id'] = $_SESSION['userID'];
		$data1['FName']=$_POST['newFName'];
		$sql="UPDATE marjagram_user SET Firstname=:FName WHERE UserID=:id";
		try{
			$stm=$DBH->prepare($sql);
			if($stm->execute($data1)){
				$_SESSION['message'] = "Tiedot päivitetty.";
			}
		} catch(PDOException $e){
			$_SESSION['message'] = "Tietokantaongelma";
			file_put_contents('../log/DBErrors.txt', 'update profile1: '.$e->getMessage()."\n", FILE_APPEND);
		}
	}
	if(!empty($_POST['newLName'])){
		$data2['id'] = $_SESSION['userID'];
		$data2['LName']=$_POST['newLName'];
		$sql="UPDATE marjagram_user SET Lastname=:LName WHERE UserID=:id";
		try{
			$stm=$DBH->prepare($sql);
			if($stm->execute($data2)){
				$_SESSION['message'] = "Tiedot päivitetty.";
			}
		} catch(PDOException $e){
			$_SESSION['message'] = "Tietokantaongelma";
			file_put_contents('../log/DBErrors.txt', 'update profile2: '.$e->getMessage()."\n", FILE_APPEND);
		}
	}
	if(!empty($_POST['newGender'])){
		$data3['id'] = $_SESSION['userID'];
		$data3['gender']=$_POST['newGender'];
		$sql="UPDATE marjagram_user SET Gender=:gender WHERE UserID=:id";
		try{
			$stm=$DBH->prepare($sql);
			if($stm->execute($data3)){
				$_SESSION['message'] = "Tiedot päivitetty.";
			}
		} catch(PDOException $e){
			$_SESSION['message'] = "Tietokantaongelma";
			file_put_contents('../log/DBErrors.txt', 'update profile3: '.$e->getMessage()."\n", FILE_APPEND);
		}
	}
	if(!empty($_POST['newBDate'])){
		$data4['id'] = $_SESSION['userID'];
		$data4['bdate']=$_POST['newBDate'];
		$sql="UPDATE marjagram_user SET Birthdate=:bdate WHERE UserID=:id";
		try{
			$stm=$DBH->prepare($sql);
			if($stm->execute($data4)){
				$_SESSION['message'] = "Tiedot päivitetty.";
			}
		} catch(PDOException $e){
			$_SESSION['message'] = "Tietokantaongelma";
			file_put_contents('../log/DBErrors.txt', 'update profile4: '.$e->getMessage()."\n", FILE_APPEND);
		}
	}
	if(!empty($_POST['newEmail'])){
		$data5['id'] = $_SESSION['userID'];
		$data5['email']=$_POST['newEmail'];
		$sql="UPDATE marjagram_user SET Email=:email WHERE UserID=:id";
		try{
			$stm=$DBH->prepare($sql);
			if($stm->execute($data5)){
				$_SESSION['message'] = "Tiedot päivitetty.";
			}
		} catch(PDOException $e){
			$_SESSION['message'] = "Tietokantaongelma";
			file_put_contents('../log/DBErrors.txt', 'update profile5: '.$e->getMessage()."\n", FILE_APPEND);
		}
	}
	redirect('../profiili.php');
	

	
}
?>