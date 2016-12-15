<?php
session_start();
require_once '../config/config.php';
require_once '../functions/functions.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
$m_dir = "/marjagram/";
$target_dir = "uploads/".$_SESSION['userID']."/";
$path = $root.$m_dir.$target_dir;
$target_filehtml = $_SESSION['fileName'];
$target_file = $path . $_SESSION['fileName'];
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if(isset($_POST["updateNameDesc"])) {
	$data['path'] ="$target_filehtml";
	
	$sql = "UPDATE marjagram_media SET ";
	
	if(!empty($_POST['newName']) && empty($_POST['newDesc'])){
		$sql .="MName=:newName";
		$data['newName'] = $_POST['newName'];
	} else if(!empty($_POST['newDesc']) && empty($_POST['newName'])){
		$sql .="Description=:newDesc";
		$data['newDesc'] = $_POST['newDesc'];
	} else if (!empty($_POST['newName']) && !empty($_POST['newDesc'])){
		$sql.="MName=:newName, Description=:newDesc";
		$data['newName'] = $_POST['newName'];
		$data['newDesc'] = $_POST['newDesc'];
	} else {
		$_SESSION['message'] = "tyhjät kentät";
		redirect("../lataa.php");
	}
	
	$sql .= " WHERE mediapath=:path;";
	
	try{
		$stm=$DBH->prepare($sql);
		if($stm->execute($data)){
			$_SESSION['message'] = "Tiedot päivitetty.";
			redirect('../lataa.php');
		}
	} catch(PDOException $e){
		$_SESSION['message'] = "Tietokantaongelma";
		file_put_contents('../log/DBErrors.txt', 'file upload: '.$e->getMessage()."\n", FILE_APPEND);
		echo("$e->getMessage()");
		//redirect('lataa.php');
	}
}



		

?>
