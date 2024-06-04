<?php 
    include '../server/server.php';

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (strlen($_SESSION['id'] == 0)) {
        header('location:login.php');
        exit();
    }

    $username = $_SESSION['username'];
    $id = $_SESSION['id'];
    $cur_pass = md5($conn->real_escape_string($_POST['cur_pass']));
    $new_pass = md5($conn->real_escape_string($_POST['new_pass']));
    $con_pass = md5($conn->real_escape_string($_POST['con_pass']));

    if (!empty($username)) {
        if ($new_pass == $con_pass) {
            $check = "SELECT * FROM admin 
                      JOIN staff ON admin.empid = staff.staffid 
                      WHERE admin.username = '$username' AND admin.adminid = '$id' AND staff.password = '$cur_pass'";
            $res = $conn->query($check);

            if ($res->num_rows) {
                $query = "UPDATE staff SET password = '$new_pass' WHERE staffid = (SELECT empid FROM admin WHERE username = '$username' AND adminid = '$id')";
                $result = $conn->query($query);

                if ($result === true) {
                    $_SESSION['message'] = 'Password has been updated!';
                    $_SESSION['success'] = 'success';
                } else {
                    $_SESSION['message'] = 'Something went wrong!';
                    $_SESSION['success'] = 'danger';
                }
            } else {
                $_SESSION['message'] = 'Current Password is incorrect!';
                $_SESSION['success'] = 'danger';
            }
        } else {
            $_SESSION['message'] = 'Passwords did not match!';
            $_SESSION['success'] = 'danger';
        }
    } else {
        $_SESSION['message'] = 'No Username found!';
        $_SESSION['success'] = 'danger';
    }

    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    $conn->close();

