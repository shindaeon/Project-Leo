<?php
session_start();
if (!isset($_SESSION['emp_username'])) {
      header('Location: login.php');
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
                        <button class='btn btn-secondary btn-nav'><i class="fi fi-br-angle-left me-2"></i>Back</button>
                  </div>
                  <div class='col d-flex justify-content-end align-items-center'>
                        <button class='btn btn-secondary btn-nav' onclick="logout()"><i class="fi fi-br-sign-out-alt me-2"></i>Logout</button>
                  </div>
            </div>
      </div>
      <div class="container p-3">
            <h1 class="text-primary">Dashboard</h1>
            <p>Now Managing: <br> <span class="h5">$currentbus #$bus_number ($plate_number)</span></p>

      </div>
      <div class="container">
            <?php
            include '../../src/components/dashboardcard.php';
            DashboardCard('Destination', 'Bayombong', 'Booked Passengers', '10 out of 10');
            DashboardCard('Boarding Status', 'Now Boarding', 'Scanned Tickets', '10 out of 10');
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
                        <span class="text-grey"><i>Terminal Session ID: $terminal_session_id</i></span>
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