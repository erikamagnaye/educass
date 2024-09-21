<?php
session_start();
include '../server/server.php';

$username = $_POST['username'];
$password = $_POST['password'];

if (!empty($username) && !empty($password)) {
    $query = "SELECT * FROM `admin` JOIN staff ON staff.staffid = admin.empid WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows) {
        $adminData = $result->fetch_assoc();
        if (password_verify($password, $adminData['password'])) {
            if ($adminData['position'] == 'admin') {
                $_SESSION['id'] = $adminData['adminid'];
                $_SESSION['username'] = $adminData['username'];
                $_SESSION['role'] = $adminData['position'];
                $_SESSION['avatar'] = $adminData['image'];
                header('location: ../dashboard.php');
                exit();
            } else {
                $_SESSION['message'] = 'You are not authorized to access this system!';
                $_SESSION['success'] = 'error';
                $_SESSION['title'] = 'Access Denied';
                header('location: ../login.php');
                exit();
            }
        } else {
            $_SESSION['message'] = 'Username or password is incorrect!';
            $_SESSION['success'] = 'error';
            $_SESSION['title'] = 'Invalid Credentials';
            header('location: ../login.php');
        }
    } else {
        $_SESSION['message'] = 'Username or password is incorrect!';
        $_SESSION['success'] = 'error';
        $_SESSION['title'] = 'Invalid Credentials';
        header('location: ../login.php');
    }
} else {
    $_SESSION['message'] = 'Username or password is empty!';
    $_SESSION['success'] = 'error';
    $_SESSION['title'] = 'Invalid Credentials';
    header('location: ../login.php');
}

$conn->close();