<script language="javascript" type="text/javascript">	
function do_pro_peserta(fsetp_id,id,fields,mark){
	var URL = 'peserta/kursus_penilaian_upd_peserta.php?fsetp_id='+fsetp_id+'&id='+id+'&fields='+fields+'&mark='+mark;
	//alert(URL);
	callToServer(URL);
}

function do_pro_pesertaval(fsetp_id,id,fields,mark){
	var URL = 'peserta/kursus_penilaian_upd_peserta.php?fsetp_id='+fsetp_id+'&id='+id+'&fields='+fields;
	if(fields=='f_title_grade'){
		URL = URL + "&mark="+document.ilim.f_title_grade.value;
	} else if(fields=='fsetp_tempat_tugas'){
		URL = URL + "&mark="+document.ilim.fsetp_tempat_tugas.value;
	} else if(fields=='fsetp_negeri'){
		URL = URL + "&mark="+document.ilim.fsetp_negeri.value;
	}
	//alert(URL);
	callToServer(URL);
}

function do_pro(fset_pid,id,mark,ty){
	//alert(mark);
	if(ty=='U'){
		var ulas=mark;
		var URL = 'peserta/kursus_penilaian_upd_peserta_det.php?fset_pid='+fset_pid+'&id='+id+'&mark='+ulas+'&ty=U';
	} else if(ty=='K'){
		var ulas=mark;
		var URL = 'peserta/kursus_penilaian_upd_peserta_det.php?fset_pid='+fset_pid+'&id='+id+'&mark='+ulas+'&ty=K';
	} else {
		var URL = 'peserta/kursus_penilaian_upd_peserta_det.php?fset_pid='+fset_pid+'&id='+id+'&mark='+mark+'&ty=';
	}
	//alert(URL);
	callToServer(URL);
}

