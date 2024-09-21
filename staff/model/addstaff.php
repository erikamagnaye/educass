<?php
include '../server/server.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$skTypes = array('SK-Arawan','SK-Bagong Niing', 'SK-Balat Atis','SK-Briones','SK-Bulihan','SK-Buliran','SK-Callejon',
'SK-Corazon', 'SK-Del Valle','SK-Loob','SK-Magsaysay','SK-Matipunso','SK-Niing','SK-Poblacion','SK-Pulo',
 'SK-Pury','SK-Sampaga','SK-Sampaguita', 'SK-San Jose', 'SK-Sinturisan'); 

if (!isset($_SESSION['staffid']) || strlen($_SESSION['staffid']) == 0 || in_array($_SESSION['role'], $skTypes)) {
    header('location:index.php');
    exit();
}

if (isset($_POST['create'])) {
    $lname  = $_POST['lname'];
    $fname  = $_POST['fname'];
    $email  = $_POST['email'];
    $position  = $_POST['position'];
    $contact_no  = $_POST['contact_no'];
    $address = $_POST['address'];
    $age   = $_POST['age'];
    $gender= $_POST['gender'];
    $bday= $_POST['bday'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $insertQuery = "INSERT INTO `staff` (`lastname`, `firstname`, `email`, `password`, `contact_no`, `age`, `birthday`, `address`, `position`, `gender`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssssisssss", $lname, $fname, $email, $password, $contact_no, $age, $bday, $address, $position, $gender);
    if ($stmt->execute()) {
        $_SESSION['display'] = 'Successfully added a new Sk!';
        $_SESSION['title'] = 'Good Job';
        $_SESSION['success'] = 'success';
    } else {
        $_SESSION['display'] = 'Something went wrong!';
        $_SESSION['title'] = 'Error';
        $_SESSION['success'] = 'error';
    }
}

header("Location: ../staff.php");

$conn->close();