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
if (!isset($_SESSION['skid']) || strlen($_SESSION['skid']) == 0 || !in_array($_SESSION['role'], $skTypes) || !isset($_SESSION['skpos'])) {
    header('location:sklogin.php');
    exit();
} else {
    $staffid = $_SESSION['skid'];
    if (isset($_GET['concernid'])) {
        $concernid = $_GET['concernid'];

        $query = "SELECT * FROM `concerns` join student on concerns.studid=student.studid WHERE concernid = $concernid ";
        $view = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($view)) {
            $studid = $row['studid'];
            $title = $row['title'];
            $description = $row['description'];
            $date = $row['date'];
            $file = $row['file'];
            $status = $row['status'];
            $remarks = $row['remarks'];
            $brgy = $row['brgy'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $midname = $row['midname'];
            $email = $row['email'];
        } else {
            $_SESSION['message'] = 'No Record found!';
            $_SESSION['success'] = 'danger';
            header("Location: complaint.php");
            exit();
        }
    }
    $getstaff = "SELECT * FROM `staff`  WHERE staffid = $staffid ";
    $data = mysqli_query($conn, $getstaff);

    if ($row = mysqli_fetch_assoc($data)) {
        
        $stafffirstname = $row['firstname'];
        $stafflastname = $row['lastname'];
 $staffname= $stafffirstname .' '. $stafflastname;
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
        <div class="row d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-12">
                <div class="card mb-3 mt-3" style="width: 80%; margin: 0 auto;">
                    <img src="assets/img/saq.jpg" class="card-img-top" alt="...">
                    <div class="card-header " style="border-radius: 8px;">
                        <div class="card-head-row">
                            <div class="card-title text-center">Manage Queries</div>
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
        <th style="height: 40px;">Complaint Name</th>
        <td style="height: 40px;"><?php echo $firstname . ' ' . $midname . '. ' . $lastname ?></td>

    </tr>
    <tr>
        <th style="height: 40px;">Barangay</th>
        <td style="height: 40px;"><?php echo $brgy ?></td>

    </tr>
    <tr>
        <th style="height: 40px;">Email</th>
        <td style="height: 40px;"><?php echo $email ?></td>

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
                <a href="<?= '../applicants/assets/uploads/complaintfile/' . $file ?>" target="_blank"><?php echo $file ?></a>
            <?php } else {
                echo "No attachment submitted";
            } ?>
        </td>
    </tr>
    <tr>
        <th style="height: 40px;">Status</th>
        <td style="height: 40px;"><?php echo $status ?></td>
    </tr>
    <?php
    //QUERY FOR REPLY
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
//QUERY FOR REMARKS OF EMPLOYEE
$remarks = "SELECT * FROM `remark` WHERE concernid = $concernid AND studid = $studid ORDER BY `date` ASC";
$remarksresult = mysqli_query($conn, $remarks);
$allremarks = '';


if (mysqli_num_rows($remarksresult) > 0) {
while ($row = mysqli_fetch_assoc($remarksresult)) {
$empremarks = $row['remarks'];
$dateremarks = $row['date'];
$remarksby = $row['sender'];
$allremarks .= "$dateremarks from $remarksby | $empremarks<br>"; // Concatenate the replies
}
} else {
$allremarks = "No replies found.";
}

    echo "<tr>";
    echo "<td style='height: 40px;'>Applicant  Replies <br><br> $allReplies</th>";
    echo "<td style='height: 40px;'>Remarks <br><br>$allremarks</td>";
    echo "</tr>";
    ?>
   
</table>
</form>
<form action="model/reply.php" method="post">
<div class="row">
<div class="col-md-4 mt-4" >
<label style="color:blue;">Queries Status</label>
                <select class="form-control form-control form-control-select" name="compstatus" required>
<option disabled selected>Update Queries Status</option>
<option value="Pending" <?php echo ($status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
<option value="In Process" <?php echo ($status == 'In Process') ? 'selected' : ''; ?>>In Process</option>
<option value="Close" <?php echo ($status == 'Close') ? 'selected' : ''; ?>>Close</option>
</select>
               
            </div>
    <div class="form-group col-md-8">
        <label style="color:blue;">Write a reply</label>
        <div class="input-group">
            <input type="hidden" value="<?php echo $concernid; ?>" name="concernid">
            <input type="hidden" value="<?php echo $studid; ?>" name="studid">
            <input type="hidden" value="<?php echo $staffname; ?>" name="staffname">
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
                    <div class="card-footer text-center">
                        <p>&copy Web Based Educational Assistance Application System 2024</p>
                    </div>
                </div>
            </div>

        </div>
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