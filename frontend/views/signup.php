<!DOCTYPE html>
<html lang="en">

<head>
      <title>Sign Up</title>
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
                              <h1 class="text-center text-primary mb-3">Sign up</h1>
                              <form method="POST">
                                    <div class="row mb-3 px-1">
                                          <div class="col">
                                                <label for="fullname" class="form-label fs-6">Full Name:</label>
                                                <input type="text" class="form-control bg-primary border-0 p-2" id="fullname" name="fullname" required>

                                          </div>
                                          <div class="col">
                                                <label for="username" class="form-label fs-6">Username:</label>
                                                <input type="text" class="form-control bg-primary border-0 p-2" id="username" name="username" required>

                                          </div>
                                    </div>

                                    <div class="mb-3 px-1">
                                          <label for="email" class="form-label fs-6">E-mail Address:</label>
                                          <input type="email" class="form-control bg-primary border-0 p-2" id="email" name="email" required>
                                    </div>

                                    <div class="mb-3 px-1">
                                          <label for="password" class="form-label fs-6">Password:</label>
                                          <input type="password" class="form-control bg-primary border-0 p-2" id="password" name="password" required>
                                    </div>
                                    <div class="mb-3 px-1">
                                          <label for="repassword" class="form-label fs-6">Re-type password:</label>
                                          <input type="password" class="form-control bg-primary border-0 p-2" id="repassword" name="repassword" required>
                                    </div>



                                    <div class="row bg-secondary p-3 rounded-top-5">
                                          <div class="col d-flex justify-content-center">
                                                <button class="btn bg-primary mb-3" id="btn_signup">
                                                      <i class="fi fi-br-sign-in-alt me-1"></i>
                                                      Sign up
                                                </button>
                                          </div>
                                          <p class="text-dark text-center">
                                                Already have an account?
                                                <a href="login.php">Log in</a>
                                          </p>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>

      <!-- Include Popper.js and Bootstrap JavaScript -->
      <script src="../node_modules/@popperjs/core/dist/umd/popper.js"></script>
      <script src="../src/js/bootstrap/bootstrap.js"></script>
      <script>
            const btn_signup = document.getElementById('btn_signup');
            btn_signup.addEventListener('click', (e) => {
                  e.preventDefault;
                  const fullname = document.getElementById('fullname').value;
                  const username = document.getElementById('username').value;
                  const email = document.getElementById('email').value;
                  const password = document.getElementById('password').value;
                  const repassword = document.getElementById('repassword').value;
                  if (password != repassword) {
                        alert('Passwords do not match');
                        return;
                  }
                  if (fullname == '' || username == '' || email == '' || password == '' || repassword == '') {
                        alert('Please fill in all fields');
                        return;
                  } else {
                        fetch('../controllers/signup.php', {
                                    method: 'POST',
                                    headers: {
                                          'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                          fullname: fullname,
                                          username: username,
                                          email: email,
                                          password: password
                                    })
                              }).then(response => response.text())
                              .then(data => {
                                    alert(data);
                              }).catch(
                                    
                              )
                  }
            })
      </script>
</body>

</html>