<?php 
	session_start();
	include '../server/server.php';

	$username 	= $conn->real_escape_string($_POST['username']);
   //$password	= sha1($conn->real_escape_string($_POST['password']));
   $password = md5($_POST['password']);


	if($username != '' AND $password != ''){
		$query 		= "SELECT * FROM `admin` join staff on staff.staffid=admin.empid WHERE username = '$username' AND password = '$password' and position= 'admin'";
		
		$result 	= $conn->query($query);
		//
		if($result->num_rows){
			while ($row = $result->fetch_assoc()) {
				$_SESSION['id'] = $row['adminid'];
				$_SESSION['username'] = $row['username'];
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

			$_SESSION['message'] = 'You have successfull logged in to Educational Assistance System!';
			$_SESSION['success'] = 'success';

            header('location: ../dashboard.php');

		}else{
			$_SESSION['message'] = 'Username or password is incorrect!';
			$_SESSION['success'] = 'danger';
            header('location: ../login.php');
		}
	}else{
		$_SESSION['message'] = 'Username or password is empty!';
		$_SESSION['success'] = 'danger';
        header('location: ../login.php');
	}

    

	$conn->close();

