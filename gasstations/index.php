<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./styles.css" />
	<link rel="stylesheet" type="text/css" href="./style.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script>
		function load_home(page, perpage, search, orderby, ad) {
			fetch("./gasstationslist.php?page=" + page + "&perpage=" + perpage + "&q=" + search + "&orderby=" + orderby + "&ascdesc=" + ad)
				.then((response) => response.text())
				.then((html) => {
					document.getElementById("datalist").innerHTML = html;
				})
				.catch((error) => {
					console.warn(error);
				});
		}
		function getData() {
			load_home(page.value, perpage.value, search.value, sortby.value, ascdesc.value);
		}
		function deleteRecord(id, dkn) {
			$.ajax({
				type: "POST",
				url: "./adminaction.php",
				data: { mode: "delete", id: id, dkn: dkn },
				success: function (msg) {
					if (msg == "OK") getData();
					else alert(msg);
				}
			});
		}
		function clearSettings() {
			page.value = 1;
			perpage.value = 50;
			search.value = "";
			sortby.selectedIndex = 0;
			ascdesc.selectedIndex = 0;
			getData();
		}
		function clrData() {
			var inputs = document.querySelectorAll(".insert");
			for (var i = 0; i < inputs.length - 2; i++) inputs[i].value = "";
		}
		function clrDataU() {
			var inputs = document.querySelectorAll(".insertU");
			for (var i = 1; i < inputs.length - 2; i++) inputs[i].value = "";
		}
		function insertData() {
			$.ajax({
				type: "POST",
				url: "./adminaction.php",
				data: { mode: "insert", dkn: dknIn.value, nazwa: nazwaIn.value, nazwaStacji: nazwaStacjiIn.value, infraPoczta: infraPocztaIn.value, infraKod: infraKodIn.value, infraUlica: infraUlicaIn.value, infraNrLokalu: infraNrLokaluIn.value, Latitude: LatitudeIn.value, Longitude: LongitudeIn.value },
				success: function (msg) {
					if (msg != "OK") alert(msg);
					else getData();
				}
			});
		}
		function updateDataPopup(id) {
			var row = document.querySelector("#tr_" + id);
			update.style.display = "table";
			update.style.visibility = "visible";
			var updateInserts = document.querySelectorAll(".insertU");
			for (var i = 0; i < row.children.length - 1; i++) {
				updateInserts[i].value = row.children[i].innerHTML;
			}
		}
		function updateData() {
			$.ajax({
				type: "POST",
				url: "./adminaction.php",
				data: { mode: "update", id: idU.value, dkn: dknInU.value, nazwa: nazwaInU.value, nazwaStacji: nazwaStacjiInU.value, infraPoczta: infraPocztaInU.value, infraKod: infraKodInU.value, infraUlica: infraUlicaInU.value, infraNrLokalu: infraNrLokaluInU.value, Latitude: LatitudeInU.value, Longitude: LongitudeInU.value },
				success: function (msg) {
					if (msg != "OK") alert(msg);
					else getData();
					cancelUpdate();
				}
			});
		}
		function cancelUpdate() {
			clrDataU();
			update.style.display = "none";
			update.style.visibility = "hidden";
		}
	</script>
</head>

