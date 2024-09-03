<?php 
	session_start();
	include '../server/server.php';

	$email 	= $conn->real_escape_string($_POST['email']);
	$position 	= $conn->real_escape_string($_POST['position']);
	$password = md5($_POST['password']);

	
	if($email != '' AND $password != ''AND $position != '' ){
		$query 		= "SELECT * FROM  staff WHERE email = '$email' AND password = '$password' AND position = '$position'  ";
		$result 	= $conn->query($query);
		//
		if($result->num_rows){
			while ($row = $result->fetch_assoc()) {
				$_SESSION['skid'] = $row['staffid'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['role'] = $row['position'];
				$_SESSION['avatar'] = $row['image'];
				
				$skpos = str_replace('SK-', '', $row['position']); // get the barangay name without "SK-"
				$_SESSION['skpos'] = $skpos; 
			}

            header('location: ../skdashboard.php');

		}else{
			$_SESSION['message'] = 'Your credential is incorrect. Please, Try again!';
			$_SESSION['success'] = 'error';
			$_SESSION['title']='Invalid Credentials';
            header('location: ../sklogin.php');
		}
	}else{
		$_SESSION['message'] = 'Username or password is empty!';
		$_SESSION['success'] = 'error';
		$_SESSION['title']='Invalid Credentials';
        header('location: ../sklogin.php');
	}

    

	$conn->close();
