<?php 
require('inc/essential.php');
require('inc/db_config.php');
require('inc/links.php');
adminLogin();

if (isset($_GET['del'])) {
	$frm_data = filteration($_GET);
	
	$query = "DELETE FROM `features` WHERE `id`=$frm_data[del]";
	$result = $con->query($query);

	if ($result) {
		alert('success','Data deleted!');
	}else{
		alert('Danger','Operation failed!');

	}

}
 ?>
 <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Features & Facilities</title>
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
<div class="container-fluid" id="main-content">
	<div class="row">
		<div class="col-lg-10 ms-auto p-4 overflow-hidden ">
			<h3 class="mb-4">FEATURES & FACILITIES</h3>

			<div class="card border-0 shadow-sm mb-4" >
				<div class="card-body">

					<div class="d-flex align-items-center justify-content-between mb-3">
				  		<h5 class="card-title m-0">Features</h5>
				  		<button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#features-s">
						  <i class="bi bi-plus"></i>Add
						</button>
				  	</div>

				  	<div class="table-responsive-md longEnough " style="height:350px; overflow-y:scroll;">
				  		<table class="table table-hover border">
						  	<thead>
							    <tr class="bg-dark text-white">
							      <th scope="col">Id</th>
							      <th scope="col">Name</th>
							      <th scope="col">Action</th>
							    </tr>
						  	</thead>
						  	<tbody id="features_data">
						  		
					  				
						  	</tbody>
						</table>
				  	</div>
			  	</div>
			</div>

			<div class="card border-0 shadow-sm" >
				<div class="card-body">

					<div class="d-flex align-items-center justify-content-between mb-3">
				  		<h5 class="card-title m-0">Facilities</h5>
				  		<button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facility-s">
						  <i class="bi bi-plus"></i>Add
						</button>
				  	</div>

				  	<div class="table-responsive-md longEnough " style="height:350px; overflow-y:scroll;">
				  		<table class="table table-hover border">
						  	<thead>
							    <tr class="bg-dark text-white">
							      <th scope="col">Id</th>
							      <th scope="col">Icon</th>
							      <th scope="col">Name</th>
							      <th scope="col" width="40%">Discription</th>
							      <th scope="col">Action</th>
							    </tr>
						  	</thead>
						  	<tbody id="facilities_data">
						  		
					  				
						  	</tbody>
						</table>
				  	</div>
			  	</div>
			</div>
		</div>
	</div>	
</div>

<!-- Features Modal -->
<div class="modal fade" id="features-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	 <div class="modal-dialog">
	 	<form id="feature_s_form">
		    <div class="modal-content">
		    	<div class="modal-header">
			        <h5 class="modal-title" >Add Features</h5>
		        </div>
		      	<div class="modal-body">
			        <div class="mb-3">
						<label class="form-label fw-bold">Name</label>
						<input type="text" name="feature_name" class="form-control shadow-none" required>
					</div>
		      	</div>
		      	<div class="modal-footer">
			        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
			        <button type="submit" name="submit" class="btn costum-bg text-white shadow-none">Save</button>
		      	</div>
		    </div>
	 	</form>
	 </div>
</div>

<!-- Facility Modal -->
<div class="modal fade" id="facility-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	 <div class="modal-dialog">
	 	<form method="POST" action="ajax/ajax_features_facilities.php" enctype="multipart/form-data">
		    <div class="modal-content">
		    	<div class="modal-header">
			        <h5 class="modal-title" >Add Facilitiy</h5>
		        </div>
		      	<div class="modal-body">
			        <div class="mb-3">
						<label class="form-label fw-bold">Name</label>
						<input type="text" required name="facility_name" id="facility_name" class="form-control shadow-none">
					</div>
					<div class="col-md-12 mb-3">
						<label class="form-label fw-bold">Icon</label>
						<input type="file" name="facility_icon" id="facility_icon" class="form-control shadow-none" required>
					</div>
					<div class="col-md-12 mb-3">
						<label class="form-label fw-bold">Discription</label>
						<textarea name="faiclity_desc" id="facility_desc" class="form-control shadow-none" rows="3"></textarea>
					</div>
		      	</div>
		      	<div class="modal-footer">
			        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
			        <button type="submit" name="submit" class="btn costum-bg text-white shadow-none">Save</button>
		      	</div>
		      	<span id="uploadStatus"></span>
		    </div>
	 	</form>
	 </div>
</div>
<?php require('inc/script.php'); ?>
<script src="script/features_facilities.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>