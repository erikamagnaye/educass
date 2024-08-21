<?php include 'server/server.php' ?>

<?php 

session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0)) {
	header('location:login.php');
    exit();
}
else{
    $studid = $_SESSION['id'];
    if (isset($_GET['appid']) && isset($_GET['educid'])) {
        $appid = $_GET['appid'];
        $educid = $_GET['educid'];
    
        $query = "SELECT *
FROM `application`
JOIN `student` ON `application`.`studid` = `student`.`studid`
JOIN `studentcourse` ON `application`.`studid` = `studentcourse`.`studid` and `application`.educid=`studentcourse`.educid
JOIN `parentinfo` ON `application`.`studid` = `parentinfo`.`studid`
JOIN (
  SELECT * FROM `educ aids` WHERE `educid` = $educid
) AS `educ aids` ON `application`.`educid` = `educ aids`.`educid`
WHERE `application`.`appid` = $appid AND `application`.`educid` = $educid AND `application`.`studid` = $studid";
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
        
            $educname = $row['educname'];
            $sem = $row['sem'];
            $sy = $row['sy'];

            $course = $row['course'];
            $major = $row['major'];
            $school_address = $row['school_address'];
            $school_name = $row['school_name'];
            $coursesem = $row['sem'];
            $coursesy = $row['sy'];
            $year = $row['year'];

            $father = $row['father'];
            $f_occu = $row['f_occu'];
            $f_age = $row['f_age'];
            $f_income= $row['f_income'];
            $f_status = $row['f_status'];
            $f_educattain = $row['f_educattain'];
            $mother = $row['mother'];
            $m_occu = $row['m_occu'];
            $m_age = $row['m_age'];
            $m_income= $row['m_income'];
            $m_status = $row['m_status'];
            $m_educattain = $row['m_educattain'];
          
        } else {
            $_SESSION['title'] = 'Error!';
            $_SESSION['message'] = 'Something went Wrong. Please, Try again!';
            $_SESSION['success'] = 'error';
            header("Location: all_application.php");
            exit();
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Educational Assistance</title>
   
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
                                <div class="text-center">
                                            <img src="assets/img/logo.png" class="img-fluid" width="80" height="60">
										</div>
                                <h3 class="mt-4 fw-bold text-center" style=""><?php echo $educname . ' SY: '. $sy. ' '. $sem?></h3>
                                <br>

 

                                    <div class="row mt-2">
                                    
            
            <div class="col-md-12">
        
            <br>
     
  
  <table class="table table-bordered table-responsive">
  <tr>
  <th colspan="4" style="text-align: center; margin-left: 10px;">
  <h3>APPLICANT INFORMATION</h3>
  
</th> 
    </tr>
    <tr>
        <th colspan="2" style="text-transform: uppercase;font-weight:bold; margin: 5px;"><?php if(!empty($picture)): ?>
                        <img src="<?= preg_match('/data:image/i', $picture) ? $picture : '../applicants/assets/uploads/applicant_profile/'.$picture ?>" alt="Picture" 
                        class="avatar-img rounded-circle" style="height: 70px;width:70px; margin: 2px;">
                    <?php else: ?>
                        <img src="assets/img/logo.png" alt="Picture" class="avatar-img rounded-circle">
                    <?php endif ?> <?php echo $firstname . ' ' . $midname . '. ' . $lastname; ?></th>
        <!--<td colspan="2" style="text-transform: uppercase;font-weight:bold;"><?php echo $firstname . ' ' . $midname . '. ' . $lastname; ?></td>-->
        <th colspan="2"><span style=" color: red">Application No: <?php echo $appid?></span></th>

    </tr>
    <tr>
        <th colspan="2">PERSONAL INFORMATION</th>
 
        <th colspan="2">COURSE INFORMATION</th>
       
    </tr>
    <tr>
         <td colspan="2" style="padding-left: 20px;"><br>Email  &emsp;&emsp;&emsp;&nbsp;&nbsp;:&emsp; <?php echo $email; ?> 
            <br>Contact No.&emsp;:&emsp;<?php echo $contact_no?> 
            <br>Age  &emsp;&emsp;&emsp;&emsp; :&emsp;<?php echo $age; ?>
            <br>Birthday  &emsp;&emsp; :&emsp;<?php echo $birthday; ?>
            <br>Address.  &emsp;&emsp; :&emsp;<?php echo $street_name . ', ' . $brgy . ', ' . $municipality . ', ' . $province; ?>
            <br>Gender    &emsp;&emsp;&nbsp;&nbsp; :&emsp;<?php echo $gender; ?>
            <br>Citizenship    &emsp; :&emsp;<?php echo $citizenship; ?>
            <br>Religion   &emsp;&emsp;&nbsp;&nbsp;:&emsp;<?php echo $religion; ?>
            <br>Civil Status    &emsp; :&emsp;<?php echo $civilstatus; ?><br>
         
        </td>
       
        <td colspan="2"><br>Course &emsp;&emsp;:&emsp;<?php echo $course; ?> 
            <br>Major &emsp;&emsp;&nbsp;:&emsp;<?php echo $major?>
             <br>Year &emsp;&emsp;&emsp;:&emsp;<?php echo $year; ?>
             <br>Semester &emsp; :&emsp;<?php echo $coursesem; ?>
             <br>SY&emsp;&emsp;&emsp;&emsp;:&emsp;<?php echo   $coursesy; ?>
             <br>School&emsp;&emsp; &nbsp;:&emsp;<?php echo $school_name?> 
             <br>Address&emsp;&emsp;:&emsp;<?php echo $school_address; ?><br>
        </td>
    </tr>

  <tr>
    <th colspan="4"></th>
  </tr>
  <tr>
    <th colspan="2"> Grades</th>
    <th colspan="2" > PARENT INFORMATION</th>
  </tr>
  <tr>
    <th></th>
    <td></td>
    <th ></th>
    <td></td>
  </tr>
    <tr>
        <th colspan="4"></th>
    </tr>
    <tr>
        <th height="50" colspan="2">Religion:</th>
      
        <th height="50" colspan="2">Civil Status:</th>
     
    </tr>
    <tr>

  
        <th style="height: 30px;">Account Status:</th>
        <td style="height: 30px;"><?php echo $accstatus; ?></td>
        <th height="30">Valid ID</th>
        <td height="30">
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