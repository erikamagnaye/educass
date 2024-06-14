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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
 /* Default font size for body */
.content h2{
    font-size: 20px;
}

        /* Font size for small devices (phones, less than 600px) */
        @media (max-width: 600px) {
       
            .card-title, h2, .table th, .table td {
                font-size: 9px;
            }
            .btn {
                font-size: 9px;
            }
        }

        /* Font size for medium devices (tablets, 600px and up) */
        @media (min-width: 600px) and (max-width: 768px) {
          
            .card-title, h2, .table th, .table td {
                font-size: 12px;
            }
            .btn {
                font-size: 12px;
            }
        }

        /* Font size for large devices (desktops, 768px and up) */
        @media (min-width: 768px) and (max-width: 992px) {
            body {
                font-size: 16px;
            }
            .card-title, h2, .table th, .table td {
                font-size: 14px;
            }
            .btn {
                font-size: 14px;
            }
        }

        /* Font size for extra large devices (large desktops, 992px and up) */
        @media (min-width: 992px) {
         
            .card-title, h2, .table th, .table td {
                font-size: 14px;
            }
            .btn {
                font-size: 14px;
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
										<div class="card-title">Available Educational Assistance </div>
										
									
									
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-striped">
											<!--<thead>
												<tr>
													<th scope="col">Title</th>
													<th scope="col">Semester</th>
													<th scope="col">School Year</th>
													<th>Status</th>
													<th>Action</th>
													
												</tr>
											</thead>  -->
											<tbody>
                          <?php 
                                    $query = "SELECT * FROM `educ aids` where status = 'Open' order by `date` desc"; // SQL query to fetch all table data
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
                                        <td><?php echo htmlspecialchars($sem);?> SY: <?php echo htmlspecialchars($sy); ?></td>
                                         <td>Until <?php echo htmlspecialchars($end); ?></td>
                                        <td>
                                        <a href="apply_educ.php?educid=<?php echo $educid; ?>" class="btn btn-success btn-circle">
                                                    <i class="fa fa-check"></i> Apply
                                                    </a>
                                            
                                        </td>
                                    </tr>
                                    <?php } ?>

</tbody>

										
										</table>
									</div>
								</div>
							</div>
						</div>
<!-- PREVIOUS EDUC ASS -->
<div class="col-md-12">
						
                        <div class="card">
                            <div class="card-header">
                                <div class="card-head-row">
                                    <div class="card-title">Previous Educational Assistance </div>
                                    
                                
                                
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <!--<thead>
                                            <tr>
                                                <th scope="col">Title</th>
                                                <th scope="col">Semester</th>
                                                <th scope="col">School Year</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>  -->
                                        <tbody>
                      <?php 
                                $query = "SELECT * FROM `educ aids` where status = 'Closed' order by `date` desc"; // SQL query to fetch all table data
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
                                    <td><?php echo htmlspecialchars($sem);?> SY: <?php echo htmlspecialchars($sy); ?></td>
                                    <td> Until <?php echo htmlspecialchars($end); ?></td>
                                    <td>
                                    <a  class="btn btn-danger btn-circle text-white">
                                                <i class="fa fa-times"></i> Closed
                                                </a>
                                        
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