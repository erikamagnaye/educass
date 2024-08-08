<?php

require("../server/server.php");

// get Users
$query = "SELECT lastname,firstname,midname,`email`, `birthday`,`contact_no`, `brgy`, `municipality`, `province`, `street_name`, `gender`, citizenship,`religion`,`age`,`civilstatus` FROM `student`";
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
header('Content-Disposition: attachment; filename=EAapplicants.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('Lastname', 'Firstname','Middle Name','Email', 'Birthday', 'Contact Number', 'Barangay', 'Municipality', 'Province', 'Street', 'Gender', 'citizenship', 'Religion', 'Age', 'Civil Status'));

if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}


?>