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
$bus_data = $_SESSION['session_data'];
if ($bus_data['bus_status'] == 'DORMANT' || $bus_data['bus_status'] == 'INACTIVE') {
      header('Location: dashboard.php');
      exit();
}

include '../../controllers/dbConfig.php';
$terminal_session_id = $_SESSION['terminal_session_id'];
$query = $dbConnection->prepare("SELECT * FROM terminal_sessions WHERE session_id = ? LIMIT 1");
$query->bind_param("i", $terminal_session_id);
$query->execute();
$result = $query->get_result();
$session = $result->fetch_assoc();
$query->close();
$passengers = json_decode($session['passengers'], true);
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
                        <a href="dashboard.php">
                              <button class='btn btn-secondary btn-nav'>
                                    <i class="fi fi-br-angle-left me-2"></i>Back
                              </button>
                        </a>
                  </div>
                  <div class='col d-flex justify-content-end align-items-center'>
                        <a href="../admin/busmanager.php">
                              <button class='btn btn-secondary btn-nav'><i class="fi fi-br-cross me-2"></i>Exit</button>
                        </a>

                  </div>
            </div>
      </div>
      <div class="container p-3">
            <h1 class="text-primary">Manage Passengers</h1>
            <p>Now Managing: <br>
                  <span class="h5">
                        <?php
                        echo $bus_data['bus_company_name'] . " #" . $bus_data['bus_number'] . " (" . $bus_data['bus_plate_number'] . ")";
                        ?>
                  </span>
            </p>

      </div>

      <div class="container px-3">
            <div class="row">
                  <div class="col">
                        <table class="table table-striped table-hover table-primary table-responsive">
                              <thead class="text-center">
                                    <tr class="align-middle">
                                          <th class="bg-primary">Seat Number</th>
                                          <th class="bg-secondary">Name</th>
                                          <th class="bg-primary">Actions</th>
                                    </tr>
                              </thead>
                              <tbody class="text-center">
                                    <?php
                                    foreach ($passengers as $passenger) {
                                          echo "<tr class='align-middle'>";
                                          if ($passenger['status'] == "available") {
                                                echo '<form method="POST" action="">' .
                                                      "<td>" . $passenger['seatNumber'] . "</td>" .
                                                      "<td><input type='text' name='assignedName' class='form-control'></td>" .
                                                      '<td>
                                                            <input type="hidden" name="seatNumber" value="' . $passenger['seatNumber'] . '">
                                                            <button type="submit" name="assignSeat" class="btn btn-success">Assign</button>
                                                      </form>
                                                </td>';
                                          } else {
                                                echo "<td>" . $passenger['seatNumber'] . "</td>";
                                                echo "<td>" . $passenger['username'] . "</td>";
                                                echo '<td>
                                                            <form method="POST" action="">
                                                                  <input type="hidden" name="seatNumber" value="' . $passenger['seatNumber'] . '">
                                                                  <button type="submit" name="removePassenger" class="btn btn-danger">Remove</button>
                                                            </form>
                                                      </td>';
                                          }
                                          echo "</tr>";
                                    }
                                    ?>
                              </tbody>
                              <tfoot>
                                    <tr>
                                          <td colspan="3" class="text-center">--- Nothing Follows ---</td>

                                    </tr>
                              </tfoot>
                        </table>
                  </div>
            </div>
      </div>
      <?php
      if (isset($_POST['removePassenger'])) {
            $seatNumber = $_POST['seatNumber'];
            foreach ($passengers as $key => $passenger) {
                  if ($passenger['seatNumber'] == $seatNumber) {
                        $passengers[$key]['status'] = "available";
                        $passengers[$key]['username'] = null;
                        $passengers[$key]['ticket'] = null;
                        break;
                  }
            }
            $passengers = json_encode($passengers);
            $query = $dbConnection->prepare("UPDATE terminal_sessions SET passengers = ? WHERE session_id = ?");
            $query->bind_param("si", $passengers, $session['session_id']);
            $query->execute();
            $query->close();
            $passengers = json_decode($passengers, true);
            echo "<script>window.location.href = 'managepassengers.php';</script>";
            exit();
      }

      if (isset($_POST['assignSeat'])) {
            $seatNumber = $_POST['seatNumber'];
            $assignedName = $_POST['assignedName'];
            foreach ($passengers as $key => $passenger) {
                  if ($passenger['seatNumber'] == $seatNumber) {
                        $passengers[$key]['status'] = "taken";
                        $passengers[$key]['username'] = $assignedName;
                        $passengers[$key]['ticket'] = 'ASSIGNED BY STAFF';
                        break;
                  }
            }
            $passengers = json_encode($passengers);
            $query = $dbConnection->prepare("UPDATE terminal_sessions SET passengers = ? WHERE session_id = ?");
            $query->bind_param("si", $passengers, $session['session_id']);
            $query->execute();
            $query->close();
            $passengers = json_decode($passengers, true);
            echo "<script>window.location.href = 'managepassengers.php';</script>";
            exit();
      }

      ?>

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