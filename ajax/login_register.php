<?php 
require '../admin/inc/db_config.php';
require '../admin/inc/essential.php';
require("../inc/sendgrid/sendgrid-php.php");
date_default_timezone_set("Asia/Kolkata");

function send_mail($uemail,$token,$type){

    if ($type == "email_confirmation") {
        $page = "email_confirm.php";
        $subject = "Account Varification Link";
        $content = "confirm your email";
    }else{
        $page = "index.php";
        $subject = "Account Reset Link";
        $content = "Reser your account";
    }


	$email = new \SendGrid\Mail\Mail(); 
	$email->setFrom(SITE_MAIL, SITE_NAME);
	$email->setSubject($subject);
	$email->addTo($uemail);
	$email->addContent(
	    "text/html",
	     "Click the link to $content: <br>
	     <a href='".SITE_URL."$page?$type&email=$uemail&token=$token"."'>CLICK ME</a>
	     "
	);
	$sendgrid = new \SendGrid(SENDGRID_API_KEY);

    try{
        $sendgrid->send($email);
    	return 1;
    }
    catch (Exception $e){
    	return 0;
    }
}

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

    $token = bin2hex(random_bytes(16));
    if(!send_mail($email,$token,"email_confirmation")){
    	echo "mail failed";
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
                echo 1;
                die();
            }
        }
    }
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($_POST['forgot_pass']) ) {
    $email = $_POST['email'];

    $query = $con->query("SELECT * FROM `user_register` WHERE `email`='$email' LIMIT 1");
    if (mysqli_num_rows($query)==0) {
        echo "inv_email";
    }else{
        $u_fetch = mysqli_fetch_assoc($query);
        if ($u_fetch['is_varified']==0) {
            echo "not_verified";
        }else if($u_fetch['status']==0) {
            echo "Inactive";
        }else{
            $token = bin2hex(random_bytes(16));
            if(!send_mail($email,$token,"account_recovery")){
                echo "mail failed";
            }else{
                $date = date("Y-m-d");
                $q = $con->query("UPDATE `user_register` SET `token`='$token',`t_expire`='$date' WHERE `id`='$u_fetch[id]'");
                if ($q) {
                    echo 1;
                }else{
                    echo "upd_failed";
                }
            }
        }
    } 
die();       
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($_POST['recovery_pass']) ) {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $pass = md5($_POST['pass']);

    $q = $con->query("UPDATE `user_register` SET `password`='$pass',`token`=null,`t_expire`=null WHERE `email`='$email' AND `token`='$token'");
    if ($q) {
        echo 1;
    }else{
        echo "failed";
    }
}
?>