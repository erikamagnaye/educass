<?php include 'server/server.php' ?>

<?php 

session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
$skTypes = array('SK-Arawan','SK-Bagong Niing', 'SK-Balat Atis','SK-Briones','SK-Bulihan','SK-Buliran','SK-Callejon',
'SK-Corazon', 'SK-Del Valle','SK-Loob','SK-Magsaysay','SK-Matipunso','SK-Niing','SK-Poblacion','SK-Pulo',
 'SK-Pury','SK-Sampaga','SK-Sampaguita', 'SK-San Jose', 'SK-Sinturisan'); 
if (!isset($_SESSION['staffid']) || strlen($_SESSION['staffid']) == 0 ||in_array($_SESSION['role'], $skTypes)) {
	header('location:index.php');
    exit();
}
else {

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Educational Assistance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    /* Table styles */
    .table {
        font-size: 14px;
    }
    .table th, .table td {
        font-size: 12px;
    }
    .table h2 {
        font-size: 18px;
    }

    /* Responsive styles */
    @media only screen and (max-width: 768px) {
        /* Tablet and mobile styles */
        .card-body {
            padding: 1rem;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .table {
            font-size: 12px;
        }
        .table th, .table td {
            font-size: 10px;
        }
        h3, p{
            font-size: 10px;
        }
        img {
         width: 20%; 
         height: auto;
}
    }

    @media only screen and (max-width: 480px) {
        /* Mobile styles */
        .card-body {
            padding: 0.5rem;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .table {
            font-size: 10px;
        }
        .table th, .table td {
            font-size: 8px;
        }
        h3, p{
            font-size: 10px;
        }
        img {
         width: 20%; 
         height: auto;
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
				<div class="panel-header bg-transparent-gradient">
					<div class="page-inner">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-black fw-bold">Educational Assistance</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner">
					<div class="row mt--2">
						<div class="col-md-12">

                            <?php if(isset($_SESSION['message'])): ?>
                                <div class="alert alert-<?php echo $_SESSION['success']; ?> <?= $_SESSION['success']=='danger' ? 'bg-danger text-light' : null ?>" role="alert">
                                    <?php echo $_SESSION['message']; ?>
                                </div>
                            <?php unset($_SESSION['message']); ?>
                            <?php endif ?>

                            <div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title">Educational Assistancet</div>
										<div class="card-tools">
											<button class="btn btn-info btn-border btn-round btn-sm" onclick="printDiv('printThis')">
												<i class="fa fa-print"></i>
												Print 
											</button>
										</div>
									</div>
								</div>
								<div class="card-body m-5" id="printThis">
                                    <div class="d-flex flex-wrap justify-content-around" style="border-bottom:1px solid green">
                                        <div class="text-center">
                                            <img src="assets/img/logo.png" class="img-fluid" width="100">
										</div>
										<div class="text-center">
                                            <h3 class="mb-0">Republic of the Philippines</h3>
                                            <h3 class="mb-0">Province of Quezon</h3>
											<h3 class="fw-bold mb-0">San Antonio</h3>
                                            <p><i>Mobile No.0923333</i></p>
										</div>
                                        <div class="text-center">
                                            <img src="assets/img/logo.png" class="img-fluid" width="100">
										</div>
									</div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="text-center mt-5">
                                                <h3 class="mt-4 fw-bold">Educational Assistance Provided in San Antonio, Quezon</h3>
                                            </div>
                                            <br>
                                            <div class="table-responsive">
        <table class="table table-bordered">
       <?php
        $sql = "SELECT * FROM `educ aids`";
         $result = mysqli_query($conn, $sql); 
    ?>
            <thead>
                <tr>
                <th>Educational Assistance</th>
                    <th>Semester</th>
                    <th>School year</th>
                    <th>Start</th>
                    <th>Due</th>
                    <th>Minimum Grade</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display each record in the table
                $count = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($count % 20 === 0 && $count !== 0) {
                        echo '</tbody></table><div class="page-break"></div><h2>Educational  (Page ' . ($count / 25 + 1) . ')</h2><table class="table table-bordered"><thead><tr><th>ID</th><th>Name</th><th>Year</th><th>Course</th><th>Barangay</th><th>Gender</th></tr></thead><tbody>';
                    }
                    echo "<tr>";
                    echo "<td>" . $row['educname'] . "</td>";
                    echo "<td>" . $row['sem'] . "</td>";
                    echo "<td>" . $row['sy'] . "</td>";
                    echo "<td>" . $row['start'] . "</td>";
                    echo "<td>" . $row['end'] . "</td>";
                    echo "<td>" . $row['min_grade'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "</tr>";
                    $count++;
                }
                ?>
            </tbody>
        </table>
    </div>
                                          
                                        
                                        <p class="ml-3 text-center"><i>&copy Web Based Educational Assistance Application System for San Antonio, Quezon</i></p>
                                    </div>
								</div>
							</div>
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
    <script>
            function openModal(){
                $('#pment').modal('show');
            }
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
    </script>
</body>
</html><?php }?>