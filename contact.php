<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require('inc/links.php'); ?> 
	<title>TAJ Hotel - CONTACT</title>
</head>
<body class="bg-light ">
<?php
 require('inc/header.php');
$contact_q = "SELECT * FROM `contact_details` WHERE `id`=1";
$res = $con->query($contact_q);
$row = mysqli_fetch_assoc($res); 
?>

<div class="my-5 px-4">
	<h2 class="text-center fw-bold h-font">CONTACT US</h2>
	<div class="h-line bg-dark"></div>
	<p class="text-center mt-3">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod <br>
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim <br> veniam,
		quis nostrud exercitation.
	</p>
</div>

<div class="container">
	<div class="row">
		<div class="col-lg-6 col-md-6 mb-5 px-4">
			<div class="bg-white rounded shadow p-4 ">
				<iframe class="w-100 rounded mb-4" height="320px" src="<?php echo $row['iframe']; ?>"  loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<h5>Address</h5>
						<a href="<?php echo $row['gmap']; ?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
							<i class="bi bi-geo-alt-fill"></i><?php echo $row['address']; ?>
						</a>

						<h5 class="mt-4">Call Us</h5>
						<a href="tel: +<?php echo $row['pn1']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
							<i class="bi bi-telephone-outbound-fill"></i> +<?php echo $row['pn1']; ?>
						</a>
						<br>
						<a href="tel: +<?php echo $row['pn2']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
							<i class="bi bi-telephone-outbound-fill"></i> +<?php echo $row['pn2']; ?>
						</a>
					</div>
					<div class="col-lg-6 col-md-6">
						<h5 class="">Email</h5>
						<a href="mailto: <?php echo $row['email']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
							<i class="bi bi-envelope-fill"></i><?php echo $row['email']; ?>
						</a>

						<h5 class="mt-4">Follow Us</h5>
						<a href="<?php echo $row['tw']; ?>" class="d-inline-block text-dark fs-5 me-2">
							<i class="bi bi-twitter me-1"></i>
						</a>
						<a href="<?php echo $row['fb']; ?>" class="d-inline-block text-dark fs-5 me-2">
							<i class="bi bi-facebook me-1"></i>
						</a>
						<a href="<?php echo $row['insta']; ?>" class="d-inline-block text-dark fs-5">
							<i class="bi bi-instagram me-1"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6  px-4">
			<div class="bg-white rounded shadow p-4 ">
				<form method="POST" >
					<h5>Send message</h5>
					<div class="mt-3">
						<label class="form-label" style="font-weight: 500;">Name</label>
						<input name="name" required type="text" class="form-control shadow-none">
					</div>
					<div class="mt-3">
						<label class="form-label" style="font-weight: 500;">Email</label>
						<input name="email" required type="email" class="form-control shadow-none">
					</div>
					<div class="mt-3">
						<label class="form-label" style="font-weight: 500;">Subject</label>
						<input name="subject" required type="text" class="form-control shadow-none">
					</div>
					<div class="mt-3">
						<label class="form-label" style="font-weight: 500;">Message</label>
						<textarea name="message" required class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
					</div>
					<input type="submit" name="send" class="btn text-white costum-bg mt-3" value="Send">
				</form>
			</div>
		</div>
	</div>
</div>

<?php 

	if (isset($_POST['send'])) {

		$frm_data = filteration($_POST);
		$name = $_POST['name'];
		$email = $_POST['email'];
		$subject = $_POST['subject'];
		$message = $_POST['message'];

		$q = "INSERT INTO `user_contact`(`name`, `email`, `subject`, `message`) VALUES ('$name','$email','$subject','$message')";
		$res = $con->query($q);

		if ($res==1) {
			alert('success','Mail send successfully');
		}else{
			alert('error','Server down! Try again later');

		}

	}


 ?>

<?php require('inc/footer.php');  ?>
</body>
</html>