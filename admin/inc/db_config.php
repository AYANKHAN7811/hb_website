<?php 

$hname = "localhost";
$uname = "root";
$pass = "";
$db = "hb_website";

$con = mysqli_connect($hname,$uname,$pass,$db);
if (!$con) {
	die("cannot connect to database" . mysqli_connect_error());
}

function filteration($data){
	foreach ($data as $key => $value) {
		$value = trim($value);
		$value = stripslashes($value);
		$value = strip_tags($value);
		$value = htmlspecialchars($value);
		$data[$key] = $value;
	}

	return $data;

}

function update($sql,$values,$datatypes){
	$con = $GLOBALS['con'];
	if ($stmt = mysqli_prepare($con,$sql)) {
		mysqli_stmt_bind_param($stmt,$datatypes,...$values);
		
		if(mysqli_stmt_execute($stmt)){
			$res = mysqli_stmt_affected_rows($stmt);
			mysqli_stmt_close($stmt);
			return $res;
		}else{
			mysqli_stmt_close($stmt);
			die("Query can not be prepared.-update");
		}
	}else{
		die("Query can not be executed.-update");
	}
}



 ?>
