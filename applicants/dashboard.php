
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

		//all applications of student	
	$query = "SELECT * FROM application WHERE studid = '$id'";
    $result = $conn->query($query);
	$totalapp = $result->num_rows;
        //pending applications    
	$query = "SELECT * FROM `application`  WHERE studid = '$id' AND `status` ='Pending' order by date desc ";
    $result2 = $conn->query($query);
	$pending = $result2->num_rows;
        //approved applications   
	$query = "SELECT * FROM `application`  WHERE studid = '$id' AND `status` ='Approved' order by date desc ";
    $result3 = $conn->query($query);
	$approved = $result3->num_rows;
            //rejected applications
	$query = "SELECT * FROM `application`  WHERE studid = '$id' AND `status` ='Rejected' order by date desc";
    $result4 = $conn->query($query);
	$rejected = $result4->num_rows;
    	//all educ assistance	provided
	$query6 = "SELECT * FROM `educ aids`";
    $result6 = $conn->query($query6);
	$totaleduc = $result6->num_rows;
		//all complaints of student	
		$query7 = "SELECT * FROM concerns WHERE studid = '$id'";
		$result7 = $conn->query($query7);
		$totalconcerns = $result7->num_rows;

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>EAASSAQ</title>
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon"/>   <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<style>


/* styles for medium screens */
@media (max-width: 768px) {
  .btn-container button {
    width: 150px;
    height: 40px;
    font-size: 13px;
  }
}

/* styles for small screens */
@media (max-width: 480px) {
  .btn-container button {
    width: 100px;
    height: 30px;
    font-size: 11px;
  }
}
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
							
                        <div > <hr style="width: 100%;">
								<h4 class="text-black fw-regular ">Cute ko</h4>
								<div class="btn-container">
    <a href="#" class="btn"><i class="fas fa-user icon" style="margin-right: 8px;"> </i><?= $totalapp ?>  Applications </a>
    <a href="#" class="btn"><i class="fas fa-users icon" style="margin-right: 8px;"></i><?= $pending ?>  Pending </a>
	<a href="#" class="btn"><i class="fas fa-users icon" style="margin-right: 8px;"></i><?= $approved ?>  Approved </a>
	<a href="#" class="btn"><i class="fas fa-users icon" style="margin-right: 8px;"></i><?= $rejected ?>  Rejected </a>
	<a href="#" class="btn"><i class="fas fa-users icon" style="margin-right: 8px;"></i><?= $totaleduc ?>  Educational Assistance Provided </a>
	<a href="#" class="btn"><i class="fas fa-users icon" style="margin-right: 8px;"></i><?= $totalconcerns ?>  Complaints </a>

</div>


								<div > <hr>
								<h4 class="text-black fw-regular ">Educational Assistance </h4>
							</div>
							</div>
						</div>
					</div>
				
				</div>
                            <div class="page-inner mt--2">
					<div class="row">
					<div class="col-md-6">
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
                                    <h6 class="fw-bold text-uppercase text-center"><?= $totalapp ?> Open Educational Assistance</h6>
									<a href="resident_info.php?state=all" class="card-link text-light" style="text-align: left;">view</a>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="col-md-6">
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
                                    <h6 class="fw-bold text-uppercase text-center"><?= $totalapp ?> Close Educational Assistance</h6>
									<a href="resident_info.php?state=all" class="card-link text-light" style="text-align: left;">view</a>
                                </div>
                            </div>
                        </div>
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