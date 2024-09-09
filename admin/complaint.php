<?php include 'server/server.php' ?>

<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'admin') {
	header('location:login.php');
    exit();
} else {

    $stmt = $conn->prepare("SELECT 
    SUM(IF(`status` = 'Pending', 1, 0)) AS pending_count,
    SUM(IF(`status` = 'In Process', 1, 0)) AS in_process_count,
    SUM(IF(`status` = 'Close', 1, 0)) AS closed_count
  FROM `concerns`");
  $stmt->execute();
  $result = $stmt->get_result();
  $allcomplaints = $result->fetch_assoc();
  
  $pending = $allcomplaints['pending_count'];
  $inprocess= $allcomplaints['in_process_count'];
  $close = $allcomplaints['closed_count'];
  $total_complaints = $pending +   $inprocess +   $close;

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'templates/header.php' ?>
        <title>Educational Assistance</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
       
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
      
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

            table {
                text-align: left;
            }
/*button color depending on status of complaint */
.btn-violet {
  background-color: #7A288A; /* violet */
  color: #fff;
}

.btn-warning {
  background-color: #F7DC6F; /* yellow */
  color: #333;
}

.btn-danger {
  background-color: #FF0000; /* red */
  color: white;
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
                                    <h2 class="text-black fw-bold">Admin Dashboard</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-inner">

                        <div class="row mt--2">

                            <div class="col-md-12">

                                <div class="card">
                                <img src="assets/img/queries.jpg" class="card-img-top" alt="...">
                                    <div class="card-header">
                                        <div class="card-head-row">
                                            <div class="card-title">Concerns/Queries</div>

                   

                                        </div>
                                    </div>
                                    <div class="card-body col-md-12">
                                        <div container-fluid>
                                            <div class="dashboard">
                                                <div class="card" style="background-color:#06D001;">
                                                    <div class="card-icon" style="color:white;"><i class="fa-solid fa-clipboard-question"></i></div>
                                                    <a href="complaint.php" class="btn">
                                                        <h5 style="color:white;"><?= $total_complaints ?> <br>All Complaints</h5>
                                                    </a>

                                                </div>
                                                <div class="card">
                                                    <div class="card-icon" style="color:violet;"><i class="fa-solid fa-hourglass-end"></i></div>
                                                    <a href="complaint_pending.php" class="btn">
                                                        <h5><?= $pending ?> <br>Pending</h5>
                                                    </a>

                                                </div>
                                                <div class="card">
                                                    <div class="card-icon" style="color:yellow;"><i class="fa fa-spinner fa-spin"></i></div>
                                                    <a href="complaint_inprocess.php" class="btn">
                                                        <h5><?= $inprocess ?> <br>In Process</h5>
                                                    </a>

                                                </div>
                                                <div class="card">
                                                    <div class="card-icon" style="color:red;"><i class="fa-solid fa-gavel"></i></div>
                                                    <a href="complaint_closed.php" class="btn">
                                                        <h5><?= $close ?><br> Closed</h5>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>



                                    </div>


                                    <div class="table-responsive">




                                        <table id="dataTable" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="text-align: justify;">Complaint No.</th>
                                                    <th scope="col" style="text-align: justify;">Complaint</th>
                                                    <th scope="col" style="text-align: justify;">Date</th>
                                                    <th scope="col" style="text-align: justify;">Status</th>
                                                    <th scope="col" style="text-align: justify;">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $query = "SELECT * FROM `concerns` order by `date` desc"; // SQL query to fetch all table data
                                                $view_data = mysqli_query($conn, $query); // sending the query to the database

                                                // displaying all the data retrieved from the database using while loop
                                                while ($row = mysqli_fetch_assoc($view_data)) {
                                                    $concernid = $row['concernid'];
                                                    $studid = $row['studid'];
                                                    $title = $row['title'];
                                                    $date = $row['date'];
                                                    $status = $row['status'];

                                                    // Determine the button color based on the status
                                                    if ($status == 'Pending') {
                                                        $btn_color = 'btn-violet';
                                                    } elseif ($status == 'In Process') {
                                                        $btn_color = 'btn-warning';
                                                    } elseif ($status == 'Close') {
                                                        $btn_color = 'btn-danger'; // red
                                                    } else {
                                                        $btn_color = 'btn-default'; // default color
                                                    }

                                                ?>
                                                    <tr>
                                                        <td class="text-uppercase"><?php echo htmlspecialchars($concernid); ?></td>
                                                        <td><?php echo htmlspecialchars($title); ?></td>
                                                        <td><?php echo htmlspecialchars($date); ?></td>
                                                        <td>
      <button class="btn <?php echo $btn_color; ?>"><?php echo htmlspecialchars($status); ?></button>
    </td>
                                                        <td>
                                                          
                                          
                                                 
                                                            <a href="view_complaint.php?update&concernid=<?php echo $concernid; ?>" class="btn btn-link btn-success mr-1" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>

                                                            <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm border-0" title="Delete" onclick="confirmDeletion(<?php echo $concernid; ?>)">
    <i class="fa fa-trash"></i>
</a>

<script>
    function confirmDeletion(concernid) {
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
                window.location.href = 'delete_complaint.php?concernid=' + concernid + '&confirm=true';
            }
        });
    }
</script>
                                                           

                                                        
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

        

          

            <!-- Main Footer -->
            <?php include 'templates/main-footer.php' ?>
            <!-- End Main Footer -->

        </div>

        </div>
        <?php include 'templates/footer.php' ?>
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
                    "language": {
                        "search": "_INPUT_",
                        "searchPlaceholder": "Search here"
                    },
                    "columns": [{
                            "title": "Complaint No.",
                            "data": "title",
                            "orderable": true
                        },
                        {
                            "title": "Complaint",
                            "data": "semester",
                            "orderable": true
                        },
                        {
                            "title": "Date",
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