<?php 
	include('../server/server.php');

    session_start(); 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if (strlen($_SESSION['studentid'] == 0) || !isset($_SESSION['studentid']) || !isset($_SESSION['email'])) {
        header('location:login.php');
        exit();
    }
   // if(!isset($_SESSION['id'])){
        //if (isset($_SERVER["HTTP_REFERER"])) {
           // header("Location: " . $_SERVER["HTTP_REFERER"]);
       // }
    //}

    $id = $_SESSION['studentid'];   // Get the current stud ID from the session
	//$id 	= $conn->real_escape_string($_POST['id']);
    $profile 	= $conn->real_escape_string($_POST['profileimg']); // base 64 image
	$profile2 	= $_FILES['img']['name'];
    // change profile2 name
    $newName = date('dmYHis').str_replace(" ", "", $profile2);

    // image file directory
    $target = "../assets/uploads/applicant_profile/".basename($newName);

    if(!empty($id)){
        $query = "SELECT * FROM student  WHERE studid='$id'";
        $res = $conn->query($query);

        if($res->num_rows == 0){

            $_SESSION['message'] = 'User not found!';
            $_SESSION['success'] = 'danger';

            if (isset($_SERVER["HTTP_REFERER"])) {
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }

        }else{
            $row = $res->fetch_assoc();
            if (!empty($profile) && !empty($profile2)) {
                $update = "UPDATE student SET picture='$profile' WHERE studid='$row[studid]'";
                $result = $conn->query($update);
                $_SESSION['avatar'] = $profile;
            } else if (!empty($profile) && empty($profile2)) {
                $update = "UPDATE student SET picture='$profile' WHERE studid='$row[studid]'";
                $result = $conn->query($update);
                $_SESSION['avatar'] = $profile;
            } else if (!empty($newName)) {
                $update = "UPDATE student SET picture='$newName' WHERE studid='$row[studid]'";
                $result = $conn->query($update);
                if ($result) {
                    move_uploaded_file($_FILES['img']['tmp_name'], $target);
                    $_SESSION['avatar'] = $newName;
                }
            }
        }
      }  else{

        $_SESSION['message'] = 'Please fill up the form completely!';
        $_SESSION['success'] = 'danger';
    }

    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
	$conn->close();
