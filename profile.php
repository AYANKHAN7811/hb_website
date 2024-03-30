
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
    require('inc/links.php'); 
    if (!isset($_SESSION['login'])) {
        header("Location: http://localhost/hb_website/index.php");
        exit(); // Ensure that script stops here and doesn't execute further
    } 
    ?> 
  <title>Profile</title>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>
 <div class="container d-flex justify-content-center align-items-center " style="height: 70vh;">
  <div class="card profile-card bg-white rounded shadow" style="width: 23rem; border:none;">
    <i class="bi bi-three-dots-vertical text-end display-7" style="margin:10px 10px 0 0;"></i>
    <img src="img/<?php echo $_SESSION['upic'] ?>" class="card-img-top justify-content-center align-items-center shadow" alt="...">
    <div class="card-body">
      <h3 class="text-center fw-bold h-font"><?php echo $_SESSION['uname']; ?></h3>
      <p class="text-center" disabled><?php echo $_SESSION['e-mail']; ?>  </p>
      <div class="d-flex justify-content-evenly display-7">
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
        <a href=""><i class="bi bi-whatsapp"></i></a>
        <a href=""><i class="bi bi-youtube"></i></a>
      </div>
    </div>
  </div>
</div>

<?php require('inc/footer.php');  ?>
</body>
</html> 