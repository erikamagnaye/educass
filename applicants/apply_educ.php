<?php include 'server/server.php' ?>

<?php 

session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0)) {
	header('location:login.php');
    exit();
}

else {
//we need to retrieve existing information of the students so they won't have to input their info again
if (isset($_GET['educid'])) { // this is from educaids.php, this educid will be used for applying for the educ aids
    $educid = $_GET['educid'];

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
$educbg = "SELECT * FROM `studentcourse` where studid= $studid order by studid desc limit 1"; // SQL query to fetch all table data
$studcourse = mysqli_query($conn, $educbg); // sending the query to the database

// displaying all the data retrieved from the database using while loop
while ($data = mysqli_fetch_assoc($studcourse)) {
    $_SESSION= $data['courseid'];         
        
    $course = $data['course'];         
    $major = $data['major'];  
    $school_name = $data['school_name'];           
    $school_address = $data['School_address'];        
   
}

//CODE TO RETRIEVE PARENTS INFO
$father = ''; // initialize 
$f_age = ''; // initialize 
$f_occu = ''; // initialize mjor
$f_income = ''; // initialize 
$f_status= ''; // initialize mjor
$f_educattain = ''; // initialize 
$mother = ''; // initialize 
$m_age = ''; // initialize 
$m_occu = ''; // initialize mjor
$m_income = ''; // initialize 
$m_status= ''; // initialize mjor
$m_educattain = ''; // initialize 
//CODE TO RETRIEVE DATA ABOUT COURSE/EDUCATIONAL BACKGROUND
$parent = "SELECT * FROM `parentinfo` where studid= $studid"; // SQL query to fetch all table data
$studparent = mysqli_query($conn, $parent); // sending the query to the database

// displaying all the data retrieved from the database using while loop
while ($parents = mysqli_fetch_assoc($studparent)) {
               
    $_SESSION= $parents['parentid']; // use this for application
    $father = $parents['father'];
    $f_age = $parents['f_age'];
    $f_occu = $parents['f_occu'];
    $f_income = $parents['f_income'];
    $f_status = $parents['f_status'];
    $f_educattain = $parents['f_educattain'];
    $mother = $parents['mother'];
    $m_age = $parents['m_age'];
    $m_occu = $parents['m_occu'];
    $m_income = $parents['m_income'];
    $m_status = $parents['m_status'];
    $m_educattain = $parents['m_educattain']; 
   
}
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
<style>
 /* Default font size for body */
.content h2{
    font-size: 20px;
}

        /* Font size for small devices (phones, less than 600px) */
        @media (max-width: 600px) {
       
            .card-title, h2, .table th, .table td {
                font-size: 9px;
            }
            .btn {
                font-size: 9px;
            }
        }

        /* Font size for medium devices (tablets, 600px and up) */
        @media (min-width: 600px) and (max-width: 768px) {
          
            .card-title, h2, .table th, .table td {
                font-size: 12px;
            }
            .btn {
                font-size: 12px;
            }
        }

        /* Font size for large devices (desktops, 768px and up) */
        @media (min-width: 768px) and (max-width: 992px) {
            body {
                font-size: 16px;
            }
            .card-title, h2, .table th, .table td {
                font-size: 14px;
            }
            .btn {
                font-size: 14px;
            }
        }

        /* Font size for extra large devices (large desktops, 992px and up) */
        @media (min-width: 992px) {
         
            .card-title, h2, .table th, .table td {
                font-size: 14px;
            }
            .btn {
                font-size: 14px;
            }
        }
	
* {
    margin: 0;
    padding: 0;
}

html {
    height: 100%;
}

/*Background color*/
/*#grad1 {
    background-color: #9C27B0;
    background-image: linear-gradient(120deg, #FF4081, #81D4FA);
}*/

/*form styles*/
#msform {
    text-align: center;
    position: relative;
    margin-top: 20px;
}

#msform fieldset .form-card {
    background: white;
    border: 0 none;
    border-radius: 0px;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    padding: 20px 40px 30px 40px;
    box-sizing: border-box;
    width: 94%;
    margin: 0 3% 20px 3%;
    border-radius: 20px;
   
    /*stacking fieldsets above each other*/
    position: relative;
}

#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;

    /*stacking fieldsets above each other*/
    position: relative;
}

/*Hide all except first fieldset*/
#msform fieldset:not(:first-of-type) {
    display: none;
}

