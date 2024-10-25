<?php
$dbServer = '127.0.0.1';
$dbUsername = 'daeon8';
$dbPassword = '1234';
$dbDatabase = 'fastlane_systems';
$dbPort = '3306';

$dbConnection = new mysqli($dbServer, $dbUsername, $dbPassword, $dbDatabase, $dbPort);
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}
?>