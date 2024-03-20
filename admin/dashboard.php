<?php 
require('inc/essential.php');
require('inc/links.php');
adminLogin();
 ?>

<!DOCTYPE html>
<html> 
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dashboard</title>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<style>

	</style>
</head>
<body class="bg-light">

<?php require 'inc/header.php'; ?>

<div class="container-fluid" id="main-content">
  <div class="row">
    <div class="col-lg-10 ms-auto p-4 overflow-hidden">
    	<div class="row d-flex justify-content-between mb-3">
    		<div class="col-lg-6 " style="background: #f2f2f2;">
      			<canvas id="myDoughnutChart" width="350" height="350"></canvas>
    		</div>
    	</div>
    </div>
  </div>
</div>
<script>
// Dummy data for the doughnut chart
var dummyDoughnutData = {
  labels: ["Room1", "Room2", "Room3", "Room4", "Room5"],
  datasets: [{
    label: "Used",
    data: [50, 80, 10, 200, 75],
    backgroundColor: [
      'rgba(255, 99, 132, 0.7)',
      'rgba(54, 162, 235, 0.7)',
      'rgba(255, 206, 86, 0.7)',
      'rgba(75, 192, 192, 0.7)',
      'rgba(153, 102, 255, 0.7)',
    ],
    borderColor: [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(153, 102, 255, 1)',
    ],
    borderWidth: 1
  }]
};

// Get the doughnut chart container
var doughnutCtx = document.getElementById('myDoughnutChart').getContext('2d');

// Create a doughnut chart
var myDoughnutChart = new Chart(doughnutCtx, {
  type: 'doughnut',
  data: dummyDoughnutData,
  options: {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '40%', // Adjust the cutout percentage as needed for the desired appearance
  }
});
</script>
<?php require('inc/script.php') ?>
</body>
</html>