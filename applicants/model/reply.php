<?php
include '../server/server.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['reply'])) {
    $studid=$_SESSION['id'];
    $concernid = $_POST['concernid'];
    $message = $_POST['message'];
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d");

    // Insert into reply table
    $stmt = $conn->prepare("INSERT INTO reply (studid, concernid, `reply`, `date`) 
                           VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $studid, $concernid, $message, $date);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = 'You have sent a reply';
        $_SESSION['title'] = 'Good job';
        $_SESSION['success'] = 'success';
        header('location: ../complaint.php');
        exit();
    } else {
        $_SESSION['message'] = 'Something went wrong!';
        $_SESSION['title'] = 'Error';
        $_SESSION['success'] = 'error';
        header('location: ../complaint.php');
        exit();
    }
}

$conn->close();
?>