function do_serah(kursus_id,icno,fsetp_id,id){
	/*var jum = document.ilim.jum_nilai.value;
	var cnt = document.ilim.cnt.value;
	if(cnt==jum){
		if(confirm("Adakah and apasti untuk membuat serahan")){
			var URL = 'peserta/kursus_penilaian_upd_det.php?fsetp_id'+fsetp_id+'&id='+id;
			callToServer(URL);
		}
	} else {
		alert("Sila pilih kesemua maklumat markah penilaian.");
	}*/
	if(confirm("Adakah and apasti untuk membuat serahan")){
		var URL = 'peserta/kursus_penilaian_upd_det.php?kursus_id='+kursus_id+'&icno='+icno+'&fsetp_id='+fsetp_id+'&id='+id;
		//alert(URL); 
		document.ilim.action = URL;
		document.ilim.submit();
		//callToServer(URL);
	}	
	
}
</script>
<?
function disp_heads(){
	return '<!--<tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="2"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="35%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>-->
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="1"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="1"><b>Maklumat Penilaian</b></td>
                    <td width="7%" align="center" valign="bottom"><b>Amat Tidak Setuju</b></td>
                    <td width="7%" align="center" valign="bottom"><b>Tidak Setuju<br /></b></td>
                    <td width="7%" align="center" valign="bottom"><b>Kurang Setuju<br /></b></td>
                    <td width="7%" align="center" valign="bottom"><b>Setuju<br /></b></td>
                    <td width="7%" align="center" valign="bottom"><b>Sangat Setuju<br /></b></td>
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

//calculate years of age (input string: YYYY-MM-DD)
function birthday($birthday){
	list($year,$month,$day) = explode("-",$birthday);
	$year_diff  = date("Y") - $year;
	$month_diff = date("m") - $month;
	$day_diff   = date("d") - $day;
	if ($day_diff < 0 || $month_diff < 0)
	  $year_diff--;
	return $year_diff;
}

//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kursus_id=isset($_REQUEST["kursus_id"])?$_REQUEST["kursus_id"]:"";
$ic=isset($_REQUEST["ic"])?$_REQUEST["ic"]:"";
/*$sSQL="SELECT * FROM _tbl_nilai_bahagian WHERE pset_id=".tosql($kursus_id);
$sSQL .= " ORDER BY nilai_sort";*/


$conn->debug=false;
$sql = "SELECT * FROM _tbl_set_penilaian WHERE fset_event_id=".tosql($kursus_id);
$rs = &$conn->query($sql);
$fset_id = $rs->fields['fset_id'];
$conn->debug=false;

$sql1 = "SELECT * FROM _tbl_set_penilaian_peserta WHERE event_id=".tosql($kursus_id)." AND fset_id=".tosql($fset_id)." AND id_peserta=".tosql($id);
$rs_sql1 = &$conn->query($sql1);
if($rs_sql1->EOF){
	$sql_pes = "SELECT * FROM _tbl_peserta WHERE f_peserta_noic=".tosql($ic);
	$rs_peserta = &$conn->Execute($sql_pes);
	$umurs = birthday($rs_peserta->fields['f_peserta_lahir']);
	$jantinas = $rs_peserta->fields['f_peserta_jantina'];
	$positions = $rs_peserta->fields['f_title_grade'];
	$negeri = $rs_peserta->fields['f_peserta_negeri'];
	$BranchCd = $rs_peserta->fields['BranchCd'];
	$pos = dlookup("_ref_titlegred","f_jawatan","f_gred_id=".tosql($positions));
	$jum_kursus = dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted=1 AND peserta_icno=".tosql($ic));
	
	$ttugas = dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($BranchCd));
	
	if($umurs<=19){ $umurp = ', fsetp_umur19'; } 
	else if($umurs>=20 && $umurs<=29){ $umurp = ', fsetp_umur20'; } 
	else if($umurs>=30 && $umurs<=39){ $umurp = ', fsetp_umur30'; } 
	else if($umurs>=40 && $umurs<=49){ $umurp = ', fsetp_umur40'; } 
	else if($umurs>=50){ $umurp = ', fsetp_umur50'; } 
	else { $umurp = ', fsetp_umur19'; } 

	if($jantinas=='L'){ $jantina = ', fsetp_jantina_l'; } 
	else { $jantina = ', fsetp_jantina_p'; } 

	if($pos=='1'){ $jawatan = ', fsept_jusa'; } 
	else if($pos=='2'){ $jawatan = ', fsetp_pp'; } 
	else { $jawatan = ', fsetp_sokongan'; } 

	if($jum_kursus=='1'){ $kursus_hadir = ', fsetp_pertama'; } 
	else if($jum_kursus=='2'){ $kursus_hadir = ', fsetp_kedua'; } 
	else { $kursus_hadir = ', fsetp_ketiga'; } 
	
	$sel_val="SELECT fset_id, fset_event_id FROM _tbl_set_penilaian
 		WHERE fset_event_id=".tosql($kursus_id)." AND fset_id=".tosql($fset_id);
	$rs_val = &$conn->query($sel_val);
	$fset_id=$rs_val->fields['fset_id'];
	$fset_event_id=$rs_val->fields['fset_event_id'];
	
	
	/*$sql_ins1 = "INSERT INTO _tbl_set_penilaian_peserta (fset_id, event_id, id_peserta".$umurp.")
		SELECT fset_id, fset_event_id, ".tosql($id)." FROM _tbl_set_penilaian
 		WHERE fset_event_id=".tosql($kursus_id)." AND fset_id=".tosql($fset_id);*/
	$sql_ins1 = "INSERT INTO _tbl_set_penilaian_peserta (fset_id, event_id, id_peserta, fsetp_jawatan, fsetp_negeri, fsetp_tempat_tugas".$umurp.$jantina.$jawatan.$kursus_hadir.")
	VALUES(".tosql($fset_id).", ".tosql($fset_event_id).", ".tosql($id).", ".tosql($positions).", ".tosql($negeri).", ".tosql($ttugas).", 1, 1, 1, 1)";
	$conn->execute($sql_ins1);
	//print $sql_ins1; exit;
	if(mysql_errno()<>0){ print "Ada masalah sistem."; exit; }
}
//$conn->debug=false;

$sql1 = "SELECT * FROM _tbl_set_penilaian_peserta_bhg WHERE event_id=".tosql($kursus_id)." AND fset_id=".tosql($fset_id)." 
	AND id_peserta=".tosql($id);
$rs_sql1 = &$conn->query($sql1);
if($rs_sql1->EOF){
	$sql_ins2 = "INSERT INTO _tbl_set_penilaian_peserta_bhg (fsetb_id, fset_id, event_id, fsetbp_nilaib_id, fsetbp_pensyarah_id, fsetbp_jadmasaid, sorts, id_peserta)
		SELECT fsetb_id, fset_id, fsetb_event_id, fsetb_nilaib_id, fsetb_pensyarah_id, fsetb_jadmasaid, sorts, ".tosql($id)." FROM _tbl_set_penilaian_bhg
 		WHERE fsetb_event_id=".tosql($kursus_id)." AND fset_id=".tosql($fset_id);
	$conn->execute($sql_ins2);
	if(mysql_errno()<>0){ print "Ada masalah sistem."; exit; }
}

