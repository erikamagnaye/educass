<?php 
    include 'server/server.php'; // Adjust the path as needed

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

    if (isset($_GET['deleteid'])) {
        $staffid = $_GET['deleteid'];

        // Check if the user has confirmed the deletion
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
            // SQL query to delete data from the "educ aids" table where educid = $educid
            $query = "DELETE FROM `staff` WHERE staffid = '$staffid'";
            $result = $conn->query($query);

            if ($result === true) {
                $_SESSION['deletemess'] = 'Successfully Deleted SK!';
                $_SESSION['title'] = 'Good Job';
                $_SESSION['success'] = 'success';
        
            }else{
                $_SESSION['deletemess'] = 'Something went wrong, Try again!';
                $_SESSION['title'] = 'Error';
                $_SESSION['success'] = 'danger';
            }
        } else {
            $_SESSION['deletemess'] = 'No Such Record Found!';
            $_SESSION['title'] = 'Error';
            $_SESSION['success'] = 'danger';
        }

        header("Location: staff.php"); 
        $conn->close();
    } 
?>
