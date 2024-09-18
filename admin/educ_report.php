<?php include 'server/server.php' ?>
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'admin') {
    header('location:login.php');
    exit();
} else {


    $id = $_SESSION['id'];
    $query = "SELECT * FROM `admin` join staff on staff.staffid=admin.empid WHERE adminid= '$id'";
    $result = $conn->query($query);

    if ($result->num_rows) {
        while ($row = $result->fetch_assoc()) {
            $adminid = $row['adminid'];
            $username = $row['username'];
            $role = $row['position'];
        }
    }

    //get the recent educational
    $query = "SELECT educid FROM `educ aids` ORDER BY date DESC LIMIT 1";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $recent = $row['educid'];

    //all applicants for recent assistance	

    $educreportid = mysqli_real_escape_string($conn, $_GET['educreportid']);

    $app = "SELECT COUNT(*) FROM application  where educid = '$educreportid'";
    $resultapp = $conn->query($app);
    $row = $resultapp->fetch_assoc();
    $totalapp = $row['COUNT(*)'];
    //pending applicants    
    $query2 = "SELECT COUNT(*) FROM application  where educid = '$educreportid'  and appstatus ='Pending' ";
    $result2 = $conn->query($query2);
    $row = $result2->fetch_assoc();
    $pending = $row['COUNT(*)'];
    //approved applicants    
    $query3 = "SELECT  COUNT(*) FROM application  where educid = '$educreportid'  and appstatus ='Approved'";
    $result3 = $conn->query($query3);
    $row = $result3->fetch_assoc();
    $approved = $row['COUNT(*)'];
    //rejected applicants
    $query4 = "SELECT COUNT(*) FROM application  where educid = '$educreportid'  and appstatus ='Rejected'";
    $result4 = $conn->query($query4);
    $row = $result4->fetch_assoc();
    $rejected = $row['COUNT(*)'];


    // Initialize variables with default values
    $sy = 'N/A';
    $sem = 'N/A';

    $query1 = "SELECT * FROM `educ aids` where educid = '$educreportid' ;";
    $result5 = $conn->query($query1);

    if ($result5->num_rows) {
        while ($row = $result5->fetch_assoc()) {
            $sem = $row['sem'];
            $sy = $row['sy'];
        }
    }

    // Retrieve data from database  THIS IS FOR PIE CHART FOR APPLICANTS PER BRGY

    // Fetch the most recent educational assistance ID based on the date
// Retrieve data from database for pie chart

    $stmt = $conn->prepare("SELECT student.brgy, COUNT(*) AS count 
    FROM student 
    JOIN application ON student.studid = application.studid
    JOIN `educ aids` ON application.educid = `educ aids`.educid 
    WHERE `educ aids`.educid = ? 
    GROUP BY student.brgy 
    ORDER BY brgy ASC");
    $stmt->bind_param("i", $educreportid);
    $stmt->execute();
    $result = $stmt->get_result();

    $dataArray = array();
    $dataArray[] = ['Barangay', 'Number of Applicants'];

    // Format data for Google Charts
    while ($row = $result->fetch_assoc()) {
        $dataArray[] = [$row['brgy'], (int) $row['count']];
    }
    // END OF CODE FOR PIE CHART


    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'templates/header.php' ?>
        <title>Admin Dashboard</title>
        <link rel="icon" href="assets/img/logo.png" type="image/x-icon" />
        <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
     
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            // Load the Visualization API and the corechart package
            google.charts.load('current', {
                'packages': ['corechart']
            });

            // Set a callback to run when the Google Visualization API is loaded
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                // Create the data table
                var data = google.visualization.arrayToDataTable(<?= json_encode($dataArray) ?>);

                // Set chart options
                var options = {
                    title: 'Number of Applicants per Barangay',
                    is3D: true
                };

                // Instantiate and draw the chart, passing in some options
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        </script>


        <!--START OF CODE FOR bar chart CHART TO DISPLAY ALL APPLICANTS PER year level-->

        <?php
        // Execute the query to retrieve the data
        $stmt = $conn->prepare("SELECT sc.year, COUNT(*) AS count 
        FROM application 
        JOIN studentcourse sc ON application.courseid = sc.courseid 
        WHERE application.educid = ? 
        GROUP BY sc.year 
        ORDER BY sc.year ASC");
        $stmt->bind_param("i", $educreportid);
        $stmt->execute();
        $result = $stmt->get_result();

        // Create an array to store the data for the chart
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = array($row['year'], $row['count']);
        }

        // Close the database connection
    
        ?>
        <script type="text/javascript">
            // Load the Google Charts library
            google.charts.load('current', {
                'packages': ['bar']
            });
            google.charts.setOnLoadCallback(drawbarChart);

            // Draw the chart
            function drawbarChart() {
                // Create the data table
                var data = google.visualization.arrayToDataTable([
                    ['Year', 'Applicants'],
                    <?php foreach ($data as $row) { ?>['<?php echo $row[0]; ?>', <?php echo $row[1]; ?>],
                    <?php } ?>
                ]);

                // Create the chart options
                var options = {
                    title: 'Applicants per Year Level',
                    chartArea: {
                        width: '40%',
                        height: '20%'
                    },
                    hAxis: {
                        minValue: 0
                    },
                    vAxis: {
                        title: ''
                    }
                };

                // Create the chart
                var chart = new google.visualization.BarChart(document.getElementById('barchart_div'));
                chart.draw(data, options);
            }
        </script>
        </script>
        <style>

            .dashboard {
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 15px;
                align-items: center;
            }

            .card {
                background: #ffffff;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 5px;
                text-align: center;
                display: flex;
                flex-direction: column;

            }

            .card-icon {
                font-size: 20px;
                color: #4CAF50;
            }

            h5 {
                margin: 5px 0 5px;
                word-wrap: break-word;
                overflow-wrap: break-word;
                word-break: break-all;
            }

            .card-title {
                font-size: 18px;
            }

            /* Small screens (max-width: 768px) */
            @media (max-width: 768px) {
                .dashboard {
                    grid-template-columns: repeat(2, 1fr);
                }

                .card {
                    padding: 5px;
                    display: flex;
                    flex-direction: column;

                    text-align: center;
                }

                .card-icon {
                    font-size: 14px;
                }

                h5 {
                    font-size: 14px;
                    overflow-wrap: break-word;
                    /* Add this line to break long text */
                    word-wrap: break-word;
                    word-break: break-all;
                }

                .card-title {
                    font-size: 12px;
                }
            }

            /* Extra small screens (max-width: 480px) */
            @media (max-width: 480px) {
                .dashboard {
                    grid-template-columns: repeat(2, 1fr);
                }

                .card {
                    padding: 2px;
                    display: flex;
                    flex-direction: column;

                    text-align: center;
                }

                .card-icon {
                    font-size: 12px;
                }

                h5 {
                    font-size: 12px;
                    overflow-wrap: break-word;
                    /* Add this line to break long text */
                    word-wrap: break-word;
                    word-break: break-all;
                }

                .card-title {
                    font-size: 10px;
                }
            }

            /* Extra extra small screens (max-width: 320px) */
            @media (max-width: 320px) {
                .dashboard {
                    grid-template-columns: repeat(2, 1fr);
                }

                .card {
                    padding: 1px;
                    display: flex;
                    flex-direction: column;

                    text-align: center;
                }

                .card-icon {
                    font-size: 10px;
                }

                h5 {
                    font-size: 10px;
                    overflow-wrap: break-word;
                    /* Add this line to break long text */
                    word-wrap: break-word;
                    word-break: break-all;
                }

                .card-title {
                    font-size: 10px;
                }
            }

            /*second card */
            .stats-dashboard {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 15px;
                align-items: center;
            }

            .stats-card {
                background: #ffffff;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 5px;
                text-align: center;
                display: flex;
                flex-direction: column;
            }

            .stats-card-icon {
                font-size: 20px;
                color: #4CAF50;
            }

            h5 {
                margin: 5px 0 5px;
                word-wrap: break-word;
                overflow-wrap: break-word;
                word-break: break-all;
            }

            .stats-card-title {
                font-size: 18px;
            }

            /* Small screens (max-width: 768px) */
            @media (max-width: 768px) {
                .stats-dashboard {
                    grid-template-columns: repeat(2, 1fr);
                }

                .stats-card {
                    padding: 5px;
                    display: flex;
                    flex-direction: column;
                    text-align: center;
                }

                .stats-card-icon {
                    font-size: 14px;
                }

                h5 {
                    font-size: 14px;
                    overflow-wrap: break-word;
                    /* Add this line to break long text */
                    word-wrap: break-word;
                    word-break: break-all;
                }

                .stats-card-title {
                    font-size: 12px;
                }
            }

            /* Extra small screens (max-width: 480px) */
            @media (max-width: 480px) {
                .stats-dashboard {
                    grid-template-columns: repeat(2, 1fr);
                }

                .stats-card {
                    padding: 2px;
                    display: flex;
                    flex-direction: column;
                    text-align: center;
                }

                .stats-card-icon {
                    font-size: 12px;
                }

                h5 {
                    font-size: 12px;
                    overflow-wrap: break-word;
                    /* Add this line to break long text */
                    word-wrap: break-word;
                    word-break: break-all;
                }

                .stats-card-title {
                    font-size: 10px;
                }
            }

            /* Extra extra small screens (max-width: 320px) */
            @media (max-width: 320px) {
                .stats-dashboard {
                    grid-template-columns: repeat(2, 1fr);
                }

                .stats-card {
                    padding: 1px;
                    display: flex;
                    flex-direction: column;
                    text-align: center;
                }

                .stats-card-icon {
                    font-size: 10px;
                }

                h5 {
                    font-size: 10px;
                    overflow-wrap: break-word;
                    /* Add this line to break long text */
                    word-wrap: break-word;
                    word-break: break-all;
                }

                .stats-card-title {
                    font-size: 10px;
                }
            }

            /*end  of secong dashboard cards*/
            .piechart,
            .barchart {
                width: 100%;
                height: 350px;
                border: 1px solid lightgrey;
                box-sizing: border-box;
                font-size: 16px;
                margin: 0 auto;
            }

            @media (max-width: 767.98px) {

                .piechart,
                .barchart {
                    height: 250px;
                    overflow: hidden;
                    font-size: 13px;
                    align-items: justify;
                    margin: 0 auto;
                }
            }

            @media (min-width: 768px) and (max-width: 991.98px) {

                .piechart,
                .barchart {
                    height: 300px;
                    overflow: hidden;
                    font-size: 13px;
                    margin: 0 auto;
                }
            }

            @media (min-width: 992px) {

                .piechart,
                .barchart {
                    height: 350px;
                    overflow: hidden;
                    font-size: 13px;
                    margin: 0 auto;
                }
            }

            /*line chart */
            .linechart {
                width: 100%;
                height: 350px;

            }
        </style>
    </head>

    <body>
        <? //php include 'templates/loading_screen.php' 
            ?>

        <div class="wrapper">
            <!-- Main Header -->
            <?php include 'templates/main-header.php' ?>
            <!-- End Main Header -->

            <!-- Sidebar -->
            <?php include 'templates/sidebar.php' ?>
            <!-- End Sidebar -->

            <div class="main-panel">
                <div class="content">
                    <div class="page-inner">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-black fw-bold">Admin Dashboard</h2>


                            </div>

                        </div>

                    </div>

                    <div class="page-inner mt--2">




                        <div class="row">
                            <div class="col-md-12">
                                <div class="card" style="padding:0px; margin:0px;">
                                    <!-- <div class="card-header card-header-border bg-success" style="border-radius: 8px;">
                                    <div class="card-head-row">
                                        <div class="card-title fw" style=" color: #ffffff;">EUCATIONAL ASSISTANCE APPLICATION SYSTEM</div>
                                    </div>
                                </div>-->



                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header ">
                                        <div class="card-head-row">
                                            <div class="card-title fw-regular ">Educational Assistance for SY: <?= $sy ?>
                                                for <?= $sem ?> Report</div>
                                                <div class="card-tools">
                                            <a href="educass.php" class="btn btn-danger btn-border btn-round btn-sm" title="view and print">
												<i class="fa fa-chevron-left"></i>
												Back
											</a>
                                         
											</div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="container-fluid mt-5">
                                            <div class="stats-dashboard">
                                                <div class="stats-card bg-primary mb-2">
                                                    <div class="stats-card-icon" style="color: white;"><i
                                                            class="fa-solid fa-user-graduate"></i></div>
                                                    <a href="educ_report_applicants.php?educreportid=<?php echo $educreportid ?>"
                                                        class="btn">
                                                        <h5 style="color: white;"><?= $totalapp ?> <br>Applicants</h5>
                                                    </a>
                                                </div>
                                                <div class="stats-card bg-warning mb-2">
                                                    <div class="stats-card-icon" style="color: white;"><i
                                                            class="fa-solid fa-spinner fa-spin"></i></div>
                                                    <a href="educ_report_pending_applicants.php" class="btn">
                                                        <h5 style="color: white;"><?= $pending ?> <br> Pending</h5>
                                                    </a>
                                                </div>
                                                <div class="stats-card bg-success mb-2">
                                                    <div class="stats-card-icon" style="color: white;"><i
                                                            class="fa-regular fa-thumbs-up"></i></div>
                                                    <a href="educ_report_approved_applicants.php" class="btn">
                                                        <h5 style="color: white;"><?= $approved ?> <br> Approved</h5>
                                                    </a>
                                                </div>
                                                <div class="stats-card bg-danger mb-2">
                                                    <div class="stats-card-icon" style="color: white;"><i
                                                            class="fa-regular fa-thumbs-down"></i></div>
                                                    <a href="educ_report_rejected_applicants.php" class="btn">
                                                        <h5 style="color: white;"><?= $rejected ?> <br> Rejected</h5>
                                                    </a>
                                                </div>
                                            </div>



                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">

                                                <div id="piechart_3d" class="piechart"></div>

                                            </div>
                                            <div class="col-md-6 mb-3">

                                                <div id="barchart_div" class="barchart"></div>

                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card" style="padding:0px; margin:0px;">
                                                    <div class="card-header card-header-border ">
                                                        <div class="card-head-row">
                                                            <div class="card-title fw">All submitted files of applicants
                                                            </div>
                                                            <div class="card-tools">
                                         
                                                            <a type="button" href="javascript:void(0);"
                                                                    onclick="confirmDeleteall(<?php echo $educreportid; ?>)"
                                                                    class="btn  btn-outline-danger  mr-1" title="Remove">
                                                                    <i class="fa fa-trash"></i> Delete all
                                                                </a>


                                                                <script>
                                                                    function confirmDeleteall(educreportid) {
                                                                        Swal.fire({
                                                                            title: "Are you sure?",
                                                                            text: "You want to delete all files?",
                                                                            icon: "warning",
                                                                            showCancelButton: true,
                                                                            confirmButtonColor: "#DD6B55",
                                                                            confirmButtonText: "Yes, delete it!",
                                                                            cancelButtonText: "Cancel",
                                                                            closeOnConfirm: true
                                                                        }).then((result) => {
                                                                            if (result.isConfirmed) {
                                                                                window.location.href = 'deleteall.php?deleteid=' + educid + '&confirm=true';
                                                                            }
                                                                        });
                                                                    }
                                                                </script>
                                        </td>
												
											</div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body" style="text-align:justify;font-size:10px;">
                                                        
										<table id="dataTable" class="table table-striped">
											<thead>
												<tr>
													<th scope="col">No</th>
													<th >Student</th>
                                                    <th >Barangay</th>
													<th >School ID</th>
													<th >Grades</th>
													<th >Enrollment Form</th>
													<th >Indigency</th>
                                                    <th >Letter</th>
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
                                    $query = "SELECT * FROM `requirements` join student on requirements.studid=student.studid 
                                    join application on requirements.reqid=application.reqid
                                    where requirements.educid ='$educreportid'"; // SQL query to fetch all table data
                                    $view_data = mysqli_query($conn, $query); // sending the query to the database

                                    // displaying all the data retrieved from the database using while loop
                                    $count=1;
                                    while ($row = mysqli_fetch_assoc($view_data)) {
                                        $studid = $row['studid'];                
                                        $lastname = $row['lastname'];        
                                        $firstname = $row['firstname'];         
                                        $midname = $row['midname'];  
                                        $letter = $row['letter'];           
                                        $schoolid = $row['schoolid'];        
                                        $grades = $row['grades'];         
                                        $cor = $row['cor'];  
                                        $indigency = $row['indigency'];  
                                         $brgy = $row['brgy']; 
                                    ?>
                                  <tr>
    
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo htmlspecialchars($lastname. ' ' . $firstname . ' ' . $midname); ?></td>
                                        <td><?php echo htmlspecialchars($brgy);?></td>
                                        <td><?php if (!empty($schoolid)): ?>   <a href="<?= '../applicants/assets/uploads/requirements/schoolid/' . $schoolid ?>" target="_blank">School ID</a>  <?php endif; ?></td>
                                        <td><?php if (!empty($grades)): ?>   <a href="<?= '../applicants/assets/uploads/requirements/grades/' . $grades?>" target="_blank"><?//php echo $grades ?> Grades</a>  <?php endif; ?></td>
                                        <td><?php if (!empty($cor)): ?>   <a href="<?= '../applicants/assets/uploads/requirements/coe/' . $cor ?>" target="_blank"><?//php echo $cor ?>Enrollment form</a>  <?php endif; ?></td>
                                        <td><?php if (!empty($indigency)): ?>   <a href="<?= '../applicants/assets/uploads/requirements/indigent/' . $indigency ?>" target="_blank"><?//php echo $indigency ?>Indigent</a>  <?php endif; ?></td>
                                        <td><?php if (!empty($letter)): ?>   <a href="<?= '../applicants/assets/uploads/requirements/letter/' . $letter ?>" target="_blank"><?//php echo $letter ?> letter</a>  <?php endif; ?></td>

                                            <td>
                       
                                            <a type="button" href="javascript:void(0);"
                                                                    onclick="confirmDeletion(<?php echo $educreportid; ?>, <?php echo $studid ?>)"
                                                                    class="btn btn-link btn-danger mr-1" title="Remove">
                                                                    <i class="fa fa-times"></i>
                                                                </a>


                                                                <script>
                                                                    function confirmDeletion(educreportid, studid) {
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
                                                                                window.location.href = 'deletefile.php?deleteid=' + educreportid + '&studid=' + studid + '&confirm=true';
            }
                                                                        });
                                                                    }
                                                                </script>
                                        </td>
                                    </tr>
                                    <?php $count++; } ?>

</tbody>

										
										</table>
                                                    </div>

                                                </div>
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


        </div>

        </div>

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
                    "scrollX": "300px", // Add this option to enable vertical scrolling
            "scrollCollapse": true, // Add this option to collapse the table when scrolling
        });
            });
        </script>

        <script type="text/javascript">
            google.charts.load("current", {
                packages: ["corechart"]
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable(<?php echo json_encode($dataArray); ?>);

                var options = {
                    title: 'Applicants Per Barangay',
                    is3D: true,
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                chart.draw(data, options);
            }
        </script>


    </body>

    </html><?php } ?>