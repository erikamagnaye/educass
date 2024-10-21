<?php
include '../server/server.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (strlen($_SESSION['studentid'] == 0) || !isset($_SESSION['studentid']) || !isset($_SESSION['email'])) {
	header('location:login.php');
    exit();
}

$email = $_SESSION['email'];
$studid = $_SESSION['studentid'];

if (!empty($_POST['cur_pass']) && !empty($_POST['new_pass']) && !empty($_POST['con_pass'])) {
    $cur_pass = $_POST['cur_pass'];
    $new_pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
    $con_pass = $_POST['con_pass'];

    if ($con_pass == $_POST['new_pass']) {
        $checkQuery = "SELECT * FROM student 
                      WHERE studid= ? AND email = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("is", $studid, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            if (password_verify($cur_pass, $row['password'])) {
                $updateQuery = "UPDATE student SET password = ? WHERE studid = ? AND email = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("sis", $new_pass, $studid, $email);
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Password has been updated!';
                    $_SESSION['success'] = 'success';
                } else {
                    $_SESSION['message'] = 'Something went wrong!';
                    $_SESSION['success'] = 'error';
                }
            } else {
                $_SESSION['message'] = 'Current Password is incorrect!';
                $_SESSION['success'] = 'error';
            }
        } else {
            $_SESSION['message'] = 'No Username found!';
            $_SESSION['success'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Passwords did not match!';
        $_SESSION['success'] = 'error';
    }
} else {
    $_SESSION['message'] = 'Please fill in all fields!';
    $_SESSION['success'] = 'error';
}

$conn->close(); // Close the database connection

if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit(); // Add exit() to stop script execution
} else {
    header("Location: dashboard.php"); // Redirect to dashboard if HTTP_REFERER is not set
    exit();
}