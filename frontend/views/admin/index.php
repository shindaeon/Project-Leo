<?php
session_start();
if (!isset($_SESSION['emp_username'])) {
      header('Location: login.php');
}
if (!isset($_SESSION['terminal_session_id']) || $_SESSION['terminal_session_id'] == 0) {
      header('Location: busmanager.php');
}
if (isset($_SESSION['emp_username']) && isset($_SESSION['terminal_session_id'])){
      header('Location: dashboard.php');
} else {
      header('Location: login.php');
}
exit();
