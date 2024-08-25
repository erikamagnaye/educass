<?php 
    include 'server/server.php'; // Adjust the path as needed

    session_start(); 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'admin') {
        header('location:login.php');
        exit();
    }

    if (isset($_GET['deleteid'])) {
        $studid = $_GET['deleteid'];

        // Check if the user has confirmed the deletion
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
            // Get the student's uploaded files and image paths from the database
            $query = "SELECT validid, picture FROM `student` WHERE studid = '$studid'";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();

            $validid = $row['validid'];
            $picture = $row['picture'];

            $validid_path = '../applicants/assets/uploads/validid_file/'.$validid;
            $picture_path = '../applicants/assets/uploads/applicant_profile/'.$picture;

            // Delete the student's data from the database
            $query = "DELETE FROM `student` WHERE studid = '$studid'";
            $result = $conn->query($query);

            if ($result === true) {
                // Delete the uploaded valid ID and picture files
                if (file_exists($validid_path)) {  /// THIS WILL CHECK IF THE FILE EXIST
                    unlink($validid_path);      /// THIS WILL DELETE THE FILE FROM ITS LOCATION
                }
                if (file_exists($picture_path)) {
                    unlink($picture_path);
                }

                $_SESSION['deletemess'] = 'Successfully Deleted student!';
                $_SESSION['title'] = 'Good Job';
                $_SESSION['success'] = 'success';
            } else {
                $_SESSION['deletemess'] = 'Something went wrong, Try again!';
                $_SESSION['title'] = 'Error';
                $_SESSION['success'] = 'error';
            }
        } else {
            $_SESSION['deletemess'] = 'No Such Record Found!';
            $_SESSION['title'] = 'Error';
            $_SESSION['success'] = 'error';
        }

        header("Location: student.php"); 
        $conn->close();
    } 
?>
