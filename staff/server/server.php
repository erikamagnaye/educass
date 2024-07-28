<?php
$database   = 'educass';
$username   = 'root';
$host       = 'localhost';
$password   = '';

ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}





/*if(!isset($_SESSION)){
	session_start();	
}

if(!isset($_SESSION['username'])){
	header('Location: login.php');
}
  */