<?php

require("../server/server.php");

if (isset($_GET['recent']) && isset($_GET['filbrgy']) && isset($_GET['year'])) {
    $recent = $_GET['recent'];
    $filbrgy = $_GET['filbrgy'];
    $year = '%' . $_GET['year'] . '%';
}

// get Users

$stmt = $conn->prepare("SELECT CONCAT(lastname, ', ', firstname, ' ' , midname ) AS fullname, 
 gender, 
    brgy, 
    school_name, 
    contact_no, 
    `year`
    FROM student join studentcourse on student.studid=studentcourse.studid 
            join application on studentcourse.courseid=application.courseid  WHERE application.educid=? and brgy=? and `year` LIKE ? and application.appstatus = 'Approved' ORDER BY `year` ASC, lastname ASC");
$stmt->bind_param("sss", $recent, $filbrgy, $year);
$stmt->execute();
$result = $stmt->get_result();



$users = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Approved Educational Assistance Applicants.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('Fullname','Gender', 'Barangay', 'School', 'Contact Number', 'Year Level'));

if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
fclose($output);

?>