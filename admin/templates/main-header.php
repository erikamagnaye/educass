<?php //include 'model/fetch_brgy_info.php'
//session_start();
if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0 || $_SESSION['role'] !== 'Admin') {
	header('location:login.php');
    exit();
}
else {
?>

<div class="main-header">
    <!-- Logo Header data-background-color="green"-->
    <div class="logo-header" data-background-color="" style="background-color:#B8001F;">
        
        <a href="dashboard.php" class="logo">
            <img src="assets/img/logo.png" alt="navbar brand" class="navbar-brand" style="height: 45px; width: 45px;"> <span class="text-light ml-2 fw-bold" style="font-size:20px">EAAS SAQ</span>
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header data-background-color="green"-->
    <nav class="navbar navbar-header navbar-expand-lg"  style="background-color:#B8001F;">
        
        <div class="container-fluid"><span class="text-light ml-2 fw-medium" style="font-size:15px">Educational Assistance Application System for San Antonio, Quezon</span>
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
              <!--  <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-settings"></i>
                    </a>
                    <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                        <li>
                            <a class="see-all" onclick="window.location.href='logout.php';">Sign Out<i class="icon-logout"></i> </a>


                            <?php //if(isset($_SESSION['role'])):?>
                               <a class="see-all" href="logout.php">Sign Out<i class="icon-logout"></i> </a>
                            <?php //else: ?>
                                <a class="see-all" href="login.php">Sign In<i class="icon-login"></i> </a>  
                            <?php //endif ?>
                        </li>
                    </ul>
                </li>-->
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div><?php }?>