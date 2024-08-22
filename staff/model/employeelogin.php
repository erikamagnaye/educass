<?php 
	session_start();
	include '../server/server.php';

	$email 	= $conn->real_escape_string($_POST['email']);
   //$password	= sha1($conn->real_escape_string($_POST['password']));
   $password = md5($_POST['password']);


	if($email != '' AND $password != ''){
		$query 		= "SELECT * FROM  staff WHERE email = '$email' AND password = '$password' ";
		
		$result 	= $conn->query($query);
		//
		if($result->num_rows){
			while ($row = $result->fetch_assoc()) {
				$_SESSION['id'] = $row['staffid'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['role'] = $row['position'];
				$_SESSION['avatar'] = $row['image'];

				/*if (!empty($_POST["remember"])) {
					//COOKIES for email
					setcookie("username", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
					//COOKIES for password
					setcookie("password", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
				} else {
					if (isset($_COOKIE["username"])) {
						setcookie("username", "");
					}
					if (isset($_COOKIE["password"])) {
						setcookie("password", "");
					}
				}
			*/
			}

			//$_SESSION['message'] = 'You have successfull logged in to Educational Assistance System!';
			//$_SESSION['success'] = 'success';
			//$_SESSION['title'] = 'Success';
            header('location: ../employeedashboard.php');

		}else{
			$_SESSION['message'] = 'email or password is incorrect!';
			$_SESSION['success'] = 'error';
			$_SESSION['title']='Invalid Credentials';
            header('location: ../employeelogin.php');
		}
	}else{
		$_SESSION['message'] = 'email or password is empty!';
		$_SESSION['success'] = 'error';
		$_SESSION['title']='Invalid Credentials';
        header('location: ../employeelogin.php');
	}

    

	$conn->close();

