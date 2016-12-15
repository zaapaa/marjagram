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
$target_filehtml = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$target_file = $path . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["upload"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
    	$_SESSION['message'] = "Tiedosto ei ole kuva";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $_SESSION['message'] = "Kuva on jo olemassa";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 120000000) {
	$_SESSION['message'] = "Tiedosto liian iso";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
	$_SESSION['message'] = "vain jpg-, png- ja gif- tiedostot sallittu";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	redirect("../lataa.php");
// if everything is ok, try to upload file
} else {
	$old = umask(0);
	$path = $root.$m_dir.$target_dir;
	if(!is_dir($path)){
		echo($path);
		mkdir($path, 0777, true);
		
	}
	echo ($target_file);
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    	umask($old);
        $data['mname'] =pathinfo($target_file,PATHINFO_FILENAME);
        $data['path'] ="$target_filehtml";
        $data['userid'] = $_SESSION["userID"];
        
        try{
        	$stm=$DBH->prepare("INSERT INTO marjagram_media (MName, Mediapath, UserID) VALUES(:mname,:path,:userid);");
        	if($stm->execute($data)){
        		$_SESSION['message'] = "Tiedosto ". basename( $_FILES["fileToUpload"]["name"]). " on ladattu.";
        		$_SESSION['fileUploaded'] = "yes";
        		$_SESSION['fileName'] = $target_filehtml;
        		redirect('../lataa.php');
        	}
        } catch(PDOException $e){
        	$_SESSION['message'] = "Tietokantaongelma";
        	file_put_contents('log/DBErrors.txt', 'file upload: '.$e->getMessage()."\n", FILE_APPEND);
        	echo("$e->getMessage()");
        	//redirect('lataa.php');
        }
    } else {
    	umask($old);
    	$_SESSION['message'] = "Harass?";
    }
}
?>
