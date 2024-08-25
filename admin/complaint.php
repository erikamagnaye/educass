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
$allcomplaints =1;
$pending =1;
$approved =1;
$rejected =1;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Educational Assistance</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .btn-link + .btn-link {
    margin-left: 5px;
}



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
  grid-template-columns: repeat(4, 1fr);
  gap: 10px;
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
    transition: box-shadow 0.3s; 
}
.card:hover {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); 
  transform: translateY(-5px); 
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
}
/* Small screens (max-width: 768px) */
@media (max-width: 768px) {
    .dashboard {
        display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
    }
    .card {
        padding: 2px;
		display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    }
    .card-icon {
        font-size: 13px;
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
        display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
    }
    .card {
        padding: 2px;
		display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    }
    .card-icon {
        font-size: 13px;
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
        display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
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
        font-size: 10px;
    }
    h5 {
        font-size: 10px;
		overflow-wrap: break-word; /* Add this line to break long text */
		word-wrap: break-word;
		word-break: break-all;
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
								<h2 class="text-black fw-bold">Applicant Portal</h2>
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
										<div class="card-title">Concerns/Queries</div>
										
											<div class="card-tools">
                                          
												<a href="#add" data-toggle="modal" class="btn btn-info btn-border btn-round btn-sm" title="Post Assistance">
													<i class="fa fa-plus"></i>
													File Concerns
												</a>
											</div>
									
									</div>
								</div>
								<div class="card-body col-md-12">
<div container-fluid>
<div class="dashboard">
        <div class="card">
            <div class="card-icon" style="color:orange;"><i class="fa-solid fa-clipboard-question"></i></div>
          <a href="all_applications.php" class="btn">  <h5><?= $allcomplaints ?> <br>All Complaints</h5></a>
          
        </div>
        <div class="card">
            <div class="card-icon" style="color:violet;"><i class="fa-solid fa-hourglass-end"></i></div>
			<a href="applications.php" class="btn"><h5><?= $pending ?> <br>Pending</h5></a>
         
        </div>
        <div class="card">
            <div class="card-icon" style="color:yellow;"><i class="fa fa-spinner fa-spin"></i></div>
			<a href="applications.php" class="btn"><h5><?= $approved ?> <br>In Process</h5></a>
     
        </div>
        <div class="card">
            <div class="card-icon" style="color:red;"><i class="fa-solid fa-gavel"></i></div>
			<a href="applications.php" class="btn"> <h5><?=$rejected?><br> Closed</h5></a>
           
        </div> 
    </div>
</div>
   


</div>
    
    
									<div class="table-responsive">




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
                                            <a type="button" href="edit_educ.php?update&educid=<?php echo $educid; ?>"   class="btn btn-link btn-success mr-1" 
                                                title="view report">
                                                <i class="fa fa-file"></i>

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