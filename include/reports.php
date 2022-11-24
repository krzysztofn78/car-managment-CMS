<?php 
session_start();

	include("../connection.php");
	include("../functions.php");

	$user_data = check_login($con);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Auto-Moto CMS by Nowicki</title>
</head>
<body>

	<a href="../logout.php">Wyloguj</a>
	<h1>Raporty</h1>

	<br>
	Witaj, <?php echo $user_data['user_name']; ?>
	<a href="../include/drivers.php">Zarządzanie kierowcami</a>
	<a href="../include/delivers.php">Zarządzanie wyjazdami</a>
	<a href="../include/cars.php">Zarządzanie samochodami</a>
	<a href="../include/reports.php">Raporty</a>
</body>
</html>