
    <?php
    session_start();
    session_destroy();
    header("Location: employeelogin.php");
    exit();
    
    