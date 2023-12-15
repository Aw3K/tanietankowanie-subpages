<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

	<style>
		#reload {
			position: absolute;
			top: 5px;
			right: 0%;
		}

		#logout {
			position: absolute;
			top: 55px;
			right: 0%;
		}
	</style>
</head>
<?php
session_start();
include "adminconfig.php";
//$_SESSION['logged'] = false;
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
		<div id="imageFrame"></div>
		<div id="imageNumber"></div>
		<div id="imageDataField" value="0"></div>
		<div class="textB" id="leftChange" onclick="changeImage('left')">&lHar;</div>
		<div class="textB" id="rightChange" onclick="changeImage('right')">&rHar;</div>
		<div class="textB" id="deleteImage" onclick="deleteImage()">SUPRIMIR ELIMINAR</div>
		<input type="button" class="menu-button button" onclick="reloadImages()" id="reload" value="Odśwież zdjęcie" />
		<input type="button" class="menu-button button" id="logout" onclick="location.href = './logout.php';"
			value="Wyloguj" />
		<script> var fileLoc = <?php echo "\"" . $fileData . "\"" ?>; var imageLoc = <?php echo "\"" . $imageDir . "\"" ?>; </script>
		<script src="imageexplorer.js"></script>
	</body>
	<?php
}
?>

</html>