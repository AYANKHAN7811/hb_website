<?php 
require '../admin/inc/db_config.php';
require '../admin/inc/essential.php';
date_default_timezone_set("Asia/Kolkata");


if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($_FILES['image']) ) {

    $email = $_POST['email'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $pin = $_POST['pin'];
    $dob = $_POST['dob'];
    $pass = md5($_POST['pass']);
    $con_pass = md5($_POST['con_pass']);
    $pic = $_FILES['image'];
    $img_name = $_FILES['image']['name'];
    $img_size = $_FILES['image']['size'];
    $tmp_dir = $_FILES['image']['tmp_name'];
    $img_typ = $_FILES['image']['type'];

    if ($pass != $con_pass) {
    	echo "Password dose not match";
    	exit();
    }

	$user_exist = $con->query("SELECT * FROM `user_register` WHERE `email`='$email' OR `number`='$number' LIMIT 1");
	if (mysqli_num_rows($user_exist)!=0) {
		$user_exist_fetch = mysqli_fetch_assoc($user_exist);
		echo ($user_exist_fetch['email']==$email)? "email already exists" : "phone number already used";
        exit();
	}

    if($img_typ == "image/jpeg" || $img_typ == "image/png" || $img_typ == "image/jpg" || $img_typ == "image/svg" || $img_typ == "image/webp" || $img_typ == "image/htm"){
        if($img_size <= 2097152){
            move_uploaded_file($tmp_dir,"../img/".$img_name);
            $query = "INSERT INTO `user_register`(`name`, `email`, `address`, `number`, `pincode`, `dob`, `profile`, `password`,`token`) VALUES ('$name','$email','$address','$number','$pin','$dob','$img_name','$pass','$token')";
            $res = $con->query($query);
            if($res){   
                echo 1;
            }
            else{      
                echo "insert failed"; 
                exit;
            }
        }else{
             echo "large img";
             exit();
        }
    }else{
         echo "formate not supported";
         exit();
    } 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($_POST['login']) ) {
    $emailNum = $_POST['email_num'];
    $password = md5($_POST['password']);

    $query = $con->query("SELECT * FROM `user_register` WHERE `email`='$emailNum' OR `number`='$emailNum' LIMIT 1");
    if (mysqli_num_rows($query)==0) {
        echo "inv_email_mob";
    }else{
        $u_fetch = mysqli_fetch_assoc($query);
        if ($u_fetch['is_varified']==0) {
            echo "not_verified";
        }else if($u_fetch['status']==0) {
            echo "Inactive";
        }else{
            if ($password !== $u_fetch['password']) {
                echo "invalid_pass";
            } else{
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['uid'] = $u_fetch['id'];
                $_SESSION['uname'] = $u_fetch['name'];
                $_SESSION['upic'] = $u_fetch['profile'];
                $_SESSION['uphone'] = $u_fetch['number'];
                $_SESSION['e-mail'] = $u_fetch['email'];
                echo 1;
            }
        }
    }
    die();
}