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
    $staffid = $_SESSION['skid'];
    $query = "SELECT * FROM `staff` where staffid = $staffid "; // SQL query to fetch all table data
    $view_data = mysqli_query($conn, $query); // sending the query to the database

    // displaying all the data retrieved from the database using while loop
    while ($row = mysqli_fetch_assoc($view_data)) {

        $lastname = $row['lastname'];
        $firstname = $row['firstname'];
        $email = $row['email'];
        $age = $row['age'];
        $contact_no = $row['contact_no'];
        $birthday = $row['birthday'];
        $address = $row['address'];
        $position = $row['position'];
        $gender = $row['gender'];
    }


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'templates/header.php' ?>
        <title>Educational Assistance | SK Portal</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
        <style>
            .btn-link+.btn-link {
                margin-left: 5px;
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
                    <div class="panel-header ">
                        <div class="page-inner">
                            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                                <div>
                                    <h2 class="text-black fw-bold">SK Dashboard</h2>
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
                                            <div class="card-title">Personal Information</div>
                                          
                                        </div>

                                    </div>
                                    <div class="card-body">

                                        <form action="model/update_info.php" method="post">
                                            <input type="hidden" name="staffid" value="<?=$staffid ?>">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Last Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter Last Name" value="<?php echo $lastname; ?>" name="lastname" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">First Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter First Name" value="<?php echo $firstname; ?>" name="firstname" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Email address</label>
                                                    <input type="text" class="form-control" placeholder="Enter Email address" value="<?php echo $email; ?>" name="email" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Age</label>
                                                    <input type="number" class="form-control" placeholder="Enter Age" value="<?php echo $age; ?>" name="age" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Contact Number</label>
                                                    <input type="text" class="form-control" placeholder="Enter Contact Number" value="<?php echo $contact_no; ?>" name="contact_no" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Birthday</label>
                                                    <input type="date" class="form-control" placeholder="Enter Birthday" value="<?php echo $birthday; ?>" name="birthday" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Position</label>
                                                    <input type="text" class="form-control" placeholder="Enter Position" value="<?php echo $position; ?>" name="position" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Address</label>
                                                    <input type="text" class="form-control" placeholder="Enter address" value="<?php echo $address; ?>" name="address" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Sex</label>
                                                    <input type="text" class="form-control" placeholder="Enter Sex" value="<?php echo $gender; ?>" name="gender" required>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-outline-primary btn-round" name="update"> <i class="fa fa-refresh"></i>Update</button>
                                        </form>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>













                    <!-- ALERT FOR ADD -->
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
                        unset($_SESSION['success']);
                        unset($_SESSION['title']); ?>
                    <?php endif; ?>


                    <!-- ALERT FOR EDIT -->
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
                        unset($_SESSION['success']);
                        unset($_SESSION['title']); ?>
                    <?php endif; ?>
                    <!-- ALERT FOR delete -->
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
                        unset($_SESSION['success']);
                        unset($_SESSION['title']); ?>
                    <?php endif; ?>


                    <!-- Main Footer -->
                    <?php include 'templates/main-footer.php' ?>
                    <!-- End Main Footer -->

                </div>

            </div>
            <?php include 'templates/footer.php' ?>

            <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
    </body>

    </html><?php } ?>