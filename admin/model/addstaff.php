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
            $_SESSION['display'] = 'Successfully added a new staff!';
            $_SESSION['title'] = 'Good Job';
            $_SESSION['success'] = 'success';

        }else{
            $_SESSION['display'] = 'Something went wrong!';
            $_SESSION['title'] = 'Error';
            $_SESSION['success'] = 'danger';
        }

    }

//}


header("Location: ../staff.php");

$conn->close();
