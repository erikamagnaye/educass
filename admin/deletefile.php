<?php
include 'server/server.php'; // Adjust the path as needed

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'admin') {
    header('location:login.php');
    exit();
}

if (isset($_GET['deleteid']) && isset($_GET['studid']) ) {
    $educreportid = $_GET['deleteid'];
    $studid = $_GET['studid'];
    $educreportid = $_GET['educreportid'];

    // Check if the user has confirmed the deletion
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
        // Get the student's uploaded files and image paths from the database
        $query = "SELECT schoolid, letter, cor, grades, indigency FROM `requirements` WHERE studid = ? and educid=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $studid, $educreportid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $schoolid = $row['schoolid'];
        $letter = $row['letter'];
        $cor = $row['cor'];
        $grades = $row['grades'];
        $indigency = $row['indigency'];

        $schoolid_path = '../applicants/assets/uploads/requirements/schoolid/' . $schoolid;
        $letterpath = '../applicants/assets/uploads/requirements/schoolid/' . $letter;
        $corpath = '../applicants/assets/uploads/requirements/coe/' . $cor;
        $gradespath = '../applicants/assets/uploads/requirements/grades/' . $grades;
        $indigencypath = '../applicants/assets/uploads/requirements/indigent/' . $indigency;

        // Delete the student's data from the database
        $query = "DELETE FROM `requirements` WHERE educid = ? and studid=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $educreportid, $studid);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Delete the uploaded valid ID and picture files
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

    header("Location: educass.php");
    $conn->close();
}
?>