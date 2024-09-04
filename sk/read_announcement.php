

<?php
include 'server/server.php';


session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
$skTypes = array(
    'SK-Arawan',
    'SK-Bagong Niing',
    'SK-Balat Atis',
    'SK-Briones',
    'SK-Bulihan',
    'SK-Buliran',
    'SK-Callejon',
    'SK-Corazon',
    'SK-Del Valle',
    'SK-Loob',
    'SK-Magsaysay',
    'SK-Matipunso',
    'SK-Niing',
    'SK-Poblacion',
    'SK-Pulo',
    'SK-Pury',
    'SK-Sampaga',
    'SK-Sampaguita',
    'SK-San Jose',
    'SK-Sinturisan'
);
if (!isset($_SESSION['skid']) || strlen($_SESSION['skid']) == 0 || !in_array($_SESSION['role'], $skTypes)||!isset($_SESSION['skpos'])) {
    header('location:index.php');
    exit();
}
else{
$role= $_SESSION['role'];

if (isset($_GET['announceid'])) {
    $announceid = $_GET['announceid'];

    $query = "SELECT * FROM `announcement` WHERE announceid = $announceid";
    $view = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($view)) {
        $title = $row['title'];
        $details = $row['details'];
        $date = $row['date'];
    } else {
        $_SESSION['message'] = 'No Record found!';
        $_SESSION['success'] = 'danger';
        header("Location: ../announcement.php");
        exit();
    }
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
<div class="row d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-6">
            <div class="card mb-3 mt-3" style="width: 80%; margin: 0 auto;">
                <img src="assets/img/saq.jpg" class="card-img-top" alt="...">
				<div class="card-header " style="border-radius: 8px;">
                                <div class="card-head-row">
                                    <div class="card-title text-center"> Announcement</div>
                                    <div class="card-tools">
                                                                <a href="announcement.php" class="btn btn-danger btn-border btn-round btn-sm" title="view and print">
                                                                    <i class="fa fa-chevron-left"></i>
                                                                   Back
                                                                </a>
                                                                

                                                            </div>
                                </div>
                            </div>
                <div class="card-body">
                <div>

<p class="text-muted"> <?php echo $date; ?></p>
</div>
<form>

<div class="form-group">


    <h3 class="text-center"><?php echo $title; ?></h3>
    <p>Details: </p>
    <?php echo nl2br(htmlspecialchars($details)); ?>

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