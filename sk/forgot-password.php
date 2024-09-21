<?php 
session_start(); 
include ('server/server.php');

if (isset($_POST['reset'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $newpass = password_hash($conn->real_escape_string($_POST['newpassword']), PASSWORD_DEFAULT);
    $skTypes = array(
        'SK-Arawan',
        'SK-Bagong Niing',
        'SK-Balat Atis',
        'SK-Briones',
        'SK-Bulihan',
        'SK-Buliran',
        'SK-Callejon',
        'SK-Corazon',
        'SK-Del Valle',
        'SK-Loob',
        'SK-Magsaysay',
        'SK-Matipunso',
        'SK-Niing',
        'SK-Poblacion',
        'SK-Pulo',
        'SK-Pury',
        'SK-Sampaga',
        'SK-Sampaguita',
        'SK-San Jose',
        'SK-Sinturisan'
    ); 
    if (!empty($email) && !empty($newpass)) {
        // Prepare the query to check for email and username
        $query = "SELECT* FROM staff
                  WHERE staff.email = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $staffData = $result->fetch_assoc();
            if (in_array($staffData['position'], $skTypes)) {
                // User found, update password
                $updateQuery = "UPDATE `staff` 
                                SET `password` = ? 
                                WHERE `email` = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("ss", $newpass, $email);
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Password successfully reset!';
                    $_SESSION['success'] = 'success';
                } else {
                    $_SESSION['message'] = 'Error updating password!';
                    $_SESSION['success'] = 'error';
                }
            } else {
                // Staff position is in SK types, do not update password
                $_SESSION['message'] = 'You are not an authorize user!';
                $_SESSION['success'] = 'error';
            }
        } else {
            // User not found
            $_SESSION['message'] = 'Invalid Credentials. Please, Try again!';
            $_SESSION['success'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Please fill in all fields!';
        $_SESSION['success'] = 'error';
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
     
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
        
            <h3 class="text-center">Reset Password </h3>
            <div class="login-form">
                <form method="POST" action="">
                    <div class="form-group form-floating-label">
                        <input id="email" name="email" type="email" class="form-control input-border-bottom" required>
                        <label for="email" class="placeholder">Email</label>
                    </div>

                    <div class="form-group form-floating-label">
                        <input id="password" name="newpassword" type="password" class="form-control input-border-bottom" required>
                        <label for="password" class="placeholder">New Password</label>
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary me-2" name="reset">Reset</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='sklogin.php';">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['message'])) : ?> 
                                <script>
                                    Swal.fire({
                                        title: '<?php echo $_SESSION['success']; ?>',
                                        text: '<?php echo $_SESSION['message']; ?>',
                                        icon: '<?php echo $_SESSION['success']; ?>',
                                        confirmButtonText: 'OK'
                                    });
                                </script>
                                <?php unset($_SESSION['message']);
                                unset($_SESSION['success']); ?>
                            <?php endif; ?>

    <?php include 'templates/footer.php' ?>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <script>
  
    </script>
</body>
</html>
