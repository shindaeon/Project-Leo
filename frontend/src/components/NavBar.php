<?php
function NavBar($btn1_icon, $btn1_name, $btn2_icon, $btn2_name)
{
  echo <<<HTML
    <div class='container-fluid p-2 bg-grey position-sticky fixed-top'>
        <div class='row'>
            <div class='col d-flex align-items-center'>
                <button class='btn btn-primary btn-nav' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasWithBothOptions' aria-controls='offcanvasWithBothOptions'>$btn1_icon $btn1_name</button>
            </div>
            <div class='col d-flex justify-content-end align-items-center'>
                <button class='btn btn-primary btn-nav'>$btn2_icon $btn2_name</button>
            </div>
        </div>
    </div>

  HTML;
}
?>