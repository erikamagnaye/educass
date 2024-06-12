   
   
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
    background: url('assets/img/saqbound.jpg') no-repeat center center fixed; 
    background-size: cover;
  
}

.container-login {
    background-color: rgba(0, 0, 0, 0.5); /* Black background with 50% opacity */
    border-radius: 10px;
    padding: 20px;
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

    </style>
</head>
<body class="login">
<?php include 'templates/loading_screen.php' ?>
<br>
	<div class="wrapper ">


		<div class="container container-login animated fadeIn">
            <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-<?= $_SESSION['success']; ?> <?= $_SESSION['success']=='danger' ? 'bg-danger text-light' : null ?>" role="alert">
                    <?= $_SESSION['message']; ?>
                </div>
            <?php unset($_SESSION['message']); ?>
            <?php endif ?>
			<h2 class="text-center">Create an Account</h2>
			<div class="login-form">
              
                            <form method="POST" action="model/save_resident.php" enctype="multipart/form-data">
                            <input type="hidden" name="size" value="1000000">
                            <div class="row">
                                <div class="col-md-4">
                                    <div style="width: 340px; height: 230;" class="text-center" id="my_camera">
                                        <img src="assets/img/person.png" alt="..." class="img img-fluid" width="250" >
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
                                        <input type="file" class="form-control" name="img" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Valid ID</label>
                                        <input class="form-control" type="file" id="formFile">
                                    </div>
                                    </div>
                                 
                                </div>
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
                                                <label>Religion</label>
                                                <input type="text" class="form-control" placeholder="Enter Religion" name="religion">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Place of Birth</label>
                                                <input type="text" class="form-control" placeholder="Enter Birthplace" name="bplace" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Birthdate</label>
                                                <input type="date" class="form-control" placeholder="Enter Birthdate" name="bdate" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input type="number" class="form-control" placeholder="Enter Age" min="1" name="age" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label>Civil Status</label>
                                                <select class="form-control" name="cstatus">
                                                    <option disabled selected>Select Civil Status</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Widow">Widow</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select class="form-control" required name="gender">
                                                    <option disabled selected value="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Street Name (ex. Purok 6)</label>
                                                <input type="text" class="form-control" placeholder="Enter Birthplace" name="street" required>
                                            </div>
                                        </div>
                                      
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Barangay</label>
                                                <select class="form-control vstatus" required name="vstatus">
                                                    <option disabled selected>Select Barangay</option>
                                                    <option value="Yes">Arawan</option>
                                                    <option value="No">Bagong Niing</option>
                                                    <option value="Yes">Balat Atis</option>
                                                    <option value="No">Briones</option>
                                                    <option value="Yes">Bulihan</option>
                                                    <option value="No">Buliran</option>
                                                    <option value="Yes">Callejon</option>
                                                    <option value="No">Corazon</option>
                                                    <option value="Yes">Del Valle</option>
                                                    <option value="No">Loob</option>
                                                    <option value="Yes">Magsaysay</option>
                                                    <option value="No">Matipunso</option>
                                                    <option value="Yes">Niing</option>
                                                    <option value="No">Poblacion</option>
                                                    <option value="Yes">Pulo</option>
                                                    <option value="No">Pury</option>
                                                    <option value="No">Sampaga</option>
                                                    <option value="Yes">Sampaguita</option>
                                                    <option value="No">San Jose</option>
                                                    <option value="Yes">Sintorisan</option>
                                                    
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
                                                <input type="email" class="form-control" placeholder="Enter Email" name="email">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input type="text" class="form-control" placeholder="Enter Contact Number" name="contact_no">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Province</label>
                                                <input type="text" class="form-control" placeholder="Enter Province" name="province">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" >
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
                             </div>   
                            
                               </div>
                            </div>
                        </div>
                        <hr>
<div style="border-bottom:3px solid white;"><br><br>

</div>

                            <h3 class="text-center" style=" background-color:green;padding: 15px;"> Parents Information</h3>
                       
                        <div class="row" style="margin-bottom: 15px;">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Father's Name</label>
                                                <input type="text" class="form-control" placeholder="Enter Firstname" name="fname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input type="text" class="form-control" placeholder="Enter Middlename" name="mname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Occupation</label>
                                                <input type="text" class="form-control" placeholder="Enter Lastname" name="lname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Income</label>
                                                <input type="text" class="form-control" placeholder="Enter Lastname" name="lname" required>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="row" style="border-bottom:1px solid white; margin: top 15px; margin-bottom: 15px;">
                                     
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Educational Attainment</label>
                                                <input type="text" class="form-control" placeholder="Enter Firstname" name="fname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                        <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control vstatus" required name="fstatus">
                                                    <option disabled selected>Select Voters Status</option>
                                                    <option value="Alive">Alive</option>
                                                    <option value="Deceased">Deceased</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Citizenship</label>
                                                <input type="text" class="form-control" placeholder="Enter Lastname" name="lname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Religion</label>
                                                <input type="text" class="form-control" placeholder="Enter Lastname" name="lname" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Mother's Name</label>
                                                <input type="text" class="form-control" placeholder="Enter Firstname" name="fname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input type="text" class="form-control" placeholder="Enter Middlename" name="mname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Occupation</label>
                                                <input type="text" class="form-control" placeholder="Enter Lastname" name="lname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Income</label>
                                                <input type="text" class="form-control" placeholder="Enter Lastname" name="lname" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Educational Attainment</label>
                                                <input type="text" class="form-control" placeholder="Enter Firstname" name="fname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                        <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control vstatus" required name="fstatus">
                                                    <option disabled selected>Status</option>
                                                    <option value="Alive">Alive</option>
                                                    <option value="Deceased">Deceased</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Citizenship</label>
                                                <input type="text" class="form-control" placeholder="Enter Lastname" name="lname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Religion</label>
                                                <input type="text" class="form-control" placeholder="Enter Lastname" name="lname" required>
                                            </div>
                                        </div>
                                    </div>
                        <div class="form-group" style="border-top:1px solid white; background-color: green;margin-top:15px;">
                                <div class="terms">
                                    <input type="checkbox" id="terms" name="terms" required>
                                    <label for="terms">I agree to the collection and use of my information for the educational assistance system. I understand that my information will be used solely for this purpose.</label>
                                    <h3 class="terms" style="color: white;"><a href="terms_and_conditions.html" target="_blank"><span>Read our full Terms and Conditions</span></a></h3>
                                </div>
                            </div>  
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" >Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
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
   









   
   
   
   

   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