<?php
session_start();
include "adminconfig.php";
if (empty($_SESSION['logged'])) {
	if (empty($_POST['pass']) || empty($_POST['login'])) {
		?>

		<body>
			<header class="flex-row flex-justify-center flex-align-center flex-row-media">
				<a href="#" class="flex-row flex-align-center gap20 header flex-row-media">
					<img src="img/icon.png" alt="" />
					<h1>eTanieTankowanie - Lista Stacji</h1>
				</a>
				<nav class="flex-row gap20 menu">
					<a href="#">
						<div class="menu-option">Strona główna</div>
					</a>
					<a href="#">
						<div class="menu-option">Kontakt</div>
					</a>
					<a href="#">
						<div class="menu-button">Centrum pomocy</div>
					</a>
				</nav>
				<div class="hamburger">
					<span class="bar"></span>
					<span class="bar"></span>
					<span class="bar"></span>
				</div>
			</header>

			<main class="flex-col flex-justify-center" style="height: 75vh;">
				<form method="POST" action="">
					<div class="flex-col flex-align-center">
						<input type="text" name="login" placeholder="Login"></br>
						<input type="password" name="pass" placeholder="Hasło"></br>
						<input type="submit" class="menu-button button" value="ZALOGUJ" name="submit">
					</div>
				</form>
			</main>
			<script src="main.js"></script>
		</body>
		<?php
	} else {
		$login = htmlentities($_POST['login'], ENT_QUOTES, 'UTF-8');
		$pass = htmlentities($_POST['pass'], ENT_QUOTES, 'UTF-8');
		if ($pass != $PASSWORD || $login != $LOGIN) {
			?>

			<body>
				<header class="flex-row flex-justify-center flex-align-center flex-row-media">
					<a href="#" class="flex-row flex-align-center gap20 header flex-row-media">
						<img src="img/icon.png" alt="" />
						<h1>eTanieTankowanie - Lista Stacji</h1>
					</a>
					<nav class="flex-row gap20 menu">
						<a href="#">
							<div class="menu-option">Strona główna</div>
						</a>
						<a href="#">
							<div class="menu-option">Kontakt</div>
						</a>
						<a href="#">
							<div class="menu-button">Centrum pomocy</div>
						</a>
					</nav>
					<div class="hamburger">
						<span class="bar"></span>
						<span class="bar"></span>
						<span class="bar"></span>
					</div>
				</header>

				<center>
					<main class="flex-col flex-justify-center" style="height: 75vh;">
						<p class="p-text"> Niepoprawne dane. </p>
					</main>
				</center>

				<script src="main.js"></script>
			</body>
			<?php
			echo "<meta http-equiv=\"refresh\" content=\"3\" />";
		} else {
			$_SESSION['logged'] = true;
			header("Refresh:0");
		}
	}

} else {
	?>

	<body>
		<header class="flex-row flex-justify-center flex-align-center flex-row-media">
			<a href="#" class="flex-row flex-align-center gap20 header flex-row-media">
				<img src="img/icon.png" alt="" />
				<h1>eTanieTankowanie - Lista Stacji</h1>
			</a>
			<nav class="flex-row gap20 menu">
				<a href="#">
					<div class="menu-option">Strona główna</div>
				</a>
				<a href="#">
					<div class="menu-option">Kontakt</div>
				</a>
				<a href="#">
					<div class="menu-button">Centrum pomocy</div>
				</a>
				<a href="./logout.php">
					<input type="button" class="logout-button button" value="WYLOGUJ" />
				</a>
			</nav>
			<div class="hamburger">
				<span class="bar"></span>
				<span class="bar"></span>
				<span class="bar"></span>
			</div>
		</header>

		<main class="flex-col flex-justify-center gap50">

			<section id="update" class="update border">
				<h2 style="margin-bottom: 20px;">Edytuj stacje:</h2>
				<div class="flex-row gap10" style="margin-bottom: 25px;">
					<input type="text" name="idU" id="idU" class="insertU table-text-input" readonly="true" disabled />

					<input type="text" placeholder="dkn" name="dknIn" id="dknInU" class="insertU table-text-input" />

					<input type="text" placeholder="nazwa" name="nazwaIn" id="nazwaInU" class="insertU table-text-input" />

					<input type="text" placeholder="nazwaStacji" name="nazwaStacjiIn" id="nazwaStacjiInU"
						class="insertU table-text-input" />

					<input type="text" placeholder="infraPoczta" name="infraPocztaIn" id="infraPocztaInU"
						class="insertU table-text-input" />
				</div>

				<div class="flex-row gap10" style="margin-bottom: 25px;">
					<input type="text" placeholder="infraKod" name="infraKodIn" id="infraKodInU"
						class="insertU table-text-input" />

					<input type="text" placeholder="infraUlica" name="infraUlicaIn" id="infraUlicaInU"
						class="insertU table-text-input" />

					<input type="text" placeholder="infraNrLokalu" name="infraNrLokaluIn" id="infraNrLokaluInU"
						class="insertU table-text-input" />

					<input type="text" placeholder="Latitude" name="LatitudeIn" id="LatitudeInU"
						class="insertU table-text-input" />

					<input type="text" placeholder="Longitude" name="LongitudeIn" id="LongitudeInU"
						class="insertU table-text-input" />
				</div>

				<div class="flex-row flex-space-between">
					<div class="flex-row gap20">
						<input type="button" value="ZAKTUALIZUJ" onclick="updateData()" class="insertU table-button" />
						<input type="button" value="WYCZYŚĆ" onclick="clrDataU()" class="insertU table-button" />
					</div>

					<input type="button" value="ANULUJ" onclick="cancelUpdate()"
						class="insertUO table-button margin-top15-media" />
				</div>
			</section>

			<section class="flex-col gap20 border">
				<h2>Dodaj stacje:</h2>
				<div class="flex-row flex-justify-center gap10 flex-align-center-media">
					<div class="flex-row gap10 flex-row-media gap20-media">
						<input type="text" style="width: 100px;" placeholder="dkn" name="dknIn" id="dknIn" class="insert" />

						<input type="text" placeholder="nazwa" name="nazwaIn" id="nazwaIn"
							class="insert table-text-input" />
					</div>

					<input type="text" placeholder="nazwaStacji" name="nazwaStacjiIn" id="nazwaStacjiIn"
						class="insert table-text-input" />

					<div class="flex-row gap10 flex-row-media gap20-media">
						<input type="text" placeholder="infraPoczta" name="infraPocztaIn" id="infraPocztaIn"
							class="insert table-text-input" />

						<input type="text" placeholder="infraKod" name="infraKodIn" id="infraKodIn"
							class="insert table-text-input" />
					</div>

					<div class="flex-row gap10 flex-row-media gap20-media">
						<input type="text" placeholder="infraUlica" name="infraUlicaIn" id="infraUlicaIn"
							class="insert table-text-input" />

						<input type="text" placeholder="infraNrLokalu" name="infraNrLokaluIn" id="infraNrLokaluIn"
							class="insert table-text-input" />
					</div>

					<div class="flex-row gap10 flex-row-media gap20-media">
						<input type="text" placeholder="Latitude" name="LatitudeIn" id="LatitudeIn" class="insert"
							style="width: 100px;" />

						<input type="text" placeholder="Longitude" name="LongitudeIn" id="LongitudeIn" class="insert"
							style="width: 100px;" />
					</div>

					<div class="flex-row gap10 flex-row-media gap20-media margin-top15-media">
						<input type="button" class="insert table-button" value="DODAJ" onclick="insertData()" />
						<input type="button" class="insert table-button" value="WYCZYŚĆ" onclick="clrData()" />
					</div>
				</div>
			</section>

			<section class="flex-col gap20 border">
				<h2>Wyszukaj stacje:</h2>
				<center>
					<div class="settings flex-row flex-justify-center gap20 flex-align-center-media">
						<div class="flex-row gap20 flex-row-media">
							<input id="page" class="text-input" style="width: 100px" placeholder="PAGE" value="1" />
							<input id="perpage" class="text-input" style="width: 100px" placeholder="PERPAGE" value="50" />
						</div>

						<input id="search" class="text-input" style="width: 400px" placeholder="SZUKAJ" value="" />

						<div class="flex-row gap20 flex-row-media">
							<select class="table-text-input" name="sortby" id="sortby">
								<option value="id">id</option>
								<option value="dkn">dkn</option>
								<option value="nazwa">nazwa</option>
								<option value="nazwaStacji">nazwaStacji</option>
								<option value="'infraPoczta'">infraPoczta</option>
								<option value="'infraKod'">infraKod</option>
								<option value="'infraUlica'">infraUlica</option>
								<option value="'infraNrLokalu'">infraNrLokalu</option>
								<option value="'Latitude'">Latitude</option>
								<option value="'Longitude'">Longitude</option>
							</select>
							<select class="table-text-input" name="ascdesc" id="ascdesc">
								<option value="ASC">ASC</option>
								<option value="DESC">DESC</option>
							</select>
						</div>

						<div class="flex-row gap20 flex-row-media">
							<input type="button" class="menu-button button" onclick="getData()" value="WYSZUKAJ" />
							<input type="button" class="menu-button button" onclick="clearSettings()" value="WYCZYŚĆ" />
						</div>
					</div>
				</center>
			</section>

			<div id="datalist" class="datalist">
				<!--<table>
					<tr>
						<th>id</th>
						<th>dkn</th>
						<th>nazwa</th>
						<th>nazwa stacji</th>
						<th>infrapoczta</th>
						<th>infrakod</th>
						<th>infraulica</th>
						<th>infranrlokalu</th>
						<th>latitude</th>
						<th>longitude</th>
						<th style='text-align: center;'>X</th>
					</tr>
					<tr id="tr_1">
						<th>1</th>
						<td>18454</td>
						<td> RIA Sp. z o.o. </td>
						<td> Stacja Paliw nr 1</td>
						<td>Radomyśl</td>
						<td>37-455</td>
						<td>Rzeczyca Okrągła</td>
						<td>116</td>
						<td>50.6459</td>
						<td>22.0533191</td>
						<td>
							<div class="flex-row flex-justify-center gap10">
								<input type='button' class="table-button button" onclick='updateDataPopup(1)'
									value='EDYTUJ' />
								<input type='button' class="table-button button" onclick='deleteRecord()' value='USUŃ' />
							</div>
						</td>
					</tr>
					<tr id="tr_2">
						<th>2</th>
						<td>18454</td>
						<td> RIA Sp. z o.o. </td>
						<td> Stacja Paliw nr 2</td>
						<td>Grębów</td>
						<td>39-410</td>
						<td>Jamnica</td>
						<td>160</td>
						<td>50.57276969999999</td>
						<td>21.9411191</td>
						<td>
							<div class="flex-row flex-justify-center gap10">
								<input type='button' class="table-button button" onclick='updateDataPopup(2)'
									value='EDYTUJ' />
								<input type='button' class="table-button button" onclick='deleteRecord()' value='USUŃ' />
							</div>
						</td>
					</tr>
					<tr id="tr_3">
						<th>3</th>
						<td>18454</td>
						<td> RIA Sp. z o.o. </td>
						<td> Stacja Paliw nr 3</td>
						<td>Stalowa Wola</td>
						<td>37-450</td>
						<td>C.O.P.</td>
						<td>1</td>
						<td>50.5728611</td>
						<td>22.0593409</td>
						<td>
							<div class="flex-row flex-justify-center gap10">
								<input type='button' class="table-button button" onclick='updateDataPopup(3)'
									value='EDYTUJ' />
								<input type='button' class="table-button button" onclick='deleteRecord()' value='USUŃ' />
							</div>
						</td>
					</tr>
					<tr id="tr_4">
						<th>4</th>
						<td>18454</td>
						<td> RIA Sp. z o.o. </td>
						<td> Stacja Paliw nr 4</td>
						<td>Prysznica</td>
						<td>37-403</td>
						<td>Szubargi</td>
						<td>96</td>
						<td>50.5698848</td>
						<td>22.0977468</td>
						<td>
							<div class="flex-row flex-justify-center gap10">
								<input type='button' class="table-button button" onclick='updateDataPopup(4)'
									value='EDYTUJ' />
								<input type='button' class="table-button button" onclick='deleteRecord()' value='USUŃ' />
							</div>
						</td>
					</tr>
					<tr id="tr_5">
						<th>5</th>
						<td>18454</td>
						<td> RIA Sp. z o.o. </td>
						<td> Stacja Paliw nr 5</td>
						<td>Stalowa Wola</td>
						<td>37-450</td>
						<td>Solidarności</td>
						<td>6A</td>
						<td>50.5571074</td>
						<td>22.0654017</td>
						<td>
							<div class="flex-row flex-justify-center gap10">
								<input type='button' class="table-button button" onclick='updateDataPopup(5)'
									value='EDYTUJ' />
								<input type='button' class="table-button button" onclick='deleteRecord()' value='USUŃ' />
							</div>
						</td>
					</tr>
				</table>-->
			</div>

		</main>

		<script src="main.js"></script>
	</body>
	<?php
}
?>

</html>