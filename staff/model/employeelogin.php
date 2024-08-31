<?php 
	session_start();
	include '../server/server.php';

	$email 	= $conn->real_escape_string($_POST['email']);
	$password = md5($_POST['password']);
	$skTypes = array('SK-Arawan','SK-Bagong Niing', 'SK-Balat Atis','SK-Briones','SK-Bulihan','SK-Buliran','SK-Callejon',
	   'SK-Corazon', 'SK-Del Valle','SK-Loob','SK-Magsaysay','SK-Matipunso','SK-Niing','SK-Poblacion','SK-Pulo',
		'SK-Pury','SK-Sampaga','SK-Sampaguita', 'SK-San Jose', 'SK-Sinturisan');
	
	if($email != '' AND $password != '' ){
		$query 		= "SELECT * FROM  staff WHERE email = '$email' AND password = '$password' ";
		
		$result 	= $conn->query($query);
		
		if($result->num_rows){
			while ($row = $result->fetch_assoc()) {
				if(in_array($row['position'], $skTypes)) {
					$_SESSION['message'] = 'You are not authorized to access this system!';
					$_SESSION['success'] = 'error';
					$_SESSION['title']='Access Denied';
					header('location: ../employeelogin.php');
					exit();
				} else {
					$_SESSION['staffid'] = $row['staffid'];
					$_SESSION['email'] = $row['email'];
					$_SESSION['role'] = $row['position'];
					$_SESSION['avatar'] = $row['image'];
					$_SESSION['firstname'] = $row['firstname'];
					$_SESSION['lastname'] = $row['lastname'];
					header('location: ../employeedashboard.php');
					exit();
				}
			}
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

