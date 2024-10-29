<?php
include '../controllers/session_checker.php';
include '../controllers/dbConfig.php';
include '../src/components/Receipt.php';
include '../src/components/BackNavBar.php';
if (!isset($_SESSION['receiptData'])) {
      header('Location: ../index.php');
}
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
            BackNavBar('../index.php', 'home', 'Home');
      ?>
      <div class="container p-3">
            <div class="row">
                  <div class="col">
                        <h1 class="text-primary">Book Successful</h1>
                        <p class="text-justify bg-info text-dark p-3 m-1 rounded-4">Please <u>Save</u> this receipt, and arrive at the terminal <u>15 mins. before</u> the bus departs. Have an attendant scan this receipt ticket for it to be validated before the expiration date.</p>
                  </div>
            </div>
            <div class="row">
                  <div class="col m-3">
                        <?php
                        $receiptData = $_SESSION['receiptData'];
                        Receipt(
                              $receiptData['barcode'],
                              $receiptData['destination'],
                              $receiptData['bus_name'],
                              $receiptData['bus_number'],
                              $receiptData['bus_plate_number'],
                              $receiptData['bus_type'],
                              $receiptData['seat_no'],
                              $receiptData['fare_price'],
                              $receiptData['date_booked'],
                              $receiptData['expiration_date'],
                              $receiptData['departing_time']
                        );
                        ?>
                  </div>
            </div>
            <div class="row position-sticky fixed-bottom p-3">
                  <div class="col d-flex justify-content-end">
                        <button class="btn btn-secondary"><i class="fi fi-br-download me-2"></i>Save Receipt</button>
                  </div>
            </div>
      </div>



      <!-- Include Popper.js and Bootstrap JavaScript -->
      <script src="../node_modules/@popperjs/core/dist/umd/popper.js"></script>
      <script src="../src/js/bootstrap/bootstrap.js"></script>
      <script src="../src/js/qrcode/generator.js"></script>
      <script>
            const qr = new QRCode(document.getElementById('qrcode'), {
                  text: <?php echo json_encode($receiptData['barcode']); ?>,
                  width: 200,
                  height: 200,
                  colorDark: '#000000',
                  colorLight: '#f4ce14',
                  correctLevel: QRCode.CorrectLevel.H
            });
      </script>
</body>

</html>