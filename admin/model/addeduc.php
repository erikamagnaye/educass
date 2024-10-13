<?php include '../server/server.php' ?>
<?php
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0)) {
	header('location:login.php');
    exit();
}

if (isset($_POST['create'])){
    $title     = $conn->real_escape_string($_POST['title']);
    $sem       = $conn->real_escape_string($_POST['sem']);
    $sy        = $conn->real_escape_string($_POST['sy']);
    $start     = $conn->real_escape_string($_POST['start']);
    $end       = $conn->real_escape_string($_POST['end']);
    $status    = $conn->real_escape_string($_POST['status']);
    $date      = $conn->real_escape_string($_POST['date']);
    $min_grade = $conn->real_escape_string($_POST['min_grade']);

    $from_email = 'educationalassistancesaq@gmail.com';  
    $from_name  = 'Educational Assistance';

    // Insert into `educ aids` table
    $insert = "INSERT INTO `educ aids` (`educname`, `sem`, `sy`, `start`, `end`, `min_grade`,`date`, `status`) 
               VALUES ('$title', '$sem','$sy', '$start','$end', '$min_grade','$date','$status')";
    $result = $conn->query($insert);

    if($result){
        // Success message for educational assistance post
        $_SESSION['message'] = 'New Educational Assistance has been posted!';
        $_SESSION['success'] = 'success';

        // Fetch emails of all staff and students from the database
        $email_query = "SELECT email FROM staff UNION SELECT email FROM student";
        $email_result = $conn->query($email_query);

        if ($email_result->num_rows > 0) {
            $email_errors = [];

            // Loop through each email and send the notification
            while ($row = $email_result->fetch_assoc()) {
                $to = $row['email'];
                $subject = "$title";  // Subject is the educational assistance title
                $message = "Good day! <br>. $title for S.Y. $sy $sem is now $status.";  // Email body

                // Build the email headers
                $headers  = "From: " . $from_name . " <" . $from_email . ">\r\n";
                $headers .= "Reply-To: $from_email\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                // Send email to each user
                if (!mail($to, $subject, $message, $headers)) {
                    $error = error_get_last();
                    $email_errors[] = 'Email not sent to ' . $to . ' Error: ' . $error['message'];
                }
            }

            // Check if any email failed to send
            if (!empty($email_errors)) {
                $_SESSION['message'] = 'Educational Assistance posted but some emails were not sent: ' . implode(', ', $email_errors);
                $_SESSION['success'] = 'warning';
            }

        } else {
            // If no emails found in the database
            $_SESSION['message'] = 'Educational Assistance posted but no email addresses found!';
            $_SESSION['success'] = 'warning';
        }

    } else {
        // Database insert failure
        $_SESSION['message'] = 'Something went wrong!';
        $_SESSION['success'] = 'danger';
    }
}

header("Location: ../educass.php");
$conn->close();
exit();
?>
