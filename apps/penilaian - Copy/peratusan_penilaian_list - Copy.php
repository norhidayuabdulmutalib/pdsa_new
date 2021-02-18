<?
$conn->debug=true;
$sSQL="SELECT * FROM _tbl_nilai_bahagian WHERE pset_id=".tosql($id);
$sSQL .= " ORDER BY nilai_sort";
/*$sSQL="SELECT A.*, B.f_penilaian, C.pset_detailid FROM _ref_penilaian_maklumat A, _ref_penilaian_kategori B, _tbl_penilaian_det_detail C 
WHERE A.f_penilaianid=B.f_penilaianid AND A.is_deleted=0 AND A.f_penilaian_detailid=C.f_penilaian_detailid AND C.pset_id=".tosql($id_set);
$sSQL .= " ORDER BY A.f_penilaianid, A.f_penilaian_desc";*/
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

?>
<form name="ilim" method="post">
<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr valign="top" bgcolosr="#80ABF2"> 
        <td height="30" colspan="5" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT PERATUSAN PENILAIAN</strong></font>
        </td>
    </tr>
    <?php
	//$conn->debug=true;
	$jum_tawaran = dlookup("_tbl_kursus_jadual_peserta","count(*)","EventId=".tosql($id));
	$jum_hadir = dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted= 1 AND EventId=".tosql($id));
	$jum_nilai = dlookup_cnt("_tbl_penilaian_peserta","distinct pp_peserta_id","pp_eventid=".tosql($id)." GROUP BY pp_peserta_id");
	$conn->debug=false;
	?>
	<tr>
        <td><strong>Jumlah Tawaran : <?php print $jum_tawaran;?></strong> peserta</td>
        <td><strong>Jumlah Kehadiran : <?php print $jum_hadir;?></strong> peserta hadir</td>
        <td><strong>Jumlah Peserta Menilai : <?php print $jum_nilai;?></strong> membuat penilaian</td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="2"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="35%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>
                <tr bgcolor="#CCCCCC">
                    <td width="7%" align="center" valign="bottom"><b>Sangat Tidak Memuaskan<br />(1)</b></td>
                    <td width="7%" align="center" valign="bottom"><b>Tidak Memuaskan<br />(2)</b></td>
                    <td width="7%" align="center" valign="bottom"><b>Sederhana<br />(3)</b></td>
                    <td width="7%" align="center" valign="bottom"><b>Memuaskan<br />(4)</b></td>
                    <td width="7%" align="center" valign="bottom"><b>Sangat Memuaskan<br />(5)</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 0; $jum_nilai=0;
                    while(!$rs->EOF) {
                        $bil = $bil + 1;
						$sql = "SELECT A.*, B.f_penilaian, C.pset_detailid FROM _ref_penilaian_maklumat A, _ref_penilaian_kategori B, _tbl_penilaian_det_detail C 
							WHERE A.f_penilaianid=B.f_penilaianid AND A.is_deleted=0 AND A.f_penilaian_detailid=C.f_penilaian_detailid AND C.pset_id=".tosql($id_set).
							" AND B.f_penilaianid=".tosql($rs->fields['f_penilaianid']);
						$sql .= " ORDER BY A.f_penilaianid, A.f_penilaian_desc";
						$rs_det = &$conn->Execute($sql);
						$bill=0;
						if(!$rs_det->EOF){
						?>
							<tr bgcolor="#CCCCCC">
                            	<td><b><?=$bil;?>.</b></td>
								<td valign="top" align="left" colspan="6"><b><? echo stripslashes($rs->fields['f_penilaian']);?></b>&nbsp;</td>
							</tr>
                        <?php
							while(!$rs_det->EOF){
								$bill++; $nilai=0; $pp_id='';
								$ppset_id 	= $rs_det->fields['pset_detailid'];
								$nilai1 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=1 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id));
								$nilai2 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=2 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id));
								$nilai3 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=3 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id));
								$nilai4 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=4 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id));
								$nilai5 = dlookup("_tbl_penilaian_peserta","count(*)","pp_marks=5 AND pp_eventid=".tosql($id)." AND pset_detailid=".tosql($ppset_id));
							?>
							<tr bgcolor="#FFFFFF">
								<td valign="top" align="right"><?=$bil;?>.<?=$bill;?>.</td>
								<td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
								<td align="center"><input type="text" size="4" value="<?=$nilai1;?>" style="text-align:center" /></td>
								<td align="center"><input type="text" size="4" value="<?=$nilai2;?>" style="text-align:center" /></td>
								<td align="center"><input type="text" size="4" value="<?=$nilai3;?>" style="text-align:center" /></td>
								<td align="center"><input type="text" size="4" value="<?=$nilai4;?>" style="text-align:center" /></td>
								<td align="center"><input type="text" size="4" value="<?=$nilai5;?>" style="text-align:center" /></td>
							</tr>
							<?
								$cnt++;
								$rs_det->movenext(); 
							}
						}
                        $rs->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <? } ?>                   
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
    <br />Sila klik untuk serahan maklumat penilaian.
</td></td>
</table> 
</form>
