<?php include 'server/server.php' ?>

<?php 

session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'Admin') {
	header('location:login.php');
    exit();
}
else {
// staet of code to digitally update status of educ assistance
$currentDate = date('Y-m-d');
$newStatus = 'Closed'; // The status you want to set when the end date is reached

// Select all entries with a due date less than the current date
$selectQuery = "SELECT educid FROM `educ aids` WHERE `end` < ?";
$stmtSelect = $conn->prepare($selectQuery);
$stmtSelect->bind_param("s", $currentDate);
$stmtSelect->execute();
$result = $stmtSelect->get_result();

// Update the status of each entry found
if ($result->num_rows > 0) {
    $updateQuery = "UPDATE `educ aids` SET `status` = ? WHERE educid = ?";
    $stmtUpdate = $conn->prepare($updateQuery);

    while ($row = $result->fetch_assoc()) {
        $id = $row['educid'];
        $stmtUpdate->bind_param("si", $newStatus, $id);
        $stmtUpdate->execute();
    }

    $stmtUpdate->close();
    //echo "Statuses updated successfully.";
}// else {
   // echo "No records to update.";
//}

$stmtSelect->close();



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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
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
                                            <a href="viewprinteduc.php" class="btn btn-success btn-border btn-round btn-sm" title="view and print">
												<i class="fa fa-eye"></i>
												View
											</a>
                                            <a href="model/export_educprovided_csv.php" class="btn btn-danger btn-border btn-round btn-sm" title="Download">
												<i class="fa fa-file"></i>
												Export CSV
											</a>
												<a href="#add" data-toggle="modal" class="btn btn-info btn-border btn-round btn-sm" title="Post Assistance">
													<i class="fa fa-plus"></i>
													Post New assistance
												</a>
											</div>
									
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">

	<!-- MANUAL SEARCH .....ETO YUNG MAY CLEAR OPTION
	<div class="row">
<div class="col-md-12">
<form method="GET">
<div class="input-group mb-3">
<input type="text" class="form-control" name="search" placeholder="Search..." value="<?//php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
<div class="input-group-append">
<button class="btn btn-primary" type="submit">Search</button>
<?//php if (isset($_GET['search']) && $_GET['search'] != ''): ?>
<a href="<?//php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary">Clear</a>
<?//php endif; ?>
</div>
</div>
</form>
</div>
</div> -->


<!--  <div class="row">
<div class="col-md-6">
<div class="dataTables_length" id="dataTable_length">
<label>Show 
<select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
<option value="10">10</option>
<option value="25">25</option>
<option value="50">50</option>
<option value="100">100</option>
</select> entries
</label>
</div>
</div>
<div class="col-md-6">
<input type="text" id="search-input" class="form-control" placeholder="Search...">
<div id="search-results"></div>
</div>
</div>-->
										<table id="dataTable" class="table table-striped">
											<thead>
												<tr>
													<th scope="col">Title</th>
													<th scope="col">Semester</th>
													<th scope="col">School Year</th>
													<th>Status</th>
													<th>Action</th>
													
												</tr>
											</thead>
											<tbody>
                          <?php 
                         // if (isset($_GET['search'])) {
                          //  $search = $_GET['search'];
                          //  $query = "SELECT * FROM `educ aids` WHERE `educname` LIKE '%$search%' OR `sem` LIKE '%$search%' OR `sy` LIKE '%$search%' order by `date` desc";
                      //  } else {
                           // $query = "SELECT * FROM `educ aids` order by `date` desc";
                       // }
                                    $query = "SELECT * FROM `educ aids` order by `date` desc"; // SQL query to fetch all table data
                                    $view_data = mysqli_query($conn, $query); // sending the query to the database

                                    // displaying all the data retrieved from the database using while loop
                                    while ($row = mysqli_fetch_assoc($view_data)) {
                                        $educid = $row['educid'];                
                                        $title = $row['educname'];        
                                        $sem = $row['sem'];         
                                        $sy = $row['sy'];  
                                        $status = $row['status'];           
                                        $start = $row['start'];        
                                        $end = $row['end'];         
                                        $date = $row['date'];  
                                        $min_grade = $row['min_grade'];  
                                    ?>
                                  <tr>
                                        <td class="text-uppercase"><?php echo htmlspecialchars($title); ?></td>
                                        <td><?php echo htmlspecialchars($sem); ?></td>
                                        <td><?php echo htmlspecialchars($sy); ?></td>
                                        <td><?php echo htmlspecialchars($status); ?></td>
                                        <td>
                                            <a type="button" href="educ_report.php?educreportid=<?php echo $educid; ?>"   class="btn btn-link btn-primary mr-1" 
                                                title="view report">
                                                <i class="fa-solid fa-chart-simple"></i>

                                            </a>
                                            <a type="button" href="edit_educ.php?update&educid=<?php echo $educid; ?>"   class="btn btn-link btn-success mr-1" 
                                                title="Edit Data">
                                                <i class="fa fa-edit"></i>

                                            </a>
                                            <a type="button" href="javascript:void(0);"
                                                                    onclick="confirmDeletion(<?php echo $educid; ?>)"
                                                                    class="btn btn-link btn-danger mr-1" title="Remove">
                                                                    <i class="fa fa-times"></i>
                                                                </a>


                                                                <script>
                                                                    function confirmDeletion(educid) {
                                                                        Swal.fire({
                                                                            title: "Are you sure?",
                                                                            text: "You want to delete this record?",
                                                                            icon: "warning",
                                                                            showCancelButton: true,
                                                                            confirmButtonColor: "#DD6B55",
                                                                            confirmButtonText: "Yes, delete it!",
                                                                            cancelButtonText: "Cancel",
                                                                            closeOnConfirm: true
                                                                        }).then((result) => {
                                                                            if (result.isConfirmed) {
                                                                                window.location.href = 'remove_educass.php?deleteid=' + educid + '&confirm=true';
                                                                            }
                                                                        });
                                                                    }
                                                                </script>
                                        </td>
                                    </tr>
                                    <?php } ?>

</tbody>

										
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			 <!-- Modal ADD NEW POST FOR EDUCATIONAL ASSISTANCE -->
			 <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Post Educational Assistance</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="model/addeduc.php" >
                                <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Title</label>
                                    <input type="text" class="form-control" placeholder="Enter Title" name="title" required>
                                </div>
                                
                              
                                </div>
                                <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Semester</label>
                                    <input type="text" class="form-control" placeholder="Enter Semester" name="sem" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label>School Year</label>
                                    <input type="text" class="form-control" placeholder="Enter Title" name="sy" required>
                                </div>
                                
                                </div>
                                <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Start of Application</label>
                                    <input type="date" class="form-control" name="start" required>
                                </div>
								<div class="form-group col-md-6">
                                    <label>End of Application</label>
                                    <input type="date" class="form-control" name="end" required>
                                </div>
                                </div>
                                
								
                              <!--  <div class="form-group">
                                    <label>Minimum Grade needed</label>
                                    <input type="text" class="form-control" name="min_grade" required>
                                </div>-->
                                <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Date Created</label>
                                    <input type="date" class="form-control" name="date" required>
                                </div>
								<div class="form-group col-md-6">
                                    <label>Status</label>
                                    <select class="form-control" id="" required name="status">
                                        <option value="Open">Open</option>
                                        <option value="Closed">Closed</option>
                                    </select>
                                </div>
                                </div>
								
                            
                        </div>
                        <div class="modal-footer">
                          <!--  <input type="hidden" id="pos_id" name="id"> -->
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="create">Create</button>
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
       <!-- ALERT FOR ADD -->
       <?php if (isset($_SESSION['message'])) : ?>
                    <script>
                        Swal.fire({
                            title: '<?php echo $_SESSION['success']; ?>',
                            text: '<?php echo $_SESSION['message']; ?>',
                            icon: '<?php echo $_SESSION['success']; ?>',
                            confirmButtonText: 'OK'
                        });
                    </script>
                    <?php unset($_SESSION['message']);
                    unset($_SESSION['success']);
                    ?>
                <?php endif; ?>


         <!-- alert for UPDATEEEEEEEEE -->
         <?php if (isset($_SESSION['alertmess'])) : ?> 
                                <script>
                                    Swal.fire({
                                        title: '<?php echo $_SESSION['title']; ?>',
                                        text: '<?php echo $_SESSION['alertmess']; ?>',
                                        icon: '<?php echo $_SESSION['success']; ?>',
                                        confirmButtonText: 'OK'
                                    });
                                </script>
                                <?php unset($_SESSION['alertmess']);
                                unset($_SESSION['success']);
                                unset($_SESSION['title']);  ?>
                            <?php endif; ?>

    <script>
        //this can be remove because search is still working without it
    $(document).ready(function() {
        $('#search-input').on('keyup', function() {
            var searchQuery = $(this).val();
            if (searchQuery != '') {
                $.ajax({
                    type: 'POST',
                    url: 'live_search.php',
                    data: {search: searchQuery},
                    success: function(data) {
                        $('#search-results').html(data);
                    }
                });
            } else {
                $('#search-results').html('');
            }
        });
    });

    //CODE FOR DATATABLES THAT SORT AND SEARCH DATA
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "ordering": true,
            "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "order": [[2, "desc"], 
                    [1, "desc"],
                ],
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search here"
            },
            "columns": [
                {"title": "Title", "data": "title", "orderable": true},
                {"title": "Semester", "data": "semester", "orderable": true},
                {"title": "School Year", "data": "school_year", "orderable": true},
                {"title": "Status", "data": "status", "orderable": true},
                {"title": "Action", "data": "action", "orderable": true}
            ]
        });
    });
</script>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
</body>
</html><?php }?>