<?php
session_start();
include("connection.php");
include("functions.php");
$user_data = check_login($con);
?>

<html lang="pl">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>auto-moto-cms</title>
	<link rel="stylesheet" href="../include/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
	<header>
		<div class="container">
			<span class="header__logo">
			</span>
			<div class="header__links">
				<a class="btn btn-dark" href="../logout.php">Wyloguj</a>
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
					<a href="../include/drivers.php" class="btn--yellow">Zarządzanie kierowcami</a>
					<a href="../include/delivers.php" class="btn--yellow">Zarządzanie wyjazdami </a>
					<a href="../include/cars.php" class="btn--yellow">Zarządzanie samochodami</a>
					<a href="../include/reports.php" class="btn--yellow">Raporty</a>
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>