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
   $studid =  $_SESSION['id'];



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Educational Assistance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
/*button color depending on status of complaint */
.btn-violet {
  background-color: #7A288A; /* violet */
  color: #fff;
}

.btn-approved {
  background-color: green; /* yellow */
  color: white;
}

.btn-danger {
  background-color: #FF0000; /* red */
  color: white;
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
								<div class="card-header bg-danger" style="border-radius: 2px;">
									<div class="card-head-row">
										<div class="card-title"style=" color: #ffffff;"><h3>My Rejected Approved Applications</h3></div>
										
									
									
									</div>
                                    <form>
           
								</div>
                                <div class="card-body">
    <?php 
    $query = "SELECT application.educid,`application`.appstatus, `application`.appid, `educ aids`.educname as educname, `educ aids`.sem as sem, `educ aids`.sy as sy, `educ aids`.status as status, `application`.appdate, `educ aids`.min_grade 
          FROM `application` 
          JOIN `educ aids` 
          ON application.educid = `educ aids`.educid 
          WHERE studid = $studid and application.appstatus = 'Rejected'
          ORDER BY `educid` DESC"; // SQL query to fetch all table data
    $view_data = mysqli_query($conn, $query); // sending the query to the database

    if (mysqli_num_rows($view_data) > 0) { // if there are results
        while ($row = mysqli_fetch_assoc($view_data)) {
            $educid = $row['educid'];
            $appid = $row['appid'];                  
            $title = $row['educname'];        
            $sem = $row['sem'];         
            $sy = $row['sy'];  
            $status = $row['status'];                
            $date = $row['appdate'];  
            $min_grade = $row['min_grade'];  
            $appstatus = $row['appstatus']; 
             
    // Determine the button color based on the status
    if ($appstatus == 'Pending') {
      $btn_color = 'btn-violet';
  } elseif ($appstatus == 'Approved') {
      $btn_color = 'btn-approved';
  } elseif ($appstatus == 'Rejected') {
      $btn_color = 'btn-danger'; // red
  } else {
      $btn_color = 'btn-default'; // default color
  }
            ?>
            <div class="card mb-2" style="border-width: 1px; border-radius: 10px;">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title mb-0"><?php echo $title . " for " . $sy . "   ". $sem; ?></h6>
                            <small class="text-muted">
    <span>Applied on: <?php echo $date;?></span>
    <span style="margin-left: 20px;">Status :  <?php echo $status;?></span>    <span style="margin-left: 20px;">Application No :  <?php echo $appid;?></span>
</small>
                        </div>
                        <div>
                        <button class="btn <?php echo $btn_color; ?>"><?php echo htmlspecialchars($appstatus); ?></button>
                                <a href="view_application.php?appid=<?php echo $appid; ?>&educid=<?php echo $educid; ?>" class="btn btn-success btn-circle" style="margin: 1px;">
                                    <i class="fa fa-eye"></i> View Application
                                </a>
                           
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
                <h4 class="card-title mb-0">No Rejected Applications as of the moment.</h4>
                <small class="text-muted" >Thank You!!</small>
            </div>
        </div>
        <?php 
    }
    ?>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
   
</body>
</html><?php }?>