<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
	<?php require('inc/links.php') ?>
	<title>TAJ Hotel - HOME</title>
	<style>
		.availability-form{
			margin-top: -50px;
			z-index: 2;
			position: relative;
		}
	</style>

</head>
<body class="bg-light ">

<?php require('inc/header.php'); ?>

<!-- Carousel -->

<div class="container-fluid px-lg-4 mt-4" >
	<div class="swiper mySwiper">
	    <div class="swiper-wrapper">
		    <div class="swiper-slide">
		       <img src="img/2.jpg" class="w-100 d-block" / style="height: 60vh">
		    </div>
		    <div class="swiper-slide">
		       <img src="img/3.webp" class="w-100 d-block" / style="height: 60vh">
		    </div>
		    <div class="swiper-slide">
		       <img src="img/4.jpg" class="w-100 d-block" / style="height: 60vh">
		    </div>
		  </div>
 	</div>
</div>

<!-- check avalilbility form -->

<div class="container availability-form">
	<div class="row">
		<div class="col-lg-12 bg-white shadow p-4 rounded">
			<h5 class="mb-4">check booking availability</h5>
			<form>
				<div class="row align-items-end">
					<div class="col-lg-3 mb-3">
							<label class="form-label" style="font-weight: 500;">Check-in</label>
							<input type="date" class="form-control shadow-none">
					</div>
					<div class="col-lg-3 mb-3">
							<label class="form-label" style="font-weight: 500;">Check-out</label>
							<input type="date" class="form-control shadow-none">
					</div>
					<div class="col-lg-3 mb-3">
						<label class="form-label" style="font-weight: 500;">Adult</label>
							<select class="form-select shadow-none">
								<option selected>Open this select menu</option>
								<option value="1">One</option>
								<option value="2">Two</option>
								<option value="3">Three</option>
							</select>
					</div>
					<div class="col-lg-2 mb-3">
						<label class="form-label" style="font-weight: 500;">Children</label>
							<select class="form-select shadow-none">
								<option selected>Open this select menu</option>
								<option value="1">One</option>
								<option value="2">Two</option>
								<option value="3">Three</option>
							</select>
					</div>
					<div class="col-lg-1 mb-lg-3 mt-2">
						<button type="submit" class="btn text-white shadow-none costum-bg">submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Rooms -->

<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR ROOMS</h2>

