<?php 
    include('../server/server.php');

    session_start(); 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $username = $_SESSION['username']; 
    $reviewedby = $_SESSION['role']; 
    $appstatus = $conn->real_escape_string($_POST['appstatus']); 
    $appremark = $conn->real_escape_string($_POST['appremarks']); 
    $appid = $_POST['appid'];
    $educid = $_POST['educid'];
    $studid = $_POST['studid'];

    if(isset ($_POST['update'])){
        $query = "UPDATE application SET appstatus = ?, reviewedby = ? , appremark = ? WHERE appid = ? AND educid = ? AND studid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssiii", $appstatus, $reviewedby,$appremark, $appid, $educid, $studid);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = 'Update successful!';
            $_SESSION['success'] = 'success';
            $_SESSION['title'] = 'success';
            header("Location: ../all_current_applicants.php");
            exit();
        } else {
            $_SESSION['message'] = 'Update failed. Please, Try again!';
            $_SESSION['success'] = 'error';
            $_SESSION['title'] = 'Something Wrong';
            header("Location: ../all_current_applicants.php");
            exit();
        }
    }
      
    $conn->close();
?>