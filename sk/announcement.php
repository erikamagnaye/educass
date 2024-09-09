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
            <img src="assets/img/announcement.jpg" class="card-img-top" alt="...">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Announcement</div>
                      
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
                                    <h6 class="card-title mb-0"><?php echo $title;?></h6>
                                    <small class="text-muted">Posted on: <?php echo $date;?></small>
                                </div>
                                <div>
                                    <a href="read_announcement.php?announceid=<?php echo $announceid; ?>" class="btn btn-success btn-sm" title="View">
                                    View
                                    </a>
                         
                                  
                                                 

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
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