$sql1 = "SELECT * FROM _tbl_set_penilaian_peserta_detail WHERE event_id=".tosql($kursus_id)." AND fset_id=".tosql($fset_id)." AND id_peserta=".tosql($id);
$rs_sql1 = &$conn->query($sql1);
if($rs_sql1->EOF){
	$sql_ins3 = "INSERT INTO _tbl_set_penilaian_peserta_detail (fsetdet_id, fset_id, fsetb_id, event_id, f_penilaian_detailid, id_peserta, fsetdet_5)
		SELECT fsetdet_id, fset_id, fsetb_id, event_id, f_penilaian_detailid, ".tosql($id).", 1 FROM _tbl_set_penilaian_bhg_detail
 		WHERE event_id=".tosql($kursus_id)." AND fset_id=".tosql($fset_id);
	$conn->execute($sql_ins3);
	if(mysql_errno()<>0){ print "Ada masalah sistem."; exit; }
}

//exit;


//$conn->debug=true;
$sSQL = "SELECT A.*, B.f_peserta_noic, B.f_title_grade FROM _tbl_set_penilaian_peserta A, _tbl_peserta B, _tbl_kursus_jadual_peserta C 
WHERE A.id_peserta=C.InternalStudentId AND B.f_peserta_noic=C.peserta_icno AND A.event_id=".tosql($kursus_id)." AND A.fset_id=".tosql($fset_id)." AND C.InternalStudentId=".tosql($id);
$rs = &$conn->query($sSQL);
//$cnt = $rs->recordcount();
$fsetp_id = $rs->fields['fsetp_id'];
$icno = $rs->fields['f_peserta_noic'];
$positions = $rs->fields['f_title_grade'];
$pos = dlookup("_ref_titlegred","f_jawatan","f_gred_id=".tosql($positions));
//$conn->debug=false;

