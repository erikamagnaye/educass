<?php 
session_start();
include '../server/server.php';

$email = $conn->real_escape_string($_POST['email']);
$password = md5($_POST['password']);
//$status = "Verified";

if (!empty($email) && !empty($password)) {
    // Check if the account is verified
    $query = "SELECT * FROM `student` WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($query);
    if ($result->num_rows) {
        while ($row = $result->fetch_assoc()) {
        
     
            $_SESSION['id'] = $row['studid'];
            $_SESSION['name'] = $row['firstname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['avatar'] = $row['picture'];
    
            header('Location: ../dashboard.php');
          }
     }
   else {
        $_SESSION['message'] = 'Invalid email or password!';
        $_SESSION['success'] = 'error';
        $_SESSION['title'] = 'Error';
        header('Location: ../login.php');
    }
} else {
    $_SESSION['message'] = 'Email or password is empty!';
    $_SESSION['success'] = 'error';
    $_SESSION['title'] = 'Error';
    header('Location: ../login.php');
}

$conn->close();

/*
if ($result->num_rows) {
    $row = $result->fetch_assoc();
    
    if ($row['accstatus'] === $status) {
        $_SESSION['id'] = $row['studid'];
        $_SESSION['name'] = $row['firstname'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['avatar'] = $row['picture'];
        
        $_SESSION['message'] = 'You have successfully logged in to the Educational Assistance System!';
        $_SESSION['success'] = 'success';

        header('Location: ../dashboard.php');
    } else {
        $_SESSION['message'] = 'Account not yet verified!';
        $_SESSION['success'] = 'error';
        $_SESSION['title'] = 'Error';
        header('Location: ../login.php');
    }
} */