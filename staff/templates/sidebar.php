<?php // function to get the current page name

$skTypes = array('SK-Arawan','SK-Bagong Niing', 'SK-Balat Atis','SK-Briones','SK-Bulihan','SK-Buliran','SK-Callejon',
'SK-Corazon', 'SK-Del Valle','SK-loob','SK-Magsaysay','SK-Matipunso','SK-Niing','SK-Poblacion','SK-Pulo',
 'SK-Pury','SK-Sampaga','SK-Sampaguita', 'SK-San Jose', 'SK-Sinturisan'); 
if (!isset($_SESSION['staffid']) || strlen($_SESSION['staffid']) == 0 ||in_array($_SESSION['role'], $skTypes)) {
	header('location:index.php');
    exit();
}

else{
$staffid = $_SESSION['staffid'] ;
		$query 		= "SELECT * FROM `staff` WHERE staffid= '$staffid'";
		$result 	= $conn->query($query);
        
        if (!$result) {
            // Display SQL error for debugging
            echo "Error: " . $conn->error;
            exit();
        }		
		if($result->num_rows){
			while ($row = $result->fetch_assoc()) {
				$staffid = $row['staffid'];
				$name = $row['firstname'];
                $email = $row['email'];
				//$role = $row['position'];
			}
			}
            $stmt = $conn->prepare("SELECT 
            SUM(IF(`status` = 'Pending', 1, 0)) AS pending_count,
            SUM(IF(`status` = 'In Process', 1, 0)) AS in_process_count,
            SUM(IF(`status` = 'Close', 1, 0)) AS closed_count
          FROM `concerns`");
          $stmt->execute();
          $result = $stmt->get_result();
          $allcomplaints = $result->fetch_assoc();
          
          $pending = $allcomplaints['pending_count'];  
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
                        <img src="<?= preg_match('/data:image/i', $_SESSION['avatar']) ? $_SESSION['avatar'] : 'assets/uploads/avatar/'.$_SESSION['avatar'] ?>" alt="..." class="avatar-img rounded-circle">
                    <?php else: ?>
                        <img src="assets/img/logo.png" alt="..." class="avatar-img rounded-circle">
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
                <li class="nav-item <?= $current_page=='employeedashboard.php'? 'active' : null ?>">
                    <a href="employeedashboard.php" >
                        <i class="fa fa-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu</h4>
                </li>
                <li class="nav-item <?= $current_page=='educass.php' || $current_page=='viewprinteduc.php' ? 'active' : null ?>">
                    <a href="educass.php">
                        <i class="fa fa-graduation-cap"></i>
                        <p>Educational Aids</p>
                    </a>
                </li>
                <li class="nav-item <?= $current_page=='announcement.php' || $current_page=='generate_resident.php' ? 'active' : null ?>">
                    <a href="announcement.php">
                        <i class="fa fa-bullhorn"></i>
                        <p>Announcement  </p>
                    </a>
                </li>
                <li class="nav-item <?= $current_page=='complaint.php' || $current_page=='complaint_pending.php' || $current_page=='complaint_inprocess.php'|| $current_page=='complaint_closed.php'? 'active' : null ?>">
                    <a href="complaint.php">
                    <i class="fa-solid fa-clipboard-question"></i>
                        <p>Queries <?php if ($pending > 0): ?>
                <span class="badge badge-danger"><?=$pending?></span>
            <?php endif; ?></p>
                    </a>
                </li>
                <li class="nav-item <?= $current_page=='staff.php'  ? 'active' : null ?>">
                    <a href="staff.php">
                    <i class="fa-solid fa-user-group"></i>
                        <p>SK Officials</p>
                    </a>
                </li>
                <li class="nav-item <?= $current_page=='profile.php'  ? 'active' : null ?>">
                    <a href="profile.php">
                        <i class="fas fa-user-tie"></i>
                        <p>Profile</p>
                    </a>
                </li>
             
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">System</h4>
                </li>
                <li class="nav-item  'active' : null ?>">
                    <a href="#settings" data-toggle="collapse" class="collapsed" aria-expanded="false">
                        <i class="icon-wrench"></i>
                            <p>Settings</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse <?= $current_page=='purok.php' || $current_page=='position.php'  || $current_page=='precinct.php' || $current_page=='chairmanship.php' || $current_page=='users.php' || $current_page=='support.php' || $current_page=='backup.php' ? 'show' : null ?>" id="settings">
                        <ul class="nav nav-collapse">
                            
                        <li class="nav-item ">
                                    <a href="backup/backup.php">
                                    <i class="fa fa-database"></i>
                                        <p>Backup</p>
                                    </a>
                                </li>
                <li class="nav-item ">
                    <a href="logout.php">
                        <i class="fa fa-power-off"></i>
                        <p>Logout</p>
                    </a>
                </li>
                              
                           
                            <!--    <li>
                                    <a href="#restore" data-toggle="modal">
                                        <span class="sub-item">Restore</span>
                                    </a>
                                </li>  -->
                         
                        </ul>
                    </div>
                </li>
              
                
            </ul>
        </div>
    </div>
</div><?php }?>