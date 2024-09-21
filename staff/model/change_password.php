<?php
include '../server/server.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$email = $_SESSION['email'];
$staffid = $_SESSION['staffid'];

if (!empty($email) && !empty($staffid)) {
    $cur_pass = $_POST['cur_pass'];
    $new_pass = $_POST['new_pass'];
    $con_pass = $_POST['con_pass'];

    if ($new_pass == $con_pass) {
        // Prepare the query to check the current password
        $query = "SELECT * FROM staff WHERE email = ? AND staffid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $email, $staffid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows) {
            $staffData = $result->fetch_assoc();
            if (password_verify($cur_pass, $staffData['password'])) {
                // Update the password using password hashing
                $newPassHash = password_hash($new_pass, PASSWORD_DEFAULT);
                $updateQuery = "UPDATE staff SET password = ? WHERE staffid = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("si", $newPassHash, $staffid);
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Password has been updated!';
                    $_SESSION['title'] = 'Good Job!';
                    $_SESSION['success'] = 'success';
                } else {
                    $_SESSION['message'] = 'Something went wrong!';
                    $_SESSION['success'] = 'error';
                    $_SESSION['title'] = 'Good Job!';
                }
                header("Location: ../employeedashboard.php");
                exit();
            } else {
                $_SESSION['message'] = 'Current Password is incorrect!';
                $_SESSION['success'] = 'error';
                $_SESSION['title'] = 'Error!';
                header("Location: ../employeedashboard.php");
                exit();
            }
        } else {
            $_SESSION['message'] = 'No staff found!';
            $_SESSION['success'] = 'error';
            $_SESSION['title'] = 'Error!';
            header("Location: ../employeedashboard.php");
            exit();
        }
    } else {
        $_SESSION['message'] = 'Passwords did not match!';
        $_SESSION['success'] = 'error';
        $_SESSION['title'] = 'Error';
        header("Location: ../employeedashboard.php");
        exit();
    }
} else {
    $_SESSION['message'] = 'No email or staffid found!';
    $_SESSION['success'] = 'error';
    $_SESSION['title'] = 'Error!';
    header("Location: ../employeedashboard.php");
    exit();
}

if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}

$conn->close();