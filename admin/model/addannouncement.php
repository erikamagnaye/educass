<?php include '../server/server.php' ?>
<?php
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0)) {
	header('location:login.php');
    exit();
}

if (isset($_POST['create'])){
    $title 	= $conn->real_escape_string($_POST['title']);
	$details= $conn->real_escape_string($_POST['details']);
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:sa");
	

   // if(!empty($title) && !empty($sem) && !empty($sy) && !empty($start) && !empty($end) && !empty($status) && !empty($date) && !empty($min_grade)){

        $insert  = "INSERT INTO`announcement` (`title`, `details`, `date`) VALUES ('$title', '$details','$date')";
        $result  = $conn->query($insert);

        if($result){
            $_SESSION['message'] = 'New announcement has been posted!';
            $_SESSION['title'] = 'success';
            $_SESSION['success'] = 'success';

        }else{
            $_SESSION['message'] = 'Something went wrong!';
            $_SESSION['title'] = 'success';
            $_SESSION['success'] = 'error';
        }

    }

//}


header("Location: ../announcement.php");

$conn->close();
