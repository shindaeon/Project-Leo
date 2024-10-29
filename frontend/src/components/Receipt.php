<?php
      function Receipt($barcode, $destination, $bus_name, $bus_number, $bus_plate_number, $bus_type, $seat_no, $fare_price, $date_booked, $expiration_date, $departing_time) {
            echo <<<HTML
                  <div class="card bg-primary text-dark p-4" id="receipt">
                              <div class="row">
                                    <div class="col justify-content-center d-flex">
                                          <div id="qrcode" class="p-3"></div>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col d-flex justify-content-center">
                                          <span id="txt-code" class="text-mono d-inline-block text-uppercase mb-4">$barcode</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col">
                                          <span class="text-mono">Destination:</span><br>
                                          <span class="text-mono text-uppercase d-inline-block mb-2">$destination</span><br>
                                          <span class="text-mono">Bus Name:</span><br>
                                          <span class="text-mono text-uppercase d-inline-block mb-2">$bus_name</span><br>
                                          <span class="text-mono">Bus Number:</span><br>
                                          <span class="text-mono text-uppercase d-inline-block mb-2">#$bus_number</span><br>
                                          <span class="text-mono">Bus Plate Number:</span><br>
                                          <span class="text-mono text-uppercase d-inline-block mb-2">$bus_plate_number</span><br>
                                          <span class="text-mono">Bus Type:</span><br>
                                          <span class="text-mono text-uppercase d-inline-block mb-2">$bus_type</span><br>
                                    </div>
                                    <div class="col">
                                          <span class="text-mono">Seat No:</span><br>
                                          <span class="text-mono text-uppercase d-inline-block mb-2">$seat_no</span><br>
                                          <span class="text-mono">Fare Price:</span><br>
                                          <span class="text-mono text-uppercase d-inline-block mb-2">&#8369;$fare_price</span><br>
                                          <span class="text-mono">Date Booked:</span><br>
                                          <span class="text-mono text-uppercase d-inline-block mb-2">$date_booked</span><br>
                                          <span class="text-mono">Book Expires on:</span><br>
                                          <span class="text-mono text-uppercase d-inline-block mb-2">$expiration_date</span><br>
                                          <span class="text-mono">Bus Departs on:</span><br>
                                          <span class="text-mono text-uppercase d-inline-block mb-2">$departing_time</span><br>
                                    </div>
                              </div>
                        </div>
            HTML;
      
      }
?>
