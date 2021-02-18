<?php
	$jumlah1=0;
	$jumlah2=0;
	//$conn->debug=true;
	$lepas = date("Y")-1; $semasa = date("Y"); 
	$sSQL2="SELECT B.startdate, B.enddate, A.* 
	FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B 
	WHERE A.EventId=B.id AND year(B.startdate)=".tosql($lepas)." AND A.InternalStudentAccepted=1 AND A.is_selected IN (1,9)
	AND A.peserta_icno=".tosql($rs->fields['f_peserta_noic']);
	$sSQL2 .= " GROUP BY A.EventId, A.peserta_icno ORDER BY B.startdate DESC"; //AND A.is_sijil=1 
	$rs2 = &$conn->Execute($sSQL2);
	while(!$rs2->EOF){
		$ddiff = get_datediff($rs2->fields['startdate'],$rs2->fields['enddate']);
		$jumlah1+=$ddiff;
		$rs2->movenext();
	}
	$sSQL2="SELECT A.startdate, A.enddate
	FROM _tbl_peserta_kursusluar A, _tbl_peserta B 
	WHERE A.id_peserta=B.id_peserta AND year(A.startdate)=".tosql($lepas)." 
	AND B.f_peserta_noic=".tosql($rs->fields['f_peserta_noic']);
	$sSQL2 .= " ORDER BY A.startdate DESC"; //AND A.is_sijil=1 
	$rs2 = &$conn->Execute($sSQL2);
	//print $sSQL2;
	while(!$rs2->EOF){
		$ddiff = get_datediff($rs2->fields['startdate'],$rs2->fields['enddate']);
		$jumlah1+=$ddiff;
		$rs2->movenext();
	}
	//$jumlah1 = $rs2->recordcount();

	$sSQL2="SELECT B.startdate, B.enddate, A.* 
	FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B 
	WHERE A.EventId=B.id AND year(B.startdate)=".tosql($semasa)." AND A.InternalStudentAccepted=1 AND A.is_selected IN (1,9)
	AND A.peserta_icno=".tosql($rs->fields['f_peserta_noic']);
	$sSQL2 .= " GROUP BY A.EventId, A.peserta_icno ORDER BY B.startdate DESC"; //AND A.is_sijil=1 
	$rs2 = &$conn->Execute($sSQL2);
	while(!$rs2->EOF){
		$ddiff = get_datediff($rs2->fields['startdate'],$rs2->fields['enddate']);
		$jumlah2+=$ddiff;
		$rs2->movenext();
	}
	$sSQL2="SELECT A.startdate, A.enddate
	FROM _tbl_peserta_kursusluar A, _tbl_peserta B 
	WHERE A.id_peserta=B.id_peserta AND year(A.startdate)=".tosql($semasa)." 
	AND B.f_peserta_noic=".tosql($rs->fields['f_peserta_noic']);
	$sSQL2 .= " ORDER BY A.startdate DESC"; //AND A.is_sijil=1 
	$rs2 = &$conn->Execute($sSQL2);
	while(!$rs2->EOF){
		$ddiff = get_datediff($rs2->fields['startdate'],$rs2->fields['enddate']);
		$jumlah2+=$ddiff;
		$rs2->movenext();
	}
	
	$conn->debug=false;
?>
<b><?php print $lepas;?> :</b> <u><?=$jumlah1;?> hari</u>.<br />
<b><?php print $semasa;?> :</b> <u><?=$jumlah2;?> hari</u>.<br />