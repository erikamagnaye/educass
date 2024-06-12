<?php 
	session_start(); 
	if(isset($_SESSION['name'])){
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
	<style>
     body.login {
    background: url('assets/img/background.jpg') no-repeat center center fixed; 
    background-size: cover;
  
}

        .container-login {
            background-color: rgba(255, 255, 255, 0.8); /* Optional: Adds a slight white overlay for readability */
            border-radius: 10px;
            padding: 20px;
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
			<h3 class="text-center">Applicants Login </h3>
			<div class="login-form">
                <form method="POST" action="model/login.php">
					<div class="form-group form-floating-label">
						<input id="username" name="email" type="text" class="form-control input-border-bottom" required >
						<label for="username" class="placeholder">Email Address</label>
					</div>
					<div class="form-group form-floating-label">
						<input id="password" name="password" type="password" class="form-control input-border-bottom" required >
						<label for="password" class="placeholder">Password</label>
						<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					</div>
					<div class="my-2 d-flex justify-content-between align-items-center">
                    <a href="createacc.php" class="auth-link text-black"> Create Account</a>
						<a href="forgot-pass.php" class="auth-link text-black">Forgot password?</a>
					</div><br>
					<div class="form-action mb-3">
						<button type="submit" class="btn btn-primary btn-rounded btn-login">Login</button>
                        <br>
                     	</div>
                         <div class=" align-items-center text-center">
                    <a href="index.php" class="auth-link text-red" style="color: red;"> Cancel</a>
						
					</div>
                </form>
			</div>
		</div>
	</div>
	<?php include 'templates/footer.php' ?>
	<script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
</body>
</html>
