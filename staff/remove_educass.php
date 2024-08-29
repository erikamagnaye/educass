<?php 
    include 'server/server.php'; // Adjust the path as needed

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

    if (isset($_GET['deleteid'])) {
        $educid = $_GET['deleteid'];

        // Check if the user has confirmed the deletion
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
            // SQL query to delete data from the "educ aids" table where educid = $educid
            $query = "DELETE FROM `educ aids` WHERE educid = '$educid'";
            $result = $conn->query($query);

            if ($result === true) {
                $_SESSION['alertmess'] = 'Record has been Deleted!';
                $_SESSION['success'] = 'success';
                $_SESSION['title'] = 'Deleted';
            } else {
                $_SESSION['alertmess'] = 'Something went wrong!';
                $_SESSION['success'] = 'error';
                $_SESSION['title'] = 'Error';
            }
        } else {
            $_SESSION['alertmess'] = 'No Such Record Found!';
            $_SESSION['success'] = 'error';
            $_SESSION['title'] = 'Invalid';
        }

        header("Location: educass.php"); // Adjust the path as needed
        $conn->close();
    } 
?>
