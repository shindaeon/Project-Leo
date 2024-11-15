<?php
try {
      session_start();
      if (!isset($_SESSION['emp_username'])) {
            header('Location: login.php');
      }
      if (!isset($_SESSION['terminal_session_id'])) {
            header('Location: busmanager.php');
      }
      include 'dbConfig.php';
      $session_id = $_SESSION['terminal_session_id'];
      $query = $dbConnection->prepare("DELETE FROM terminal_sessions WHERE session_id = ?");
      $query->bind_param('i', $session_id);
      $query->execute();


      //update bus current session
      $query = $dbConnection->prepare("UPDATE buses SET current_terminal_session = '0' WHERE current_terminal_session = ?");
      $query->bind_param('i', $session_id);
      $query->execute();
      $dbConnection->close();
      $query->close();

      unset($_SESSION['terminal_session_id']);
      unset($_SESSION['session_data']);
      unset($_SESSION['bus_plate_number']);
      echo 'success';
} catch (Exception $e) {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
}

exit();
