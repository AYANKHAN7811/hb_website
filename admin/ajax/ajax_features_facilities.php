<?php 
require('../inc/essential.php');
require('../inc/db_config.php');
adminLogin();

if (isset($_POST['add_features'])) {
	$frm_data = filteration($_POST);
	$name = $frm_data['name'];
	$q = "INSERT INTO `features`(`name`) VALUES ('$name')";
	$res = $con->query($q);
	echo $res;
}

if (isset($_POST['get_features'])) {
	$q = "SELECT * FROM `features`";
	$res = $con->query($q);
	$i=1;

	while ($row = mysqli_fetch_assoc($res)) {
	    echo <<<data
	        <tr>
	            <th scope="row">$i</th>
	            <td>{$row['name']}</td>
	            <td><a href='?del={$row['id']}' class='btn btn-sm rounded-pill btn-danger'>Delete</a></td>
	        </tr>
	data;
	    $i++; 
	}
}

if (isset($_POST['get_facilities'])) {
	$q = "SELECT * FROM `facilities`";
	$res = $con->query($q);
	$i=1;

	while ($row = mysqli_fetch_assoc($res)) {
		$path = "images/" . $row['icon'];
	    echo <<<data
	        <tr class="align-middle">
	            <th scope="row">$i</th>
	            <td><img src="{$path}" width="60px"></td>
	            <td>{$row['name']}</td>
	            <td>{$row['description']}</td>
	            <td><a href='?del_facility={$row['id']}' class='btn btn-sm rounded-pill btn-danger'>Delete</a></td>
	        </tr>
	data;
	    $i++; 

	}

}

if(isset($_POST['submit'])){
    $facility_name = htmlentities(mysqli_real_escape_string($con, $_POST['facility_name']));
    $faiclity_desc = mysqli_real_escape_string($con, $_POST['faiclity_desc']);
    $facility_icon = $_FILES['facility_icon'];
    $img_name = $_FILES['facility_icon']['name'];
    $img_size = $_FILES['facility_icon']['size'];
    $tmp_dir = $_FILES['facility_icon']['tmp_name'];
    $img_typ = $_FILES['facility_icon']['type'];
    if($img_typ == "image/jpeg" || $img_typ == "image/png" || $img_typ == "image/jpg" || $img_typ == "image/svg" || $img_typ == "image/webp" || $img_typ == "image/htm"){
        if($img_size <= 2097152){
            move_uploaded_file($tmp_dir,"../images/".$img_name);
            $sql = "INSERT INTO `facilities`(`icon`, `name`, `description`) VALUES ('$img_name','$facility_name','$faiclity_desc')";
            $res = $con->query($sql);
            if($res){
                $_SESSION['message'] = "<div>Facility Added Succefully</div>";
                header("Location: ../features_facilities.php");
            }
            else{      
                $_SESSION['message'] = "<div>Sorry! something went wrong</div>";
                header("Location: ../features_facilities.php"); 
            }
        }else{
             $_SESSION['message'] = "<div>Image size should be less than 2MB</div>";
                header("Location: ../features_facilities.php");
        }
    }else{
         $_SESSION['message'] = "<div>Image format not supported.</div>";
                header("Location: ../features_facilities.php");
    }
}


// if (isset($_POST['upd_contacts'])) {

// 	$frm_data = filteration($_POST);

// 	$q = "UPDATE `contact_details` SET `address`=?,`gmap`=?,`pn1`=?,`pn2`=?,`email`=?,`fb`=?,`insta`=?,`tw`=?,`iframe`=? WHERE `id`=1";
// 	$values = [$frm_data['address'],$frm_data['gmap'],$frm_data['pn1'],$frm_data['pn2'],$frm_data['email'],$frm_data['fb'],$frm_data['insta'],$frm_data['tw'],$frm_data['iframe']];
// 	$res = update($q,$values,"sssssssss");
// 	echo $res;

// }



 ?>
