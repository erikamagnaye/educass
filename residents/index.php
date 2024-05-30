<?php
session_start();
error_reporting(0);
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to check user credentials
    $sql = "SELECT * FROM tblresident WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User authenticated, redirect to success page
        $_SESSION['login'] = $_POST['email'];
		$_SESSION['id'] = $result['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        // Authentication failed, redirect to login page with error message
        header("Location: index.php?error=1");
        exit();
    }
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Form</title>
<style>
    
    body {
        font-family: Arial, sans-serif;
        background-color: #f1f1f1;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background-color: #fff;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        width: 300px;
    }

    input {
        width: 100%;
        padding: 8px;
        margin: 5px 0;
        box-sizing: border-box;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .message {
        text-align: center;
    }

</style>
</head>

<body>
<div class="container" id="loginForm" >
<form method="POST" action="index.php">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1">
 
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" >
  </div>
  <div>
  <p class="message">Not registered? <a href="register.php">Create an account</a></p>
  </div>
  <button type="submit">Login</button>
 
</form>
</div>

<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>
<script>
    <?php if(isset($_GET['error']) && $_GET['error'] == 1): ?>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Incorrect email or password!',
        confirmButtonColor: '#007bff',
        confirmButtonText: 'OK'
    });
    <?php endif; ?>
</script>
</body>
</html>
