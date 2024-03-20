<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require('inc/links.php'); ?>
	<title>TAJ Hotel - FACILITIES</title>
	<style type="">
		.pop:hover{
			border-top-color: var(--teal) !important;
			transform: scale(1.03);
			transition: all 0.3s;
		}
	</style>
</head>
<body class="bg-light ">
	<?php require('inc/header.php'); ?>

	<div class="my-5 px-4">
		<h2 class="text-center fw-bold h-font">OUR FACILITIES</h2>
		<div class="h-line bg-dark"></div>
		<p class="text-center mt-3">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod <br>
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim <br> veniam,
			quis nostrud exercitation.
		</p>
	</div>

	<div class="container">
		<div class="row">
			<?php 
			$res = $con->query("SELECT * FROM `facilities`");
			while ($row=mysqli_fetch_assoc($res)) {
			 ?>
			<div class="col-lg-4 col-md-6 mb-5 px-4">
				<div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
					<div class="d-flex align-items-center mb-2">
						<img src="admin/images/<?php echo $row['icon']; ?>" width="50px">
						<h5 class="m-4 ms-2"><?php echo $row['name']; ?></h5>
					</div>
					<p><?php echo $row['description']; ?></p>
				</div>
			</div>

			 <?php  } ?>
		</div>
	</div>

<?php require('inc/footer.php');  ?>

</body>
</html>