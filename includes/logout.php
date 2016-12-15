<?php
require_once '../functions/functions.php';
session_start();
session_destroy();
redirect("../index.php");
?>