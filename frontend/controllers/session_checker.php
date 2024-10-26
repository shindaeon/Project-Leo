<?php
//checks if the user is logged in, if not, redirects to login page
session_start();
if ($_SESSION['username'] == null) {
      header('Location: views/login.php');
      exit();
}
