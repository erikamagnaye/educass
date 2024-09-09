<?php 
    include('../server/server.php');

    session_start(); 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

 
    $accstatus = $conn->real_escape_string($_POST['accstatus']); 
 
    $studid = $_POST['studid'];

    if(isset ($_POST['update'])){
        $query = "UPDATE student SET accstatus = ? WHERE studid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $accstatus,  $studid);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = 'Update successful!';
            $_SESSION['success'] = 'success';
            $_SESSION['title'] = 'success';
            header("Location: ../notverified.php");
            exit();
        } else {
            $_SESSION['message'] = 'Update failed. Please, Try again!';
            $_SESSION['success'] = 'error';
            $_SESSION['title'] = 'Something Wrong';
            header("Location: ../notverified.php");
            exit();
        }
    }
      
    $conn->close();
?>