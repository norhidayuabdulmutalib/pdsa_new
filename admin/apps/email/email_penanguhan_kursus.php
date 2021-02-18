<?
include 'smtp.php';
//print "Tangguh";

$sSQL="SELECT A.*, B.startdate, B.enddate, B.penyelaras_email    
FROM _tbl_kursus A, _tbl_kursus_jadual B WHERE A.id=B.courseid AND B.id = ".tosql($id,"Text");
$rsemail = &$conn->Execute($sSQL);

$courseid = $rsemail->fields['courseid'];
$tajuk_kursus = $rsemail->fields['coursename'];
$startdate = $rsemail->fields['startdate'];
$enddate = $rsemail->fields['enddate'];
$mail_to = $rsemail->fields['penyelaras_email'];

$sqlinst = "SELECT insemail FROM _tbl_kursus_jadual_det A, _tbl_instructor B 
WHERE A.instruct_id=B.ingenid AND A.event_id=".tosql($id);

$rsemail = &$conn->execute($sqlinst);
while(!$rsemail->EOF){
	if(!empty($rsemail->fields['insemail'])){
		if(!empty($mail_to)){ $mail_to.=","; }
		$mail_to .= $rsemail->fields['insemail'];
	}
	$rsemail->movenext();
}

//if(!empty($mail_to)){ $mail_to.=","; }
//$mail_to .= 'nizamms@yahoo.com';
/* subject */
$subject = "Makluman Penanguhan Kursus";
/* message */
$message = '
	<head>
	<title>Makluman Penanguhan Kursus</title>
	</head>
	<body>
	Assalamualaikum,
	<br><br>
	Adalah dimaklumkan bahawa kursus <b>'.$courseid." - ".$tajuk_kursus.'</b> telah ditangguhkan kepada tarikh yang berikut: <br><br>';
$message .=	'Tarikh Mula : <b>'.DisplayDate($startdate).'</b><br>';
$message .=	'Tarikh Akhir : <b>'.DisplayDate($enddate).'</b><br>';
$message .=	'	<p>
	Terima Kasih,<br>
	Webmaster Ilim
	</b>
	</body>
	</html>';

	/* To send HTML mail, you can set the Content-type header. */
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
	/* additional headers */
	$headers .= "From: webmaster<kursus_ilim@islam.gov.my>\r\n";
	$headers .= "Cc:nizamms@gmail.com\r\n";
	$headers .= "bcc:\r\n";
	
	smtpmail($mail_to, $subject, $message, $headers);
 	//mail($mail_to, $subject, $message, $headers = '');
	//if(mail($mail_to, $subject, $message, $headers)){
    //   	print "OK";
   	//	exit();
	//}

?>						