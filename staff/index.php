<?php 
	session_start(); 

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
 
	<style>


      
    </style>
</head>
<body >
  
<div class="row d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="col-md-12">
    <div class="card mb-3 mt-3" style="width: 80%; margin: 0 auto;">
      <img src="assets/img/saq.jpg" class="card-img-top" alt="...">
      <div class="card-body">
        <div class="container centered mt-3">
          <div class="col-md-8 offset-md-2">
            <div class="card card-border text-center mb-3">
              <div class="card-body">
                <h1 class="card-title text-center mt-3" style="font-weight: bold;">Educational Assistance Application System for San Antonio, Quezon</h1><br><br><br>
                <h5 class="card-text text-center">Login as</h5><br>
                <div class="text-center">
                <button type="button" class="btn btn-outline-primary" onclick="location.href='employeelogin.php'">Employee</button>
                <button type="button" class="btn btn-outline-warning" onclick="location.href='sklogin.php'">SK Official</button>
              </div>
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




	<?php include 'templates/footer.php' ?>
	<script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
</body>
</html>
