<?php
include_once '../apps/email/smtp.php';

$mail_to = 'nizamms@gmail.com';

$subject = 'Website Change Reqest';

$headers = "From: kursus_ilim@islam.gov.my\r\n";
//$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
$headers .= "CC: nizamms@yahoo.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = '<html><body>';
$message .= '<h1>Hello, World!</h1>';
$message .= '</body></html>';

smtpmail($mail_to, $subject, $message, $headers);


?>