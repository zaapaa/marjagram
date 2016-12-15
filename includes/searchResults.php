<?php
session_start();
require_once '../functions/functions.php';
require_once '../config/config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
$media = getSearchMedia($DBH, $_SESSION['search']);
$mediajson = json_encode($media);
echo($mediajson);
?>