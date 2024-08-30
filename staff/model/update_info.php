<?php 
	session_start();
	include '../server/server.php';


    if (isset($_POST['update'])) {
        $staffid = $_POST['staffid'];
            

            $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $contact_no = $_POST['contact_no'];
        $birthday = $_POST['birthday'];
        $address = $_POST['address'];
        $position = $_POST['position'];
        $gender = $_POST['gender'];
    
       
    
        $query = "UPDATE `staff` SET `lastname`='$lastname', `firstname`='$firstname', `email`='$email',  `contact_no`='$contact_no',`age`='$age', 
        `birthday`='$birthday',`address`='$address',`position`='$position', `gender`='$gender' 
        WHERE staffid=$staffid";
        $result = $conn->query($query);
    
        if($result){
            $_SESSION['alertmess'] = 'Your Information has been updated !';
            $_SESSION['title'] = 'Good Job';
            $_SESSION['success'] = 'success';
    
        }else{
            $_SESSION['alertmess'] = 'Something went wrong, Try again!';
            $_SESSION['title'] = 'Error';
            $_SESSION['success'] = 'error';
        }
        header("Location: ../profile.php");
        exit();
        
        
    }
    
    $conn->close();