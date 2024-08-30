<?php 
    include '../server/server.php';

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);


    $email = $_SESSION['email'];
    $staffid = $_SESSION['staffid'];
    $cur_pass = md5($conn->real_escape_string($_POST['cur_pass']));
    $new_pass = md5($conn->real_escape_string($_POST['new_pass']));
    $con_pass = md5($conn->real_escape_string($_POST['con_pass']));

    if (!empty($username)) {
        if ($new_pass == $con_pass) {
            $check = "SELECT * FROM  staff 
                      WHERE email = '$email' AND staffid = '$staffid' AND password = '$cur_pass'";
            $res = $conn->query($check);

            if ($res->num_rows) {
                $query = "UPDATE staff SET password = '$new_pass' WHERE staffid = $staffid";
                $result = $conn->query($query);

                if ($result === true) {
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
            $_SESSION['message'] = 'Passwords did not match!';
            $_SESSION['success'] = 'error';
            $_SESSION['title'] = 'Error';
            header("Location: ../employeedashboard.php");
            exit();
        }
    } else {
        $_SESSION['message'] = 'No Username found!';
        $_SESSION['success'] = 'error';
        $_SESSION['title'] = 'Error!';
        header("Location: ../employeedashboard.php");
        exit();
    }

    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    $conn->close();

