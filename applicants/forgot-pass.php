
<?php
session_start();
include('server/server.php');

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $newpass = $_POST['newpassword'];

    if (!empty($email) && !empty($contact_no) && !empty($newpass)) {
        // Check if user exists
        $checkStmt = $conn->prepare("SELECT * FROM student WHERE email = ? AND contact_no = ?");
        $checkStmt->bind_param("ss", $email, $contact_no);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            // User found, update password
            $hashed_password = password_hash($newpass, PASSWORD_DEFAULT);
            $updateStmt = $conn->prepare("UPDATE `student` SET `password` = ? WHERE `email` = ? AND `contact_no` = ?");
            $updateStmt->bind_param("sss", $hashed_password, $email, $contact_no);
            if ($updateStmt->execute()) {
                $_SESSION['message'] = 'Password successfully reset!';
                $_SESSION['success'] = 'success';
            } else {
                $_SESSION['message'] = 'Error updating password!';
                $_SESSION['success'] = 'danger';
            }
        } else {
            // User not found
            $_SESSION['message'] = 'Invalid Credentials. Please, Try again!';
            $_SESSION['success'] = 'danger';
        }
    } else {
        $_SESSION['message'] = 'Please fill in all fields!';
        $_SESSION['success'] = 'danger';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'templates/header.php' ?>
    <title>Reset Password</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
<style>
        body.login {
    background: url('assets/img/saqbound.jpg') no-repeat center center fixed; 
    background-size: cover;
  
}
</style>
</head>
<body class="login">
<?php include 'templates/loading_screen.php' ?>
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-<?= $_SESSION['success']; ?> <?= $_SESSION['success']=='danger' ? 'bg-danger text-light' : null ?>" role="alert">
                    <?= $_SESSION['message']; ?>
                </div>
            <?php unset($_SESSION['message']); ?>
            <?php endif ?>
            <h3 class="text-center">Reset Password </h3>
            <div class="login-form">
                <form method="POST" action="">
                    <div class="form-group form-floating-label">
                        <input id="email" name="email" type="email" class="form-control input-border-bottom" required>
                        <label for="email" class="placeholder">Email</label>
                    </div>
                    <div class="form-group form-floating-label">
                        <input id="username" name="contact_no" type="tel" class="form-control input-border-bottom" required>
                        <label for="username" class="placeholder">Phone Number</label>
                    </div>
                    <div class="form-group form-floating-label">
                        <input id="password" name="newpassword" type="password" class="form-control input-border-bottom" required>
                        <label for="password" class="placeholder">New Password</label>
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary me-2" name="reset">Reset</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='login.php';">Cancel</button>
                </form>
            </div>
        </div>
    </div>
    <?php include 'templates/footer.php' ?>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <script>
  
    </script>
</body>
</html>
