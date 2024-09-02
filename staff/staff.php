<?php include 'server/server.php' ?>

<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$skTypes = array('SK-Arawan','SK-Bagong Niing', 'SK-Balat Atis','SK-Briones','SK-Bulihan','SK-Buliran','SK-Callejon',
'SK-Corazon', 'SK-Del Valle','SK-loob','SK-Magsaysay','SK-Matipunso','SK-Niing','SK-Poblacion','SK-Pulo',
 'SK-Pury','SK-Sampaga','SK-Sampaguita', 'SK-San Jose', 'SK-Sinturisan'); 
if (!isset($_SESSION['staffid']) || strlen($_SESSION['staffid']) == 0 ||in_array($_SESSION['role'], $skTypes)) {
	header('location:index.php');
    exit();
} else {
    // staet of code to digitally update status of educ assistance
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
    } // else {
    // echo "No records to update.";
    //}

    $stmtSelect->close();



    //end of code to update educ ass digitally

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'templates/header.php' ?>
        <title>Educational Assistance | Employee Portal</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
       <style>


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
                                    <h2 class="text-black fw-bold">Employee Portal</h2>
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
                                            <div class="card-title">SK Officials</div>

                                            <div class="card-tools">
                                                <a href="viewstaff.php" class="btn btn-success btn-border btn-round btn-sm" title="view and print">
                                                    <i class="fa fa-eye"></i>
                                                    View
                                                </a>
                                                <a href="model/export_staff_csv.php" class="btn btn-danger btn-border btn-round btn-sm" title="Download">
                                                    <i class="fa fa-file"></i>
                                                    Export CSV
                                                </a>
                                                <a href="#add" data-toggle="modal" class="btn btn-info btn-border btn-round btn-sm" title="Post Assistance">
                                                    <i class="fa fa-plus"></i>
                                                    Add SK
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="myTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Staff</th>
                                                        <th scope="col">Position</th>
                                                        <th scope="col">Address</th>
                                                        <th scope="col">Gender</th>
                                                        <th scope="col">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $skTypes = array('SK-Arawan','SK-Bagong Niing', 'SK-Balat Atis','SK-Briones','SK-Bulihan','SK-Buliran','SK-Callejon',
                                                    'SK-Corazon', 'SK-Del Valle','SK-loob','SK-Magsaysay','SK-Matipunso','SK-Niing','SK-Poblacion','SK-Pulo',
                                                     'SK-Pury','SK-Sampaga','SK-Sampaguita', 'SK-San Jose', 'SK-Sinturisan');
                                                    
                                                    $query = "SELECT *, CONCAT(lastname, ', ', firstname) AS fullname 
                                                    FROM staff WHERE position IN ('" . implode("', '", $skTypes) . "') 
          ORDER BY lastname ASC"; // SQL query to fetch all table data
                                                    $view_data = mysqli_query($conn, $query); // sending the query to the database

                                                    // displaying all the data retrieved from the database using while loop
                                                    while ($row = mysqli_fetch_assoc($view_data)) {
                                                        $staffid = $row['staffid'];
                                                        $lastname = $row['lastname'];
                                                        $firstname = $row['firstname'];
                                                        $email = $row['email'];
                                                        $contact_no = $row['contact_no'];
                                                        $age = $row['age'];
                                                        $birthday = $row['birthday'];
                                                        $address = $row['address'];
                                                        $position = $row['position'];
                                                        $gender = $row['gender'];
                                                        $fullname =$row['fullname'];

                                                       // $fullname = $lastname . ', ' . $firstname;
                                                    ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($fullname); ?></td>
                                                            <td><?php echo htmlspecialchars($position); ?></td>
                                                            <td><?php echo htmlspecialchars($address); ?></td>
                                                            <td><?php echo htmlspecialchars($gender); ?></td>
                                                            <td>
                                                              

<a href="edit_staff.php?update&staffid=<?php echo $staffid; ?>" class="btn btn-link btn-success mr-1" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>

                                                            <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm border-0" title="Delete" onclick="confirmDeletion(<?php echo $staffid; ?>)">
    <i class="fa fa-trash"></i>
</a>

<script>
    function confirmDeletion(concernid) {
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
                window.location.href = 'remove_staff.php?deleteid=' + staffid + '&confirm=true';
            }
        });
    }
</script>
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

                <!-- Modal ADD NEW STAFF FOR EDUCATIONAL ASSISTANCE -->
                <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-success" style="border-radius: 3px;">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Staff</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="model/addstaff.php">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Last Name" name="lname" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" placeholder="Enter First Name" name="fname" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Email</label>
                                            <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Position</label>
                                            <input type="text" class="form-control" placeholder="Enter Position" name="position" list="posOptions" required>
                                            <datalist id="posOptions">
                                            <option value="SK-Arawan">
                                                <option value="SK-Bagong Niing">
                                                <option value="SK-Balat Atis">
                                                <option value="SK-Briones">
                                                <option value="SK-Bulihan">
                                                <option value="SK-Buliran">
                                                <option value="SK-Callejon">
                                                <option value="SK-Corazon">
                                                <option value="SK-Del Valle">
                                                <option value="SK-Loob">
                                                <option value="SK-Magsaysay">
                                                <option value="SK-Matipunso">
                                                <option value="SK-Niing">
                                                <option value="SK-Poblacion">
                                                <option value="SK-Pulo">
                                                <option value="SK-Pury">
                                                <option value="SK-Sampaga">
                                                <option value="SK-Sampaguita">
                                                <option value="SK-San Jose">
                                                <option value="SK-Sinturisan">
                                            </datalist>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Contact Number</label>
                                            <input type="text" class="form-control" placeholder="09" name="contact_no" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Address</label>
                                            <input type="text" class="form-control" placeholder="Enter Address" name="address" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Age</label>
                                            <input type="number" class="form-control" placeholder="Enter Age" name="age" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Birthday</label>
                                            <input type="date" class="form-control" placeholder="Enter Birthday" name="bday" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Gender</label>
                                            <select class="form-control" id="" required name="gender">
                                                <option value="">Select</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="text" class="form-control" placeholder="Password" name="password" required>
                                    </div>



                            </div>
                            <div class="modal-footer">
                                <!--  <input type="hidden" id="pos_id" name="id"> -->
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="create">Create</button>
                            </div>

                            <?php if (isset($_SESSION['display'])) : ?>
                                <script>
                                    Swal.fire({
                                        title: '<?php echo $_SESSION['title']; ?>',
                                        text: '<?php echo $_SESSION['display']; ?>',
                                        icon: '<?php echo $_SESSION['success']; ?>',
                                        confirmButtonText: 'OK'
                                    });
                                </script>
                                <?php unset($_SESSION['display']);
                                unset($_SESSION['success']); ?>
                            <?php endif; ?>
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
                        [0, "asc"]
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