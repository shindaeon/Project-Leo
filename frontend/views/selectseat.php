<?php
include '../controllers/session_checker.php';
include '../controllers/dbConfig.php';
$bus_id = $_GET['bus_id'];
if (isset($bus_id)) {
      $query = $dbConnection->prepare("
                  SELECT 
                        buses.bus_number,
                        buses.bus_company_name,
                        buses.bus_company_initials,
                        buses.bus_plate_number,
                        buses.bus_type,
                        terminal_sessions.session_id,
                        terminal_sessions.destination,
                        terminal_sessions.fare_price,
                        terminal_sessions.departing_time,
                        terminal_sessions.expiration_date,
                        terminal_sessions.passengers
                  FROM 
                        buses
                  INNER JOIN 
                        terminal_sessions 
                  ON 
                        buses.current_terminal_session = terminal_sessions.session_id
                  WHERE
                        buses.bus_id = ?;
            ");
      $query->bind_param('i', $bus_id);
      $query->execute();
      $result = $query->get_result();
      $row = $result->fetch_assoc();
      $passengers = json_decode($row['passengers']);
} else {
      header('Location: ../index.php');
}
$query->close();
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
      //render the back navbar
      include '../src/components/BackNavBar.php';
      BackNavBar('../views/busdetails.php?bus_id=' . $bus_id, 'angle-left', 'Back');
      ?>
      <div class="container p-3">
            <div class="row">
                  <div class="col">
                        <h1 class="text-primary">Select A Seat</h1>
                        <span class="h6">Legend:</span><br>
                        <span class="badge bg-danger text-light px-3 py-2">Taken</span>
                        <span class="badge text-light bg-secondary px-3 py-2">Available</span>
                        <span class="badge text-dark bg-primary px-3 py-2">Selected</span>
                  </div>
            </div>
            <form method="post">
                  <div class="row">
                        <div class="col text-center mt-3">
                                    <?php
                                    //render the seats
                                    include '../src/components/Seat.php';
                                    foreach ($passengers as $passenger) {
                                          Seat($passenger->seatNumber, $passenger->status);
                                    }

                                    ?>
                        </div>
                  </div>
                  <div class="row fixed-bottom p-3">
                        <div class="col d-flex justify-content-end">
                              <button type="submit" class="btn btn-primary" name="btn_submit">
                                    <i class="fi fi-br-check me-2"></i>Book Now
                              </button>

                        </div>
                  </div>
            </form>
            <?php
                  if(isset($_POST['btn_submit']) && !empty($_POST['seat'])) {
                        $selected_seat = $_POST['seat'];
                        foreach ($passengers as $passenger) {
                              if ($passenger->seatNumber == $selected_seat) {
                                    $barcode = $row['session_id'].'-'.$row['bus_company_initials'].$row['bus_number'].'-'.'PS'.$selected_seat;
                                    $passenger->status = 'reserved';
                                    $passenger->username = $_SESSION['username'];
                                    $passenger->ticket = $barcode;
                                    break;
                              }
                        }
                        $updated_passengers = json_encode($passengers);
                        $updateQuery = $dbConnection->prepare("
                              UPDATE 
                                    terminal_sessions
                              SET 
                                    passengers = ?
                              WHERE
                                    session_id = ?;
                        ");
                        $updateQuery->bind_param('si', $updated_passengers, $row['session_id']);
                        $updateQuery->execute();
                        if ($updateQuery->affected_rows > 0) {
                              $receiptData = [
                                    'barcode' => $barcode,
                                    'destination' => $row['destination'],
                                    'bus_name' => $row['bus_company_name'],
                                    'bus_number' => $row['bus_number'],
                                    'bus_plate_number' => $row['bus_plate_number'],
                                    'bus_type' => $row['bus_type'],
                                    'seat_no' => $selected_seat,
                                    'fare_price' => $row['fare_price'],
                                    'date_booked' => date('Y-m-d H:i:s'),
                                    'expiration_date' => $row['expiration_date'],
                                    'departing_time' => $row['departing_time']
                              ];
                              $_SESSION['receiptData'] = $receiptData;
                              header('Location: ../views/receipt.php');
                        } else {
                              echo "<script>alert('Failed to reserve seat $selected_seat!')</script>";
                        }
                        $updateQuery->close();
                        $dbConnection->close();
                  }
            ?>
      </div>


      <!-- Include Popper.js and Bootstrap JavaScript -->
      <script src="../node_modules/@popperjs/core/dist/umd/popper.js"></script>
      <script src="../src/js/bootstrap/bootstrap.js"></script>
</body>

</html>