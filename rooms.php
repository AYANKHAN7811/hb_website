<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require('inc/links.php'); ?> 
	<title>TAJ Hotel - ROOMS</title>
</head>
<body class="bg-light ">
<?php require('inc/header.php'); ?>

<div class="my-5 px-4">
	<h2 class="text-center fw-bold h-font">OUR ROOMS</h2>
	<div class="h-line bg-dark"></div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
			<nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
			  <div class="container-fluid flex-lg-column align-items-stretch">
			    <h4 class="mt-2">FILTERS </h4>
			    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			      <span class="navbar-toggler-icon"></span>
			    </button>
			    <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
			     	<div class="border bg-light p-3 rounded mb-3">
			     		<h5 class="mb-3" style="font-size: 18px;">CHECK AVAILABILITY</h5>
			     		<label class="form-label" >Check-in</label>
						<input type="date" class="form-control shadow-none">

			     		<label class="form-label mt-3" >Check-out</label>
						<input type="date" class="form-control shadow-none">
			     	</div>
			     	<div class="border bg-light p-3 rounded mb-3">
			     		<h5 class="mb-3" style="font-size: 18px;">FACILITIES</h5>
			     		<div class="mb-2">
							<input type="checkbox" id="f1" class="form-check-input shadow-none me-1">
				     		<label class="form-check-label" for="f1">Facility one</label>
			     		</div>
			     		<div class="mb-2">
							<input type="checkbox" id="f2" class="form-check-input shadow-none me-1">
				     		<label class="form-check-label" for="f2">Facility two</label>
			     		</div>
			     		<div class="mb-2">
							<input type="checkbox" id="f3" class="form-check-input shadow-none me-1">
				     		<label class="form-check-label" for="f3">Facility three</label>
			     		</div>
			     	</div>
			     	<div class="border bg-light p-3 rounded mb-3">
			     		<h5 class="mb-3" style="font-size: 18px;">GUESTS</h5>
			     		<div class="d-flex">
			     			<div class="me-2">
				     			<label class="form-label mt-3" >Adults</label>
								<input type="number" class="form-control shadow-none">
			     			</div>
				     		<div>
				     			<label class="form-label mt-3" >Children</label>
								<input type="number" class="form-control shadow-none">
				     		</div>
			     		</div>
			     	</div>
			    </div>
			  </div>
			</nav>
		</div>
		<div class="col-lg-9 col-md-12 px-4">
			<?php 
			$room_res = $con->query("SELECT * FROM `rooms` WHERE `status`=1 AND `removed`=0 ORDER BY `id` DESC");

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
			<div class="card mb-4 border-0 shadow">
			  <div class="row g-0 p-3 align-items-center">
			    <div class="col-md-5 mb-lg-0 mb-md-0 mb-3 ">
			      <img src="<?php echo $get_thumb ?>" style="width: 362px; height: 201px;"  class="img-fluid rounded w-md-100">
			    </div>
			    <div class="col-md-5 px-lg-3 px-md-3 px-0">
			      <h5 class=""><?php echo $room_data['name']; ?></h5>
			      	<div class="features mb-3">
						<h6 class="mb-1">Features</h6>
						<?php echo $features_data; ?>
					</div>
					<div class="facilities mb-3">
						<h6 class="mb-1">Facilities</h6>
						<?php echo $facilities_data; ?>
					</div>
					<div class="guest mb-3">
						<h6 class="mb-1">Guest</h6>
						<span class="badge rounded-pill bg-light text-dark mb-1 text-wrap ">
							<?php echo $room_data['adult'] ?> Adult
						</span>
						<span class="badge rounded-pill bg-light text-dark mb-1 text-wrap ">
							<?php echo $room_data['children'] ?> Childern
						</span>
					</div>
			    </div>
			    <div class="col-md-2 text-center">
					<h6 class="mb-3"><?php echo $room_data['price'] ?>₹ per night</h6>
					<?php 
					 	$book_btn = "";
						if (!$title_row['shutdown']==1) {
							$login = 0;
							if (isset($_SESSION['login']) && $_SESSION['login']==true) {
								$login = 1;
							}
							$book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm w-100 text-white costum-bg shadow-none me-2 mb-2'>Book Now</button>";
						}
						echo $book_btn;
					 ?>
					
					<a href="room_details.php?id=<?php echo $room_data['id'] ?>" class="btn btn-sm w-100 btn-outline-dark shadow-none">More Detail</a>
			    </div>
			  </div>
			</div>
			<?php
			}
			?>
			
		</div>

	</div>
</div>

<?php require('inc/footer.php');  ?>

</body>
</html>