#msform fieldset .form-card {
    text-align: left;
    color: black;
}

#msform input, #msform textarea {
    padding: 0px 8px 4px 8px;
    border: none;
    border-bottom: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    font-family: 'Poppins', Times, serif;
    color: black;
    font-size: 14px;
    letter-spacing: 1px;
}

#msform input:focus, #msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: none;
    font-weight: bold;
    border-bottom: 2px solid skyblue;
    outline-width: 0;

    
}

/*Blue Buttons*/
#msform .action-button {
    width: 100px;
    background: skyblue;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px;
}

#msform .action-button:hover, #msform .action-button:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue;
}

/*Previous Buttons*/
#msform .action-button-previous {
    width: 100px;
    background: #616161;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px;
}

#msform .action-button-previous:hover, #msform .action-button-previous:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px #616161;
}

/*Dropdown List Exp Date*/
select.list-dt {
    border: none;
    outline: 0;
    border-bottom: 1px solid #ccc;
    padding: 2px 5px 3px 5px;
    margin: 2px;
}

select.list-dt:focus {
    border-bottom: 2px solid skyblue;
}

/*The background card*/
.card {
    z-index: 0;
    border: none;
    border-radius: 0.5rem;
    position: relative;
}

/*FieldSet headings*/
.fs-title {
    font-size: 25px;
    color: #2C3E50;
    margin-bottom: 10px;
    font-weight: bold;
    text-align: left;
}

/*progressbar*/
#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey;
}

#progressbar .active {
    color: #000000;
}

#progressbar li {
    list-style-type: none;
    font-size: 12px;
    width: 16%;
    float: left;
    position: relative;
}

/*Icons in the ProgressBar*/
#progressbar #information:before {
    font-family: FontAwesome;
    content: "\f007";
}

#progressbar #course:before {
    font-family: FontAwesome;
    content: "\f19d";
}

#progressbar #grades:before {
    font-family: FontAwesome;
    content: "\f559";
}
#progressbar #parents:before {
    font-family: FontAwesome;
    content: "\f0c0";
}
#progressbar #requirements:before {
    font-family: FontAwesome;
    content: "\f15c";
}

#progressbar #confirm:before {
    font-family: FontAwesome;
    content: "\f46c";
}
/* Apply smaller font size on smaller screen sizes */
@media (max-width: 768px) {
    #progressbar:before {
        font-size: 6px;
    }
}
/*ProgressBar before any progress*/
#progressbar li:before {
    width: 50px;
    height: 50px;
    line-height: 45px;
    display: block;
    font-size: 18px;
    color: #ffffff;
    background: lightgray;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    padding: 2px;
}

/*ProgressBar connectors*/
#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: lightgray;
    position: absolute;
    left: 0;
    top: 25px;
    z-index: -1;
}

/*Color number of the step and the connector before it*/
#progressbar li.active:before, #progressbar li.active:after {
    background: green;
}

/*Imaged Radio Buttons*/
.radio-group {
    position: relative;
    margin-bottom: 25px;
}

.radio {
    display:inline-block;
    width: 204;
    height: 104;
    border-radius: 0;
    background: lightblue;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
    cursor:pointer;
    margin: 8px 2px; 
}

.radio:hover {
    box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3);
}

.radio.selected {
    box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1);
}

/*Fit image in bootstrap div*/
.fit-image{
    width: 100%;
    object-fit: cover;
}

/* start... this is for input fields of Grades*/
.input-row {
  display: flex;
}

.input-row input {
  margin-right: 10px;
}

button {
  margin-top: 10px;
  
}


/* end... this is for input fields of Grades*/
/* this is for the input field with select options*/
.form-control {
  border: none;
  border-bottom: 1px solid #ccc; /* adjust the color and thickness as needed */
  border-radius: 0;
  box-shadow: none;
  height: 40px; /* add this to make input fields consistent height */
  padding: 10px;

  
}


select.form-control {
  height: 40px; /* add this to make select options consistent height */
  padding: 10px;
}
.main-panel {
  font-family: Poppins, sans-serif;
}

