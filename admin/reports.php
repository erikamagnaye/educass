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

    //count all approved applicants per brgy
    $stmt = $conn->prepare("
    SELECT brgy, COUNT(*) AS approved_count 
    FROM student 
    JOIN application ON student.studid = application.studid 
    WHERE application.appstatus = 'Approved'
    GROUP BY brgy
");
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize variables for each barangay with a default value of 0
    $arawan = 0;
    $bagong_niing = 0;
    $balat_atis = 0;
    $briones = 0;
    $bulihan = 0;
    $buliran = 0;
    $callejon = 0;
    $corazon = 0;
    $del_valle = 0;
    $loob= 0;
    $magsaysay = 0;
    $matipunso = 0;
    $niing = 0;
    $poblacion = 0;
    $pulo = 0;
    $pury = 0;
    $sampaga = 0;
    $sampaguita = 0;
    $san_jose = 0;
    $sintorisan = 0;

    // Fetch the approved counts and assign them to the corresponding variables
    while ($row = $result->fetch_assoc()) {
        switch ($row['brgy']) {
            case 'Arawan':
                $arawan = $row['approved_count'];
                break;
            case 'Bagong Niing':
                $bagong_niing = $row['approved_count'];
                break;
            case 'Balat Atis':
                $balat_atis = $row['approved_count'];
                break;
            case 'Briones':
                $briones = $row['approved_count'];
                break;
            case 'Bulihan':
                $bulihan = $row['approved_count'];
                break;
            case 'Buliran':
                $buliran = $row['approved_count'];
                break;
            case 'Callejon':
                $callejon = $row['approved_count'];
                break;
            case 'Corazon':
                $corazon = $row['approved_count'];
                break;
            case 'Del Valle':
                $del_valle = $row['approved_count'];
                break;
            case 'Loob':
                $loob = $row['approved_count'];
                break;
            case 'Magsaysay':
                $magsaysay = $row['approved_count'];
                break;
            case 'Matipunso':
                $matipunso = $row['approved_count'];
                break;
            case 'Niing':
                $niing = $row['approved_count'];
                break;
            case 'Poblacion':
                $poblacion = $row['approved_count'];
                break;
            case 'Pulo':
                $pulot = $row['approved_count'];
                break;
            case 'Pury':
                $pury = $row['approved_count'];
                break;
            case 'Sampaga':
                $sampaga = $row['approved_count'];
                break;
            case 'Sampaguita':
                $sampaguita = $row['approved_count'];
                break;
            case 'San Jose':
                $san_jose = $row['approved_count'];
                break;
            case 'Sintorisan':
                $sintorisan = $row['approved_count'];
                break;
            default:
                // If the barangay doesn't match any of the cases, do nothing
                break;
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'templates/header.php' ?>
        <title>Educational Assistance</title>

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
                                            <div class="card-title">Educational Assistance</div>
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
                                                </div>
                                                <br>
                                                <div class="text-center mt-5">
                                           
                                                    <table class="table table-borderless">
  <t>
                                                    
  <td>  Total Applicants:<span><?php echo $totalapp; ?></td>
  <td>Pending: <span><?php echo $pending; ?></td>
  <td>Approved : <span><?php echo $approved; ?></td>
  <td>Rejected: <span><?php echo $rejected; ?></td></tr>
</table>
                                                </div><br>

                                                <div class="col-md-12 table-responsive">

                                                    <br>

                                               

                                                    <table class="table table-bordered ">
                                                    <tr>
                                                            
                                                            <th colspan="4" style="height: 30px;text-align:center;"><h3>Approved Applicants per barangay</h3></th>
                                                        </tr>
                                                        <tr>
                                                            <th style="height: 30px;">Arawan</th>
                                                            <td style="height: 30px;"><?php echo $arawan; ?></td>
                                                            <th style="height: 30px;">Magsaysay</th>
                                                            <td style="height: 30px;"><?php echo $magsaysay; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="height: 30px;">Bagong Niing</th>
                                                            <td style="height: 30px;"><?php echo $bagong_niing; ?></td>
                                                            <th style="height: 30px;">Matipunso</th>
                                                            <td style="height: 30px;"><?php echo $matipunso; ?></td>
                                                        </tr>
                                                         <tr>
                                                            <th style="height: 30px;">Balat Atis</th>
                                                            <td style="height: 30px;"><?php echo $balat_atis; ?></td>
                                                            <th style="height: 30px;">Niing</th>
                                                            <td style="height: 30px;"><?php echo $niing; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="height: 30px;">Briones</th>
                                                            <td style="height: 30px;"><?php echo $briones; ?></td>
                                                            <th style="height: 30px;">Poblacion</th>
                                                            <td style="height: 30px;"><?php echo $poblacion; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="height: 30px;">Bulihan</th>
                                                            <td style="height: 30px;"><?php echo $bulihan; ?></td>
                                                            <th style="height: 30px;">Pulo</th>
                                                            <td style="height: 30px;"><?php echo $pulo; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="height: 30px;">Buliran</th>
                                                            <td style="height: 30px;"><?php echo $buliran; ?></td>
                                                            <th style="height: 30px;">Pury</th>
                                                            <td style="height: 30px;"><?php echo $pury; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="height: 30px;">Callejon</th>
                                                            <td style="height: 30px;"><?php echo $callejon; ?></td>
                                                            <th style="height: 30px;">Sampaga</th>
                                                            <td style="height: 30px;"><?php echo $sampaga; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="height: 30px;">Corazon</th>
                                                            <td style="height: 30px;"><?php echo $corazon; ?></td>
                                                            <th style="height: 30px;">Sampaguita</th>
                                                            <td style="height: 30px;"><?php echo $sampaguita; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="height: 30px;">Del Valle</th>
                                                            <td style="height: 30px;"><?php echo $del_valle; ?></td>
                                                            <th style="height: 30px;">San Jose</th>
                                                            <td style="height: 30px;"><?php echo $san_jose; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="height: 30px;">loob</th>
                                                            <td style="height: 30px;"><?php echo $loob; ?></td>
                                                            <th style="height: 30px;">Sinturisan</th>
                                                            <td style="height: 30px;"><?php echo $sintorisan; ?></td>
                                                        </tr>
                                                        
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