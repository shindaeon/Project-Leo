<?php
    function Card($busDetails, $terminalName, $destinationName, $departureTime, $farePrice) {
        echo "
        <div class='card text-dark bg-primary mb-3 p-1'>
            <div class='card-body'>
                <span class='text-mono'>$busDetails</span><br>
                <span class='badge bg-dark text-primary mb-3'>$terminalName</span>
                
                <h3 class='card-title'>$destinationName</h3>
                <div class='row'>
                    <div class='col-8'>
                        <p class='card-text'>
                            <span class='h6'>Departing on:</span><br>
                            <span class='d-inline-block mb-2'>$departureTime</span><br>
                            <span class='h6 d-inline mt-3'>Fare Price:</span><br>
                            <span>$farePrice</span>
                        </p>
                    </div>
                    <div class='col-4 d-flex justify-content-end align-items-end'>
                        <button onclick='' class='btn btn-dark d-block btn-square'><i class='text-primary fi fi-br-angle-right md-32'></i></button>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
    ?>
