<?php 
session_start(); 
include ('server/server.php');

if (isset($_POST['reset'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $newpass = md5($conn->real_escape_string($_POST['newpassword']));

    if (!empty($email) && !empty($username) && !empty($newpass)) {
        // Join admin and staff tables to check for email and username
        $query = "SELECT admin.*, staff.* FROM admin 
                  JOIN staff ON staff.staffid = admin.empid 
                  WHERE staff.email = '$email' AND admin.username = '$username'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // User found, update password
            $updateQuery = "UPDATE `staff` 
                            SET `password` = '$newpass' 
                            WHERE `email`= '$email'";
            if ($conn->query($updateQuery) === TRUE) {
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
                        <input id="username" name="username" type="text" class="form-control input-border-bottom" required>
                        <label for="username" class="placeholder">Username</label>
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
