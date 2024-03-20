<?php 
require 'admin/inc/db_config.php';
require 'admin/inc/essential.php';

if (isset($_GET['email_confirmation'])) {
    $data = filteration($_GET);
    $query = $con->prepare("SELECT * FROM `user_register` WHERE `email`=? AND `token`=? LIMIT 1");
    $query->bind_param("ss", $data['email'], $data['token']);
    $query->execute();

    $result = $query->get_result();

	if ($result->num_rows == 1) {
	    $fetch = $result->fetch_assoc();

	    if ($fetch['is_varified'] == 1) {
	        echo "<script> alert('Email Already Verified!') </script>";
	    }else {
	        $update = $con->prepare("UPDATE `user_register` SET `is_varified`=1 WHERE `id`=?");
	        $update->bind_param("i", $fetch['id']);

	        if ($update->execute()) {
	            echo "<script> alert('Email Verification Successful!') </script>";
	        } else {
	            echo "<script> alert('Email Verification Failed! Server down!') </script>";
	        }
	    }

	    echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 1000); // Delay in milliseconds (1 seconds in this example)
            </script>";
            exit();
	} else {
	    echo "<script> alert('Invalid Link!')</script>";
	}

}

 ?>