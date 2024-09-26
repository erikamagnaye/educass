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
    $title 	= $_POST['title'];
    $details = $_POST['details'];
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:sa");
    $sender_email = $_SESSION['email'];

    // Fetch emails of all staff and students from the database
    $email_query = "SELECT email FROM staff UNION SELECT email FROM student";
    $result = $conn->query($email_query);

    if ($result->num_rows > 0) {
        // Loop through each email and send the announcement
        while ($row = $result->fetch_assoc()) {
            $to = $row['email'];
            $subject = "$title";
            $message = "$details";
            $headers = "From: $sender_email\r\n";
            $headers .= "Reply-To: $sender_email\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            // Send email to each user
            if (!mail($to, $subject, $message, $headers)) {
                $error = error_get_last();
                $_SESSION['message'] = 'Email not sent to ' . $to . ' Error: ' . $error['message'];
                $_SESSION['title'] = 'Error';
                $_SESSION['success'] = 'error';
                header("Location: ../announcement.php");
                exit();
            }
        }

        // Insert the announcement into the database if emails are sent
        $stmt = $conn->prepare("INSERT INTO `announcement` (`title`, `details`, `date`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $details, $date);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = 'New announcement has been posted!';
            $_SESSION['title'] = 'success';
            $_SESSION['success'] = 'success';
        } else {
            $_SESSION['message'] = 'Something went wrong while saving the announcement!';
            $_SESSION['title'] = 'Error';
            $_SESSION['success'] = 'error';
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = 'No email addresses found!';
        $_SESSION['title'] = 'Error';
        $_SESSION['success'] = 'error';
    }
}

header("Location: ../announcement.php");
$conn->close();
exit();
?>
