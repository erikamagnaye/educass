<?php
include '../server/server.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset ($_GET['concernid'])){
    $concernid = $_GET['concernid'];

    // Check if the record exists in the remarks table
    $check_query = "SELECT * FROM concerns WHERE concernid = $concernid";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Record exists, update it
        $query = "UPDATE concerns SET `status` = 'Close' WHERE concernid = $concernid";
        mysqli_query($conn, $query);
    }

    // Redirect back to the original page
    header("Location: ../complaint.php");
    exit;
}

?>