<?php
include '../../controllers/dbConfig.php';
session_start();
if (isset($_SESSION['emp_username'])) {
      header('Location: busmanager.php');
}
if (isset($_POST['btn_submit'])) {
      $emp_username = $_POST['username'];
      $emp_password = $_POST['password'];
      $query = $dbConnection->prepare("SELECT * FROM cashiers WHERE username = ? AND password = ?");
      $query->bind_param('ss', $emp_username, $emp_password);

      $query->execute();
      $res = $query->get_result();
      if ($res->num_rows > 0) {
            $user = $res->fetch_assoc();
            $_SESSION['emp_username'] = $user['username'];
            $_SESSION['emp_full_name'] = $user['cashier_name'];
            if ($user['current_terminal_session'] != NULL){
                  $_SESSION['terminal_session_id'] = $user['current_terminal_session'];
                  header('Location: dashboard.php');
            } else {
                  header('Location: busmanager.php');
            }
      } else {
            echo '<script>alert("Invalid username or password")</script>';
      }
      $dbConnection->close();
      $query->close();
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

<body class="bg-primary">
      <div class="container">
            <div class="row">
                  <div class="col d-flex justify-content-center my-5 py-3">
                        <img src="../../public/LogoRoundedSquare.png" class="img-fluid" width="150" alt="">
                  </div>
            </div>
            <div class="row">
                  <div class="col">
                        <div class="mx-3">
                              <div class="row">
                                    <div class="col">
                                          <h1 class="text-center text-dark mb-3">Admin Log in</h1>
                                          <form method="POST" action="">
                                                <div class="mb-3 px-5">
                                                      <label for="username" class="form-label text-dark">Your Username:</label>
                                                      <input type="text" class="form-control bg-dark text-light border-0 p-2" id="username" name="username" required>
                                                </div>
                                                <div class="mb-5 px-5">
                                                      <label for="password" class="form-label text-dark">Your Password:</label>
                                                      <input type="password" class="form-control bg-dark text-light border-0 p-2" id="password" name="password" required>
                                                </div>
                                                <div class="row position-sticky fixed-bottom bg-dark p-3 rounded-top-5">
                                                      <div class="col d-flex justify-content-center">
                                                            <button class="btn bg-secondary text-light mb-3" type="submit" name="btn_submit">
                                                                  <i class="fi fi-br-sign-in-alt me-1"></i>
                                                                  Sign in
                                                            </button>
                                                      </div>
                                                      <p class="text-light text-center">
                                                            For new employees, ask your employer for a new account.
                                                      </p>
                                                </div>
                                          </form>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <!-- Include Popper.js and Bootstrap JavaScript -->
      <script src="../../node_modules/@popperjs/core/dist/umd/popper.js"></script>
      <script src="../../src/js/bootstrap/bootstrap.js"></script>
</body>

</html>