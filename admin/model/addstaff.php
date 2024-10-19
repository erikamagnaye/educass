<?php
include '../server/server.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (strlen($_SESSION['id']) == 0) {
    header('location:login.php');
    exit();
}

if (isset($_POST['create'])) {
    $lname  = $_POST['lname'];
    $fname  = $_POST['fname'];
    $email  = $_POST['email'];
    $position  = $_POST['position'];
    $contact_no  = $_POST['contact_no'];
    $address = $_POST['address'];
    $age   = $_POST['age'];
    $gender= $_POST['gender'];
    $bday= $_POST['bday'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

      // Check if the email already exists
      $checkEmailQuery = "SELECT * FROM staff WHERE email = ?";
      $checkStmt = $conn->prepare($checkEmailQuery);
      $checkStmt->bind_param("s", $email);
      $checkStmt->execute();
      $checkResult = $checkStmt->get_result();
  
      if ($checkResult->num_rows > 0) {
          // Email already exists
          $_SESSION['display'] = 'Email is already in use!';
          $_SESSION['title'] = 'Error';
          $_SESSION['success'] = 'error';
          header("Location: ../staff.php");
          exit();
      } else {

    $insertQuery = "INSERT INTO `staff` (`lastname`, `firstname`, `email`, `password`, `contact_no`, `age`, `birthday`, `address`, `position`, `gender`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssssissss", $lname, $fname, $email, $password, $contact_no, $age, $bday, $address, $position, $gender);
    if ($stmt->execute()) {
        $_SESSION['display'] = 'Successfully added a new staff!';
        $_SESSION['title'] = 'Good Job';
        $_SESSION['success'] = 'success';
    } else {
        $_SESSION['display'] = 'Something went wrong!';
        $_SESSION['title'] = 'Error';
        $_SESSION['success'] = 'error';
    }
}
}

header("Location: ../staff.php");

$conn->close();