<?php
 include 'server/server.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$searchQuery = $_POST['search'];

$query = "SELECT * FROM `educ aids` WHERE `educname` LIKE '%$searchQuery%' OR `sem` LIKE '%$searchQuery%' OR `sy` LIKE '%$searchQuery%' order by `date` desc";
$view_data = mysqli_query($conn, $query);

if (mysqli_num_rows($view_data) > 0) {
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Title</th>';
    echo '<th scope="col">Semester</th>';
    echo '<th scope="col">School Year</th>';
    echo '<th>Status</th>';
    echo '<th>Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_assoc($view_data)) {
        $educid = $row['educid'];                
        $title = $row['educname'];        
        $sem = $row['sem'];         
        $sy = $row['sy'];  
        $status = $row['status'];           
        $start = $row['start'];        
        $end = $row['end'];         
        $date = $row['date'];  
        $min_grade = $row['min_grade'];  
        echo '<tr>';
        echo '<td class="text-uppercase">' . htmlspecialchars($title) . '</td>';
        echo '<td>' . htmlspecialchars($sem) . '</td>';
        echo '<td>' . htmlspecialchars($sy) . '</td>';
        echo '<td>' . htmlspecialchars($status) . '</td>';
        echo '<td>';
        echo '<a type="button" href="edit_educ.php?update&educid=' . $educid . '"   class="btn btn-link btn-success" title="Edit Data">';
        echo '<i class="fa fa-edit"></i>';
        echo '</a>';
        echo '<a type="button" href="javascript:void(0);" onclick="confirmDeletion(' . $educid . ')" class="btn btn-link btn-danger" title="Remove">';
        echo '<i class="fa fa-times"></i>';
        echo '</a>';
        echo '<script>';
        echo 'function confirmDeletion(educid) {';
        echo 'if (confirm("Are you sure you want to delete this record?")) {';
        echo 'window.location.href = "remove_educass.php?deleteid=" + educid + "&confirm=true";';
        echo '}';
        echo '}';
        echo '</script>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo 'No results found.';
}

mysqli_close($conn);
?>