<?php include 'server/server.php' ?>

<?php 

session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0)) {
	header('location:login.php');
    exit();
}





?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Educational Assistance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
    color: #9E9E9E;
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
    font-family: montserrat;
    color: #2C3E50;
    font-size: 16px;
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
#progressbar #account:before {
    font-family: FontAwesome;
    content: "\f023";
}

#progressbar #personal:before {
    font-family: FontAwesome;
    content: "\f007";
}

#progressbar #payment:before {
    font-family: FontAwesome;
    content: "\f09d";
}

#progressbar #confirm:before {
    font-family: FontAwesome;
    content: "\f00c";
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
					<?php if(isset($_SESSION['message'])): ?>
							<div class="alert alert-<?php echo $_SESSION['success']; ?> <?= $_SESSION['success']=='danger' ? 'bg-danger text-light' : null ?>" role="alert">
								<?php echo $_SESSION['message']; ?>
							</div>
                            <!-- MESSAGE WHEN DATA IS INSERTED __-->
                            
                            <?php 
                            /*if (isset($_SESSION['message']) && $_SESSION['message'] != ''){ ?>                                                         ?>
                      <!--  <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Hello!</strong><?//php echo $_SESSION['message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div> -->
                            
						<?php unset($_SESSION['message']);  //}*/ ?> 
                       

						<?php endif ?>
					<div class="row mt--2">
						
						<div class="col-md-12">
						
							<div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title">Available Educational Assistance </div>
										
									
									
									</div>
								</div>
								

							
  
        
            
                <h2 class="text-center"><strong>Submit Application </strong></h2>
                <p class="text-center">Fill out all field and ensure integrity of information</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>Information</strong></li>
                                <li id="personal"><strong>Course</strong></li>
                                <li id="payment"><strong>Grades</strong></li>
								<li id="personal"><strong>Parents</strong></li>
                                <li id="payment"><strong>Requirements</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul>
                            <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card" style="background-color:#F7F9F2;">
                                    <h2 class="fs-title">Personal Information</h2>
                                 <!--   <input type="email" name="email" placeholder="Email Id"/> -->
                                   	<div class="row">
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Firstname" name="fname" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Middlename" name="mname" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Lastname" name="lname" required>
                                        </div>
                                    </div>
								    <div class="row">
                                        <div class="col-md-4">                                      
                                                <input type="text" class="form-control" placeholder="Enter Religion" name="religion" required>                                         
                                        </div>
                                        <div class="col-md-4">                                       
                                                <input type="text" class="form-control" placeholder="Enter Citizenship" name="bplace" required>                                       
                                        </div>
                                        <div class="col-md-4">                                       
                                                <input type="date" class="form-control" placeholder="Enter Birthdate" name="bdate" required>                                       
                                        </div>
                                    </div>
									<div class="row">
                                        <div class="col-md-4">                                  
                                                <input type="number" class="form-control" placeholder="Enter Age" min="1" name="age" required>                                           
                                            </div>
                                            <div class="col-md-4">
                                                
                                                <select class="form-control" name="cstatus" required>
                                                    <option disabled selected>Select Civil Status</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Widow">Widow</option>
                                                </select>
                                           
                                        </div>
                                        <div class="col-md-4">
                                            
                                                <select class="form-control" required name="gender">
                                                    <option disabled selected value="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                          
                                        </div>
                                    </div>
									<div class="row">
                                        
                                        <div class="col-md-4">
                                           
                                                <input type="text" class="form-control" placeholder="Enter Birthplace" name="street" required>
                                     
                                        </div>
                                      
                                        <div class="col-md-4">
                                            
                                                <select class="form-control vstatus" required name="vstatus">
                                                    <option disabled selected>Select Barangay</option>
                                                    <option value="Arawan">Arawan</option>
                                                    <option value="Baging Niing">Bagong Niing</option>
                                                    <option value="Balat Atis">Balat Atis</option>
                                                    <option value="Briones">Briones</option>
                                                    <option value="Bulihan">Bulihan</option>
                                                    <option value="Buliran">Buliran</option>
                                                    <option value="Callejon">Callejon</option>
                                                    <option value="Corazon">Corazon</option>
                                                    <option value="Del Valle">Del Valle</option>
                                                    <option value="Loob">Loob</option>
                                                    <option value="Magsaysay">Magsaysay</option>
                                                    <option value="Matipunso">Matipunso</option>
                                                    <option value="Niing">Niing</option>
                                                    <option value="Poblacion">Poblacion</option>
                                                    <option value="Pulo">Pulo</option>
                                                    <option value="Pury">Pury</option>
                                                    <option value="Sampaga">Sampaga</option>
                                                    <option value="Sampaguita">Sampaguita</option>
                                                    <option value="San Jose">San Jose</option>
                                                    <option value="Sintorisan">Sintorisan</option>
                                                    
                                                </select>                                    
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Municipality" name="municipality" required>                                           
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col-md-4">
                                                <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
                                        </div>
                                        <div class="col-md-4"> 
                                                <input type="text" class="form-control" placeholder="Enter Contact Number" name="contact_no" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Province" name="province" required>
                                        </div>
                                    </div>
								</div>
                                <input type="button" name="next" class="next action-button" value="Next Step"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Educational Background</h2>
                                    <div class="row">
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Course" name="fname" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Major (N/A if none)" name="mname" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter School" name="lname" required>
                                        </div>
                                    </div>
									<div class="row">
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter School Address" name="fname" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Semester" name="mname" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter School Year" name="lname" required>
                                        </div>
                                    </div>
								 </div>
								
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="button" name="next" class="next action-button" value="Next Step"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card" style="background-color:#F7F9F2;">
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
                              
								<input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="button" name="make_payment" class="next action-button" value="Next Step"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Parenst Information</h2>
                                    <div class="row">
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Father's Name" name="fname" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="number" class="form-control" placeholder="Enter Age" name="fage" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Occupation" name="lname" required>
                                        </div>
                                    </div>
								    <div class="row">
                                        <div class="col-md-4">                                      
                                                <input type="text" class="form-control" placeholder="Enter Income" name="religion" required>                                         
                                        </div>
                                        <div class="col-md-4">                                       
                                                <input type="text" class="form-control" placeholder="Educational Attainment" name="bplace" required>                                       
                                        </div>
                                        <div class="col-md-4">                                       
                                        <select class="form-control" name="fstatus" required>
                                                    <option disabled selected>Select Status</option>
                                                    <option value="Alive">Alive</option>
                                                    <option value="Deceased">Deceased</option>
                                                 
                                                </select>                                      
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Mother's Name" name="fname" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="number" class="form-control" placeholder="Enter Age" name="mage" required>
                                        </div>
                                        <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Occupation" name="lname" required>
                                        </div>
                                    </div>
								    <div class="row">
                                        <div class="col-md-4">                                      
                                                <input type="text" class="form-control" placeholder="Enter Income" name="religion" required>                                         
                                        </div>
                                        <div class="col-md-4">                                       
                                                <input type="text" class="form-control" placeholder="Educational Attainment" name="bplace" required>                                       
                                        </div>
                                        <div class="col-md-4">                                       
                                        <select class="form-control" name="fstatus" required>
                                                    <option disabled selected>Select Status</option>
                                                    <option value="Alive">Alive</option>
                                                    <option value="Deceased">Deceased</option>
                                                 
                                                </select>                                      
                                        </div>
                                    </div>
                                </div>

								<input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="button" name="make_payment" class="next action-button" value="Next Step"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card" style="background-color:#F7F9F2;">
                                    <h2 class="fs-title">Requirements</h2>
                                    <div class="row">
                                        <div class="col-md-4">
                                        <label for="formFile" class="form-label">Valid ID</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="validid" required>
                                        </div>
                                        <div class="col-md-4">
                                        <label for="formFile" class="form-label">Valid ID</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="validid" required>
                                        </div>
                                        <div class="col-md-4">
                                        <label for="formFile" class="form-label">Valid ID</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="validid" required>
                                        </div>
                                    </div>
								    <div class="row">
                                        <div class="col-md-4">                                      
                                        <label for="formFile" class="form-label">Valid ID</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="validid" required>                                         
                                        </div>
                                        <div class="col-md-4">                                       
                                        <label for="formFile" class="form-label">Valid ID</label>
                                        <input class=" form-control form-control-sm" type="file" id="formFile" name="validid" required>                                      
                                        </div>
                                      
                                    </div>
                                 
                                  
                                </div>

								<input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="button" name="make_payment" class="next action-button" value="Next Step"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title text-center">Finish !</h2>
                                    <br><br>
                                    <div class="row justify-content-center">
                                        <p>I hereby certify that all information and requirements submitted in this application are true and correct</p>
                                    </div>
                                    <br><br>
                              
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <a href="apply_educ.php?educid=<?php echo $educid; ?>" class="btn btn-success btn-circle">
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
</html>