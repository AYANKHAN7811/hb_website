<?php 
// check room id from url is present or not
// shutdown mode is active or not
// user is logged in or not

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php 
		require('inc/links.php'); 
		if(!isset($_GET['id']) || $title_row['shutdown']==1 ){
			header('Location: rooms.php');
			die();
		}else if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
			header('Location: rooms.php');
			die();
		}

		$id = $_GET['id'];

		// filter and get user and room data
	?> 
	<title>TAJ Hotel -  Confirm bookings</title>
</head>
<body class="bg-light ">
<?php 
	require('inc/header.php'); 

	$room_res = $con->query("SELECT * FROM `rooms` WHERE `id`='$id' AND `status`=1 AND `removed`=0 ");
	if (mysqli_num_rows($room_res)==0) {
		header('Location: rooms.php');
		die();
	}
	$room_data = mysqli_fetch_assoc($room_res);
	$_SESSION['room'] = [
	   "id" => $room_data['id'],
	   "name" => $room_data['name'],
	   "price" => $room_data['price'],
	   "payment" => null,
	  "available" => false,
	];
	
	$user_res = $con->query("SELECT * FROM `user_register` WHERE `id`='$_SESSION[uid]' LIMIT 1");
	$user_data = mysqli_fetch_assoc($user_res);

?>

<div class="container">
	<div class="row">

		<div class="col-12 my-5 mb-4 px-4">
			<h2 class="fw-bold ">CONFIRM BOOKING</h2>
			<div style="font-size: 14px;">
				<a href="index.php" class="text-secondary text-decoration-none">HOME</a>
				<span class="text-secondary "> / </span>
				<a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
				<span class="text-secondary "> / </span>
				<a href="rooms.php" class="text-secondary text-decoration-none">CONFIRM</a>
			</div>
		</div>
	
		<div class="col-lg-7 col-md-12 px-4 ">
			<?php 
				$thumb_q = $con->query("SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]' AND `thumbnail`='1'");
				$get_thumb = '';
				if (mysqli_num_rows($thumb_q)) {
					$thumb_row = mysqli_fetch_assoc($thumb_q);
					$get_thumb = "img/".$thumb_row['image'];
				}else{
					$get_thumb = "img/de.png";
				}
			 ?>
			 <div class="card p-3 shadow-sm rounded ">
			 	<img src="<?php echo $get_thumb ?>" style="height: 276px;" class="img-fluid rounded w-md-100 mb-3">
			 	<h5><?php echo $room_data['name'] ?></h5>
			 	<h6><?php echo "₹" . $room_data['price'] ?></h6>
			 </div>
		</div>

		<div class="col-lg-5 col-md-12 px-4">
			<div class="card mb-4 border-0 shadow-sm rounded-3 bg-white">
				<div class="card-body">
					<form action="" id="booking_form">
						<h6 class="mb-3">BOOKING DETAILS</h6>
						<div class="row">
							<div class="col-md-6 mb-3">
								<label class="form-label ">Name</label>
								<input type="text" name="name" value="<?php echo $user_data['name'] ?>" class="form-control shadow-none" required>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label ">Phone number</label>
								<input type="number" name="number" value="<?php echo $user_data['number'] ?>" class="form-control shadow-none" required>
							</div>
							<div class="col-md-12 mb-3">
								<label class="form-label ">Address</label>
								<textarea class="form-control shadow-none" name="address" rows="1" required><?php echo $user_data['address'] ?></textarea>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label ">Check-in</label>
								<input type="date" onchange="check_availability()" name="checkin"  class="form-control shadow-none" required>
							</div>
							<div class="col-md-6 mb-4">
								<label class="form-label ">Check-out</label>
								<input type="date" onchange="check_availability()" name="checkout"  class="form-control shadow-none" required>
							</div>
							<div class="col-12">
								<div class="spinner-border text-dark mb-3 d-none" id="info_loader" role="status">
									<span class="visually-hidden">Loading...</span>
								</div>
								<h6 class="mb-3 text-danger" id="pay_info">Provide check-in & check-out date !</h6>
								<button type="button" disabled name="pay_now" class="btn w-100 text-white bg-dark  mb-1" >PAY NOW</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require('inc/footer.php');  ?>

<script>

let booking_form = document.getElementById('booking_form');
let info_loader = document.getElementById('info_loader');
let pay_info = document.getElementById('pay_info');

function check_availability(){
	let checkin_val = booking_form.elements['checkin'].value;
	let checkout_val = booking_form.elements['checkout'].value;
	booking_form.elements['pay_now'].setAttribute('disabled',true);

	if (checkin_val != "" && checkout_val != "") {

		pay_info.classList.add('d-none');
		pay_info.classList.replace('text-dark','text-danger');
		info_loader.classList.remove('d-none');

		let data = new FormData();

		data.append('check_availability','');
		data.append('check_in',checkin_val);
		data.append('check_out',checkout_val);

		let xhr = new XMLHttpRequest();
		xhr.open("POST","ajax/ajax_confirm_booking.php",true);

		xhr.onload = function(){
			let data = JSON.parse(this.responseText);

			if (data.status == "check_in_out_equal") {
				pay_info.innerText = "you can not check out on same day !";
			}else if (data.status == "check_out_earlier") {
				pay_info.innerText = "check out date is earlier than check in date !";
			}else if (data.status == "check_in_earlier") {
				pay_info.innerText = "check in date is earlier than today's date !";
			}else if (data.status == "unavailable") {
				pay_info.innerText = "Room not available for this check in date !";
			}else{
				pay_info.innerText = "No. of days: " + data.days + "\nTotal amount to pay: ₹" + data.payment;


				pay_info.classList.replace('text-danger','text-dark');
				booking_form.elements['pay_now'].removeAttribute('disabled');
			}
			pay_info.classList.remove('d-none');
			info_loader.classList.add('d-none');
		}
		xhr.send(data);

	}

}
</script>
</body>
</html>