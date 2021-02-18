<?
/*
$fd =popen("/usr/sbin/sendmaill -t","w") or die("Couldn't Open Sendmail");
fputs($fd, "To: nizamms@gmail.com \n");
fputs($fd, "From: \"Your name\"<aziyan@rurallink.gov.my> \n");
fputs($fd, "Subject: Test message from my web site \n");
fputs($fd, "X-Mailer: PHP3 \n\n");
fputs($fd, "Testing. \n");
pclose($fd);
//exit;
include 'smtp.php';
*/
$mail_to = 'nizamms@gmail.com';
/* subject */
$subject = "Testing send email";
/* message */
$message = '
	<head>
	<title>testing email</title>
	</head>
	<body>
	TERIMA KASIH, <br>CUBAANNNNNNNNNNNNNNNNNNNNNNN
	<p>
	Sekian, terima kasih,<br>
	Webmaster
	</b>
	</body>
	</html>';

	/* To send HTML mail, you can set the Content-type header. */
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
	/* additional headers */
	$headers .= "From: Webmaster e-Parlimen<nizamms@gmail.com>\r\n";
	$headers .= "Cc:\r\n";
	$headers .= "bcc:\r\n";
	
 	mail($mail_to, $subject, $message, $headers);
	//smtpmail($mail_to, $subject, $message, $headers);

?>						