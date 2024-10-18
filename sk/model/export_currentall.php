
<?php

require("../server/server.php");
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['recent'])) {
    $recent = $_GET['recent'];
}
$skpos = $_SESSION['skpos'];
// get Users
$query = "SELECT CONCAT(lastname, ', ', firstname, ' ' , midname ) AS fullname, 
 gender, 
    brgy, 
    school_name, 
    contact_no, 
    `year`
    FROM student join studentcourse on student.studid=studentcourse.studid 
join application on studentcourse.courseid=application.courseid 
where application.educid=$recent and brgy= '$skpos'  ORDER BY `year` ASC, lastname ASC";
if (!$result = $conn->query($query)) {
    exit($conn->error);
}

$users = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$filename = $skpos . " All Applicants.csv";

header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=$filename");
$output = fopen('php://output', 'w');
fputcsv($output, array('Fullname','Gender', 'Barangay', 'School', 'Contact Number', 'Year Level'));

if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
fclose($output);

?>