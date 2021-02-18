<?php
include '../../common.php';
$kid=isset($_REQUEST["kid"])?$_REQUEST["kid"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
//$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
//$blok_search=isset($_REQUEST["blok_search"])?$_REQUEST["blok_search"]:"";

//if(!empty($pro) && $pro=='PILIH'){
	$conn->debug=true;
	print "JK:".$jk;
	if(empty($id)){ $id = $kid; }
	$bilikid=isset($_REQUEST["bilikid"])?$_REQUEST["bilikid"]:"";
	$jk=isset($_REQUEST["jk"])?$_REQUEST["jk"]:"";
	//$sql = "UPDATE _tbl_kursus_jadual SET bilik_kuliah=".tosql($bilikid)." WHERE id=".tosql($id);
	//$conn->execute($sql);
	$rsd = "SELECT * FROM _tbl_kursus_jadual WHERE id=".tosql($kid);
	$rsdt = $conn->execute($rsd);
	$stdt = $rsdt->fields['startdate'];
	$endt = $rsdt->fields['enddate'];
	//print $jk;
	$tid = "T-".date("Ymd")."-".uniqid();
	$sqli = "INSERT INTO _sis_a_tblasrama_tempah(tempahan_id, event_id, bilik_id, asrama_type, startdt, enddt, j_tempah)
	VALUES(".tosql($tid).", ".tosql($kid).", ".tosql($bilikid,"Number").", 'P',".tosql($stdt).", ".tosql($endt).", 'KL')";
	$conn->execute($sqli);
	//print "<br>".$sqli;
//}
?>