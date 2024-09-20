<?php include 'server/server.php' ?>

<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0) || !isset($_SESSION['id']) || !isset($_SESSION['email'])) {
	header('location:login.php');
    exit();
} else {
    $studid = $_SESSION['id'];
    if (isset($_GET['concernid'])) {
        $concernid = $_GET['concernid'];

        $query = "SELECT * FROM `concerns` WHERE concernid = $concernid AND studid = $studid";
        $view = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($view)) {
           
            $title = $row['title'];
            $description = $row['description'];
            $date = $row['date'];
            $file = $row['file'];
            $status = $row['status'];
            $remarks = $row['remarks'];
        } else {
            $_SESSION['message'] = 'No Record found!';
            $_SESSION['success'] = 'danger';
            header("Location: complaint.php");
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">My Complaint/ Queries</div>

                                <div class="card-tools">
                                   
                                    <a href="complaint.php" class="btn btn-danger btn-border btn-round btn-sm">
                                        <i class="fas fa-chevron-left"></i> Back
                                    </a>

                                </div>

                            </div>
                        </div>
                        <div class="card-body">


                            <div>

                                <p class="text-muted" style="margin-left:20px;">Date sent: <?php echo $date; ?></p>
                            </div>
                            <form>
                                <table class="table">
                                <tr>
                                        <th style="height: 40px;">Complaint No</th>
                                        <td style="height: 40px;"><?php echo $concernid ?></td>

                                    </tr>
                                    <tr>
                                        <th style="height: 40px;">Complaint</th>
                                        <td style="height: 40px;"><?php echo $title ?></td>

                                    </tr>
                                    <tr>
                                        <th style="height: 40px;">Description</th>
                                        <td style="height: 40px;"><?php echo nl2br(htmlspecialchars($description)); ?></td>
                                    </tr>
                                    <tr>
                                        <th style="height: 40px;">Proof</th>
                                        <td style="height: 40px;">
                                            <?php if (!empty($file)) { ?>
                                                <a href="<?= 'assets/uploads/complaintfile/' . $file ?>" target="_blank"><?php echo $file ?></a>
                                            <?php } else {
                                                echo "No attachment submitted";
                                            } ?>
                                        </td>
                                    </tr>
                                    <tr >
                                        <th style="height: 40px;">Status</th>
                                        <td style="height: 40px;"><?php echo $status ?></td>
                                    </tr>
                                    <?php
$reply = "SELECT * FROM `reply` WHERE concernid = $concernid AND studid = $studid ORDER BY `date` ASC";
$result = mysqli_query($conn, $reply);

$allReplies = '';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $message = $row['reply'];
        $date = $row['date'];
        $allReplies .= "$date | $message<br>"; // Concatenate the replies
    }
} else {
    $allReplies = "No replies found.";
}

echo "<tr>";
echo "<th style='height: 40px;'>My Replies</th>";
echo "<td style='height: 40px;'>$allReplies</td>";
echo "</tr>";
?>
                                   
                                    <tr>
                                        <th style="height: 40px;">Remarks</th>
                                        <td style="height: 40px;"><?php echo $status ?></td>
                                    </tr>
                                </table>
                            </form>
                            <form action="model/reply.php" method="post">
                            <div class="row">
    <div class="form-group col-md-10">
        <label style="color:blue;">Write a reply</label>
        <div class="input-group">
        <input type="hidden" value="<?php echo $concernid; ?>" name="concernid">
            <textarea class="form-control" rows="2" placeholder="Enter reply here" name="message" required></textarea>
            <div class="input-group-append">
            <button type="submit" name="reply" title="reply" style="background: none; border: none; padding: 0;">
                        <i class="fa fa-paper-plane" style="font-size: 24px; color: #337ab7;justify-content:center;margin:15px;"></i>
                    </button>
            </div>
        </div>
    </div>
</div>
                           
                            
                            </form>

                        </div>
                    </div>
                </div>
            </div>




            <!-- Main Footer -->
            <? //php include 'templates/main-footer.php' 
            ?>
            <!-- End Main Footer -->


            <? //php include 'templates/footer.php' 
            ?>






            <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
    </body>

    </html><?php } ?>