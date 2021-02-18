<?php 
include 'smtp.php';
$mail_to = $_POST['email'];
/* subject */
$subject = $_POST['subject'];
//$subject = "e-Halal JAKIM - Makluman Kelulusan Permohonan Akaun Syarikat";
$message = $_POST['message'];
/* To send HTML mail, you can set the Content-type header. */
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
/* additional headers */
$headers .= "From: Webmaster HALAL<halal@islam.gov.my>\r\n";
$headers .= "Cc:\r\n";
$headers .= "bcc:\r\n";
//mail($mail_to, $subject, $message, $headers = '');
smtpmail($mail_to, $subject, $message, $headers);
?>						

<table align="center" width="100%">
  <tr><td></td></tr>
    <tr align="center"><td align="center"><br><br><font color="#FFFFFF"><strong>TERIMA KASIH</strong>&nbsp;telah digunakan </font></td></tr>
  <tr align="center"><td><font color="#FFFFFF">Kunjungi Laman Web Halal JAKIM selalu</font></td></tr>
</table>
<script language='Javascript'>
	alert('Pengemaskinian Data Selesai.');
</script>
<meta http-equiv="refresh" content="0; URL=http:company_list.php?page=<?php print $cur_pg?>"> 
