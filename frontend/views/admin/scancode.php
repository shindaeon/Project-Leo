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



include '../../controllers/dbConfig.php';

$terminal_session_id = $_SESSION['terminal_session_id'];
$bus_data = $_SESSION['session_data'];
if ($bus_data['bus_status'] == 'DORMANT' || $bus_data['bus_status'] == 'INACTIVE') {
      header('Location: dashboard.php');
      exit();
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

      <div class="container pt-3 px-3">
            <h1 class="text-primary">Scan QR Code</h1>
            <p>Now Managing: <br>
                  <span class="h5">
                        <?php
                        echo $bus_data['bus_company_name'] . " #" . $bus_data['bus_number'] . " (" . $bus_data['bus_plate_number'] . ")";
                        ?>
                  </span>
            </p>
      </div>

      <div class="py-1 px-3 container">
            <div id="reader" class="bg-primary m-3 rounded-4"></div>
      </div>

      <div class="container d-flex justify-content-center p-3">
            <label for="enteredCode" class="text-center">Enter barcode (for Camera errors):</p>
            <form action="" method="POST">
                  <input type="text" id="enteredCode" class="form-control text-center" placeholder="0000-XXXXX0-XX00">
      </div>
      <div class=""></div>
      <div class="container">
            <div class="row position-sticky fixed-bottom px-4 pb-3">
                  <div class="col">
                        <a href="managepassengers.php">
                              <button type="button" class="btn btn-secondary">Manage</button>
                        </a>
                  </div>
                  <div class="d-flex col justify-content-end">
                        <button type="submit" id="btn_submit" class="btn btn-primary"><i class="fi fi-br-check-circle me-2"></i>Submit</button>
                  </div>
                  </form>
            </div>
      </div>
      <!-- Include Popper.js and Bootstrap JavaScript -->
      <script src="../../node_modules/@popperjs/core/dist/umd/popper.js"></script>
      <script src="../../src/js/bootstrap/bootstrap.js"></script>
      <script src="../../node_modules/html5-qrcode/html5-qrcode.min.js"></script>
      <script>
            function verifyQRCode(qrCode) {
                  fetch(`../../controllers/qrcodeHandler.php?qrCode=${qrCode}`)
                        .then(response => response.text())
                        .then(data => {
                              if (data == "success") {
                                    alert('QR Code validated successfully!');
                              } else if (data == "already taken") {
                                    alert('QR Code already been validated!');
                              } else {
                                    alert('QR Code not found! Please try again.');
                              }
                        }).catch(err => {
                              console.error(err);
                        });
            }

            // alert("Please allow camera permissions to scan QR code, if scan fails, please enter the Code manually.");
            function onScanSuccess(decodedText, decodedResult) {
                  // Handle on success condition with the decoded text or result.
                  confirm("Is this the correct QR Code? \n\"" + decodedText + "\"");
                  if (confirm) {
                        verifyQRCode(decodedText);
                  }
            }

            var html5QrcodeScanner = new Html5QrcodeScanner(
                  "reader", {
                        fps: 10,
                        qrbox: 250,
                        aspectRatio: 1.33,
                        formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
                        rememberLastUsedCamera: true,
                  });
            html5QrcodeScanner.render(onScanSuccess);

            const btn_submit = document.getElementById('btn_submit');
            btn_submit.addEventListener('click', (e) => {
                  e.preventDefault();
                  const enteredCode = document.getElementById('enteredCode').value.trim();
                  console.log(enteredCode);
                  verifyQRCode(enteredCode);
            })
      </script>
</body>

</html>