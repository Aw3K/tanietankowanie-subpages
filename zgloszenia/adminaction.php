<?php
session_start();
include "adminconfig.php";
if (!isset($_SESSION['logged']) && empty($_SESSION['logged']))
	exit("User isn't logged in.");
$idList = $_POST['ids'];
if (empty($idList))
	exit("Empty input.");
$conn = pg_connect($connString);
foreach ($idList as $out) {
	pg_query("DELETE FROM zgloszenia WHERE id=" . $out . ";");
}
pg_close($conn);
?>