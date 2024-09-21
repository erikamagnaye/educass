<?php include '../server/server.php' ?>
<?php
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
$skTypes = array('SK-Arawan','SK-Bagong Niing', 'SK-Balat Atis','SK-Briones','SK-Bulihan','SK-Buliran','SK-Callejon',
'SK-Corazon', 'SK-Del Valle','SK-Loob','SK-Magsaysay','SK-Matipunso','SK-Niing','SK-Poblacion','SK-Pulo',
 'SK-Pury','SK-Sampaga','SK-Sampaguita', 'SK-San Jose', 'SK-Sinturisan'); 
if (!isset($_SESSION['staffid']) || strlen($_SESSION['staffid']) == 0 ||in_array($_SESSION['role'], $skTypes)) {
	header('location:index.php');
    exit();
}

if (isset($_POST['create'])){
    $title 	= $conn->real_escape_string($_POST['title']);
	$sem 	= $conn->real_escape_string($_POST['sem']);
    $sy 	= $conn->real_escape_string($_POST['sy']);
	$start 	= $conn->real_escape_string($_POST['start']);
    $end 	= $conn->real_escape_string($_POST['end']);
	$status = $conn->real_escape_string($_POST['status']);
    $date   = $conn->real_escape_string($_POST['date']);
    $min_grade= $conn->real_escape_string($_POST['min_grade']);

   // if(!empty($title) && !empty($sem) && !empty($sy) && !empty($start) && !empty($end) && !empty($status) && !empty($date) && !empty($min_grade)){

        $insert  = "INSERT INTO`educ aids` (`educname`, `sem`, `sy`, `start`, `end`, `min_grade`,`date`, `status`) VALUES ('$title', '$sem','$sy', '$start','$end', '$min_grade','$date','$status')";
        $result  = $conn->query($insert);

        if($result){
            $_SESSION['message'] = 'New Educational Assistance has been posted!';
            $_SESSION['success'] = 'success';

        }else{
            $_SESSION['message'] = 'Something went wrong!';
            $_SESSION['success'] = 'danger';
        }

    }

//}


header("Location: ../educass.php");

$conn->close();
