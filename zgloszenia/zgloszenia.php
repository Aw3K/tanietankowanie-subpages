<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script>
		function load_home() {
			fetch("./zgloszenialist.php")
				.then((response) => response.text())
				.then((html) => {
					document.getElementById("datalist").innerHTML = html;
				})
				.catch((error) => {
					console.warn(error);
				});
		}
		function getAllMarked() {
			var list = document.querySelectorAll('#deleteCheck');
			var idList = [];
			for (var i = 0; i < list.length; i++) {
				if (list[i].checked) idList.push(list[i].value);
			}
			$.ajax({
				type: 'post',
				url: './adminaction.php',
				data: {
					ids: idList,
				},
				success: function (data) {
					console.log(data);
					load_home();
				},
			});
		}
	</script>

</head>
<?php
session_start();
//$_SESSION['logged'] = false;
include "adminconfig.php";
if (empty($_SESSION['logged'])) {
	if (empty($_POST['pass']) || empty($_POST['login'])) {
		?>

		<body>
			<header class="flex-row flex-justify-center flex-align-center flex-row-media">
				<a href="#" class="flex-row flex-align-center gap20 header flex-row-media">
					<img src="img/icon.png" alt="" />
					<h1>eTanieTankowanie - Admin Panel</h1>
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

			<main class="flex-col flex-justify-center">
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
						<h1>eTanieTankowanie - Admin Panel</h1>
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
					<main class="flex-col flex-justify-center">
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
				<h1>eTanieTankowanie - Admin Panel</h1>
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

		<main class="flex-col flex-justify-center gap20">
			<div id="datalist" class="datalist">
				<?php
				include("zgloszenialist.php");
				?>

				<!--<table>
					<tr>
						<th>Id</th>
						<th>User Id</th>
						<th>Opis</th>
						<th>Lat</th>
						<th>Long</th>
						<th></th>
					</tr>
					<tr>
						<td>1</td>
						<td>gedrrgdrgrdhr</td>
						<td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque totam eaque alias quia officia
							molestiae!</td>
						<td>52</td>
						<td>51</td>
						<td><input type="checkbox" name="" id=""></td>
					</tr>
					<tr>
						<td>2</td>
						<td>nhdhsgsgs</td>
						<td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore iure velit aspernatur vitae
							maxime, eaque dolores ducimus!</td>
						<td>53</td>
						<td>52</td>
						<td><input type="checkbox" name="" id=""></td>
					</tr>
					<tr>
						<td>3</td>
						<td>hgsrsegt3rfa</td>
						<td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam labore eos corrupti!</td>
						<td>53</td>
						<td>51</td>
						<td><input type="checkbox" name="" id=""></td>
					</tr>
				</table>-->
			</div>

			<div class="flex-row gap20 flex-row-media flex-justify-center-media">
				<input type="button" class="menu-button button" value="ROZWIĄZANE" onclick="getAllMarked()" />
				<a href="./logout.php"><input type="button" class="menu-button button" value="WYLOGUJ" /></a>
			</div>
		</main>

		<script src="main.js"></script>
	</body>
	<?php
}
?>

</html>