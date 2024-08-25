

<?php
include 'server/server.php';


session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'admin') {
	header('location:login.php');
    exit();
}
else{
$role= $_SESSION['role'];
$username= $_SESSION['username'];
if (isset($_GET['announceid'])) {
	$announceid = $_GET['announceid'];

	$query = "SELECT * FROM `announcement` WHERE announceid = $announceid";
	$view = mysqli_query($conn, $query);

	if ($row = mysqli_fetch_assoc($view)) {
		$title = $row['title'];
		$details = $row['details'];
		
	} else {
		$_SESSION['message'] = 'No Record found!';
		$_SESSION['success'] = 'danger';
		header("Location: ../announcement.php");
		exit();
	}
}

if (isset($_POST['update'])) {
	$title = $_POST['title'];
		$details = $_POST['details'];
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:sa");

   

	$query = "UPDATE `announcement` SET `title`='$title', `details`='$details', `date`='$date' WHERE announceid=$announceid";
	$result = $conn->query($query);

    if($result){
        $_SESSION['alertmess'] = 'Successfully Updated an announcement!';
        $_SESSION['title'] = 'Good Job';
        $_SESSION['success'] = 'success';

    }else{
        $_SESSION['alertmess'] = 'Something went wrong, Try again!';
        $_SESSION['title'] = 'Error';
        $_SESSION['success'] = 'error';
    }
    header("Location: announcement.php");
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
                    <div class="col-md-5">
                        <div class="card" style="padding: 5px;margin:10px;">
                            <div class="card-header bg-success" style="border-radius: 8px;">
                                <div class="card-head-row">
                                    <div class="card-title text-center" style=" color: #ffffff;">Update announcement</div>
                                </div>
                            </div>
                            <form method="POST" action="">
                            
                            <div class="form-group">
                                        <label>Announcement Title</label>
                                        <input type="text" class="form-control" value="<?php echo $title; ?>" name="title" required>
                                    </div>
                                    <div class="form-group">
    <label for="validationTextarea">Details</label>
    <textarea class="form-control" rows="5"  name="details" required>
        <?php echo htmlspecialchars($details); ?>
    </textarea>
</div>
                       
                               
       
                                    





                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                                    <a href="announcement.php" class="btn btn-secondary">Back</a>
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
</html><?php }?>