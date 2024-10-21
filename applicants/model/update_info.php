<?php 
	session_start();
	include '../server/server.php';


    if (isset($_POST['update'])) {
        $studid = $_SESSION['studentid'];
            

            $religion = $_POST['religion'];
        $citizenship = $_POST['citizenship'];
        $province = $_POST['province'];
        $age = $_POST['age'];
        $contact_no = $_POST['contact_no'];
        $birthday = $_POST['birthday'];
        $brgy = $_POST['brgy'];
        $street_name = $_POST['street_name'];
        $municipality = $_POST['municipality'];
        $gender = $_POST['gender'];
        $civilstatus = $_POST['civilstatus'];
    
       
    
        $query = "UPDATE `student` SET 
        `birthday`=?, 
        `contact_no`=?, 
        `brgy`=?,  
        `municipality`=?, 
        `province`=?, 
        `street_name`=?, 
        `gender`=?, 
        `citizenship`=?, 
        `religion`=?, 
        `age`=?, 
        `civilstatus`=? 
        WHERE `studid`=?";

$stmt = $conn->prepare($query);
$stmt->bind_param("sssssssssssi", 
                $birthday, 
                $contact_no, 
                $brgy, 
                $municipality, 
                $province, 
                $street_name, 
                $gender, 
                $citizenship, 
                $religion, 
                $age, 
                $civilstatus, 
                $studid);
$result = $stmt->execute();
    
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