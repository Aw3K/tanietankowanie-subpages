<?php
session_start();
include "adminconfig.php";
if (!isset($_SESSION['logged']) && empty($_SESSION['logged']))
    exit("User isn't logged in.");
if (!($files = scandir($imageDir)))
    exit("Isn't a catalog or don't exist.");
$files = preg_grep('~\.(jpeg|jpg|png)$~', $files);
echo json_encode($files);
?>