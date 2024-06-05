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
        $educid = $_GET['deleteid'];

        // Check if the user has confirmed the deletion
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
            // SQL query to delete data from the "educ aids" table where educid = $educid
            $query = "DELETE FROM `educ aids` WHERE educid = '$educid'";
            $result = $conn->query($query);

            if ($result === true) {
                $_SESSION['message'] = 'Record has been Deleted!';
                $_SESSION['success'] = 'danger';
            } else {
                $_SESSION['message'] = 'Something went wrong!';
                $_SESSION['success'] = 'danger';
            }
        } else {
            $_SESSION['message'] = 'No Such Record Found!';
            $_SESSION['success'] = 'danger';
        }

        header("Location: educass.php"); // Adjust the path as needed
        $conn->close();
    } 
?>
