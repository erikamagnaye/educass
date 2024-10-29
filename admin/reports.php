<?php include 'server/server.php' ?>

<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'Admin') {
    header('location:login.php');
    exit();
} else {
    //get the recent educational
    $query = "SELECT * FROM `educ aids` ORDER BY date DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $data = $stmt->get_result();
    // Check if the query was successful
    if ($data) {
        // Fetch all the rows from the result
        while ($row = $data->fetch_assoc()) {

            $recenteduc = $row['educid'];
            $educname = $row['educname'];
            $sem = $row['sem'];
            $sy = $row['sy'];
        }
    }

    $app = "SELECT COUNT(*) FROM application  where educid = '$recenteduc'";
    $resultapp = $conn->query($app);
    $row = $resultapp->fetch_assoc();
    $totalapp = $row['COUNT(*)'];
    //pending applicants    
    $query2 = "SELECT COUNT(*) FROM application  where educid = '$recenteduc'  and appstatus ='Pending' ";
    $result2 = $conn->query($query2);
    $row = $result2->fetch_assoc();
    $pending = $row['COUNT(*)'];
    //approved applicants    
    $query3 = "SELECT  COUNT(*) FROM application  where educid = '$recenteduc'  and appstatus ='Approved'";
    $result3 = $conn->query($query3);
    $row = $result3->fetch_assoc();
    $approved = $row['COUNT(*)'];
    //rejected applicants
    $query4 = "SELECT COUNT(*) FROM application  where educid = '$recenteduc'  and appstatus ='Rejected'";
    $result4 = $conn->query($query4);
    $row = $result4->fetch_assoc();
    $rejected = $row['COUNT(*)'];




    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'templates/header.php' ?>
        <title>Educational Assistance</title>
        <link rel="icon" href="assets/img/logo.png" type="image/x-icon" /> <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            /* Table styles */
            .table {
                font-size: 14px;
            }

            .table th,
            .table td {
                font-size: 12px;
            }

            .table h2 {
                font-size: 18px;
            }

            /* Responsive styles */
            @media only screen and (max-width: 768px) {

                /* Tablet and mobile styles */
                .card-body {
                    padding: 1rem;
                }

                .table-responsive {
                    overflow-x: auto;
                }

                .table {
                    font-size: 12px;
                }

                .table th,
                .table td {
                    font-size: 10px;
                }

                h3,
                p {
                    font-size: 10px;
                }

                img {
                    width: 20%;
                    height: auto;
                }
            }

            @media only screen and (max-width: 480px) {

                /* Mobile styles */
                .card-body {
                    padding: 0.5rem;
                }

                .table-responsive {
                    overflow-x: auto;
                }

                .table {
                    font-size: 10px;
                }

                .table th,
                .table td {
                    font-size: 8px;
                }

                h3,
                p {
                    font-size: 10px;
                }

                img {
                    width: 20%;
                    height: auto;
                }
            }

            .TEXT {
                margin: 50px;
                font-size: 14px;
            }

            @media only screen and (max-width: 768px) {
  .TEXT {
    font-size: 16px;
    margin: 10px;
  }
}

@media only screen and (max-width: 480px) {
  .TEXT {
    font-size: 14px;
    margin: 5px;
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
                    <div class="panel-header bg-transparent-gradient">
                        <div class="page-inner">
                            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                                <div>
                                    <h2 class="text-black fw-bold">Educational Assistance</h2>
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
                                            <div class="card-title">Report</div>
                                            <div class="card-tools">
                                                <button class="btn btn-info btn-border btn-round btn-sm"
                                                    onclick="printDiv('printThis')">
                                                    <i class="fa fa-print"></i>
                                                    Print
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body m-5" id="printThis">
                                        <div class="d-flex flex-wrap justify-content-around"
                                            style="border-bottom:1px solid green">
                                            <div class="text-center">
                                                <img src="assets/img/logo.png" class="img-fluid" width="100">
                                            </div>
                                            <div class="text-center">
                                                <h3 class="mb-0">Republic of the Philippines</h3>
                                                <h3 class="mb-0">Province of Quezon</h3>
                                                <h3 class="fw-bold mb-0">San Antonio</h3>
                                                <p><i>Mobile No.0923333</i></p>
                                            </div>
                                            <div class="text-center">
                                                <img src="assets/img/quezon.png" class="img-fluid" width="100">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <div class="text-center mt-5">
                                                    <h3 class="mt-4 fw-bold">
                                                        <?php echo $educname . ' for ' . $sem . ' ' . $sy . ' '; ?> for San
                                                        Antonio, Quezon</h3>
                                                        <h6>Approved</h6>
                                                </div>
                                                <br>
                                             <!--   <div class="text-center mt-5">
                                           
                                                    <table class="table table-borderless">
  <t>
                                                    
  <td>  Total Applicants:<span><?php echo $totalapp; ?></td>
  <td>Pending: <span><?php echo $pending; ?></td>
  <td>Approved : <span><?php echo $approved; ?></td>
  <td>Rejected: <span><?php echo $rejected; ?></td></tr>
</table>
                                                </div><br>-->

                                                <div class="col-md-12 table-responsive">
                                                <div>
<h6 style="text-align:justify; margin-left:10px"><bold> Total Applicants :<span><?php echo $totalapp;?></span></bold></h6>
</div>
<?php
                                    // Count all approved applicants per brgy with year level and gender 
$stmt = $conn->prepare("
SELECT 
    student.brgy,
    COUNT(*) AS approved_count,
    SUM(CASE WHEN student.gender = 'Male' THEN 1 ELSE 0 END) AS male_count,
    SUM(CASE WHEN student.gender = 'Female' THEN 1 ELSE 0 END) AS female_count,
    SUM(CASE WHEN studentcourse.year = 'First Year' THEN 1 ELSE 0 END) AS first_year_count,
    SUM(CASE WHEN studentcourse.year = 'Second Year' THEN 1 ELSE 0 END) AS second_year_count,
    SUM(CASE WHEN studentcourse.year = 'Third Year' THEN 1 ELSE 0 END) AS third_year_count,
    SUM(CASE WHEN studentcourse.year = 'Fourth Year' THEN 1 ELSE 0 END) AS fourth_year_count
FROM student 
JOIN studentcourse ON student.studid = studentcourse.studid
JOIN application ON student.studid = application.studid 
WHERE application.appstatus = 'Approved' AND application.educid = ?
GROUP BY student.brgy
");
$stmt->bind_param("i", $recenteduc);
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to hold counts for each barangay
$applicantData = [];

// Fetch and store counts into the array
while ($row = $result->fetch_assoc()) {
    $applicantData[$row['brgy']] = [
        'approved_count' => $row['approved_count'],
        'male_count' => $row['male_count'],
        'female_count' => $row['female_count'],
        'first_year_count' => $row['first_year_count'],
        'second_year_count' => $row['second_year_count'],
        'third_year_count' => $row['third_year_count'],
        'fourth_year_count' => $row['fourth_year_count'],
    ];
}

// Access data for each barangay in your table
$barangays = ['Arawan', 'Bagong Niing', 'Balat Atis', 'Briones', 'Bulihan', 'Buliran', 'Callejon', 'Corazon', 'Del Valle', 'Loob', 'Magsaysay', 'Matipunso', 'Niing', 'Poblacion', 'Pulo', 'Pury', 'Sampaga', 'Sampaguita', 'San Jose', 'Sintorisan'];
?>

<div class="col-md-12 table-responsive">
    <table class="table table-borderless">
        <thead>
            <tr>
                <th scope="col">Barangay</th>
                <th scope="col">No. of Applicants</th>
                <th scope="col">Male</th>
                <th scope="col">Female</th>
                <th scope="col">1st Year</th>
                <th scope="col">2nd Year</th>
                <th scope="col">3rd Year</th>
                <th scope="col">4th Year</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($barangays as $barangay) {
                $data = $applicantData[$barangay] ?? [
                    'approved_count' => 0,
                    'male_count' => 0,
                    'female_count' => 0,
                    'first_year_count' => 0,
                    'second_year_count' => 0,
                    'third_year_count' => 0,
                    'fourth_year_count' => 0
                ];
                echo "<tr>
                    <th style='height:40px;'>{$barangay}</th>
                    <td style='height:40px;'>{$data['approved_count']}</td>
                    <td style='height:40px;'>{$data['male_count']}</td>
                    <td style='height:40px;'>{$data['female_count']}</td>
                    <td style='height:40px;'>{$data['first_year_count']}</td>
                    <td style='height:40px;'>{$data['second_year_count']}</td>
                    <td style='height:40px;'>{$data['third_year_count']}</td>
                    <td style='height:40px;'>{$data['fourth_year_count']}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

                                                 
                                                </div>
                                                <p class="ml-3 text-center"><i>&copy Web Based Educational Assistance
                                                        Application System for San Antonio, Quezon</i></p>
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
        <script>
            function openModal() {
                $('#pment').modal('show');
            }
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
    </body>

    </html><?php } ?>