<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetakan Penilaian</title>
<script language="javascript" type="text/javascript">	
function do_close(){
	parent.emailwindow.hide();
	//window.close();
}
function handleprint(){
	window.print();
}
</script>
<style type="text/css" media="all">@import"../../css/print_style.css";</style>
<style media="print" type="text/css">
	body{FONT-SIZE: 10px;FONT-FAMILY: Arial;COLOR: #000000}
	.printButton { display: none; }

@media all{
 .page-break { display:none; }
}

@media print{
 .page-break { display:block; page-break-before:always; }
}
</style>
</head>
<body>
<?
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
if(empty($id)){ $id=isset($_REQUEST["id"])?$_REQUEST["id"]:""; }
$proses=isset($_REQUEST["PRO"])?$_REQUEST["PRO"]:"";
/*if($proses=='PROSES'){
	$conn->debug=true;
	$sql = "SELECT * FROM _tbl_set_penilaian WHERE fset_event_id=".tosql($id);
	$rs = &$conn->Execute($sql);
	if(!$rs->EOF){
		$u19 = dlookup("_tbl_set_penilaian_peserta","count(*)","fsetp_umur19=1 AND event_id=".tosql($id));
		$u20 = dlookup("_tbl_set_penilaian_peserta","count(*)","fsetp_umur20=1 AND event_id=".tosql($id));
		$u30 = dlookup("_tbl_set_penilaian_peserta","count(*)","fsetp_umur30=1 AND event_id=".tosql($id));
		$u40 = dlookup("_tbl_set_penilaian_peserta","count(*)","fsetp_umur40=1 AND event_id=".tosql($id));
		$u50 = dlookup("_tbl_set_penilaian_peserta","count(*)","fsetp_umur50=1 AND event_id=".tosql($id));
		$jantina_l = dlookup("_tbl_set_penilaian_peserta","count(*)","fsetp_jantina_l=1 AND event_id=".tosql($id));
		$jantina_p = dlookup("_tbl_set_penilaian_peserta","count(*)","fsetp_jantina_p=1 AND event_id=".tosql($id));
		$jawatan_j = dlookup("_tbl_set_penilaian_peserta","count(*)","fsept_jusa=1 AND event_id=".tosql($id));
		$jawatan_p = dlookup("_tbl_set_penilaian_peserta","count(*)","fsept_pp=1 AND event_id=".tosql($id));
		$jawatan_s = dlookup("_tbl_set_penilaian_peserta","count(*)","fsept_sokongan=1 AND event_id=".tosql($id));
		$kursus_1 = dlookup("_tbl_set_penilaian_peserta","count(*)","fsetp_pertama=1 AND event_id=".tosql($id));
		$kursus_2 = dlookup("_tbl_set_penilaian_peserta","count(*)","fsetp_kedua=1 AND event_id=".tosql($id));
		$kursus_3 = dlookup("_tbl_set_penilaian_peserta","count(*)","fsetp_ketiga=1 AND event_id=".tosql($id));
	
		$sqlu = "UPDATE _tbl_set_penilaian SET fsetp_umur19=".tosql($u19).", fsetp_umur20=".tosql($u20).", 
		 	fsetp_umur30=".tosql($u30).",  fsetp_umur40=".tosql($u40).",  fsetp_umur50=".tosql($u50).",
			fsetp_jantina_l=".tosql($jantina_l).", fsetp_jantina_p=".tosql($jantina_p).", 
			fsept_jusa=".tosql($jawatan_j).", fsept_pp=".tosql($jawatan_p).", fsept_sokongan=".tosql($jawatan_s).", 
			fsetp_pertama=".tosql($kursus_1).", fsetp_kedua=".tosql($kursus_2).", fsetp_ketiga=".tosql($kursus_3)." 
		WHERE fset_event_id=".tosql($id);
		$conn->Execute($sqlu);
	}

	$sql_det = "SELECT * FROM _tbl_set_penilaian_bhg_detail WHERE event_id=".tosql($id);
	$rs_det = &$conn->Execute($sql_det);
	$bil=0;
	while(!$rs_det->EOF){ 
		$bil++; $nilai=0; $pp_id='';
		$fsetdet_id 	= $rs_det->fields['fsetdet_id'];
		$nilai1 = dlookup("_tbl_set_penilaian_peserta_detail","count(*)","fsetdet_1=1 AND fsetdet_id=".tosql($fsetdet_id));
		$nilai2 = dlookup("_tbl_set_penilaian_peserta_detail","count(*)","fsetdet_2=1 AND fsetdet_id=".tosql($fsetdet_id));
		$nilai3 = dlookup("_tbl_set_penilaian_peserta_detail","count(*)","fsetdet_3=1 AND fsetdet_id=".tosql($fsetdet_id));
		$nilai4 = dlookup("_tbl_set_penilaian_peserta_detail","count(*)","fsetdet_4=1 AND fsetdet_id=".tosql($fsetdet_id));
		$nilai5 = dlookup("_tbl_set_penilaian_peserta_detail","count(*)","fsetdet_5=1 AND fsetdet_id=".tosql($fsetdet_id));
		
		$sqlpi = "UPDATE _tbl_set_penilaian_bhg_detail SET 
			fsetdet_1=".tosql($nilai1).",	fsetdet_2=".tosql($nilai2).", fsetdet_3=".tosql($nilai3).", fsetdet_4=".tosql($nilai4).", fsetdet_5=".tosql($nilai5);
		$sqlpi .= " WHERE fsetdet_id=".tosql($fsetdet_id)." AND event_id=".tosql($id);
		//print "<br>".$sqlpi."<br>";
		$conn->execute($sqlpi);
		
		$cnt = $cnt + 1;
		$rs_det->movenext();
	} 
}*/
?>
<script language="javascript">
function do_proses(id){
	var winds = document.ilim.winds.value;
	//alert(winds);
	document.ilim.action = 'modal_form.php?win='+winds+'&id='+id+'&PRO=PROSES';
	document.ilim.submit();
}
function disp_val(val,pkid,ty){
	//alert(val);
	var jk = document.ilim.jk.value;
	var pk1=document.getElementsByName("pk1")[val].value-0;
	var pk2=document.getElementsByName("pk2")[val].value-0;
	if(ty==1){
		var pk3=document.getElementsByName("pk3")[val].value-0;
		var pk4=document.getElementsByName("pk4")[val].value-0;
		var pk5=document.getElementsByName("pk5")[val].value-0;
	} else {
		var pk3=0;
		var pk4=0;
		var pk5=0;
	}
	var jumpk=0;
	jumpk = pk1+pk2+pk3+pk4+pk5;
	//alert(jumpk);
	if(jumpk>jk){
		alert("Jumlah input data melebihi jumlah kehadiran peserta");
	} else {
		var URL = 'penilaian/peratusan_penilaian_upd.php?pkid='+pkid+"&pk1="+pk1+"&pk2="+pk2+"&pk3="+pk3+"&pk4="+pk4+"&pk5="+pk5;
		callToServer(URL);
	}
	//document.ilim.action=URL;
	//document.ilim.target='_blank';
	//document.ilim.submit();
}
</script>
<?php
function disp_heads(){
	return '<!--<tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="2"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="35%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>-->
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="1"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="1"><b>Maklumat Penilaian</b></td>
                    <td width="15%" align="center" valign="bottom"><b>Bilangan Peserta</b></td>
                    <td width="10%" align="center" valign="bottom"><b>Bilangan Peserta</b></td>
                    <td width="10%" align="center" valign="bottom"><b>Peratusan<br /></b></td>
                </tr>';
}
function disp_heads2(){
	return '<!--<tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="2"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="35%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>-->
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="1"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="1"><b>Maklumat Penilaian</b></td>
                    <td width="7%" align="center" colspan=2 valign="bottom"><b>&nbsp;</b></td>
                    <td width="7%" align="center" colspan=3 valign="bottom"><b>&nbsp;</b></td>
                </tr>';
}


$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Next");
$rskursus = &$conn->Execute($sSQL);
?>
<form name="ilim" method="post">
<input type="hidden" name="id" value="<?=$id;?>" />
<input type="hidden" name="winds" value="<?=$_GET['win'];?>" />
<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr valign="top" bgcolosr="#80ABF2"> 
        <td height="30" colspan="5" valign="middle">
        <div style="float:left">
        	<font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT PERATUSAN PENILAIAN</strong></font></div>
        </td>
    </tr>
    <tr><td colspan="5">
        <table width="100%" cellpadding="2" cellspacing="0" border="0" align="center">
	        <tr>
                <td width="25%" align="right"><b>Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="74%" align="left"><?php print $rskursus->fields['courseid'] . " - " .$rskursus->fields['coursename'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Kategori</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rskursus->fields['categorytype'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Pusat</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rskursus->fields['SubCategoryNm'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Tarikh Kursus</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print DisplayDate($rskursus->fields['startdate']);?> - <?php print DisplayDate($rskursus->fields['enddate']);?></td>                
            </tr>
		</table>
    </td></tr>
    <tr><td colspan="5">&nbsp;</td></tr>
    <?php
	//$conn->debug=true;
	$jum_tawaran = dlookup("_tbl_kursus_jadual_peserta","count(*)","EventId=".tosql($id));
	$jum_hadir = dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted= 1 AND EventId=".tosql($id));
	$jum_nilai = dlookup_cnt("_tbl_penilaian_peserta","distinct pp_peserta_id","pp_eventid=".tosql($id)." GROUP BY pp_peserta_id");
	//$conn->debug=false;
	?>
	<tr>
        <td><strong>Jumlah Tawaran : <?php print $jum_tawaran;?></strong> peserta</td>
        <td><strong>Jumlah Kehadiran : <?php print $jum_hadir;?></strong> peserta hadir<input type="hidden" name="jk" value="<?=$jum_hadir;?>" /></td>
        <td><strong>Jumlah Peserta Menilai : <?php print $jum_nilai;?></strong> membuat penilaian</td>
    </tr>
    <tr><td>&nbsp;</td></tr>
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
        <td colspan="2"></td>
      </tr>
      <tr>
        <td colspan="2">7. Negeri tempat bertugas :</td>
        <td colspan="7" style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</td>
        <td colspan="2">(sila nyatakan)</td>
      </tr>
    </table><br /></td></tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
<?php
$sql_det = "SELECT * FROM _tbl_set_penilaian WHERE fset_event_id=".tosql($id);
//$conn->debug=true;
$rs = &$conn->Execute($sql_det);
$fset_id = $rs->fields['fset_id'];
	$sql_det = "SELECT A.*, B.nilai_keterangan FROM _tbl_set_penilaian_bhg A, _tbl_nilai_bahagian B
	WHERE A.fsetb_nilaib_id=B.nilaib_id AND A.fsetb_event_id=".tosql($id)." AND A.fset_id=".tosql($fset_id);
	$sql_det .= " ORDER BY sorts";
	$rs_bhg = &$conn->Execute($sql_det);
            if(!$rs_bhg->EOF) {
				$bil_bhg=0;
                while(!$rs_bhg->EOF) {
					$bil_bhg++;
					 $fsetb_id = $rs_bhg->fields['fsetb_id'];
					 $fsetbp_id= $rs_bhg->fields['fsetbp_id'];
					 $fsetb_pensyarah_id = $rs_bhg->fields['fsetb_pensyarah_id'];
					 $jump=0;
            ?>
                    <tr height="25px" bgcolor="#666666">
                        <td colspan="7" align="left">&nbsp;&nbsp;<b><label><? echo stripslashes($rs_bhg->fields['nilai_keterangan']);?></label></b></td>
                    </tr>
                    <?php
                    if(!empty($fsetb_pensyarah_id)){ // JIKA MELIBATKAN PENSYARAH
                        $sql_p = "SELECT A.tajuk, B.insname, B.ingenid FROM _tbl_kursus_jadual_masa A, _tbl_instructor B WHERE A.event_id=".tosql($id)." 
						AND A.id_pensyarah=".tosql($fsetb_pensyarah_id)." AND A.id_pensyarah=B.ingenid";
                        $rs_pensyarah = $conn->execute($sql_p);
						print '<tr height="25px" bgcolor="#CCCCCC">
							<td colspan="7" align="left"><b>Nama Pensyarah : '.stripslashes($rs_pensyarah->fields['insname']).'
							<br>Tajuk : '.stripslashes($rs_pensyarah->fields['tajuk']).'</b></td>
						</tr>';
					}

					$sql_det = "SELECT A.*, B.f_penilaian_jawab, B.f_penilaian_desc FROM _tbl_set_penilaian_bhg_detail A, _ref_penilaian_maklumat B 
					WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.event_id=".tosql($id). " AND fsetb_id=".tosql($fsetb_id);
					$rs_det = &$conn->Execute($sql_det);
					$bil=0;
					$jum_set=0;
					while(!$rs_det->EOF){ 
						$bil++;
						$pct_set1=0;$pct_set2=0;$pct_set3=0;$pct_set4=0;$pct_set5=0;$jum_set=0;
						$fsetdet_id=$rs_det->fields['fsetdet_id'];
						$set1 = $rs_det->fields['fsetdet_1'];
						$set2 = $rs_det->fields['fsetdet_2'];
						$set3 = $rs_det->fields['fsetdet_3'];
						$set4 = $rs_det->fields['fsetdet_4'];
						$set5 = $rs_det->fields['fsetdet_5'];
						$jum_set=$set1+$set2+$set3+$set4+$set5;
						if(!empty($set1)){ $pct_set1=($set1/$jum_set)*100; }
						if(!empty($set2)){ $pct_set2=($set2/$jum_set)*100; }
						if(!empty($set3)){ $pct_set3=($set3/$jum_set)*100; }
						if(!empty($set4)){ $pct_set4=($set4/$jum_set)*100; }
						if(!empty($set5)){ $pct_set5=($set5/$jum_set)*100; }
						if($rs_det->fields['f_penilaian_jawab']=='1'){
							if($bil==1){ print disp_heads(); }
				?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right" rowspan="6"><?=$bil;?>.</td>
                                <td valign="top" align="left" rowspan="6"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td valign="top" align="left">Sangat Setuju&nbsp;</td>
                                <td align="center"><?=$set1;?></td>
                                <td align="center"><?=number_format($pct_set1,2);?></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left">Setuju&nbsp;</td>
                                <td align="center"><?=$set2;?></td>
                                <td align="center"><?=number_format($pct_set2,2);?></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left">Kurang Setuju&nbsp;</td>
                                <td align="center"><?=$set3;?></td>
                                <td align="center"><?=number_format($pct_set3,2);?></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left">Tidak Setuju&nbsp;</td>
                                <td align="center"><?=$set4;?></td>
                                <td align="center"><?=number_format($pct_set4,2);?></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left">Amat Sangat Setuju&nbsp;</td>
                                <td align="center"><?=$set5;?></td>
                                <td align="center"><?=number_format($pct_set5,2);?></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left"><strong>Jumlah</strong>&nbsp;</td>
                                <td align="center"><strong><?=$jum_set;?></strong></td>
                                <td align="center"><strong>100%</strong></td>
                            </tr>
						<?php } else if($rs_det->fields['f_penilaian_jawab']=='2'){ 
							if($bil==1){ print disp_heads2(); } ?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right" rowspan="3"><?=$bil;?>.</td>
                                <td valign="top" align="left" rowspan="3"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td valign="top" align="left">Ya&nbsp;</td>
                                <td align="center"><?=$set1;?></td>
                                <td align="center"><?=number_format($pct_set1,2);?></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left">Tidak&nbsp;</td>
                                <td align="center"><?=$set2;?></td>
                                <td align="center"><?=number_format($pct_set2,2);?></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left"><strong>Jumlah</strong>&nbsp;</td>
                                <td align="center"><strong><?=$jum_set;?></strong></td>
                                <td align="center"><strong>100%</strong></td>
                            </tr>
						<?php } else if($rs_det->fields['f_penilaian_jawab']=='3'){ 
							if($bil==1){ print disp_heads2(); }?>
						<tr bgcolor="#FFFFFF">
							<td valign="top" align="right"><?=$bil;?>.</td>
							<td valign="top" align="left" colspan="6">
								<? echo stripslashes($rs_det->fields['f_penilaian_desc']);?><br />
								<textarea rows="10" cols="100" name="remarks" onchange="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',99,'<?=$kursus_id;?>','')"><?php print $pp_remarks;?></textarea>&nbsp;</td>
						</tr>
						<?php
						}
						$cnt = $cnt + 1;
						$rs_det->movenext();
					} 
					$bil = $bil + 1;
				$rs_bhg->movenext();
				}
			} 
             ?>                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5"></td></tr>
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
</body>
</html>
