<?php 
    include 'server/server.php'; // Adjust the path as needed

    session_start(); 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (strlen($_SESSION['id']) == 0) {
        header('location:login.php'); // Adjust the path as needed
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
                $_SESSION['deletemess'] = 'Successfully Deleted staff!';
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

        header("Location: staff.php"); // Adjust the path as needed
        $conn->close();
    } 
?>
