<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'smtp.php';

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
	$headers .= "From: Webmaster ITIS<nizamms@gmail.com>\r\n";
	$headers .= "Cc:\r\n";
	$headers .= "bcc:\r\n";
	
 	//mail($mail_to, $subject, $message, $headers);
	smtpmail($mail_to, $subject, $message, $headers) or die("error");

?>						