<?php

$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate, D.bilik_kuliah 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Next");
$rskursus = &$conn->Execute($sSQL);


$selq = "SELECT * FROM _tbl_set_penilaian WHERE fset_event_id=".tosql($id);
$rs_setnilai = &$conn->Execute($selq);
if($rs_setnilai->EOF){
	$set_id = uniqid(date("Ymd-His"));
	$sql_ins = "INSERT INTO _tbl_set_penilaian (fset_id, fset_event_id, fset_create_dt, fset_create_by)
	VALUES(".tosql($set_id).", ".tosql($id).", ".tosql(date("Y-m-d H:i:s")).", ".tosql($_SESSION["s_userid"]).")";
	//print "<br>".$sql_ins;
	$conn->Execute($sql_ins);
} else {
	$set_id=$rs_setnilai->fields['fset_id'];
}
//print 
//$conn->debug=true;
$sSQL="SELECT B.* FROM _tbl_penilaian_set A, _tbl_nilai_bahagian B WHERE A.pset_id=B.pset_id AND A.pset_status=0";
$sSQL .= " ORDER BY B.nilai_sort ASC, B.nilaib_id ASC";
$rs = &$conn->Execute($sSQL);
if(!$rs->EOF) {
	while(!$rs->EOF) {
		$id_bhg = $rs->fields['nilaib_id'];
		$is_pensyarah = $rs->fields['is_pensyarah'];
		$nilai_sort = $rs->fields['nilai_sort'];
		$jump=0;
	
		if($is_pensyarah==1 && $id_bhg==3){
			$ingenid=''; $id_jadmasa='';
			$sql_p = "SELECT A.tajuk, A.id_jadmasa, B.insname, B.ingenid FROM _tbl_kursus_jadual_masa A, _tbl_instructor B 
				WHERE A.event_id=".tosql($id)." AND A.id_pensyarah=B.ingenid";
			$rs_pensyarah = $conn->execute($sql_p);
			//print $sql_p;
			$bil_pensyarah=0;
			while(!$rs_pensyarah->EOF){
				$bil_pensyarah++;
				$ingenid=$rs_pensyarah->fields['ingenid'];
				$id_jadmasa=$rs_pensyarah->fields['id_jadmasa'];


				//$selqb = "SELECT * FROM _tbl_set_penilaian_bhg WHERE fset_id=".tosql($set_id)." AND fsetb_event_id=".tosql($id)." 
				//AND fsetb_nilaib_id=".tosql($id_bhg). " AND fsetb_jadmasaid=".tosql($id_jadmasa);
				$selqb = "SELECT * FROM _tbl_set_penilaian_bhg WHERE fset_id=".tosql($set_id)." AND fsetb_event_id=".tosql($id)." 
				AND fsetb_nilaib_id=".tosql($id_bhg). " AND fsetb_jadmasaid=".tosql($id_jadmasa);
				$rs_setbahagian = &$conn->Execute($selqb);
				$sql_ins='';
				if($rs_setbahagian->EOF){
					$set_bhgid = uniqid(date("Ymd-His"));
					$sql_ins = "INSERT INTO _tbl_set_penilaian_bhg (fsetb_id, fset_id, fsetb_event_id, fsetb_nilaib_id, 
					fsetb_pensyarah_id, fsetb_jadmasaid, fsetb_create_dt, fsetb_create_by, sorts)
					VALUES(".tosql($set_bhgid).", ".tosql($set_id).", ".tosql($id).", ".tosql($id_bhg).", 
					".tosql($ingenid).", ".tosql($id_jadmasa).", ".tosql(date("Y-m-d H:i:s")).", ".tosql($_SESSION["s_userid"]).", $nilai_sort)";
					//print "<br>".$sql_ins;
					$conn->Execute($sql_ins); if(mysql_errno()<>0){ print mysql_error(); exit; }
				} else {
					$set_bhgid = $rs_setbahagian->fields['fsetb_id'];
					$sql_upd = "UPDATE _tbl_set_penilaian_bhg SET fsetb_pensyarah_id=".tosql($ingenid).", fsetb_jadmasaid=".tosql($id_jadmasa)." 
					WHERE fsetb_id=".tosql($set_bhgid);
					//print $sql_upd;
					$conn->Execute($sql_upd); if(mysql_errno()<>0){ print mysql_error(); exit; }
				}

				/*$sql_det = "SELECT A.*, B.f_penilaian_desc, C.f_penilaian FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B, _ref_penilaian_kategori C
				WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND B.f_penilaianid=C.f_penilaianid AND A.nilaib_id=".tosql($id_bhg);*/
				$sql_det = "SELECT A.*, B.f_penilaian_desc FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B
				WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.nilaib_id=".tosql($id_bhg);
				$rs_det = &$conn->Execute($sql_det);
				$bil=0;
				while(!$rs_det->EOF){ 
					$bil++;
					$f_penilaian_detailid=$rs_det->fields['f_penilaian_detailid'];
					
					$selqb_det = "SELECT * FROM _tbl_set_penilaian_bhg_detail WHERE fset_id=".tosql($set_id)." 
					AND fsetb_id=".tosql($set_bhgid)." AND f_penilaian_detailid=".tosql($f_penilaian_detailid);
					$rs_setbahagian_det = &$conn->Execute($selqb_det);
					$sql_ins_det='';
					if($rs_setbahagian_det->EOF){
						//$set_bhgid = uniqid(date("Ymd-His"));
						$sql_ins_det = "INSERT INTO _tbl_set_penilaian_bhg_detail(fset_id, fsetb_id, f_penilaian_detailid, event_id)
						VALUES(".tosql($set_id).", ".tosql($set_bhgid).", ".tosql($f_penilaian_detailid).", ".tosql($id).")";
						//print "<br>".$sql_ins;
						$conn->Execute($sql_ins_det); if(mysql_errno()<>0){ print mysql_error(); exit; }
					}
					$cnt = $cnt + 1;
				   // $bil = $bil + 1;
					$rs_det->movenext();
				} 
				$jump++;
				$rs_pensyarah->movenext();
			} 
		} else { 
			$ingenid=''; $id_jadmasa='';
			//print "<br>biasa";
			$sql_ins=='';
			/*$sql_det = "SELECT A.*, B.f_penilaian_desc, C.f_penilaian FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B, _ref_penilaian_kategori C
			WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND B.f_penilaianid=C.f_penilaianid AND A.nilaib_id=".tosql($id_bhg);*/
			$sql_det = "SELECT A.*, B.f_penilaian_desc, B.f_penilaian_jawab FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B
			WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.nilaib_id=".tosql($id_bhg);
			$rs_det = &$conn->Execute($sql_det);
			$bil=0;

			$selqb = "SELECT * FROM _tbl_set_penilaian_bhg WHERE fset_id=".tosql($set_id)." AND fsetb_event_id=".tosql($id)." 
			AND fsetb_nilaib_id=".tosql($id_bhg);
			//print $selqb;
			$rs_setbahagian = &$conn->Execute($selqb);
			if($rs_setbahagian->EOF){
				//print $rs_det->fields['f_penilaian_desc']."<br>";
				$set_bhgid = uniqid(date("Ymd-His"));
				$sql_ins = "INSERT INTO _tbl_set_penilaian_bhg (fsetb_id, fset_id, fsetb_event_id, fsetb_nilaib_id, 
				fsetb_pensyarah_id, fsetb_jadmasaid, fsetb_create_dt, fsetb_create_by, sorts)
				VALUES(".tosql($set_bhgid).", ".tosql($set_id).", ".tosql($id).", ".tosql($id_bhg).", 
				".tosql($ingenid).", ".tosql($id_jadmasa).", ".tosql(date("Y-m-d H:i:s")).", ".tosql($_SESSION["s_userid"]).", $nilai_sort)";
				//print "<br>".$sql_ins;
				$conn->Execute($sql_ins); if(mysql_errno()<>0){ print mysql_error(); print "1"; exit; }
			} else {
				$set_bhgid = $rs_setbahagian->fields['fsetb_id'];
			}

			while(!$rs_det->EOF){ 
				$bil++; $nilai=0; $pp_id='';
				$f_penilaian_detailid=$rs_det->fields['f_penilaian_detailid'];
				
				$selqb_det = "SELECT * FROM _tbl_set_penilaian_bhg_detail WHERE fset_id=".tosql($set_id)." 
				AND fsetb_id=".tosql($set_bhgid)." AND f_penilaian_detailid=".tosql($f_penilaian_detailid);
				$rs_setbahagian_det = &$conn->Execute($selqb_det);
				$sql_ins_det='';
				if($rs_setbahagian_det->EOF){
					//$set_bhgid = uniqid(date("Ymd-His"));
					$sql_ins_det = "INSERT INTO _tbl_set_penilaian_bhg_detail(fset_id, fsetb_id, f_penilaian_detailid, event_id)
					VALUES(".tosql($set_id).", ".tosql($set_bhgid).", ".tosql($f_penilaian_detailid).", ".tosql($id).")";
					//print "<br>".$sql_ins;
					$conn->Execute($sql_ins_det); if(mysql_errno()<>0){ print mysql_error(); exit; }
				}

				$cnt = $cnt + 1;
			   // $bil = $bil + 1;
				$rs_det->movenext();
			} 
		}
		$cnt = $cnt + 1;
		$bil = $bil + 1;
					
		$rs->movenext();
	}
}
//exit;
?>
