<?php include '../server/server.php' ?>
<?php
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (strlen($_SESSION['id'] == 0)) {
    header('location:login.php');
    exit();
}use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';  // this is from PHPMailer

if (isset($_POST['create'])) {
    $title     = $_POST['title'];
    $details   = $_POST['details'];
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:sa");

    // Set the 'From' email and name
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
            $batch_size = 200; // Number of emails to send in each batch
            $batch_counter = 0;
            $email_errors = [];

            $mail = new PHPMailer(true);  // Passing 'true' enables exceptions
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; 
                $mail->SMTPAuth   = true;
                $mail->Username   = $from_email;      
                $mail->Password   = 'guer fsju uyvi fcuh';    
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom($from_email, $from_name);
                $mail->isHTML(true);
            
                // Loop through each email and send the announcement
                while ($row = $result->fetch_assoc()) {
                    $mail->addAddress($row['email']);  // Add recipient

                    // Content
                    $mail->isHTML(true);  // Set email format to HTML
                    $mail->Subject = $title;
                    $mail->Body    = "<html><body><h3>Good Day! </h3><br><pre><p style='  font-family: Arial, Helvetica, sans-serif; font-size:14px;'>$details</pre></body></html>";

                    try {
                        $mail->send();  // Attempt to send the email
                    } catch (Exception $e) {
                        $email_errors[] = 'Email not sent to ' . $row['email'] . ' Error: ' . $mail->ErrorInfo;
                    }

                    $mail->clearAddresses();  // Clear the recipient to avoid issues in the loop
                    $batch_counter++;

                    if ($batch_counter % $batch_size == 0) {
                        sleep(5);  // Pause for 5 seconds between batches
                    }
                
                }

                // Handle email errors
                if (!empty($email_errors)) {
                    $_SESSION['message'] = 'Announcement posted but some emails were not sent: ' . implode(', ', $email_errors);
                    $_SESSION['title'] = 'Partial Success';
                    $_SESSION['success'] = 'warning';
                }

            } catch (Exception $e) {
                $_SESSION['message'] = 'Mailer Error: ' . $mail->ErrorInfo;
                $_SESSION['title'] = 'Error';
                $_SESSION['success'] = 'error';
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
