<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php
//$conn->debug=true;
$id=isset($_REQUEST["pset_id"])?$_REQUEST["pset_id"]:"";

//$sSQL="SELECT * FROM _tbl_nilai_bahagian WHERE pset_id=".tosql($id);
//$sSQL .= " ORDER BY nilai_sort";
$sSQL="SELECT B.* FROM _tbl_penilaian_set A, _tbl_nilai_bahagian B WHERE A.pset_id=B.pset_id AND A.pset_status=0";
$sSQL .= " ORDER BY B.nilai_sort ASC, B.nilaib_id ASC";

$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
//$conn->debug=false;

?>
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
					//print $sql_upd; //
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

			$selqb = "SELECT * FROM _tbl_set_penilaian_bhg WHERE fset_id=".tosql($set_id)." AND fsetb_event_id=".tosql($id)." AND fsetb_nilaib_id=".tosql($id_bhg);
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


function disp_heads(){
	return '<!--<tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="2"><b>Bil</b></td>
                    <td width="45%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="50%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>-->
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="1"><b>Bil</b></td>
                    <td width="45%" align="center" rowspan="1"><b>Maklumat Penilaian</b></td>
                    <td width="10%" align="center" valign="bottom"><b>Amat Tidak Setuju</b></td>
                    <td width="10%" align="center" valign="bottom"><b>Tidak Setuju<br /></b></td>
                    <td width="10%" align="center" valign="bottom"><b>Kurang Setuju<br /></b></td>
                    <td width="10%" align="center" valign="bottom"><b>Setuju<br /></b></td>
                    <td width="10%" align="center" valign="bottom"><b>Sangat Setuju<br /></b></td>
                </tr>';
}
function disp_heads2(){
	return '<!--<tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="2"><b>Bil</b></td>
                    <td width="45%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="50%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>-->
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="1"><b>Bil</b></td>
                    <td width="45%" align="center" rowspan="1"><b>Maklumat Penilaian</b></td>
                    <td width="10%" align="center" colspan=2 valign="bottom"><b>&nbsp;</b></td>
                    <td width="10%" align="center" colspan=3 valign="bottom"><b>&nbsp;</b></td>
                </tr>';
}
?>
<script language="javascript" type="text/javascript">	
function do_close(){
	//parent.emailwindow.hide();
	window.close();
}
function handleprint(){
	window.print();
}
</script>
<style type="text/css" media="all">@import"../../css/print_style.css";</style>
<style media="print" type="text/css">
	body{FONT-SIZE: 10px;FONT-FAMILY: Arial;COLOR: #000000}
	.printButton { display: none; }
	#ad{ display:none;}
	#leftbar{ display:none;}
	#contentarea{ width:100%;}
</style>
<style type="text/css">
@media all{
 .page-break { display:none; }
}

@media print{
	#ad{ display:none;}
	#leftbar{ display:none;}
	#contentarea{ width:100%;}
 	.page-break { display:block; page-break-before:always; }
}
</style>

</head>

<body>
<TABLE SUMMARY="This table gives the character entity reference,
                decimal character reference, and hexadecimal character
                reference for 8-bit Latin-1 characters, as well as the
                rendering of each in your browser." width="100%" align="center">
  <COLGROUP>
  <COLGROUP SPAN=3>
  <COLGROUP SPAN=3>
  <THEAD>
    <tr valign="top" bgcolosr="#80ABF2">
    	<td width="30%">&nbsp;</td> 
        <td width="40%" height="30" colspan="3" valign="middle" align="center">            
	        <img src="../images/crestmalaysia.gif" width="50" height="35" border="0" /><br />
        </td>
    	<td width="30%"><div style="float:right;vertical-align:text-top" align="right"><b>BPP(1)</b><br /><b>Institut Latihan Islam Malaysia 2011</b></div></td> 
    </tr>
    <tr valign="top" bgcolosr="#80ABF2"> 
        <td height="30" colspan="5" valign="middle" align="center" width="100%">            
            Institut Latihan Islam Malaysia<br />
            Jalan Sungai Merab, Seksyen 12,<br />
            43650 Bandar Baru Bangi, Selangor<br />
        </td>
    </tr>
  </THEAD>
  <TBODY style="width:100%">
    <tr valign="top" bgcolosr="#80ABF2"> 
        <td height="30" colspan="5" valign="middle" align="center">
	        <font size="3" face="Arial, Helvetica, sans-serif"><strong>BORANG PENILAIAN PESERTA KURSUS / BENGKEL</strong></font>
        </td>
    </tr>
    <tr><td colspan="5">
        <table width="100%" cellpadding="2" cellspacing="0" border="0" align="center">
	        <tr>
                <td width="10%" align="left"><b>Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="84%" align="left" style="border-bottom:thin;border-bottom-style:dotted;"><?php print $rskursus->fields['courseid'] . " - " .$rskursus->fields['coursename'];?></td>                
            </tr>
            <tr>
                <td align="left"><b>Kategori</b></td>
                <td align="center"><b> : </b></td>
                <td align="left" style="border-bottom:thin;border-bottom-style:dotted;"><?php print $rskursus->fields['categorytype'];?></td>                
            </tr>
            <tr>
                <td align="left"><b>Tempat</b></td>
                <td align="center"><b> : </b></td>
                <td align="left" style="border-bottom:thin;border-bottom-style:dotted;">
				<?php print dlookup("_tbl_bilikkuliah","f_bilik_nama","f_bilikid=".tosql($rskursus->fields['bilik_kuliah']));?></td>                
            </tr>
            <tr>
                <td align="left"><b>Tarikh</b></td>
                <td align="center"><b> : </b></td>
                <td align="left" style="border-bottom:thin;border-bottom-style:dotted;">
				<?php print DisplayDate($rskursus->fields['startdate']);?> - <?php print DisplayDate($rskursus->fields['enddate']);?></td>                
            </tr>
            <tr>
                <td align="left" colspan="3">
				Anda diminta memberikan maklum balas yang ikhlas kepada setiap kenyataan dengan membulatkan nombor skala yang ditetapkan.</td>                
            </tr>
		</table>
    </td></tr>
    <tr><td colspan="5">&nbsp;</td></tr>
    <tr><td colspan="5">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        	
        </table>
    </td></tr>
    <tr><td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td width="12%">1. Umur :</td>
        <td width="16%">20 ke bawah</td>
        <td width="3%"><input type="text" size="1" /></td>
        <td width="7%">&nbsp;</td>
        <td width="11%">2. Jantina :</td>
        <td width="8%">Lelaki</td>
        <td width="2%"><input type="text" size="1" /></td>
        <td width="3%">&nbsp;</td>
        <td width="21%">3.Kumpulan Jawatan :</td>
        <td width="12%">JUSA</td>
        <td width="5%"><input type="text" size="1" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>20-29 tahun</td>
        <td><input type="text" size="1" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Perempuan</td>
        <td><input type="text" size="1" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>P&amp;P</td>
        <td><input type="text" size="1" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>30-39 tahun</td>
        <td><input type="text" size="1" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Sokongan</td>
        <td><input type="text" size="1" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>40-49 tahun</td>
        <td><input type="text" size="1" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>50 tahun ke atas</td>
        <td><input type="text" size="1" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">4. kekerapan Kursus di ILIM</td>
        <td>Pertama</td>
        <td><input type="text" size="1" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Kedua</td>
        <td><input type="text" size="1" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Lebih dari dua</td>
        <td><input type="text" size="1" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">5. Gred Jawatan :</td>
        <td colspan="7" style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</td>
        <td colspan="2">(sila nyatakan)</td>
      </tr>
      <tr>
        <td colspan="2">6. Jabatan/Agensi tempat bertugas :</td>
        <td colspan="7" style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</td>
        <td colspan="2">(sila nyatakan)</td>
      </tr>
      <tr>
        <td colspan="2">7. Negeri tempat bertugas :</td>
        <td colspan="7" style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</td>
        <td colspan="2">(sila nyatakan)</td>
      </tr>
    </table><br /></td></tr>
	<tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">    <?php
$select = "SELECT B.fsetb_id FROM _tbl_kursus_jadual_masa A, _tbl_set_penilaian_bhg B WHERE A.id_jadmasa=B.fsetb_jadmasaid AND B.fsetb_event_id=".tosql($id);
$select .= " ORDER BY tarikh, masa_mula ";
$rssort = $conn->execute($select);
//print $select; exit;
if(!$rssort->EOF){
	$bil=3;
	while(!$rssort->EOF){
		$ids = $rssort->fields['fsetb_id'];
		$ups = "UPDATE _tbl_set_penilaian_bhg SET sorts=".tosql($bil)." WHERE fsetb_id=".tosql($ids);
		$conn->execute($ups);
		$bil++;
		$rssort->movenext();
		//print $ups;
	}
}


$sql_det = "SELECT * FROM _tbl_set_penilaian WHERE fset_event_id=".tosql($id);
//$conn->debug=true;
$rs = &$conn->Execute($sql_det);
$fset_id = $rs->fields['fset_id'];

	$sql_det = "SELECT A.*, B.nilai_keterangan FROM _tbl_set_penilaian_bhg A, _tbl_nilai_bahagian B
	WHERE A.fsetb_nilaib_id=B.nilaib_id AND A.fsetb_event_id=".tosql($id)." AND A.fset_id=".tosql($fset_id);
	$sql_det .= " ORDER BY sorts"; //print $sql_det;
	$rs_bhg = &$conn->Execute($sql_det);
	
            if(!$rs_bhg->EOF) {
				$bil_bhg=0; $jum_rec=0;
                while(!$rs_bhg->EOF) {
					$bil_bhg++;
					 $fsetb_id = $rs_bhg->fields['fsetb_id'];
					 $fsetbp_id= $rs_bhg->fields['fsetbp_id'];
					 $fsetb_pensyarah_id = $rs_bhg->fields['fsetb_pensyarah_id'];
					 $fsetb_jadmasaid = $rs_bhg->fields['fsetb_jadmasaid'];
					 $jump=0;
            ?>
                    <tr height="25px" bgcolor="#666666">
                        <td colspan="7" align="left">&nbsp;&nbsp;<b><label><?php echo stripslashes($rs_bhg->fields['nilai_keterangan']);?></label></b></td>
                    </tr>
                    <?php
                    if(!empty($fsetb_pensyarah_id)){ // JIKA MELIBATKAN PENSYARAH
                        $sql_p = "SELECT A.tajuk, A.tarikh, A.masa_mula, A.masa_tamat, B.insname, B.ingenid FROM _tbl_kursus_jadual_masa A, _tbl_instructor B WHERE A.event_id=".tosql($id)." 
						AND A.id_pensyarah=".tosql($fsetb_pensyarah_id)." AND A.id_pensyarah=B.ingenid AND A.id_jadmasa=".tosql($fsetb_jadmasaid);
						$sql_p .= " ORDER BY A.tarikh, A.masa_mula";
                        $rs_pensyarah = $conn->execute($sql_p);
						//print $sql_p;
						print '<tr height="25px" bgcolor="#CCCCCC">
							<td colspan="7" align="left"><b>Nama Pensyarah : '.stripslashes($rs_pensyarah->fields['insname']).'
							<br>Tajuk : '.stripslashes($rs_pensyarah->fields['tajuk']).' - ' .
							DisplayDate($rs_pensyarah->fields['tarikh']).' ('.$rs_pensyarah->fields['masa_mula'].' - '.$rs_pensyarah->fields['masa_tamat'].')</b></td>
						</tr>';
					}

					$sql_det = "SELECT A.*, B.f_penilaian_jawab, B.f_penilaian_desc FROM _tbl_set_penilaian_bhg_detail A, _ref_penilaian_maklumat B 
					WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.event_id=".tosql($id). " AND fsetb_id=".tosql($fsetb_id);
					$rs_det = &$conn->Execute($sql_det);
					$bil=0;
					while(!$rs_det->EOF){ 
						$bil++;
						$fsetdet_id=$rs_det->fields['fsetdet_id'];
						if($rs_det->fields['f_penilaian_jawab']=='1'){
							if($bil==1){ print disp_heads(); }
				?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left"><?php echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td align="center"> 1 </td>
                                <td align="center"> 2 </td>
                                <td align="center"> 3 </td>
                                <td align="center"> 4 </td>
                                <td align="center"> 5 </td>
                            </tr>
						<?php } else if($rs_det->fields['f_penilaian_jawab']=='2'){ 
							if($bil==1){ print disp_heads2(); } ?>
								<tr bgcolor="#FFFFFF">
									<td valign="top" align="right"><?=$bil;?>.</td>
									<td valign="top" align="left"><?php echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                    <td align="center" colspan="2"> Ya </td>
									<td align="center" colspan="3"> Tidak </td>
								</tr>
						<?php } else if($rs_det->fields['f_penilaian_jawab']=='3'){ 
						}
						$cnt = $cnt + 1; $jum_rec++;
						$rs_det->movenext();
					} 
					$bil = $bil + 1;
					/*if(!empty($fsetbp_pensyarah_id)){ ?>
						<tr bgcolor="#FFFFFF">
								<td valign="top" align="left" colspan="7"><br /><div style="border-bottom:thin;border-bottom-style:dotted;">Ulasan : 
                                <textarea name="ulasan<?=$bil_bhg;?>" id="ulasan" rows="3" cols="100" onchange="do_pro('<?=$fsetbp_id;?>','<?=$id;?>',this.form.ulasan<?=$bil_bhg;?>.value,'U')"><?php print $rs_bhg->fields['fsetbp_remarks'];?></textarea></div><br></td>
							</tr>
				<?php	 }*/
				$rs_bhg->movenext();
				}
			} 
             ?>                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">
    <br />
    <b>Sila berikan cadangan bagi meningkatkan mutu kursus ini :</b><br />
    <br /><div style="border-bottom:thin;border-bottom-style:dotted;">1. </div>
    <br /><div style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</div>
    <br /><div style="border-bottom:thin;border-bottom-style:dotted;">2. </div>
    <br /><div style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</div>
    <br /><div style="border-bottom:thin;border-bottom-style:dotted;">3. </div>
    <br /><div style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</div>
    <br /><div style="border-bottom:thin;border-bottom-style:dotted;">4. </div>
    <br /><div style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</div>
	</td></tr>
<tr><td align="center" width="100%" colspan="5">
<hr />
	<?php //print $jum_nilai."/".$cnt; ?>
    <input type="hidden" name="jum_nilai" value="<?=$jum_nilai;?>" />
    <input type="hidden" name="cnt" value="<?=$cnt;?>" />
</td></tr>
</table> 
</form>
    <div class="printButton" align="center">
        <br>
        <table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
        <input type="button" value="Print" onClick="handleprint()" style="cursor:pointer" />
        <input type="button" value="Close" onClick="do_close()" title="Please click to close window" style="cursor:pointer">
        <br>Please change the printing Orientation to <b>Potrait</b> before printing.
        <br /><br />
        </td></tr></table>
    </div>
</div>
  </TBODY>
</TABLE>
</body>
</html>
