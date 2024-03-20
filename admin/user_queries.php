<?php 
require('inc/essential.php');
require('inc/db_config.php');
require('inc/links.php');
adminLogin();

if (isset($_GET['seen'])) {
	$frm_data = filteration($_GET);

	if ($frm_data['seen']=='all') {
		$query = "UPDATE `user_contact` SET `seen`=1";
		$result = $con->query($query);

		if ($result) {
			alert('success','Mark all as read!');
		}else{
			alert('Danger','Operation failed!');

		}
	}else{
		$query = "UPDATE `user_contact` SET `seen`=1 WHERE `id`=$frm_data[seen]";
		$result = $con->query($query);

		if ($result) {
			alert('success','Mark as read!');
		}else{
			alert('Danger','Operation failed!');

		}

	}
}
if (isset($_GET['del'])) {
	$frm_data = filteration($_GET);

	if ($frm_data['del']=='all') {
		$query = "DELETE FROM `user_contact`";
		$result = $con->query($query);

		if ($result) {
			alert('success','All Data deleted!');
		}else{
			alert('Danger','Operation failed!');

		}
	}else{
		$query = "DELETE FROM `user_contact` WHERE `id`=$frm_data[del]";
		$result = $con->query($query);

		if ($result) {
			alert('success','Data deleted!');
		}else{
			alert('Danger','Operation failed!');

		}

	}
}
 ?>
 <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User queries</title>
	<?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
<?php require 'inc/header.php'; ?>

<div class="container-fluid" id="main-content">
	<div class="row">
		<div class="col-lg-10 ms-auto p-4 overflow-hidden ">
			<h3 class="mb-4">User Contacts</h3>

			<div class="card border-0 shadow-sm" >
				<div class="card-body">
					<div class="text-end mb-4">
						<a href="?seen=all" class="btn btn-dark shadow-none rounded-pill text-white"><i class="bi bi-check2-all"></i> Mark all read</a>
						<a href="?del=all" class="btn btn-danger shadow-none rounded-pill text-white"><i class="bi bi-trash3-fill"></i> Delete all</a>
					</div>
				  	<div class="table-responsive-md longEnough " style="height:450px; overflow-y:scroll;">
				  		<table class="table table-hover border">
						  	<thead class="sticky-top">
							    <tr class="bg-dark text-white">
							      <th scope="col">Id</th>
							      <th scope="col">Name</th>
							      <th scope="col">Email</th>
							      <th scope="col">Subject</th>
							      <th scope="col">Message</th>
							      <th scope="col">Date</th>
							      <th scope="col">Action</th>
							    </tr>
						  	</thead>
						  	<tbody>
						  		<?php 
						  			$q = "SELECT * FROM `user_contact` ORDER BY `id` DESC";
						  			$res = $con->query($q);
						  			$i = 1;

						  			while ($row=mysqli_fetch_assoc($res)) {
						  				$seen = "";
						  				if ($row['seen']!=1) {
						  					$seen = "<a href='?seen=$row[id]' class='btn btn-sm rounded-pill btn-success'>Mark as read</a>";
						  				}
						  				$seen .="<a href='?del=$row[id]' class='btn btn-sm rounded-pill btn-danger'>Delete</a>";
						  		?>		
						  				<tr>
							      			<th scope="row"><?php echo $i; ?></th>
							      			<td><?php echo $row['name']; ?></td>
							      			<td><?php echo $row['email']; ?></td>
							      			<td><?php echo $row['subject']; ?></td>
							      			<td><?php echo $row['message']; ?></td>
							      			<td><?php echo $row['date']; ?></td>
							      			<td><?php echo $seen; ?></td>
							      		</tr>	
							    <?php
							    	$i++;		
						  			}
						  		 ?>
						  </tbody>
						</table>
				  	</div>
			  	</div>
			</div>

		</div>
	</div>	
</div>
<?php require('inc/script.php'); ?>
</body>
</html>