.form-control-select {   /* font fam for select options */
  font-family: 'Poppins', sans-serif !important;
}
.main-panel select.form-control {
  font-family: 'Poppins', sans-serif;
}
</style>
</head>
<body>
	<?//php include 'templates/loading_screen.php' ?>

	<div class="wrapper">
		<!-- Main Header -->
		<?php include 'templates/main-header.php' ?>
		<!-- End Main Header -->

		<!-- Sidebar -->
		<?php include 'templates/sidebar.php' ?>
		<!-- End Sidebar -->
 
		<div class="main-panel">
			<div class="content">
				<div class="panel-header ">
					<div class="page-inner">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-black fw-bold">Educational Assistance Application</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner">
				
					<div class="row mt--2">
						
						<div class="col-md-12">
						
							<div class="card">
								<div class="card-header">
									<div class="card-head-row text-center">
                                    <h2 class="text-center"><strong>Submit Application </strong></h2>
										
									
									
									</div>
								</div>
								

							
  
        
            
                
                <p class="text-center">Fill out all field and ensure integrity of information</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="information"><strong>Information</strong></li>
                                <li id="course"><strong>Course</strong></li>
                                <li id="grades"><strong>Grades</strong></li>
								<li id="parents"><strong>Parents</strong></li>
                                <li id="requirements"><strong>Requirements</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul>
                            <!-- fieldsets -->
                            <fieldset>
                                
                                <div class="form-card">
                                    <h2 class="fs-title">Personal Information    YUNG CONTACT NUMBER GAWIN VARCHAR</h2>
                                 <!--   <input type="email" name="email" placeholder="Email Id"/> -->
                                   	<div class="row ">
 
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Firstname" value="<?php echo $firstname; ?>" name="fname" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Middlename" value="<?php echo $midname; ?>" name="mname" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Lastname" value="<?php echo $lastname; ?>" name="lname" required>
                                        </div>
                                    </div>
								    <div class="row">
                                        <div class="col-md-4">                                      
                                                <input type="text" class="form-control" placeholder="Enter Religion" value="<?php echo $religion; ?>" name="religion" required>                                         
                                        </div>
                                        <div class="col-md-4">                                       
                                                <input type="text" class="form-control" placeholder="Enter Citizenship" value="<?php echo $citizenship; ?>" name="citizenship" required>                                       
                                        </div>
                                        <div class="col-md-4">                                       
                                                <input type="date" class="form-control" placeholder="Enter Birthdate" value="<?php echo $birthday; ?>" name="bdate" required>                                       
                                        </div>
                                    </div>
									<div class="row">
                                        <div class="col-md-4">                                  
                                                <input type="number" class="form-control" placeholder="Enter Age" min="1" value="<?php echo $age; ?>" name="age" required>                                           
                                            </div>
                                            <div class="col-md-4" >
                                                
                                            <select class="form-control form-control-sm form-control-select" name="cstatus" required>
            <option disabled selected>Select Civil Status</option>
            <option value="Single" <?php echo ($civilstatus == 'Single') ? 'selected' : ''; ?>>Single</option>
            <option value="Married" <?php echo ($civilstatus == 'Married') ? 'selected' : ''; ?>>Married</option>
            <option value="Widow" <?php echo ($civilstatus == 'Widow') ? 'selected' : ''; ?>>Widow</option>
        </select>
                                           
                                        </div>
                                        <div class="col-md-4">
                                            
                                        <select class="form-control form-control-sm" required name="gender" style="font-family: 'Poppins', Times, serif;">
            <option disabled selected value="">Select Gender</option>
            <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select>
                                          
                                        </div>
                                    </div>
									<div class="row">
                                        
                                        <div class="col-md-4">
                                           
                                                <input type="text" class="form-control" placeholder="Enter street" value="<?php echo $street_name; ?>" name="street" required>
                                     
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

