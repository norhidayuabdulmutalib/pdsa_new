<?php include_once '../../common.php';
$conn->debug=true;
$pkid=isset($_REQUEST["pkid"])?$_REQUEST["pkid"]:"";
$frm=$_GET["frm"];

if($frm=='detail'){
	$pk1=$_GET['pk1'];
	$pk2=$_GET['pk2'];
	$pk3=$_GET['pk3'];
	$pk4=$_GET['pk4'];
	$pk5=$_GET['pk5'];
	
	$sSQL="UPDATE _tbl_set_penilaian_bhg_detail SET
	fsetdet_jum1=$pk1, fsetdet_jum2=$pk2, fsetdet_jum3=$pk3, fsetdet_jum4=$pk4, fsetdet_jum5=$pk5 
	WHERE fsetdet_id = ".$pkid;

	$conn->execute($sSQL);
	print '<script language="javascript">
		//parent.location.reload();	
		//refresh = parent.location; 
		//parent.location = refresh;
	</script>';

} else if($frm=='main'){
	$id=$_GET['pkid'];
	$fields=$_GET['fields'];
	$val=$_GET['val'];
	$jum=$_GET['jum'];
	$val_jum=$_GET['val_jum'];

	if(empty($val_jum)){ $sSQL="UPDATE _tbl_set_penilaian SET $fields=$val WHERE fset_event_id=".tosql($id); }
	else { $sSQL="UPDATE _tbl_set_penilaian SET $fields=$val, jum_hadir=$val_jum WHERE fset_event_id=".tosql($id); }

	$conn->execute($sSQL);
	print '<script language="javascript">
		//parent.location.reload();
	</script>';
}

