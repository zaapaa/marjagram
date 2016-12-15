<?php
session_start();
require_once '../functions/functions.php';
require_once("../config/config.php");


$comment=getComments($DBH, $_SESSION['mediaID']);
$jsonString = json_encode($comment);
echo($jsonString);
?>