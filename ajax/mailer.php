<?php 

use PHPMailer\PHPMailer\PHPMailer;	
use PHPMailer\PHPMailer\SMTP;	
use PHPMailer\PHPMailer\Exception;	

require '../vendor/autoload.php';

$mail = new PHPMailer(true);
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->isSMTP();
$mail->SMTPAuth = true;

// SMTP configuration for Gmail
$mail->Host       = 'smtp.gmail.com';         // Gmail SMTP server
$mail->Port       = 587;                      // Gmail SMTP port (587 for TLS)
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
$mail->SMTPAuth   = true;                     // Enable SMTP authentication
$mail->Username   = 'ayan.inayatinfotech@gmail.com'; // Your Gmail address
$mail->Password   = 'ayaninayat';            // Your Gmail password

$mail->isHtml(true);

return $mail;


?>