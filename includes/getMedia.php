<?php
session_start();
require_once '../functions/functions.php';
require_once("../config/config.php");


$media=getMediaID($DBH, $_SESSION['mediaID']);
$jsonString = json_encode($media);
echo($jsonString);
?>