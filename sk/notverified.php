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

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'templates/header.php' ?>
        <title>Educational Assistance</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>


        </style>

    </head>

    <body>
    

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
                                    <h2 class="text-black fw-bold">Admin</h2>
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
                                            <div class="card-title" style="color:red;">Not Verified Accounts</div>

                                            <div class="card-tools">
                                                <a href="viewstudent.php" class="btn btn-success btn-border btn-round btn-sm" title="view and print">
                                                    <i class="fa fa-eye"></i>
                                                    View
                                                </a>
                                                <a href="model/export_student_csv.php" class="btn btn-danger btn-border btn-round btn-sm" title="Download">
                                                    <i class="fa fa-file"></i>
                                                    Export CSV
                                                </a>
                                               
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="myTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">No</th>
                                                        <th scope="col">Student</th>
                                                        <th scope="col">Barangay</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Gender</th>
                                                        <th scope="col">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT *, CONCAT(lastname, ', ', firstname, ' ' , midname, '.' ) AS fullname 
                                                    FROM student where accstatus ='' and brgy='$skpos' ORDER BY brgy asc, lastname ASC"; // SQL query to fetch all table data
                                                    $view_data = mysqli_query($conn, $query); // sending the query to the database
                                                    $count=1;
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
                                                        $fullname =$row['fullname'];

                                                        $imagePath = $row['picture'];
                                                        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                                            $imageUrl = $imagePath;
                                                        } else {
                                                            $imageUrl = '../applicants/assets/uploads/applicant_profile/' . $imagePath;
                                                        }
                                                       // $fullname = $lastname . ', ' . $firstname;
                                                    ?>
                                                        <tr>
                                                        <td><?php echo $count; ?></td>
                                                        <td><img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="Picture" class="avatar-img rounded-circle" style="height: 50px;width:50px;"> <?php echo htmlspecialchars($fullname); ?></td>
                                                            <td><?php echo htmlspecialchars($brgy); ?></td>
                                                            <td><?php echo htmlspecialchars($email); ?></td>
                                                            <td><?php echo htmlspecialchars($gender); ?></td>
                                                            <td>
                                                                <a type="button" href="studentdetails.php?studid=<?php echo $studid; ?>" class="btn btn-link btn-info" title="Edit Data">
                                                                    <i class="fa fa-file"></i></a>

                                                            <!--    <a type="button" href="#" data-toggle="modal" data-target="#edit" data-staffid="<?php echo $staffid;?>" class="btn btn-link btn-success" title="Edit Data">
                                                                    <i class="fa fa-edit"></i></a> -->
</a>        
                                                                <a type="button" href="javascript:void(0);" onclick="confirmDeletion(<?php echo $studid; ?>)" class="btn btn-link btn-danger" title="Delete">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                                <script>
                                                                    function confirmDeletion(studid) {
                                                                        if (confirm('Are you sure you want to delete this record?')) {
                                                                            window.location.href = 'remove_student.php?deleteid=' + studid + '&confirm=true';
                                                                        }
                                                                    }
                                                                </script>
                                                            </td>
                                                        </tr>
                                                    <?php $count++;  }?>

                                                </tbody>


                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

       <!-- alert for DELETEEEEEEEEE -->
       <?php if (isset($_SESSION['deletemess'])) : ?> 
                                <script>
                                    Swal.fire({
                                        title: '<?php echo $_SESSION['title']; ?>',
                                        text: '<?php echo $_SESSION['deletemess']; ?>',
                                        icon: '<?php echo $_SESSION['success']; ?>',
                                        confirmButtonText: 'OK'
                                    });
                                </script>
                                <?php unset($_SESSION['deletemess']);
                                unset($_SESSION['success']);unset($_SESSION['title']); ?>
                            <?php endif; ?>


                <!-- Main Footer -->
                <?php include 'templates/main-footer.php' ?>
                <!-- End Main Footer -->

            </div>

        </div>
        <?php include 'templates/footer.php' ?>
        <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
        <!--sweet alert -->

        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    "pageLength": 10,
                    "lengthChange": true,
                    "order": [
                       // [1, "asc"], [0, "asc"]
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
        </script>
    </body>

    </html><?php } ?>