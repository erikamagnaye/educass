<?php
session_start();
include '../server/server.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $query = "SELECT * FROM student WHERE email = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];
            $is_activated = $row['is_activated']; // Fetch the activation status

            // Check if the account is activated
        if ($is_activated == 1) {

            if (password_verify($password, $hashed_password)) {
                $_SESSION['studentid'] = $row['studid'];
                $_SESSION['name'] = $row['firstname'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['avatar'] = $row['picture'];

                header('Location: ../dashboard.php');
                exit();
            } 
         else {
            $_SESSION['message'] = 'Invalid email or password!';
            $_SESSION['success'] = 'error';
            $_SESSION['title'] = 'Error';
            header('Location: ../login.php');
            exit();

        } }else {
             // If the account is not activated
             $_SESSION['message'] = 'Your account is not activated yet!';
             $_SESSION['success'] = 'error';
             $_SESSION['title'] = 'Account Not Activated';
             header('Location: ../login.php');
             exit();
            }
        } else {
            $_SESSION['message'] = 'Invalid email or password!';
            $_SESSION['success'] = 'error';
            $_SESSION['title'] = 'Error';
            header('Location: ../login.php');
            exit();
             
        }
    } else {
        $_SESSION['message'] = 'Email or password is empty!';
        $_SESSION['success'] = 'error';
        $_SESSION['title'] = 'Error';
        header('Location: ../login.php');
        exit();
    }

    $conn->close();
}