<?php
include '../../controllers/dbConfig.php';
session_start();
if (!isset($_SESSION['emp_username'])) {
      header('Location: login.php');
}
if (isset($_POST['btn_submit'])) {
      $plate_number = $_POST['plate_number'];
      $bus_key = $_POST['bus_key'];
      $query = $dbConnection->prepare("SELECT * FROM buses WHERE bus_plate_number = ? AND bus_key = ?");
      $query->bind_param('ss', $plate_number, $bus_key);

      $query->execute();
      $res = $query->get_result();
      $bus = $res->fetch_assoc();
      if ($res->num_rows > 0) {
            //check if current session is not null from db
            if ($bus['current_terminal_session'] != NULL || $bus['current_terminal_session'] != 0) {
                  $_SESSION['terminal_session_id'] = $bus['current_terminal_session'];
                  header('Location: dashboard.php');
                  exit();
            }
            $_SESSION['bus_plate_number'] = $bus['bus_plate_number'];
            header('Location: newsession.php');


            //if null redirect to create terminal session.php
            //else redirect to dashboard.php
            exit();
      } else {
            echo '<script>alert("Invalid plate number or bus key")</script>';
      }
      $dbConnection->close();
      $query->close();
}
unset($_SESSION['bus_plate_number'], $_SESSION['terminal_session_id']);


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
                        <span class="text-dark mx-2">
                              <i class="fi fi-br-user"></i>
                              <?php echo $_SESSION['emp_full_name']; ?>
                        </span>
                  </div>
                  <div class="col d-flex justify-content-center align-content-center p-1">
                        <img src="../../public/logogrey_circle.png" class="img-fluid" height="30" width="30" alt="">
                  </div>
                  <div class='col d-flex justify-content-end align-items-center'>
                        <button onclick="logout()" class='btn btn-secondary btn-nav'><i class="fi fi-br-sign-out-alt me-2"></i>Logout</button>
                  </div>
            </div>
      </div>

      <div class="d-flex" style="height:85vh;">
            <div class="container my-auto">
                  <div class="d-flex flex-column align-items-center justify-content-center">
                        <h2 class="text-center text-primary mb-3">Enter Bus Credentials to Manage</h2>
                        <div class="container">
                              <div class="d-flex rounded-5 justify-content-center align-content-center p-3 bg-secondary">
                                    <form action="" method="POST">
                                          <div class="form-group my-3">
                                                <label for="plate_number" class="form-label">Plate Number:</label>
                                                <input type="text" class="form-control bg-dark text-light" name="plate_number" required>
                                          </div>
                                          <div class="form-group my-3">
                                                <label for="bus_key">Bus Key:</label>
                                                <input type="password" class="form-control bg-dark text-light" name="bus_key">
                                          </div>
                              </div>
                        </div>
                        <div class="container">
                              <div class="d-flex justify-content-center p-3">
                                    <button class="btn btn-primary" type="submit" name="btn_submit">
                                          <i class="fi fi-br-check-circle me-2"></i>Submit
                                    </button>
                              </div>
                              <p class="text-center">If the bus is not on the system yet, you can
                                    <a class="text-primary" type="button" data-bs-toggle="modal" data-bs-target="#newBus">
                                          <u>Add a Bus</u>
                                    </a>
                              </p>
                        </div>
                        </form>
                  </div>
            </div>
      </div>

      <?php
      if (isset($_POST['btn_add'])) {
            $bus_company_name = $_POST['bus_company_name'];
            $bus_number = $_POST['bus_number'];
            $bus_plate_number = $_POST['bus_plate_number'];
            $bus_company_initials = $_POST['bus_company_initials'];
            $bus_type = $_POST['bus_type'];
            $bus_key = $_POST['bus_key'];

            $query = $dbConnection->prepare("INSERT INTO buses (bus_company_name, bus_number, bus_plate_number, bus_company_initials, bus_type, bus_key) VALUES (?, ?, ?, ?, ?, ?)");
            $query->bind_param('ssssss', $bus_company_name, $bus_number, $bus_plate_number, $bus_company_initials, $bus_type, $bus_key);
            $query->execute();
            $dbConnection->close();
            $query->close();
            if ($query) {
                  echo '<script>alert("Bus added successfully")</script>';
            } else {
                  echo '<script>alert("Failed to add bus")</script>';
            }
      }
      ?>

      <div class="modal fade" id="newBus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                  <div class="modal-content">
                        <div class="modal-header bg-primary text-dark border-0">
                              <h3 class="modal-title" id="staticBackdropLabel">Add a Bus</h3>
                              <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                        </div>
                        <div class="modal-body bg-dark text-light">
                              <form action="" method="POST">
                                    <div class="form-group my-2 mx-1">
                                          <label for="bus_company_name" class="form-label">Bus Company Name:</label>
                                          <input type="text" name="bus_company_name" class="form-control" placeholder="Bus Liner Inc." required>
                                    </div>
                                    <div class="form-group my-2 mx-1">
                                          <label for="bus_number" class="form-label">Bus Number:</label>
                                          <input type="number" name="bus_number" class="form-control" placeholder="01" maxlength="3" required>
                                    </div>
                                    <div class="form-group my-2 mx-1">
                                          <label for="bus_plate_number" class="form-label">Bus Plate Number:</label>
                                          <input type="text" name="bus_plate_number" class="form-control" placeholder="XXXX-1234" maxlength="9" required>
                                    </div>
                                    <div class="form-group my-2 mx-1">
                                          <label for="bus_company_initials" class="form-label">Bus Company Initials:</label>
                                          <input type="text" name="bus_company_initials" class="form-control" placeholder="BSLI" maxlength="5" minlength="2" required>
                                    </div>
                                    <div class="form-group my-2 mx-1">
                                          <label for="bus_type" class="form-label">Bus Type:</label>
                                          <select name="bus_type" id="" class="form-select" required>
                                                <option value="Regular">Regular</option>
                                                <option value="Air-conditioned">Air-conditioned</option>
                                          </select>
                                    </div>
                                    <div class="form-group my-2 mx-1">
                                          <label for="bus_key" class="form-label">Bus Key:</label>
                                          <input type="password" name="bus_key" class="form-control" minlength="8" required>
                                    </div>

                        </div>
                        <div class="modal-footer bg-primary text-dark border-0">
                              <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="close">Cancel</button>
                              <button class="btn btn-success" name="btn_add">Add Bus</button>
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