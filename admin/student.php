<?php include 'server/server.php' ?>

<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'admin') {
	header('location:login.php');
    exit();
} else {
   

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'templates/header.php' ?>
        <title>Educational Assistance</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
                 <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

       <style>
.modal-body {
    max-height: 70vh; /* Set a maximum height for the modal body */
    overflow-y: auto; /* Enable vertical scrolling */
}

        </style>

    </head>

    <body>
    

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
                                    <h2 class="text-black fw-bold">Admin</h2>
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
                                            <div class="card-title">Registered Students</div>

                                            <div class="card-tools">
                                              
                                                <a href="#" class="btn btn-success btn-border btn-round btn-sm"
                                                    title="view and print" onclick="openPrintModal()">
                                                    <i class="fa fa-eye"></i>
                                                    View
                                                </a>
                                                <a href="model/export_student_csv.php" class="btn btn-danger btn-border btn-round btn-sm" title="Download">
                                                    <i class="fa fa-file"></i>
                                                    Export CSV
                                                </a>
                                               
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="myTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">No</th>
                                                        <th scope="col">Student</th>
                                                        <th scope="col">Barangay</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Gender</th>
                                                        <th scope="col">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT *, CONCAT(lastname, ', ', firstname, ' ' , midname, '.' ) AS fullname 
                                                    FROM student ORDER BY brgy asc, lastname ASC"; // SQL query to fetch all table data
                                                    $view_data = mysqli_query($conn, $query); // sending the query to the database
                                                    $count=1;
                                                    // displaying all the data retrieved from the database using while loop
                                                    while ($row = mysqli_fetch_assoc($view_data)) {
                                                        $studid = $row['studid'];
                                                        $lastname = $row['lastname'];
                                                        $firstname = $row['firstname'];
                                                        $midname = $row['midname'];
                                                        $email = $row['email'];
                                                        $contact_no = $row['contact_no'];
                                                        $age = $row['age'];
                                                        $birthday = $row['birthday'];
                                                        
                                                        $gender = $row['gender'];
                                                        $brgy = $row['brgy'];
                                                        $municipality = $row['municipality'];
                                                        $province = $row['province'];
                                                        $street_name = $row['street_name'];
                                                        $validid = $row['validid'];
                                                        //$picture = $row['picture'];
                                                        $citizenship = $row['citizenship'];
                                                        $religion = $row['religion'];
                                                        $civilstatus = $row['civilstatus'];
                                                        $accstatus = $row['accstatus'];
                                                        $fullname =$row['fullname'];

                                                        $imagePath = $row['picture'];
                                                      
                                                        if (empty($imagePath)) {
                                                            $imageUrl = '../applicants/assets/img/pic.jpg'; 
                                                        }
                                                        else {
                                                            $imageUrl = '../applicants/assets/uploads/applicant_profile/' . $imagePath;
                                                        }
                                                       // $fullname = $lastname . ', ' . $firstname;
                                                    ?>
                                                        <tr>
                                                        <td><?php echo $count; ?></td>
                                                        <td><img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="" class="avatar-img rounded-circle" style="height: 50px;width:50px;"> <?php echo htmlspecialchars($fullname); ?></td>
                                                            <td><?php echo htmlspecialchars($brgy); ?></td>
                                                            <td><?php echo htmlspecialchars($email); ?></td>
                                                            <td><?php echo htmlspecialchars($gender); ?></td>
                                                            <td>
                                                                <div style ="display:flex;">
                                                                <a type="button" href="studentdetails.php?studid=<?php echo $studid; ?>" class="btn btn-link btn-info" title="View">
                                                                    <i class="fa fa-file"></i></a>                                                       
</a>        
                                                           
                                                            

                                                                
                                                            <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm border-0" title="Delete" onclick="confirmDeletion(<?php echo $studid; ?>)">
    <i class="fa fa-trash"></i>
</a>

<script>
    function confirmDeletion(studid) {
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
                window.location.href = 'remove_student.php?deleteid=' + studid + '&confirm=true';
            }
        });
    }
</script>
                                                                </div>
                                                                
                                                            </td>
                                                        </tr>
                                                    <?php $count++;  }?>

                                                </tbody>


                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

          <!--PRINT -->

                <!-- Modal -->
                <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="btn btn-round btn-sm btn-danger"
                                    onclick="printDiv('printModalBody')"><i class="fa fa-print"></i> Print</button>
                          
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="printModalBody">
                                <!-- Content to be printed will be injected here -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-round btn-secondary"
                                    data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-round btn-danger"
                                    onclick="printDiv('printModalBody')"><i class="fa fa-print"></i> Print</button>
                            </div>
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
                       // [1, "asc"], [0, "asc"]
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

              //PRINT 
              function openPrintModal() {
              
              $.ajax({
                  url: 'viewstudent.php', // Create this PHP file to return HTML content
                  type: 'GET',

                  success: function (response) {
                      // Injecting the fetched content into the modal body
                      document.getElementById('printModalBody').innerHTML = response;
                      // Show the modal
                      $('#printModal').modal('show');
                  },
                  error: function () {
                      alert('Error fetching report data.');
                  }
              });
          }

          function printDiv(divName) {
              var printContents = document.getElementById(divName).innerHTML;
              var originalContents = document.body.innerHTML;

              // Replace body content with the content to print
              document.body.innerHTML = printContents;

              // Trigger print dialog
              window.print();

              // Restore original body content
              document.body.innerHTML = originalContents;
              location.reload();
          }
        </script>
    </body>

    </html><?php } ?>