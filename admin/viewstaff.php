<?php include 'server/server.php';
 $sql = "SELECT *, CONCAT(lastname, ', ', firstname) AS fullname FROM staff ORDER BY lastname ASC";
 $result = mysqli_query($conn, $sql); 
  ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Educational Assistance</title>
   
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    /* Table styles */
    .table {
        font-size: 14px;
    }
    .table th, .table td {
        font-size: 12px;
        height:40px;
    }
    .table h2 {
        font-size: 18px;
    }

    /* Responsive styles */
    @media only screen and (max-width: 768px) {
        /* Tablet and mobile styles */
        .card-body {
            padding: 1rem;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .table {
            font-size: 12px;
        }
        .table th, .table td {
            font-size: 10px;
        }
        h3, p{
            font-size: 10px;
        }
        img {
         width: 20%; 
         height: auto;
}
    }

    @media only screen and (max-width: 480px) {
        /* Mobile styles */
        .card-body {
            padding: 0.5rem;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .table {
            font-size: 10px;
        }
        .table th, .table td {
            font-size: 8px;
        }
        h3, p{
            font-size: 10px;
        }
        img {
         width: 20%; 
         height: auto;
}
    }
</style>

</head>
<body>

                         

                                    <div class="d-flex flex-wrap justify-content-around" style="border-bottom:1px solid green">
                                        <div class="text-center">
                                            <img src="assets/img/logo.png" class="img-fluid" width="100">
										</div>
										<div class="text-center">
                                            <h3 class="mb-0">Republic of the Philippines</h3>
                                            <h3 class="mb-0">Province of Quezon</h3>
											<h3 class="fw-bold mb-0">San Antonio</h3>
											<p><i>Mobile No.0923333</i></p>
										</div>
                                        <div class="text-center">
                                            <img src="assets/img/quezon.png" class="img-fluid" width="100">
										</div>
									</div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="text-center mt-5">
                                                <h3 class="mt-4 fw-bold">Staff Information</h3>
                                            </div>
                                            <br>
                                            <div class="table-responsive">
        <table class="table table-bordered">
       <?php
       
    ?>
            <thead>
                <tr>
                <th>No</th>
                    <th>Fullname</th>
                    <th>Position</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>Age</th>
                    <th>Birthday</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display each record in the table
                $count = 0;
                $no =1;
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($count % 20 === 0 && $count !== 0) {
                        echo '</tbody></table><div class="page-break"></div><h2>Educational  (Page ' . ($count / 25 + 1) . ')</h2><table class="table table-bordered"><thead><tr><th>ID</th><th>Name</th><th>Year</th><th>Course</th><th>Barangay</th><th>Gender</th></tr></thead><tbody>';
                    }
                    echo "<tr>";
                    echo "<td>" . $no . "</td>";
                    echo "<td>" . $row['fullname'] . "</td>";
                    echo "<td>" . $row['position'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['contact_no'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['age'] . "</td>";
                    echo "<td>" . $row['birthday'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "</tr>";
                    $count++;
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
                                          
                                        
                                        <p class="ml-3 text-center"><i>&copy Web Based Educational Assistance Application System for San Antonio, Quezon</i></p>
                                    </div>
								</div>
						
					
</body>
</html>