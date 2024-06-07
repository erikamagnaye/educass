<?php include 'server/server.php' ?>

<?php 

session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0)) {
	header('location:login.php');
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Educational Assistance</title>
   


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
								<h2 class="text-black fw-bold">Educational Assistance</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner">
					<?php if(isset($_SESSION['message'])): ?>
							<div class="alert alert-<?php echo $_SESSION['success']; ?> <?= $_SESSION['success']=='danger' ? 'bg-danger text-light' : null ?>" role="alert">
								<?php echo $_SESSION['message']; ?>
							</div>
                            <!-- MESSAGE WHEN DATA IS INSERTED __-->
                            
                            <?php 
                            /*if (isset($_SESSION['message']) && $_SESSION['message'] != ''){ ?>                                                         ?>
                      <!--  <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Hello!</strong><?//php echo $_SESSION['message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div> -->
                            
						<?php unset($_SESSION['message']);  //}*/ ?> 
                       

						<?php endif ?>
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
										<table class="table table-striped">
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
                                    $query = "SELECT * FROM `educ aids`"; // SQL query to fetch all table data
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
                                            <a type="button" href="edit_educ.php?update&educid=<?php echo $educid; ?>"   class="btn btn-link btn-success" 
                                                title="Edit Data">
                                                <i class="fa fa-edit"></i>

                                            </a>
                                                <a type="button" href="javascript:void(0);" 
                                                onclick="confirmDeletion(<?php echo $educid; ?>)" 
                                                class="btn btn-link btn-danger" title="Remove">
                                                <i class="fa fa-times"></i>
                                                </a>
                                                <script>
                                                    function confirmDeletion(educid) {
                                                        if (confirm('Are you sure you want to delete this record?')) {
                                                            window.location.href = 'remove_educass.php?deleteid=' + educid + '&confirm=true';
                                                        }
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
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" placeholder="Enter Title" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label>Semester</label>
                                    <input type="text" class="form-control" placeholder="Enter Semester" name="sem" required>
                                </div>
                                <div class="form-group">
                                    <label>School Year</label>
                                    <input type="text" class="form-control" placeholder="Enter Title" name="sy" required>
                                </div>
								<div class="form-group">
                                    <label>Start of Application</label>
                                    <input type="date" class="form-control" name="start" required>
                                </div>
								<div class="form-group">
                                    <label>End of Application</label>
                                    <input type="date" class="form-control" name="end" required>
                                </div>
                                <div class="form-group">
                                    <label>Minimum Grade needed</label>
                                    <input type="text" class="form-control" name="min_grade" required>
                                </div>
								<div class="form-group">
                                    <label>Date Created</label>
                                    <input type="date" class="form-control" name="date" required>
                                </div>
								<div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" id="" required name="status">
                                        <option value="Open">Open</option>
                                        <option value="Closed">Closed</option>
                                    </select>
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

			<!-- Modal EDIT EDUCATIONAL ASSISTANCE -->
		<!-- Modal EDIT EDUCATIONAL ASSISTANCE 
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Assistance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="model/edit_educass.php">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" id="title" placeholder="Enter title" name="title" value="<?php echo $title ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <input type="text" class="form-control" id="sem" placeholder="Enter semester" name="sem" value="<?php echo $sem ?>"  required>
                    </div>
                    <div class="form-group">
                        <label>School Year</label>
                        <input type="text" class="form-control" id="sy" placeholder="Enter school year" name="sy" value="<?php echo $sy ?>"  required>
                    </div>
                    <div class="form-group">
                        <label>Minimum Grade Required</label>
                        <input type="text" class="form-control" id="min_grade" placeholder="Enter minimum grade" name="min_grade" value="<?php echo $min_grade ?>"  required>
                    </div>
                    <div class="form-group">
                        <label>Start</label>
                        <input type="date" class="form-control" id="start" name="start" value="<?php echo $start ?>"  required>
                    </div>
                    <div class="form-group">
                        <label>Due Date</label>
                        <input type="date" class="form-control" id="end" name="end" value="<?php echo $end ?>"  required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="status" required name="status" value="<?php echo $status ?>" >
                            <option value="Active">Open</option>
                            <option value="Inactive">Closed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date Posted</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo $date ?>"  required>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="educid" name="educid">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->


			<!-- Main Footer -->
			<?php include 'templates/main-footer.php' ?>
			<!-- End Main Footer -->
			
		</div>
		
	</div>
	<?php include 'templates/footer.php' ?>
   
</body>
</html>