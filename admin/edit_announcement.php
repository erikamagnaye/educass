

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

if (isset($_GET['announceid'])) {
    $announceid = $_GET['announceid'];

    $stmt = $conn->prepare("SELECT * FROM `announcement` WHERE announceid = ?");
    $stmt->bind_param("i", $announceid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $title = $row['title'];
        $details = $row['details'];
    } else {
        $_SESSION['message'] = 'No Record found!';
        $_SESSION['success'] = 'danger';
        header("Location: announcement.php");
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
    <style>
       body{
    background: url('assets/img/saqbound.jpg') no-repeat center center fixed; 
    background-size: cover;
  
}

</style>
</head>
<body>
<div class="row d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-6">
            <div class="card mb-3 mt-3" style="width: 80%; margin: 0 auto;">
                <img src="assets/img/announcement.jpg" class="card-img-top" alt="...">
				<div class="card-header " style="border-radius: 8px;">
                                <div class="card-head-row">
                                    <div class="card-title text-center" >Update announcement</div>
                                </div>
                            </div>
                <div class="card-body">
				
                
                       
                          
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
                <div class="card-footer text-center">
                    <p>&copy Web Based Educational Assistance Application System 2024</p>
                </div>
            </div>
        </div>

    </div>
	<?//php include 'templates/loading_screen.php' ?>


		
	</div>
	<?//php include 'templates/footer.php' ?>
  
</body>
</html><?php }?>