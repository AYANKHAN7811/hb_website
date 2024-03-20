<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link rel="stylesheet" type="text/css" href="css/common.css">

<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");

require 'admin/inc/db_config.php';
require 'admin/inc/essential.php';

$title = $con->query("SELECT * FROM `settings`");
$title_row = mysqli_fetch_assoc($title);

if ($title_row['shutdown']==1) {
	echo<<<alertbar
		 <div class="bg-danger text-center p-2 fw-bold">
		 	<i class="bi bi-exclamation-triangle-fill"></i>
		 	Booking are temporarily closed. !
		 </div>
	alertbar;
}
 ?>
