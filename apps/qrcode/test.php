<?php
include '../../common_qr.php';
//include "../../phpqrcode/qrlib.php";
$kid=isset($_REQUEST["kid"])?$_REQUEST["kid"]:"";
//$conn->debug=true;


$sql_det = "SELECT * FROM _tbl_kursus_det WHERE kursus_id=".tosql($kid,"Number");
$rs_det = $conn->execute($sql_det);

/*while(!$rs_det->EOF){
	// create a QR Code with this text and display it
	QRcode::png("http://www.sitepoint.com", "test-me.png", "L", 4, 4, false, $backColor, $foreColor);
	$rs_det->movenext(); 
}*/

if(!$rs_det->EOF){
	//print dlookup("_tbl_kursus","coursename","");
	while(!$rs_det->EOF){
		//print '<img src="php/qr_img.php?d=http://itis.islam.gov.my/itis_test'.$rs_det->fields['file_name'].'" >';
		//print '<img src="php/qr_img.php?d=http://itis.islam.gov.my/itis_test/apps/all_pic/open_files.php?id='.$rs_det->fields['id_kur_det'].'" >';
		print '<img src="php/qr_img.php?d=http://itis.islam.gov.my/apps/all_pic/open_files.php?id='.$rs_det->fields['id_kur_det'].'" >';
		print '<br>'.$rs_det->fields['file_name'];
		print '<br><br>';	
		$rs_det->movenext(); 
	}

}
?>
