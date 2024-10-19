<?php
include '../server/server.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (strlen($_SESSION['id']) == 0) {
    header('location:login.php');
    exit();
}

$role = $_SESSION['role'];
$id = $_SESSION['id'];
$email = $_SESSION['email'];
if (!empty($_POST['cur_pass']) && !empty($_POST['new_pass']) && !empty($_POST['con_pass'])) {
    $cur_pass = $_POST['cur_pass'];
    $new_pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
    $con_pass = $_POST['con_pass'];

    if ($con_pass == $_POST['new_pass']) {
        $checkQuery = "SELECT * FROM  staff  
                      WHERE staffid = ? AND email = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("is", $id, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            if (password_verify($cur_pass, $row['password'])) {
                $updateQuery = "UPDATE staff SET password = ? WHERE staffid = (SELECT empid FROM admin WHERE adminid = ?)";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("si", $new_pass, $id);
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

if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}

$conn->close();