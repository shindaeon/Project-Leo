<?php
      session_start();
      if (isset($_GET['qrCode'])) {
            include 'dbConfig.php';
            $qrCode = $_GET['qrCode'];
            $terminal_session_id = $_SESSION['terminal_session_id'];
            $query = $dbConnection->prepare("SELECT passengers FROM terminal_sessions WHERE session_id = ? LIMIT 1");
            $query->bind_param("i", $terminal_session_id);
            $query->execute();
            $result = $query->get_result();
            $session = $result->fetch_assoc();

            $passengers = json_decode($session['passengers'], true);
            foreach($passengers as $key => $passenger) {
                  if ($passenger['ticket'] == $qrCode) {
                        if ($passenger['status'] == 'taken') {
                              echo "already taken";
                              exit();
                        }
                        $passengers[$key]['status'] = 'taken';
                        $updatedPassengers = json_encode($passengers);
                        $query = $dbConnection->prepare("UPDATE terminal_sessions SET passengers = ? WHERE session_id = ?");
                        $query->bind_param("si", $updatedPassengers, $terminal_session_id);
                        $query->execute();
                        $query->close();
                        echo "success";
                        exit();
                  }
            }
            echo "not found";
      }

