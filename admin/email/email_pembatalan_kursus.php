<?php
include 'smtp.php';


$sSQL="SELECT A.*, B.startdate, B.enddate, B.penyelaras_email     
FROM _tbl_kursus A, _tbl_kursus_jadual B WHERE A.id=B.courseid AND B.id = ".tosql($id,"Text");
$rsemail = &$conn->Execute($sSQL);

$courseid = $rsemail->fields['courseid'];
$tajuk_kursus = $rsemail->fields['coursename'];
$startdate = $rsemail->fields['startdate'];
$enddate = $rsemail->fields['enddate'];
$mail_to = $rsemail->fields['penyelaras_email'];
$tempat = dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rsemail->fields['kampus_id']));

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
	Adalah dimaklumkan bahawa kursus berikut telah dibatalkan kerana sebab-sebab yang tidak dapat dielakkan. <br>';
	
$message .= '<p>TAJUK KURSUS : <b>'.$courseid.' - '.$tajuk_kursus.'</b><br>
			TEMPAT KURSUS : <b>'.$tempat.'</b>
		</p>';	

$message .= '<p>
	Terima Kasih,<br>
	<b>Webmaster Kursus ITIS</b>
	</body>
	</html>';

	/* To send HTML mail, you can set the Content-type header. */
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
	/* additional headers */
	$headers .= "From: webmaster<kursus_ilim@islam.gov.my>\r\n";
	$headers .= "Cc:nizamms@gmail.com\r\n";
	$headers .= "bcc:\r\n";
	
	
	//print $message; exit; 
	smtpmail($mail_to, $subject, $message, $headers);
 	//mail($mail_to, $subject, $message, $headers = '');
	//if(mail($mail_to, $subject, $message, $headers)){
    //   	print "OK";
   	//	exit();
	//}

?>						