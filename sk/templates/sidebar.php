<?php // function to get the current page name

$skTypes = array('SK-Arawan','SK-Bagong Niing', 'SK-Balat Atis','SK-Briones','SK-Bulihan','SK-Buliran','SK-Callejon',
'SK-Corazon', 'SK-Del Valle','SK-Loob','SK-Magsaysay','SK-Matipunso','SK-Niing','SK-Poblacion','SK-Pulo',
 'SK-Pury','SK-Sampaga','SK-Sampaguita', 'SK-San Jose', 'SK-Sinturisan'); 
if (!isset($_SESSION['skid']) || strlen($_SESSION['skid']) == 0 ||!in_array($_SESSION['role'], $skTypes)||!isset($_SESSION['skpos'])) {
	header('location:sklogin.php');
    exit();
}

else{
$skid = $_SESSION['skid'] ;
		$query 		= "SELECT * FROM `staff` WHERE staffid= '$skid'";
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
                $skemail = $row['email'];
				//$role = $row['position'];
			}
			}
            $stmt = $conn->prepare("SELECT 
            c.*,
            SUM(IF(c.`status` = 'Pending', 1, 0)) AS pending_count,
            SUM(IF(c.`status` = 'In Process', 1, 0)) AS in_process_count,
            SUM(IF(c.`status` = 'Close', 1, 0)) AS closed_count
        FROM `concerns` c
        JOIN `student` s ON c.`studid` = s.`studid`
        WHERE s.`brgy` = ?
        ");
        $stmt->bind_param("s", $skpos);
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
                            <span class="user-level"><?php echo ucfirst($skemail); ?></span>
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
                <li class="nav-item <?= $current_page=='skdashboard.php' ||$current_page=='pendingapplication.php' || $current_page=='approvedapplication.php'|| $current_page=='rejectedapplication.php'? 'active' : null ?>">
                    <a href="skdashboard.php" >
                        <i class="fa fa-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
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
              
             
                <li class="nav-item <?= $current_page=='profile.php'  ? 'active' : null ?>">
                    <a href="profile.php">
                        <i class="fas fa-user-tie"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item <?= $current_page=='logout.php'  ? 'active' : null ?>">
                    <a href="logout.php">
                        <i class="fas fa-power-off"></i>
                        <p>Logout</p>
                    </a>
                </li>
             
                
               
              
                
            </ul>
        </div>
    </div>
</div><?php }?>