<div class="container">
	<div class="row">
		<?php 
			$room_res = $con->query("SELECT * FROM `rooms` WHERE `status`=1 AND `removed`=0 ORDER BY `id` DESC LIMIT 3");

			while ($room_data = mysqli_fetch_assoc($room_res)) {

				// get feature of room
				$fea_q = $con->query("SELECT f.name FROM `features` f
						INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
						WHERE rfea.room_id = '$room_data[id]'");
				$features_data = "";
				while ($features_row = mysqli_fetch_assoc($fea_q)) {
				$features_data .= "<span class='badge rounded-pill bg-light text-dark mb-1 text-wrap'>
								$features_row[name]
								</span>";

				}

				// get facility of room
				$fac_q = $con->query("SELECT f.name FROM `facilities` f
						INNER JOIN `room_facilities` rfac ON f.id = rfac.facility_id
						WHERE rfac.room_id = '$room_data[id]'");
				$facilities_data = "";
				while ($facility_row = mysqli_fetch_assoc($fac_q)) {
				$facilities_data .= "<span class='badge rounded-pill bg-light text-dark mb-1 text-wrap'>
								$facility_row[name]
								</span>";

				}

				$thumb_q = $con->query("SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]' AND `thumbnail`='1'");
				$get_thumb = '';
				if (mysqli_num_rows($thumb_q)) {
					$thumb_row = mysqli_fetch_assoc($thumb_q);
					$get_thumb = "img/".$thumb_row['image'];
				}else{
					$get_thumb = "img/de.png";
				}

			?>
		<div class="col-lg-4 col-md-6 my-3">
			<div class="card border-0 shadow" style="max-width: 300px; margin: auto;">
				<img src="<?php echo $get_thumb ?>" class="card-img-top" style="height: 175px;">
				<div class=" row card-body">
					<div class=" col-lg-7">
						<h5 class="card-title"><?php echo $room_data['name']; ?></h5>
						<h6 class="mb-2"><?php echo $room_data['price'] ?>₹ per night</h6>
					</div>
					<div class="col-lg-5 rating mb-2">
						<h6 class="mb-1">Ratings</h6>
						<span class="badge rounded-pill bg-light">
						<i class="bi bi-star-fill text-warning"></i>
						<i class="bi bi-star-fill text-warning"></i>
						<i class="bi bi-star-fill text-warning"></i>
						<i class="bi bi-star-fill text-warning"></i>
					</span>
					</div>
					<div class="features mb-2">
						<h6 class="mb-1">Features</h6>
						<?php echo $features_data; ?>
					</div>
					<div class="facilities mb-2">
						<h6 class="mb-1">Facilities</h6>
						<?php echo $facilities_data; ?>
					</div>
					<div class="guest mb-2">
						<h6 class="mb-1">Guest</h6>
						<span class="badge rounded-pill bg-light text-dark mb-1 text-wrap ">
							<?php echo $room_data['adult'] ?> Adult
						</span>
						<span class="badge rounded-pill bg-light text-dark mb-1 text-wrap ">
							<?php echo $room_data['children'] ?> Childern
						</span>
					</div>
					<div class="d-flex justify-content-evenly mb-2">
						<?php 
						 	$book_btn = "";
							if (!$title_row['shutdown']==1) {
								$login = 0;
								if (isset($_SESSION['login']) && $_SESSION['login']==true) {
									$login = 1;
								}
								$book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm text-white costum-bg shadow-none me-2'>Book Now</button>";
							}
							echo $book_btn;
						 ?>
						<a href="#" class="btn btn-sm btn-outline-dark shadow-none">More Detail</a>
					</div>
				</div>
			</div>
		</div>
<?php } ?>
		<div class="col-lg-12 text-center mt-5 mb-5">
			<a href="rooms.php" class="btn btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms >>></a>
		</div>
	</div>
</div>

<!-- Facilities -->


<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR FACILITIES</h2>

<div class="container">
	<div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
			<?php 
			$res = $con->query("SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT 5");
			while ($row=mysqli_fetch_assoc($res)) {
			 ?>
			<div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
				<img src="admin/images/<?php echo $row['icon']; ?>" width="80px">
				<h5 class="mt-3"><?php echo $row['name']; ?></h5>
			</div>
			 <?php  } ?>
		<div class="col-lg-12 text-center mt-5 mb-5">
			<a href="facilities.php" class="btn btn-outline-dark rounded-0 fw-bold shadow-none">More Facilities >>></a>
		</div>
	</div>
</div>


<!-- Testimonials -->

<h2 class="mt-5 pt-4 mb-5 text-center fw-bold h-font">TESTIMONIALS</h2>

<div class="container">
  <div class="swiper swiper-testimonial">
    <div class="swiper-wrapper">
      <div class="swiper-slide bg-white p-4">
        <div class="profile d-flex align-items-center mb-3" >
        	<img src="img/1.jpg" width="30px">
        	<h6 class="m-0 ms-2">Random user1</h6>
        </div>
        <p>
	        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	        quis nostrud.
	      </p>
	      <div class="rating">
	      	<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
	      </div>
      </div>
       <div class="swiper-slide bg-white p-4">
        <div class="profile d-flex align-items-center mb-3" >
        	<img src="img/1.jpg" width="30px">
        	<h6 class="m-0 ms-2">Random user1</h6>
        </div>
        <p>
	        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	        quis nostrud.
	      </p>
	      <div class="rating">
	      	<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
	      </div>
      </div>
       <div class="swiper-slide bg-white p-4">
        <div class="profile d-flex align-items-center mb-3" >
        	<img src="img/1.jpg" width="30px">
        	<h6 class="m-0 ms-2">Random user1</h6>
        </div>
        <p>
	        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	        quis nostrud.
	      </p>
	      <div class="rating">
	      	<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
	      </div>
      </div>
       <div class="swiper-slide bg-white p-4">
        <div class="profile d-flex align-items-center mb-3" >
        	<img src="img/1.jpg" width="30px">
        	<h6 class="m-0 ms-2">Random user1</h6>
        </div>
        <p>
	        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	        quis nostrud.
	      </p>
	      <div class="rating">
	      	<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
	      </div>
      </div>
       <div class="swiper-slide bg-white p-4">
        <div class="profile d-flex align-items-center mb-3" >
        	<img src="img/1.jpg" width="30px">
        	<h6 class="m-0 ms-2">Random user1</h6>
        </div>
        <p>
	        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	        quis nostrud.
	      </p>
	      <div class="rating">
	      	<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
	      </div>
      </div>
       <div class="swiper-slide bg-white p-4">
        <div class="profile d-flex align-items-center mb-3" >
        	<img src="img/1.jpg" width="30px">
        	<h6 class="m-0 ms-2">Random user1</h6>
        </div>
        <p>
	        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	        quis nostrud.
	      </p>
	      <div class="rating">
	      	<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
					<i class="bi bi-star-fill text-warning"></i>
	      </div>
      </div>
    </div>
    <div class="swiper-pagination mt-5"></div>
  </div>
  <div class="col-lg-12 text-center mt-5 mb-5">
		<a href="about.php" class="btn btn-outline-dark rounded-0 fw-bold shadow-none">More Info >>></a>
	</div>
</div>


<!-- Reach Us -->

<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">REACH US</h2>
<?php
	$contact_q = "SELECT * FROM `contact_details` WHERE `id`=1";
	$res = $con->query($contact_q);
	$row = mysqli_fetch_assoc($res); 
?>
<div class="container">
	<div class="row">
		<div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
			<iframe class="w-100 rounded" height="320px" src="<?php echo $row['iframe']; ?>"  loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>
		<div class="col-lg-4 col-md-4">
			<div class="bg-white p-4 rounded mb-4">
				<h5>Call Us</h5>
				<a href="tel: +<?php echo $row['pn1']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
					<i class="bi bi-telephone-outbound-fill"></i> +<?php echo $row['pn1']; ?>
				</a>
				<br>
				<a href="tel: +<?php echo $row['pn2']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
					<i class="bi bi-telephone-outbound-fill"></i> +<?php echo $row['pn2']; ?>
				</a>
			</div>
			<div class="bg-white p-4 rounded mb-2">
				<h5>Follow Us</h5>
				<a href="#" class="d-inline-block mb-3 ">
					<span class="badge bg-light text-dark fs-6 p-2">
						<i class="bi bi-twitter me-1"></i> <?php echo $row['tw'];  ?>
					</span>
				</a>
				<br>
				<a href="#" class="d-inline-block mb-3 ">
					<span class="badge bg-light text-dark fs-6 p-2">
						<i class="bi bi-facebook me-1"></i> <?php echo $row['fb'];  ?>
					</span>
				</a>
				<br>
				<a href="#" class="d-inline-block  ">
					<span class="badge bg-light text-dark fs-6 p-2">
						<i class="bi bi-instagram me-1"></i> <?php echo $row['insta'];  ?>
					</span>
				</a>
			</div>
		</div>
	</div>
</div>

<!-- password recovery modal and code -->

<div class="modal fade" id="recoverymodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<form  id="recovery-form" action="" enctype="multipart/form-data">
	      <div class="modal-header">
	        <h5 class="modal-title d-flex align-items-center"><i class="bi bi-shield-lock fs-3 me-2"></i>Set up a new Password</h5>
	        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
					<div class="mb-4">
						<label class="form-label">New Password</label>
						<input type="password" name="pass" class="form-control shadow-none" required>
						<input type="hidden" name="email">
						<input type="hidden" name="token">
					</div>
					<div class="text-end mb-2">
						<button type="button" class="btn text-secondary text-decoration-none shadow-none" data-bs-dismiss="modal">
						cancel
						</button>
						<input type="submit" name="login" class="btn btn-dark shadow-none" value="Reset Password" data-bs-dismiss="modal">
					</div>
	      </div>
      </form>
    </div>
  </div>
</div>

<?php require('inc/footer.php');  ?>

<?php 
if (isset($_GET['account_recovery'])) {
	$t_date = date("Y-m-d");
	$email = $_GET['email'];
	$token = $_GET['token'];

	$query = $con->query("SELECT * FROM `user_register` WHERE `email`='$email' AND `token`='$token' AND `t_expire`='$t_date' LIMIT 1");

	if (mysqli_num_rows($query)==1) {
			echo<<<showmodal
			<script>
				var myModal = document.getElementById('recoverymodal');
				myModal.querySelector("input[name='email']").value = '$email';
				myModal.querySelector("input[name='token']").value = '$token';
				var modal = bootstrap.Modal.getOrCreateInstance(myModal);
				modal.show();
			</script>
			showmodal;

	}else{
		alert('error','Invalid or expired link.!');
	}
}

 ?>

</body>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
	var swiper = new Swiper(".mySwiper", {
	  spaceBetween: 30,
	  effect: "fade",
	  loop: true,
	  autoplay: {
	  	delay: 3500,
	  	disableOnInteraction: false,
	  }
	});


	var swiper = new Swiper(".swiper-testimonial", {

	effect: "coverflow",
	slidesPerView: "3",
	loop: true,
	coverflowEffect: {
	  rotate: 50,
	  stretch: 0,
	  depth: 100,
	  modifier: 1,
	  slideShadows: false,
	},
	pagination: {
	el: '.swiper-pagination',
	clickable: true,
	},
	});

let recovery_form = document.getElementById('recovery-form');

jQuery(document).ready(function () {
    jQuery('#recovery-form').submit(function (event) {
        event.preventDefault();

        var formData = new FormData(this);
        formData.append('recovery_pass',"");    
        jQuery.ajax({
            type: 'POST',
            url: 'ajax/login_register.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
              if (response==1) {
								showAlert('success','Account reset successfully');
							}else{
								showAlert('error','Invalid link !');
							}
            },
            error: function (error) {
               console.log('Error: ' + error);
            }
        });
    });
});
</script>
</html>