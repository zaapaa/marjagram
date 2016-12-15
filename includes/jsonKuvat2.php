<?php
require_once '../functions/functions.php';
require_once("../config/config.php");


$kuvat=getNewestMedia($DBH, 100);
$jsonString = json_encode($kuvat);
echo($jsonString);
?>