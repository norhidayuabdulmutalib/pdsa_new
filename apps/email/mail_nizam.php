<?php
include("Mail.php");
/* mail setup recipients, subject etc */
$recipients = "nizamms@gmail.com";
$headers["From"] = "ict@darulquran.gov.my";
$headers["To"] = "nizamms@gmail.com";
$headers["Subject"] = "User feedback";
$mailmsg = "Hello, This is a test.";
/* SMTP server name, port, user/passwd */
$smtpinfo["host"] = "postmaster.1govuc.gov.my";
$smtpinfo["port"] = "25";
$smtpinfo["auth"] = true;
$smtpinfo["username"] = "root";
$smtpinfo["password"] = "j4k1mdq2oo8";
/* Create the mail object using the Mail::factory method */
$mail_object =& Mail::factory("smtp", $smtpinfo);
/* Ok send mail */
$mail_object->send($recipients, $headers, $mailmsg);
?>