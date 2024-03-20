<?php 
require('../inc/essential.php');
require('../inc/db_config.php');
adminLogin();

if(isset($_POST['submit'])){
    $features = $_POST['features'];
    $facilities = $_POST['facilities'];

    $name = $_POST['name'];
    $area = $_POST['area'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $adult = $_POST['adult'];
    $children = $_POST['children'];
    $desc = $_POST['desc'];

    // Create a prepared statement for inserting room data
    $q = "INSERT INTO `rooms`(`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $con->prepare($q)) {
        $stmt->bind_param('sssssss', $name, $area, $price, $quantity, $adult, $children, $desc);
        $stmt->execute();
        $stmt->close();

        $room_id = mysqli_insert_id($con);

        // Insert room facilities
        $q2 = "INSERT INTO `room_facilities`(`room_id`, `facility_id`) VALUES (?, ?)";
        if ($stmt = $con->prepare($q2)) {
            foreach ($facilities as $f) {
                $stmt->bind_param('ii', $room_id, $f);
                $stmt->execute();
            }
            $stmt->close();
        } else {
            $flag = 0;
            die('Query can not be prepared - room facilities insert');
        }

        // Insert room features
        $q3 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?, ?)";
        if ($stmt = $con->prepare($q3)) {
            foreach ($features as $f) {
                $stmt->bind_param('ii', $room_id, $f);
                $stmt->execute();
            }
            $stmt->close();
        } else {
            $flag = 0;
            die('Query can not be prepared - room features insert');
        }

        $flag = 1;
    } else {
        $flag = 0;
        die('Query can not be prepared - room insert');
    }

    $_SESSION['message'] = "<div> New Room Added Succefully</div>";
    header("Location: ../rooms.php");

}

if (isset($_POST['get_all_rooms'])){
	$q = "SELECT * FROM `rooms` WHERE `removed`=0";
	$res = $con->query($q);

	$i = 1;

	while ($row = mysqli_fetch_assoc($res)) {
		if ($row['status']==1) {
			$status = "<button onclick='toggleStatus($row[id],0)' class='btn btn-dark btn-sm shadow-none'>Active</button>";
		}else{
			$status = "<button onclick='toggleStatus($row[id],1)' class='btn btn-warning btn-sm shadow-none'>Inactive</button>";
		}?>
            <tr>
                <th><?php echo $i; ?></th>   
                <td><?php echo $row['name'];?></td>
                <td><?php echo $row['area'];?>sq. ft.</td>
                <td>
                    <span class='badge rounded-pill bg-light text-dark'>
                        Adult: <?php echo $row['adult'];  ?>
                    </span><br>
                    <span class='badge rounded-pill bg-light text-dark'>
                        Children: <?php echo $row['children'];  ?>
                    </span>    
                </td>
                <td>₹ <?php echo $row['price']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $status;  ?></td>
                <td id='showModal'>
                    <button type='button'  onclick="send_id(<?php echo $row['id']; ?>)"  class='btn btn-primary shadow-none btn-sm edit-room-button' data-bs-toggle='modal' data-bs-target='#edit-room' data-room-id='<?php echo $row['id']; ?>'>
                        <i class='bi bi-pencil-square'></i> 
                    </button>
                    <button type='button' onclick="room_images(<?php echo $row['id']; ?>,'<?php echo $row["name"]; ?>')" class='btn btn-info shadow-none btn-sm edit-room-button' data-bs-toggle='modal' data-bs-target='#add_img'>
                    <i class='bi bi-images'></i> 
                    </button>
                    <button type='button' onclick="room_id(<?php echo $row['id']; ?>)" class='btn btn-danger shadow-none btn-sm edit-room-button' >
                    <i class='bi bi-trash3'></i> 
                    </button>

                </td>
            </tr>
            <?php            
	    $i++;
	}
    die();
}


if (isset($_POST['toggleStatus'])){
    $frm_data = filteration($_POST);
    $q = "UPDATE `rooms` SET `status`='$frm_data[value]' WHERE `id`=$frm_data[toggleStatus]";
    $res = $con->query($q);
    if ($res) {
        echo 1;
    }else{
        echo 0;
    }
}

