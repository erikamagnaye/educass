<?php 
include '../server/server.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$profile 	= ' ';
$accstatus 	= ' ';

if (isset($_POST['save'])) {
    // Retrieve form data
    $fname = $conn->real_escape_string($_POST['fname']);
    $mname = $conn->real_escape_string($_POST['mname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $religion = $conn->real_escape_string($_POST['religion']);
    $bplace = $conn->real_escape_string($_POST['bplace']);
    $bdate = $conn->real_escape_string($_POST['bdate']);
    $age = $conn->real_escape_string($_POST['age']);
    $cstatus = $conn->real_escape_string($_POST['cstatus']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $street = $conn->real_escape_string($_POST['street']);
    $brgy = $conn->real_escape_string($_POST['vstatus']);
    $municipality = $conn->real_escape_string($_POST['municipality']);
    $email = $conn->real_escape_string($_POST['email']);
    $contact_no = $conn->real_escape_string($_POST['contact_no']);
    $province = $conn->real_escape_string($_POST['province']);
    $password = md5($_POST['password']);
    $validid = '../assets/uploads/validid_file' . basename($_FILES['validid']['name']);

    // Validate file upload and move it to the destination
    if (move_uploaded_file($_FILES['validid']['tmp_name'], $validid)) {
        // Insert data into database
        $stmt = $conn->prepare("INSERT INTO student (lastname, firstname, midname, email, `password`, birthday, contact_no, brgy, municipality, province, street_name, validid, picture, gender, citizenship, religion, age, civilstatus, accstatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssisssssssssiss", $lname, $fname, $mname, $email, $password, $bdate, $contact_no, $brgy, $municipality, $province, $street, $validid, $profile, $gender, $bplace, $religion, $age, $cstatus, $accstatus);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'success';
            $_SESSION['mess'] = 'Account created successfully! Please wait until your account has been verified.';
        } else {
            $_SESSION['success'] = 'danger';
            $_SESSION['mess'] = 'There was an error creating your account.';
        }
        $stmt->close();
    } else {
        $_SESSION['success'] = 'danger';
        $_SESSION['mess'] = 'File upload failed.';
    }

    header("Location: ../createacc.php"); // Redirect to the account creation page
    exit();
}

$conn->close();

