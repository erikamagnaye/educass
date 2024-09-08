<?php 
    include 'server/server.php'; 

    session_start(); 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'admin') {
        header('location:login.php');
        exit();
    }

    if (isset($_GET['concernid']) && isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
        $concernid = $_GET['concernid'];

        // SQL query to delete data from the "announcement" table where announceid = $announceid
        $query = "DELETE FROM `concerns` WHERE concernid = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $concernid);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Successfully Deleted a complaint!';
            $_SESSION['title'] = 'Good Job';
            $_SESSION['success'] = 'success';
        } else {
            $_SESSION['message'] = 'Something went wrong, Try again!';
            $_SESSION['title'] = 'Error';
            $_SESSION['success'] = 'danger';
        }

        header("Location: complaint.php"); 
        $conn->close();
    } 
?>
