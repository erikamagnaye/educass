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
else{
    if (isset($_GET['studid'])) {
        $studid = $_GET['studid'];
    
        $query = "SELECT *, CONCAT(lastname, ', ', firstname, ' ' , midname, '.' ) AS fullname, CONCAT(street_name, ', ', brgy, ' , ' , municipality, ', ', province ) AS address FROM student WHERE studid = $studid";
        $view = mysqli_query($conn, $query);
    
        if ($row = mysqli_fetch_assoc($view)) {
            $studid = $row['studid'];
            $lastname = $row['lastname'];
            $firstname = $row['firstname'];
            $midname = $row['midname'];
            $email = $row['email'];
            $contact_no = $row['contact_no'];
            $age = $row['age'];
            $birthday = $row['birthday'];
            
            $gender = $row['gender'];
            $brgy = $row['brgy'];
            $municipality = $row['municipality'];
            $province = $row['province'];
            $street_name = $row['street_name'];
            $validid = $row['validid'];
            $picture = $row['picture'];
            $citizenship = $row['citizenship'];
            $religion = $row['religion'];
            $civilstatus = $row['civilstatus'];
            $accstatus = $row['accstatus'];
            $fullname =$row['fullname'];
            $address =$row['address'];
            
          
        } else {
            $_SESSION['title'] = 'Error!';
            $_SESSION['message'] = 'No Record found!';
            $_SESSION['success'] = 'error';
            header("Location: student.php");
            exit();
        }
    }

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
								<h2 class="text-black fw-bold">Educational Assistance Beneficiary</h2>
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
										<div class="card-title">Educational Assistance  Applicant</div>
										<div class="card-tools">
											<button class="btn btn-info btn-border btn-round btn-sm" onclick="printDiv('printThis')">
												<i class="fa fa-print"></i>
												Print 
											</button>
										</div>
									</div>
								</div>

								<div class="card-body m-5" id="printThis">
                                <h3 class="mt-4 fw-bold text-center" style="border-bottom:1px solid green">Educational Assistance Applicant</h3>
                                <br>

 

                                    <div class="row mt-2">
                                    
            
            <div class="col-md-12">
        
            <br>
     
  
  <table class="table table-bordered">
  <tr>
        <th colspan="4" style="text-align: center;"><h3>Applicant Information</h3></th>
        
    </tr>
    <tr>
        <th><?php if(!empty($picture)): ?>
                        <img src="<?= preg_match('/data:image/i', $picture) ? $picture : '../applicants/assets/uploads/applicant_profile/'.$picture ?>" alt="Picture" 
                        class="avatar-img rounded-circle" style="height: 70px;width:70px;">
                    <?php else: ?>
                        <img src="assets/img/logo.png" alt="Picture" class="avatar-img rounded-circle">
                    <?php endif ?></th>
        <td style="text-transform: uppercase;font-weight:bold;"><?php echo $fullname; ?></td>
        <th>Email</th>
        <td><?php echo $email; ?></td>
    </tr>
    <tr>
        <th>Contact No.:</th>
        <td><?php echo $contact_no; ?></td>
        <th>Age:</th>
        <td><?php echo $age; ?></td>
    </tr>
    <tr>
        <th>Birthday:</th>
        <td><?php echo $birthday; ?></td>
        <th>Gender:</th>
        <td><?php echo $gender; ?></td>
    </tr>
    <tr>
        <th>Address:</th>
        <td><?php echo $street_name . ', ' . $brgy . ', ' . $municipality . ', ' . $province; ?></td>
        <th>Citizenship:</th>
        <td><?php echo $citizenship; ?></td>
    </tr>
    <tr>
        <th>Religion:</th>
        <td><?php echo $religion; ?></td>
        <th>Civil Status:</th>
        <td><?php echo $civilstatus; ?></td>
    </tr>
    <tr>

  
        <th>Account Status:</th>
        <td><?php echo $accstatus; ?></td>
        <th>Valid ID</th>
        <td>
        <?php if(!empty($validid)): ?>
    <a href="<?= '../applicants/assets/uploads/validid_file/'.$validid ?>" target="_blank"><?php echo $validid ?></a>
  <?php else: ?>
    No Valid ID available
  <?php endif ?>
</td>
    </tr>

</table>

     
                                          
                                        
                                        <p class="ml-3 text-center"><i>&copy Web Based Educational Assistance Application System for San Antonio, Quezon</i></p>
                                 
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
        //CODE TO PRINT THE DOCUMENT
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

            // CODE TO VIEW VALID

    </script>
</body>
</html><?php }?>