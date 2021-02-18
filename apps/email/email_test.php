<?
include 'smtp.php';

$mail_to = 'nizamms@gmail.com';
/* subject */
$subject = "Test Account 1govuc";
/* message */
$message = '
	<head>
	<title>Testing 1GOVUC - ITIS</title>
	</head>
	<body>
	Testing : Testing 1GOVUC - ITIS
	<p>
	Thank you,<br>
	Webmaster
	</b>
	</body>
	</html>';

	/* To send HTML mail, you can set the Content-type header. */
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
	/* additional headers */
	$headers .= "From: KursusIlim<kursus_ilim@islam.gov.my>\r\n";
	$headers .= "Cc:nizamms@yahoo.com\r\n";
	$headers .= "bcc:\r\n";
	
	smtpmail($mail_to, $subject, $message, $headers);
 	//mail($mail_to, $subject, $message, $headers = '');
	//if(mail($mail_to, $subject, $message, $headers)){
    //   	print "OK";
   	//	exit();
	//}

?>						