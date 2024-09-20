<?php include 'server/server.php' ?>

<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0) || !isset($_SESSION['id']) || !isset($_SESSION['email'])) {
	header('location:login.php');
    exit();
} else {
    if (isset($_GET['announceid'])) {
        $announceid = $_GET['announceid'];

        $query = "SELECT * FROM `announcement` WHERE announceid = $announceid";
        $view = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($view)) {
            $title = $row['title'];
            $details = $row['details'];
            $date = $row['date'];
        } else {
            $_SESSION['message'] = 'No Record found!';
            $_SESSION['success'] = 'danger';
            header("Location: ../announcement.php");
            exit();
        }
    }


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'templates/header.php' ?>
        <title>Educational Assistance</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">

        <style>
            .btn-link+.btn-link {
                margin-left: 5px;
            }
        </style>

    </head>

    <body>
        <? //php include 'templates/loading_screen.php' 
        ?>


            <!-- Main Header -->
            <? //php include 'templates/main-header.php' 
            ?>
            <!-- End Main Header -->

            <!-- Sidebar -->
            <? //php include 'templates/sidebar.php' 
            ?>
            <!-- End Sidebar -->

                    <div class="panel-header ">
                        <div class="page-inner">
                            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">

                            </div>
                        </div>
                    </div>

                    <div class="page-inner">
                        <div class="row mt--2 justify-content-center">
                            <div class="col-md-6">
                                <div class="card  my-5">

                                    <div class="card-body">


                                        <div>

                                            <p class="text-muted"> <?php echo $date; ?></p>
                                        </div>
                                        <form>

                                            <div class="form-group">


                                                <h3 class="text-center"><?php echo $title; ?></h3>
                                                <p>Details: </p>
                                                <?php echo nl2br(htmlspecialchars($details)); ?>

                                            </div>
                                            <div class="form-group">

                                                <a href="announcement.php" class="btn btn-secondary">Back</a>
                                            </div>

                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                  

                    <!-- Main Footer -->
                    <?//php include 'templates/main-footer.php' ?>
                    <!-- End Main Footer -->

            
            <? //php include 'templates/footer.php' 
            ?>






            <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
    </body>

    </html><?php } ?>