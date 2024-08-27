<?php
include '../server/server.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['send'])) {
    $id = $_SESSION['id'];
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);

    // Define the directory where files will be uploaded
    $uploadDir = '../assets/uploads/complaintfile/' . basename($_FILES['complaintfile']['name']);

    // Get file info
    $complaintfile = basename($_FILES['complaintfile']['name']);
    $filePath = $uploadDir . $complaintfile;
    $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

    // Check if a file is uploaded
    if (!empty($complaintfile)) {
        // Validate file type
        if (!in_array($_FILES['complaintfile']['type'], $allowedTypes)) {
            $_SESSION['message'] = 'Invalid file type!';
            $_SESSION['title'] = 'Error';
            $_SESSION['success'] = 'error';
            header('location: ../complaint.php');
            exit();
        }

        // Attempt to move the uploaded file
        if (move_uploaded_file($_FILES['complaintfile']['tmp_name'], $uploadDir)) {
            // Insert the complaint into the database with the file
            date_default_timezone_set('Asia/Manila');
            $date = date("Y-m-d");
            $status = "Pending";

            $stmt = $conn->prepare("INSERT INTO concerns (studid, title, description, file, date, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssss", $id, $title, $description, $complaintfile, $date, $status);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['message'] = 'New complaint/queries has been sent!';
                $_SESSION['title'] = 'Success';
                $_SESSION['success'] = 'success';
            } else {
                $_SESSION['message'] = 'Something went wrong!';
                $_SESSION['title'] = 'Error';
                $_SESSION['success'] = 'error';
            }
            header('location: ../complaint.php');
            exit();
        } else {
            $_SESSION['message'] = 'Error moving uploaded file. Please check directory permissions.';
            $_SESSION['title'] = 'Error';
            $_SESSION['success'] = 'error';
            header('location: ../complaint.php');
            exit();
        }
    } else {
        // Insert the complaint into the database without a file
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d");
        $status = "Pending";

        $stmt = $conn->prepare("INSERT INTO concerns (studid, title, description, date, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $id, $title, $description, $date, $status);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = 'New complaint/queries has been sent!';
            $_SESSION['title'] = 'Success';
            $_SESSION['success'] = 'success';
        } else {
            $_SESSION['message'] = 'Something went wrong!';
            $_SESSION['title'] = 'Error';
            $_SESSION['success'] = 'error';
        }
        header('location: ../complaint.php');
        exit();
    }
}

$conn->close();
?>
