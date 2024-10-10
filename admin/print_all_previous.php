<?php
include 'server/server.php'; // Include your database connection

if (isset($_GET['educreportid'])) {
    $educreportid = $_GET['educreportid'];

    // Your SQL query here
    $sql = "SELECT *, CONCAT(lastname, ', ', firstname, ' ', midname, '.') AS fullname 
            FROM student 
            JOIN studentcourse ON student.studid=studentcourse.studid 
            JOIN application ON studentcourse.courseid=application.courseid 
            WHERE application.educid=$educreportid  
            ORDER BY brgy ASC, `year` ASC, lastname ASC";

    $result = mysqli_query($conn, $sql);

    // Start building HTML output
    ob_start(); // Start output buffering

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
            <img src="assets/img/quezon.png" class="img-fluid" width="100">
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="text-center mt-5">
                <h3 class="mt-4 fw-bold">Educational Assistance Applicants for San Antonio</h3>
            </div><br>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Fullname</th>
                            <th>Gender</th>
                            <th>Barangay</th>
                            <th>School</th>
                            <th>Contact No</th>
                            <th>Year Level</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                    $count = 1; // Initialize counter variable
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $row['fullname'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td>" . $row['brgy'] . "</td>";
                        echo "<td>" . $row['school_name'] . "</td>";
                        echo "<td>" . $row['contact_no'] . "</td>";
                        echo "<td>" . $row['year'] . "</td>";
                        echo "</tr>";
                        $count++;
                    }
                    ?>
                    </tbody>
                </table>

                <!-- Footer -->
                <p class="ml-3 text-center"><i>&copy Web Based Educational Assistance Application System for San Antonio, Quezon</i></p>

            </div> <!-- End of table-responsive -->
        </div> <!-- End of col-md-12 -->
    </div> <!-- End of row -->
    <?php

    // Get contents and clean buffer
    $output = ob_get_clean();
    echo $output; // Return output for AJAX success callback
}
?>