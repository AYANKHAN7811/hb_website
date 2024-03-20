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
	<title>Settings</title>
</head>
<body class="bg-light">

<?php require 'inc/header.php'; ?>

<div class="container-fluid" id="main-content">
	<div class="row">
		<div class="col-lg-10 ms-auto p-4 overflow-hidden ">

			<h3 class="mb-4">SETTINGS</h3>
			<!-- General settings -->
			<div class="card border-0 shadow-sm mb-4" >
				<div class="card-body">
				  	<div class="d-flex align-items-center justify-content-between mb-3">
				  		<h5 class="card-title m-0">General Settings</h5>
				  		<button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-s">
						  <i class="bi bi-pencil-square"></i>Edit
						</button>
				  	</div>
				    <h6 class="card-subtitle mb-2 fw-bold">Site Title</h6>
				    <p class="card-text" id="site_title"></p>
				    <h6 class="card-subtitle mb-2 fw-bold">About Us</h6>
				    <p class="card-text" id="site_about"></p>
			  	</div>
			</div>

			<!-- General settings Modal -->
			<div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				 <div class="modal-dialog">
				 	<form id="general_s_form">
					    <div class="modal-content">
					    	<div class="modal-header">
						        <h5 class="modal-title" >General Settings</h5>
					        </div>
					      	<div class="modal-body">
						        <div class="mb-3">
									<label class="form-label fw-bold">Site title</label>
									<input type="text" required name="site_title" id="site_title_inp" class="form-control shadow-none">
								</div>
								<div class="col-md-12 mb-3">
									<label class="form-label fw-bold">About us</label>
									<textarea name="site_about" required id="site_about_inp" class="form-control shadow-none" rows="5"></textarea>
								</div>
					      	</div>
					      	<div class="modal-footer">
						        <button type="button" onclick="site_title.value = general_data.site_title,site_about.value = general_data.site_about" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
						        <button type="submit" class="btn costum-bg text-white shadow-none">Save</button>
					      	</div>
					    </div>
				 	</form>
				 </div>
			</div>

			<!-- Shutdown section -->
			<div class="card border-0 shadow-sm mb-4" >
			  <div class="card-body">
			  	<div class="d-flex align-items-center justify-content-between mb-3">
			  		<h5 class="card-title m-0">Shutdown website</h5>
			  		<form>
				  		<div class="form-check form-switch">
						  <input onchange="upd_shutdown(this.value)" class="form-check-input" type="checkbox" id="shutdown-toggle">
						</div>
					</form>
			  	</div>
			    <p class="card-text" >No customers will be allowed to book Hotel rooms, while shutdown</p>
			  </div>
			</div>

			<!-- contact details section -->
			<div class="card border-0 shadow-sm mb-4" >
			  <div class="card-body">
			  	<div class="d-flex align-items-center justify-content-between mb-3">
			  		<h5 class="card-title m-0">Contacts Settings</h5>
			  		<button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#contacts-s">
					  <i class="bi bi-pencil-square"></i>Edit
					</button>
			  	</div>
			  	<div class="row">
			  		<div class="col-lg-6">
			  			<div class="mb-4">
						    <h6 class="card-subtitle mb-2 fw-bold">Address</h6>
						    <p class="card-text" id="address"></p>
			  			</div>
			  			<div class="mb-4">
						    <h6 class="card-subtitle mb-2 fw-bold">Google Map</h6>
						    <p class="card-text" id="gmap"></p>
			  			</div>
			  			<div class="mb-4">
						    <h6 class="card-subtitle mb-2 fw-bold">Phone Number</h6>
						    <p class="card-text mb-1">
						    	<i class="bi bi-telephone-outbound-fill"></i>
						    	<span id="pn1"></span>
						    </p>
						    <p class="card-text">
						    	<i class="bi bi-telephone-outbound-fill"></i>
						    	<span id="pn2"></span>
						    </p>
			  			</div>
			  			<div class="mb-4">
						    <h6 class="card-subtitle mb-2 fw-bold">E-mail</h6>
						    <p class="card-text" id="email"></p>
			  			</div>
			  		</div>
			  		<div class="col-lg-6">
			  			<div class="mb-4">
			  				 <h6 class="card-subtitle mb-2 fw-bold">Social Links</h6>
						    <p class="card-text mb-1">
								<i class="bi bi-facebook me-1"></i>
						    	<span id="fb"></span>
						    </p>
						    <p class="card-text mb-1">
								<i class="bi bi-twitter me-1"></i>
						    	<span id="tw"></span>
						    </p>
						    <p class="card-text">
								<i class="bi bi-instagram me-1"></i>
						    	<span id="insta"></span>
						    </p>
			  			</div>
			  			<div class="mb-4">
			  				<h6 class="card-subtitle mb-2 fw-bold">Iframe</h6>
						  	<iframe id="iframe" src="" loading="lazy" class="border p-2 w-100"></iframe>
			  			</div>
			  		</div>
			  	</div>
			  </div>
			</div>

			<!-- contact details Modal -->
			<div class="modal fade" id="contacts-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				 <div class="modal-dialog modal-lg">
				 	<form id="contacts_s_form">
					    <div class="modal-content">
					    	<div class="modal-header">
						        <h5 class="modal-title" >Contact Settings</h5>
					        </div>
					      	<div class="modal-body">
					      		<div class="container-fluid p-0">
					      			<div class="row">
					      				<div class="col-lg-6">
					      					<div class="mb-3">
												<label class="form-label fw-bold">Address</label>
												<input type="text" required name="address" id="address_inp" class= "form-control shadow-none">
											</div>
											<div class="mb-3">
												<label class="form-label fw-bold">Google Map</label>
												<input type="text" required name="gmap" id="gmap_inp" class= "form-control shadow-none">
											</div>
											<div class="mb-3">
												<label class="form-label fw-bold">Phone Number (With Country Code)</label>
												<div class="input-group mb-3">
												    <span class="input-group-text">
						    							<i class="bi bi-telephone-outbound-fill"></i>
												    </span>
												  	<input type="text" name="pn1" id="pn1_inp" class="form-control shadow-none" required>
												</div>
												<div class="input-group mb-3">
												  	<span class="input-group-text">
						    							<i class="bi bi-telephone-outbound-fill"></i>
												    </span>
												  	<input type="text" name="pn2" id="pn2_inp" class="form-control shadow-none" >
												</div>
											</div>
											<div class="mb-3">
												<label class="form-label fw-bold">E-mail</label>
												<input type="email" required name="email" id="email_inp" class= "form-control shadow-none">
											</div>
					      				</div>
					      				<div class="col-lg-6">
					      					<div class="mb-3">
												<label class="form-label fw-bold">Social Links</label>
												<div class="input-group mb-3">
												    <span class="input-group-text">
														<i class="bi bi-facebook me-1"></i>
												    </span>
												  	<input type="text" name="fb" id="fb_inp" class="form-control shadow-none" required>
												</div>
												<div class="input-group mb-3">
												    <span class="input-group-text">
														<i class="bi bi-twitter me-1"></i>
												    </span>
												  	<input type="text" name="tw" id="tw_inp" class="form-control shadow-none" required>
												</div>
												<div class="input-group mb-3">
												    <span class="input-group-text">
														<i class="bi bi-instagram me-1"></i>
												    </span>
												  	<input type="text" name="insta" id="insta_inp" class="form-control shadow-none" >
												</div>
											</div>
											<div class="mb-3">
												<label class="form-label fw-bold">Iframe Src</label>
												<input type="text" required name="iframe" id="iframe_inp" class= "form-control shadow-none">
											</div>
					      				</div>
					      			</div>
					      		</div>
					      	</div>
					      	<div class="modal-footer">
						        <button type="button" onclick="contacts_inp(contacts_data)" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
						        <button type="submit" class="btn costum-bg text-white shadow-none">Save</button>
					      	</div>
					    </div>
				 	</form>
				 </div>
			</div>

			<!-- Management Team Section -->
			<div class="card border-0 shadow-sm mb-4" >
				<div class="card-body">
				  	<div class="d-flex align-items-center justify-content-between mb-3">
				  		<h5 class="card-title m-0">Management Team </h5>
				  		<button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#team-s">
						  <i class="bi bi-plus-circle"></i> Add
						</button>
				  	</div>
				  	<div class="row" id="team-data">
				  		
				  	</div>
			  	</div>
			</div>

			<!-- Management Team  Modal -->
			<div class="modal fade" id="team-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				 <div class="modal-dialog">
				 	<form id="team_s_form">
					    <div class="modal-content">
					    	<div class="modal-header">
						        <h5 class="modal-title" >Add Team Members</h5>
					        </div>
					      	<div class="modal-body">
						        <div class="mb-3">
									<label class="form-label fw-bold">Name</label>
									<input type="text" required name="member_name" id="member_name_inp" class="form-control shadow-none">
								</div>
								<div class="col-md-12 mb-3">
									<label class="form-label fw-bold">Picture</label>
									<input type="file" required name="member_picture" accept="[.jpg, .png, .webp, .jpeg]" id="member_picture_inp" class="form-control shadow-none">
								</div>
					      	</div>
					      	<div class="modal-footer">
						        <button type="button" onclick="" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
						        <button type="submit" class="btn costum-bg text-white shadow-none">Save</button>
					      	</div>
					    </div>
				 	</form>
				 </div>
			</div>

		</div>
	</div>	
</div>

<?php require('inc/script.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="script/settings.js"></script>
</body>
</html>
