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
    'SK-loob',
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
if (!isset($_SESSION['staffid']) || strlen($_SESSION['staffid']) == 0 || in_array($_SESSION['role'], $skTypes)) {
    header('location:index.php');
    exit();
} else {

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
                                    <h2 class="text-black fw-bold">Employee Dashboard</h2>
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
                                            <div class="card-title">Announcement</div>
                                            <div class="card-tools">
                                                <a href="#add" data-toggle="modal" class="btn btn-info btn-border btn-round btn-sm" title="Post Assistance">
                                                    <i class="fa fa-plus"></i>
                                                    New announcement
                                                </a>
                                            </div>
                                        </div><br>
                                        <div class="card-tools">
                                            <form>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search by title or date" id="search-input">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-info" type="submit">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $query = "SELECT * FROM `announcement` order by `date` desc"; // SQL query to fetch all table data
                                        $view_data = mysqli_query($conn, $query); // sending the query to the database

                                        // displaying all the data retrieved from the database using while loop
                                        while ($row = mysqli_fetch_assoc($view_data)) {
                                            $announceid = $row['announceid'];
                                            $title = $row['title'];
                                            $date = $row['date'];
                                            $details = $row['details'];
                                        ?>
                                            <div class="card mb-2" style="border-width: 1px; border-radius: 10px;">
                                                <div class="card-body py-2">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h6 class="card-title mb-0"><?php echo $title; ?></h6>
                                                            <small class="text-muted">Posted on: <?php echo $date; ?></small>
                                                        </div>
                                                        <div>
                                                            <a href="edit_announcement.php?update&announceid=<?php echo $announceid; ?>" class="btn btn-primary btn-sm" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>

                                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" title="Delete" onclick="confirmDeletion(<?php echo $announceid; ?>)">
    <i class="fa fa-trash"></i>
</a>

<script>
    function confirmDeletion(announceid) {
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
                window.location.href = 'remove_announcement.php?deleteid=' + announceid + '&confirm=true';
            }
        });
    }
</script>

                                                           




                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>













                    <!-- Modal ADD NEW POST FOR AANNOUNCEMENT -->
                    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Post announcement</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="model/addannouncement.php">
                                        <div class="form-group">
                                            <label>Announcement Title</label>
                                            <input type="text" class="form-control" placeholder="Enter Title" name="title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="validationTextarea">Details</label>
                                            <textarea class="form-control" id="validationTextarea" rows="5" placeholder="Details" name="details" required></textarea>

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


                //for search announcement
                $(document).ready(function() {
                    $('#search-input').on('keyup', function() {
                        var searchQuery = $(this).val();
                        if (searchQuery != '') {
                            $.ajax({
                                type: 'POST',
                                url: 'search_announcements.php',
                                data: {
                                    search: searchQuery
                                },
                                success: function(data) {
                                    $('.card-body').html(data);
                                }
                            });
                        } else {
                            $.ajax({
                                type: 'POST',
                                url: 'search_announcements.php',
                                data: {
                                    search: ''
                                },
                                success: function(data) {
                                    $('.card-body').html(data);
                                }
                            });
                        }
                    });
                });
            </script>
            <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
    </body>

    </html><?php } ?>