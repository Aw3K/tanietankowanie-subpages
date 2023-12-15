<?php
session_start();
include "adminconfig.php";
error_reporting(0);
$_SESSION = array();
session_destroy();
header("location: " . $logoutLoc);
?>