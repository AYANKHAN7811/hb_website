<?php 

require('admin/inc/essential.php');

session_start();
session_destroy();
header('Location: index.php');
 ?>