<?php
function DashboardCard($title1, $detail1, $title2, $detail2, $action)
{
      if ($action == 'none') {
            return <<<HTML
                  <div class="card bg-primary p-2 my-2">
                        <div class="card-body">
                              <div class="row">
                                    <div class="col">
                                          <span>$title1:</span>
                                          <h3>$detail1</h3>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-9">
                                          <span>$title2:</span>
                                          <h5>$detail2</h5>
                                    </div>
                              </div>
                        </div>
                  </div>
            HTML;
      } else {
            return <<<HTML
            <div class="card bg-primary p-2 my-2">
                  <div class="card-body">
                        <div class="row">
                              <div class="col">
                                    <span>$title1:</span>
                                    <h3>$detail1</h3>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-9">
                                    <span>$title2:</span>
                                    <h5>$detail2</h5>
                              </div>
                              <div class="col-3 d-flex justify-content-end">
                                    <button class="btn btn-secondary btn-square" data-bs-toggle="modal" data-bs-target="#$action"><i class="fi fi-br-pencil"></i></button>
                              </div>
                        </div>
                  </div>
            </div>
HTML;
      }
}
