<?php
include '../server/server.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$skTypes = array(
    'SK-Arawan',
    'SK-Bagong Niing',
    'SK-Balat Atis',
    'SK-Briones',
    'SK-Bulihan',
    'SK-Buliran',
    'SK-Callejon',
    'SK-Corazon',
    'SK-Del Valle',
    'SK-Loob',
    'SK-Magsaysay',
    'SK-Matipunso',
    'SK-Niing',
    'SK-Poblacion',
    'SK-Pulo',
    'SK-Pury',
    'SK-Sampaga',
    'SK-Sampaguita',
    'SK-San Jose',
    'SK-Sinturisan'
);
if (!isset($_SESSION['skid']) || strlen($_SESSION['skid']) == 0 || !in_array($_SESSION['role'], $skTypes)||!isset($_SESSION['skpos'])) {
    header('location:index.php');
    exit();
}

$sk = $_SESSION['role'];
$skid = $_SESSION['skid'];

if (!empty($_POST['cur_pass']) && !empty($_POST['new_pass']) && !empty($_POST['con_pass'])) {
    $cur_pass = $_POST['cur_pass'];
    $new_pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
    $con_pass = $_POST['con_pass'];

    if ($con_pass == $_POST['new_pass']) {
        $checkQuery = "SELECT * FROM stafft 
                      WHERE staffid= ? AND position = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("is", $skid, $sk);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            if (password_verify($cur_pass, $row['password'])) {
                $updateQuery = "UPDATE staff SET password = ? WHERE staffid = ? AND position = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("sis", $new_pass, $skid, $sk);
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Password has been updated!';
                    $_SESSION['success'] = 'success';
                    $_SESSION['title'] = 'success';
                } else {
                    $_SESSION['message'] = 'Something went wrong!';
                    $_SESSION['success'] = 'error';
                    $_SESSION['title'] = 'Error';
                }
            } else {
                $_SESSION['message'] = 'Current Password is incorrect!';
                $_SESSION['success'] = 'error';
                $_SESSION['title'] = 'Error';
            }
        } else {
            $_SESSION['message'] = 'No Username found!';
            $_SESSION['success'] = 'error';
            $_SESSION['title'] = 'Error';
        }
    } else {
        $_SESSION['message'] = 'Passwords did not match!';
        $_SESSION['success'] = 'error';
        $_SESSION['title'] = 'Error';
    }
} else {
    $_SESSION['message'] = 'Please fill in all fields!';
    $_SESSION['success'] = 'error';
    $_SESSION['title'] = 'Error';
}

$conn->close(); // Close the database connection

if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit(); // Add exit() to stop script execution
} else {
    header("Location: skdashboard.php"); // Redirect to dashboard if HTTP_REFERER is not set
    exit();
}