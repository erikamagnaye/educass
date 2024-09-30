<?php include 'server/server.php' ?>

<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['studentid'] == 0) || !isset($_SESSION['studentid']) || !isset($_SESSION['email'])) {
	header('location:login.php');
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
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
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
                                    <h2 class="text-black fw-bold">Applicant Portal</h2>
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
    $query = "SELECT * FROM `announcement` ORDER BY `date` DESC"; // SQL query to fetch all table data
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
                    <a href="#" 
                       class="btn btn-success btn-sm view_announcement" 
                       title="View" 
                       data-announceid="<?php echo $announceid; ?>" 
                       data-title="<?php echo htmlspecialchars($title); ?>" 
                       data-details="<?php echo htmlspecialchars($details); ?>"> 
                        View
                    </a>                                     
                </div>
            </div>
        </div>
    </div>
    <?php }?>
</div>

<!-- Modal -->
<div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="announcementModalLabel">Announcement Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 style="text-align:center;" id="modalTitle"></h4>
                <p nl2br id="modalDetails"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('.view_announcement').click(function (e) {
        e.preventDefault(); // Prevent default anchor behavior
        
        // Get announcement details from data attributes
        var announceId = $(this).data('announceid');
        var title = $(this).data('title');
        var details = $(this).data('details');

        // Populate modal with announcement details
        $('#modalTitle').text(title); // Set title in modal
       

           // Replace newlines with <br> for HTML display
           $('#modalDetails').html(details.replace(/\n/g, '<br>')); // Set details in modal
        
        // Show the modal
        $('#announcementModal').modal('show');
    });
});
</script>









                

    

            

                
 


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