<?php include '../server/server.php' ?>

<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['send'])) {
    $id = $_SESSION['id'];
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);

    $complaintfile = null; // Initialize $complaintfile as null

    if (!empty($_FILES['complaintfile']['name'])) { // Check if a file is uploaded
        $fileType = $_FILES['complaintfile']['type'];
        $fileallowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

        // Check if the file type is allowed
        if (in_array($fileType, $fileallowedTypes)) {
            $filepath = 'assets/uploads/complaintfile/';
            $complaintfile = basename($_FILES['complaintfile']['name']);
            $target_file = $filepath . $complaintfile;

            // Move the uploaded file to the desired location
            if (move_uploaded_file($_FILES['complaintfile']['tmp_name'], $target_file)) {
                // File uploaded successfully
               
            } else {
                $_SESSION['message'] = 'Error uploading file!';
                $_SESSION['title'] = 'error';
                $_SESSION['success'] = 'error';
                header('location: ../complaint.php');
                exit();
            }
        } else {
            $_SESSION['message'] = 'Invalid file type!';
            $_SESSION['title'] = 'error';
            $_SESSION['success'] = 'error';
            header('location: ../complaint.php');
            exit();
        }
    }

    // Insert data into database
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d");
    $status = "Pending";

    $stmt = $conn->prepare("INSERT INTO concerns (studid, title, description, file, date, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $id, $title, $description, $complaintfile, $date, $status);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = 'New complaint/queries has been sent!';
        $_SESSION['title'] = 'success';
        $_SESSION['success'] = 'success';
    } else {
        $_SESSION['message'] = 'Something went wrong!';
        $_SESSION['title'] = 'success';
        $_SESSION['success'] = 'error';
    }
    header('location: ../complaint.php');
    exit();
}
$conn->close();
?>