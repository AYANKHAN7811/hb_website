<?php 

define('SENDGRID_API_KEY', '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');
define('SITE_URL','http://localhost/hb_website/');
define('SITE_MAIL','ayan.inayatinfotech@gmail.com');
define('SITE_NAME','Ayan');

function adminLogin(){
	session_start();
	if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
		header('Location: index.php');
	}
}

function alert($type, $msg) {
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
    
    echo <<<alert
        <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
            <strong class="me-3">$msg</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            setTimeout(function(){
                document.querySelector('.custom-alert').remove();
            }, 3000); // 3000 milliseconds (3 seconds)
        </script>
alert;
}

 ?>
