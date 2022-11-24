<?php
session_start();
include("../connection.php");
include("../functions.php");
$user_data = check_login($con);
?>

<html lang="pl">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>auto-moto-cms</title>
	<link rel="stylesheet" href="../include/style.css">
</head>

<body>
	<header>
		<div class="container">
			<span class="header__logo">
			</span>
			<div class="header__links">
				<a href="logout.php">Wyloguj</a>
			</div>
		</div>
	</header>

	<section class="section section--landing-hero">
		<div class="container">
			<div class="column__content--left">
				<h1 class="landing-hero__title">
					Witaj <?php echo $user_data['user_name']; ?> na stronie </br> <span class="yellow">CMS Auto-Moto</span>
				</h1>
				<p class="landing-hero__description">
					Zarządzanie kierowcami, samochodami, wyjazdami czy paletami w jednym miejscu.
				</p>
				<div class="landing-hero__btn">
					<h2>Wybierz funkcję:</h2>
					<a href="../index.php" class="btn--yellow">Powrót</a>
					<a href="../include/country_delivers.php" class="btn--yellow">Wyjazdy krajowe </a>
					<a href="../include/suus_delivers.php" class="btn--yellow">Wyjazdy SUUS</a>
					<a href="../include/depl_delivers.php" class="btn--yellow">Wyjazdy DE / PL</a>
				</div>
			</div>
			<div class="column__content--right">
				<img src="https://cyberfolks.pl/wp-content/themes/cyberfolks/landingi/image-landing-2.png" alt="Witamy na stronie" />
			</div>
		</div>
	</section>
	<section class="section--posts">
		<div class="container">
			<h2 class="posts__header title-yellow">Tutaj będą pokazywane wpisy odnośnie serwisów</h2>
			<div class="posts__list">
				<p>treść</p>
			</div>
		</div>
	</section>
</body>

</html>