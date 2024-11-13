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
                        <button class='btn btn-primary btn-nav'><i class="fi fi-br-user"></i> Cashier 1</button>
                  </div>
                  <div class='col d-flex justify-content-end align-items-center'>
                        <button class='btn btn-secondary btn-nav'><i class="fi fi-br-sign-out-alt me-2"></i>Logout</button>
                  </div>
            </div>
      </div>

      <div class="mt-3 d-flex align-content-center justify-content-center">
            <h1>Enter Bus Credentials to Manage</h1>
      </div>
      <div class="container">
            <div class="d-flex rounded-5 justify-content-center align-content-center p-3 bg-secondary">
                  <form action="">
                        <div class="form-group my-3">
                              <label for="plate_number" class="form-label">Plate Number:</label>
                              <input type="text" class="form-control bg-dark text-light" name="plate_number" required>
                        </div>

                        <div class="form-group my-3">
                              <label for="bus_code" class="form-label">Bus Code:</label>
                              <input type="text" class="form-control bg-dark text-light" name="bus_code" required>
                        </div>

                        <div class="form-group my-3">
                              <label for="bus_key">Bus Key:</label>
                              <input type="password" class="form-control bg-dark text-light" name="bus_key">
                        </div>

            </div>
            <div class="d-flex justify-content-center p-3">
                  <button class="btn btn-primary"><i class="fi fi-br-check-circle me-2"></i>Submit</button>
            </div>
            </form>
      </div>



      <!-- Include Popper.js and Bootstrap JavaScript -->
      <script src="../../node_modules/@popperjs/core/dist/umd/popper.js"></script>
      <script src="../../src/js/bootstrap/bootstrap.js"></script>
</body>

</html>