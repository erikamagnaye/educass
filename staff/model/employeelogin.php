<?php
session_start();
include '../server/server.php';

$email = $_POST['email'];
$password = $_POST['password'];
$skTypes = array('SK-Arawan','SK-Bagong Niing', 'SK-Balat Atis','SK-Briones','SK-Bulihan','SK-Buliran','SK-Callejon',
   'SK-Corazon', 'SK-Del Valle','SK-Loob','SK-Magsaysay','SK-Matipunso','SK-Niing','SK-Poblacion','SK-Pulo',
    'SK-Pury','SK-Sampaga','SK-Sampaguita', 'SK-San Jose', 'SK-Sinturisan');

if (!empty($email) && !empty($password)) {
    $query = "SELECT * FROM staff WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows) {
        $staffData = $result->fetch_assoc();
        if (password_verify($password, $staffData['password'])) {
            if (in_array($staffData['position'], $skTypes)) {
                $_SESSION['message'] = 'You are not authorized to access this system!';
                $_SESSION['success'] = 'error';
                $_SESSION['title'] = 'Access Denied';
                header('location: ../employeelogin.php');
                exit();
            } else {
                $_SESSION['staffid'] = $staffData['staffid'];
                $_SESSION['email'] = $staffData['email'];
                $_SESSION['role'] = $staffData['position'];
                $_SESSION['avatar'] = $staffData['image'];
                $_SESSION['firstname'] = $staffData['firstname'];
                $_SESSION['lastname'] = $staffData['lastname'];
                header('location: ../employeedashboard.php');
                exit();
            }
        } else {
            $_SESSION['message'] = 'email or password is incorrect!';
            $_SESSION['success'] = 'error';
            $_SESSION['title'] = 'Invalid Credentials';
            header('location: ../employeelogin.php');
        }
    } else {
        $_SESSION['message'] = 'email or password is incorrect!';
        $_SESSION['success'] = 'error';
        $_SESSION['title'] = 'Invalid Credentials';
        header('location: ../employeelogin.php');
    }
} else {
    $_SESSION['message'] = 'email or password is empty!';
    $_SESSION['success'] = 'error';
    $_SESSION['title'] = 'Invalid Credentials';
    header('location: ../employeelogin.php');
}

$conn->close();