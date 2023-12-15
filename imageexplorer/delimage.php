<?php
session_start();
include "adminconfig.php";
if (!isset($_SESSION['logged']) && empty($_SESSION['logged']))
    exit("User isn't logged in.");
$img = $_GET['img'];
unlink($imageDir . $img);
?>