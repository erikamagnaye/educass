<?php
include '../server/server.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0)) {
	header('location:login.php');
    exit();
}
	if (isset($_SERVER["HTTP_REFERER"])) {
		header("Location: " . $_SERVER["HTTP_REFERER"]);
		exit();
	}


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
		$_SESSION['success'] = 'danger';
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
		$_SESSION['message'] = 'Data has been updated!';
		$_SESSION['success'] = 'success';
	} else {
		$_SESSION['message'] = 'Something went wrong!';
		$_SESSION['success'] = 'danger';
	}

	header("Location: ../educass.php");
	exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../templates/header.php'; ?>
	<title>Edit Educational Assistance</title>
</head>
<body>
	<?php include '../templates/loading_screen.php'; ?>
	<div class="wrapper">
		<?php include '../templates/main-header.php'; ?>
		<?php include '../templates/sidebar.php'; ?>
		
		<div class="main-panel">
			<div class="content">
				<div class="panel-header">
					<div class="page-inner">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-black fw-bold">Edit Educational Assistance</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner">
					<div class="row mt--2">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title">Edit Educational Assistance</div>
									</div>
								</div>
								<div class="card-body">
									<form method="POST" action="">
										<div class="form-group">
											<label>Title</label>
											<input type="text" class="form-control" id="title" placeholder="Enter title" name="title" value="<?php echo $title; ?>" required>
										</div>
										<div class="form-group">
											<label>Semester</label>
											<input type="text" class="form-control" id="sem" placeholder="Enter semester" name="sem" value="<?php echo $sem; ?>" required>
										</div>
										<div class="form-group">
											<label>School Year</label>
											<input type="text" class="form-control" id="sy" placeholder="Enter school year" name="sy" value="<?php echo $sy; ?>" required>
										</div>
										<div class="form-group">
											<label>Minimum Grade Required</label>
											<input type="text" class="form-control" id="min_grade" placeholder="Enter minimum grade required" name="min_grade" value="<?php echo $min_grade; ?>" required>
										</div>
										<div class="form-group">
											<label>Start Date</label>
											<input type="date" class="form-control" id="start" name="start" value="<?php echo $start; ?>" required>
										</div>
										<div class="form-group">
											<label>End Date</label>
											<input type="date" class="form-control" id="end" name="end" value="<?php echo $end; ?>" required>
										</div>
										<div class="form-group">
											<label>Date Applied</label>
											<input type="date" class="form-control" id="date" name="date" value="<?php echo $date; ?>" required>
										</div>
										<div class="form-group">
											<label>Status</label>
											<select class="form-control" id="status" name="status" required>
												<option value="active" <?php echo $status == 'active' ? 'selected' : ''; ?>>Active</option>
												<option value="inactive" <?php echo $status == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
											</select>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary" name="update">Update</button>
											<a href="../educass.php" class="btn btn-secondary">Back</a>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include '../templates/main-footer.php'; ?>
		</div>
	</div>
	<?php include '../templates/footer.php'; ?>
	<script src="../assets/js/customFunction.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
