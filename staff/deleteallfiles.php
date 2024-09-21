<?php
include 'server/server.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$skTypes = array(
    'SK-Arawan',
    'SK-Bagong Niing',
    'SK-Balat Atis',
    'SK-Briones',
    'SK-Bulihan',
    'SK-Buliran',
    'SK-Callejon',
    'SK-Corazon',
    'SK-Del Valle',
    'SK-Loob',
    'SK-Magsaysay',
    'SK-Matipunso',
    'SK-Niing',
    'SK-Poblacion',
    'SK-Pulo',
    'SK-Pury',
    'SK-Sampaga',
    'SK-Sampaguita',
    'SK-San Jose',
    'SK-Sinturisan'
);
if (!isset($_SESSION['staffid']) || strlen($_SESSION['staffid']) == 0 || in_array($_SESSION['role'], $skTypes)) {
    header('location:index.php');
    exit();
}

if (isset($_GET['deleteid']) ) {
    $educreportid = $_GET['deleteid'];
   

    // Check if the user has confirmed the deletion
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
        // Get the student's uploaded files and image paths from the database
        $query = "SELECT * FROM `requirements` WHERE  educid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",  $educreportid);
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
        $query = "DELETE FROM `requirements` WHERE educid = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $educreportid);
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

            $_SESSION['deletemess'] = 'Successfully deleted student!';
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