<select class="form-control form-control-sm vstatus" required name="brgy">
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
								</div>
                               
                               
                                <a  class="next action-button btn btn-primary btn-circle "  name="next"><i class="fa-solid fa-forward"></i> Next
                                 </a>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Educational Background</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Enter Course" value="<?php echo $course; ?>" name="course" required>
                                        </div>
                                        <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Enter Major (N/A if none)" value="<?php echo $major; ?>" name="major" required>
                                        </div>
                                      
                                    </div>
									<div class="row">
                                    <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Enter School" value="<?php echo $school_name; ?>" name="school_name" required>
                                        </div>
                                        <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Enter School Address" value="<?php echo $school_address; ?>" name="school_address" required>
                                        </div>
                                       
                                    </div>
                                    <div class="row">
                                    <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Semester" name="sem" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter School Year (ex. 2024-2025)" name="sy" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Year Level" name="year" required>
                                        </div>
                                       
                                    </div>
								 </div>
							

                                <a  class="previous action-button-previous btn btn-warning btn-circle "  name="previous"><i class="fa-solid fa-backward"></i> Back
                                 </a>
                                 <a  class="next action-button btn btn-primary btn-circle "  name="next"><i class="fa-solid fa-forward"></i> Next
                                 </a>
                            </fieldset>
                            <fieldset>
                                <div class="form-card" style="">
                                    <h2 class="fs-title">Grades</h2>
                                    
                                    <div id="input-container">
                                    <div class="input-row">
                                        <input type="text" placeholder="Subject" name="subject">
                                        <input type="text" placeholder="Grade" name="grade">
                                    </div>
                                        <a type="button" id="add-btn" class="btn btn-link btn-success" title="Add Subject">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                  
                                </div>
                              
							<!--	<input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="button" name="make_payment" class="next action-button" value="Next Step"/>
-->
                                <a  class="previous action-button-previous btn btn-warning btn-circle "  name="previous"><i class="fa-solid fa-backward"></i> Back
                                 </a>
                                 <a  class="next action-button btn btn-primary btn-circle "  name="grades"><i class="fa-solid fa-forward"></i> Next
                                 </a>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Parenst Information</h2>
                                    <div class="row">
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Father's Name" value="<?php echo $father; ?>" name="father" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="number" class="form-control" placeholder="Enter Age"value="<?php echo $f_age; ?>" name="f_age" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Occupation" value="<?php echo $f_occu; ?>" name="f_occu" required>
                                        </div>
                                    </div>
								    <div class="row">
                                        <div class="col-md-4">                                      
                                                <input type="text" class="form-control" placeholder="Enter Income" value="<?php echo $f_income; ?>"name="f_income" required>                                         
                                        </div>
                                        <div class="col-md-4">                                       
                                                <input type="text" class="form-control" placeholder="Educational Attainment" value="<?php echo $f_educattain; ?>" name="f_educattain" required>                                       
                                        </div>
                                        <div class="col-md-4">                                       
                                        <select class="form-control form-control-sm" name="f_status" required>
                                                    <option disabled selected disabled selected value="">Select Status</option>
                                                    <option value="Alive" <?php echo ($f_status == 'Alive') ? 'selected' : ''; ?>>Alive</option>
                                                    <option value="Deceased" <?php echo ($f_status == 'Deceased') ? 'selected' : ''; ?>>Deceased</option>
                                                 
                                                </select>                                        
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Mother's Name" value="<?php echo $mother; ?>" name="mother" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="number" class="form-control" placeholder="Enter Age" value="<?php echo $m_age; ?>" name="m_age" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Occupation" value="<?php echo $m_occu; ?>" name="m_occu" required>
                                        </div>
                                    </div>
								    <div class="row">
                                        <div class="col-md-4">                                      
                                                <input type="text" class="form-control" placeholder="Enter Income" value="<?php echo $m_income; ?>" name="m_income" required>                                         
                                        </div>
                                        <div class="col-md-4">                                       
                                                <input type="text" class="form-control" placeholder="Educational Attainment" value="<?php echo $m_educattain; ?>" name="m_educattain" required>                                       
                                        </div>
                                        <div class="col-md-4">                                       
                                        <select class="form-control form-control-sm" name="m_status" required>
                                                    <option disabled selected disabled selected value="">Select Status</option>
                                                    <option value="Alive" <?php echo ($m_status == 'Alive') ? 'selected' : ''; ?>>Alive</option>
                                                    <option value="Deceased" <?php echo ($m_status == 'Deceased') ? 'selected' : ''; ?>>Deceased</option>
                                                 
                                                </select>  
                                               
                                        </div>
                                    </div>
                                </div>

							<!--	<input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="button" name="make_payment" class="next action-button" value="Next Step"/>
                            -->
                                <a  class="previous action-button-previous btn btn-warning btn-circle "  name="previous"><i class="fa-solid fa-backward"></i> Back
                                 </a>
                                 <a  class="next action-button btn btn-primary btn-circle "  name="parents"><i class="fa-solid fa-forward"></i> Next
                                 </a>
                            </fieldset>
                            <fieldset>
                                <div class="form-card" style="">
                                    <h2 class="fs-title">Requirements</h2>
                                    <div class="row">
                                        <div class="col-md-4">
                                        <label for="formFile" class="form-label">Certificate of Enrollment</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="coe" accept=".png, .jpg, .jpeg, .docx, .pdf" required>
                                        </div>
                                        <div class="col-md-4">
                                        <label for="formFile" class="form-label">Barangay Indigent</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="indigent" accept=".png, .jpg, .jpeg, .docx, .pdf" required>
                                        </div>
                                        <div class="col-md-4">
                                        <label for="formFile" class="form-label">Grades</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="grades" accept=".png, .jpg, .jpeg, .docx, .pdf" required>
                                        </div>
                                    </div>
								    <div class="row">
                                        <div class="col-md-4">                                      
                                        <label for="formFile" class="form-label">Letter</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="letter" accept=".png, .jpg, .jpeg, .docx, .pdf" required>                                         
                                        </div>
                                        <div class="col-md-4">                                       
                                        <label for="formFile" class="form-label">School ID</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="schoolid" accept=".png, .jpg, .jpeg, .docx, .pdf" required>                                      
                                        </div>
                                      
                                    </div>
                                 
                                  
                                </div>

							<!--	<input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="button" name="make_payment" class="next action-button" value="Next Step"/>
