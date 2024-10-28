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
      <div class="card bg-primary text-dark p-4">
            <div class="row">
                  <div class="col">
                        <svg id="barcode"></svg>
                  </div>
            </div>
            <div class="row">
                  <div class="col">
                        <span class="text-mono">Destination:</span><br>
                        <span class="text-mono text-uppercase d-inline-block mb-2">$destination</span><br>
                        <span class="text-mono">Bus Name:</span><br>
                        <span class="text-mono text-uppercase d-inline-block mb-2">$bus_name</span><br>
                        <span class="text-mono">Bus Number:</span><br>
                        <span class="text-mono text-uppercase d-inline-block mb-2">#$bus_number</span><br>
                        <span class="text-mono">Bus Plate Number:</span><br>
                        <span class="text-mono text-uppercase d-inline-block mb-2">$bus_plate_number</span><br>
                        <span class="text-mono">Bus Type:</span><br>
                        <span class="text-mono text-uppercase d-inline-block">$bus_type</span><br>
                  </div>
                  <div class="col">
                        <span class="text-mono">Seat No:</span><br>
                        <span class="text-mono text-uppercase d-inline-block mb-2">$seat_no</span><br>
                        <span class="text-mono">Fare Price:</span><br>
                        <span class="text-mono text-uppercase d-inline-block mb-2">$fare_price</span><br>
                        <span class="text-mono">Date Booked:</span><br>
                        <span class="text-mono text-uppercase d-inline-block mb-2">$date_booked</span><br>
                        <span class="text-mono">Book Expires on:</span><br>
                        <span class="text-mono text-uppercase d-inline-block mb-2">$expiration_date</span><br>
                        <span class="text-mono">Bus Departs on:</span><br>
                        <span class="text-mono text-uppercase d-inline-block">$departing_time</span><br>
                  </div>
            </div>
      </div>

      <!-- Include Popper.js and Bootstrap JavaScript -->
      <script src="../node_modules/@popperjs/core/dist/umd/popper.js"></script>
      <script src="../src/js/bootstrap/bootstrap.js"></script>
</body>

</html>