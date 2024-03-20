<?php 
require('inc/db_config.php');
require('inc/essential.php');

session_start();
if ((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
	header('Location: dashboard.php');
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Login Panel</title>
	<?php require('inc/links.php'); ?>
	<style>
		div.login-form{
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%,-50%);
			width: 400px;
		}
	</style>
</head>
<body class="bg-light">
<div class="login-form text-center bg-white rounded shadow overflow-hidden">
	<form method="POST">
		<h4 class="bg-dark text-white py-3">ADMIN LOGIN PANEL</h4>
		<div class="p-4">
			<div class="mb-3">
				<input name="admin_name" required type="text" class="form-control shadow-none text-center" placeholder="Admin Name">
			</div>
			<div class="mb-4">
				<input name="admin_pass" required type="password" class="form-control shadow-none text-center" placeholder="Password">
			</div>
			<button name="login" class="btn text-white costum-bg shadow-none">LOGIN</button>
		</div>
	</form>
</div>


<?php 

if (isset($_POST['login'])) {
	$name = $_POST['admin_name'];
	$password = $_POST['admin_pass'];
	$frm_data = filteration($_POST);

	$sql = "SELECT * FROM admin_cred WHERE admin_name = '$name' AND admin_pass = '$password'";
	$res = mysqli_query($con,$sql);

	if ($res->num_rows==1) {
		$row = mysqli_fetch_assoc($res);
		$_SESSION['adminLogin'] = true;
		$_SESSION['adminId'] = $row['sr_no'];
		header('Location: dashboard.php');
	}else{
		alert('error','login failed - invalid credentials');
	}
}

 ?>

<?php require('inc/script.php'); ?>
</body>
</html>