<?php include '../server/server.php' ?>
<?php
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (strlen($_SESSION['id'] == 0)) {
    header('location:login.php');
    exit();
}

if (isset($_POST['create'])) {
    $title     = $_POST['title'];
    $details   = $_POST['details'];
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:sa");

    // Set the 'From' email and name (no-reply and Educational Assistance)
    $from_email = 'educationalassistancesaq@gmail.com';  
    $from_name  = 'Educational Assistance';

    // Insert the announcement into the database
    $stmt = $conn->prepare("INSERT INTO `announcement` (`title`, `details`, `date`) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $details, $date);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Database insert successful
        $_SESSION['message'] = 'New announcement has been posted!';
        $_SESSION['title'] = 'success';
        $_SESSION['success'] = 'success';

        // Fetch emails of all staff and students from the database
        $email_query = "SELECT email FROM staff UNION SELECT email FROM student";
        $result = $conn->query($email_query);

        if ($result->num_rows > 0) {
            $email_errors = [];
            // Loop through each email and send the announcement
            while ($row = $result->fetch_assoc()) {
                $to = $row['email'];
                $subject = "$title";
                $message = "$details";

                // Build the headers with the 'From' name and email
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

            // If there were email errors, display them
            if (!empty($email_errors)) {
                $_SESSION['message'] = 'Announcement posted but some emails were not sent: ' . implode(', ', $email_errors);
                $_SESSION['title'] = 'Partial Success';
                $_SESSION['success'] = 'warning';
            }

        } else {
            // No email addresses found
            $_SESSION['message'] = 'Announcement posted, but no email addresses were found!';
            $_SESSION['title'] = 'Warning';
            $_SESSION['success'] = 'warning';
        }

    } else {
        // Database insert failed
        $_SESSION['message'] = 'Something went wrong while saving the announcement!';
        $_SESSION['title'] = 'Error';
        $_SESSION['success'] = 'error';
    }

    $stmt->close();
}

header("Location: ../announcement.php");
$conn->close();
exit();
?>
