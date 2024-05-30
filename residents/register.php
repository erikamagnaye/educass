<?php include 'server/server.php' ?>

<?php
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

if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $alias = $_POST['alias'];
    $bplace = $_POST['bplace'];
    $bdate = $_POST['bdate'];
    $age = $_POST['age'];
    $cstatus = $_POST['cstatus'];
    $gender = $_POST['gender'];
    $purok = $_POST['purok'];
    $occu = $_POST['occu'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $citizenship = $_POST['citizenship'];
    $rtype = $_POST['rtype'];
    $address = $_POST['address'];
    $password = $_POST['password']; // Added password field

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO tblresident (citizenship, firstname, middlename, lastname, alias, birthplace, birthdate, age, civilstatus, gender, purok, occupation, email, phone, resident_type, `address`, `password`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("ssssssissssssssss", $citizenship, $fname, $mname, $lname, $alias, $bplace, $bdate, $age, $cstatus, $gender, $purok, $occu, $email, $number, $rtype, $address, $password);

    // Execute the statement
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        header("Location: index.php?signup=success");
        exit();
        
    } else {
        header("Location: register.php?signup=failed");
        exit();
    }

    // Close the statement
    //$stmt->close();
}

// Close the database connection
$conn->close();
?>


<!Doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sampal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>

<style>
   .container {
            margin: 15px auto; /* Center the container horizontally */
            width: 70%;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .row {
            margin-right: -20px; /* Remove the default margin-right */
            margin-left: -20px; /* Remove the default margin-left */
        }
        .form-group {
            padding: 0 20px; /* Add padding to match the row's negative margins */
        }
        .btn{
            margin-left: 5px;
        }
        h1{
            align-items: center;
            text-align: center;
            margin-bottom: 20px;
        }
</style>
</head>
<body>
<div class="container">
<form method="POST" action="" >
    <h1>Register Account</h1>
                        <div class="row">
                            <div class="col">
                    <div class="row">
                        <div class="col ">
                            <div class="form-group">
                                <label>Firstname</label>
                                <input type="text" class="form-control"  name="fname" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Middlename</label>
                                <input type="text" class="form-control"  name="mname" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Lastname</label>
                                <input type="text" class="form-control"  name="lname" required>
                            </div>
                        </div>
                    </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Alias</label>
                                        <input type="text" class="form-control"  name="alias">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Place of Birth</label>
                                        <input type="text" class="form-control"  name="bplace" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Birthdate</label>
                                        <input type="date" class="form-control"  name="bdate" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                    <label>Age</label>
                                        <input type="number" class="form-control"  min="1" name="age" required>
                                    </div>
                                </div>
                                
                                <div class="col">
                                    <div class="form-group">
                                        <label>Civil Status</label>
                                        <select class="form-control" name="cstatus" required>
                                            <option value="">Select Civil Status</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                            <option value="Separated">Separated</option>
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="col">
                                <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                <div class="form-group">
                                        <label>Purok</label>
                                        <select class="form-control" name="purok" required>
                                            <option value="">Select Purok</option>
                                            <option value="Male">Purok 1</option>
                                            <option value="Male">Purok 2</option>
                                            <option value="Male">Purok 3</option>
                                            <option value="Male">Purok 4</option>
                                            <option value="Male">Purok 5</option>
                                            <option value="Male">Purok 6</option>
                                            <option value="Male">Purok 7</option>

                                            <?php foreach($purok as $p): ?>
                                               <option value="<?= $p['name'] ?>"><?= $p['name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col">
                                <div class="form-group">
                                        <label>Occupation</label>
                                        <input type="text" class="form-control"  name="occu" required>
                                    </div>
                                </div>
                               
                                <div class="col">
                                <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control"  name="email" required>
                                    </div>
                                </div>
                            </div>
           <!--new row-->       <div class="row">
                                <div class="col">
                                <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control"  name="number" required>
                                    </div>
                                </div>
                                
                                <div class="col">
                                <div class="form-group">
                                        <label>Resident Type</label>
                                        <select class="form-control" name="rtype" required>
                                            <option value="">Select Resident Type</option>
                                            <option value="Alive">Alive</option>
                                            <option value="Deceased">Deceased</option>
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="col">
                                <div class="form-group">
                                        <label>Citizenship</label>
                                        <input type="text" class="form-control" name="citizenship"  required>
                                    </div>
                                </div>
                            </div>
                            
                     

  <!--new row-->       <div class="row">
                        <div class="col">
                                <div class="form-group">
                                         <label>Address</label>
                                        <input type="text" class="form-control"  name="address" required>
                                    </div>
                                </div>
                                
                                <div class="col">
                                <div class="form-group">
                                <label>password</label>
                                        <input type="password" class="form-control" placeholder="" name="password" required>
                                    </div>
                                </div>
                               
                              
                            </div>


                                <div class="col mt-3">
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-secondary mr-2" onclick="window.location.href='index.php'">Cancel</button>
                                <button type="submit" class="btn btn-primary ml-2" name="register">Register </button>
                            </div>
                        </div>
                            </div>
                          
                    </div>
                   
                </form>
       </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>
<script>
    <?php if(isset($_GET['signup']) && $_GET['signup'] == 'success'): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Account created successfully!',
            confirmButtonColor: '#007bff'
        });
    <?php endif; ?>

    <?php if(isset($_GET['signup']) && $_GET['signup'] == 'failed'): ?>
        Swal.fire({
            icon: 'error',
            title: 'Ooops!',
            text: 'Account creation Failed!',
            confirmButtonColor: '#007bff'
        });
    <?php endif; ?>
</script>

</body>
</html>
