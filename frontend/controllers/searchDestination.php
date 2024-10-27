<?php
      include '../controllers/dbConfig.php';
      include '../src/components/Card.php';
      $searchValue = $_GET['searchValue'];
      $searchValue = '%' . $searchValue . '%';
      if ($searchValue != '%%'){
            $query = $dbConnection->prepare("
            SELECT 
                  buses.bus_id,
                  buses.bus_number,
                  buses.bus_plate_number,
                  buses.bus_company_name,
                  terminal_sessions.session_id,
                  terminal_sessions.destination,
                  terminal_sessions.departing_time,
                  terminal_sessions.passengers,
                  terminal_sessions.bus_status,
                  terminal_sessions.fare_price,
                  terminal_sessions.terminal_location
            FROM 
                  buses
            INNER JOIN 
                  terminal_sessions 
            ON 
                  buses.current_terminal_session = terminal_sessions.session_id
            WHERE 
                  terminal_sessions.destination LIKE ?
            ");
            $query->bind_param('s', $searchValue);
            $query->execute();
            $result = $query->get_result();
            $dbConnection->close();
            $query->close();
            foreach ($result as $row) {
            $busDetails = $row['bus_company_name'] . ' #' . $row['bus_number'] . ' (' . $row['bus_plate_number'] . ')';
            Card(
                  $busDetails,
                  $row['terminal_location'],
                  $row['destination'],
                  $row['departing_time'],
                  $row['fare_price'],
                  $row['bus_id']
            );
            }
      } else {
            $query = $dbConnection->prepare("
            SELECT 
                  buses.bus_id,
                  buses.bus_number,
                  buses.bus_plate_number,
                  buses.bus_company_name,
                  terminal_sessions.session_id,
                  terminal_sessions.destination,
                  terminal_sessions.departing_time,
                  terminal_sessions.passengers,
                  terminal_sessions.bus_status,
                  terminal_sessions.fare_price,
                  terminal_sessions.terminal_location
            FROM 
                  buses
            INNER JOIN 
                  terminal_sessions 
            ON 
                  buses.current_terminal_session = terminal_sessions.session_id;
            ");
            $query->execute();
            $result = $query->get_result();
            $dbConnection->close();
            $query->close();
            foreach ($result as $row) {
            $busDetails = $row['bus_company_name'] . ' #' . $row['bus_number'] . ' (' . $row['bus_plate_number'] . ')';
            Card(
                  $busDetails,
                  $row['terminal_location'],
                  $row['destination'],
                  $row['departing_time'],
                  $row['fare_price'],
                  $row['bus_id']
            );
            }
      }
