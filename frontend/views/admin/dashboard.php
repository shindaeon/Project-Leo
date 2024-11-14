<?php
session_start();
if (!isset($_SESSION['emp_username'])) {
      header('Location: login.php');
}
if (!isset($_SESSION['terminal_session_id'])) {
      header('Location: busmanager.php');
}
$terminal_session_id = $_SESSION['terminal_session_id'];
include '../../controllers/dbConfig.php';
$query = $dbConnection->prepare("
      SELECT 
            buses.bus_number,
            buses.bus_plate_number,
            buses.bus_company_name,
            terminal_sessions.session_id,
            terminal_sessions.destination,
            terminal_sessions.departing_time,
            terminal_sessions.passengers,
            terminal_sessions.bus_status,
            terminal_sessions.fare_price,
            terminal_sessions.terminal_location
      FROM 
            buses
      INNER JOIN 
            terminal_sessions 
      ON 
            terminal_sessions.session_id = buses.current_terminal_session
      WHERE
            terminal_sessions.session_id = ?;
");
$query->bind_param('s', $terminal_session_id);
$query->execute();
$res = $query->get_result();
if ($res->num_rows > 0) {
      $session = $res->fetch_assoc();
      $currentbus = $session['bus_company_name'];
      $bus_number = $session['bus_number'];
      $plate_number = $session['bus_plate_number'];
      $destination = $session['destination'];
      $departing_time = $session['departing_time'];
      $passengers = json_decode($session['passengers']);
      $bus_status = $session['bus_status'];
      $fare_price = $session['fare_price'];

      //count booked passengers and scanned tickets
      $booked_passengers = 0;
      $total_seats = 0;
      $scanned_tickets = 0;
      foreach ($passengers as $passenger) {
            if ($passenger->status == 'reserved') {
                  $booked_passengers++;
            } elseif ($passenger->status == 'taken') {
                  $scanned_tickets++;
            }
            $total_seats++;
      }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
      <title>Project Leoforeio</title>
      <meta charset="UTF-8" />
      <link rel="icon" type="image/svg+xml" href="../../public/LogoCircle.png" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="../../src/css/bootstrap/bootstrap.css" />
      <link rel="stylesheet" href="../../src/css/typography.css" />
      <link rel="stylesheet" href="../../src/css/custom.css" />
      <link rel="stylesheet" href="../../node_modules/@flaticon/flaticon-uicons/css/bold/rounded.css" />
      <link rel="stylesheet" href="../../node_modules/@flaticon/flaticon-uicons/css/brands/all.css" />
</head>

<body>
      <div class='container-fluid p-2 bg-primary position-sticky fixed-top'>
            <div class='row'>
                  <div class='col d-flex align-items-center'>
                        <a href="../admin/busmanager.php">
                         <button class='btn btn-secondary btn-nav'><i class="fi fi-br-cross me-2"></i>Exit</button>
                        </a>
                  </div>
                  <div class='col d-flex justify-content-end align-items-center'>
                        <button class='btn btn-secondary btn-nav' onclick="logout()"><i class="fi fi-br-sign-out-alt me-2"></i>Logout</button>
                  </div>
            </div>
      </div>
      <div class="container p-3">
            <h1 class="text-primary">Dashboard</h1>
            <p>Now Managing: <br>
                  <span class="h5">
                        <?php
                        echo "$currentbus #$bus_number ($plate_number)";
                        ?>
                  </span>
            </p>

      </div>
      <div class="container">
            <?php
            include '../../src/components/dashboardcard.php';
            DashboardCard('Destination', $destination, 'Booked Passengers', $booked_passengers . " out of " . $total_seats);
            DashboardCard('Boarding Status', $bus_status, 'Scanned Tickets', $scanned_tickets . ' out of ' . $booked_passengers);
            ?>
      </div>

      <div class="container position-sticky fixed-bottom">
            <div class="row">
                  <div class="col">
                        <button class="btn btn-secondary"><i class="fi fi-br-qr-scan me-2"></i><br>Scan Barcodes</button>
                  </div>
                  <div class="col d-flex justify-content-end">
                        <button class="btn btn-secondary"><i class="fi fi-br-users-gear me-2"></i><br>Manage Passengers</button>
                  </div>
            </div>
            <div class="row">
                  <div class="col text-center">
                        <span class="text-grey"><i>Terminal Session ID:
                                    <?php
                                    echo $terminal_session_id;
                                    ?>
                              </i></span>
                  </div>
            </div>
      </div>
      <!-- Include Popper.js and Bootstrap JavaScript -->
      <script src="../../node_modules/@popperjs/core/dist/umd/popper.js"></script>
      <script src="../../src/js/bootstrap/bootstrap.js"></script>
      <script>
            function logout() {
                  fetch("../../controllers/logout_handler.php")
                        .then((response) => response.text())
                        .then((data) => {
                              if (data == "success") {
                                    window.location.href = "/Project-Leo/frontend/views/admin/login.php";
                              } else {
                                    alert(
                                          "There seems to be an issue logging you out. Please try again later."
                                    );
                                    console.log(data);
                              }
                        });
            }
      </script>
</body>

</html>