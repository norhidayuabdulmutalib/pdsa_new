<?
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
if(empty($id)){ $id=isset($_REQUEST["id"])?$_REQUEST["id"]:""; }
$proses=isset($_REQUEST["PRO"])?$_REQUEST["PRO"]:"";
if($proses=='PROSES'){
	$sSQL="SELECT * FROM _tbl_nilai_bahagian WHERE pset_id=".tosql($id);
	$sSQL .= " ORDER BY nilai_sort";
	$rs = &$conn->Execute($sSQL);
	$cnt = $rs->recordcount();

	if(!$rs->EOF) {
		while(!$rs->EOF) {
			 $id_bhg = $rs->fields['nilaib_id'];
			 $pset_id = $rs->fields['pset_id'];
			 $is_pensyarah = $rs->fields['is_pensyarah'];
			 $jump=0;
			if(empty($is_pensyarah)){
				/*$sql_det = "SELECT A.*, B.f_penilaian_desc, C.f_penilaian FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B, _ref_penilaian_kategori C
				WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND B.f_penilaianid=C.f_penilaianid AND A.nilaib_id=".tosql($id_bhg);*/
				$sql_det = "SELECT A.*, B.f_penilaian_desc FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B
				WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.nilaib_id=".tosql($id_bhg);
				$rs_det = &$conn->Execute($sql_det);
				$bil=0;
				while(!$rs_det->EOF){ 
					$bil++; $nilai=0; $pp_id='';
					$ppset_id 	= $rs_det->fields['pset_detailid'];
					$nilai1 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=1 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id));
					$nilai2 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=2 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id));
					$nilai3 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=3 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id));
					$nilai4 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=4 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id));
					$nilai5 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=5 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id));
					
					$sqlps = "SELECT * FROM _tbl_penilaian_kursus WHERE pk_eventid=".tosql($pset_id)." AND pset_detailid=".tosql($ppset_id);
					$rsp1 = $conn->execute($sqlps);
					if($rsp1->EOF){
						$sqlpi = "INSERT INTO _tbl_penilaian_kursus(pk_eventid, pset_detailid, id_pensyarah, 
						pk_1, pk_1pct, pk_2, pk_2pct, pk_3, pk_3pct, pk_4, pk_4pct, pk_5, pk_5pct)
						VALUES(".tosql($pset_id).", ".tosql($ppset_id).", NULL, 
						".$nilai1.", 0, ".$nilai2.", 0, ".$nilai3.", 0, ".$nilai4.", 0, ".$nilai5.", 0)";
					} else {
						$sqlpi = "UPDATE _tbl_penilaian_kursus SET 
							pk1=".tosql($nilai1).",	pk2=".tosql($nilai2).", pk3=".tosql($nilai3).", pk4=".tosql($nilai4).", pk5=".tosql($nilai5);
						$sqlpi .= " WHERE pk_eventid=".tosql($pset_id)." AND pset_detailid=".tosql($ppset_id);
					}
					$conn->execute($sqlpi);
					
					$cnt = $cnt + 1;
					$rs_det->movenext();
				} 
			} else {
				$sql_p = "SELECT A.tajuk, B.insname, B.ingenid FROM _tbl_kursus_jadual_masa A, _tbl_instructor B WHERE A.event_id=".tosql($id)." AND A.id_pensyarah=B.ingenid";
				$rs_pensyarah = $conn->execute($sql_p);
				while(!$rs_pensyarah->EOF){
					$ingenid=$rs_pensyarah->fields['ingenid'];
					print '<tr height="25px" bgcolor="#CCCCCC">
						<td colspan="7" align="left"><b>Nama Pensyarah : '.stripslashes($rs_pensyarah->fields['insname']).'
						<br>Tajuk : '.stripslashes($rs_pensyarah->fields['tajuk']).'</b></td>
					</tr>';
			
					$sql_det = "SELECT A.*, B.f_penilaian_desc, C.f_penilaian FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B, _ref_penilaian_kategori C
					WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND B.f_penilaianid=C.f_penilaianid AND A.nilaib_id=".tosql($id_bhg);
					$rs_det = &$conn->Execute($sql_det);
					$bil=0;
					while(!$rs_det->EOF){ 
						$bil++; $nilai=0; $pp_id='';
						$ppset_id 	= $rs_det->fields['pset_detailid'];
						$nilai1 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=1 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id)
						." AND id_pensyarah=".tosql($ingenid));
						$nilai2 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=2 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id)
						." AND id_pensyarah=".tosql($ingenid));
						$nilai3 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=3 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id)
						." AND id_pensyarah=".tosql($ingenid));
						$nilai4 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=4 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id)
						." AND id_pensyarah=".tosql($ingenid));
						$nilai5 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=5 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id)
						." AND id_pensyarah=".tosql($ingenid));
								$cnt = $cnt + 1;
							   // $bil = $bil + 1;
						$rs_det->movenext();


						$sqlps = "SELECT * FROM _tbl_penilaian_kursus WHERE pk_eventid=".tosql($pset_id)." AND pset_detailid=".tosql($ppset_id)." AND id_pensyarah=".tosql($ingenid);
						$rsp1 = $conn->execute($sqlps);
						if($rsp1->EOF){
							$sqlpi = "INSERT INTO _tbl_penilaian_kursus(pk_eventid, pset_detailid, id_pensyarah, 
							pk_1, pk_1pct, pk_2, pk_2pct, pk_3, pk_3pct, pk_4, pk_4pct, pk_5, pk_5pct)
							VALUES(".tosql($pset_id).", ".tosql($ppset_id).", ".tosql($ingenid).", 
							".$nilai1.", 0, ".$nilai2.", 0, ".$nilai3.", 0, ".$nilai4.", 0, ".$nilai5.", 0)";
						} else {
							$sqlpi = "UPDATE _tbl_penilaian_kursus SET 
								pk1=".tosql($nilai1).",	pk2=".tosql($nilai2).", pk3=".tosql($nilai3).", pk4=".tosql($nilai4).", pk5=".tosql($nilai5);
							$sqlpi .= " WHERE pk_eventid=".tosql($pset_id)." AND pset_detailid=".tosql($ppset_id)." AND id_pensyarah=".tosql($ingenid);
						}
						$conn->execute($sqlpi);
		
					} 
					$jump++;
					$rs_pensyarah->movenext();
				}
			}
			$cnt = $cnt + 1;
			$bil = $bil + 1;
			$rs->movenext();
		} 
	}                   
}

