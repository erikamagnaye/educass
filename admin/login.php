<?php 
	session_start(); 
	if(isset($_SESSION['username'])){
		header('Location: dashboard.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'templates/header.php' ?>
	<title>Login </title>
	<link rel="icon" href="assets/img/logo.png" type="image/x-icon"/>   <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->
	<link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
       
	<style>
     body{
    background: url('assets/img/saqbound.jpg') no-repeat center center fixed; 
    background-size: cover;
  
}

        .container-login {
            background-color: rgba(255, 255, 255, 0.8); /* Optional: Adds a slight white overlay for readability */
            border-radius: 10px;
            padding: 20px;
        }
    </style>
</head>
<body >
<?//php include 'templates/loading_screen.php' ?>
	

	<div class="row d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-12">
            <div class="card mb-3 mt-3" style="width: 80%; margin: 0 auto;">
                <img src="assets/img/saq.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="container centered mt-3">
                        <div class="col-md-6 offset-md-3">
                            <div class="card card-border text-center mb-3">
                                <div class="card-body">
                                    <h1 class="card-title text-center mt-3" style="font-weight: bold;">Admin Login</h1><br>
                                    <form method="POST" action="model/login.php">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput" name="username" placeholder="username" required>
                                            <label for="floatingInput">Username</label>
                                        </div>
                                        <div class="form-floating">
                                            <input type="password" id="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                                            <label for="floatingPassword">Password</label>
                                            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>

                                        <div class="my-2 d-flex justify-content-between align-items-center">
                                            <!-- <input type="checkbox" name="remember" <?php if (isset($_COOKIE['username'])) { ?> checked <?php } ?> /> Remember me -->
                                            <a href="forgot-password.php" class="auth-link" style="color:green;text-decoration:none;">Forgot password?</a>
                                        </div><br>
                                        <div class="form-action mb-3"style="padding: 5px; margin-:0, 10px;">
                                          
                                            <button type="submit" class="btn btn-round btn-primary"  name="submit">Login</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <p>&copy Web Based Educational Assistance Application System 2024</p>
                </div>
            </div>
        </div>

    </div>
	<!--  ALERT FOR LOGIN-->
	<?php if (isset($_SESSION['message'])) : ?> 
                                <script>
                                    Swal.fire({
                                        title: '<?php echo $_SESSION['title']; ?>',
                                        text: '<?php echo $_SESSION['message']; ?>',
                                        icon: '<?php echo $_SESSION['success']; ?>',
                                        confirmButtonText: 'OK'
                                    });
                                </script>
                                <?php unset($_SESSION['message']);
                                unset($_SESSION['success']); unset($_SESSION['title']); ?>
                            <?php endif; ?>

							
	<?php include 'templates/footer.php' ?>
	<script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
</body>
</html>
