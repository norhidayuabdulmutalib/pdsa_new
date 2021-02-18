<?php
	$lepas = date("Y")-1; $semasa = date("Y"); 
	$sSQL2="SELECT B.startdate, B.enddate, A.* 
	FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B 
	WHERE A.EventId=B.id AND year(B.startdate)=".tosql($lepas)." AND A.InternalStudentAccepted=1 
	AND A.peserta_icno=".tosql($ic);
	$sSQL2 .= " ORDER BY B.startdate DESC"; //AND A.is_sijil=1 
	$rs2 = $conn->Execute($sSQL2);
	$jumlah2=0; $bil2=0;
	while(!$rs2->EOF){
		$bil2++;
		// $ddiff = get_datediff($rs2->fields['startdate'],$rs2->fields['enddate']);
		$jumlah2+=$ddiff;
		$rs2->movenext();
	}
	
	if(!empty($jumlah2)){ $jumlah2 .= " Hari"; } else { $jumlah2 = '-'; } 

	$sSQL2="SELECT B.startdate, B.enddate, A.* 
	FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B 
	WHERE A.EventId=B.id AND year(B.startdate)=".tosql($semasa)." AND A.InternalStudentAccepted=1 
	AND A.peserta_icno=".tosql($ic);
	$sSQL2 .= " ORDER BY B.startdate DESC"; //AND A.is_sijil=1 
	$rs2 = &$conn->Execute($sSQL2);
	$jumlah1=0; $bil1=0;
	while(!$rs2->EOF){
		$bil1++;
		$ddiff = get_datediff($rs2->fields['startdate'],$rs2->fields['enddate']);
		$jumlah1+=$ddiff;
		$rs2->movenext();
	}

	if(!empty($jumlah1)){ $jumlah1 .= " Hari"; } else { $jumlah1 = '-'; } 
?>
