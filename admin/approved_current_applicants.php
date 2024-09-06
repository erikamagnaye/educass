<?php include 'server/server.php' ?>

<?php 

session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'admin') {
	header('location:login.php');
    exit();
}
else {


  //get the recent educational
  $query = "SELECT educid FROM `educ aids` ORDER BY date DESC LIMIT 1";
  $result = $conn->query($query);
  $row = $result->fetch_assoc();
  $recent = $row['educid'];

//end of code to update educ ass digitally

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Educational Assistance</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
     
<style>
    .btn-link + .btn-link {
    margin-left: 5px;
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
				<div class="panel-header ">
					<div class="page-inner">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-black fw-bold">Admin</h2>
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
										<div class="card-title">Educational Assistance Provided</div>
										
											<div class="card-tools">
                                            <a href="print_all_current.php" class="btn btn-success btn-border btn-round btn-sm" title="view and print">
												<i class="fa fa-eye"></i>
												View
											</a>
                                            <a href="model/export_educprovided_csv.php" class="btn btn-danger btn-border btn-round btn-sm" title="Download">
												<i class="fa fa-file"></i>
												Export CSV
											</a>
                                            <a href="dashboard.php" class="btn btn-danger btn-border btn-round btn-sm" >
												<i class="fa fa-chevron-left"></i>
												Back
											</a>
											</div>
									
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">





                                    <table id="dataTable" class="table table-striped">

<thead>
    <tr>
    <th scope="col">No</th>
        <th scope="col">Full Name</th>
        <th scope="col">Year</th>
        <th scope="col">Barangay</th>
        <th scope="col">Status</th>
        <th>Action</th>

    </tr>
</thead>
<tbody>
    <?php

    $query = " SELECT *, CONCAT(lastname, ', ', firstname, ' ' , midname, '.' ) AS fullname 
    FROM student join studentcourse on student.studid=studentcourse.studid 
join application on studentcourse.courseid=application.courseid 
where application.educid=$recent and appstatus = 'Approved' ORDER BY brgy ASC, `year` ASC, lastname ASC";
    $view_data = mysqli_query($conn, $query); // sending the query to the database

    $count =1;
    // displaying all the data retrieved from the database using while loop
    while ($row = mysqli_fetch_assoc($view_data)) {
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
        //$picture = $row['picture'];
        $citizenship = $row['citizenship'];
        $religion = $row['religion'];
        $civilstatus = $row['civilstatus'];
        $accstatus = $row['accstatus'];
        $fullname = $row['fullname'];
        $appstatus = $row['appstatus'];

        $year = $row['year'];
        $school_name = $row['school_name'];
        $appid = $row['appid'];

        $imagePath = $row['picture'];
        if (empty($imagePath)) {
            $imageUrl = '../applicants/assets/img/pic.jpg/';
        } elseif (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            $imageUrl = $imagePath;
        } else {
            $imageUrl = '../applicants/assets/uploads/applicant_profile/' . $imagePath;
        }
        // $fullname = $lastname . ', ' . $firstname;
    ?>
        <tr>
        <td><?php echo $count; ?></td>
            <td><img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="" class="avatar-img rounded-circle" style="height: 50px;width:50px;"> <?php echo htmlspecialchars($fullname); ?></td>
            <td><?php echo htmlspecialchars($year); ?></td>
            <td><?php echo htmlspecialchars($brgy); ?></td>
            <td style="<?php
                        if ($appstatus == 'Pending') {
                            echo 'color: #FFC107'; // yellow-orange color for pending
                        } elseif ($appstatus == 'Approved') {
                            echo 'color: #4CAF50'; // green color for approved
                        } elseif ($appstatus == 'Rejected') {
                            echo 'color: #FF0000'; // red color for rejected
                        }
                        ?>">
                <?php echo htmlspecialchars($appstatus); ?>
            </td>
            <td>
                <a type="button" href="applicant_info.php?studid=<?php echo $studid; ?>&educid=<?php echo $recent; ?>&appid=<?php echo $appid; ?>" class="btn btn-link btn-info" title="Edit Data">
                    <i class="fa fa-file"></i></a>



            </td>
        </tr>
     
    <?php    $count++; } ?>

</tbody>


</table>
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
                                unset($_SESSION['success']);
                                unset($_SESSION['title']);  ?>
                            <?php endif; ?>

                            <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    "pageLength": 10,
                    "lengthChange": true,
                    "order": [
                       
                    ],
                    "searching": true,
                    "ordering": true,
                    "language": {
                        "search": "_INPUT_",
                        "searchPlaceholder": "Search here",
                        "lengthMenu": "_MENU_entries per page"
                    },
                });
            });
        </script>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
</body>
</html><?php }?>