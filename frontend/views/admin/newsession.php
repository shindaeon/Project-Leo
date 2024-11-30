<?php
session_start();
if (!isset($_SESSION['emp_username'])) {
      header('Location: login.php');
}
if (!isset($_SESSION['bus_plate_number'])) {
      header('Location: busmanager.php');
}
include '../../controllers/dbConfig.php';
if (isset($_POST['btn_submit']) && isset($_SESSION['bus_plate_number'])) {
      $destination = $_POST['destination'];
      $terminal_location = $_POST['terminal_location'];
      $departing_time = $_POST['departing_time'];
      $expiration_date = $_POST['expiration_date'];
      $fare_price = $_POST['fare_price'];
      $bus_status = "NOW BOARDING";
      $number_of_seats = $_POST['seats'];
      $seats = [];
      for ($i = 1; $i <= $number_of_seats; $i++) {
            $seats[$i] = [
                  "status" => "available",
                  "ticket" => null,
                  "username" => null,
                  "seatNumber" => $i
            ];
      }
      $seats_json = json_encode($seats);

      $query = $dbConnection->prepare("INSERT INTO terminal_sessions (destination, terminal_location, departing_time, expiration_date, fare_price, passengers, bus_status) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $query->bind_param('sssssss', $destination, $terminal_location, $departing_time, $expiration_date, $fare_price, $seats_json, $bus_status);
      $query->execute();
      $session_id = $dbConnection->insert_id;
      $query->close();

      $query = $dbConnection->prepare("UPDATE buses SET current_terminal_session = ? WHERE bus_plate_number = ?");
      $query->bind_param('ss', $session_id, $_SESSION['bus_plate_number']);
      $query->execute();
      $query->close();
      $_SESSION['terminal_session_id'] = $session_id;
      header('Location: dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
      <title>Project Leoforeio</title>
      <meta charset="UTF-8" />
      <link rel="icon" type="image/svg+xml" href="../public/LogoCircle.png" />
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
                              <button class='btn btn-secondary btn-nav'><i class="fi fi-br-angle-left me-2"></i>Back</button>
                        </a>
                  </div>
                  <div class="col d-flex justify-content-center align-content-center p-1">
                        <img src="../../public/logogrey_circle.png" class="img-fluid" height="30" width="30" alt="">
                  </div>
                  <div class='col d-flex justify-content-end align-items-center'>
                        <button class='btn btn-secondary btn-nav' onclick="logout()"><i class="fi fi-br-sign-out-alt me-2"></i>Logout</button>
                  </div>
            </div>
      </div>
      <h1 class="text-primary pt-3 px-3">New Terminal Session</h1>
      <p class="pb-3 px-3">
            Set up a new session for your bus
            <span class="text-primary">
                  <u><?php echo $_SESSION['bus_plate_number']; ?></u></span>, so it will be visible on the Bus Finder
      </p>
      <div class="container">
            <div class="d-flex rounded-5 justify-content-center align-content-center p-3 bg-secondary">
                  <form method="POST" action="">
                        <div class="form-group my-2">
                              <label for="destination" class="form-label">Set Destination:</label>
                              <input type="text" name="destination" class="form-control" required>
                        </div>
                        <div class="form-group my-2">
                              <label for="terminal_location" class="form-label">Terminal Location:</label>
                              <input type="text" name="terminal_location" class="form-control" required>
                        </div>
                        <div class="form-group my-2">
                              <label for="departing_time" class="form-label">Set Departing Time:</label>
                              <input type="datetime-local" name="departing_time" class="form-control" required>
                        </div>
                        <div class="form-group my-2">
                              <label for="expiration_date" class="form-label">Set Ticket Expiration Date:</label>
                              <input type="datetime-local" name="expiration_date" class="form-control" required>
                        </div>
                        <div class="form-group my-2">
                              <label for="fare_price" class="form-label">Set Fare Price:</label>
                              <input type="number" name="fare_price" class="form-control" min="1" pattern="^\d+(\.\d{1,2})?$" step="0.25" required>
                        </div>
                        <div class="form-group my-2">
                              <label for="seats" class="form-label">Set Number of Seats:</label>
                              <input type="number" name="seats" class="form-control" min="1" max="85" required>
                        </div>

            </div>
            <div class="d-flex justify-content-center p-3">
                  <button class="btn btn-primary" type="submit" name="btn_submit"><i class="fi fi-br-check-circle me-2"></i>Submit</button>
            </div>
            </form>


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