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
if (!isset($_SESSION['skid']) || strlen($_SESSION['skid']) == 0 || !in_array($_SESSION['role'], $skTypes)||!isset($_SESSION['skpos'])) {
    header('location:index.php');
    exit();
} else {

    if (isset($_GET['appid']) && isset($_GET['educid'])&& isset($_GET['studid'])) {
        $appid = $_GET['appid'];
        $educid = $_GET['educid'];
        $studid = $_GET['studid'];

        $query = "SELECT *
FROM `application`
JOIN `student` ON `application`.`studid` = `student`.`studid`
JOIN `studentcourse` ON `application`.`courseid` = `studentcourse`.`courseid` and `application`.educid=`studentcourse`.educid
JOIN `parentinfo` ON `application`.`studid` = `parentinfo`.`studid`
JOIN (
  SELECT * FROM `educ aids` WHERE `educid` = $educid
) AS `educ aids` ON `application`.`educid` = `educ aids`.`educid`
WHERE `application`.`appid` = $appid AND `application`.`educid` = $educid AND `application`.`studid` = $studid";
        $view = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($view)) {
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
            $picture = $row['picture'];
          
            $accstatus = $row['accstatus'];

            $appstatus = $row['appstatus'];
            $appdate = $row['appdate'];
            $reviewedby = $row['reviewedby'];
            $appremark = $row['appremark'];

            //calculate the age based on their application date because the age is updatable
            $birthday_date = date_create($birthday);
            $appdate_date = date_create($appdate);
            $age = date_diff($birthday_date, $appdate_date);
            $age_years = $age->y;

            $educname = $row['educname'];
            $sem = $row['sem'];
            $sy = $row['sy'];

            $course = $row['course'];
            $major = $row['major'];
            $school_address = $row['school_address'];
            $school_name = $row['school_name'];
            $coursesem = $row['sem'];
            $coursesy = $row['sy'];
            $year = $row['year'];

            $parentname = $row['parentname'];
            $parentage = $row['parentage'];
            $parent_occu = $row['parent_occu'];
            $parent_income = $row['parent_income'];
            $parent_status = $row['parent_status'];
            $parent_educattain = $row['parent_educattain'];
            $parent_address = $row['parent_address'];
            $parent_contact = $row['parent_contact'];


         
        } else {
            $_SESSION['title'] = 'Error!';
           $_SESSION['message'] = 'Something went Wrong. Please, Try again!.';
            $_SESSION['success'] = 'error';
           header("Location: skdashboard.php");
            exit();
        
        }
        $req="SELECT *
        FROM `requirements` join application on requirements.reqid= application.reqid WHERE `application`.`appid` = $appid AND `requirements`.`educid` = $educid AND `requirements`.`studid` = $studid"; ;
         $viewreq = mysqli_query($conn, $req);
        
         if ($rowreq = mysqli_fetch_assoc($viewreq)) {
            $letter = $rowreq['letter'];
            $schoolid = $rowreq['schoolid'];
            $cor = $rowreq['cor'];
            $indigency = $rowreq['indigency'];
            $grades = $rowreq['grades'];
         }

    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'templates/header.php' ?>
        <title>Educational Assistance Student</title>
        <link rel="icon" href="assets/img/logo.png" type="image/x-icon"/>   <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
     
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            table {
                margin: 0 auto;
                justify-content: center;
                max-width: 90%;
            }

            th {
                font-size: 16px;

            }

            td {
                font-size: 14px;
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
                    <div class="panel-header bg-transparent-gradient">
                        <div class="page-inner">
                            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                                <div>
                                    <h2 class="text-black fw-bold">Educational Assistance Beneficiary</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-inner">
                        <div class="row mt--2">
                            <div class="col-md-12">



                                <div class="card " style="justify-content:center">
                                    <div class="card-header">
                                        <div class="card-head-row">
                                            <div class="card-title">Educational Assistance Applicant</div>
                                            <div class="card-tools">
                                                <button class="btn btn-danger btn-border btn-round btn-sm" onclick="printDiv('printThis')">
                                                    <i class="fa fa-print"></i>
                                                    Print
                                                </button>
                                              
                                                <a href="#add" data-toggle="modal" class="btn btn-info btn-border btn-round btn-sm" title="Post Assistance">
                                                    <i class="fa fa-refresh"></i>
                                                    Update Status
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body m-5" id="printThis">
                                       
                                        <div class="text-center">
                                            <img src="assets/img/logo.png" class="img-fluid" width="80" height="60">
                                        </div>
                                       <p class="mt-4 fw-bold text-center" style=""><?php echo $educname . ' SY: ' . $sy . ' ' . $sem ?></p>
                                       <p style="text-align:center">Date of Application: <?php echo $appdate ?></p>
                                       <br>



                                        <div class="row mt-2">


                                            <div class="col-md-12">

                                                <br>

                                                <table class="table table-bordered ">
                                                    <tr>
                                                        <th colspan="4" style="text-align: center;">
                                                            <h3>Applicant Information</h3>
                                                        </th>

                                                    </tr>
                                                    <tr>
                                                        <th><?php if (!empty($picture)): ?>
                                                                <img src="<?= preg_match('/data:image/i', $picture) ? $picture : '../applicants/assets/uploads/applicant_profile/' . $picture ?>" alt="Picture"
                                                                    class="avatar-img rounded-circle" style="height: 70px;width:70px;">
                                                            <?php else: ?>
                                                                <img src="assets/img/logo.png" alt="Picture" class="avatar-img rounded-circle" style="height: 70px;width:70px;">
                                                            <?php endif ?>
                                                        </th>
                                                        <td style="text-transform: uppercase;font-weight:bold;"><?php echo $firstname . ' ' . $midname . '  ' . $lastname; ?></td>
                                                        <th style=" color: red">Application No:</th>
                                                        <td style=" color: red;font-weight:bold;"><?php echo $appid; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2">PERSONAL INFORMATION</th>

                                                        <th colspan="2">PARENT INFORMATION</th>

                                                    </tr>
                                                    <tr>
                                                        <th style="height: 30px;">email</th>
                                                        <td style="height: 30px;"><?php echo $email; ?></td>
                                                        <th style="height: 30px;">Guardian</th>
                                                        <td style="height: 30px;"><?php echo $parentname; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="height: 30px;">Contact No.:</th>
                                                        <td style="height: 30px;"><?php echo $contact_no; ?></td>
                                                        <th style="height: 30px;"> Age</th>
                                                        <td style="height: 30px;"><?php echo $parentage; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="height: 30px;">Birthday:</th>
                                                        <td style="height: 30px;"><?php echo $birthday; ?></td>
                                                        <th style="height: 30px;">Occupation</th>
                                                        <td style="height: 30px;"><?php echo $parent_occu; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="height: 30px;">Age:</th>
                                                        <td style="height: 30px;"><?php echo $age_years; ?></td>
                                                        <th style="height: 30px;"> Income</th>
                                                        <td style="height: 30px;"><?php echo $parent_income; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="height: 30px;">Address:</th>
                                                        <td style="height: 30px;"><?php echo $street_name . ', ' . $brgy; ?></td>
                                                        <th style="height: 30px;">Status</th>
                                                        <td style="height: 30px;"><?php echo $parent_status; ?></td>
                                                    </tr>
                                                    <tr>
                                                     
                                                       
                                                    </tr>
                                                    <tr>
                                                    <th style="height: 30px;">Gender</th>
                                                        <td style="height: 30px;"><?php echo $gender; ?></td>
                                                        <th style="height: 30px;">Address</th>
                                                        <td style="height: 30px;"><?php echo $parent_address; ?></td>
                                                    </tr>
                                                    <tr>
                                                    <th colspan="2" style="height: 30px;"></th>
                                                        <th style="height: 30px;">Contact No</th>
                                                        <td style="height: 30px;"><?php echo $parent_contact; ?></td>
                                                    </tr>
                                                  
                                                    <tr>
                                                    <th colspan="2" style="height: 30px;">REQUIREMENTS</th>
                                                        <th colspan="2" style="height: 30px;"></th>
                                                                          
                                                    </tr>
                                                    <tr>
                                                  
                                                    <th style="height: 30px;">School ID</th>
                                                        <td style="height: 30px;"><?php if (!empty($schoolid)): ?>
                                                                <a href="<?= '../applicants/assets/uploads/requirements/schoolid/' . $schoolid ?>" target="_blank"><?php echo $schoolid ?></a>
                                                            <?php else: ?>
                                                                No School ID submitted
                                                            <?php endif ?></td>
                                                        <th colspan="2" style="height: 30px;"> COURSE INFORMATION</th>                    
                                                    </tr>
                                                    <tr>
                                                       
                                                        
                                                      
                                                    </tr>
                                                    <tr>
                                                       
                                                        
                                                    </tr>
                                                    <tr>
                                                        <th style="height: 30px;">Enrollment Form</th>
                                                        <td style="height: 30px;"><?php if (!empty($cor)): ?>
                                                                <a href="<?= '../applicants/assets/uploads/requirements/coe/' . $cor ?>" target="_blank"><?php echo $cor ?></a>
                                                            <?php else: ?>
                                                                No Enrollment form submitted
                                                            <?php endif ?></td>
                                                            <th style="height: 30px;">Course</th>
                                                        <td style="height: 30px;"><?php echo $course; ?></td>
                                                       
                                                    </tr>
                                                    <tr>
                                                        <th style="height: 30px;">Grades</th>
                                                        <td style="height: 30px;"><?php if (!empty($grades)): ?>
                                                                <a href="<?= '../applicants/assets/uploads/requirements/grades/' . $grades ?>" target="_blank"><?php echo $grades ?></a>
                                                            <?php else: ?>
                                                                No grades submitted
                                                            <?php endif ?></td>
                                                            <th style="height: 30px;">Major</th>
                                                        <td style="height: 30px;"><?php echo $major; ?></td>
                                                       
                                                    </tr>
                                                    <tr>
                                                        <th style="height: 30px;">Barangay Indigent</th>
                                                        <td style="height: 30px;"><?php if (!empty($indigency)): ?>
                                                                <a href="<?= '../applicants/assets/uploads/requirements/indigent/' . $indigency ?>" target="_blank"><?php echo $indigency ?></a>
                                                            <?php else: ?>
                                                                No barangay indigent submitted
                                                            <?php endif ?></td>
                                                            <th style="height: 30px;">Year Level</th>
                                                        <td style="height: 30px;"><?php echo $year . ' S.Y ' .$sy; ?></td>
                                                   
                                                    </tr>
                                                    <tr>
                                                        <th style="height: 30px;">Letter</th>
                                                        <td style="height: 30px;"><?php if (!empty($letter)): ?>
                                                                <a href="<?= '../applicants/assets/uploads/requirements/letter/' . $letter ?>" target="_blank"><?php echo $letter ?></a>
                                                            <?php else: ?>
                                                                No letter submitted
                                                            <?php endif ?></td>
                                                            <th style="height: 30px;">School</th>
                                                        <td style="height: 30px;"><?php echo $school_name; ?></td>
                                                    </tr>
                                                    <tr>
                                                    <th colspan="2" style="height: 30px;text-align:center">Remarks</th>
                                                   <!-- <th style="height: 30px;">Valid ID</th>
                                                        <td style="height: 30px;"> <?php if (!empty($validid)): ?>
                                                                <a href="<?= '../applicants/assets/uploads/validid_file/' . $validid ?>" target="_blank"><?php echo $validid ?></a>
                                                            <?php else: ?>
                                                                No Valid ID available
                                                            <?php endif ?>
                                                        </td>-->
                                                        <th style="height: 30px;">School Address</th>
                                                        <td style="height: 30px;"><?php echo $school_address; ?></td>
                                                    </tr> 
                                                    <tr>
                                                        
                                                        <td colspan="2" style="height: 30px;text-align:center;"> <?php echo $appremark; ?></td>   
                                                        <th style="height: 30px;">Semester</th>
                                                        <td style="height: 30px;"><?php echo $sem; ?></td>                 
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" style="height: 30px;text-transform: uppercase;text-align:center;<?php
                                                                                        if ($appstatus == 'Pending') {
                                                                                            echo 'color: #FFC107'; // yellow-orange color for pending
                                                                                        } elseif ($appstatus == 'Approved') {
                                                                                            echo 'color: #4CAF50'; // green color for approved
                                                                                        } elseif ($appstatus == 'Rejected') {
                                                                                            echo 'color: #FF0000'; // red color for rejected
                                                                                        }
                                                                                        ?>">......  Your application is  <?php echo $appstatus; ?> ......</th>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" style="height: 30px;text-transform: uppercase;text-align:center;">Reviewed and Evaluated by   <?php echo $reviewedby; ?> </th>
                                                        
                                                    </tr>

                                                </table>

   


                                                <p class="ml-3 text-center"><i>&copy Web Based Educational Assistance Application System for San Antonio, Quezon</i></p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>
          <!-- MODAL TO UPDATE Application  -->
                    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header " >
                                <h5 class="modal-title" id="exampleModalLabel">Update Application Status</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="model/updateapplication.php">
                                  
                                   
                                  
                                    <div class="form-group col-md-12">
                                        <input type="hidden" value="<?php echo $studid ?>" name="studid">
                                        <input type="hidden" value="<?php echo $educid ?>" name="educid">
                                        <input type="hidden" value="<?php echo $appid ?>" name="appid">
                                            <label>Application Status</label>
                                            <select class="form-control" id="" required name="appstatus">
                                                <option disabled value="">Select</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Approved">Approved</option>
                                                <option value="Rejected">Rejected</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                       
                                       <label>Remarks</label>
                                   
                                       <textarea class="form-control" id="validationTextarea" rows="2"  name="appremarks" required></textarea>

                                   </div>
                            </div>
                            <div class="modal-footer">
                                <!--  <input type="hidden" id="pos_id" name="id"> -->
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm" name="update">Update</button>
                            </div>

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
                                unset($_SESSION['success']);unset($_SESSION['title']); ?>
                            <?php endif; ?>
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
            <script>
                //CODE TO PRINT THE DOCUMENT
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

                // CODE TO VIEW VALID
            </script>
    </body>

    </html><?php } ?>