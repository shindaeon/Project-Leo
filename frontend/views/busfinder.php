<?php
include '../controllers/session_checker.php';
$_SESSION['receiptData'] = null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Project Leoforeio</title>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/svg+xml" href="public/LogoCircle.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../src/css/bootstrap/bootstrap.css" />
  <link rel="stylesheet" href="../src/css/typography.css" />
  <link rel="stylesheet" href="../src/css/custom.css" />
  <link rel="stylesheet" href="../node_modules/@flaticon/flaticon-uicons/css/bold/rounded.css" />
  <link rel="stylesheet" href="../node_modules/@flaticon/flaticon-uicons/css/brands/all.css" />
</head>

<body>
  <?php
  include '../src/components/NavBar.php';
  include '../controllers/dbConfig.php';

  NavBar(
    '<i class="fa fi-br-menu-burger me-2"></i>',
    'Menu',
    '<i class="fa fi-br-user me-2"></i>',
    'Profile',
    $_SESSION['username'],
    $_SESSION['full_name'],
    $_SESSION['email']
  );
  ?>

  <div class="container px-2 py-3 d-flex justify-content-center align-content-center">
    <?php
    include '../src/components/SearchBar.php';
    SearchBar(
      'Search for a destination',
      '<i class="fi fi-br-search-location"></i>',
    );
    ?>
  </div>



  <div class="container p-2" id="cards">
    <?php
    include '../src/components/Card.php';
    $query = $dbConnection->prepare("
    SELECT 
      buses.bus_id,
      buses.bus_number,
      buses.bus_plate_number,
      buses.bus_company_name,
      terminal_sessions.session_id,
      terminal_sessions.destination,
      terminal_sessions.departing_time,
      terminal_sessions.passengers,
      terminal_sessions.bus_status,
      terminal_sessions.fare_price,
      terminal_sessions.terminal_location
    FROM 
      buses
    INNER JOIN 
      terminal_sessions 
    ON 
      buses.current_terminal_session = terminal_sessions.session_id;
  ");
    $query->execute();
    $result = $query->get_result();
    $dbConnection->close();
    $query->close();

    foreach ($result as $row) {
      $busDetails = $row['bus_company_name'] . ' #' . $row['bus_number'] . ' (' . $row['bus_plate_number'] . ')';
      Card(
        $busDetails,
        $row['terminal_location'],
        $row['destination'],
        $row['departing_time'],
        $row['fare_price'],
        $row['bus_id']
      );
    }

    ?>
  </div>


  <!-- Include Popper.js and Bootstrap JavaScript -->
  <script src="../node_modules/@popperjs/core/dist/umd/popper.js"></script>
  <script src="../src/js/bootstrap/bootstrap.js"></script>
  <script src="../src/js/search.js"></script>
</body>

</html>