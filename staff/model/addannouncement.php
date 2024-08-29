<?php include '../server/server.php' ?>
<?php
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
$skTypes = array('SK-Arawan','SK-Bagong Niing', 'SK-Balat Atis','SK-Briones','SK-Bulihan','SK-Buliran','SK-Callejon',
'SK-Corazon', 'SK-Del Valle','SK-loob','SK-Magsaysay','SK-Matipunso','SK-Niing','SK-Poblacion','SK-Pulo',
 'SK-Pury','SK-Sampaga','SK-Sampaguita', 'SK-San Jose', 'SK-Sinturisan'); 
if (!isset($_SESSION['staffid']) || strlen($_SESSION['staffid']) == 0 ||in_array($_SESSION['role'], $skTypes)) {
	header('location:index.php');
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
            $_SESSION['alertmess'] = 'New announcement has been posted!';
            $_SESSION['title'] = 'success';
            $_SESSION['success'] = 'success';

        }else{
            $_SESSION['alertmess'] = 'Something went wrong!';
            $_SESSION['title'] = 'success';
            $_SESSION['success'] = 'error';
        }
        header("Location: ../announcement.php");
        exit;
    }

//}




$conn->close();
