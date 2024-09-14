
<?php include 'server/server.php' ?>
<?php 
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0) || !isset($_SESSION['id'])) {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
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
    grid-template-columns: repeat(6, 1fr);
    gap: 10px;
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
    justify-content: center;
}

.card-icon {
    font-size: 20px;
    color: #4CAF50;
}

h5 {
    margin: 10px 0 10px;
	word-wrap: break-word;
    overflow-wrap: break-word;
	word-break: break-all;
    font-size: 15px;
}
/* Small screens (max-width: 768px) */
@media (max-width: 768px) {
    .dashboard {
        grid-template-columns: repeat(3, 1fr);
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
        font-size: 13px;
		overflow-wrap: break-word; /* Add this line to break long text */
		word-wrap: break-word;
		word-break: break-all;
    }
}

/* Extra small screens (max-width: 480px) */
@media (max-width: 480px) {
    .dashboard {
        grid-template-columns: repeat(3, 1fr);
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
        font-size: 13px;
		overflow-wrap: break-word; /* Add this line to break long text */
		word-wrap: break-word;
		word-break: break-all;
    }
}

/* Extra extra small screens (max-width: 320px) */
@media (max-width: 320px) {
    .dashboard {
        grid-template-columns: repeat(3, 1fr);
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
        font-size: 14px;
    }
    h5 {
        font-size: 13px;
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
				
							
						</div>
						
					</div>
				
				</div>
                            <div class="page-inner mt--2">
		

	
				
				
								

	

<div class="dashboard">
        <div class="card bg-secondary">
            <div class="card-icon" style="color:white"><i class="fas fa-user"></i></div>
          <a href="all_applications.php" class="btn">  <h5 style="color:white"><?= $totalapp ?> <br>Applications</h5></a>
          
        </div>
        <div class="card bg-warning">
            <div class="card-icon"style="color:white"><i class="fa-solid fa-spinner fa-spin"></i></div>
			<a href="all_pending_applications.php" class="btn"><h5 style="color:white"><?= $pending ?> <br>Pending</h5></a>
         
        </div>
        <div class="card bg-success">
            <div class="card-icon" style="color:white"><i class="fa fa-thumbs-up"></i></div>
			<a href="all_approved_applications.php" class="btn"><h5 style="color:white"><?= $approved ?> <br>Approved</h5></a>
     
        </div>
        <div class="card "style="background-color:#B80000">
            <div class="card-icon" style="color:white"><i class="fa fa-thumbs-down"></i></div>
			<a href="all_rejected_applications.php" class="btn"> <h5 style="color:white"><?=$rejected?><br> Rejected</h5></a>
           
        </div> <div class="card bg-info">
            <div class="card-icon" style="color:white"><i class="fa-solid fa-user-graduate"></i></div>
			<a href="educaids.php" class="btn"> <h5 style="color:white"><?=$totaleduc?><br>Educational Aids </h5></a>      
        </div>
		<div class="card text-center " style="background-color:#E36414">
            <div class="card-icon" style="color:white"><i class="fa-solid fa-clipboard-question"></i></div>
			<a href="complaint.php" class="btn"> <h5 style="color:white"><?=$totalconcerns?> <br>Complaints</h5></a>         
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