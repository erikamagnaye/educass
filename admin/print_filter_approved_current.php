<?php include 'server/server.php';

if (isset($_GET['recent']) && isset($_GET['filbrgy']) && isset($_GET['year'])) {
    $recent = mysqli_real_escape_string($conn, $_GET['recent']);
    $filbrgy = mysqli_real_escape_string($conn, $_GET['filbrgy']);
    $year = mysqli_real_escape_string($conn, $_GET['year']);
                      
       
$query = "SELECT *, CONCAT(lastname, ', ', firstname, ' ' , midname, '.' ) AS fullname 
FROM student join studentcourse on student.studid=studentcourse.studid 
join application on studentcourse.courseid=application.courseid 
where application.educid=? and brgy=? and `year` LIKE ? and application.appstatus = 'Approved' ORDER BY `year` ASC, lastname ASC";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'sss', $recent, $filbrgy, $year);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
ob_start(); 
?>

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
                                            <img src="assets/img/logo.png" class="img-fluid" width="100">
										</div>
									</div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="text-center mt-5">
                                                <h3 class="mt-4 fw-bold">Educational Assistance Applicants from <?php echo $filbrgy ?></h3>
                                            </div>
                                            <br>
                                            <div class="table-responsive">
 <table class="table table-bordered">
 <thead>
     <tr>
         <th> No</th>
         <th> Fullname</th>
         <th> Gender</th>
         <th> Barangay</th>
         <th>School</th>
         <th> Contact No</th>
         <th>Year Level</th>
     </tr>
 </thead>
 <tbody>
     <?php
                             
 


     // Display each record in the table
     $count = 1; // Initialize the counter variable
     while ($row = mysqli_fetch_assoc($result)) {
         echo "<tr>";
         echo "<td> " . $count . "</td>"; // Display the counter value
         echo "<td> " . $row['fullname'] . "</td>";
         echo "<td>" . $row['gender'] . "</td>";
         echo "<td>" . $row['brgy'] . "</td>";
         echo "<td>" . $row['school_name'] . "</td>";
         echo "<td>" . $row['contact_no'] . "</td>";
         echo "<td>" . $row['year'] . "</td>";
         echo "</tr>";
         if ($count % 20 === 0 && $count !== 0) {
             echo '</tbody></table><div class="page-break"></div><h2>Educational  (Page ' . ($count / 25 + 1) . ')</h2><table class="table table-bordered"><thead><tr><th>No</th><th>fullname</th><th>Gender</th><th>Barangay</th><th>School</th><th>Contact </th><th>Year level </th></tr></thead><tbody>';
         }
         $count++; // Increment the counter variable
        }  
     ?>
 </tbody>
</table>
    </div>
                                          
                                        
                                        <p class="ml-3 text-center"><i>&copy Web Based Educational Assistance Application System for San Antonio, Quezon</i></p>
                                    </div>
								</div>
                                <?php
$output = ob_get_clean();
echo $output; // Return output for AJAX success callback

} else {
echo "Invalid parameters.";
}
?>