<?php 
if(!isset($_GET['id'])){
	header('Location: rooms.php');
	die();
}
$id = $_GET['id'];

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require('inc/links.php'); ?> 
	<title>TAJ Hotel - ROOMS</title>
</head>
<body class="bg-light ">
<?php 
	require('inc/header.php'); 
	$room_res = $con->query("SELECT * FROM `rooms` WHERE `id`='$id' AND `status`=1 AND `removed`=0 ");
	$room_data = mysqli_fetch_assoc($room_res);

?>

<div class="container">
	<div class="row">

		<div class="col-12 my-5 mb-4 px-4">
			<h2 class="fw-bold "><?php echo $room_data['name']; ?></h2>
			<div style="font-size: 14px;">
				<a href="index.php" class="text-secondary text-decoration-none">HOME</a>
				<span class="text-secondary "> / </span>
				<a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
			</div>
		</div>
	
		<div class="col-lg-7 col-md-12 px-4 ">
			<div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
				<div class="carousel-inner">
					<?php 
						$img_q = $con->query("SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]'");
						$get_thumb = '';
						if (mysqli_num_rows($img_q)>0) {
							$active_class = "active";
							while ($img_res = mysqli_fetch_assoc($img_q)) {
								$get_thumb = "img/".$img_res['image'];

								echo "<div class='carousel-item $active_class'>
								  	<img src='$get_thumb' class='d-block w-100 rounded' style=''>
								</div>";
								$active_class='';
							}
						}else{
							$get_thumb = "img/de.png";
							echo "<div class='carousel-item active'>
								  	<img src='$get_thumb' class='d-block w-100 rounded'>
								</div>";
						}
			 		?>
				</div>
				<button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
				</button>
			</div>
		</div>

		<div class="col-lg-5 col-md-12 px-4">
			<div class="card mb-4 border-0 shadow-sm rounded-3 bg-white">
				<div class="card-body">
					<h4>$<?php echo $room_data['price']; ?> per night</h4>
					<div class="rating mb-2">
				      	<i class="bi bi-star-fill text-warning"></i>
						<i class="bi bi-star-fill text-warning"></i>
						<i class="bi bi-star-fill text-warning"></i>
						<i class="bi bi-star-fill text-warning"></i>
				     </div>
				     <?php 
						$fea_q = $con->query("SELECT f.name FROM `features` f
								INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
								WHERE rfea.room_id = '$room_data[id]'");
						$features_data = "";

						while ($features_row = mysqli_fetch_assoc($fea_q)) {
						$features_data .= "<span class='badge rounded-pill bg-light text-dark mb-1 text-wrap me-1 mb-1'>
							$features_row[name]
							</span>";

						}

						$fac_q = $con->query("SELECT f.name FROM `facilities` f
								INNER JOIN `room_facilities` rfac ON f.id = rfac.facility_id
								WHERE rfac.room_id = '$room_data[id]'");
						$facilities_data = "";
						while ($facility_row = mysqli_fetch_assoc($fac_q)) {
						$facilities_data .= "<span class='badge rounded-pill bg-light text-dark mb-1 text-wrap me-1 mb-1'>
								$facility_row[name]
								</span>";

						}
				      ?>
				     <div class="features mb-2">
						<h6 class="mb-1">Features</h6>
						<?php echo $features_data; ?>
					</div>
					<div class="facilities mb-2">
						<h6 class="mb-1">Facilities</h6>
						<?php echo $facilities_data; ?>
					</div>
					<div class=" mb-2">
						<h6 class="mb-1">Guest</h6>
						<span class="badge rounded-pill bg-light text-dark mb-1 text-wrap ">
							<?php echo $room_data['adult'] ?> Adult
						</span>
						<span class="badge rounded-pill bg-light text-dark mb-1 text-wrap ">
							<?php echo $room_data['children'] ?> Childern
						</span>
					</div>
					<div class=" mb-2">
						<h6 class="mb-1">Area</h6>
						<span class="badge rounded-pill bg-light text-dark mb-1 text-wrap ">
							<?php echo $room_data['area'] ?> .sq .ft
						</span>
					</div>
					<div class="mb-2">
					<?php 
					 	$book_btn = "";
						if (!$title_row['shutdown']==1) {
							$login = 0;
							if (isset($_SESSION['login']) && $_SESSION['login']==true) {
								$login = 1;
							}
							$book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn w-100 text-white costum-bg shadow-none me-2 mb-1'>Book Now</button>";
						}
						echo $book_btn;
					?>
						
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 mt-4 px-4 ">
			<div class="mb-5">
				<h4>Description</h4>
				<p><?php echo $room_data['description'] ?></p>
			</div>
			<div>
				<h4 class="mb-3">Reviews & Ratings</h4>
				<div class="d-flex align-items-center mb-2" >
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

	</div>
</div>

<?php require('inc/footer.php');  ?>
</body>
</html>