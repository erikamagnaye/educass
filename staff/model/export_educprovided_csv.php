<?php

require("../server/server.php");

// get Users
$query = "SELECT educname,sem,sy,`start`,`end`,min_grade,`date`,`status` FROM `educ aids`";
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
header('Content-Disposition: attachment; filename=educational_assistance.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('Educational Assistance', 'Semester','School Year', 'Start of Application', 'End of Application', 'Minimum Grade', 'Date Posted', 'Status'));

if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}


?>