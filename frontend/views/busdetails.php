<?php
include '../controllers/session_checker.php';
include '../controllers/dbConfig.php';
$bus_id = $_GET['bus_id'];
if (isset($bus_id)) {
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
                  buses.current_terminal_session = terminal_sessions.session_id
            WHERE
                  buses.bus_id = ?;
      ");
      $query->bind_param('i', $bus_id);
      $query->execute();
      $result = $query->get_result();
      $row = $result->fetch_assoc();
      $passengers = json_decode($row['passengers']);
      $available_seats = 0;
      foreach ($passengers as $passenger) {
            if ($passenger->status == 'available') {
                  $available_seats++;
            }
      }
} else {
      header('Location: ../index.php');
}
$dbConnection->close();
$query->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
      <title>Project Leoforeio</title>
      <meta charset="UTF-8" />
      <link rel="icon" type="image/svg+xml" href="../public/LogoCircle.png" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="../src/css/bootstrap/bootstrap.css" />
      <link rel="stylesheet" href="../src/css/typography.css" />
      <link rel="stylesheet" href="../src/css/custom.css" />
      <link rel="stylesheet" href="../node_modules/@flaticon/flaticon-uicons/css/bold/rounded.css" />
      <link rel="stylesheet" href="../node_modules/@flaticon/flaticon-uicons/css/brands/all.css" />
</head>

<body>
      <?php
      include '../src/components/BackNavBar.php';
      BackNavBar('../index.php', 'angle-left', 'Back', 'btn_back');
      ?>
      <div class="container p-3">
            <div class="row mb-3">
                  <div class="col">
                        <div class="row">
                              <div class="col">
                                    <h1 class="text-primary">Bus Details</h1>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col">
                                    <h4 class="text-primary">
                                          <?php echo $row['bus_company_name']; ?>
                                    </h4>
                              </div>
                              <div class="col"></div>
                        </div>
                  </div>
            </div>
            <div class="row">
                  <div class="col">
                        <h5 class="text-primary">Destination:</h5>
                        <p>
                              <?php echo $row['destination']; ?>
                        </p>
                  </div>
            </div>
            <div class="row">
                  <div class="col">
                        <h5 class="text-primary">Fare Price:</h5>
                        <p>
                              &#8369;<?php echo $row['fare_price']; ?>
                        </p>
                  </div>
            </div>
            <div class="row">
                  <div class="col">
                        <h5 class="text-primary">Bus Type:</h5>
                        <p>
                              <?php echo $row['bus_company_name']; ?>
                        </p>
                  </div>
            </div>
            <div class="row">
                  <div class="col">
                        <h5 class="text-primary">Departs on:</h5>
                        <p>
                              <?php echo $row['departing_time']; ?>
                        </p>
                  </div>
            </div>
            <div class="row">
                  <div class="col">
                        <h5 class="text-primary">Bus Number:</h5>
                        <p>
                              #<?php echo $row['bus_number']; ?>
                        </p>
                  </div>
            </div>
            <div class="row">
                  <div class="col">
                        <h5 class="text-primary">Seats Available:</h5>
                        <p>
                              <?php echo $available_seats.' seats available'; ?>
                        </p>
                  </div>
            </div>
            <div class="row fixed-bottom p-3">
                  <div class="col d-flex justify-content-end">
                        <a href="selectseat.php?bus_id=<?php echo $bus_id ?>">
                              <button class="btn btn-primary"><i class="fi fi-br-Booking me-2"></i>Book a seat</button>
                        </a>
                  </div>
            </div>

      </div>

      <!-- Include Popper.js and Bootstrap JavaScript -->
      <script src="../node_modules/@popperjs/core/dist/umd/popper.js"></script>
      <script src="../src/js/bootstrap/bootstrap.js"></script>
</body>

</html>