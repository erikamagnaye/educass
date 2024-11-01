<?php 
session_start();
include 'server.php';

$skTypes = array(
    'SK-Arawan', 'SK-Bagong Niing', 'SK-Balat Atis', 'SK-Briones', 'SK-Bulihan', 
    'SK-Buliran', 'SK-Callejon', 'SK-Corazon', 'SK-Del Valle', 'SK-Loob', 
    'SK-Magsaysay', 'SK-Matipunso', 'SK-Niing', 'SK-Poblacion', 'SK-Pulo', 
    'SK-Pury', 'SK-Sampaga', 'SK-Sampaguita', 'SK-San Jose', 'SK-Sinturisan'
);

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    //$position = $_POST['position'];

    if (!empty($username) && !empty($password) ) {
        // Query to check the staff table
        $query = "SELECT * FROM staff WHERE email = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $userData = $result->fetch_assoc();
            if (password_verify($password, $userData['password'])) {
                // Redirect based on position
                if ($userData['position'] == 'Admin') {
                    $_SESSION['id'] = $userData['staffid'];
                    $_SESSION['username'] = $userData['firstname'];
                    $_SESSION['role'] = $userData['position'];
                    $_SESSION['avatar'] = $userData['image'];
                    $_SESSION['email'] = $userData['email'];
                    header('location: admin/dashboard.php');
                    exit();
                } elseif ($userData['position'] == 'Staff') {
                    $_SESSION['id'] = $userData['staffid'];
                    $_SESSION['username'] = $userData['firstname'];
                    $_SESSION['role'] = $userData['position'];
                    $_SESSION['email'] = $userData['email'];
                    $_SESSION['avatar'] = $userData['image'];
                    header('location: staff/employeedashboard.php');
                    exit();
                } elseif (in_array($userData['position'], $skTypes)) {
                    $_SESSION['id'] = $userData['staffid'];
                    $_SESSION['email'] = $userData['email'];
                    $_SESSION['role'] = $userData['position'];
                    $_SESSION['avatar'] = $userData['image'];
                    $_SESSION['skpos'] = str_replace('SK-', '', $userData['position']);
                    header('location: sk/skdashboard.php');
                    exit();
                }
            } else {
                $_SESSION['message'] = 'Invalid email or password!';
                $_SESSION['success'] = 'error';
                $_SESSION['title'] = 'Error';
                header('location: login.php');
                exit();
            }
        } else {
            //  check the student table
            $query = "SELECT * FROM student WHERE email = ? ";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $userData = $result->fetch_assoc();
                if (password_verify($password, $userData['password'])) {
                    if ($userData['position'] == 'Student' && $userData['is_activated'] == 1) {
                        $_SESSION['studentid'] = $userData['studid'];
                        $_SESSION['name'] = $userData['firstname'];
                        $_SESSION['email'] = $userData['email'];
                        $_SESSION['avatar'] = $userData['picture'];
                        $_SESSION['role'] = $userData['position'];
                        header('location: applicants/dashboard.php');
                        exit();
                    } else {
                        $_SESSION['message'] = 'Your account is not activated yet! Please, check your email';
                        $_SESSION['success'] = 'error';
                        $_SESSION['title'] = 'Account Not Activated';
                        header('location: login.php');
                        exit();
                    }
                } else {
                    $_SESSION['message'] = 'Invalid email or password!';
                    $_SESSION['success'] = 'error';
                    $_SESSION['title'] = 'Error';
                    header('location: login.php');
                    exit();
                }
            } else {
                // Unauthorized position or account not found
                if (in_array($position, array_merge(['Admin', 'Staff', 'Student'], $skTypes))) {
                    $_SESSION['message'] = 'You are not authorized to access the system!';
                    $_SESSION['success'] = 'error';
                    $_SESSION['title'] = 'Unauthorized Access';
                    header('location: login.php');
                    exit();
                } else {
                    $_SESSION['message'] = 'Invalid position or user type!';
                    $_SESSION['success'] = 'error';
                    $_SESSION['title'] = 'Invalid Data';
                    header('location: login.php');
                    exit();
                }
            }
        }
    } else {
        $_SESSION['message'] = 'Please fill in all fields!';
        $_SESSION['success'] = 'error';
        $_SESSION['title'] = 'Error';
        header('location: login.php');
        exit();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>

	<title>Login </title>
	<link rel="icon" href="assets/img/logo.png" type="image/x-icon"/>   <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->
	<link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
       
        <link rel="icon" href="admin/assets/img/logo.png" type="image/x-icon" /> <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->
    <link rel="stylesheet" href="admin/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="admin/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="admin/vendors/css/vendor.bundle.base.css">
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
                <img src="saq.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="container centered mt-3">
                        <div class="col-md-6 offset-md-3">
                            <div class="card card-border text-center mb-3">
                                <div class="card-body">
                                    <h1 class="card-title text-center mt-3" style="font-weight: bold;"> Login</h1><br>
                                    <form method="POST" action="">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="floatingInput" name="username" placeholder="Email" required>
                                            <label for="floatingInput">Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
    <label for="password">Password</label>
    <span toggle="#password" style="color:blue;" class="fa fa-fw fa-eye field-icon toggle-password"></span>
</div>

                                        <div class="form-floating">
  <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="position">
    <option disabled selected>Select user type </option>
    <option value="Admin">Admin</option>
    <option value="Staff">Staff</option>
    <option value="Student">Student</option>
    <option value="SK-Arawan">SK-Arawan</option>
    <option value="SK-Bagong Niing">SK-Bagong Niing</option>
    <option value="SK-Balat Atis">SK-Balat Atis</option>
    <option value="SK-Briones">SK-Briones</option>
    <option value="SK-Bulihan">SK-Bulihan</option>
    <option value="SK-Buliran">SK-Buliran</option>
    <option value="SK-Callejon">SK-Callejon</option>
    <option value="SK-Corazon">SK-Corazon</option>
    <option value="SK-Del Valle">SK-Del Valle</option>
    <option value="SK-Loob">SK-Loob</option>
    <option value="SK-Magsaysay">SK-Magsaysay</option>
    <option value="SK-Matipunso">SK-Matipunso</option>
    <option value="SK-Niing">SK-Niing</option>
    <option value="SK-Poblacion">SK-Poblacion</option>
    <option value="SK-Pulo">SK-Pulo</option>
    <option value="SK-Pury">SK-Pury</option>
    <option value="SK-Sampaga">SK-Sampaga</option>
    <option value="SK-Sampaguita">SK-Sampaguita</option>
    <option value="SK-San Jose">SK-San Jose</option>
    <option value="SK-Sinturisan">SK-Sinturisan</option>
  </select>
  <label for="floatingSelect">User Type</label>
</div>
                                        <div class="my-2 d-flex justify-content-between align-items-center">
                                            <!-- <input type="checkbox" name="remember" <?php if (isset($_COOKIE['username'])) { ?> checked <?php } ?> /> Remember me -->
                                            <a href="forgot-password.php" class="auth-link" style="color:green;text-decoration:none;">Forgot password?</a>
                                        </div><br>
                                        <div class="form-action mb-3"style="padding: 5px; margin-:0, 10px;">
                                        <button type="button" class="btn btn-outline-danger" onclick="location.href='index.php'">Cancel</button>
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

                            <script>
    document.addEventListener("DOMContentLoaded", function() {
        const togglePassword = document.querySelector('.toggle-password');
        const passwordField = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>
						

</body>
</html>
