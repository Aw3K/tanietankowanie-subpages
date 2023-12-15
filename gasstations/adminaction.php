<?php
error_reporting(0);
session_start();
include "adminconfig.php";
if (!isset($_SESSION['logged']) && empty($_SESSION['logged']))
	exit("User isn't logged in.");
if ($_POST['mode'] == "insert" || $_POST['mode'] == "update") {
	$conn = pg_connect($connString3);
	$id = pg_escape_literal($conn, $_POST['id']);
	$dkn = pg_escape_literal($conn, $_POST['dkn']);
	$nazwa = pg_escape_literal($conn, $_POST['nazwa']);
	$nazwaStacji = pg_escape_literal($conn, $_POST['nazwaStacji']);
	$infraPoczta = pg_escape_literal($conn, $_POST['infraPoczta']);
	$infraKod = pg_escape_literal($conn, $_POST['infraKod']);
	$infraUlica = pg_escape_literal($conn, $_POST['infraUlica']);
	$infraNrLokalu = pg_escape_literal($conn, $_POST['infraNrLokalu']);
	$Latitude = pg_escape_literal($conn, $_POST['Latitude']);
	$Longitude = pg_escape_literal($conn, $_POST['Longitude']);
}
if ($_POST['mode'] == "insert") {
	if (
		!pg_query($conn, "INSERT INTO public.gas_station(dkn, nazwa, \"nazwaStacji\", \"infraPoczta\", \"infraKod\", \"infraUlica\", \"infraNrLokalu\", \"Latitude\", \"Longitude\") " .
			"VALUES ($dkn, $nazwa, $nazwaStacji, $infraPoczta, $infraKod, $infraUlica, $infraNrLokalu, $Latitude, $Longitude);")
	)
		echo pg_last_error($conn);
	else
		echo "OK";
} else if ($_POST['mode'] == "update") {
	if (
		!pg_query($conn, "UPDATE public.gas_station " .
			"SET dkn=$dkn, nazwa=$nazwa, \"nazwaStacji\"=$nazwaStacji, \"infraPoczta\"=$infraPoczta, \"infraKod\"=$infraKod, \"infraUlica\"=$infraUlica, \"infraNrLokalu\"=$infraNrLokalu, \"Latitude\"=$Latitude, \"Longitude\"=$Longitude " .
			"WHERE id=$id;")
	)
		echo pg_last_error($conn);
	else
		echo "OK";
} else {
	$id = $_POST['id'];
	$dkn = $_POST['dkn'];
	if (empty($id) || !isset($id) || empty($dkn) || !isset($dkn))
		exit("Empty input.");
	$conn = pg_connect($connString3);
	if (!pg_query("DELETE FROM gas_station WHERE id=" . pg_escape_literal($conn, $id) . " AND dkn=" . pg_escape_literal($conn, $dkn) . ";"))
		echo pg_last_error($conn);
	else
		echo "OK";
}
pg_close($conn);
?>