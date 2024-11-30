<?php
session_start();
if (!isset($_SESSION['emp_username'])) {
      header('Location: login.php');
}
if (!isset($_SESSION['terminal_session_id']) || $_SESSION['terminal_session_id'] == 0) {
      header('Location: busmanager.php');
}
$session_data = $_SESSION['session_data'];
include '../../controllers/dbConfig.php';
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
                        <a href="../admin/dashboard.php">
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
      <h1 class="text-primary pt-3 px-3">Edit Terminal Session</h1>
      <p class="pb-3 px-3">
            Edit existing data for your terminal session for bus
            <span class="text-primary">
                  <u><?php echo $_SESSION['session_data']['bus_plate_number']; ?></u></span>
      </p>

      <?php
      if (isset($_POST['btn_submit'])) {
            $destination = $_POST['destination'];
            $terminal_location = $_POST['terminal_location'];
            $departing_time = $_POST['departing_time'];
            $expiration_date = $_POST['expiration_date'];
            $fare_price = $_POST['fare_price'];
            $bus_status = $_POST['bus_status'];

            $query = $dbConnection->prepare("UPDATE terminal_sessions SET destination = ?, terminal_location = ?, departing_time = ?, expiration_date = ?, fare_price = ?, bus_status = ? WHERE session_id = ?");
            $query->bind_param('ssssdsi', $destination, $terminal_location, $departing_time, $expiration_date, $fare_price, $bus_status, $_SESSION['terminal_session_id']);
            $query->execute();
            $query->close();
            if ($query) {
                  echo "<script>
                        alert('Session data updated successfully!');
                        window.location.href = 'dashboard.php';
                  </script>";
            } else {
                  echo "<script>alert('Failed to update session data!')</script>";
                  exit();
            }
      }
      ?>

      <div class="container">
            <div class="d-flex rounded-5 justify-content-center align-content-center p-3 bg-secondary">
                  <form method="POST" action="">
                        <div class="form-group my-2">
                              <label for="destination" class="form-label">Destination:</label>
                              <input type="text" name="destination" value="<?php echo $session_data['destination']; ?>" class="form-control" required>
                        </div>
                        <div class="form-group my-2">
                              <label for="terminal_location" class="form-label">Terminal Location:</label>
                              <input type="text" name="terminal_location" value="<?php echo $session_data['terminal_location']; ?>" class="form-control" required>
                        </div>
                        <div class="form-group my-2">
                              <label for="departing_time" class="form-label">Departing Time:</label>
                              <input type="datetime-local" name="departing_time" value="<?php echo $session_data['departing_time']; ?>" class="form-control" required>
                        </div>
                        <div class="form-group my-2">
                              <label for="expiration_date" class="form-label">Ticket Expiration Date:</label>
                              <input type="datetime-local" name="expiration_date" class="form-control" value="<?php echo $session_data['expiration_date']; ?>" required>
                        </div>
                        <div class="form-group my-2">
                              <label for="fare_price" class="form-label">Fare Price:</label>
                              <input type="number" name="fare_price" class="form-control" value="<?php echo $session_data['fare_price']; ?>" min="1" pattern="^\d+(\.\d{1,2})?$" step="0.25" required>
                        </div>
                        <div class="form-group my-2">
                              <label for="fare_price" class="form-label">Bus Status:</label>
                              <select name="bus_status" id="" class="form-select">
                                    <option value="NOW BOARDING" <?php echo ($session_data['bus_status'] == 'NOW BOARDING') ? 'selected' : ''; ?>>NOW BOARDING</option>
                                    <option value="DEPARTED" <?php echo ($session_data['bus_status'] == 'DEPARTED') ? 'selected' : ''; ?>>DEPARTED</option>
                                    <option value="DORMANT" <?php echo ($session_data['bus_status'] == 'DORMANT') ? 'selected' : ''; ?>>DORMANT</option>
                              </select>
                        </div>
            </div>
            <div class="d-flex justify-content-center p-3">
                  <button class="btn btn-primary" type="submit" name="btn_submit"><i class="fi fi-br-check-circle me-2"></i>Submit</button>
            </div>
            </form>
            <!-- Include Popper.js and Bootstrap JavaScript -->
            <script src="../../node_modules/@popperjs/core/dist/umd/popper.js"></script>
            <script src="../../src/js/bootstrap/bootstrap.js"></script>
</body>

</html>