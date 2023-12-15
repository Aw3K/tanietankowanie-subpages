<?php
session_start();
include "adminconfig.php";

if (!isset($_SESSION['logged']) && empty($_SESSION['logged']))
	exit("User isn't logged in.");
$conn = pg_connect($connString);
$result = pg_query($conn, "SELECT * FROM zgloszenia;");
if (!empty($result)) {
	echo "<table><tr><th>Id</th><th>User Id</th><th>Opis</th><th>Lat</th><th>Long</th><th></th></tr>";
	while ($row = pg_fetch_array($result)) {
		echo "<tr><td>" . $row['id'] . "</td>" . "<td>" . $row['user_id'] . "</td>" . "<td>" . $row['opis'] . "</td>" . "<td>" . $row['latitude'] . "</td>" . "<td>" . $row['longitude'] . "</td><td><input type=\"checkbox\" id=\"deleteCheck\" value=\"" . $row['id'] . "\"></td></tr>";
	}
	echo "</table>";
}
pg_close($conn);

?>