
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
	$query = "SELECT * FROM `application`  WHERE studid = '$id' AND `appstatus` ='Pending' order by appdate desc ";
    $result2 = $conn->query($query);
	$pending = $result2->num_rows;
        //approved applications   
	$query = "SELECT * FROM `application`  WHERE studid = '$id' AND `appstatus` ='Approved' order by appdate desc ";
    $result3 = $conn->query($query);
	$approved = $result3->num_rows;
            //rejected applications
	$query = "SELECT * FROM `application`  WHERE studid = '$id' AND `appstatus` ='Rejected' order by appdate desc";
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

/* style for cards in dash */
* {
    box-sizing: border-box;
}


.dashboard {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.card {
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    padding: 5px;
    text-align: center;
	display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.card-icon {
    font-size: 30px;
    color: #4CAF50;
}

h5 {
    margin: 10px 0 10px;
	word-wrap: break-word;
    overflow-wrap: break-word;
	word-break: break-all;
}
/* Small screens (max-width: 768px) */
@media (max-width: 768px) {
    .dashboard {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
    .card {
        padding: 5px;
		display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    }
    .card-icon {
        font-size: 16px;
    }
    h5 {
        font-size: 16px;
		overflow-wrap: break-word; /* Add this line to break long text */
		word-wrap: break-word;
		word-break: break-all;
    }
}

/* Extra small screens (max-width: 480px) */
@media (max-width: 480px) {
    .dashboard {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    }
    .card {
        padding: 2px;
		display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    }
    .card-icon {
        font-size: 15px;
    }
    h5 {
        font-size: 14px;
		overflow-wrap: break-word; /* Add this line to break long text */
		word-wrap: break-word;
		word-break: break-all;
    }
}

/* Extra extra small screens (max-width: 320px) */
@media (max-width: 320px) {
    .dashboard {
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    }
    .card {
        padding: 1px;
		display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
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
								<h2 class="text-black fw-bold"> Applicant Portal</h2>
								<!--
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
	<a href="#" class="btn"><i class="fas fa-users icon" style="margin-right: 8px;"></i><?= $totaleduc ?>  Educational Assistance </a>
	<a href="#" class="btn"><i class="fas fa-users icon" style="margin-right: 8px;"></i><?= $totalconcerns ?>  Complaints </a>

</div>


								<div > <hr>
								<h4 class="text-black fw-regular ">Educational Assistance </h4>
							</div>
							</div> -->
							
						</div>
						
					</div>
				
				</div>
                            <div class="page-inner mt--2">
			<!--		<div class="row">
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
						
		
		
					</div> -->

	
				
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body col-md-12">
								<div class="container-fluid">

	

<div class="dashboard">
        <div class="card">
            <div class="card-icon"><i class="fas fa-user"></i></div>
          <a href="all_applications.php" class="btn">  <h5><?= $totalapp ?> <br>Applications</h5></a>
          
        </div>
        <div class="card">
            <div class="card-icon"><i class="fas fa-chart-line"></i></div>
			<a href="applications.php" class="btn"><h5><?= $pending ?> <br>Pending</h5></a>
         
        </div>
        <div class="card">
            <div class="card-icon"><i class="fas fa-cogs"></i></div>
			<a href="applications.php" class="btn"><h5><?= $approved ?> <br>Approved</h5></a>
     
        </div>
        <div class="card">
            <div class="card-icon"><i class="fas fa-comments"></i></div>
			<a href="applications.php" class="btn"> <h5><?=$rejected?><br> Rejected</h5></a>
           
        </div> <div class="card">
            <div class="card-icon"><i class="fas fa-comments"></i></div>
			<a href="educaids.php" class="btn"> <h5><?=$totaleduc?><br> Educational Assistance</h5></a>      
        </div>
		<div class="card">
            <div class="card-icon"><i class="fas fa-comments"></i></div>
			<a href="applications.php" class="btn"> <h5><?=$totalconcerns?> <br>Complaints</h5></a>         
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
										<div class="card-title fw">template</div>
									</div>
								</div>
								<div class="card-body col-md-12">
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