<?php 
    include 'server/server.php'; 

    session_start(); 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (strlen($_SESSION['id']) == 0) {
        header('location:login.php'); 
        exit();
    }

    if (isset($_GET['deleteid']) && isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
        $announceid = $_GET['deleteid'];

        // SQL query to delete data from the "announcement" table where announceid = $announceid
        $query = "DELETE FROM `announcement` WHERE announceid = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $announceid);

        if ($stmt->execute()) {
            $_SESSION['deletemess'] = 'Successfully Deleted announcement!';
            $_SESSION['title'] = 'Good Job';
            $_SESSION['success'] = 'success';
        } else {
            $_SESSION['deletemess'] = 'Something went wrong, Try again!';
            $_SESSION['title'] = 'Error';
            $_SESSION['success'] = 'danger';
        }

        header("Location: announcement.php"); 
        $conn->close();
    } 
?>