$sSQL="SELECT * FROM _tbl_nilai_bahagian WHERE pset_id=".tosql($id);
$sSQL .= " ORDER BY nilai_sort";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

?>
<script language="javascript">
function do_proses(id){
	var win = document.ilim.win.value;
	document.ilim.action = 'modal_form.php?'+win+'&id='+id+'&PRO=PROSES';
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
$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Next");
$rskursus = &$conn->Execute($sSQL);
?>
<form name="ilim" method="post">
<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr valign="top" bgcolosr="#80ABF2"> 
        <td height="30" colspan="5" valign="middle">
        <div style="float:left">
        	<font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT PERATUSAN PENILAIAN</strong></font></div>
        <div style="float:right"><input type="button" value="Proses" style="cursor:pointer" onclick="do_proses('<?=$id;?>')" /></div>
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
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="2"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="35%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>
                <tr bgcolor="#CCCCCC">
                    <td width="7%" align="center" valign="bottom"><b>Amat Tidak Setuju</b></td>
                    <td width="7%" align="center" valign="bottom"><b>Tidak Setuju<br />
                  </b></td>
                    <td width="7%" align="center" valign="bottom"><b>Kurang Setuju</b></td>
                    <td width="7%" align="center" valign="bottom"><b>                    Setuju</b></td>
                  <td width="7%" align="center" valign="bottom"><b>Sangat Setuju<br />
                  </b></td>
                </tr>
            <?
            if(!$rs->EOF) { $jum_rec=0;
                while(!$rs->EOF) {
					 $id_bhg = $rs->fields['nilaib_id'];
					 $is_pensyarah = $rs->fields['is_pensyarah'];
					 $jump=0;
            ?>
	            <tr height="25px" bgcolor="#666666">
                    <td colspan="7">&nbsp;&nbsp;<b><label><? echo stripslashes($rs->fields['nilai_keterangan']);?></label></b></td>
                </tr>
                <?php
                    if($is_pensyarah==1){
                        $sql_p = "SELECT A.tajuk, B.insname, B.ingenid FROM _tbl_kursus_jadual_masa A, _tbl_instructor B WHERE A.event_id=".tosql($id)." AND A.id_pensyarah=B.ingenid";
                        $rs_pensyarah = $conn->execute($sql_p);
                       // print $sql_p;
                        while(!$rs_pensyarah->EOF){
							$ingenid=$rs_pensyarah->fields['ingenid'];
                            print '<tr height="25px" bgcolor="#CCCCCC">
                                <td colspan="7" align="left"><b>Nama Pensyarah : '.stripslashes($rs_pensyarah->fields['insname']).'
                                <br>Tajuk : '.stripslashes($rs_pensyarah->fields['tajuk']).'</b></td>
                            </tr>';
					
							/*$sql_det = "SELECT A.*, B.f_penilaian_desc, C.f_penilaian FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B, _ref_penilaian_kategori C
							WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND B.f_penilaianid=C.f_penilaianid AND A.nilaib_id=".tosql($id_bhg);*/
							$sql_det = "SELECT A.*, B.f_penilaian_desc FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B
							WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.nilaib_id=".tosql($id_bhg);
							$rs_det = &$conn->Execute($sql_det);
							$bil=0;
							while(!$rs_det->EOF){ 
								$bil++; $nilai=0; $pp_id='';
								$ppset_id 	= $rs_det->fields['pset_detailid'];
								$sqlss = "SELECT * FROM _tbl_penilaian_kursus WHERE pk_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id)
								." AND id_pensyarah=".tosql($ingenid);
								$rsss = $conn->execute($sqlss);
								$pk_id = $rsss->fields['pk_id'];
								$nilai1 = $rsss->fields['pk_1'];
								$nilai2 = $rsss->fields['pk_2'];
								$nilai3 = $rsss->fields['pk_3'];
								$nilai4 = $rsss->fields['pk_4'];
								$nilai5 = $rsss->fields['pk_5'];
								?>
								<tr bgcolor="#FFFFFF">
									<td valign="top" align="right"><?=$bil;?>.</td>
									<td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                    <td align="center"><input type="text" size="4" name="pk1" value="<?=$nilai1;?>" maxlength="3" style="text-align:center" 
                                    	onchange='disp_val(<?php print $jum_rec;?>,<?php print $pk_id;?>,1)' /></td>
                                    <td align="center"><input type="text" size="4" name="pk2" value="<?=$nilai2;?>" maxlength="3" style="text-align:center" 
                                    	onchange='disp_val(<?php print $jum_rec;?>,<?php print $pk_id;?>,1)' /></td>
                                    <td align="center"><input type="text" size="4" name="pk3" value="<?=$nilai3;?>" maxlength="3" style="text-align:center" 
                                    	onchange='disp_val(<?php print $jum_rec;?>,<?php print $pk_id;?>,1)' /></td>
                                    <td align="center"><input type="text" size="4" name="pk4" value="<?=$nilai4;?>" maxlength="3" style="text-align:center" 
                                    	onchange='disp_val(<?php print $jum_rec;?>,<?php print $pk_id;?>,1)' /></td>
                                    <td align="center"><input type="text" size="4" name="pk5" value="<?=$nilai5;?>" maxlength="3" style="text-align:center" 
                                    	onchange='disp_val(<?php print $jum_rec;?>,<?php print $pk_id;?>,1)' /></td>
								</tr>
								<?
								$cnt = $cnt + 1;
							    // $bil = $bil + 1;
							    $jum_rec++;
								$rs_det->movenext();
							} 
                            $jump++;
							$rs_pensyarah->movenext();
						}
					} else { 
						/*$sql_det = "SELECT A.*, B.f_penilaian_desc, C.f_penilaian 
						FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B, _ref_penilaian_kategori C
						WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND B.f_penilaianid=C.f_penilaianid AND A.nilaib_id=".tosql($id_bhg);*/
						$sql_det = "SELECT A.*, B.f_penilaian_desc, B.f_penilaian_jawab  
						FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B
						WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.nilaib_id=".tosql($id_bhg);
						$rs_det = &$conn->Execute($sql_det);
						$bil=0;
						while(!$rs_det->EOF){ 
							$bil++; $nilai=0; $pp_id='';
							$ppset_id 	= $rs_det->fields['pset_detailid'];

							$sqlss = "SELECT * FROM _tbl_penilaian_kursus WHERE pk_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id);
							$rsss = $conn->execute($sqlss);
							$pk_id = $rsss->fields['pk_id'];
							$nilai1 = $rsss->fields['pk_1'];
							$nilai2 = $rsss->fields['pk_2'];
							$nilai3 = $rsss->fields['pk_3'];
							$nilai4 = $rsss->fields['pk_4'];
							$nilai5 = $rsss->fields['pk_5'];
							if($rs_det->fields['f_penilaian_jawab']=='1'){
							?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td align="center"><input type="text" size="4" name="pk1" value="<?=$nilai1;?>" maxlength="3" style="text-align:center" 
                                	onchange='disp_val(<?php print $jum_rec;?>,<?php print $pk_id;?>,1)' /></td>
                                <td align="center"><input type="text" size="4" name="pk2" value="<?=$nilai2;?>" maxlength="3" style="text-align:center" 
                                	onchange='disp_val(<?php print $jum_rec;?>,<?php print $pk_id;?>,1)' /></td>
                                <td align="center"><input type="text" size="4" name="pk3" value="<?=$nilai3;?>" maxlength="3" style="text-align:center" 
                                	onchange='disp_val(<?php print $jum_rec;?>,<?php print $pk_id;?>,1)' /></td>
                                <td align="center"><input type="text" size="4" name="pk4" value="<?=$nilai4;?>" maxlength="3" style="text-align:center" 
                                	onchange='disp_val(<?php print $jum_rec;?>,<?php print $pk_id;?>,1)' /></td>
                                <td align="center"><input type="text" size="4" name="pk5" value="<?=$nilai5;?>" maxlength="3" style="text-align:center" 
                                	onchange='disp_val(<?php print $jum_rec;?>,<?php print $pk_id;?>,1)' /></td>
                            </tr>
							<?php } else if($rs_det->fields['f_penilaian_jawab']=='2'){ ?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td align="center" colspan="2"> Ya <input type="text" size="4" name="pk1" value="<?=$nilai1;?>" maxlength="3" style="text-align:center" 
                                	onchange='disp_val(<?php print $jum_rec;?>,<?php print $pk_id;?>,2)' /></td>
                                <td align="center" colspan="3"> Tidak <input type="text" size="4" name="pk2" value="<?=$nilai2;?>" maxlength="3" style="text-align:center" 
                                	onchange='disp_val(<?php print $jum_rec;?>,<?php print $pk_id;?>,2)' /></td>
                            </tr>
							<?php } else if($rs_det->fields['f_penilaian_jawab']=='3'){ ?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left" colspan="6">
									<? echo stripslashes($rs_det->fields['f_penilaian_desc']);?><br />
                                    <textarea rows="10" cols="100"></textarea>&nbsp;</td>
                            </tr>
                            <?php 
							}
							$cnt = $cnt + 1;
						    // $bil = $bil + 1;
						    $jum_rec++;
							$rs_det->movenext();
						} 
					}
                    $cnt = $cnt + 1;
                    $bil = $bil + 1;
                    $rs->movenext();
                } 
            } ?>                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">	
</td></tr>
<tr><td align="center" width="100%" colspan="5">
<hr />
	<?php //print $jum_nilai."/".$cnt; ?>
    <input type="hidden" name="jum_nilai" value="<?=$jum_nilai;?>" />
    <input type="hidden" name="cnt" value="<?=$cnt;?>" />
	<input type="button" value="Tutup" style="cursor:pointer" onclick="javascript:parent.emailwindow.hide();" />
    <input type="hidden" name="win" value="<?=$URLs;?>" />
</td></td>
</table> 
</form>
