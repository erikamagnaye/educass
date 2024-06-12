
<?php include 'server/server.php' ?>
<?php 
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0)) {
	header('location:login.php');
    exit();
}

	else {
		$id = $_SESSION['id'] ;
		$query 		= "SELECT * FROM `student`  WHERE studid= '$id'";
		$result 	= $conn->query($query);
		
		if($result->num_rows){
			while ($row = $result->fetch_assoc()) {
				$studid = $row['studid'];
				$name = $row['firstname'];
				//$role = $row['position'];
			}
			}

		//all applicants for recent assistance	
	$query = "SELECT * FROM application join `educ aids` on `application`.`educid`=`educ aids`.`educid` order by `educ aids`.educid desc limit 1";
    $result = $conn->query($query);
	$totalapp = $result->num_rows;
        //pending applicants    
	$query = "SELECT * FROM application join `educ aids` on `application`.`educid`=`educ aids`.`educid` WHERE application.status ='Pending' order by `educ aids`.educid desc ";
    $result2 = $conn->query($query);
	$pending = $result2->num_rows;
        //approved applicants    
	$query = "SELECT * FROM application join `educ aids` on `application`.`educid`=`educ aids`.`educid` WHERE application.status ='Approved' order by `educ aids`.educid desc  ";
    $result3 = $conn->query($query);
	$approved = $result3->num_rows;
            //rejected applicants
	$query = "SELECT * FROM application join `educ aids` on `application`.`educid`=`educ aids`.`educid` WHERE application.status ='Rejected' order by `educ aids`.educid desc ";
    $result4 = $conn->query($query);
	$rejected = $result4->num_rows;
    	//all educ assistance	provided
	$query6 = "SELECT * FROM `educ aids`";
    $result6 = $conn->query($query6);
	$totaleduc = $result6->num_rows;


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
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Admin Dashboard</title>
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon"/>   <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->
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
	
	</style>
</head>
<body>
	<?php include 'templates/loading_screen.php' ?>

	<div class="wrapper">
		<!-- Main Header -->
		<?php include 'templates/main-header.php' ?>
		<!-- End Main Header -->

		<!-- Sidebar -->
		<?php include 'templates/sidebar.php' ?>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-transparent">
					<div class="page-inner">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-black fw-bold"> Dashboard</h2>
								<?php if(isset($_SESSION['message'])): ?>
							<div class="alert alert-<?= $_SESSION['success']; ?> <?= $_SESSION['success']=='danger' ? 'bg-danger text-light' : null ?>" role="alert">
								<?php echo $_SESSION['message']; ?>
							</div>
						<?php unset($_SESSION['message']); ?>
						<?php endif ?>
								<div > <hr>
								<h4 class="text-black fw-regular ">Cute ko</h4>
								<div class="btn-container">
    <a href="#" class="btn"><i class="fas fa-user icon" style="margin-right: 8px;"> </i><?= $totalapp ?>  Verified  Account </a>
    <a href="#" class="btn"><i class="fas fa-users icon" style="margin-right: 8px;"></i><?= $totalapp ?>  Not Verified  Account </a>
	<a href="#" class="btn"><i class="fas fa-users icon" style="margin-right: 8px;"></i><?= $totalapp ?>  Complaints/ Concerns </a>
	<a href="#" class="btn"><i class="fas fa-users icon" style="margin-right: 8px;"></i><?= $totalapp ?>  staff </a>
	<a href="#" class="btn"><i class="fas fa-users icon" style="margin-right: 8px;"></i><?= $totaleduc ?>  Educational Assistance Provided </a>
</div>


								<div > <hr>
								<h4 class="text-black fw-regular ">Educational Assistance for SY: <?= $sy ?> for <?= $sem ?>  Report</h4>
							</div>
							</div>
						</div>
					</div>
				
				</div>
				<div class="page-inner mt--2">
				
					<div class="row">
					<div class="col-md-3">
                <div class="card card-stats card-primary card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 ">
                                <div class="icon-big text-center">
                                    <i class="flaticon-users"></i>
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
                                    <i class="flaticon-users"></i>
                                </div>
                            </div>
                            <div class="col-12 ">
                                <div class="numbers mt-2">
                                    <h6 class="fw-bold text-uppercase text-center"><?= $pending ?> Pending</h6>
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
                                    <i class="flaticon-users"></i>
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
                                    <i class="flaticon-users"></i>
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
	
				
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title fw-bold">waiting</div>
									</div>
								</div>
								<div class="card-body">
								<div class="container-fluid mt-5">
   

</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
			<!-- Main Footer -->
			<?php include 'templates/main-footer.php' ?>
			<!-- End Main Footer -->
			
		</div>
		
	</div>
	<?php include 'templates/footer.php' ?>
</body>
</html><?php }?>