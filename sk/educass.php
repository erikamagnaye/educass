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
    $position =$_SESSION['role'];
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
        <title>Educational Assistance</title>
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
                                    <h2 class="text-black fw-bold"><?php echo $position?> Dashboard</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-inner">

                        <div class="row mt--2">

                            <div class="col-md-12">

                                <div class="card">
                                <img src="assets/img/educ.jpg" class="card-img-top" alt="...">
                                    <div class="card-header">
                                        <div class="card-head-row">
                                            <div class="card-title">Educational Assistance Provided</div>

                                          

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">


                                            <table id="dataTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Title</th>
                                                        <th scope="col">Semester</th>
                                                        <th scope="col">School Year</th>
                                                        <th>Status</th>
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
                                                    $query = "SELECT * FROM `educ aids` order by `date` desc"; // SQL query to fetch all table data
                                                    $view_data = mysqli_query($conn, $query); // sending the query to the database

                                                    // displaying all the data retrieved from the database using while loop
                                                    while ($row = mysqli_fetch_assoc($view_data)) {
                                                        $educid = $row['educid'];
                                                        $title = $row['educname'];
                                                        $sem = $row['sem'];
                                                        $sy = $row['sy'];
                                                        $status = $row['status'];
                                                        $start = $row['start'];
                                                        $end = $row['end'];
                                                        $date = $row['date'];
                                                        $min_grade = $row['min_grade'];
                                                    ?>
                                                        <tr>
                                                            <td class="text-uppercase"><?php echo htmlspecialchars($title); ?></td>
                                                            <td><?php echo htmlspecialchars($sem); ?></td>
                                                            <td><?php echo htmlspecialchars($sy); ?></td>
                                                            <td><?php echo htmlspecialchars($status); ?></td>
                                                            <td>
                                                                <a type="button" href="edit_educ.php?update&educid=<?php echo $educid; ?>" class="btn btn-link btn-success mr-1"
                                                                    title="view report">
                                                                    <i class="fa fa-file"></i>

                                                                </a>
                                           
                                                          


                                               
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

                <!-- Modal ADD NEW POST FOR EDUCATIONAL ASSISTANCE -->
                <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Post Educational Assistance</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="model/addeduc.php">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" placeholder="Enter Title" name="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Semester</label>
                                        <input type="text" class="form-control" placeholder="Enter Semester" name="sem" required>
                                    </div>
                                    <div class="form-group">
                                        <label>School Year</label>
                                        <input type="text" class="form-control" placeholder="Enter Title" name="sy" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Start of Application</label>
                                        <input type="date" class="form-control" name="start" required>
                                    </div>
                                    <div class="form-group">
                                        <label>End of Application</label>
                                        <input type="date" class="form-control" name="end" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Minimum Grade needed</label>
                                        <input type="text" class="form-control" name="min_grade" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Date Created</label>
                                        <input type="date" class="form-control" name="date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" id="" required name="status">
                                            <option value="Open">Open</option>
                                            <option value="Closed">Closed</option>
                                        </select>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <!--  <input type="hidden" id="pos_id" name="id"> -->
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="create">Create</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal EDIT EDUCATIONAL ASSISTANCE -->
                <!-- Modal EDIT EDUCATIONAL ASSISTANCE 
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Assistance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="model/edit_educass.php">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" id="title" placeholder="Enter title" name="title" value="<?php echo $title ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <input type="text" class="form-control" id="sem" placeholder="Enter semester" name="sem" value="<?php echo $sem ?>"  required>
                    </div>
                    <div class="form-group">
                        <label>School Year</label>
                        <input type="text" class="form-control" id="sy" placeholder="Enter school year" name="sy" value="<?php echo $sy ?>"  required>
                    </div>
                    <div class="form-group">
                        <label>Minimum Grade Required</label>
                        <input type="text" class="form-control" id="min_grade" placeholder="Enter minimum grade" name="min_grade" value="<?php echo $min_grade ?>"  required>
                    </div>
                    <div class="form-group">
                        <label>Start</label>
                        <input type="date" class="form-control" id="start" name="start" value="<?php echo $start ?>"  required>
                    </div>
                    <div class="form-group">
                        <label>Due Date</label>
                        <input type="date" class="form-control" id="end" name="end" value="<?php echo $end ?>"  required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="status" required name="status" value="<?php echo $status ?>" >
                            <option value="Active">Open</option>
                            <option value="Inactive">Closed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date Posted</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo $date ?>"  required>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="educid" name="educid">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->


                <!-- Main Footer -->
                <?php include 'templates/main-footer.php' ?>
                <!-- End Main Footer -->

            </div>

        </div>
        <?php include 'templates/footer.php' ?>

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
            unset($_SESSION['success']);
            unset($_SESSION['title']);  ?>
        <?php endif; ?>
        <script>
            //this can be remove because search is still working without it
            $(document).ready(function() {
                $('#search-input').on('keyup', function() {
                    var searchQuery = $(this).val();
                    if (searchQuery != '') {
                        $.ajax({
                            type: 'POST',
                            url: 'live_search.php',
                            data: {
                                search: searchQuery
                            },
                            success: function(data) {
                                $('#search-results').html(data);
                            }
                        });
                    } else {
                        $('#search-results').html('');
                    }
                });
            });

            //CODE FOR DATATABLES THAT SORT AND SEARCH DATA
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    "ordering": true,
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "order": [[2, "desc"], 
                    [1, "desc"],
                ],
                    "language": {
                        "search": "_INPUT_",
                        "searchPlaceholder": "Search here"
                    },
                    "columns": [{
                            "title": "Title",
                            "data": "title",
                            "orderable": true
                        },
                        {
                            "title": "Semester",
                            "data": "semester",
                            "orderable": true
                        },
                        {
                            "title": "School Year",
                            "data": "school_year",
                            "orderable": true
                        },
                        {
                            "title": "Status",
                            "data": "status",
                            "orderable": true
                        },
                        {
                            "title": "Action",
                            "data": "action",
                            "orderable": true
                        }
                    ]
                });
            });
        </script>
        <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
    </body>

    </html><?php } ?>