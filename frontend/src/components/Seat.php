<?php
      function Seat($seatNumber, $status) {
            if ($status == 'reserved' || $status == 'taken') {
                  return <<<HTML
                        <input type="radio" id="seat$seatNumber" name="seat" value="$seatNumber" disabled />
                        <label for="seat$seatNumber" class="seatLabel px-3 py-4 m-2 col-2 rounded-5">$seatNumber</label>
                  HTML;
            } else {
                  return <<<HTML
                        <input type="radio" id="seat$seatNumber" name="seat" value="$seatNumber" />
                        <label for="seat$seatNumber" class="seatLabel px-3 py-4 m-2 col-2 rounded-5">$seatNumber</label>
                  HTML;
            }
      }