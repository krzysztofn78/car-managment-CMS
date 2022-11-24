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
	<div id="wrapper">
		<h1>Zarządzanie kierowcami</h1>
		<p>
			<a class="btn btn-warning" href="../index.php" title="Home">Strona Główna</a>
			<a class="btn btn-info" href="../include/delivers.php" title="Wyjazdy">Wyjazdy</a>
			<?php if (!isset($_GET['create'])) echo "<a class='btn btn-success' href=\"?create\" title=\"Create a Record\">Dodaj kierowcę</a>" ?>
		</p>
		<?php
		function create_record()
		{
			echo "<p>Dodawanie Kierowcy</p>";
		?>
			<form method="POST" action="?save">
				<p><label for="first_name">Imię:</label>
					<input type="text" id="first_name" value="" name="first_name">
				</p>
				<p><label for="last_name">Nazwisko:</label>
					<input type="text" id="last_name" value="" name="last_name">
				</p>
				<p><label for="phone">Telefon:</label>
					<input type="text" id="phone" value="" name="phone">
				</p>
				<a href="../include/drivers.php">Anuluj</a>&nbsp;&nbsp;
				<input type="submit" value="Zapisz dane">
			</form>
		<?php
		}
		function render_data($result)
		{
			echo "<table class='table table-striped table-hover'>\n";
			echo '<tr>
			<th>Sortowanie=></th>
			<th><a class="btn btn-info" href="?sort=first_name">Imię</a></th>
			<th><a class="btn btn-info" href="?sort=last_name">Nazwisko</a></th>
			<th><a class="btn btn-info" href="?sort=phone">Telefon</a></th>
			</tr>' . "\n";
			while ($row = $result->fetch_assoc()) {
				echo "<tr>\n";
				echo "<td><a class='btn btn-warning' href=\"?edit={$row['driver_id']}\">Edycja</a></td><td>
			" . $row['first_name'] . "</td><td>
			" . $row['last_name'] . "</td><td>
			" . $row['phone'] . "</td>\n";
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		function edit_data($db, $id)
		{
			echo "<p>Edycja danych kierowcy: </p>";
			$sql = "SELECT * FROM drivers WHERE driver_id=$id LIMIT 1";
			$result = $db->query($sql);
			$row = $result->fetch_assoc();
			$first = $row['first_name'];
			$last = $row['last_name'];
			$phone = $row['phone'];
		?>
			<form method="POST" action="?update=<?php echo $id; ?>">
				<input type="hidden" name="id" id="id" Value="<?php echo $row['driver_id']; ?>" readonly>
				<p><label for="first_name">Imię:</label>
					<input type="text" id="first_name" value="<?php echo $first; ?>" name="first_name">
				</p>
				<p><label for="last_name">Nazwisko:</label>
					<input type="text" id="last_name" value="<?php echo $last; ?>" name="last_name">
				</p>
				<p><label for="last_name">Telefon:</label>
					<input type="text" id="phone" value="<?php echo $phone; ?>" name="phone">
				</p>
				<p>
					<a href="../include/drivers.php">Anuluj</a>&nbsp;&nbsp;
					<input type="submit" value="Zapisz nowe dane.">
				</p>
			</form>
		<?php
		}
		if (isset($_GET['sort'])) {
			//echo "<h2>Sorting data by: " . $_GET['sort'] . "</h2>\n";
			$sql = "SELECT * FROM drivers ORDER BY {$_GET['sort']}";
			$resault = $db->query($sql);
			render_data($resault);
		} elseif (isset($_GET['edit'])) {
			edit_data($db, $_GET['edit']);
		} elseif (isset($_GET['update'])) {
			$sql = "UPDATE drivers SET first_name='{$_POST['first_name']}',last_name='{$_POST['last_name']}',phone='{$_POST['phone']}' WHERE driver_id={$_POST['id']} LIMIT 1";
			$result = $db->query($sql);
			if ($result) {
				$sql = "SELECT * FROM drivers";
				$result = $db->query($sql);
				render_data($result);
			} else {
				echo "Edycja danych kierowcy nie powiodła się.";
				echo $sql;
			}
		} elseif (isset($_GET['create'])) {
			create_record($db);
		} elseif (isset($_GET['save'])) {
			$first = $_POST['first_name'];
			$last = $_POST['last_name'];
			$phone = $_POST['phone'];
			$sql = "INSERT INTO drivers (first_name,last_name,phone,updated_by) VALUES ('$first','$last','$phone','1')";
			$result = $db->query($sql);
			if ($db->affected_rows == 1) {
				$sql = "SELECT * FROM drivers";
				$result = $db->query($sql);
				render_data($result);
			} else {
				echo "Dodawanie kierowcy nie powiodło się.";
			}
		} else {
			$sql = "SELECT * FROM drivers";
			$result = $db->query($sql);
			render_data($result);
		}
		$db->close();
		?>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>