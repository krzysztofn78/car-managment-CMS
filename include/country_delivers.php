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
        <h1>Zarządzanie wyjazdami krajowymi</h1>
        <p>
            <a class="btn btn-warning" href="../index.php" title="Home">Strona Główna</a>
            <a class="btn btn-info" href="../include/delivers.php" title="Wyjazdy">Wyjazdy</a>
            <?php if (!isset($_GET['create_country'])) echo "<a class='btn btn-success' href=\"?create_country\" title=\"Dodaj wyjazd krajowy\">Dodaj wyjazd krajowy</a>" ?>
        </p>
        <?php
        function create_country($db, $driver, $cars)
        {
        ?>
            <form method="POST" action="?saveCountry">


                <div class="container shadow-lg p-3 mb-5 bg-white rounded">
                    <h2>Dodawanie wyjazdu Krajowego</h2>
                    <div class="row">
                        <div class="col-2">
                            <label for="data">Data wyjazdu:</label>
                            <input type="date" id="data" value="" name="data" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="driver">Kierowca:</label>
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
                        <div class="col-2">
                            <label for="masterNumber">Numer Mastera:</label>
                            <input type="text" id="masterNumber" value="" name="masterNumber" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="customer">Klient:</label>
                            <input type="text" id="customer" value="" name="customer" class="form-control">
                        </div>
                        <div class="col-2">
                            <label for="destination">Miejscowość:</label>
                            <input type="text" id="destination" value="" name="destination" class="form-control">
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
                    </div>
                    <p></p>
                    <p></p>
                    <p></p>
                    <a class="btn btn-danger" href="../include/delivers.php">Anuluj</a>&nbsp;&nbsp;
                    <button type="submit" class="btn btn-success">Zapisz dane</button>
            </form>
        <?php
        }
        function render_data($result)
        {
            echo "<table class='table table-striped table-hover'>\n";
            echo '<thead><tr>
			<th>Data</th>
			<th>Kierowca</th>
			<th>Miejscowość</th>
			<th>Klient</th>
			<th>Samochód</th>
			<th>Ilość kilometrów</th>
			<th>P początkowy</th>
			<th>P końcowy</th>
			<th>Ilość paliwa</th>
			<th>Średnie spalanie</th>
			</tr></thead>' . "\n";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>\n";
                echo "<td>
			" . $row['data1'] . "</td><td>
            " . $row['last_name'] . " " . $row['first_name'] . "</td><td>
			" . $row['destination'] . "</td><td>
			" . $row['customer'] . "</td><td>
			" . $row['registration'] . "</td><td>
			" . $row['distance'] . "</td><td>
			" . $row['distanceBefore'] . "</td><td>
			" . $row['distanceAfter'] . "</td><td>
			" . $row['refueling'] . "</td><td>
			" . $row['avgsc'] . "</td>\n";
                echo "</tr>\n";
            }
            echo "</table>\n";
        }

        if (isset($_GET['create_country'])) {

            $sql = "SELECT * FROM drivers";
            $resaultDriver = $db->query($sql);
            $driver = $resaultDriver->fetch_All();
            $sql = "SELECT * FROM cars";
            $resaultCars = $db->query($sql);
            $cars = $resaultCars->fetch_All();

            create_country($db, $driver, $cars);
            //koniec wywołania funkcji
        } elseif (isset($_GET['saveCountry'])) {
            $data1 = $_POST['data'];
            $driver = $_POST['driver'];
            $driver2 = 1; //brak kierowcy
            $dest = $_POST['destination'];
            $cus = $_POST['customer'];
            $car = $_POST['car'];
            $before = $_POST['distasnceBefore'];
            $after = $_POST['distasnceAfter'];
            $distance = $after - $before;
            $refueling = $_POST['refueling'];
            $avgsc = ($refueling / $distance) * 100;
            $deliveryTo = "countryDelivers";

            $sql = "INSERT INTO delivers (data1,driver,driver2,destination,customer,car,distance,distanceBefore,distanceAfter,refueling,avgsc,deliveryTo) VALUES ('$data1','$driver','$driver2','$dest','$cus','$car','$distance','$before','$after','$refueling','$avgsc','$deliveryTo')";
            $result = $db->query($sql);

            echo $result;
            if ($db->affected_rows == 1) {
                $sql = "SELECT 
                delivers.delivers_id,
                delivers.data1,
                delivers.driver,
                delivers.destination,
                delivers.customer,
                delivers.car,
                delivers.distance,
                delivers.distanceBefore,
                delivers.distanceAfter,
                delivers.refueling,
                delivers.avgsc,
                drivers.last_name,
                drivers.first_name,
                cars.registration FROM delivers LEFT JOIN drivers ON driver=driver_id LEFT JOIN cars ON car=cars_id WHERE deliveryTo LIKE 'countryDelivers'";
                $result = $db->query($sql);
                render_data($result);
            } else {
                echo "Dodawanie wyjazdu krajowego nie powiodło się.";
            }
        } else {
            $sql = "SELECT 
            delivers.delivers_id,
            delivers.data1,
            delivers.driver,
            delivers.destination,
            delivers.customer,
            delivers.car,
            delivers.distance,
            delivers.distanceBefore,
            delivers.distanceAfter,
            delivers.refueling,
            delivers.avgsc,
            drivers.last_name,
            drivers.first_name,
            cars.registration FROM delivers LEFT JOIN drivers ON driver=driver_id LEFT JOIN cars ON car=cars_id WHERE deliveryTo LIKE 'countryDelivers'";
            $result = $db->query($sql);
            render_data($result);
        }
        $db->close();
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>