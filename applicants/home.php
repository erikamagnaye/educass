
<?php include 'server/server.php' ?>
<?php 

	$query = "SELECT * FROM tblresident WHERE resident_type=1";
    $result = $conn->query($query);
	$total = $result->num_rows;

	$query1 = "SELECT * FROM tblresident WHERE gender='Male' AND resident_type=1";
    $result1 = $conn->query($query1);
	$male = $result1->num_rows;

?>



<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <style>
    .card-container {
  display: flex;
  justify-content: center;
  margin-top: 100px;
  margin-left: 120px;
}

.card {
  margin: 10px;
  width: 300px;
  height: 150px;
  padding: 20px;
  background-color: #f0f0f0;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  text-align: center;
}

.card{
  background-color: white; /* Light Pink */
}

i {
  font-size: 50px;
  color: #333;
  margin-bottom: 10px;
}

h2 {
  color: #333;
  font-size: 24px;
  margin-bottom: 10px;
}

p {
  color: #666;
  font-size: 16px;
}
  </style>
</head>
<body>
    <?php include 'dashboard.php'; ?>
  <div class="card-container">
    <div class="card">
      <i class="fas fa-chart-bar"></i>
      <h2 class="fw-bold text-uppercase">Certificates</h2>
	<h3 class="fw-bold text-uppercase"><?= number_format($total) ?></h3>
    </div>
    
    <div class="card">
      <i class="fas fa-chart-line"></i>
      <h2 class="fw-bold text-uppercase">Complaints</h2>
	<h3 class="fw-bold text-uppercase"><?= number_format($total) ?></h3>
    </div>
    
    <div class="card">
      <i class="fas fa-chart-pie"></i>
      <h2 class="fw-bold text-uppercase">Officials</h2>
	<h3 class="fw-bold text-uppercase"><?= number_format($total) ?></h3>
    </div>
  </div>
  
  <script src="script.js"></script>
  <script>
    document.getElementById("dashboardCard").addEventListener("click", function() {
  window.location.href = "otherpage.html";
});
  </script>
</body>
</html>