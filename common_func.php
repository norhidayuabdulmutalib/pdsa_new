<?php

function pusat_kursus($pusat_id){
  	global $conn; $sSQL='';
	$sSQL = "SELECT SubCategoryNm, SubCategoryDesc FROM _tbl_kursus_catsub WHERE id=".tosql($pusat_id);
  	$rs2 = &$conn->execute($sSQL);
	//print $sSQL;
	$pusat_name = $rs2->fields['SubCategoryDesc']."<br><i>[ ".$rs2->fields['SubCategoryNm']." ]</i>";
	
	return $pusat_name;
}

function pusat_list($pusat_id){
  	global $conn; $sSQL='';
	$sSQL = "SELECT SubCategoryNm, SubCategoryDesc FROM _tbl_kursus_catsub WHERE id=".tosql($pusat_id);
  	$rs2 = &$conn->execute($sSQL);
	//print $sSQL;
	$pusat_name = $rs2->fields['SubCategoryDesc']." [".$rs2->fields['SubCategoryNm']."]";
	
	return $pusat_name;
}

?>