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
        <h1>Zarządzanie wyjazdami SUUS</h1>
        <p>
            <a class="btn btn-warning" href="../index.php" title="Home">Strona Główna</a>
            <a class="btn btn-info" href="../include/delivers.php" title="Wyjazdy">Wyjazdy</a>
            <?php if (!isset($_GET['create_suus'])) echo "<a class='btn btn-success' href=\"?create_suus\" title=\"Dodaj wyjazd SUUS\">Dodaj wyjazd SUUS</a>" ?>
        </p>
        <?php
        function create_suus($db, $driver, $cars)
        {
        ?>
            <form method="POST" action="?saveSuus">
                <div class="container shadow-lg p-3 mb-5 bg-white rounded">
                    <h2>Dodawanie wyjazdu SUUS</h2>
                    <div class="row">
                        <div class="col-2">
                            <label for="data">Data wyjazdu:</label>
                            <input type="date" id="data" value="" name="data" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="driver">Kierowca1:</label>
                            <select class="form-control" name="driver">
                                <?php
                                foreach ($driver as $driv) {
                                    echo '<option value=' . $driv[0] . '>';
                                    echo $driv[2] . " ";
                                    echo $driv[1];
                                    echo '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="driver2">Kierowca2:</label>
                            <select class="form-control" name="driver2">
                                <?php
                                foreach ($driver as $driv) {
                                    echo '<option value=' . $driv[0] . '>';
                                    echo $driv[2] . " ";
                                    echo $driv[1];
                                    echo '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="castDriver">Obsada:</label>
                            <select class="form-control" name="castDriver">
                                <option value='1'>Jedna osoba</option>
                                <option value='2'>Dwie osoby</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="car">Samochód:</label>
                            <select class="form-control" name="car">
                                <?php
                                foreach ($cars as $car) {
                                    echo '<option value=' . $car[0] . '>';
                                    echo $car[1];
                                    echo '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="distanceBefore">Licznik początkowy:</label>
                            <input type="text" id="distanceBefore" value="" name="distasnceBefore" class="form-control">
                        </div>
                        <div class="col-2">
                            <label for="dictanceAfter">Licznik końcowy:</label>
                            <input type="text" id="distanceAfter" value="" name="distasnceAfter" class="form-control">
                        </div>
                        <div class="col-2">
                            <label for="refueling">Ilość paliwa:</label>
                            <input type="text" id="refueling" value="" name="refueling" class="form-control">
                        </div>
                        <div class="col-2">
                            <label for="masterNumber">Numer Mastera:</label>
                            <input type="text" id="masterNumber" value="" name="masterNumber" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="sheduledShipments">Dostawy planowane:</label>
                            <input type="text" id="sheduledShipments" value="" name="sheduledShipments" class="form-control">
                        </div>
                        <div class="col-2">
                            <label for="completedShipments">Dostawy zrealizowane:</label>
                            <input type="text" id="completedShipments" value="" name="completedShipments" class="form-control">
                        </div>
                        <div class="col-2">
                            <label for="sheduledPickups">Kolekcje planowane:</label>
                            <input type="text" id="sheduledPickups" value="" name="sheduledPickups" class="form-control">
                        </div>
                        <div class="col-2">
                            <label for="completedPickups">Kolekcje zrealizowane:</label>
                            <input type="text" id="completedPickups" value="" name="completedPickups" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <label for="completedPickups">Rozpoczęcie pracy:</label>
                            <input type="time" id="startTime" value="" name="startTime" class="form-control">
                        </div>
                        <div class="col-1">
                            <label for="completedPickups">Zakończenie pracy:</label>
                            <input type="time" id="endTime" value="" name="endTime" class="form-control">
                        </div>
                    </div>
                    <p></p>
                    <p></p>
                    <p></p>
                    <a class="btn btn-danger" href="../include/delivers.php">Anuluj</a>&nbsp;&nbsp;
                    <button type="submit" class="btn btn-success">Zapisz dane</button>
                </div>
            </form>
        <?php
        }
        function render_data($result)
        {
            echo "<table class='table table-striped table-hover'>\n";
            echo '<tr>
			<th>Data</th>
			<th>Kierowca1</th>
            <th>Kierowca2</th>
            <th>Obsada</th>
			<th>Samochód</th>
			<th>Ilość kilometrów</th>
			<th>P początkowy</th>
			<th>P końcowy</th>
			<th>Ilość paliwa</th>
			<th>Średnie spalanie</th>
            <th>Nr. mastera</th>
            <th>D/P</th>
            <th>D/R</th>
            <th>K/P</th>
            <th>K/R</th>
            <th>G/P</th>
            <th>G/K</th>
			</tr>' . "\n";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>\n";
                echo "<td>
			" . $row['data1'] . "</td><td>
			" . $row['last_name'] . " " . $row['first_name'] . "</td><td> 
            " . $row['h_last_name'] . " " . $row['h_first_name'] . "</td><td> 
            " . $row['castDriver'] . "</td><td>
			" . $row['registration'] . "</td><td>
			" . $row['distanceBefore'] . "</td><td>
			" . $row['distanceAfter'] . "</td><td>
            " . $row['distance'] . "</td><td>
			" . $row['refueling'] . "</td><td>
            " . $row['avgsc'] . "</td><td>
            " . $row['masterNumber'] . "</td><td>
            " . $row['sheduledShipments'] . "</td><td>
            " . $row['completedShipments'] . "</td><td>
            " . $row['sheduledPickups'] . "</td><td>
            " . $row['completedPickups'] . "</td><td>
            " . $row['startTime'] . "</td><td>
            " . $row['endTime'] . "</td>\n";
                echo "</tr>\n";
            }
            echo "</table>\n";
        }
        //poniżej dodawanie trasy suus
        if (isset($_GET['create_suus'])) {
            $sql = "SELECT * FROM drivers";
            $resaultDriver = $db->query($sql);
            $driver = $resaultDriver->fetch_All();
            $sql = "SELECT * FROM cars";
            $resaultCars = $db->query($sql);
            $cars = $resaultCars->fetch_All();
            create_suus($db, $driver, $cars);
            //koniec wywołania funkcji
        } elseif (isset($_GET['saveSuus'])) {
            $data1 = $_POST['data'];
            $driver = $_POST['driver'];
            $driver2 = $_POST['driver2'];
            $car = $_POST['car'];
            $before = $_POST['distasnceBefore'];
            $after = $_POST['distasnceAfter'];
            $distance = $after - $before;
            $refueling = $_POST['refueling'];
            $deliveryTo = "suusDelivers";
            $master = $_POST['masterNumber'];
            $sheduledShipments = $_POST['sheduledShipments'];
            $completedShipments = $_POST['completedShipments'];
            $sheduledPickups = $_POST['sheduledPickups'];
            $completedPickups = $_POST['completedPickups'];
            $castDriver = $_POST['castDriver'];
            $ST = $_POST['startTime'];
            $ET = $_POST['endTime'];
            $sql = "INSERT INTO delivers (data1,driver,driver2,car,distance,distanceBefore,distanceAfter,masterNumber,sheduledShipments,completedShipments,sheduledPickups,completedPickups,refueling,deliveryTo,castDriver,startTime,endTime) VALUES ('$data1','$driver','$driver2','$car','$distance','$before','$after','$master','$sheduledShipments','$completedShipments','$sheduledPickups','$completedPickups','$refueling','$deliveryTo','$castDriver','$ST','$ET')";
            $result = $db->query($sql);
            if ($db->affected_rows == 1) {
                $sql = "SELECT 
                        delivers.*, 
                        drivers.last_name,
                        drivers.first_name,
                        driversHelper.h_last_name,
                        driversHelper.h_first_name,
                        cars.registration 
                        FROM delivers 
                        LEFT JOIN drivers ON delivers.driver=drivers.driver_id 
                        LEFT JOIN driversHelper ON delivers.driver2=driversHelper.h_driver_id 
                        LEFT JOIN cars ON car=cars_id 
                        WHERE deliveryTo LIKE 'suusDelivers'
                        ORDER BY data1";
                $result = $db->query($sql);
                render_data($result);
            } else {
                echo "Dodawanie wyjazdu SUUS nie powiodło się.";
            }
        } else {
            $sql = "SELECT
                        delivers.*, 
                        drivers.last_name,
                        drivers.first_name,
                        driversHelper.h_last_name,
                        driversHelper.h_first_name,
                        cars.registration 
                        FROM delivers 
                        LEFT JOIN drivers ON delivers.driver=drivers.driver_id 
                        LEFT JOIN driversHelper ON delivers.driver2=driversHelper.h_driver_id 
                        LEFT JOIN cars ON car=cars_id 
                        WHERE deliveryTo LIKE 'suusDelivers'
                        ORDER BY data1";
            $result = $db->query($sql);
            render_data($result);
        }
        $db->close();
        ?>
    </div>
</body>

</html>