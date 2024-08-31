<?php

require("../server/server.php");

$skTypes = array('SK-Arawan','SK-Bagong Niing', 'SK-Balat Atis','SK-Briones','SK-Bulihan','SK-Buliran','SK-Callejon',
'SK-Corazon', 'SK-Del Valle','SK-loob','SK-Magsaysay','SK-Matipunso','SK-Niing','SK-Poblacion','SK-Pulo',
'SK-Pury','SK-Sampaga','SK-Sampaguita', 'SK-San Jose', 'SK-Sinturisan');

// get Users
$query = "SELECT lastname,firstname,email,`position`,`contact_no`,age,`birthday`,`address`,`gender` FROM `staff`WHERE position IN ('" . implode("', '", $skTypes) . "')
        ORDER BY lastname, firstname";
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
header('Content-Disposition: attachment; filename=SKOfficial.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('Lastname', 'Firstname','Email', 'Position', 'Contact Number', 'Age', 'Birthday', 'Address', 'Gender'));

if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}


?>