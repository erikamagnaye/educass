<?php
session_start();
include '../server/server.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $position = $_POST['position'];

    if ($email != '' && $password != '' && $position != '') {
        $query = "SELECT * FROM staff WHERE email = ? AND position = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $email, $position);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows) {
            while ($row = $result->fetch_assoc()) {
                $hashed_password = $row['password'];
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['skid'] = $row['staffid'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = $row['position'];
                    $_SESSION['avatar'] = $row['image'];

                    $skpos = str_replace('SK-', '', $row['position']); // get the barangay name without "SK-"
                    $_SESSION['skpos'] = $skpos;

                    header('location: ../skdashboard.php');
                    exit();
                } else {
                    $_SESSION['message'] = 'Your credential is incorrect. Please, Try again!';
                    $_SESSION['success'] = 'error';
                    $_SESSION['title'] = 'Invalid Credentials';
                    header('location: ../sklogin.php');
                    exit();
                }
            }
        } else {
            $_SESSION['message'] = 'Your credential is incorrect. Please, Try again!';
            $_SESSION['success'] = 'error';
            $_SESSION['title'] = 'Invalid Credentials';
            header('location: ../sklogin.php');
            exit();
        }
    } else {
        $_SESSION['message'] = 'Username or password is empty!';
        $_SESSION['success'] = 'error';
        $_SESSION['title'] = 'Invalid Credentials';
        header('location: ../sklogin.php');
        exit();
    }

    $conn->close();
}