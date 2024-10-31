<?php
include '../controllers/dbConfig.php';
$data = file_get_contents('php://input');
$data = json_decode($data);
$fullname = $data->fullname;
$username = $data->username;
$email = $data->email;
$password = $data->password;

$query = $dbConnection->prepare('SELECT * FROM users WHERE username = ?');
$query->bind_param('s', $username);
$query->execute();
$res = $query->get_result();
if ($res->num_rows > 0) {
      echo 'Username already exists, Try another one';
      
      exit();
} else {
      $signup_query = $dbConnection->prepare('INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)');
      $signup_query->bind_param('ssss', $fullname, $username, $email, $password);
      $signup_query->execute();
      echo 'Signed Up Successfully, Try logging your account in.';
}
