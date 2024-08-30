
<?php include 'server/server.php' ?>
<?php 
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

	else {
		$staffid = $_SESSION['staffid'] ;
		$query 		= "SELECT * FROM `staff` WHERE staffid= '$staffid'";
		$result 	= $conn->query($query);
		
		if($result->num_rows){
			while ($row = $result->fetch_assoc()) {
				$staffid = $row['staffid'];
				$firstname = $row['firstname'];
				$role = $row['position'];
                $email = $row['email'];
			}
			}
 


            //get the recent educational
            $query = "SELECT educid FROM `educ aids` ORDER BY date DESC LIMIT 1";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            $recent = $row['educid'];

		//all applicants for recent assistance	


    $app = "SELECT COUNT(*) FROM application  where educid = '$recent'";
    $resultapp= $conn->query($app);
    $row = $resultapp->fetch_assoc();
$totalapp = $row['COUNT(*)'];
        //pending applicants    
    	$query2 = "SELECT COUNT(*) FROM application  where educid = '$recent'  and appstatus ='Pending' ";
    $result2 = $conn->query($query2);
    $row = $result2->fetch_assoc();
	$pendingapp = $row['COUNT(*)'];
        //approved applicants    
	$query3 = "SELECT  COUNT(*) FROM application  where educid = '$recent'  and appstatus ='Approved'";
    $result3 = $conn->query($query3);
    $row = $result3->fetch_assoc();
	$approved = $row['COUNT(*)'];
            //rejected applicants
	$query4 = "SELECT COUNT(*) FROM application  where educid = '$recent'  and appstatus ='Rejected'";
    $result4 = $conn->query($query4);
    $row = $result4->fetch_assoc();
	$rejected = $row['COUNT(*)'];
    	//all educ assistance	provided
	$query6 = "SELECT * FROM `educ aids`";
    $result6 = $conn->query($query6);
	$totaleduc = $result6->num_rows;

//all staff
    $staff = "SELECT COUNT(*) FROM staff";
    $resultstaff= $conn->query($staff);
    $row = $resultstaff->fetch_assoc();
$staffcount = $row['COUNT(*)'];
//verified account
$verified = "SELECT COUNT(*) FROM student WHERE accstatus ='Verified'";
$resultvacc= $conn->query($verified);
$row = $resultvacc->fetch_assoc();
$vacc = $row['COUNT(*)'];
//not verified account
$notverified = "SELECT COUNT(*) FROM student WHERE accstatus = '' OR accstatus IS NULL";
$resultnotvacc= $conn->query($notverified);
$row = $resultnotvacc->fetch_assoc();
$notvacc = $row['COUNT(*)'];
//all complaints
$allcomplaints = "SELECT COUNT(*) as total FROM concerns";
$resultcomp = $conn->query($allcomplaints);
$row = $resultcomp->fetch_assoc();
$complaints = $row["total"];

	// Initialize variables with default values
$sy = 'N/A';
$sem = 'N/A';

	$query1 		= "SELECT * FROM `educ aids` ORDER BY educid DESC LIMIT 1;";
	$result5 	= $conn->query($query1);
	
	if($result5->num_rows){
		while ($row = $result5->fetch_assoc()) {
			$sem = $row['sem'];
			$sy = $row['sy'];
			
		}
		}

		// Retrieve data from database  THIS IS FOR PIE CHART FOR APPLICANTS PER BRGY

// Fetch the most recent educational assistance ID based on the date
$query1 = "SELECT educid, sem, sy FROM `educ aids` ORDER BY `date` DESC LIMIT 1";
$result1 = mysqli_query($conn, $query1);
$latest_educid = null;
$sem = '';
$sy = '';

if ($result1 && mysqli_num_rows($result1) > 0) {
    $row = mysqli_fetch_assoc($result1);
    $latest_educid = $row['educid'];
    $sem = $row['sem'];
    $sy = $row['sy'];
}

if ($latest_educid) {
    // Retrieve data from the database for the most recent educational assistance
    $sql = "SELECT student.brgy, COUNT(*) AS count 
            FROM student 
            JOIN application ON student.studid = application.studid
            JOIN `educ aids` ON application.educid = `educ aids`.educid 
            WHERE `educ aids`.educid = '$latest_educid' 
            GROUP BY student.brgy 
            ORDER BY brgy ASC";
    
    $result = mysqli_query($conn, $sql);

    $dataArray = array();
    $dataArray[] = ['Barangay', 'Number of Applicants'];

    // Format data for Google Charts
    while ($row = mysqli_fetch_assoc($result)) {
        $dataArray[] = [$row['brgy'], (int)$row['count']];
    }
} 
// END OF CODE FOR PIE CHART

//START OF CODE FOR LINE CHART TO DISPLAY ALL APPLICANTS PER EDUCATIONAL ASSISTANCE


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Employee Dashboard</title>
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon"/>   <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
        
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
        // Load the Visualization API and the corechart package
        google.charts.load('current', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Create the data table
            var data = google.visualization.arrayToDataTable(<?= json_encode($dataArray) ?>);

            // Set chart options
            var options = {
                title: 'Number of Applicants per Barangay',
                is3D: true
            };

            // Instantiate and draw the chart, passing in some options
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>
	<style>
	
.dashboard {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
    align-items: center;
}

.card {
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    padding: 5px;
    text-align: center;
	display: flex;
    flex-direction: column;

}

.card-icon {
    font-size: 20px;
    color: #4CAF50;
}

h5 {
    margin: 5px 0 5px;
	word-wrap: break-word;
    overflow-wrap: break-word;
	word-break: break-all;
}
.card-title {
    font-size: 18px; 
}
/* Small screens (max-width: 768px) */
@media (max-width: 768px) {
    .dashboard {
        grid-template-columns: repeat(2, 1fr);
    }
    .card {
        padding: 5px;
		display: flex;
    flex-direction: column;

    text-align: center;
    }
    .card-icon {
        font-size: 14px;
    }
    h5 {
        font-size: 14px;
		overflow-wrap: break-word; /* Add this line to break long text */
		word-wrap: break-word;
		word-break: break-all;
    }
    .card-title{
        font-size: 12px;
    }
}

/* Extra small screens (max-width: 480px) */
@media (max-width: 480px) {
    .dashboard {
        grid-template-columns: repeat(2, 1fr);
    }
    .card {
        padding: 2px;
		display: flex;
    flex-direction: column;

    text-align: center;
    }
    .card-icon {
        font-size: 12px;
    }
    h5 {
        font-size: 12px;
		overflow-wrap: break-word; /* Add this line to break long text */
		word-wrap: break-word;
		word-break: break-all;
    }
    .card-title {
        font-size: 10px;
    }
}

/* Extra extra small screens (max-width: 320px) */
@media (max-width: 320px) {
    .dashboard {
        grid-template-columns: repeat(2, 1fr);
    }
    .card {
        padding: 1px;
		display: flex;
    flex-direction: column;

    text-align: center;
    }
    .card-icon {
        font-size: 10px;
    }
    h5 {
        font-size: 10px;
		overflow-wrap: break-word; /* Add this line to break long text */
		word-wrap: break-word;
		word-break: break-all;
    }
    .card-title {
        font-size: 10px;
    }
}
	</style>
</head>
<body>
	<?//php include 'templates/loading_screen.php' ?>

	<div class="wrapper">
		<!-- Main Header -->
		<?php include 'templates/main-header.php' ?>
		<!-- End Main Header -->

		<!-- Sidebar -->
		<?php include 'templates/sidebar.php' ?>
		<!-- End Sidebar -->

		<div class="main-panel">
        <div class="content">
        <div class="page-inner">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-black fw-bold">Staff Dashboard</h2>
				
							
						</div>
						
					</div>
				
				</div>

				<div class="page-inner mt--2" >
             <!--   <div class="container-fluid mt-5">
                <div class="dashboard" >
        <div class="card">
            <div class="card-icon"><i class="fas fa-user"></i></div>
          <a href="applications.php" class="btn">  <h5><?= $vacc ?> <br>Verified Account</h5></a>
          
        </div>
        <div class="card">
            <div class="card-icon"><i class="fas fa-chart-line"></i></div>
			<a href="applications.php" class="btn"><h5><?= $notvacc ?> <br>Not Verified Account</h5></a>
         
        </div>
        <div class="card">
            <div class="card-icon"><i class="fas fa-cogs"></i></div>
			<a href="applications.php" class="btn"><h5><?= $complaints ?> <br>Complaints</h5></a>
     
        </div>
        <div class="card">
            <div class="card-icon"><i class="fas fa-comments"></i></div>
			<a href="staff.php" class="btn"> <h5><?=$staffcount?><br> staff</h5></a>
           
        </div> <div class="card">
            <div class="card-icon"><i class="fas fa-comments"></i></div>
			<a href="educaids.php" class="btn"> <h5><?=$totaleduc?><br> Educational Assistance</h5></a>      
        </div>
	
    </div>
    </div>-->
              <div class="row">
						<div class="col-md-12">
                        <div class="card" style="padding:0px; margin:0px;background-color:#F5F7F8;">
                       <!-- <div class="card-header card-header-border bg-success" style="border-radius: 8px;">
									<div class="card-head-row">
										<div class="card-title fw" style=" color: #ffffff;">EUCATIONAL ASSISTANCE APPLICATION SYSTEM</div>
									</div>
								</div>-->
								<div class="card-body col-md-12">
								<div class="container-fluid">

	

<div class="dashboard" >
        <div class="card" style="">
            <div class="card-icon" style="color: skyblue;"><i class="fa-solid fa-user-shield"></i></div>
          <a href="applications.php" class="btn">  <h5><?= $vacc ?> <br>Verified Account</h5></a>
          
        </div>
        <div class="card">
            <div class="card-icon" style="color: orange;"><i class="fa-solid fa-user-xmark"></i></div>
			<a href="applications.php" class="btn"><h5><?= $notvacc ?> <br>Not Verified Account</h5></a>
         
        </div>
        <div class="card">
            <div class="card-icon" style="color: red;"><i class="fa-solid fa-clipboard-question"></i></div>
			<a href="applications.php" class="btn"><h5><?= $complaints ?> <br>Complaints</h5></a>
     
        </div>
        <div class="card">
            <div class="card-icon" style="color: green;"><i class="fa-solid fa-user-tie"></i></div>
			<a href="staff.php" class="btn"> <h5><?=$staffcount?><br> staff</h5></a>
           
        </div> <div class="card">
            <div class="card-icon" style="color: yellow;"><i class="fa-solid fa-book-open-reader"></i></div>
			<a href="educaids.php" class="btn"> <h5><?=$totaleduc?><br> Educational Assistance</h5></a>      
        </div>
  <!--      <div class="card">
            <div class="card-icon"style="color: blue;"><i class="fa-solid fa-user-graduate"></i></div>
			<a href="educaids.php" class="btn"> <h5><?=$totaleduc?><br> Beneficiaries</h5></a>      
        </div> -->
        </div> 
       
	
    </div>


</div>
								</div>
                                </div>
						</div>
                        <br>

                        <div class="row">
						<div class="col-md-12">
                        <div class="card" style="padding:0px; margin:0px;background-color:#F5F7F8;">
                       <!-- <div class="card-header card-header-border bg-success" style="border-radius: 8px;">
									<div class="card-head-row">
										<div class="card-title fw" style=" color: #ffffff;">EUCATIONAL ASSISTANCE APPLICATION SYSTEM</div>
									</div>
								</div>-->

                                

								</div>
                                </div>
						</div>
<br>
                        <div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header bg-success" style="border-radius: 8px;">
									<div class="card-head-row">
										<div class="card-title fw-regular " style="color:#ffffff">Educational Assistance for SY: <?= $sy ?> for <?= $sem ?>  Report</div>
									</div>
								</div>
								<div class="card-body">
								<div class="container-fluid mt-5">
                                <div class="row">
					<div class="col-md-3">
                <div class="card card-stats card-primary card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 ">
                                <div class="icon-big text-center">
                                    <i class="fa-solid fa-user-graduate"></i>
                                </div>
                            </div>
                            <div class="col-12 ">
                                <div class="numbers mt-2">
                                    <h6 class="fw-bold text-uppercase text-center"><?= $totalapp ?> Applicants</h6>
									<a href="resident_info.php?state=all" class="card-link text-light" style="text-align: left;">view</a>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
			<div class="col-md-3">
                <div class="card card-stats card-warning card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 ">
                                <div class="icon-big text-center">
                                <i class="fa-solid fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            <div class="col-12 ">
                                <div class="numbers mt-2">
                                    <h6 class="fw-bold text-uppercase text-center"><?=$pendingapp ?> Pending</h6>
									<a href="resident_info.php?state=all" class="card-link text-light" style="text-align: left;">view</a>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
						
			<div class="col-md-3">
                <div class="card card-stats card-secondary card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 ">
                                <div class="icon-big text-center">
                                <i class="fa-regular fa-thumbs-up"></i>
                                </div>
                            </div>
                            <div class="col-12 ">
                                <div class="numbers mt-2">
                                    <h6 class="fw-bold text-uppercase text-center"><?= $approved ?> Approved</h6>
									<a href="resident_info.php?state=all" class="card-link text-light" style="text-align: left;">view</a>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
			<div class="col-md-3">
                <div class="card card-stats card-danger card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 ">
                                <div class="icon-big text-center">
                                <i class="fa-regular fa-thumbs-down"></i>
                                </div>
                            </div>
                            <div class="col-12 ">
                                <div class="numbers mt-2">
                                    <h6 class="fw-bold text-uppercase text-center"><?= $rejected ?> Rejected</h6>
									<a href="resident_info.php?state=all" class="card-link text-light" style="text-align: left;">view</a>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
					</div>

</div>
								</div>
							</div>
						</div>
					</div>

                    <div class="row">
        <div class="col-md-6 offset-md-4">
            <div class="card">
                <div class="card-header">
                    Applicants Per Barangay
                </div>
                <div class="card-body">
                    <div id="piechart_3d" style="width: 100%; height: 450px;"></div>
                </div>
            </div>
        </div>
    </div>
					</div>
    

              

	
   	<!-- Main Footer -->
       <?php include 'templates/main-footer.php' ?>
			<!-- End Main Footer -->

				</div>
			</div>
           
            <?php include 'templates/footer.php' ?>

	
		</div>
		
	</div>
    	                    <!-- alert for UPDATEEEEEEEEE -->
                            <?php if (isset($_SESSION['message'])) : ?> 
                                <script>
                                    Swal.fire({
                                        title: '<?php echo $_SESSION['title']; ?>',
                                        text: '<?php echo $_SESSION['message']; ?>',
                                        icon: '<?php echo $_SESSION['success']; ?>',
                                        confirmButtonText: 'OK'
                                    });
                                </script>
                                <?php unset($_SESSION['message']);
                                unset($_SESSION['success']); ?>
                            <?php endif; ?>
			

    <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($dataArray); ?>);

        var options = {
            title: 'Applicants Per Barangay',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }
</script>

<!-- CODE FOR LINE CHART -->

</body>
</html><?php }?>