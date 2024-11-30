<?php
session_start();
include '../controllers/dbconfig.php';
if (isset($_SESSION['username'])) {
      header('Location: ../index.php');
}
if (isset($_POST['btn_submit'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $query = $dbConnection->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
      $query->bind_param('ss', $username, $password);

      $query->execute();
      $res = $query->get_result();
      if ($res->num_rows > 0) {
            $user = $res->fetch_assoc();
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            header('Location: ../index.php');
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
      <title>Login</title>
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
      <div class="container">
            <div class="row">
                  <div class="col d-flex justify-content-center my-5 py-3">
                        <img src="../public/LogoRoundedSquare.png" class="img-fluid" width="150" alt="">
                  </div>
            </div>
            <div class="row">
                  <div class="col">
                        <div class="mx-3">
                              <div class="row">
                                    <div class="col">
                                          <h1 class="text-center text-primary mb-1">Buzcaya</h1>
                                          <h4 class="text-center text-light mb-4">Log in</h4>
                                          <form method="POST">
                                                <div class="mb-3 px-5">
                                                      <label for="username" class="form-label">Your Username:</label>
                                                      <input type="text" class="form-control bg-primary border-0 p-2" id="username" name="username" required>
                                                </div>
                                                <div class="mb-5 px-5">
                                                      <label for="password" class="form-label">Your Password:</label>
                                                      <input type="password" class="form-control bg-primary border-0 p-2" id="password" name="password" required>
                                                </div>
                                                <div class="p-5 m-5"></div>
                                                <div class="row position-fixed fixed-bottom bg-secondary p-3 mx-2 rounded-top-5">
                                                      <div class="col d-flex justify-content-center">
                                                            <button class="btn bg-primary mb-3" type="submit" name="btn_submit">
                                                                  <i class="fi fi-br-sign-in-alt me-1"></i>
                                                                  Sign in
                                                            </button>
                                                      </div>
                                                      <p class="text-dark text-center">
                                                            Don't have an account yet?
                                                            <a href="signup.php">Sign Up</a>
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
      <script src="../node_modules/@popperjs/core/dist/umd/popper.js"></script>
      <script src="../src/js/bootstrap/bootstrap.js"></script>
</body>

</html>