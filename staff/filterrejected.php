
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
if (isset($_POST['filter'])) {
    $recent = $_POST['recent'];
    $filbrgy = $_POST['brgy'];
    $level = $_POST['yearlevel'];

    if ($level == 'All Levels') {
        $level_condition = '%'; // Use a wildcard to fetch all year levels
    } else {
        $level_condition = $level; // Use the specific year level selected
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

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
                                      
										<div class="card-title" style=" margin-right: 10px;"><?php echo $filbrgy?></div>
                                     
											<div class="card-tools">
                                        
                                            <a href="#" class="btn btn-success btn-border btn-round btn-sm"
                                                    title="view and print" onclick="openPrintModal()">
                                                    <i class="fa fa-eye"></i>
                                                    View
                                                </a>
                                            <a href="model/exportfilterrejected.php?recent=<?=$recent?>&filbrgy=<?=$filbrgy?>&year=<?=$level_condition?>" class="btn btn-success btn-border btn-round btn-sm" title="Download">
												<i class="fa fa-file"></i>
												Export CSV
											</a>
											    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-danger btn-border btn-round btn-sm" title="Download">
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

    // Perform the query
    $query = "SELECT *, CONCAT(lastname, ', ', firstname, ' ' , midname, '.' ) AS fullname 
    FROM student join studentcourse on student.studid=studentcourse.studid 
    join application on studentcourse.courseid=application.courseid 
    where application.educid=? and brgy=? and `year` LIKE ? and application.appstatus = 'Rejected' ORDER BY `year` ASC, lastname ASC";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $recent, $filbrgy, $level_condition);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);



    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
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
			
             <!--PRINT -->

                <!-- Modal -->
                <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="printModalLabel">Print Educational Assistance Applicants</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="printModalBody">
                                <!-- Content to be printed will be injected here -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-round btn-secondary"
                                    data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-round btn-danger"
                                    onclick="printDiv('printModalBody')"><i class="fa fa-print"></i> Print</button>
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

                  //PRINT 
                  function openPrintModal() {
                // Fetching content from the server using AJAX or PHP
                var recent = <?php echo json_encode($recent); ?>; // Get educreportid from PHP
                var filbrgy = <?php echo json_encode($filbrgy); ?>; 
                var year = <?php echo json_encode($level_condition); ?>; 
                $.ajax({
                    url: 'print_filter_rejected_current.php', // Create this PHP file to return HTML content
                    type: 'GET',
                    data: { recent: recent,   filbrgy: filbrgy, year:year},
                    success: function (response) {
                        // Injecting the fetched content into the modal body
                        document.getElementById('printModalBody').innerHTML = response;
                        // Show the modal
                        $('#printModal').modal('show');
                    },
                    error: function () {
                        alert('Error fetching report data.');
                    }
                });
            }

            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                // Replace body content with the content to print
                document.body.innerHTML = printContents;

                // Trigger print dialog
                window.print();

                // Restore original body content
                document.body.innerHTML = originalContents;
                location.reload();
            }
        </script>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
</body>
</html><?php }?>