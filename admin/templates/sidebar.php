<?php // function to get the current page name
//session_start();
if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'admin') {
	header('location:login.php');
    exit();
}
else {
$id = $_SESSION['id'] ;
		$query 		= "SELECT * FROM `admin` join staff on staff.staffid=admin.empid WHERE adminid= '$id'";
		$result 	= $conn->query($query);
        
        if (!$result) {
            // Display SQL error for debugging
            echo "Error: " . $conn->error;
            exit();
        }		
		if($result->num_rows){
			while ($row = $result->fetch_assoc()) {
				$adminid = $row['adminid'];
				$username = $row['username'];
				$role = $row['position'];
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
          
          $pendingcomp = $allcomplaints['pending_count']; 
function PageName() {
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
                        <img src="assets/img/person.png" alt="..." class="avatar-img rounded-circle">
                    <?php endif ?>
                   
                </div>
                <div class="info">
                <a data-toggle="collapse" href="<?= $role == 'admin' ? '#collapseExample' : 'javascript:void(0)' ?>" aria-expanded="true">
                        <span>
                            <?php echo ucfirst($username); ?>
                            <span class="user-level"><?php echo ucfirst($role); ?></span>
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
                  <!--   <h4 class="text-section">Menu</h4>-->
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
                        <p>Announcement</p>
                    </a>
                </li>
                <li class="nav-item <?= $current_page=='complaint.php' || $current_page=='complaint_pending.php' || $current_page=='complaint_inprocess.php' || $current_page=='complaint_closed.php' ? 'active' : null ?>">
                    <a href="complaint.php">
                        <i class="icon-docs"></i>
                        <p>Queries <?php if ($pendingcomp > 0): ?>
                <span class="badge badge-danger"><?=$pendingcomp?></span>
            <?php endif; ?></p>
                    </a>
                </li>
                <!--<li class="nav-item <?= $current_page=='messages.php'  ? 'active' : null ?>">
                    <a href="messages.php">
                        <i class="fa fa-comments"></i>
                        <p>Messages</p>
                    </a>
                </li> -->
                <li class="nav-item <?= $current_page=='staff.php'  ? 'active' : null ?>">
                    <a href="staff.php">
                        <i class="fas fa-id-badge"></i>
                        <p>staff</p>
                    </a>
                </li>
                <li class="nav-item <?= $current_page=='student.php'  ? 'active' : null ?>">
                    <a href="student.php">
                        <i class="fas fa-address-card"></i>
                        <p>Students</p>
                    </a>
                </li>
                <li class="nav-item <?= $current_page=='reports.php' ? 'active' : null ?>">
                    <a href="reports.php">
                        <i class="icon-layers"></i>
                        <p>Reports</p>
                    </a>
                </li>
             <!--   <li class="nav-item ">
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
                </li>-->
                   
                  
               
             
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