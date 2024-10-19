<?php
include 'server/server.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'Admin') {
    header('location:login.php');
    exit();
}

if (isset($_GET['deleteid']) && isset($_GET['studid'])) {
    $educreportid = $_GET['deleteid'];
    $studid = $_GET['studid'];

    // Check if the user has confirmed the deletion
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
        // Get the student's uploaded files and image paths from the database
        $query = "SELECT schoolid, letter, cor, grades, indigency FROM `requirements` WHERE studid = ? AND educid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $studid, $educreportid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Handle case where no records are found
        if (!$row) {
            $_SESSION['deletemess'] = 'Record not found!';
            $_SESSION['title'] = 'Error';
            $_SESSION['success'] = 'error';
            header("Location: educass.php");
            exit();
        }

        $schoolid = $row['schoolid'];
        $letter = $row['letter'];
        $cor = $row['cor'];
        $grades = $row['grades'];
        $indigency = $row['indigency'];

        // Construct the paths to delete files
        $schoolid_path = '../applicants/assets/uploads/requirements/schoolid/' . $schoolid;
        $letterpath = '../applicants/assets/uploads/requirements/letter/' . $letter; // Adjust the path correctly
        $corpath = '../applicants/assets/uploads/requirements/coe/' . $cor;
        $gradespath = '../applicants/assets/uploads/requirements/grades/' . $grades;
        $indigencypath = '../applicants/assets/uploads/requirements/indigent/' . $indigency;

        // Delete the student's data from the database
        $query = "DELETE FROM `requirements` WHERE educid = ? AND studid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $educreportid, $studid);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Attempt to delete files and check if they exist before deleting
            if (file_exists($schoolid_path)) {
                unlink($schoolid_path);
            }
            if (file_exists($letterpath)) {
                unlink($letterpath);
            }
            if (file_exists($corpath)) {
                unlink($corpath);
            }
            if (file_exists($gradespath)) {
                unlink($gradespath);
            }
            if (file_exists($indigencypath)) {
                unlink($indigencypath);
            }

            $_SESSION['deletemess'] = 'Successfully deleted student files!';
            $_SESSION['title'] = 'Good Job';
            $_SESSION['success'] = 'success';
        } else {
            $_SESSION['deletemess'] = 'Something went wrong, try again!';
            $_SESSION['title'] = 'Error';
            $_SESSION['success'] = 'error';
        }
    } else {
        $_SESSION['deletemess'] = 'No such record found!';
        $_SESSION['title'] = 'Error';
        $_SESSION['success'] = 'error';
    }

    header("Location: educass.php");
    $conn->close();
}
?>
