<?php include 'server/server.php' ?>

<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0)) {
    header('location:login.php');
    exit();
} else {
    $studid =$_SESSION['id'];
    $name = $_SESSION['name'];
    $query = "SELECT * FROM `student` where studid = $studid "; // SQL query to fetch all table data
    $view_data = mysqli_query($conn, $query); // sending the query to the database

    // displaying all the data retrieved from the database using while loop
    while ($row = mysqli_fetch_assoc($view_data)) {

        $lastname = $row['lastname'];
        $firstname = $row['firstname'];
        $midname = $row['midname'];
        $email = $row['email'];
        $age = $row['age'];
        $contact_no = $row['contact_no'];
        $birthday = $row['birthday'];
        $brgy = $row['brgy'];
        $municipality = $row['municipality'];
        $province = $row['province'];
        $street_name = $row['street_name'];
     
        $gender = $row['gender'];
        $citizenship = $row['citizenship'];
        $religion = $row['religion'];
        $civilstatus = $row['civilstatus'];
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
                                    <h2 class="text-black fw-bold">Applicant Dashboard</h2>
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
                                           
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Last Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter Last Name" value="<?php echo $lastname; ?>" name="lastname" readonly>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">First Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter First Name" value="<?php echo $firstname; ?>" name="firstname" readonly>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Middle Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter Middle Name" value="<?php echo $midname; ?>" name="midname" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Email Address</label>
                                                    <input type="email" class="form-control" placeholder="Enter Email" value="<?php echo $email; ?>" name="email" readonly>
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
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Age</label>
                                                    <input type="number" class="form-control" placeholder="Enter Age" value="<?php echo $age; ?>" name="age" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Sex</label>
                                                <select class="form-control form-control" required name="gender" style="font-family: 'Poppins', Times, serif;">
            <option disabled selected value="">Sex</option>
            <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Citizenship</label>
                                                    <input type="text" class="form-control" placeholder="Enter Citizenship" value="<?php echo $citizenship; ?>" name="citizenship" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Street</label>
                                                    <input type="text" class="form-control" placeholder="Enter  Street" value="<?php echo $street_name; ?>" name="street_name" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Barangay</label>
                                                    <?php
$barangays = array(
    'Arawan',
    'Bagong Niing',
    'Balat Atis',
    'Briones',
    'Bulihan',
    'Buliran',
    'Callejon',
    'Corazon',
    'Del Valle',
    'Loob',
    'Magsaysay',
    'Matipunso',
    'Niing',
    'Poblacion',
    'Pulo',
    'Pury',
    'Sampaga',
    'Sampaguita',
    'San Jose',
    'Sintorisan'
);
?>

<select class="form-control form-control vstatus" required name="brgy">
    <option disabled selected value="">Select Barangay</option>
    <?php foreach ($barangays as $barangay) { ?>
        <option value="<?php echo $barangay; ?>" <?php echo ($brgy == $barangay) ? 'selected' : ''; ?>><?php echo $barangay; ?></option>
    <?php } ?>
</select>                                 
                                                </div>
                                                
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Municipality</label>
                                                    <input type="text" class="form-control" placeholder="Enter Municipality" value="<?php echo $municipality; ?>" name="municipality" required>
                                                </div>
</div>
                                                
                                                <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Religion</label>
                                                    <input type="text" class="form-control" placeholder="Enter Religion" value="<?php echo $religion; ?>" name="religion" required>
                                                </div>
                                            <div class="col-md-4 mb-3" >
                                            <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Civil Status</label>
                                            <select class="form-control form-control form-control-select" name="civilstatus" required>
            <option disabled selected>Select Civil Status</option>
            <option value="Single" <?php echo ($civilstatus == 'Single') ? 'selected' : ''; ?>>Single</option>
            <option value="Married" <?php echo ($civilstatus == 'Married') ? 'selected' : ''; ?>>Married</option>
            <option value="Widow" <?php echo ($civilstatus == 'Widow') ? 'selected' : ''; ?>>Widow</option>
        </select>
                                           
                                        </div>
                                        <div class="col-md-4 mb-3">
                                        <label for="exampleFormControlInput1" class="form-label" style="font-weight:bold;">Province</label>
                                                <input type="text" class="form-control" placeholder="Enter Province" value="<?php echo $province; ?>" name="province" required>
                                       
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