-->
                                <a  class="previous action-button-previous btn btn-warning btn-circle "  name="previous"><i class="fa-solid fa-backward"></i> Back
                                 </a>
                                 <a  class="next action-button btn btn-primary btn-circle "  name="requirements"><i class="fa-solid fa-forward"></i> Next
                                 </a>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title text-center">Finish !</h2>
                                    <br><br>
                                    <div class="row justify-content-center">
                                        <p>I hereby certify that all information and requirements submitted in this application are true and correct otherwise it will be disregarded</p>
                                    </div>
                                    <br><br>
                              
                                </div>
                            <!--    <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                            -->
                                <a  class="previous action-button-previous btn btn-warning btn-circle "  name="previous"><i class="fa-solid fa-backward"></i> Back
                                 </a>
                                
                                <a href="submit_application.php?educid=<?php echo $educid; ?>&studid=<?php echo $studid; ?>" class="btn btn-success btn-circle">
                                                    <i class="fa fa-check"></i> Submit
                                                    </a>
                            </fieldset>
                        </form>
                    </div>
                </div>
           
      



							
							</div>
						</div>


					</div>
				</div>
			</div>
			
	

		

			<!-- Main Footer -->
			<?php include 'templates/main-footer.php' ?>
			<!-- End Main Footer -->
			
		</div>
		
	</div>
	<?php include 'templates/footer.php' ?>
   
	<script>
    $(document).ready(function(){
    
    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    
    $(".next").click(function(){
        
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        
        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        
        //show the next fieldset
        next_fs.show(); 
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
    
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({'opacity': opacity});
            }, 
            duration: 600
        });
    });
    
    $(".previous").click(function(){
        
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        
        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        
        //show the previous fieldset
        previous_fs.show();
    
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
    
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            }, 
            duration: 600
        });
    });
    
    $('.radio-group .radio').click(function(){
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });
    
    $(".submit").click(function(){
        return false;
    })
        
    });
//this is for add and remove input fields of grades
const inputContainer = document.getElementById('input-container');
const addButton = document.getElementById('add-btn');

addButton.addEventListener('click', function() {
  const inputRow = document.createElement('div');
  inputRow.classList.add('input-row');
  
  const inputSubject = document.createElement('input');
  inputSubject.setAttribute('type', 'text');
  inputSubject.setAttribute('placeholder', 'Subject');
  
  const inputGrade = document.createElement('input');
  inputGrade.setAttribute('type', 'text');
  inputGrade.setAttribute('placeholder', 'Grade');
  
  const removeLink = document.createElement('a');
  removeLink.className = 'btn btn-link btn-danger';
  removeLink.title = 'Remove';
  
  const removeIcon = document.createElement('i');
  removeIcon.className = 'fa fa-times';
  
  removeLink.appendChild(removeIcon);
  
  removeLink.addEventListener('click', function(event) {
    event.preventDefault(); // prevent default anchor behavior
    inputContainer.removeChild(inputRow);
  });
  
  inputRow.appendChild(inputSubject);
  inputRow.appendChild(inputGrade);
  inputRow.appendChild(removeLink);
  
  inputContainer.insertBefore(inputRow, addButton);

});
</script>
</body>
</html><?php }?>