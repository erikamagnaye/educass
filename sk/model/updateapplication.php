<?php 
    include('../server/server.php');

    session_start(); 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $skid = $_SESSION['skid']; 
    $reviewedby = $_SESSION['role']; 
    $appstatus = $conn->real_escape_string($_POST['appstatus']); 
    $appid = $_POST['appid'];
    $educid = $_POST['educid'];
    $studid = $_POST['studid'];

    if(isset ($_POST['update'])){
        $query = "UPDATE application SET appstatus = ?, reviewedby = ? WHERE appid = ? AND educid = ? AND studid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssiii", $appstatus, $reviewedby, $appid, $educid, $studid);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = 'Update successful!';
            $_SESSION['success'] = 'success';
            $_SESSION['title'] = 'success';
            header("Location: ../skdashboard.php");
            exit();
        } else {
            $_SESSION['message'] = 'Update failed. Please, Try again!';
            $_SESSION['success'] = 'error';
            $_SESSION['title'] = 'Something Wrong';
            header("Location: ../skdashboard.php");
            exit();
        }
    }
      
    $conn->close();
?>