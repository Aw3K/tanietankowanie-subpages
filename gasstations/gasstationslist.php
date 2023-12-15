<?php
error_reporting(0);
session_start();
include "adminconfig.php";
if (!isset($_SESSION['logged']) && empty($_SESSION['logged']))
	exit("User isn't logged in.");
$page = $_GET['page'];
$perpage = $_GET['perpage'];
$q = $_GET['q'];
$orderby = $_GET['orderby'];
$ascdesc = $_GET['ascdesc'];

$conn = pg_connect($connString3);
if (!$conn)
	exit("Couldn't connect to database.");

if (empty($page) || !isset($page) || $page < 1)
	$page = 1;
if (empty($perpage) || !isset($perpage) || $perpage < 1)
	$perpage = 50;
if (empty($q) || !isset($q))
	$q = "%";
if (empty($orderby) || !isset($orderby))
	$orderby = "id";
if ($ascdesc != "ASC" && $ascdesc != "DESC")
	$ascdesc = "ASC";

$page = pg_escape_literal($conn, $page);
$perpage = pg_escape_literal($conn, $perpage);
$q = pg_escape_literal($conn, $q);
$orderby = pg_escape_literal($conn, $orderby);
$ascdesc = pg_escape_literal($conn, $ascdesc);

$page = trim($page, "'");
$perpage = trim($perpage, "'");
$q = trim($q, "'");
$orderby = trim($orderby, "'");
$ascdesc = trim($ascdesc, "'");

$result = pg_query($conn, "SELECT id,dkn,nazwa,\"nazwaStacji\",\"infraPoczta\",\"infraKod\",\"infraUlica\",\"infraNrLokalu\",\"Latitude\",\"Longitude\" FROM gas_station " .
	"WHERE CAST(id AS varchar) LIKE '$q' OR " .
	"CAST(dkn AS varchar) LIKE '$q' OR " .
	"nazwa ILIKE '$q' OR " .
	"\"nazwaStacji\" ILIKE '$q' OR " .
	"\"infraPoczta\" ILIKE '$q' OR " .
	"\"infraKod\" ILIKE '$q' OR " .
	"\"infraUlica\" ILIKE '$q' OR " .
	"\"infraNrLokalu\" ILIKE '$q' OR " .
	"CAST(\"Latitude\" AS varchar) ILIKE '$q' OR " .
	"CAST(\"Longitude\" AS varchar) ILIKE '$q'"
	. " ORDER BY \"$orderby\" $ascdesc LIMIT " . $perpage * $page . ";");
if (!empty($result)) {
	echo "<table><tr><th>id</th><th>dkn</th><th>nazwa</th><th>nazwa stacji</th><th>infrapoczta</th><th>infrakod</th><th>infraulica</th><th>infranrlokalu</th><th>latitude</th><th>longitude</th><th style='text-align: center;'>X</th></tr>";
	$count = 1;
	while ($row = pg_fetch_array($result)) {
		if ($count >= (($page - 1) * $perpage) + 1 && $count <= ($page) * $perpage) {
			echo "<tr id='tr_" . $row['id'] . "'>
			<th>" . $row['id'] . "</th>" .
				"<th>" . $row['dkn'] . "</th>" .
				"<td>" . $row['nazwa'] . "</td>" .
				"<td>" . $row['nazwaStacji'] . "</td>" .
				"<td>" . $row['infraPoczta'] . "</td>" .
				"<td>" . $row['infraKod'] . "</td>" .
				"<td>" . $row['infraUlica'] . "</td>" .
				"<td>" . $row['infraNrLokalu'] . "</td>" .
				"<td>" . $row['Latitude'] . "</td>" .
				"<td>" . $row['Longitude'] . "</td>" .
				"<td><div class='flex-row flex-justify-center gap10'><input class='table-button button' type='button' onclick='updateDataPopup(" . $row['id'] . ")' value='EDYTUJ'/><input class='table-button button' type='button' onclick='deleteRecord(" . $row['id'] . "," . $row['dkn'] . ")' value='USUN'/></div></td></tr>";
		}
		$count++;
	}
	echo "</table>";
}
pg_close($conn);
?>