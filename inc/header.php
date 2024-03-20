<nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><?php echo $title_row['site_title']; ?></a>
    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link  me-2" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="rooms.php">Rooms</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="facilities.php">Facilities</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="contact.php">Contact us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About us</a>
        </li>
      </ul>
      <div class="d-flex">
      	<?php 
      		if (isset($_SESSION['login']) && $_SESSION['login']==true) {
      	?>
	      	<div class="btn-group">
					  <button type="button" class="btn btn-outline-dark shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
					  	<img src="img/<?php echo $_SESSION['upic']; ?>" style="width: 25px; height: 25px;" class="me-2">
					    <?php echo $_SESSION['uname']; ?>
					  </button>
					  <ul class="dropdown-menu dropdown-menu-lg-end">
					    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
					    <li><a class="dropdown-item" href="bookings.php">Bookings</a></li>
					    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
					  </ul>
					</div>
      	<?php		
      		}else{
      	 ?>
				<button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2 " data-bs-toggle="modal" data-bs-target="#loginmodal">
				Login
				</button>
				<button type="button" class="btn btn-outline-dark shadow-none " data-bs-toggle="modal" data-bs-target="#registermodal">
				Register
				</button>
			<?php } ?>
      </div>
    </div>
  </div>
</nav>

<!-- user login -->

<div class="modal fade" id="loginmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<form  id="login-form" action="" enctype="multipart/form-data">
	      <div class="modal-header">
	        <h5 class="modal-title d-flex align-items-center"><i class="bi bi-person-circle fs-3 me-2"></i>User Login</h5>
	        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
					<div class="mb-3">
						<label class="form-label">Email / Number</label>
						<input type="text" name="email_num" class="form-control shadow-none" required>
					</div>
					<div class="mb-4">
						<label class="form-label">Password</label>
						<input type="password" name="password" class="form-control shadow-none" required>
					</div>
					<div class="d-flex align-items-center justify-content-between mb-2">
						<input type="submit" name="login" class="btn btn-dark shadow-none" value="Login" data-bs-dismiss="modal">
						<button type="button" class="btn text-secondary text-decoration-none shadow-none " data-bs-toggle="modal" data-bs-target="#forgotmodal">
						Forgot Password?
						</button>
					</div>
	      </div>
      </form>
    </div>
  </div>
</div>

<!-- user register -->

<div class="modal fade" id="registermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<form method="POST" action="" id="register-form" enctype="multipart/form-data">
		    <div class="modal-header">
		       <h5 class="modal-title d-flex align-items-center"><i class="bi bi-person-check-fill fs-3 me-2"></i>User Registration</h5>
		        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		    </div>
		     <div class="modal-body">
					<span class="badge bg-light text-dark mb-3 text-wrap lh-base">
						Note: Your detail must match your ID(Aadhar Card, Driving Licence, Passport etc.)
						that will be required during check-in.
					</span>
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6 mb-3">
								<label class="form-label">Name</label>
								<input type="text" name="name" class="form-control shadow-none" required>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Email</label>
								<input type="email" name="email" class="form-control shadow-none" required>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Phone Number</label>
								<input type="number" name="number" class="form-control shadow-none" required>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Picture</label>
								<input type="file" name="pic" id="pic" class="form-control shadow-none" required>
							</div>
							<div class="col-md-12 mb-3">
								<label class="form-label">Adress</label>
								<textarea class="form-control shadow-none" name="address" rows="1" required></textarea>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Pincode</label>
								<input type="number" name="pin" class="form-control shadow-none" required>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Date of Birth</label>
								<input type="date" name="dob" class="form-control shadow-none" required>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Password</label>
								<input type="password" name="pass" class="form-control shadow-none" required>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Confirm Password</label>
								<input type="password" name="con_pass" class="form-control shadow-none" required>
							</div>
						</div>
						<div class="text-center">
							<input type="submit" data-bs-dismiss="modal" name="submit" class="btn btn-dark shadow-none" value="Register">
						</div>
					</div>
		    </div>
      </form>
    </div>
  </div>
</div>

<!-- Forgot Password -->

<div class="modal fade" id="forgotmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<form  id="forgot-form" action="" enctype="multipart/form-data">
	      <div class="modal-header">
	        <h5 class="modal-title d-flex align-items-center"><i class="bi bi-person-circle fs-3 me-2"></i>Forgot Password</h5>
	        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	      	<span class="badge bg-light text-dark mb-3 text-wrap lh-base">
						Note: A link will be sent to your email to reset your password.
					</span>
					<div class="mb-4">
						<label class="form-label">Email</label>
						<input type="email" name="email" class="form-control shadow-none" required>
					</div>
					<div class="text-end mb-2">
						<button type="button" class="btn text-secondary text-decoration-none shadow-none " data-bs-toggle="modal" data-bs-target="#loginmodal">
						cancel
						</button>
						<input type="submit" name="login" class="btn btn-dark shadow-none" value="Send link" data-bs-dismiss="modal">
					</div>
	      </div>
      </form>
    </div>
  </div>
</div>