?>
<form name="ilim" method="post">
<input type="hidden" name="fsetp_id" value="<?=$fsetp_id;?>" />
<input type="hidden" name="id" value="<?=$id;?>" />
<input type="hidden" name="id" value="<?=$icno;?>" />
<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr valign="top" bgcolosr="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT RUJUKAN PENILAIAN</strong></font>
        </td>
    </tr>
	<tr><td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td width="12%">1. Umur :</td>
        <td width="16%">20 ke bawah</td>
        <td width="3%"><input type="radio" value="1" name="fsetp_umur" <?php if($rs->fields['fsetp_umur19']==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro_peserta('<?=$fsetp_id;?>','<?=$id;?>','fsetp_umur',19)" /></td>
        <td width="7%">&nbsp;</td>
        <td width="11%">2. Jantina :</td>
        <td width="8%">Lelaki</td>
        <td width="2%"><input type="radio" value="1" name="fsetp_jantina" <?php if($rs->fields['fsetp_jantina_l']==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro_peserta('<?=$fsetp_id;?>','<?=$id;?>','fsetp_jantina','L')" /></td>
        <td width="3%">&nbsp;</td>
        <td width="21%">3.Kumpulan Jawatan :</td>
        <td width="12%">
        <?php   if($pos==1){ print 'Sokongan'; }
				else if($pos==2){ print 'P & P'; }
				else if($pos==3){ print 'JUSA'; }
        ?>
		<!--P&amp;P--></td>
        <td width="5%"><!--
        	<input type="radio" value="1" name="fsept_jawatan" <?php if($rs->fields['fsetp_pp']==1){ print 'checked="checked"'; }?> 
                 onclick="do_pro_peserta('<?=$fsetp_id;?>','<?=$id;?>','fsept_jawatan','PP')" />--></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>20-29 tahun</td>
        <td><input type="radio" value="1" name="fsetp_umur" <?php if($rs->fields['fsetp_umur20']==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro_peserta('<?=$fsetp_id;?>','<?=$id;?>','fsetp_umur',20)" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Perempuan</td>
        <td><input type="radio" value="1" name="fsetp_jantina" <?php if($rs->fields['fsetp_jantina_p']==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro_peserta('<?=$fsetp_id;?>','<?=$id;?>','fsetp_jantina','P')" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><!--Sokongan--></td>
        <td><!--<input type="radio" value="1" name="fsept_jawatan" <?php if($rs->fields['fsetp_sokongan']==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro_peserta('<?=$fsetp_id;?>','<?=$id;?>','fsept_jawatan','S')" />--></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>30-39 tahun</td>
        <td><input type="radio" value="1" name="fsetp_umur" <?php if($rs->fields['fsetp_umur30']==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro_peserta('<?=$fsetp_id;?>','<?=$id;?>','fsetp_umur',30)" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><!--JUSA--></td>
        <td><!--<input type="radio" value="1" name="fsept_jawatan" <?php if($rs->fields['fsept_jusa']==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro_peserta('<?=$fsetp_id;?>','<?=$id;?>','fsept_jawatan','J')" />--></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>40-49 tahun</td>
        <td><input type="radio" value="1" name="fsetp_umur" <?php if($rs->fields['fsetp_umur40']==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro_peserta('<?=$fsetp_id;?>','<?=$id;?>','fsetp_umur',40)" /></td>
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
        <td><input type="radio" value="1" name="fsetp_umur" <?php if($rs->fields['fsetp_umur50']==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro_peserta('<?=$fsetp_id;?>','<?=$id;?>','fsetp_umur',50)" /></td>
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
        <td><input type="radio" value="1" name="fsetp_kekerapan" <?php if($rs->fields['fsetp_pertama']==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro_peserta('<?=$fsetp_id;?>','<?=$id;?>','fsetp_kekerapan',1)" /></td>
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
        <td><input type="radio" value="1" name="fsetp_kekerapan" <?php if($rs->fields['fsetp_kedua']==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro_peserta('<?=$fsetp_id;?>','<?=$id;?>','fsetp_kekerapan',2)" /></td>
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
        <td><input type="radio" value="1" name="fsetp_kekerapan" <?php if($rs->fields['fsetp_ketiga']==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro_peserta('<?=$fsetp_id;?>','<?=$id;?>','fsetp_kekerapan',3)" /></td>
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
      <?php
            $sqlp = "SELECT * FROM _ref_titlegred WHERE is_deleted=0 AND f_status=0 ORDER BY f_gred_code";
            $rspg = &$conn->execute($sqlp);
      ?>
      <tr>
        <td colspan="2">5. Gred Jawatan :</td>
        <td colspan="7" style="border-bottom:thin;border-bottom-style:dotted;">
            <select name="f_title_grade" onchange="do_pro_pesertaval('<?=$fsetp_id;?>','<?=$id;?>','f_title_grade',0)">
                <?php while(!$rspg->EOF){ ?>
                <option value="<?php print $rspg->fields['f_gred_id'];?>" <?php if($rspg->fields['f_gred_id']==$rs->fields['fsetp_jawatan']){ print 'selected'; }
                ?>><?php print $rspg->fields['f_gred_code'] ." - ". $rspg->fields['f_gred_name'];?></option>
                <?php $rspg->movenext(); } ?>
           </select>
           <input type="text" size="30" name="gred_jawatan" value="" /></td>
        <td colspan="2">(sila nyatakan)</td>
      </tr>
      <tr>
        <td colspan="2">6. Jabatan/Agensi tempat bertugas :</td>
        <td colspan="7" style="border-bottom:thin;border-bottom-style:dotted;">
        	<input type="text" size="60" name="fsetp_tempat_tugas" value="<?php print $rs->fields['fsetp_tempat_tugas'];?>" 
            onchange="do_pro_pesertaval('<?=$fsetp_id;?>','<?=$id;?>','fsetp_tempat_tugas',0)">
        </td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td colspan="2">7. Negeri tempat bertugas :</td>
        <td colspan="7" style="border-bottom:thin;border-bottom-style:dotted;">
        	<select name="fsetp_negeri" onchange="do_pro_pesertaval('<?=$fsetp_id;?>','<?=$id;?>','fsetp_negeri',0)">
                <?php 
				$r_country = listLookup('ref_negeri', 'kod_negeri, negeri', '1', 'kod_negeri');
				while(!$r_country->EOF){ ?>
				<option value="<?=$r_country->fields['kod_negeri'] ?>" 
					<?php if($rs->fields['fsetp_negeri']==$r_country->fields['kod_negeri']) echo "selected"; ?>><?=$r_country->fields['negeri']?></option>
                <?php $r_country->movenext(); }?>        
           </select>
           <input type="text" size="30" name="negeri_bertugas" value="" />
               &nbsp;</td>
        <td colspan="2"><i>(sila nyatakan)</i></td>
      </tr>
    </table><br /></td></tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
<?php
//$conn->debug=false;
$sql_det = "SELECT A.*, B.nilai_keterangan FROM _tbl_set_penilaian_peserta_bhg A, _tbl_nilai_bahagian B
WHERE A.fsetbp_nilaib_id=B.nilaib_id AND A.event_id=".tosql($kursus_id)." AND A.id_peserta=".tosql($id)." AND A.fset_id=".tosql($fset_id);
$sql_det .= " ORDER BY fsetbp_jadmasaid";
//$conn->debug=true;
$rs_bhg = &$conn->Execute($sql_det);
//$conn->debug=false;
?>
                
            <?
            if(!$rs_bhg->EOF) {
				$bil_bhg=0;
                while(!$rs_bhg->EOF) {
					$bil_bhg++;
					 $fsetb_id = $rs_bhg->fields['fsetb_id'];
					 $fsetbp_id= $rs_bhg->fields['fsetbp_id'];
					 $fsetb_pensyarah_id = $rs_bhg->fields['fsetbp_pensyarah_id'];
					 $fsetb_jadmasaid = $rs_bhg->fields['fsetbp_jadmasaid'];
					 $jump=0;
            ?>
                    <tr height="25px" bgcolor="#666666">
                        <td colspan="7" align="left">&nbsp;&nbsp;<b><label><?php echo stripslashes($rs_bhg->fields['nilai_keterangan']);?></label></b><?//=$fsetb_pensyarah_id;?></td>
                    </tr>
                    <?php
                    if(!empty($fsetb_pensyarah_id)){ // JIKA MELIBATKAN PENSYARAH
                        $sql_p = "SELECT A.tajuk, A.tarikh, A.masa_mula, A.masa_tamat, B.insname, B.ingenid 
						FROM _tbl_kursus_jadual_masa A, _tbl_instructor B WHERE A.event_id=".tosql($kursus_id)." 
						AND A.id_pensyarah=".tosql($fsetb_pensyarah_id)." AND A.id_pensyarah=B.ingenid AND A.id_jadmasa=".tosql($fsetb_jadmasaid);
						$sql_p .= " ORDER BY tarikh, masa_mula";
                        $rs_pensyarah = $conn->execute($sql_p);
						//print $sql_p;
						print '<tr height="25px" bgcolor="#CCCCCC">
							<td colspan="7" align="left"><b>Nama Pensyarah : '.stripslashes($rs_pensyarah->fields['insname']).'
							<br>Tajuk : '.stripslashes($rs_pensyarah->fields['tajuk']).'</b> - ' .
							displayDate($rs_pensyarah->fields['tarikh']).' ('.$rs_pensyarah->fields['masa_mula'].' - '.$rs_pensyarah->fields['masa_tamat'].')</td>
						</tr>';
					}

					$sql_det = "SELECT A.*, B.f_penilaian_jawab, B.f_penilaian_desc FROM _tbl_set_penilaian_peserta_detail A, _ref_penilaian_maklumat B 
					WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.event_id=".tosql($kursus_id). " AND A.id_peserta=".tosql($id)." AND fsetb_id=".tosql($fsetb_id);
					$rs_det = &$conn->Execute($sql_det);
					$bil=0;
					while(!$rs_det->EOF){ 
						$bil++;
						$fset_pid=$rs_det->fields['fset_pid'];
						if($rs_det->fields['f_penilaian_jawab']=='1'){ if($bil==1){ print disp_heads(); }
						if(empty($rs_det->fields['fsetdet_1']) && empty($rs_det->fields['fsetdet_2']) && empty($rs_det->fields['fsetdet_3']) 
						&& empty($rs_det->fields['fsetdet_4']) && empty($rs_det->fields['fsetdet_5'])){
							$set_ = 1;
						} else { $set_ = 0; }
				?>
						<tr bgcolor="#FFFFFF">
							<td valign="top" align="right"><?=$bil;?>.</td>
							<td valign="top" align="left"><?php echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
							<td align="center"><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($rs_det->fields['fsetdet_1']==1){ print 'checked="checked"'; }?> 
								onclick="do_pro('<?=$fset_pid;?>','<?=$id;?>',1)" /></td>
							<td align="center"><input type="radio" value="2" name="chk_val[<?=$cnt;?>]" <?php if($rs_det->fields['fsetdet_2']==1){ print 'checked="checked"'; }?> 
								onclick="do_pro('<?=$fset_pid;?>','<?=$id;?>',2)" /></td>
							<td align="center"><input type="radio" value="3" name="chk_val[<?=$cnt;?>]" <?php if($rs_det->fields['fsetdet_3']==1){ print 'checked="checked"'; }?> 
								onclick="do_pro('<?=$fset_pid;?>','<?=$id;?>',3)" /></td>
							<td align="center"><input type="radio" value="4" name="chk_val[<?=$cnt;?>]" <?php if($rs_det->fields['fsetdet_4']==1){ print 'checked="checked"'; }?> 
								onclick="do_pro('<?=$fset_pid;?>','<?=$id;?>',4)" /></td>
							<td align="center"><input type="radio" value="5" name="chk_val[<?=$cnt;?>]" 
							<?php if($rs_det->fields['fsetdet_5']==1 || $set_==1){ print 'checked="checked"'; }?> 
								onclick="do_pro('<?=$fset_pid;?>','<?=$id;?>',5)" /></td>
						</tr>
						<?php } else if($rs_det->fields['f_penilaian_jawab']=='2'){ 
							if($bil==1){ print disp_heads2(); } ?>
						<tr bgcolor="#FFFFFF">
							<td valign="top" align="right"><?=$bil;?>.</td>
							<td valign="top" align="left"><?php echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
							<td align="center" colspan="2"> Ya 
                            	<input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($rs_det->fields['fsetdet_1']==1){ print 'checked="checked"'; }?> 
								onclick="do_pro('<?=$fset_pid;?>','<?=$id;?>',1)" /></td>
							<td align="center" colspan="3"> Tidak 
                            	<input type="radio" value="2" name="chk_val[<?=$cnt;?>]" <?php if($rs_det->fields['fsetdet_2']==1){ print 'checked="checked"'; }?> 
								onclick="do_pro('<?=$fset_pid;?>','<?=$id;?>',2)" /></td>
						</tr>
						<?php } else if($rs_det->fields['f_penilaian_jawab']=='3'){ 
							if($bil==1){ print disp_heads2(); }?>
						<tr bgcolor="#FFFFFF">
							<td valign="top" align="right"><?=$bil;?>.</td>
							<td valign="top" align="left" colspan="6">
								<?php echo stripslashes($rs_det->fields['f_penilaian_desc']);?><br />
								<textarea rows="10" cols="100" name="remarks" onchange="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',99,'<?=$kursus_id;?>','')"><?php print $pp_remarks;?></textarea>&nbsp;</td>
						</tr>
						<?php
						}
						$cnt = $cnt + 1;
						$rs_det->movenext();
					} 
					$bil = $bil + 1;
					if(!empty($fsetbp_pensyarah_id)){ ?>
						<tr bgcolor="#FFFFFF">
								<td valign="top" align="left" colspan="7"><br /><div style="border-bottom:thin;border-bottom-style:dotted;">Ulasan : 
                                <textarea name="ulasan<?=$bil_bhg;?>" id="ulasan" rows="3" cols="100" onchange="do_pro('<?=$fsetbp_id;?>','<?=$id;?>',this.form.ulasan<?=$bil_bhg;?>.value,'U')"><?php print $rs_bhg->fields['fsetbp_remarks'];?></textarea></div><br></td>
							</tr>
				<?php	 }
				$rs_bhg->movenext();
				}
			} 
             ?>                   
            </table> 
        </td>
    </tr>
            <tr bgcolor="#FFFFFF">
                    <td valign="top" align="left" colspan="7"><br /><div style="border-bottom:thin;border-bottom-style:dotted;"><strong>Ulasan Kursus : </strong>
                    <textarea name="ulasan_kursus" id="ulasan_kursus" rows="3" cols="100" onchange="do_pro('<?=$fsetp_id;?>','<?=$id;?>',this.form.ulasan_kursus.value,'K')"><?php print $rs->fields['fsetp_remarks'];?></textarea></div><br></td>
                </tr>
    <tr><td colspan="5">	
</td></tr>
<tr><td align="center" width="100%">
<hr />
	<?php //print $jum_nilai."/".$cnt; ?>
    <input type="hidden" name="jum_nilai" value="<?=$jum_nilai;?>" />
    <input type="hidden" name="cnt" value="<?=$cnt;?>" />
	<input type="button" value="Serah" style="cursor:pointer" onclick="do_serah('<?=$kursus_id;?>','<?=$icno;?>','<?=$fsetp_id;?>','<?=$id;?>')" />
    <br />Sila klik untuk serahan maklumat penilaian.
    <br />Sila pastikan anda membuat pilihan keatas semua soalan yang diberikan.
    <br />Setelah butang serah ini diklik / tekan, anda tidak lagi boleh membuat penilaian.
</td></td>
</table> 
</form>
