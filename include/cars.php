<?php
session_start();
require '../includes/mysqli_connect.inc.php';
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
	<div class="container-fluid">

		<h1>Zarządzanie samochodami</h1>
		<p>
			<a class="btn btn-warning" href="../index.php" title="Home">Strona Główna</a>
			<a class="btn btn-info" href="../include/cars.php" title="Samochodzy">Samochody</a>
			<?php if (!isset($_GET['create'])) echo "<a class='btn btn-success' href=\"?create\" title=\"Dodaj samochód\">Dodaj samochód</a>" ?>
		</p>
		<?php
		function create_record()
		{
			echo "<p>Dodawanie Samochodu</p>";
		?>
			<form method="POST" action="?save">
				<p><label for="registration">Numer rejestracyjny:</label>
					<input type="text" id="registration" value="" name="registration">
				</p>
				<input type="submit" value="Zapisz dane">
			</form>
		<?php
		}
		function render_data($result)
		{
			echo "<table class='table table-striped table-hover'>\n";
			echo '<tr>
			<th>Sortowanie=></th><th></th>
			<th><a class="btn btn-info" href="?sort=registration">Rejestracja</a></th>
			</tr>' . "\n";
			while ($row = $result->fetch_assoc()) {
				echo "<tr>\n";
				echo "<td><a class='btn btn-warning' href=\"?edit={$row['cars_id']}\">Edycja</a></td>
				<td><a class='btn btn-warning' href=\"?info={$row['cars_id']}\">Informacje</a></td>
				<td>" . $row['registration'] . "</td>\n";
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		function edit_data($db, $id)
		{
			echo "<p>Edycja danych samochodu: </p>";
			$sql = "SELECT * FROM cars WHERE cars_id=$id LIMIT 1";
			$result = $db->query($sql);
			$row = $result->fetch_assoc();
			$reg = $row['registration'];
		?>
			<form method="POST" action="?update=<?php echo $id; ?>">
				<input type="hidden" name="id" id="id" Value="<?php echo $row['cars_id']; ?>" readonly>
				<p><label for="registraton">Numer rejestracyjny:</label>
					<input type="text" id="registraton" value="<?php echo $reg; ?>" name="registraton">
				</p>
				<p>
					<a href="../include/cars.php">Anuluj</a>&nbsp;&nbsp;
					<input type="submit" value="Zapisz nowe dane.">
				</p>
			</form>
		<?php
		}
		//testowo
		function info_data($db, $id)
		{
			echo "<p>Informacje o samochodzie: </p>";
			$sql = "SELECT * FROM cars WHERE cars_id=$id LIMIT 1";
			$result = $db->query($sql);


			echo '<pre>';
			print_r($_GET);
			echo '</pre>';

			echo '<pre>';
			print_r($result);
			echo '</pre>';
			// tutaj wstawic wszystko od informacji i możliwość dodawania przeglądów serwisów i wymian opon
			//	przeglądy techniczne - przeglądy olresowe , wymiany opon wszystko w jednej tabeli 
			$row = $result->fetch_assoc();
			$reg = $row['registration'];
			echo $reg;
			echo '<pre>';
			print_r($reg);
			echo '</pre>';
		?>

		<?php
		}
		if (isset($_GET['sort'])) {
			$sql = "SELECT * FROM cars ORDER BY {$_GET['sort']}";
			$resault = $db->query($sql);
			render_data($resault);
		} elseif (isset($_GET['edit'])) {
			edit_data($db, $_GET['edit']);
		} elseif (isset($_GET['info'])) {
			info_data($db, $_GET['info']);
		} elseif (isset($_GET['update'])) {
			$sql = "UPDATE cars SET registration='{$_POST['registration']}' WHERE cars_id={$_POST['id']} LIMIT 1";
			$result = $db->query($sql);
			if ($result) {
				$sql = "SELECT * FROM cars";
				$result = $db->query($sql);
				render_data($result);
			} else {
				echo "Edycja danych samochodu nie powiodła się.";
				echo $sql;
			}
		} elseif (isset($_GET['create'])) {
			create_record($db);
		} elseif (isset($_GET['save'])) {
			$reg = $_POST['registration'];
			$sql = "INSERT INTO cars (registration) VALUES ('$reg')";
			$result = $db->query($sql);
			if ($db->affected_rows == 1) {
				$sql = "SELECT * FROM cars";
				$result = $db->query($sql);
				render_data($result);
			} else {
				echo "Dodawanie samochodu nie powiodło się.";
			}
		} else {
			$sql = "SELECT * FROM cars";
			$result = $db->query($sql);
			render_data($result);
		}
		$db->close();
		?>
	</div>

	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>