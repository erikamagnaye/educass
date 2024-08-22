<?php include 'server/server.php' ?>

<?php 

session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0)) {
	header('location:login.php');
    exit();
}
else {
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





?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Educational Assistance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
       
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
        /* Add this to your CSS file */

/* For small cellphone sizes (max-width: 320px) */
@media (max-width: 320px) {
  .table-responsive {
    overflow-x: auto; /* Add horizontal scrolling if table is too wide */
  }
  .table-responsive table {
    margin-right: 2px; /* Reduce margin right to 5px */
  }
}

/* For medium cellphone sizes (max-width: 480px) */
@media (max-width: 480px) {
  .table-responsive {
    overflow-x: auto; /* Add horizontal scrolling if table is too wide */
  }
  .table-responsive table {
    margin-right: 2px; /* Reduce margin right to 10px */
  }
}

/* For large cellphone sizes (max-width: 640px) */
@media (max-width: 640px) {
  .table-responsive {
    overflow-x: auto; /* Add horizontal scrolling if table is too wide */
  }
  .table-responsive table {
    margin-right: 4px; /* Reduce margin right to 15px */
  }
}

/* For tablet sizes (max-width: 768px) */
@media (max-width: 768px) {
  .table-responsive {
    overflow-x: auto; /* Add horizontal scrolling if table is too wide */
  }
  .table-responsive table {
    margin-right: 5px; /* Reduce margin right to 20px */
  }
}

/* For desktop sizes (min-width: 992px) */
@media (min-width: 992px) {
  .table-responsive {
    overflow-x: hidden; /* Remove horizontal scrolling */
  }
  .table-responsive table {
    margin-right:5px; /* Reset margin right to 30px */
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
								<div class="card-header bg-success" style="border-radius: 2px;">
									<div class="card-head-row">
										<div class="card-title"style=" color: #ffffff;"><h3>Available Educational Assistance </h3></div>
										
  
									
									</div>
                                    <form>
           
								</div>
                                <div class="card-body">
    <?php 
    $query = "SELECT * FROM `educ aids` where status = 'Open' order by `date` desc"; // SQL query to fetch all table data
    $view_data = mysqli_query($conn, $query); // sending the query to the database

    if (mysqli_num_rows($view_data) > 0) { // if there are results
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

             // Check if student has already applied
             $check_query = "SELECT * FROM `application` WHERE `studid` = '$studid' AND `educid` = '$educid'";
             $check_result = mysqli_query($conn, $check_query);
             if (mysqli_num_rows($check_result) > 0) {
                $appid_row = mysqli_fetch_assoc($check_result);
                $appid = $appid_row['appid'];
                $has_applied = true;
            } else {
                $has_applied = false;
                $appid = null;
            }
 
            ?>
            <div class="card mb-2" style="border-width: 1px; border-radius: 10px;">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title mb-0"><?php echo $title . " for " . $sy . "   ". $sem ." is open from ". $start . " until " . $end; ?></h6>
                            <small class="text-muted">Posted on: <?php echo $date;?></small>
                        </div>
                        <div>
                            <?php if ($has_applied) { ?>
                                <a href="view_application.php?appid=<?php echo $appid; ?>&educid=<?php echo $educid; ?>" class="btn btn-success btn-circle" style="margin: 1px;">
                                    <i class="fa fa-eye"></i> View Application
                                </a>
                            <?php } else { ?>
                                <a href="apply_educ.php?educid=<?php echo $educid; ?>" class="btn btn-success btn-circle" style="margin: 1px;">
                                    <i class="fa fa-check"></i> Apply Now
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
        }
    } else { // if there are no results
        ?>
        <div class="card mb-2" style="border-width: 1px; border-radius: 10px;">
            <div class="card-body py-2"style="text-align: center;">
                <h4 class="card-title mb-0">No available Educational assistances yet.</h4>
                <small class="text-muted" >Check back later for new opportunities.</small>
            </div>
        </div>
        <?php 
    }
    ?>
</div>
								</div>
							</div>
						


<!-- PREVIOUS EDUC ASS -->
<div class="col-md-12">
						<br>
                        <div class="card">
                            <div class="card-header bg-danger" style="border-radius: 2px;">
                                <div class="card-head-row">
                                    <div class="card-title" style=" color: #ffffff;"><h3>Previous Educational Assistance</h3> </div>
                                    
                                
                                
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                       <thead>
                                           <tr>
													<th scope="col">Assistance</th>
													<th scope="col">Semester</th>
													<th scope="col">Due</th>
													<th>Status</th>
													
													
												</tr>
                                        </thead>  
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
                                    <td><?php echo htmlspecialchars($title); ?></td>
                                    <td><?php echo htmlspecialchars($sem);?></td>
                                    <td><?php echo htmlspecialchars($end); ?></td>
                                    <td style="color: red;">Closed
                                     <!-- <a  class="btn btn-danger btn-circle text-white">
                                              <i class="fa fa-times"></i>  Closed
                                                </a>-->
                                        
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
                                unset($_SESSION['success']); ?>
                            <?php endif; ?>
			<!-- Main Footer -->
			<?php include 'templates/main-footer.php' ?>
			<!-- End Main Footer -->
			
		</div>
		
	</div>

	<?php include 'templates/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html><?php }?>