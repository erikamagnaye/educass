<?php // function to get the current page name

if (strlen($_SESSION['id'] == 0) || !isset($_SESSION['id']) || !isset($_SESSION['email'])) {
	header('location:login.php');
    exit();
}

else{
$id = $_SESSION['id'] ;
//$name = $_SESSION['name'] ;
//$email = $_SESSION['email'] ;
		$query 		= "SELECT * FROM `student` WHERE studid= '$id'";
		$result 	= $conn->query($query);
        
        if (!$result) {
            // Display SQL error for debugging
            echo "Error: " . $conn->error;
            exit();
        }		
		if($result->num_rows){
			while ($row = $result->fetch_assoc()) {
				$studid = $row['studid'];
				$name = $row['firstname'];
                $email = $row['email'];
				//$role = $row['position'];
			}
			}
            date_default_timezone_set('Asia/Manila');
         
            $currentDate = date("Y-m-d");
            $announce = mysqli_query($conn, "SELECT COUNT(*) FROM `announcement` WHERE DATE(date) = '$currentDate'")->fetch_assoc()['COUNT(*)'];

function PageName() { //return the file name of the current PHP script, without the directory path.
  return substr( $_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"],"/") +1);
}

$current_page = PageName();
?>
<div class="sidebar sidebar-style-2">			
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <?php if(!empty($_SESSION['avatar'])): ?>
                        <img src="<?= preg_match('/data:image/i', $_SESSION['avatar']) ? $_SESSION['avatar'] : 'assets/uploads/applicant_Profile/'.$_SESSION['avatar'] ?>" alt="..." class="avatar-img rounded-circle">
                    <?php else: ?>
                        <img src="assets/img/pic.jpg" alt="..." class="avatar-img rounded-circle">
                    <?php endif ?>
                   
                </div>
                <div class="info">
                <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                <span>
                            <?php echo ucfirst($name); ?>
                            <span class="user-level"><?php echo ucfirst($email); ?></span>
                            <span class="caret"></span>
                          
                        </span>
                    </a>
                    <div class="clearfix"></div>
                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#edit_profile" data-toggle="modal">
                                    <span class="link-collapse">Edit Profile</span>
                                </a>
                                <a href="#changepass" data-toggle="modal">
                                    <span class="link-collapse">Change Password</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item <?= $current_page=='dashboard.php'? 'active' : null ?>">
                    <a href="dashboard.php" >
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu</h4>
                </li>
                <li class="nav-item <?= $current_page=='educaids.php' || $current_page=='viewprinteduc.php' ? 'active' : null ?>">
                    <a href="educaids.php">
                        <i class="fa fa-graduation-cap"></i>
                        <p>Educational Aids</p>
                    </a>
                </li>
                <li class="nav-item <?= $current_page=='announcement.php' || $current_page=='generate_resident.php' ? 'active' : null ?>">
                    <a href="announcement.php">
                        <i class="fa fa-bullhorn"></i>
                        <p>Announcement  <?php if ($announce > 0): ?>
                <span class="badge badge-danger"><?=$announce?></span>
            <?php endif; ?></p>
                    </a>
                </li>
                <li class="nav-item <?= $current_page=='complaint.php'  ? 'active' : null ?>">
                    <a href="complaint.php">
                        <i class="icon-docs"></i>
                        <p>Concerns</p>
                    </a>
                </li>
            
                <li class="nav-item <?= $current_page=='profile.php'  ? 'active' : null ?>">
                    <a href="profile.php">
                        <i class="fas fa-user-tie"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="logout.php">
                        <i class="fa fa-power-off"></i>
                        <p>Logout</p>
                    </a>
                </li>
              
              
                
            </ul>
        </div>
    </div>
</div><?php }?>