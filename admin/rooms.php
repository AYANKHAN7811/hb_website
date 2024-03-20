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
			<h3 class="mb-4">ROOMS</h3>

			<div class="card border-0 shadow-sm mb-4" >
				<div class="card-body">
					<div class="text-end mb-4">
				  		<button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-room">
						  <i class="bi bi-plus-square"></i>Add
						</button>
				  	</div>
				  	<div class="table-responsive-lg longEnough " style="height:360px; overflow-y:scroll;">
				  		<table class="table table-hover border text-center">
						  	<thead>
							    <tr class="bg-dark text-white">
							      <th scope="col">Id</th>
							      <th scope="col">Name</th>
							      <th scope="col">Area</th>
							      <th scope="col">Guests</th>
							      <th scope="col">Price</th>
							      <th scope="col">Quantity</th>
							      <th scope="col">Status</th>
							      <th scope="col">Action</th>
							    </tr>
						  	</thead>
						  	<tbody id="room_data">
						  		
					  				
						  	</tbody>
						</table>
				  	</div>
			  	</div>
			</div>

		</div>
	</div>	
</div>

<!-- Add rooms Modal -->
<div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	 <div class="modal-dialog modal-lg">
	 	<form id="add_room_form" action="ajax/ajax_rooms.php" method="POST">
		    <div class="modal-content">
		    	<div class="modal-header">
			        <h5 class="modal-title" >Add Rooms</h5>
		        </div>
		      	<div class="modal-body">
		      		<div class="row">
		      			<div class="col-md-6 mb-3">
							<label class="form-label fw-bold">Name</label>
							<input type="text" name="name" class="form-control shadow-none" required>
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label fw-bold">Area</label>
							<input type="number" min="1" name="area" class="form-control shadow-none" required>
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label fw-bold">Price</label>
							<input type="number" min="1" name="price" class="form-control shadow-none" required>
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label fw-bold">Quantity</label>
							<input type="number" min="1" name="quantity" class="form-control shadow-none" required>
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label fw-bold">Adult (Max.)</label>
							<input type="number" min="1" name="adult" class="form-control shadow-none" required>
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label fw-bold">Children (Max.)</label>
							<input type="number" min="1"  name="children" class="form-control shadow-none" required>
						</div>
						<div class="col-md-12 mb-3">
							<label class="form-label fw-bold">Features</label>
							<div class="row">
								<?php 
								$q = "SELECT * FROM `features`";
								$res = $con->query($q);
								while ($row=mysqli_fetch_assoc($res)) {
									echo "
										 <div class='col-md-3'>
										 	<label>
										 		<input type='checkbox' name='features[]' value='$row[id]' class='form-check-input shadow-none'>
										 		$row[name]
										 	</label>
										 </div>";
								}
								 ?>
							</div>
						</div>
						<div class="col-md-12 mb-3">
							<label class="form-label fw-bold">Facilities</label>
							<div class="row">
								<?php 
								$q = "SELECT * FROM `facilities`";
								$res = $con->query($q);
								while ($row=mysqli_fetch_assoc($res)) {
									echo "
										 <div class='col-md-3'>
										 	<label>
										 		<input type='checkbox' name='facilities[]' value='$row[id]' class='form-check-input shadow-none'>
										 		$row[name]
										 	</label>
										 </div>";
								}
								 ?>
							</div>
						</div>

						<div class="col-md-12 mb-3">
							<label class="form-label fw-bold">Description</label>
							<textarea name="desc" class="form-control shadow-none" rows="4" required></textarea>
						</div>		
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

<!-- Edit rooms Modal -->
<div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	 <div class="modal-dialog modal-lg">
	 	<form id="edit_room_form" action="ajax/ajax_rooms.php" method="POST">
		    <div class="modal-content">
		    	<div class="modal-header">
			        <h5 class="modal-title" >Edit Rooms</h5>
		        </div>
		      	<div class="modal-body" id="form_data">
		      		
		      	</div>
		      	<div class="modal-footer">
			        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
			        <button type="submit" name="save" class="btn costum-bg text-white shadow-none">Save</button>
		      	</div>
		    </div>
	 	</form>
	 </div>
</div>

<!-- Manage room images Modal -->
<div class="modal fade" id="add_img" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Room Name</h5>
				<button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body">
				<div class="border-bottom border-3 pb-3 mb3">
					<form id="add_image_form" action="ajax/ajax_rooms.php" method="POST"  enctype="multipart/form-data">
						<label class="form-label fw-bold">Add Images</label>
						<input type="file" name="image" id="image" class="form-control mb-3 shadow-none" required>
						<input type="hidden" name="room_id" id="room_id">
				        <button type="submit" name="add_img" class="btn costum-bg text-white shadow-none">Add</button>
					</form>
				</div>
				<div class="table-responsive-lg longEnough " style="height:350px; overflow-y:scroll;">
			  		<table class="table table-hover border text-center">
					  	<thead>
						    <tr class="bg-dark text-light sticky-top">
						      <th scope="col" width="60%">Images</th>
						      <th scope="col">Thumbnail</th>
						      <th scope="col">Delete</th>
						    </tr>
					  	</thead>
					  	<tbody id="room_image_data">
				  				
					  	</tbody>
					</table>
			  	</div>	
			</div>
		</div>
	</div>
</div>
<script src="script/rooms.js"></script>
<?php require('inc/script.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>