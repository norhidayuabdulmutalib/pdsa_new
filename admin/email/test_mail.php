<?php 
//include 'smtp.php';
$mail_to = $_GET['email'];

$mail_to = 'nizamms@gmail.com';
/* subject */
$subject = "e-Halal JAKIM - Makluman Kelulusan Permohonan Akaun Syarikat";
/* message */
$message = '
	<head>
	<title>MAKLUMAN Kelulusan Permohonan Akaun Syarikat</title>
	</head>
	<body>
	TERIMA KASIH kerana membuat permohonan akaun e-halal<br>
	Berikut adalah Nama Pengguna dan Kata Laluan anda :
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
	$headers .= "From: suhaimi@islam.gov.my\r\n";
	$headers .= "Cc:\r\n";
	$headers .= "bcc:\r\n";
	
 	mail($mail_to, $subject, $message, $headers);
	//smtpmail($mail_to, $subject, $message, $headers = '');
?>