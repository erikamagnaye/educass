<?php include 'server/server.php' ?>

<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'Admin') {
	header('location:../login.php');
    exit();
} else {
    
    
if (isset($_POST['delete_selected']) && !empty($_POST['selected_histories'])) {
    // Retrieve selected history IDs
    $selected_histories = $_POST['selected_histories'];
    
    // Create a string of placeholders for a prepared statement
    $placeholders = implode(',', array_fill(0, count($selected_histories), '?'));
    
    // Prepare delete query
    $query = "DELETE FROM `history` WHERE `historyid` IN ($placeholders)";
    $stmt = $conn->prepare($query);
    
    // Bind parameters dynamically
    $stmt->bind_param(str_repeat('i', count($selected_histories)), ...$selected_histories);

    // Execute the query
    if ($stmt->execute()) {
        echo "Selected histories deleted successfully.";
    } else {
        echo "Error deleting histories: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
    
    // Redirect back to the history page (update `history.php` to the correct page if different)
    header("Location: history.php");
    exit();
} else {
    echo "No histories selected for deletion.";
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
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
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
                                    <h2 class="text-black fw-bold">Admin Portal</h2>
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
                        <div class="card-title">History</div>
                      
                    </div>
                </div>
                
                <div class="card-body">
                      <!-- Button to delete selected histories -->
    
    <form action="" method="post">
            <button type="submit" name="delete_selected" class="btn btn-danger mt-3">Delete History</button><br>
        <?php
        $query = "SELECT * FROM `history` ORDER BY `historydate` DESC"; // SQL query to fetch all table data
        $view_data = mysqli_query($conn, $query); // sending the query to the database

        // Displaying all the data retrieved from the database using while loop
        while ($row = mysqli_fetch_assoc($view_data)) {
            $historyid = $row['historyid'];
            $history = $row['history'];
            $date = $row['historydate'];
        ?>
        <div class="card mb-2" style="border-width: 1px; border-radius: 10px;">
            <div class="card-body py-2">
                <div class="d-flex justify-content-between">
                    <div>
                        <!-- Checkbox to select history for deletion -->
                        <input type="checkbox" name="selected_histories[]" value="<?php echo $historyid; ?>" />
                        <p class="card-title mb-0" style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><?php echo $history; ?></p>
                        <small class="text-muted"><?php echo $date; ?></small>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        
      
    </form>
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
    
        <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
    </body>

    </html><?php } ?>


