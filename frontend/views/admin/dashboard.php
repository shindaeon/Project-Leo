<?php
session_start();
if (!isset($_SESSION['emp_username'])) {
      header('Location: login.php');
}
if ($_SESSION['terminal_session_id'] == 0) {
      header('Location: newsession.php');
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
            terminal_sessions.expiration_date,
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
      $terminal_location = $session['terminal_location'];
      $expiration_date = $session['expiration_date'];

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
      $_SESSION['session_data'] = $session;
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
                        <button class='btn btn-secondary btn-nav' data-bs-toggle='offcanvas' data-bs-target='#menu' aria-controls='offcanvasWithBothOptions'>
                              <i class="fi fi-br-menu-burger me-2"></i>Menu
                        </button>
                  </div>
                  <div class='col d-flex justify-content-end align-items-center'>
                        <a href="../admin/busmanager.php">
                              <button class='btn btn-secondary btn-nav'><i class="fi fi-br-cross me-2"></i>Exit</button>
                        </a>

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
            echo DashboardCard('Destination', $destination, 'Booked Passengers', $booked_passengers . " out of " . $total_seats, "none");
            echo DashboardCard('Boarding Status', $bus_status, 'Scanned Tickets', $scanned_tickets . ' out of ' . $booked_passengers, "editStatus");
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


      <div class="offcanvas offcanvas-start bg-grey text-light p-2" data-bs-scroll="true" tabindex="-1" id="menu" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
                  <div class="row">
                        <div class="col-6 align-content-center">
                              <h2 class="offcanvas-title text-primary" id="offcanvasWithBothOptionsLabel">Menu</h2>
                        </div>
                        <div class="col-3 align-content-center justify-content-end">
                              <button type="button" class="btn btn-primary " data-bs-dismiss="offcanvas" aria-label="Close"><i class="fi fi-br-circle-xmark" style="font-size: 1.25rem;"></i></button>
                        </div>
                  </div>

            </div>
            <div class="offcanvas-body">
                  <ul class="list-unstyled">
                        <li class="h4 p-2"><a href="../admin/editsession.php"><i class="fi fi-br-customize me-3"></i>Edit Terminal Session</a></li>
                        <li class="h4 p-2"><a class="text-primary" onclick="deleteSession()" role="button"><i class="fi fi-br-trash me-3"></i>Delete Terminal Session</a></li>
                        <li class="h4 p-2"><a class="text-primary" onclick="logout()" role="button"><i class="fi fi-br-sign-out-alt me-3"></i>Logout</a></li>
                  </ul>
            </div>
      </div>

      <div class="modal fade" id="editStatus" tabindex="-1" aria-labelledby="editStatusLabel" aria-hidden="true">
            <div class="modal-dialog">
                  <div class="modal-content">
                        <div class="modal-header bg-primary text-dark border-0">
                              <h3 class="modal-title">Edit Boarding Status</h3>
                        </div>
                        <div class="modal-body bg-dark text-light">
                              <?php
                              if (isset($_POST['btn_save'])) {
                                    $bus_status = $_POST['bus_status'];
                                    $query = $dbConnection->prepare("UPDATE terminal_sessions SET bus_status = ? WHERE session_id = ?");
                                    $query->bind_param('ss', $bus_status, $terminal_session_id);
                                    $query->execute();
                                    if ($query->affected_rows > 0) {
                                          echo "<script>alert('Updated Successfully');</script>";
                                          echo "<script>window.location.href = 'dashboard.php';</script>";
                                    } else {
                                          echo "<script>alert('Oops... Something is wrong.'); </script>";
                                    }
                              }
                              ?>
                              <form action="" method="POST">
                                    <div class="form-group my-2">
                                          <label for="bus_status" class="form-label">Bus Status:</label>
                                          <select name="bus_status" id="" class="form-select">
                                                <option value="NOW BOARDING" <?php echo ($bus_status == 'NOW BOARDING') ? 'selected' : ''; ?>>NOW BOARDING</option>
                                                <option value="DEPARTED" <?php echo ($bus_status == 'DEPARTED') ? 'selected' : ''; ?>>DEPARTED</option>
                                                <option value="DORMANT" <?php echo ($bus_status == 'DORMANT') ? 'selected' : ''; ?>>DORMANT</option>
                                          </select>
                                    </div>
                        </div>
                        <div class="modal-footer bg-primary text-dark border-0">
                              <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fi fi-br-cross me-2"></i>Close</button>
                              <button type="submit" class="btn btn-secondary" name="btn_save"><i class="fi fi-br-check me-2"></i>Save</button>
                              </form>
                        </div>
                  </div>
            </div>
      </div>

      <!-- Include Popper.js and Bootstrap JavaScript -->
      <script src="../../node_modules/@popperjs/core/dist/umd/popper.js"></script>
      <script src="../../src/js/bootstrap/bootstrap.js"></script>
      <script>
            function logout() {
                  try {
                        fetch("/Project-Leo/frontend/controllers/logout_handler.php", {
                                    method: "POST",
                              })
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
                              }).catch((error) => {
                                    console.log(error);
                              });
                  } catch (error) {
                        console.log(error);
                  }
            }

            function deleteSession() {
                  if (confirm("Are you sure you want to delete this session? This action cannot be undone.")) {
                        fetch("../../controllers/deleteTerminalSession.php")
                              .then((response) => response.text())
                              .then((data) => {
                                    if (data == "success") {
                                          alert("Session deleted successfully.");
                                          window.location.href = "/Project-Leo/frontend/views/admin/busmanager.php";
                                    } else {
                                          alert(
                                                "There seems to be an issue deleting the session. Please try again later."
                                          );
                                          console.log(data);
                                    }
                              });
                  } else {
                        console.log("Cancelled");
                  }
            }
      </script>
</body>

</html>