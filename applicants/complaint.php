<?php include 'server/server.php' ?>

<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0) || !isset($_SESSION['id']) || !isset($_SESSION['email'])) {
	header('location:login.php');
    exit();
} else {
    $id = $_SESSION['id'] ;
    $allcomplaints = 1;
    $pending = 1;
    $approved = 1;
    $rejected = 1;

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'templates/header.php' ?>
        <title>Educational Assistance</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <style>
            .btn-link+.btn-link {
                margin-left: 5px;
            }



            /* styles for medium screens */
            @media (max-width: 768px) {
                .btn-container button {
                    width: 150px;
                    height: 40px;
                    font-size: 13px;
                }
            }

            /* styles for small screens */
            @media (max-width: 480px) {
                .btn-container button {
                    width: 100px;
                    height: 30px;
                    font-size: 11px;
                }
            }

            /* style for cards in dash */
            * {
                box-sizing: border-box;
            }


            .dashboard {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 10px;
            }

            .card {
                background: #ffffff;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 5px;
                text-align: center;
                display: flex;
                flex-direction: column;
                justify-content: center;
                transition: box-shadow 0.3s;
            }

            .card:hover {
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                transform: translateY(-5px);
            }

            .card-icon {
                font-size: 20px;
                color: #4CAF50;
            }

            h5 {
                margin: 10px 0 10px;
                word-wrap: break-word;
                overflow-wrap: break-word;
                word-break: break-all;
            }

            /* Small screens (max-width: 768px) */
            @media (max-width: 768px) {
                .dashboard {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 10px;
                }

                .card {
                    padding: 2px;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    text-align: center;
                }

                .card-icon {
                    font-size: 13px;
                }

                h5 {
                    font-size: 13px;
                    overflow-wrap: break-word;
                    /* Add this line to break long text */
                    word-wrap: break-word;
                    word-break: break-all;
                }
            }

            /* Extra small screens (max-width: 480px) */
            @media (max-width: 480px) {
                .dashboard {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 10px;
                }

                .card {
                    padding: 2px;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    text-align: center;
                }

                .card-icon {
                    font-size: 13px;
                }

                h5 {
                    font-size: 13px;
                    overflow-wrap: break-word;
                    /* Add this line to break long text */
                    word-wrap: break-word;
                    word-break: break-all;
                }
            }

            /* Extra extra small screens (max-width: 320px) */
            @media (max-width: 320px) {
                .dashboard {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 10px;
                }

                .card {
                    padding: 1px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                }

                .card-icon {
                    font-size: 10px;
                }

                h5 {
                    font-size: 10px;
                    overflow-wrap: break-word;
                    /* Add this line to break long text */
                    word-wrap: break-word;
                    word-break: break-all;
                }
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
                                            <div class="card-title">Concerns/Queries</div>

                                            <div class="card-tools">

                                                <a href="#add" data-toggle="modal" class="btn btn-info btn-border btn-round btn-sm" title="Post Assistance">
                                                    <i class="fa fa-plus"></i>
                                                    File Concerns
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-body col-md-12">
                                        <?php
                                        $query = "SELECT * FROM `concerns` where studid = $id order by `date` desc"; // SQL query to fetch all table data
                                        $view_data = mysqli_query($conn, $query); // sending the query to the database

                                        if (mysqli_num_rows($view_data) > 0) {
                                        // displaying all the data retrieved from the database using while loop
                                        while ($row = mysqli_fetch_assoc($view_data)) {
                                            $concernid = $row['concernid'];
                                            $title = $row['title'];
                                            $date = $row['date'];
                                            $description = $row['description'];
                                            $file = $row['file'];
                                            $status = $row['status'];
                                        ?>
                                            <div class="card mb-2" style="border-width: 1px; border-radius: 10px;">
                                                <div class="card-body py-2">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h6 class="card-title mb-0" style="text-align: justify;"><?php echo  $title; ?></h6>
                                                            <small class="text-muted" style="text-align: justify; margin: 2px;">
    sent: <?php echo $date; ?><span style="margin-left: 15px;">status: <?php echo $status; ?></span>
</small>
                                                        </div>
                                                        <div>
                                                            <a href="view_complaint.php?concernid=<?php echo $concernid; ?>" class="btn btn-success btn-sm" title="View">
                                                                View
                                                            </a>
                                                            <a href="#" onclick="return confirmCancel(<?php echo $concernid; ?>)" class="btn btn-outline-danger btn-sm" title="Cancel">
    Cancel
</a>



                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } 
                                        } else { ?>
    <div class="alert alert-info" role="alert">
        No complaint or queries yet.
    </div>
    <?php
} ?>



                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal to file complaints -->
            <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">File complaint/ Ask queries</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="model/filecomplaint.php" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" placeholder="Enter Title" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="4" placeholder="Explain your complain/queries" name="description" required></textarea>
                                </div>
                                <div class="form-group">
                                <label for="formFile" class="form-label">File/proof</label>
                                        <input class=" form-control" type="file" id="formFile" name="complaintfile" accept=".png, .jpg, .jpeg, .docx, .pdf" >                                      
                                         </div>
                              
                             

                        </div>
                        <div class="modal-footer">
                            <!--  <input type="hidden" id="pos_id" name="id"> -->
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="send">Send</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Main Footer -->
            <?php include 'templates/main-footer.php' ?>
            <!-- End Main Footer -->

        </div>
        <script>
    function confirmCancel(concernid) {
     

        Swal.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "question",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes",
  cancelButtonText: "No"
}).then((result) => {
    if (result.isConfirmed) {
                window.location.href = "model/cancel_complaint.php?concernid=" + concernid;
            }
});
    }
</script>
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
                                unset($_SESSION['success']);unset($_SESSION['title']); ?>
                            <?php endif; ?>
        <?php include 'templates/footer.php' ?>

        <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
    </body>

    </html><?php } ?>