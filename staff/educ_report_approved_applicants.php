<?php include 'server/server.php' ?>

<?php 

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
if (!isset($_SESSION['staffid']) || strlen($_SESSION['staffid']) == 0 || in_array($_SESSION['role'], $skTypes)) {
    header('location:index.php');
    exit();
}
else {
    if (isset($_GET['educreportid'])) {
        $educreportid = $_GET['educreportid'];
    }

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
										<div class="card-title">Approved Applicants</div>
										<a href="#add" data-toggle="modal" class="btn btn-secondary btn-border btn-round btn-sm" title="Post Assistance">
                                                    <i class="fa fa-filter"></i>
                                                   Filter Option
                                                </a>
											<div class="card-tools">
                                            <a href="print_approved_current.php" class="btn btn-success btn-border btn-round btn-sm" title="view and print">
												<i class="fa fa-eye"></i>
												View
											</a>
                                            <a href="model/export_educprovided_csv.php" class="btn btn-danger btn-border btn-round btn-sm" title="Download">
												<i class="fa fa-file"></i>
												Export CSV
											</a>
                                            <a href="educ_report.php?educreportid=<?php echo $educreportid ?>" class="btn btn-danger btn-border btn-round btn-sm" >
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
where application.educid=$educreportid and appstatus = 'Approved' ORDER BY brgy ASC, `year` ASC, lastname ASC";
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
                <a type="button" href="applicant_info.php?studid=<?php echo $studid; ?>&educid=<?php echo $educreportid; ?>&appid=<?php echo $appid; ?>" class="btn btn-link btn-info" title="Edit Data">
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
			
			 
            <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header " >
                                <h5 class="modal-title" id="exampleModalLabel">Filter Options</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="filterapproved.php">
                                  
                                   
                                  
                                    <div class="form-group col-md-12">
                                       
                                        <input type="hidden" value="<?php echo $educreportid ?>" name="recent">
                                      
                                            <label>Barangay</label>
                                            <select class="form-control" id="" required name="brgy">
                                          
                                                    <option value="Arawan">Arawan</option>
                                                    <option value="Bagong Niing">Bagong Niing</option>
                                                    <option value="Balat Atis">Balat Atis</option>
                                                    <option value="Briones">Briones</option>
                                                    <option value="Bulihan">Bulihan</option>
                                                    <option value="Buliran">Buliran</option>
                                                    <option value="Callejon">Callejon</option>
                                                    <option value="Corazon">Corazon</option>
                                                    <option value="Del Valle">Del Valle</option>
                                                    <option value="Loob">Loob</option>
                                                    <option value="Magsaysay">Magsaysay</option>
                                                    <option value="Matipunso">Matipunso</option>
                                                    <option value="Niing">Niing</option>
                                                    <option value="Poblacion">Poblacion</option>
                                                    <option value="Pulo">Pulo</option>
                                                    <option value="Pury">Pury</option>
                                                    <option value="Sampaga">Sampaga</option>
                                                    <option value="Sampaguita">Sampaguita</option>
                                                    <option value="San Jose">San Jose</option>
                                                    <option value="Sintorisan">Sintorisan</option>
                                            </select>
                                            <label>Year Level</label>
                                            <select class="form-control" id="" required name="yearlevel">
                                         
                                                    <option value="All Levels">All Levels</option>
                                                    <option value="First Year">First Year</option>
                                                    <option value="Second Year">Second Year</option>
                                                    <option value="Third Year">Third Year</option>
                                                    <option value="Fourth Year">Fourth Year</option>
                                                    <option value="Fifth Year">Fifth Year</option>
                                            
                                            </select>
                                        </div>
                              
                            </div>
                            <div class="modal-footer">
                                <!--  <input type="hidden" id="pos_id" name="id"> -->
                                <button type="button" class="btn  btn-sm" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm" name="filter">Filter</button>
                            </div>

                        
                            </form>
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