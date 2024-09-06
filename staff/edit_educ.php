

<?php
include 'server/server.php';


session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
$skTypes = array('SK-Arawan','SK-Bagong Niing', 'SK-Balat Atis','SK-Briones','SK-Bulihan','SK-Buliran','SK-Callejon',
'SK-Corazon', 'SK-Del Valle','SK-loob','SK-Magsaysay','SK-Matipunso','SK-Niing','SK-Poblacion','SK-Pulo',
 'SK-Pury','SK-Sampaga','SK-Sampaguita', 'SK-San Jose', 'SK-Sinturisan'); 
if (!isset($_SESSION['staffid']) || strlen($_SESSION['staffid']) == 0 ||in_array($_SESSION['role'], $skTypes)) {
	header('location:index.php');
    exit();
}
$role= $_SESSION['role'];
$email= $_SESSION['email'];
if (isset($_GET['educid'])) {
	$educid = $_GET['educid'];

	$query = "SELECT * FROM `educ aids` WHERE educid = $educid";
	$view = mysqli_query($conn, $query);

	if ($row = mysqli_fetch_assoc($view)) {
		$title = $row['educname'];
		$sem = $row['sem'];
		$sy = $row['sy'];
		$start = $row['start'];
		$end = $row['end'];
		$status = $row['status'];
		$date = $row['date'];
		$min_grade = $row['min_grade'];
	} else {
		$_SESSION['message'] = 'No Record found!';
		$_SESSION['success'] = 'error';
        $_SESSION['title'] = 'Try again';
		header("Location: ../educass.php");
		exit();
	}
}

if (isset($_POST['update'])) {
	$title = $_POST['title'];
	$sem = $_POST['sem'];
	$sy = $_POST['sy'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$status = $_POST['status'];
	$date = $_POST['date'];
	$min_grade = $_POST['min_grade'];

	$query = "UPDATE `educ aids` SET `educname`='$title', `sem`='$sem', `sy`='$sy', `start`='$start', `end`='$end', `min_grade`='$min_grade', `date`='$date', `status`='$status' WHERE educid=$educid";
	$result = $conn->query($query);

	if ($result === true) {
        $_SESSION['alertmess'] = 'Successfully Updated a record!';
        $_SESSION['title'] = 'Good Job';
        $_SESSION['success'] = 'success';

    }else{
        $_SESSION['alertmess'] = 'Something went wrong, Try again!';
        $_SESSION['title'] = 'Error';
        $_SESSION['success'] = 'danger';
    }
    header("Location: educass.php");
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
				<!--	<?//php if(isset($_SESSION['message'])): ?>
							<div class="alert alert-<?//php echo $_SESSION['success']; ?> <?//= $_SESSION['success']=='danger' ? 'bg-danger text-light' : null ?>" role="alert">
								<?//php echo $_SESSION['message']; ?>
							</div> -->
                            <!-- MESSAGE WHEN DATA IS INSERTED __-->
                            
                            <?php 
                            /*if (isset($_SESSION['message']) && $_SESSION['message'] != ''){ ?>                                                         ?>
                      <!--  <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Hello!</strong><?//php echo $_SESSION['message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div> -->
                            
						<?php unset($_SESSION['message']);  //}*/ ?> 
                       

						<?//php endif ?>
						<div class="row mt--2 justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-success" style="border-radius: 8px;">
                                <div class="card-head-row">
                                    <div class="card-title text-center"  style=" color: #ffffff;">Update Educational Assistance Information</div>
                                </div>
                            </div>
                            <form method="POST" action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" id="title" placeholder="Enter title" name="title" value="<?php echo $title; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Semester</label>
                                            <input type="text" class="form-control" id="sem" placeholder="Enter semester" name="sem" value="<?php echo $sem; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>School Year</label>
                                            <input type="text" class="form-control" id="sy" placeholder="Enter school year" name="sy" value="<?php echo $sy; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Minimum Grade Required</label>
                                            <input type="text" class="form-control" id="min_grade" placeholder="Enter minimum grade required" name="min_grade" value="<?php echo $min_grade; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="date" class="form-control" id="start" name="start" value="<?php echo $start; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" class="form-control" id="end" name="end" value="<?php echo $end; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date Applied</label>
                                            <input type="date" class="form-control" id="date" name="date" value="<?php echo $date; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="Open" <?php echo $status == 'Open' ? 'selected' : ''; ?>>Open</option>
                                                <option value="Closed" <?php echo $status == 'Closed' ? 'selected' : ''; ?>>Closed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                                    <a href="educass.php" class="btn btn-secondary">Back</a>
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