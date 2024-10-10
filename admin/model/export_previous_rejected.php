<?php

require("../server/server.php");

if (isset($_GET['educreportid'])) {
    $educreportid = $_GET['educreportid'];
}

// get Users
$query = "SELECT CONCAT(lastname, ', ', firstname, ' ' , midname ) AS fullname, 
 gender, 
    brgy, 
    school_name, 
    contact_no, 
    `year`
    FROM student join studentcourse on student.studid=studentcourse.studid 
join application on studentcourse.courseid=application.courseid 
where application.educid=$educreportid where application.appstatus= 'Rejected'  ORDER BY brgy ASC, `year` ASC, lastname ASC";
if (!$result = $conn->query($query)) {
    exit($conn->error);
}

$users = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Educational Assistance Applicants.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('Fullname','Gender', 'Barangay', 'School', 'Contact Number', 'Year Level'));

if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
fclose($output);

?>