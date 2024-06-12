<?php 
	session_start();
	include '../server/server.php';

	$email 	= $conn->real_escape_string($_POST['email']);
   //$password	= sha1($conn->real_escape_string($_POST['password']));
   $password = md5($_POST['password']);

//
	if($email != '' AND $password != ''){
		$query 		= "SELECT * FROM `student`  WHERE email = '$email' AND password = '$password' ";
		
		$result 	= $conn->query($query);
		//
		if($result->num_rows){
			while ($row = $result->fetch_assoc()) {
				$_SESSION['id'] = $row['studid'];
				$_SESSION['name'] = $row['firstname'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['avatar'] = $row['picture'];

	
			}

			$_SESSION['message'] = 'You have successfull logged in to Educational Assistance System!';
			$_SESSION['success'] = 'success';

            header('location: ../dashboard.php');

		}else{
			$_SESSION['message'] = 'Invalid Credentials!';
			$_SESSION['success'] = 'danger';
            header('location: ../login.php');
		}
	}else{
		$_SESSION['message'] = 'email or password is empty!';
		$_SESSION['success'] = 'danger';
        header('location: ../login.php');
	}

    

	$conn->close();

