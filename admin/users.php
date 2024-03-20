<?php 
require('inc/essential.php');
require('inc/db_config.php');
require('inc/links.php');
adminLogin();

 ?>
 <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Rooms</title>
	<?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
<?php require 'inc/header.php'; ?>
<?php 
if (isset($_SESSION['message'])) {
	alert('success',$_SESSION['message']);
	unset($_SESSION['message']);
}
 ?>
 <?php 
if (isset($_SESSION['img_msg'])) {
	alert('success',$_SESSION['img_msg']);
	unset($_SESSION['img_msg']);
}
 ?>
<div class="container-fluid" id="main-content">
	<div class="row">
		<div class="col-lg-10 ms-auto p-4 overflow-hidden">
			<h3 class="mb-4">USERS</h3>

			<div class="card border-0 shadow-sm mb-4" >
				<div class="card-body">
					<div class="text-end mb-4">
				  		<div class="text-end mb-4">
				  			<input type="text" oninput="search_user(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search users">
				  		</div>
				  	</div>
				  	<div class="table-responsive">
				  		<table class="table table-hover border text-center" style="min-width: 1300px;">
						  	<thead>
							    <tr class="bg-dark text-white">
							      <th scope="col">Id</th>
							      <th scope="col">Name</th>
							      <th scope="col">Email</th>
							      <th scope="col">Phone no.</th>
							      <th scope="col">Location</th>
							      <th scope="col">DOB</th>
							      <th scope="col">Verified</th>
							      <th scope="col">Status</th>
							      <th scope="col">Date</th>
							      <th scope="col">Action</th>
							    </tr>
						  	</thead>
						  	<tbody id="users_data">
						  		
					  				
						  	</tbody>
						</table>
				  	</div>
			  	</div>
			</div>

		</div>
	</div>	
</div>


<script src="script/users.js"></script>
<?php require('inc/script.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>