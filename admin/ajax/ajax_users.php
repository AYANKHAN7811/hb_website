<?php 
require('../inc/essential.php');
require('../inc/db_config.php');
adminLogin();


if (isset($_POST['get_users'])){
	$q = "SELECT * FROM `user_register`";
	$res = $con->query($q);

	$i = 1;

	while ($row = mysqli_fetch_assoc($res)) {
        $del = "<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm ' >
                <i class='bi bi-trash3'></i> 
            </button>";
        $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";

        if ($row['is_varified']) {
            $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
            $del = "";
         } 

        $status = "<button onclick='toggleStatus($row[id],0)' class='btn btn-dark btn-sm shadow-none'>Active</button>";

        if (!$row['status']) {
            $status = "<button onclick='toggleStatus($row[id],1)' class='btn btn-danger btn-sm shadow-none'>Suspended</button>";
        }   

        $date = date("d-m-Y",strtotime($row['Current_time']));
        ?>
          
        <tr>
            <th><?php echo $i; ?></th>   
            <td>
                <img src="images/<?php echo $row['profile'];?>" style='width: 55px;'>
                <?php echo $row['name'];?>    
            </td>
            <td><?php echo $row['email'];?></td>
            <td><?php echo $row['number']; ?> </td>
            <td><?php echo $row['address']; ?> | <?php echo $row['pincode']; ?></td>
            <td><?php echo $row['dob']; ?></td>
            <td><?php echo $verified; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo $del; ?></td>
        </tr>
        <?php            
	    $i++;
	}
    die();
}


if (isset($_POST['toggleStatus'])){
    $frm_data = filteration($_POST);
    $q = "UPDATE `user_register` SET `status`='$frm_data[value]' WHERE `id`=$frm_data[toggleStatus]";
    $res = $con->query($q);
    if ($res) {
        echo 1;
    }else{
        echo 0;
    }
}

if (isset($_POST['id'])) {
    $frm_data = filteration($_POST);

    $res = $con->query("DELETE FROM `user_register` WHERE `id`='$frm_data[id]' AND `is_varified`=0");

    if ($res) {
        echo 1;
    }else{
        echo 0;
    }
die();
}
 
if (isset($_POST['search_user'])){

    $name = $_POST['name'];

    $q = "SELECT * FROM `user_register` WHERE `name` LIKE '%$name%'";
    $res = $con->query($q);

    $i = 1;

    while ($row = mysqli_fetch_assoc($res)) {
        $del = "<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm ' >
                <i class='bi bi-trash3'></i> 
            </button>";
        $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";

        if ($row['is_varified']) {
            $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
            $del = "";
         } 

        $status = "<button onclick='toggleStatus($row[id],0)' class='btn btn-dark btn-sm shadow-none'>Active</button>";

        if (!$row['status']) {
            $status = "<button onclick='toggleStatus($row[id],1)' class='btn btn-danger btn-sm shadow-none'>Suspended</button>";
        }   

        $date = date("d-m-Y",strtotime($row['Current_time']));
        ?>
          
        <tr>
            <th><?php echo $i; ?></th>   
            <td>
                <img src="images/<?php echo $row['profile'];?>" style='width: 55px;'>
                <?php echo $row['name'];?>    
            </td>
            <td><?php echo $row['email'];?></td>
            <td><?php echo $row['number']; ?> </td>
            <td><?php echo $row['address']; ?> | <?php echo $row['pincode']; ?></td>
            <td><?php echo $row['dob']; ?></td>
            <td><?php echo $verified; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo $del; ?></td>
        </tr>
        <?php            
        $i++;
    }
    die();
}
 ?>
