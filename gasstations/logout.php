<?php
session_start();
error_reporting(0);
include "adminconfig.php";
$_SESSION = array();
session_destroy();
header("location: " . $logoutLoc);
?>