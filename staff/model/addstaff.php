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
    $lname 	= $conn->real_escape_string($_POST['lname']);
	$fname 	= $conn->real_escape_string($_POST['fname']);
    $email 	= $conn->real_escape_string($_POST['email']);
	$position 	= $conn->real_escape_string($_POST['position']);
    $contact_no 	= $conn->real_escape_string($_POST['contact_no']);
	$address = $conn->real_escape_string($_POST['address']);
    $age   = $conn->real_escape_string($_POST['age']);
    $gender= $conn->real_escape_string($_POST['gender']);
    $bday= $conn->real_escape_string($_POST['bday']);
    $password= md5($_POST['password']);

   // if(!empty($title) && !empty($sem) && !empty($sy) && !empty($start) && !empty($end) && !empty($status) && !empty($date) && !empty($min_grade)){

        $insert  = "INSERT INTO`staff` (`lastname`, `firstname`, `email`, `password`, `contact_no`, `age`,`birthday`, `address`, `position`, `gender`) VALUES ('$lname', '$fname','$email', '$password','$contact_no', '$age','$bday','$address','$position','$gender')";
        $result  = $conn->query($insert);

        if($result){
            $_SESSION['display'] = 'Successfully added a new Sk!';
            $_SESSION['title'] = 'Good Job';
            $_SESSION['success'] = 'success';

        }else{
            $_SESSION['display'] = 'Something went wrong!';
            $_SESSION['title'] = 'Error';
            $_SESSION['success'] = 'error';
        }

    }

//}


header("Location: ../staff.php");

$conn->close();
