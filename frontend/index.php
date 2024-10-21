<!doctype html>
<html lang="en">

<head>
    <title>Project Leoforeio</title>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="public/Logo%20Circle.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="src/css/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="src/css/styles.css" />
    <link rel="stylesheet" href="src/css/typography.css" />
    <link rel="stylesheet" href="node_modules/@flaticon/flaticon-uicons/css/bold/rounded.css" />
    <link rel="stylesheet" href="node_modules/@flaticon/flaticon-uicons/css/brands/all.css" />
</head>

<body>
  <?php 
        include 'src/components/NavBar.php';
        include  'src/components/SearchBar.php';
        echo NavBar(
          '<i class="fa fi-br-menu-burger mr-1"></i>', 'Menu',
          '<i class="fa fi-br-user mr-1"></i>', 'Profile'
        );
        echo SearchBar('Search Destination...', '<i class="fi fi-br-search-location"></i>');
  ?>
  <div class="container-fluid bg-dark text-light p-3">
    <div class="row">
      <div class="col">
          <?php
          include 'src/components/Card.php';
          echo Card(
                  'Victory Line #45 (AAA 001)',
                  'McDo Terminal, Solano',
                  'Quezon City, MNL',
                  'October 15, 2024 5:00 PM',
                  'P 100.00'
          );
          ?>


          <ul>
              <li>List item 1</li>
              <li>List item 2</li>
              <li>List item 3</li>
          </ul>

          <ol>
              <li>Ordered list item 1</li>
              <li>Ordered list item 2</li>
              <li>Ordered list item 3</li>
          </ol>

          <table class="table table-primary table-responsive">
              <thead>
              <tr>
                  <th>Header 1</th>
                  <th>Header 2</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                  <td>Data 1</td>
                  <td>Data 2</td>
              </tr>
              </tbody>
          </table>

          <button class="btn btn-primary">Button</button>

          <form>
              <label for="input">Input:</label>
              <input type="text" id="input" name="input" placeholder="Heeeeee" class="form-control bg-primary text-dark">
              <div class="form-check">
                  <input type="radio" class="form-check-input">
                  <label class="form-check-label">Leoforeio</label>
              </div>
              <div class="form-check">
                  <input type="checkbox" class="form-check-input" name="this"><label for="this" class="form-check-label">Leoforeio</label>
              </div>
              <input type="submit" class="btn btn-outline-light" value="Submit">
          </form>

          <div class="alert alert-warning alert-dismissable fade show" role="alert">
              <h1>Danger</h1>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      </div>
    </div>
  </div>
  <script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
  <script src="src/js/bootstrap/bootstrap.js"></script>
</body>

</html>