if (isset($_POST['send_id'])){
    $roomid = $_POST['send_id'];
    $q1 =  "SELECT * FROM `rooms` where `id` = '$roomid'";
    $res1 = $con->query($q1);
    if ($row1=mysqli_fetch_assoc($res1)) { ?>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Name</label>
                <input type="text" name="name" value="<?php echo $row1['name']; ?>" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Area</label>
                <input type="number" min="1" name="area" value="<?php echo $row1['area']; ?>" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Price</label>
                <input type="number" min="1" name="price" value="<?php echo $row1['price']; ?>" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Quantity</label>
                <input type="number" min="1" name="quantity" value="<?php echo $row1['quantity']; ?>" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Adult (Max.)</label>
                <input type="number" min="1" name="adult" value="<?php echo $row1['adult']; ?>" class="form-control shadow-none" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Children (Max.)</label>
                <input type="number" min="1"  name="children" value="<?php echo $row1['children']; ?>" class="form-control shadow-none" required>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold">Features</label>
                <div class="row">
                    <?php 
                    $selected_features = [];
                    $features = "SELECT * FROM `room_features` where room_id = '$roomid'";
                    $res2 = $con->query($features);
                    while ($row2=mysqli_fetch_assoc($res2)) {
                        $selected_features[] = $row2['features_id'];
                    }
                    $q = "SELECT * FROM `features`";
                    $res = $con->query($q);
                    while ($row=mysqli_fetch_assoc($res)) {
                    $checked = in_array($row['id'], $selected_features) ? "checked" : '';?>

                        <div class='col-md-3'>
                            <label>
                                <input type='checkbox'<?php echo $checked; ?> name='features[]' value='<?php echo $row["id"]; ?>' class='form-check-input shadow-none'>
                                <?php echo $row['name']; ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold">Facilities</label>
                <div class="row">
                    <?php
                    $selected_facility = [];
                    $facility = "SELECT * FROM `room_facilities` where room_id = '$roomid'";
                    $res2 = $con->query($facility);
                    while ($row2=mysqli_fetch_assoc($res2)) {
                        $selected_facility[] = $row2['facility_id'];
                    }
                    $q = "SELECT * FROM `facilities`";
                    $res = $con->query($q);
                    while ($row=mysqli_fetch_assoc($res)) { 
                        $checked = in_array($row['id'], $selected_facility) ? "checked" : '';
                         ?>
                        <div class='col-md-3'>
                            <label>
                                <input type='checkbox' <?php echo $checked; ?> name='facilities[]' value="<?php echo $row['id']; ?>" class='form-check-input shadow-none'>
                                <?php echo $row['name']; ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="desc" class="form-control shadow-none" rows="4" required><?php echo $row1['description']; ?></textarea>
            </div>
            <input type="hidden" name="room_id" value="<?php echo $row1['id']; ?>">      
        </div>
<?php     
    }
    die();
}

if(isset($_POST['save'])){
    $features = $_POST['features'];
    $facilities = $_POST['facilities'];
    $roomid = $_POST['room_id'];
    $name = $_POST['name'];
    $area = $_POST['area'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $adult = $_POST['adult'];
    $children = $_POST['children'];
    $desc = $_POST['desc'];
    
    $flag = 0;

    $q = "UPDATE `rooms` SET `name`='$name',`area`='$area',`price`='$price',`quantity`='$quantity',`adult`='$adult',`children`='$children',`description`='$desc' WHERE `id`=$roomid";
    $res = $con->query($q);
    if ($res) {
        $flag = 1;
    }

    $del_features = $con->query("DELETE FROM `room_features` WHERE `room_id`='$roomid'");
    $del_facilities = $con->query("DELETE FROM `room_facilities` WHERE `room_id`='$roomid'");

    $q2 = "INSERT INTO `room_facilities`(`room_id`, `facility_id`) VALUES (?, ?)";
    if ($stmt = $con->prepare($q2)) {
        foreach ($facilities as $f) {
            $stmt->bind_param('ii', $roomid, $f);
            $stmt->execute();
        }
        $stmt->close();
    } else {
        $flag = 0;
        die('Query can not be prepared - room facilities insert');
    }

    $q3 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?, ?)";
    if ($stmt = $con->prepare($q3)) {
        foreach ($features as $f) {
            $stmt->bind_param('ii', $roomid, $f);
            $stmt->execute();
        }
        $flag = 0;
        $stmt->close();
    } else {
        $flag = 0;
        die('Query can not be prepared - room features insert');
    }

    $_SESSION['message']="<div>Room Updated Succefully</div>";
    header("Location: ../rooms.php");
    die();
}

if(isset($_POST['add_img'])){
    $room_id = $_POST['room_id'];
    $image = $_FILES['image'];
    $img_name = $_FILES['image']['name'];
    $img_size = $_FILES['image']['size'];
    $tmp_dir = $_FILES['image']['tmp_name'];
    $img_typ = $_FILES['image']['type'];
    if($img_typ == "image/jpeg" || $img_typ == "image/png" || $img_typ == "image/jpg" || $img_typ == "image/svg" || $img_typ == "image/webp" || $img_typ == "image/htm"){
        if($img_size <= 2097152){
            move_uploaded_file($tmp_dir,"../images/".$img_name);
            $sql = "INSERT INTO `room_images`(`room_id`, `image`) VALUES ('$room_id','$img_name')";
            $res = $con->query($sql);
            if($res){
                $_SESSION['message'] = "<div>Image Added Succefully</div>";
                header("Location: ../rooms.php");
            }
            else{      
                $_SESSION['message'] = "<div>Sorry! something went wrong</div>";
                header("Location: ../rooms.php"); 
            }
        }else{
             $_SESSION['message'] = "<div>Image size should be less than 2MB</div>";
                header("Location: ../rooms.php");
        }
    }else{
         $_SESSION['message'] = "<div>Image format not supported.</div>";
                header("Location: ../rooms.php");
    }
    die();
}
    
if (isset($_POST['get_room_images'])) {
    $room_id = $_POST['get_room_images'];
    if (!is_numeric($room_id)) {
        die('Invalid room ID');
    }

    $q2 = "SELECT * FROM `room_images` WHERE `room_id`=?";
    if ($stmt = $con->prepare($q2)) {
        $stmt->bind_param('i', $room_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $images = array();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imageData = $row['image'];
                    $images[] = $imageData;
                    $path = "images/" . $imageData;
                    if ($row['thumbnail']==1) {
                        $thumb_btn = '<i class="bi bi-check2 text-light bg-success px-2 py-1 rounded fs-5"></i>';
                     }else{
                        $thumb_btn = "<button type='button' data-bs-dismiss='modal' onclick='thumb_img($row[id],$row[room_id])' class='btn btn-secondary shadow-none'>
                                <i class='bi bi-check2'></i> 
                            </button>";
                     } 
                    ?>
                    <tr>
                        <td><img src="<?php echo $path; ?>" class="img-fluid"></td>
                        <td><?php echo $thumb_btn; ?></td>
                        <td>
                            <button type='button'data-bs-dismiss="modal" onclick="del_img(<?php echo $row['id']; ?>)" class='btn btn-danger shadow-none btn-sm edit-room-button' >
                                <i class="bi bi-trash3"></i> 
                            </button>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<div class='bg-warning text-white text-center'>No images found for room No.$room_id</div>";
            }
            
            $stmt->close();
        } else {
            die('Error executing the query');
        }
    } else {
        die('Query cannot be prepared - room facilities insert');
    }
}

if (isset($_POST['del_img'])) {
    $del_id = $_POST['del_img'];
    $q = "DELETE FROM `room_images` WHERE `id`=$del_id";
    $res = $con->query($q);
    echo $res;
}

if (isset($_POST['img_id'])&&isset($_POST['room_id'])) {
   $img_id = $_POST['img_id'];
   $room_id = $_POST['room_id'];

   $q1 = "UPDATE `room_images` SET `thumbnail`=0 WHERE `room_id`='$room_id'";
   $res1 = $con->query($q1);

   $q2 = "UPDATE `room_images` SET `thumbnail`=1 WHERE `id`='$img_id'";
   $res2 = $con->query($q2);
   echo 1;
   die();
}

if (isset($_POST['room_id'])) {
    $roomid = $_POST['room_id'];
    // $res = $con->query("SELECT * FROM `room_images` WHERE `room_id`='$room_id'");
    // while ($row=mysqli_fetch_assoc($res)) {
    //     $path = "images/".$row['image'];
    //     unlink($path);
    // }
    $res1 = $con->query("DELETE FROM `room_images` WHERE `room_id`='$roomid'");
    $res2 = $con->query("DELETE FROM `room_features` WHERE `room_id`='$roomid'");
    $res3 = $con->query("DELETE FROM `room_facilities` WHERE `room_id`='$roomid'");
    $res4 = $con->query("UPDATE `rooms` SET `removed`=1 WHERE `id`='$roomid'");

    if ($res1 || $res2 || $res3) {
        echo 1;
    }else{
        echo 0;
    }
    die();
}
 ?>
