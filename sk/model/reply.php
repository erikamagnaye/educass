<?php
include '../server/server.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['reply'])) {
    $role=$_SESSION['role'];
    $compstatus = $_POST['compstatus'];
    $concernid = $_POST['concernid'];
    $studid = $_POST['studid'];
    $message = $_POST['message'];
    $staffname = $_POST['staffname'];
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d H:i:s");

    // Insert into reply table
    $stmt = $conn->prepare("INSERT INTO remark (concernid, studid,  `remarks`, `date`, sender) 
                           VALUES (?, ?, ?, ?,?)");
    $stmt->bind_param("iisss",$concernid,  $studid, $message, $date, $role);
    $stmt->execute();

 
    // Update compstatus in concern table
    $updateStmt = $conn->prepare("UPDATE concerns SET status = ? WHERE concernid = ?");
    $updateStmt->bind_param("si", $compstatus, $concernid);
    $updateStmt->execute();

    if ($stmt->affected_rows > 0 && $updateStmt->affected_rows > 0) {
        $_SESSION['message'] = 'You have sent a reply and updated the concern status';
        $_SESSION['title'] = 'Good job';
        $_SESSION['success'] = 'success';
        header('location: ../complaint.php');
        exit();
    } elseif ($stmt->affected_rows > 0) {
        $_SESSION['message'] = 'You have sent a reply';
        $_SESSION['title'] = 'Good job';
        $_SESSION['success'] = 'success';
        header('location: ../complaint.php');
        exit();
    } elseif ($updateStmt->affected_rows > 0) {
        $_SESSION['message'] = 'Queries status updated!';
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
