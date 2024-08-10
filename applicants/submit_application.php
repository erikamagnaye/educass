<?php include 'server/server.php' ?>

<?php 

session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['id'] == 0)) {
	header('location:login.php');
    exit();
}
else{

    if (isset($_GET['educid']) && isset($_GET['studid'])) { // this is from apply_educ.php
        $educid = $_GET['educid'];
        $studid = $_GET['studid'];

        //PERSONAL INFO
     
        $lastname = $conn->real_escape_string($_POST['lname']);        
        $firstname = $conn->real_escape_string($_POST['fname']);         
        $midname = $conn->real_escape_string($_POST['mname']);  
        $email = $conn->real_escape_string($_POST['email']);           
        $birthday = $conn->real_escape_string($_POST['bdate']);        
        $contact_no = $conn->real_escape_string($_POST['contact_no']);         
        $brgy = $conn->real_escape_string($_POST['brgy']);  
        $municipality =$conn->real_escape_string($_POST['municipality']); 
        $province =$conn->real_escape_string($_POST['province']);         
        $street_name = $conn->real_escape_string($_POST['street_name']);  
        $gender =$conn->real_escape_string($_POST['gender']);           
        $citizenship = $conn->real_escape_string($_POST['citizenship']);        
        $religion = $conn->real_escape_string($_POST['religion']);         
        $age = $conn->real_escape_string($_POST['age']);  
        $civilstatus = $conn->real_escape_string($_POST['civilstatus']); 


        $student = "UPDATE student SET lastname='$lastname', firstname='$firstname', midname='$midname', email='$email', birthday='$birthday', contact_no='$contact_no', brgy='$brgy', municipality='$municipality', province='$province', street_name='$street_name', gender='$gender', citizenship='$citizenship', religion='$religion', age='$age', civilstatus='$civilstatus' WHERE studid='$studid'";
        $result = $conn->query($query);

        //course
        $course = $conn->real_escape_string($_POST['course']);         
        $major = $conn->real_escape_string($_POST['major']);  
        $school_name = $conn->real_escape_string($_POST['school_name']);           
        $school_address = $conn->real_escape_string($_POST['School_address']);   
        $sem = $conn->real_escape_string($_POST['sem']);         
        $sy = $conn->real_escape_string($_POST['sy']);  
        $year = $conn->real_escape_string($_POST['year']); 

        $course = $conn->query("INSERT INTO studentcourse (studid, course, major, school_name, school_address, sem, `year`, sy ) VALUES ($studid, $course, $major, $school_name, $school_address, $sem, $year, $sy)");
        $courseid = $conn->insert_id;

        //GRADES
        $subject = $_POST['subject'];
        $grade = $_POST['grade'];

        $grades = $conn->query("INSERT INTO grades (studid, `subject`, grade ) VALUES ($studid, $subject, $grade)");
        $gradesid = $conn->insert_id;

        //parents info
        $father = $conn->real_escape_string($_POST['father']);
        $f_age = $conn->real_escape_string($_POST['f_age']);
        $f_occu = $conn->real_escape_string($_POST['f_occu']);
        $f_income = $conn->real_escape_string($_POST['f_income']);
        $f_status = $conn->real_escape_string($_POST['f_status']);
        $f_educattain = $conn->real_escape_string($_POST['f_educattain']);
        $mother =$conn->real_escape_string($_POST['mother']);
        $m_age = $conn->real_escape_string($_POST['m_age']);
        $m_occu = $conn->real_escape_string($_POST['m_occu']);
        $m_income = $conn->real_escape_string($_POST['m_income']);
        $m_status = $conn->real_escape_string($_POST['m_status']);
        $m_educattain = $conn->real_escape_string($_POST['m_educattain']); 

//check first if the parent table is empty otherwise update the table
$parentcheck = $conn->query("SELECT * FROM parentinfo WHERE studid = '$studid'");

if ($parentcheck->num_rows == 0) {
    // Parent table is empty, insert new data
    $query = "INSERT INTO parentinfo ( studid, father, f_age, f_occu, f_income, f_status, f_educattain, mother, m_age, m_occu, m_income, m_status, m_educattain) 
              VALUES ('$studid', '$father', '$f_age', '$f_occu', '$f_income', '$f_status', '$f_educattain', '$mother', '$m_age', '$m_occu', '$m_income', '$m_status', '$m_educattain')";
    $conn->query($query);
} else {
    // Parent table is not empty, update existing data
    $query = "UPDATE parentinfo SET 
              father = '$father', f_age = '$f_age', f_occu = '$f_occu', f_income = '$f_income', f_status = '$f_status', f_educattain = '$f_educattain', 
              mother = '$mother', m_age = '$m_age', m_occu = '$m_occu', m_income = '$m_income', m_status = '$m_status', m_educattain = '$m_educattain' 
              WHERE studid = '$studid'";
    $conn->query($query);
}


        $coePath = 'assets/uploads/requirements/coe/' . basename($_FILES['coe']['name']);
        $coe = basename($_FILES['coe']['name']);
        $coemaxFileSize = 10000000; // 10MB
        $coeallowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
       
        $schoolidPath = 'assets/uploads/requirements/schoolid/' . basename($_FILES['schoolid']['name']);
        $schoolid = basename($_FILES['schoolid']['name']);
        $coemaxFileSize = 10000000; // 10MB
        $schoolidallowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
       
        $gradesPath = 'assets/uploads/requirements/grades/' . basename($_FILES['grades']['name']);
        $grades = basename($_FILES['grades']['name']);
        $gradesmaxFileSize = 10000000; // 10MB
        $gradesallowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
       
        $letterPath = 'assets/uploads/requirements/letter/' . basename($_FILES['letter']['name']);
        $letter = basename($_FILES['letter']['name']);
        $lettermaxFileSize = 10000000; // 10MB
        $letterallowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
       
        $indigentPath = 'assets/uploads/requirements/indigent/' . basename($_FILES['indigent']['name']);
        $indigent = basename($_FILES['indigent']['name']);
        $indigentmaxFileSize = 10000000; // 10MB
        $indigentallowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
       
    }
}
?>