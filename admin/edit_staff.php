

<?php
include 'server/server.php';


session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'admin') {
	header('location:login.php');
    exit();
}
$role= $_SESSION['role'];
$username= $_SESSION['username'];
if (isset($_GET['staffid'])) {
	$staffid = $_GET['staffid'];

	$query = "SELECT * FROM `staff` WHERE staffid = $staffid";
	$view = mysqli_query($conn, $query);

	if ($row = mysqli_fetch_assoc($view)) {
		$lname = $row['lastname'];
		$fname = $row['firstname'];
		$email = $row['email'];
		$contact_no = $row['contact_no'];
		$age = $row['age'];
		$bday = $row['birthday'];
		$address = $row['address'];
		$position = $row['position'];
        $gender = $row['gender'];
	} else {
		$_SESSION['message'] = 'No Record found!';
		$_SESSION['success'] = 'danger';
		header("Location: ../staff.php");
		exit();
	}
}

if (isset($_POST['update'])) {
	$lname = $_POST['lname'];
		$fname = $_POST['fname'];
		$email = $_POST['email'];
		$contact_no = $_POST['contact_no'];
		$age = $_POST['age'];
		$bday = $_POST['bday'];
		$address = $_POST['address'];
		$position = $_POST['position'];
        $gender = $_POST['gender'];

   

	$query = "UPDATE `staff` SET `lastname`='$lname', `firstname`='$fname', `email`='$email', `contact_no`='$contact_no', `age`='$age', `birthday`='$bday', `address`='$address', `position`='$position', `gender`='$gender' WHERE staffid=$staffid";
	$result = $conn->query($query);

    if($result){
        $_SESSION['alertmess'] = 'Successfully Updated staff!';
        $_SESSION['title'] = 'Good Job';
        $_SESSION['success'] = 'success';

    }else{
        $_SESSION['alertmess'] = 'Something went wrong, Try again!';
        $_SESSION['title'] = 'Error';
        $_SESSION['success'] = 'danger';
    }
    header("Location: staff.php");
	exit();
    
	
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Educational Assistance</title>
	<link rel="icon" href="assets/img/logo.png" type="image/x-icon"/>   <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">

</head>
<body>
	<?//php include 'templates/loading_screen.php' ?>

	<div class="wrapper">
		<!-- Main Header -->
		<?//php include 'templates/main-header.php' ?>
		<!-- End Main Header -->

		<!-- Sidebar -->
		<?//php include 'templates/sidebar.php' ?>
		<!-- End Sidebar -->
 
		
			<div class="content">
			
				<div class="page-inner">
				
						<div class="row mt--2 justify-content-center">
                    <div class="col-md-7">
                        <div class="card" style="padding: 5px;margin:10px;">
                            <div class="card-header bg-success" style="border-radius: 8px;">
                                <div class="card-head-row">
                                    <div class="card-title text-center" style=" color: #ffffff;">Update Staff Information</div>
                                </div>
                            </div>
                            <form method="POST" action="">
                            <div class="row" style="padding: 2px;margin:2px;">
                                        <div class="form-group col-md-4">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" value="<?php echo $lname; ?>" name="lname" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" value="<?php echo $fname; ?>" name="fname" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Email</label>
                                            <input type="email" class="form-control" value="<?php echo $email; ?>" name="email" required>
                                        </div>
                                    </div>
                                <div class="row" style="padding: 2px;margin:2px;">
                                        <div class="form-group col-md-4">
                                            <label>Position</label>
                                            <input type="text" class="form-control" value="<?php echo $position; ?>" name="position" list="posOptions" required>
                                            <datalist id="posOptions">
                                                <option value="SK-Arawan">
                                                <option value="SK-Bagong Niing">
                                                <option value="SK-Balat Atis">
                                                <option value="SK-Briones">
                                                <option value="SK-Bulihan">
                                                <option value="SK-Buliran">
                                                <option value="SK-Callejon">
                                                <option value="SK-Corazon">
                                                <option value="SK-Del Valle">
                                                <option value="SK-Loob">
                                                <option value="SK-Magsaysay">
                                                <option value="SK-Matipunso">
                                                <option value="SK-Niing">
                                                <option value="SK-Poblacion">
                                                <option value="SK-Pulo">
                                                <option value="SK-Pury">
                                                <option value="SK-Sampaga">
                                                <option value="SK-Sampaguita">
                                                <option value="SK-San Jose">
                                                <option value="SK-Sinturisan">
                                            </datalist>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Contact Number</label>
                                            <input type="text" class="form-control" value="<?php echo $contact_no; ?>" name="contact_no" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Address</label>
                                            <input type="text" class="form-control" value="<?php echo $address; ?>" name="address" required>
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 2px;margin:2px;">
                                        <div class="form-group col-md-4">
                                            <label>Age</label>
                                            <input type="number" class="form-control" value="<?php echo $age; ?>" name="age" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Birthday</label>
                                            <input type="date" class="form-control" value="<?php echo $bday; ?>" name="bday" required>
                                        </div>
                                        <div class="form-group col-md-4">
    <label>Gender</label>
    <select class="form-control" id="" required name="gender">
        <option value="Male" <?php echo ($gender == 'Male')? 'selected' : '';?>>Male</option>
        <option value="Female" <?php echo ($gender == 'Female')? 'selected' : '';?>>Female</option>
    </select>
</div>
       
                                    </div>





                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                                    <a href="staff.php" class="btn btn-secondary">Back</a>
                                </div>
                              
                            </form>

                        </div>
								
							</div>
						</div>
					</div>
				</div>
			
                
			
                
			<!-- Main Footer -->
			<?//php include 'templates/main-footer.php' ?>
			<!-- End Main Footer -->
			
		</div>
		
	</div>
	<?//php include 'templates/footer.php' ?>
  
</body>
</html>