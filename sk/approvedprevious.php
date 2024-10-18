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
if (!isset($_SESSION['skid']) || strlen($_SESSION['skid']) == 0 || !in_array($_SESSION['role'], $skTypes) || !isset($_SESSION['skpos'])) {
    header('location:sklogin.php');
    exit();
} else {
    $skpos = $_SESSION['skpos'];
    $skid = $_SESSION['skid'];
    $query         = "SELECT * FROM `staff` WHERE staffid= '$skid'";
    $result     = $conn->query($query);

    if ($result->num_rows) {
        while ($row = $result->fetch_assoc()) {
            $skid = $row['staffid'];
            $firstname = $row['firstname'];
            $role = $row['position'];
            $email = $row['email'];
        }
    }

    $educreportid = mysqli_real_escape_string($conn, $_GET['educreportid']);



    //all applicants for recent assistance	

    $app = "SELECT COUNT(*) FROM application   join student on application.studid =student.studid where educid = '$educreportid' AND brgy = '$skpos'";
    $resultapp = $conn->query($app);
    $row = $resultapp->fetch_assoc();
    $totalapp = $row['COUNT(*)'];
   
    //pending applicants    
    $query2 = "SELECT COUNT(*) FROM application  join student on application.studid =student.studid where educid = '$educreportid' AND brgy = '$skpos'  and appstatus ='Pending' ";
    $result2 = $conn->query($query2);
    $row = $result2->fetch_assoc();
    $pendingapp = $row['COUNT(*)'];
    //approved applicants    
    $query3 = "SELECT  COUNT(*) FROM application  join student on application.studid =student.studid where educid = '$educreportid' AND brgy = '$skpos'  and appstatus ='Approved'";
    $result3 = $conn->query($query3);
    $row = $result3->fetch_assoc();
    $approved = $row['COUNT(*)'];
    //rejected applicants
    $query4 = "SELECT COUNT(*) FROM application  join student on application.studid =student.studid where educid = '$educreportid' AND brgy = '$skpos'  and appstatus ='Rejected'";
    $result4 = $conn->query($query4);
    $row = $result4->fetch_assoc();
    $rejected = $row['COUNT(*)'];
    //all educ assistance	provided
    $query6 = "SELECT * FROM `educ aids`";
    $result6 = $conn->query($query6);
    $totaleduc = $result6->num_rows;

    //all student each barangay
    $stud = "SELECT COUNT(*) FROM student where brgy = '$skpos' ";
    $resultstud = $conn->query($stud);
    $data = $resultstud->fetch_assoc();
    $brgystudent = $data['COUNT(*)'];
//announcement
    $announce = "SELECT COUNT(*) FROM announcement ";
    $resultann = $conn->query($announce);
    $rows = $resultann->fetch_assoc();
    $announcement = $rows['COUNT(*)'];
    //verified account
    $verified = "SELECT COUNT(*) FROM student WHERE accstatus ='Verified' and brgy='$skpos'";
    $resultvacc = $conn->query($verified);
    $row = $resultvacc->fetch_assoc();
    $vacc = $row['COUNT(*)'];
    //not verified account
    $notverified = "SELECT COUNT(*) FROM student WHERE accstatus = '' and brgy='$skpos'";
    $resultnotvacc = $conn->query($notverified);
    $row = $resultnotvacc->fetch_assoc();
    $notvacc = $row['COUNT(*)'];
    //all complaints
    $allcomplaints = "SELECT COUNT(*) as total FROM concerns join student on concerns.studid = student.studid where brgy='$skpos'";
    $resultcomp = $conn->query($allcomplaints);
    $row = $resultcomp->fetch_assoc();
    $complaints = $row["total"];

    // Initialize variables with default values
    $sy = 'N/A';
    $sem = 'N/A';

    $query1         = "SELECT * FROM `educ aids` where educid = $educreportid;";
    $result5     = $conn->query($query1);

    if ($result5->num_rows) {
        while ($row = $result5->fetch_assoc()) {
            $sem = $row['sem'];
            $sy = $row['sy'];
        }
    }

  



?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'templates/header.php' ?>
        <title>Employee Dashboard</title>
        <link rel="icon" href="assets/img/logo.png" type="image/x-icon" /> <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.min.css" />
      <!-- jQuery -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
     
        <style>
            .dashboard {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
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
                                <h2 class="text-black fw-bold">SK <?php echo $skpos ?> Dashboard</h2>


                            </div>

                        </div>

                    </div>

                    <div class="page-inner mt--2">
 
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header" style="border-radius: 1px;">
                                        <div class="card-head-row">
                                            <div class="card-title fw-regular " >Educational Assistance for SY: <?= $sy ?> for <?= $sem ?> Report for <?= $skpos ?> </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="container-fluid mt-5">
                                            
                                            <div class="dashboard">
                                                <div class="card card-primary">
                                                    <div class="card-icon" style="color: white;"> <i class="fa-solid fa-user-graduate"></i></div>
                                                    <a href="educ_report.php?educreportid=<?php echo $educreportid; ?>" class="btn">
                                                        <h5 style="color:white;"><?= $totalapp ?>  <br>All Applicants</h5>
                                                    </a>

                                                </div>
                                                <div class="card card-warning">
                                                    <div class="card-icon" style="color:white;"><i class="fa-solid fa-spinner fa-spin"></i></div>
                                                    <a href="pendingprevious.php?educreportid=<?php echo $educreportid; ?>" class="btn">
                                                        <h5 style="color:white;"><?= $pendingapp ?> <br>Pending</h5>
                                                    </a>

                                                </div>
                                                <div class="card card-success">
                                                    <div class="card-icon" style="color:white;"><i class="fa-regular fa-thumbs-up"></i></div>
                                                    <a href="approvedprevious.php?educreportid=<?php echo $educreportid; ?>" class="btn">
                                                        <h5 style="color:white;" ><?= $approved ?> <br>Approved</h5>
                                                    </a>

                                                </div>
                                                <div class="card card-danger">
                                                    <div class="card-icon" style="color:white;"><i class="fa-regular fa-thumbs-down"></i></div>
                                                    <a href="rejectedprevious.php?educreportid=<?php echo $educreportid; ?>" class="btn">
                                                        <h5 style="color:white;"><?= $rejected ?><br> Rejected</h5>
                                                    </a>
                                                </div>
                                   
                                            </div>

                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="card-head-row">
                                                            <div class="card-title">
                                                                <h2>All Applicants</h2>
                                                            </div>

                                                            <div class="card-tools">
                                                               
                                                                <a href="#" class="btn btn-success btn-border btn-round btn-sm"
                                                    title="view and print" onclick="openPrintModal()">
                                                    <i class="fa fa-eye"></i>
                                                    View
                                                </a>
                                                                <a href="model/export_previousapproved.php?educreportid=<?php echo $educreportid ?>" class="btn btn-secondary btn-border btn-round btn-sm" title="Download">
                                                                <i class="fa-solid fa-file-arrow-down"></i>
                                                                    Export CSV
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
                                                                        <th scope="col">School</th>
                                                                        <th scope="col">Status</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php

                                                                    $query = " SELECT *, CONCAT(lastname, ', ', firstname, ' ' , midname, '.' ) AS fullname FROM student join studentcourse on student.studid=studentcourse.studid 
                                                    join application on studentcourse.courseid=application.courseid 
                                                    where application.educid=$educreportid and brgy = '$skpos' and application.appstatus = 'Approved' ORDER BY lastname ASC";
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
                                                                            <td><?php echo htmlspecialchars($school_name); ?></td>
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
                                                                                <a type="button" href="view_application.php?studid=<?php echo $studid; ?>&educid=<?php echo $educreportid; ?>&appid=<?php echo $appid; ?>" class="btn btn-link btn-info" title="Edit Data">
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
                            </div>

                        </div>


                    </div>

<!--PRINT -->

                <!-- Modal -->
                <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-scrollable modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn btn-round btn-sm btn-danger"
                                    onclick="printDiv('printModalBody')"><i class="fa fa-print"></i> Print</button>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="printModalBody">
                                <!-- Content to be printed will be injected here -->
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
            unset($_SESSION['success']); ?>
        <?php endif; ?>


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
                        [2, "desc"]
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
                var educreportid = <?php echo json_encode($educreportid); ?>; // Get educreportid from PHP
                $.ajax({
                    url: 'print_approvedprevious.php', // Create this PHP file to return HTML content
                    type: 'GET',
                    data: { educreportid: educreportid },
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

        <!-- CODE FOR LINE CHART -->

    </body>

    </html><?php } ?>