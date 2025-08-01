<?php
function NavBar($btn2_icon, $btn2_name, $username, $full_name, $email)
{
  echo <<<HTML
    <script>
        function logout() {
          fetch("../controllers/logout_handler.php")
            .then((response) => response.text())
            .then((data) => {
              if (data == "success") {
                window.location.href = "/Project-Leo/frontend/views/login.php";
              } else {
                alert(
                  "There seems to be an issue logging you out. Please try again later."
                );
                console.log(data);
              }
            });
        }
    </script>
    <div class='container-fluid p-2 bg-grey position-sticky fixed-top'>
        <div class='row'>
            <div class="col d-flex align-content-center p-1">
              <img src="../public/LogoCircle.png" class="ms-2" height="25" width="25" alt="">
              <span class="mx-2 text-primary">Buzcaya</span>
            </div>
            <div class='col d-flex justify-content-end align-items-center'>
                <button class='btn btn-primary btn-nav' data-bs-toggle='offcanvas' data-bs-target='#profile' aria-controls='offcanvasWithBothOptions'>$btn2_icon $btn2_name</button>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end bg-grey text-light p-2" data-bs-scroll="true" tabindex="-1" id="profile" aria-labelledby="offcanvasWithBothOptionsLabel">
      <div class="offcanvas-header">
        <div class="col">
          <button type="button" class="btn btn-primary" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fi fi-br-circle-xmark" style="font-size: 1.25rem;"></i></button>
        </div>
        <div class="col">
          <h2 class="offcanvas-title text-primary text-end" id="offcanvasWithBothOptionsLabel">Profile</h2>
        </div>
      </div>
      <div class="offcanvas-body">
          <div class="row">
            <div class=" d-flex col justify-content-center align-content-center">
              <img src="../public/LogoCircle.png" alt="Logo" class="img-fluid" >
            </div>
          </div>
          <div class="row">
            <div class="col mt-3 text-center">
              <h3 class="text-primary">@$username</h3>
              <h5 class="text-primary">$full_name</h5>
              
              <p class="mb-5">$email</p>
              <button class="btn btn-danger" onclick="logout()">
                <i class="fi fi-br-sign-out-alt me-3"></i>Log Out
              </button>
            </div>
          </div>
      </div>
    </div>

  HTML;
}
