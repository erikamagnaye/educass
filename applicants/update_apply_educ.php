<?php include 'server/server.php' ?>

<?php 

session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0) || !isset($_SESSION['id']) || !isset($_SESSION['email'])) {
	header('location:login.php');
    exit();
}

else {
//we need to retrieve existing information of the students so they won't have to input their info again
if (isset($_GET['educid']) && isset($_GET['appid'])) { // this is from educaids.php, this educid will be used for applying for the educ aids
    $educationalid = $_GET['educid'];
    $applicationid = $_GET['appid'];

$studid = $_SESSION['id'];
$email = $_SESSION['email'];
$query = "SELECT * FROM `student` where studid= $studid"; // SQL query to fetch all table data
$student_data = mysqli_query($conn, $query); // sending the query to the database

// displaying all the data retrieved from the database using while loop
while ($row = mysqli_fetch_assoc($student_data)) {
               
    $lastname = $row['lastname'];        
    $firstname = $row['firstname'];         
    $midname = $row['midname'];  
    $email = $row['email'];           
    $birthday = $row['birthday'];        
    $contact_no = $row['contact_no'];         
    $brgy = $row['brgy'];  
    $municipality = $row['municipality']; 
    $province = $row['province'];         
    $street_name = $row['street_name'];  
    $gender = $row['gender'];           
    $citizenship = $row['citizenship'];        
    $religion = $row['religion'];         
    $age = $row['age'];  
    $civilstatus = $row['civilstatus']; 
}


$course = ''; // initialize 
$major = ''; // initialize 
$school_name = ''; // initialize mjor
$school_address = ''; // initialize 
//CODE TO RETRIEVE DATA ABOUT COURSE/EDUCATIONAL BACKGROUND
$educbg = "SELECT * FROM `studentcourse` where studid= $studid and educid = $educationalid order by courseid desc limit 1"; // SQL query to fetch all table data
$studcourse = mysqli_query($conn, $educbg); // sending the query to the database

// displaying all the data retrieved from the database using while loop
while ($data = mysqli_fetch_assoc($studcourse)) {
    $courseid= $data['courseid'];         
        
    $course = $data['course'];         
    $major = $data['major'];  
    $school_name = $data['school_name'];           
    $school_address = $data['school_address'];     
    $semester = $data['sem'];  
    $schoolyear = $data['sy'];  
    $yearlevel = $data['year'];     
   
}

//CODE TO RETRIEVE PARENTS INFO
$parentname = ''; // initialize 
$parentage = ''; // initialize 
$parent_occu = ''; // initialize mjor
$parent_income = ''; // initialize 
$parent_status= ''; // initialize mjor
$parent_educattain = ''; // initialize 
$parent_address = ''; // initialize 
$parent_contact = ''; // initialize 
 
//CODE TO RETRIEVE DATA ABOUT COURSE/EDUCATIONAL BACKGROUND
$parent = "SELECT * FROM `parentinfo` where studid= $studid"; // SQL query to fetch all table data
$studparent = mysqli_query($conn, $parent); // sending the query to the database

// displaying all the data retrieved from the database using while loop
while ($parents = mysqli_fetch_assoc($studparent)) {
               
    $parentid= $parents['parentid']; // use this for application
    $parentname = $parents['parentname'];
    $parentage = $parents['parentage'];
    $parent_occu = $parents['parent_occu'];
    $parent_income = $parents['parent_income'];
    $parent_status = $parents['parent_status'];
    $parent_educattain = $parents['parent_educattain'];
    $parent_address = $parents['parent_address'];
    $parent_contact = $parents['parent_contact'];
     
   
}
$letter = '';
$schoolid = '';
$cor = '';
$indigency = '';
$grades = '';
$req="SELECT *
FROM `requirements` join application on requirements.reqid= application.reqid WHERE `application`.`appid` = $applicationid AND `requirements`.`educid` = $educationalid AND `requirements`.`studid` = $studid"; ;
 $viewreq = mysqli_query($conn, $req);

 if ($rowreq = mysqli_fetch_assoc($viewreq)) {
    $reqid = $rowreq['reqid'];
    $letter = $rowreq['letter'];
    $schoolid = $rowreq['schoolid'];
    $cor = $rowreq['cor'];
    $indigency = $rowreq['indigency'];
    $grades = $rowreq['grades'];
 }
}


//====================================================================THIS HANDLE SUBMISSION    FOR UPDATING INFORMATION-----------------------------------------
if (isset($_POST['submit'])) { // this is from apply_educ.php

 


    $studid = $_POST['studid'];
    $educid = $_POST['educid'];
    $appid = $_POST['appid'];
    $reqid = $_POST['reqid'];
    $courseid = $_POST['courseid'];
    $parentid = $_POST['parentid'];

     // PERSONAL INFO
     $lastname = $_POST['lastname'];
     $firstname = $_POST['firstname'];
     $midname = $_POST['midname'];
     $email = $_POST['email'];
     $birthday = $_POST['birthday'];
     $contact_no = $_POST['contact_no'];
     $brgy = $_POST['brgy'];
     $municipality = $_POST['municipality'];
     $province = $_POST['province'];
     $street_name = $_POST['street_name'];
     $gender = $_POST['gender'];
     //$citizenship = $_POST['citizenship'];
    // $religion = $_POST['religion'];
     $age = $_POST['age'];
     //$civilstatus = $_POST['civilstatus'];

      // Track success of each update operation
    $success = true;

     $stmt = $conn->prepare("UPDATE student SET 
    lastname = ?, 
    firstname = ?, 
    midname = ?, 
    email = ?, 
    birthday = ?, 
    contact_no = ?, 
    brgy = ?, 
    municipality = ?, 
    province = ?, 
    street_name = ?, 
    gender = ?, 
    age = ?
    WHERE studid = ?");

$stmt->bind_param("sssssssssssii", 
    $lastname, 
    $firstname, 
    $midname, 
    $email, 
    $birthday, 
    $contact_no, 
    $brgy, 
    $municipality, 
    $province, 
    $street_name, 
    $gender, 
   $age,
    $studid);

    if (!$stmt->execute()) {
        $success = false;
    }

     // COURSE INFO
     $course = $_POST['course'];
     $major = $_POST['major'];
     $school_name = $_POST['school_name'];
     $school_address = $_POST['school_address'];
     $sem = $_POST['sem'];
     $sy = $_POST['sy'];
     $year = $_POST['year'];


     $stmt = $conn->prepare("UPDATE studentcourse SET 
     course = ?, 
     major = ?, 
     school_name = ?, 
     school_address = ?, 
     sem = ?, 
     `year` = ?, 
     sy = ? 
     WHERE courseid = ?");
 
 $stmt->bind_param("sssssssi", 
     $course, 
     $major, 
     $school_name, 
     $school_address, 
     $sem, 
     $year, 
     $sy, 
     $courseid);
 
     if (!$stmt->execute()) {
        $success = false;
    }
 

   

     // PARENT INFO
     $parentname = $_POST['parentname'];
     $parentage = $_POST['parentage'];
     $parent_occu = $_POST['parent_occu'];
     $parent_income = $_POST['parent_income'];
     $parent_status =$_POST['parent_status'];
     $parent_educattain = $_POST['parent_educattain'];
     $parent_address = $_POST['parent_address'];
     $parent_contact = $_POST['parent_contact'];
      

   

 
     $stmt = $conn->prepare("UPDATE parentinfo SET 
     parentname = ?, parentage = ?, parent_occu = ?, parent_income = ?, parent_status = ?, parent_educattain = ?, 
     parent_address = ?, parent_contact = ? 
     WHERE parentid = ?");

// Bind the parameters
$stmt->bind_param("ssssssssi", $parentname, $parentage, $parent_occu, $parent_income, $parent_status, $parent_educattain, $parent_address, $parent_contact, $parentid);

// Execute the prepared statement
if (!$stmt->execute()) {
    $success = false;
}
     
// FILE UPLOADS

    // Retrieve existing file paths from the database (before the update)
    $existingQuery = "SELECT * FROM requirements WHERE reqid = '$reqid'";
    $existingResult = mysqli_query($conn, $existingQuery);
    $existingFiles = mysqli_fetch_assoc($existingResult);

    $existing_coe = $existingFiles['cor'];
    $existing_schoolid = $existingFiles['schoolid'];
    $existing_grades = $existingFiles['grades'];
    $existing_letter = $existingFiles['letter'];
    $existing_indigent = $existingFiles['indigency'];

    // FILE UPLOADS (Check if new file is uploaded or retain the old one)

    // COE (Certificate of Enrollment)
    if (!empty($_FILES['coe']['name'])) {
        $coePath = 'assets/uploads/requirements/coe/' . basename($_FILES['coe']['name']);
        $coe = basename($_FILES['coe']['name']);
        move_uploaded_file($_FILES['coe']['tmp_name'], $coePath);
    } else {
        $coe = $existing_coe; // Retain the original file
    }

    // School ID
    if (!empty($_FILES['schoolid']['name'])) {
        $schoolidPath = 'assets/uploads/requirements/schoolid/' . basename($_FILES['schoolid']['name']);
        $schoolid = basename($_FILES['schoolid']['name']);
        move_uploaded_file($_FILES['schoolid']['tmp_name'], $schoolidPath);
    } else {
        $schoolid = $existing_schoolid; // Retain the original file
    }

    // Grades
    if (!empty($_FILES['grades']['name'])) {
        $gradesPath = 'assets/uploads/requirements/grades/' . basename($_FILES['grades']['name']);
        $grades = basename($_FILES['grades']['name']);
        move_uploaded_file($_FILES['grades']['tmp_name'], $gradesPath);
    } else {
        $grades = $existing_grades; // Retain the original file
    }

    // Letter
    if (!empty($_FILES['letter']['name'])) {
        $letterPath = 'assets/uploads/requirements/letter/' . basename($_FILES['letter']['name']);
        $letter = basename($_FILES['letter']['name']);
        move_uploaded_file($_FILES['letter']['tmp_name'], $letterPath);
    } else {
        $letter = $existing_letter; // Retain the original file
    }

    // Indigent
    if (!empty($_FILES['indigent']['name'])) {
        $indigentPath = 'assets/uploads/requirements/indigent/' . basename($_FILES['indigent']['name']);
        $indigent = basename($_FILES['indigent']['name']);
        move_uploaded_file($_FILES['indigent']['tmp_name'], $indigentPath);
    } else {
        $indigent = $existing_indigent; // Retain the original file
    }

    // Proceed with the database insertion
    $stmt = $conn->prepare("UPDATE requirements SET letter = ?, schoolid = ?, cor = ?, indigency = ?, grades = ? WHERE reqid = ?");
    $stmt->bind_param("sssssi", $letter, $schoolid, $coe, $indigent, $grades, $reqid);

    if (!$stmt->execute()) {
        $success = false;
    }

    // Check if all updates were successful
    if ($success) {
        $_SESSION['alertmess'] = 'You have successfully updated your application.';
        $_SESSION['title'] = 'Successful';
        $_SESSION['success'] = 'success';
    } else {
        $_SESSION['alertmess'] = 'Something went wrong. Please try again.';
        $_SESSION['title'] = 'Error';
        $_SESSION['success'] = 'error';
    }

    header('Location: educaids.php');
    exit;


}

 


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Educational Assistance</title>
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="icon" href="assets/img/logo.png" type="image/x-icon"/>   <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- THIS IS THE CODE TO validate fields-->

<style>
      .progressbar {
            display: flex;
            justify-content: space-between;
            position: center;
            margin-bottom: 30px;
            align-items: center;
        }

        .step {
            text-align: center;
            width: 20%;
            flex: 1;
            position: relative;
        }

        .icon-container {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        

        .progressbar .step .icon {
            background-color: lightgray;
            color: white;
            border-radius: 50%;
            display: inline-block;
            padding: 10px;
            margin-bottom: 10px;
            width: 40px;
            height: 40px;
            line-height: 20px;
            position: relative;
            z-index: 2;
        }

        .progressbar .step .line {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%);
            height: 2px;
            width: 100%;
            background-color: lightgray;
            z-index: 1;
        }

        .progressbar .step.active .icon {
            background-color: #4CAF50;
        }

        .progressbar .step.active .line {
            background-color: #4CAF50;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
        }

        input {
            display: block;
            width: 48%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            margin:10px;
        }

        button {
            padding: 10px 15px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        button:disabled {
            background-color: gray;
        }

        .btn-container {
  text-align: center;
}

.prev-step, .next-step {
  margin: 0 10px;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.prev-step {
  background-color: #4CAF50;
  color: #fff;
}

.next-step {
  background-color: #03A9F4;
  color: #fff;
}

.fas {
  font-size: 16px;
  margin: 0 5px;
}
/*
.form-control {
  height: 40px; 
  padding: 10px;
 margin-left: 30px;margin-right:30px;
  width:350px;
}
select.form-control {
  height: 40px; 
  padding: 10px;
} */
.main-panel {
  font-family: Poppins, sans-serif;
}

.form-control-select {   /* font fam for select options */
  font-family: 'Poppins', sans-serif !important;
}
.main-panel select.form-control {
  font-family: 'Poppins', sans-serif;
}
@media (max-width: 768px) {
    .progressbar .step .icon {
        width: 30px;  /* Reduced icon size */
        height: 30px; /* Reduced icon size */
        padding: 5px; /* Adjust padding to fit smaller icon */
    }

    .progressbar .step .line {
        height: 1px; /* Reduced line thickness */
    }

    .step {
        width: 45%; /* Adjust step width for medium screens */
    }
}

@media (max-width: 480px) {
    .progressbar .step .icon {
        width: 20px;  /* Further reduced icon size */
        height: 20px; /* Further reduced icon size */
        padding: 2px; /* Adjust padding for smaller icons */
    }

    .progressbar .step .line {
        height: 1px; /* Keep line thickness reduced for small screens */
    }
    .progressbar p{
        font-size: 5px;
    }

    .step {
        width: 100%; /* Full width for small screens */
    }
}
</style>
</head>
<body>
	<?//php include 'templates/loading_screen.php' ?>

	<div class="wrapper">
		<!-- Main Header -->
		<?//php include 'templates/main-header.php' ?>
		<!-- End Main Header -->

		<!-- Sidebar -->
		<?//php include 'templates/sidebar.php' ?>
		<!-- End Sidebar -->
 
		
			<div class="content">
				<div class="panel-header ">
					<div class="page-inner">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							
						</div>
					</div>
				</div>
				<div class="page-inner">
				
					<div class="row mt--2 row d-flex justify-content-center align-items-center">
						
						<div class="col-md-10 ">
						
							<div class="card">

<div class="card-header">
                                        <div class="card-head-row">
                                            <div class="card-title"><strong><h1>Update Application</h1></strong> </div>

                                            <div class="card-tools">
                                             
                                                <button class="btn btn-danger btn-border btn-round btn-sm" onclick="history.back()">
      <i class="fas fa-chevron-left"></i> Back
    </button>
                                            </div>

                                        </div>
                                    </div>
								

							
  
        
            
                
                <p class="text-center">Fill out all field and ensure integrity of information</p>
                <form id="multiStepForm" method="POST" action="" enctype="multipart/form-data">
            <!-- Progress Bar -->
            <div class="progressbar">
                <div class="step">
                    <div class="icon-container">
                        <span class="icon information-icon"> <i class="fa-solid fa-user"></i></span>
                        <div class="line"></div>
                    </div>
                    <p>Information</p>
                </div>
                <div class="step">
                    <div class="icon-container">
                        <span class="icon"><i class="fa-solid fa-graduation-cap"></i></span>
                        <div class="line"></div>
                    </div>
                    <p>Course</p>
                </div>
                <div class="step">
                    <div class="icon-container">
                        <span class="icon"><i class="fa-solid fa-user-group"></i></span>
                        <div class="line"></div>
                    </div>
                    <p>Parents</p>
                </div>
                <div class="step">
                    <div class="icon-container">
                        <span class="icon"><i class="fas fa-file-text"></i></span>
                        <div class="line"></div>
                    </div>
                    <p>Requirements</p>
                </div>
                <div class="step">
                    <div class="icon-container">
                        <span class="icon"><i class="fas fa-check"></i></span>
                        <div class="line"></div>
                    </div>
                    <p>Finish</p>
                </div>
            </div>
  <!-- Step 1: Information -->
   
  <div class="form-step active">
  <div class="card-body mx-4">
    <h2 style="margin-left: 30px;margin-right:30px;">Information</h2>

    <div class="row">
   

    <input type="hidden" name="appid" value="<?php echo $applicationid; ?>">
    <input type="hidden" name="educid" value="<?php echo $educationalid; ?>">
    <input type="hidden" name="courseid" value="<?php echo $courseid; ?>">
    <input type="hidden" name="parentid" value="<?php echo $parentid; ?>">
    <input type="hidden" name="studid" value="<?php echo $studid; ?>">
    <input type="hidden" name="reqid" value="<?php echo $reqid; ?>">
    <div class="col-md-4">
                            
                          
                                                <input type="text" class="form-control" placeholder="Enter Firstname" value="<?php echo $firstname; ?>" name="firstname" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Middlename" value="<?php echo $midname; ?>" name="midname" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Lastname" value="<?php echo $lastname; ?>" name="lastname" required>
                                        </div>
    </div>
   <!-- <div class="row">
                                        <div class="col-md-4">                                      
                                                <input type="text" class="form-control" placeholder="Enter Religion" value="<?php echo $religion; ?>" name="religion" required>                                         
                                        </div>
                                        <div class="col-md-4">                                       
                                                <input type="text" class="form-control" placeholder="Enter Citizenship" value="<?php echo $citizenship; ?>" name="citizenship" required>                                       
                                        </div>
                                        <div class="col-md-4" >
                                                
                                                <select class="form-control form-control form-control-select" name="civilstatus" required>
                <option disabled selected>Select Civil Status</option>
                <option value="Single" <?php echo ($civilstatus == 'Single') ? 'selected' : ''; ?>>Single</option>
                <option value="Married" <?php echo ($civilstatus == 'Married') ? 'selected' : ''; ?>>Married</option>
                <option value="Widow" <?php echo ($civilstatus == 'Widow') ? 'selected' : ''; ?>>Widow</option>
            </select>
                                               
                                            </div>
                                        
                                    </div> -->
									<div class="row">
                                    <div class="col-md-4">                                       
                                                <input type="date" class="form-control" placeholder="Enter Birthdate" value="<?php echo $birthday; ?>" name="birthday" required>                                       
                                        </div>
                                        <div class="col-md-4">                                  
                                                <input type="number" class="form-control" placeholder="Enter Age" min="1" value="<?php echo $age; ?>" name="age" required>                                           
                                            </div>
                                         
                                        <div class="col-md-4">
                                            
                                        <select class="form-control form-control" required name="gender" style="font-family: 'Poppins', Times, serif;">
            <option disabled selected value="">Select Gender</option>
            <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select>
                                          
                                        </div>
                                    </div>
									<div class="row">
                                        
                                        <div class="col-md-4">
                                           
                                                <input type="text" class="form-control" placeholder="Enter street" value="<?php echo $street_name; ?>" name="street_name" required>
                                     
                                        </div>
                                      
                                        <div class="col-md-4 mb-2">
                                            
                                        <?php
$barangays = array(
    'Arawan',
    'Bagong Niing',
    'Balat Atis',
    'Briones',
    'Bulihan',
    'Buliran',
    'Callejon',
    'Corazon',
    'Del Valle',
    'Loob',
    'Magsaysay',
    'Matipunso',
    'Niing',
    'Poblacion',
    'Pulo',
    'Pury',
    'Sampaga',
    'Sampaguita',
    'San Jose',
    'Sintorisan'
);
?>

<select class="form-control form-control vstatus" required name="brgy">
    <option disabled selected value="">Select Barangay</option>
    <?php foreach ($barangays as $barangay) { ?>
        <option value="<?php echo $barangay; ?>" <?php echo ($brgy == $barangay) ? 'selected' : ''; ?>><?php echo $barangay; ?></option>
    <?php } ?>
</select>                                   
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Municipality" value="<?php echo $municipality; ?>" name="municipality" required>                                           
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col-md-4">
                                                <input type="email" class="form-control" placeholder="Enter Email" value="<?php echo $email; ?>" name="email" required>
                                        </div>
                                        <div class="col-md-4"> 
                                                <input type="text" class="form-control" placeholder="Enter Contact Number" value="<?php echo $contact_no; ?>" name="contact_no" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Province" value="<?php echo $province; ?>" name="province" required>
                                        </div>
                                    </div>
								
                                    
    <div class="btn-container">
      <button type="button" class="next-step mb-3">Next<i class="fa fa-caret-right"></i></button>
    </div>
   </div>
</div>
   
<div class="form-step ">
  <div class="card-body mx-4">
    <h2>Educational Background</h2>
   
    <div class="row">
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Course" value="<?php echo $course; ?>" name="course" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Major (N/A if none)" value="<?php echo $major; ?>" name="major" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter School" value="<?php echo $school_name; ?>" name="school_name" required>
                                        </div>
                                    </div>
									<div class="row">
                                   
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter School Address" value="<?php echo $school_address; ?>" name="school_address" required>
                                        </div>
                                        <div class="col-md-4">
                                               
                                               <select class="form-control form-control form-control-select" name="sem" required>
           <option disabled selected>Select Semester</option>
           <option value="First Semester" <?php echo ($semester == 'First Semester') ? 'selected' : '';  ?>>First Semester</option>
           <option value="Second Semester"<?php echo ($semester == 'Second Semester') ? 'selected' : '';  ?>>Second Semester</option>

       </select>
                                           </div>
                                       <div class="col-md-4">
                                               <input type="text" class="form-control" value="<?=$schoolyear?>" placeholder="Enter School Year (ex. 2024-2025)" name="sy" required>
                                       </div>
                                    </div>
                                   
                                       <div class="row">

                                        <div class="col-md-4">
                                                
                                                <select class="form-control  form-control-select" name="year" required>
            <option disabled selected>Select Year Level</option>
            <option value="First Year" <?php echo ($yearlevel == 'First Year') ? 'selected' : '' ;?>>First Year</option>
            <option value="Second Year" <?php echo ($yearlevel == 'Second Year') ? 'selected' : '' ;?>>Second Year</option>
            <option value="Third Year"<?php echo ($yearlevel == 'Third Year') ? 'selected' : '' ;?>>Third Year</option>
            <option value="Fourth Year"<?php echo ($yearlevel == 'Fourth Year') ? 'selected' : '' ;?>>Fourth Year</option>
            <option value="Fifth Year"<?php echo ($yearlevel == 'Fifth Year') ? 'selected' : '' ;?>>Fifth Year</option>
        </select>
                                            </div>
              
                                    </div>
								
								
                                    
                                    <div class="btn-container">
                    <button type="button" class="prev-step mb-3 mt-3">
                      <i class="fa fa-caret-left"></i> Back
                    </button>
                    <button type="button" class="next-step mb-3 mt-3">
                      Next <i class="fa fa-caret-right"></i>
                    </button>
                  </div>
    </div>
</div>
       
<div class="form-step ">
  <div class="card-body mx-4">
    <h2>Guardian Information</h2>
   
    <div class="row">
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Guardian's Name" value="<?php echo $parentname; ?>" name="parentname" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="number" class="form-control" placeholder="Enter Age"value="<?php echo $parentage; ?>" name="parentage" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Occupation" value="<?php echo $parent_occu; ?>" name="parent_occu" required>
                                        </div>
                                    </div>
								    <div class="row">
                                        <div class="col-md-4">                                      
                                                <input type="text" class="form-control" placeholder="Enter Income" value="<?php echo $parent_income; ?>"name="parent_income" required>                                         
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Contact Number" value="<?php echo $parent_contact; ?>" name="parent_contact" required>
                                        </div>
                                       <!-- <div class="col-md-4">                                       
                                                <input type="text" class="form-control" placeholder="Educational Attainment" value="<?php echo $parent_educattain; ?>" name="parent_educattain" required>                                       
                                        </div>-->
                                        <div class="col-md-4">                                       
                                        <select class="form-control form-control" name="parent_status" required>
                                                    <option disabled selected disabled selected value="">Select Status</option>
                                                    <option value="Alive" <?php echo ($parent_status == 'Alive') ? 'selected' : ''; ?>>Alive</option>
                                                    <option value="Deceased" <?php echo ($parent_status == 'Deceased') ? 'selected' : ''; ?>>Deceased</option>
                                                 
                                                </select>                                        
                                        </div>
                                    </div>
                                
                                    <div class="row">
                                        <div class="col-md-12">
                                                <input type="text" class="form-control" placeholder="Address" value="<?php echo $parent_address; ?>" name="parent_address" required>
                                        </div>
                                       
                                       
                                    </div>
								
                                </div>
    <div class="btn-container">
                    <button type="button" class="prev-step mb-3 mt-3">
                      <i class="fa fa-caret-left"></i> Back
                    </button>
                    <button type="button" class="next-step mb-3 mt-3">
                      Next <i class="fa fa-caret-right"></i>
                    </button>
                  </div>
    </div>
    <div class="form-step ">
  <div class="card-body mx-4">
    <h2>Update Requirements</h2>
   

								  <div class="row">
                                  <div class="col-md-2">
                                  <?php if (!empty($cor)) { ?>
        <p>  <a href="<?= 'assets/uploads/requirements/coe/' . $cor ?>" target="_blank">Enrollment Form</a></p>
        
    <?php } else{
        echo '<p>No Enrollment</p>';
    }?>                                    
                                </div>
                                <div class="col-md-2">
                                  <?php if (!empty($indigency)) { ?>
        <p>  <a href="<?= 'assets/uploads/requirements/indigent/' . $indigent ?>" target="_blank">Brgy Indigency</a></p>
        
    <?php } else{
        echo '<p>No Indigency</p>';
    }?>                                    
                                </div>
                                <div class="col-md-2">
                                  <?php if (!empty($grades)) { ?>
        <p>  <a href="<?= 'assets/uploads/requirements/grades/' . $grades ?>" target="_blank">Grades</a></p>
        
    <?php } else{
        echo '<p>No Grades</p>';
    }?>                                    
                                </div>
                                <div class="col-md-2">
                                  <?php if (!empty($letter)) { ?>
        <p>  <a href="<?= 'assets/uploads/requirements/indigent/' . $letter ?>" target="_blank">Letter</a></p>
        
    <?php } else{
        echo '<p>No Letter</p>';
    }?>                                    
                                </div>
                                <div class="col-md-2">
                                  <?php if (!empty($schoolid)) { ?>
        <p>  <a href="<?= 'assets/uploads/requirements/indigent/' . $schoolid ?>" target="_blank">School ID</a></p>
        
    <?php } else{
        echo '<p>No School ID</p>';
    }?>                                    
                                </div>
                                  </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                        <label for="formFile" class="form-label">Certificate of Enrollment</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="coe" accept=".png, .jpg, .jpeg, .docx, .pdf" >
                                        </div>
                                        <div class="col-md-4">
                                        <label for="formFile" class="form-label">Barangay Indigent</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="indigent" accept=".png, .jpg, .jpeg, .docx, .pdf" >
                                        </div>
                                        <div class="col-md-4">
                                        <label for="formFile" class="form-label">Grades</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="grades" accept=".png, .jpg, .jpeg, .docx, .pdf" >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">                                      
                                        <label for="formFile" class="form-label">Letter</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="letter" accept=".png, .jpg, .jpeg, .docx, .pdf" >                                         
                                        </div>
                                        <div class="col-md-4">                                       
                                        <label for="formFile" class="form-label">School ID</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="schoolid" accept=".png, .jpg, .jpeg, .docx, .pdf">                                      
                                        </div>
                                      
                                    </div>
                                </div>
    <div class="btn-container">
                    <button type="button" class="prev-step mb-3 mt-3">
                      <i class="fa fa-caret-left"></i> Back
                    </button>
                    <button type="button" class="next-step mb-3 mt-3">
                      Next <i class="fa fa-caret-right"></i>
                    </button>
                  </div>
    </div>



<div class="form-step ">
 
   

<div class="card card-sm text-center ">
  <div class="card-body">
    <h5 class="card-title">Finish</h5>
    <img src="assets/img/emoji.png" alt="..." style="height:100px; width:100px;">
    <p class="card-text">Good Luck on your journey, Fighting!!!!</p>
    
  </div>


                                 
    <div class="btn-container">
                    <button type="button" class="prev-step mb-3 mt-3">
                      <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button type="submit" name="submit" class="btn-primary mb-3 mt-3">
                     Submit <i class="fas fa-check"></i>
                    </button>
     
             
                  </div>
                  </div>
</div>

</form>
            </div>
            <!-- Add the steps for Parent Info, Requirements, and Finish -->

       
           
      



							
							</div>
						</div>


					</div>
				</div>
			</div>
			
	

		

			<!-- Main Footer -->
			<?//php include 'templates/main-footer.php' ?>
			<!-- End Main Footer -->
			
		
		
	</div>
 

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  


	<?php include 'templates/footer.php' ?>
   

    <script>
        const formSteps = document.querySelectorAll(".form-step");
        const nextStepBtns = document.querySelectorAll(".next-step");
        const prevStepBtns = document.querySelectorAll(".prev-step");
        const progress = document.querySelectorAll(".progressbar .step");

        let currentStep = 0;

        nextStepBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                if (validateStep()) {
                    currentStep++;
                    updateFormSteps();
                    updateProgressBar();
                }
            });
        });

        prevStepBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                currentStep--;
                updateFormSteps();
                updateProgressBar();
            });
        });

        function updateFormSteps() {
            formSteps.forEach((formStep) => {
                formStep.classList.remove("active");
            });
            formSteps[currentStep].classList.add("active");
        }

        function updateProgressBar() {
            progress.forEach((step, index) => {
                if (index <= currentStep) {
                    step.classList.add("active");
                } else {
                    step.classList.remove("active");
                }
            });
        }

        function validateStep() {
            const currentInputs = formSteps[currentStep].querySelectorAll("input");
            let isValid = true;

            currentInputs.forEach((input) => {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    isValid = false;
                }
            });

            return isValid;
        }
    </script>
</body>
</html><?php }?>