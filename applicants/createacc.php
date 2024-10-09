
<?php
include 'server/server.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';  // this is from phpmailer from vendor folder

if (isset($_POST['save'])) {
    // Retrieve form data
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $bdate = $_POST['bdate'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $street = $_POST['street'];
    $brgy = $_POST['brgy'];
    $municipality = $_POST['municipality'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $province = $_POST['province'];
    $password = $_POST['password'];

    // Check if the user is from San Antonio
    if (strcasecmp($municipality, 'San Antonio') !== 0) {
        $_SESSION['success'] = 'danger';
        $_SESSION['mess'] = 'This is for College students from San Antonio, Quezon only!';
    } else {
        // Check if student already exists
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM student WHERE firstname = ? AND lastname = ? OR email = ?");
        $checkStmt->bind_param("sss", $fname, $lname, $email);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            $_SESSION['success'] = 'danger';
            $_SESSION['mess'] = 'An account with the same information already exists';
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Generate activation token
            $activation_token = bin2hex(random_bytes(16));  // Generates a random token

            // Insert data into database
            $stmt = $conn->prepare("INSERT INTO student (lastname, firstname, midname, email, `password`, birthday, contact_no, brgy, municipality, province, street_name, gender, age, activation_token, is_activated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
            $stmt->bind_param("ssssssssssssis", $lname, $fname, $mname, $email, $hashed_password, $bdate, $contact_no, $brgy, $municipality, $province, $street, $gender, $age, $activation_token);

            if ($stmt->execute()) {
                // Send Activation Email
                $activation_link = "http://localhost/educass/applicants/activate.php?token=$activation_token";  // Change this to your actual URL

                $mail = new PHPMailer(true);
                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'educationalassistancesaq@gmail.com'; 
                    $mail->Password = 'guer fsju uyvi fcuh';  
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Recipients
                    $mail->setFrom('educationalassistancesaq@gmail.com', 'Educational Assistance'); // Sender
                    $mail->addAddress($email);  // Add a recipient

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Account Activation Required';
                    $mail->Body = "Hello $fname $lname,<br><br>Thank you for registering! Please activate your account by clicking the link below:<br><a href='$activation_link'>Activate Account</a>";

                    $mail->send();
                    $_SESSION['success'] = 'success';
                    $_SESSION['mess'] = 'Account created successfully! Please check your email to activate your account.';
                } catch (Exception $e) {
                    $_SESSION['success'] = 'danger';
                    $_SESSION['mess'] = 'Account created, but the email could not be sent. Error: ' . $mail->ErrorInfo;
                }
            } else {
                $_SESSION['success'] = 'danger';
                $_SESSION['mess'] = 'There was an error creating your account.';
            }
            $stmt->close();
        }
    }
    $conn->close();

    
    //THIS IS THE ORIGINAL CODE WITH VALID ID
   //$valididPath = 'assets/uploads/validid_file' . basename($_FILES['validid']['name']);
   // $valididPath = 'assets/uploads/validid_file/' . basename($_FILES['validid']['name']);
   // $validid = basename($_FILES['validid']['name']);
   // $maxFileSize = 10000000; // 10MB
   // $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];




    /*elseif ($_FILES['validid']['size'] > $maxFileSize) {
        $_SESSION['success'] = 'danger';
        $_SESSION['mess'] = 'File size exceeds the maximum limit of 10MB.';
    } 
    elseif (!in_array($_FILES['validid']['type'], $allowedTypes)) {
        $_SESSION['success'] = 'danger';
        $_SESSION['mess'] = 'Invalid file type. Only PNG, JPEG, DOCx and JPG files are allowed.';
    }
    elseif (move_uploaded_file($_FILES['validid']['tmp_name'], $valididPath)) {
        // Insert data into database
        $stmt = $conn->prepare("INSERT INTO student (lastname, firstname, midname, email, `password`, birthday, contact_no, brgy, municipality, province, street_name, validid, picture, gender, citizenship, religion, age, civilstatus, accstatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssisssssssssiss", $lname, $fname, $mname, $email, $password, $bdate, $contact_no, $brgy, $municipality, $province, $street, $validid, $profile, $gender, $bplace, $religion, $age, $cstatus, $accstatus);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'success';
            $_SESSION['mess'] = 'Account created successfully! Please wait until your account is verified.';
        } else {
            $_SESSION['success'] = 'danger';
            $_SESSION['mess'] = 'There was an error creating your account.';
        }
        $stmt->close();
    } else {
        $_SESSION['success'] = 'danger';
        $_SESSION['mess'] = 'File upload failed.';
    } */


}
?>





   <!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'templates/header.php' ?>
	<title>Login </title>
	<link rel="icon" href="assets/img/logo.png" type="image/x-icon"/>   <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<style>
     body.login {
    background: url('assets/img/saqbound.jpg') no-repeat center center fixed; 
    background-size: cover;
  
}

.container-login {
    background-color: rgba(0, 0, 0, 0.5);  /* Black background with 50% opacity */
    border-radius: 10px;
    padding: 10px;
    color: white;
    
}
label {
    color: #fbfbfb !important;
    font-size: 14px !important;
}
.field-icon {    /* THIS IS FOR EYE ICON IN PASSWORD */
    float: right;
    margin-left: -25px;
    margin-top: -25px;
    position: relative;
    z-index: 2;
    cursor: pointer;
    color: green; /* Set the icon color to green */
}
/* THIS IS FOR CHECK BOX BUTTON FOR TERMS AND COND eme */

#my_camera {
    width: 150px;
    height: 180px;
    max-width: 150px;
    max-height:180px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto; /* Center the container */
}

