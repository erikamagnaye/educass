<?php

require("../server/server.php");

// get Users
$query = "SELECT lastname,firstname,email,`position`,`contact_no`,age,`birthday`,`address`,`gender` FROM `staff`";
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
header('Content-Disposition: attachment; filename=staff.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('Lastname', 'Firstname','Email', 'Position', 'Contact Number', 'Age', 'Birthday', 'Address', 'Gender'));

if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}


?>