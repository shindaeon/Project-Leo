<?php
function BackNavBar($href, $icon, $btn_name, $btn_id)
{
      echo <<<HTML
            <div class='container-fluid p-2 bg-grey position-sticky fixed-top'>
                  <div class='row'>
                        <div class='col d-flex align-items-center'>
                              <a href="$href">
                                    <button id="$btn_id" class='btn btn-primary btn-nav' type='button'><i class="fi fi-br-$icon me-2"></i>$btn_name</button>
                              </a>
                        </div>
                  </div>
            </div>
      HTML;
}