.circle-img {
    width: 190px;
    height:200;
    height: auto;
    border-radius: 50%;
    object-fit: cover;
}
/* Optional: Adjust size for smaller screens */
@media (max-width: 768px) {
    #my_camera {
        width: 200px;
        height: 150px;
    }
}

@media (max-width: 480px) {
    #my_camera {
        width: 200px;
        height: 150px;
    }
}
    </style>
</head>
<body class="login">
<?//php include 'templates/loading_screen.php' ?>
<br>
	<div class="wrapper ">


		<div class="container container-login ">
        <?php if(isset($_SESSION['mess'])): ?>
            <script>
                Swal.fire({
                    icon: '<?= $_SESSION['success'] == 'success' ? 'success' : 'error' ?>',
                    title: '<?= $_SESSION['success'] == 'success' ? 'Success!' : 'Error!' ?>',
                    text: '<?= $_SESSION['mess']; ?>',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'createacc.php';
                });
            </script>
            <?php unset($_SESSION['mess']); unset($_SESSION['success']);?>
        <?php endif ?>
			<h2 class="text-center">Create an Account</h2>
			<div class="login-form">
              
                            <form method="POST" action=" " enctype="multipart/form-data">
                            <input type="hidden" name="size" value="1000000">
                          <!-- --  <div class="row">
                              <div class="col-md-4">
                                    <div style="width: 200px; height: 150;" class="text-center" id="my_camera">
                                        <img src="assets/img/person.png" alt="..." class="img img-fluid circle-img" width="200" height="150" >
                                    </div>
                                    <div class="form-group d-flex justify-content-center">
                                        <button type="button" class="btn btn-success btn-sm mr-2" id="open_cam">Camera</button>
                                        <button type="button" class="btn btn-info btn-sm ml-2" onclick="save_photo()">Capture</button>   
                                    </div>
                                    <div id="profileImage">
                                        <input type="hidden" name="profileimg">
                                    </div>
                                    <div class="form-group">
                                        <label for="formFile" class="form-label">Profile Picture</label>
                                        <input type="file" class="form-control form-control-sm" name="img" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                 
                                        <label for="formFile" class="form-label">Valid ID</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="validid">
                                  
                                    </div>
                                    
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password">
                                    <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            
                                </div>  -->
                                <div class="">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Firstname</label>
                                                <input type="text" class="form-control" placeholder="Enter Firstname" name="fname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Middlename</label>
                                                <input type="text" class="form-control" placeholder="Enter Middlename" name="mname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Lastname</label>
                                                <input type="text" class="form-control" placeholder="Enter Lastname" name="lname" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Birthdate</label>
                                                <input type="date" class="form-control" placeholder="Enter Birthdate" name="bdate" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input type="number" class="form-control" placeholder="Enter Age" min="1" name="age" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sex</label>
                                                <select class="form-control" required name="gender">
                                                    <option disabled selected value="">Select </option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                  <!--   <div class="row">
                                      
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label>Civil Status</label>
                                                <select class="form-control" name="cstatus" required>
                                                    <option disabled selected>Select Civil Status</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Widow">Widow</option>
                                                </select>
                                            </div>
                                        </div>
                                              <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Religion</label>
                                                <input type="text" class="form-control" placeholder="Enter Religion" name="religion" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Citizenship</label>
                                                <input type="text" class="form-control" placeholder="Enter Citizenship" name="bplace" required>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="row">
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Street Name (ex. Purok 6)</label>
                                                <input type="text" class="form-control" placeholder="Enter Street" name="street" required>
                                            </div>
                                        </div>
                                      
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Barangay</label>
                                                <select class="form-control vstatus" required name="brgy">
                                                    <option disabled selected>Select Barangay</option>
                                                    <option value="Arawan">Arawan</option>
    <option value="Bagong Niing">Bagong Niing</option>
    <option value="Balat Atis">Balat Atis</option>
    <option value="Briones">Briones</option>
    <option value="Bulihan">Bulihan</option>
    <option value="Buliran">Buliran</option>
    <option value="Callejon">Callejon</option>
    <option value="Corazon">Corazon</option>
    <option value="Del Valle">Del Valle</option>
    <option value="Loob">Loob</option>
    <option value="Magsaysay">Magsaysay</option>
    <option value="Matipunso">Matipunso</option>
    <option value="Niing">Niing</option>
    <option value="Poblacion">Poblacion</option>
    <option value="Pulo">Pulo</option>
    <option value="Pury">Pury</option>
    <option value="Sampaga">Sampaga</option>
    <option value="Sampaguita">Sampaguita</option>
    <option value="San Jose">San Jose</option>
    <option value="Sinturisan">Sinturisan</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                     
                                            <div class="form-group">
                                                <label>Municipality</label>
                                                <input type="text" class="form-control" placeholder="Enter Municipality" name="municipality" required>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row" >
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input type="text" class="form-control" placeholder="Enter Contact Number" name="contact_no" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Province</label>
                                                <input type="text" class="form-control" placeholder="Enter Province" name="province" required>
                                            </div>
                                        </div>
                                    </div>
                                         <div class="row" >
                              
                         <!--   <div class="col-md-4">
                            <div class="form-group">
                                 
                                 <label for="formFile" class="form-label">Valid ID</label>
                                 <input class=" form-control form-control-sm" type="file" id="formFile" name="validid" accept=".png, .jpg, .jpeg, .docx, .pdf" required>
                            
                             </div>
                             </div> -->
                             <div class="col-md-4">
                             <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password" required>
                                    <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                             </div>
                             </div>  

                             <!--       <div class="row" >
                                    <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password">
                                    <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" placeholder="Enter Confirm Password" name="password" id="password">
                                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>
                                </div>
                             </div>   -->
                            

                               </div>
                            </div>
                            <div class="form-group" style="border-top:1px solid white; background-color: green;margin-top:15px;">
                                <div class="terms">
                                    <input type="checkbox" id="terms" name="terms" required>
                                    I Agree to the <a href="terms_and_conditions.php"style="color:white;"> <strong>Terms and Condition </strong></a> and  <a href="privacy.php"  style="color:white;"><strong>Privacy Policy </strong> </a></h4>
                                </div>
                            </div>  
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="window.location.href='login.php'" >Close</button>
                            <button type="submit" class="btn btn-primary" name="save">Save</button>
                        </div>
                        </div>
                        <hr>


                       
                     
                        </form>
                    </div>
                </div>
            </div>


                   
              
			</div>
		</div>
	</div>
	<?php include 'templates/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
   









   
   
   
   

   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
