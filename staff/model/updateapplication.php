<?php 
    include('../server/server.php');

    session_start(); 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '../../vendor/autoload.php'; // PHPMailer autoload


$firstname= $_SESSION['firstname'];
$lastname= $_SESSION['lastname'];

    $username = $_SESSION['username']; 
    $reviewedby = $firstname .' ' . $lastname; 
    $appstatus = $conn->real_escape_string($_POST['appstatus']); 
    $appremark = $conn->real_escape_string($_POST['appremarks']); 
    $appid = $_POST['appid'];
    $educid = $_POST['educid'];
    $studid = $_POST['studid'];

    if(isset ($_POST['update'])){
        // Update the application status
        $query = "UPDATE application SET appstatus = ?, reviewedby = ? , appremark = ? WHERE appid = ? AND educid = ? AND studid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssiii", $appstatus, $reviewedby, $appremark, $appid, $educid, $studid);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Fetch the student's name and email from the student table
            $student_query = "SELECT firstname, lastname, email FROM student WHERE studid = ?";
            $student_stmt = $conn->prepare($student_query);
            $student_stmt->bind_param("i", $studid);
            $student_stmt->execute();
            $student_result = $student_stmt->get_result();

            if ($student = $student_result->fetch_assoc()) {
                $student_name = $student['firstname'] . ' ' . $student['lastname'];
                $student_email = $student['email'];

                // Send email notification to the student
                $mail = new PHPMailer(true); // Passing `true` enables exceptions
                try {
                    // Server settings
                    $mail->isSMTP(); 
                    $mail->Host = 'smtp.gmail.com'; 
                    $mail->SMTPAuth = true; 
                    $mail->Username = 'educationalassistancesaq@gmail.com'; 
                    $mail->Password = 'guer fsju uyvi fcuh'; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
                    $mail->Port = 587; // TCP port to connect to Gmail

                    // Recipients
                    $mail->setFrom('educationalassistancesaq@gmail.com', 'Educational Assistance'); // Sender email and name
                    $mail->addAddress($student_email, $student_name); 

                    // Content
                    $mail->isHTML(true); // Set email format to HTML
                    $mail->Subject = 'Application Status Update';
                    $mail->Body    = " Good day! <br><br>
                     <strong>   Dear  $student_name, </strong><br><br>
                        Your application status has been <strong>$appstatus</strong>.<br>         
                        with remarks <strong>$appremark </strong><br>
                        Kindly check your portal for further information.
                        <br> <br>
                        
                        Best regards,<br>
                        Educational Assistance of San Antonio, Quezon 
                    ";

                    // Send the email
                    $mail->send();
                    
                    $_SESSION['message'] = 'Update successfully, and email notification sent!';
                    $_SESSION['success'] = 'success';
                    $_SESSION['title'] = 'Success';
                } catch (Exception $e) {
                    $_SESSION['message'] = 'Update successful, but email notification failed. Error: ' . $mail->ErrorInfo;
                    $_SESSION['success'] = 'error';
                    $_SESSION['title'] = 'Email Notification Failed';
                }
            } else {
                $_SESSION['message'] = 'Update successful, but no student email found!';
                $_SESSION['success'] = 'error';
                $_SESSION['title'] = 'No Email Found';
            }

            header("Location: ../skdashboard.php");
            exit();
        } else {
            $_SESSION['message'] = 'Update failed. Please, try again!';
            $_SESSION['success'] = 'error';
            $_SESSION['title'] = 'Error';
            header("Location: ../skdashboard.php");
            exit();
        }
    }
      
    $conn->close();
?>