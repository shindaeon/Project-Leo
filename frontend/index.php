<?php
// if (!isset($_SESSION['user'])) {
//   header('Location: views/login.php');
//   exit();
// } else {
//   header('Location: index.php');
//   exit();
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Project Leoforeio</title>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/svg+xml" href="public/LogoCircle.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="src/css/bootstrap/bootstrap.css" />
  <link rel="stylesheet" href="src/css/typography.css" />
  <link rel="stylesheet" href="src/css/custom.css" />
  <link rel="stylesheet" href="node_modules/@flaticon/flaticon-uicons/css/bold/rounded.css" />
  <link rel="stylesheet" href="node_modules/@flaticon/flaticon-uicons/css/brands/all.css" />
</head>

<body>
  <?php
  include 'src/components/NavBar.php';
  include 'src/components/Card.php';
  include 'src/components/SearchBar.php';

  NavBar(
    '<i class="fa fi-br-menu-burger me-2"></i>',
    'Menu',
    '<i class="fa fi-br-user me-2"></i>',
    'Profile'
  );

  Card(
    'Victory Liner #45 (AAA 001)',
    'McDo Terminal',
    'Quezon City, MNL',
    '5PM October 19, 2024',
    'P 100.00'
  );

  SearchBar(
    'Search for a destination',
    '<i class="fi fi-br-search-location"></i>',
  );
  ?>


  <!-- Include Popper.js and Bootstrap JavaScript -->
  <script src="node_modules/@popperjs/core/dist/umd/popper.js"></script>
  <script src="src/js/bootstrap/bootstrap.js"></script>
</body>

</html>