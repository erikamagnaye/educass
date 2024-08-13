<?php
include 'server/server.php';
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
    $query = "SELECT * FROM `announcement` WHERE `title` LIKE '%$searchQuery%' OR `date` LIKE '%$searchQuery%' ORDER BY `date` DESC";
    $view_data = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($view_data)) {
        $announceid = $row['announceid'];
        $title = $row['title'];
        $date = $row['date'];
        $details = $row['details'];
        ?>
         <div class="card mb-2" style="border-width: 1px; border-radius: 10px;">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title mb-0"><?php echo $title;?></h6>
                                    <small class="text-muted">Posted on: <?php echo $date;?></small>
                                </div>
                                <div>
                                    <a href="view_announcement.php?announceid=<?php echo $announceid; ?>" class="btn btn-success btn-sm" title="View">
                                    View
                                    </a>
                         
                                  
                                                 

                                </div>
                            </div>
                        </div>
                    </div>
        <?php
    }
}
?>