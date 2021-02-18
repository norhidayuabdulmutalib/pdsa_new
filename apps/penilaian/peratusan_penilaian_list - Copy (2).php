<?
//$conn->debug=true;
$sSQL="SELECT * FROM _tbl_nilai_bahagian WHERE pset_id=".tosql($id);
$sSQL .= " ORDER BY nilai_sort";
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
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
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
								?>
								<tr bgcolor="#FFFFFF">
									<td valign="top" align="right"><?=$bil;?>.</td>
									<td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
									<td align="center"><input type="text" size="4" value="<?=$nilai1;?>" style="text-align:center" /></td>
									<td align="center"><input type="text" size="4" value="<?=$nilai2;?>" style="text-align:center" /></td>
									<td align="center"><input type="text" size="4" value="<?=$nilai3;?>" style="text-align:center" /></td>
									<td align="center"><input type="text" size="4" value="<?=$nilai4;?>" style="text-align:center" /></td>
									<td align="center"><input type="text" size="4" value="<?=$nilai5;?>" style="text-align:center" /></td>
								</tr>
								<?
								$cnt = $cnt + 1;
							   // $bil = $bil + 1;
								$rs_det->movenext();
							} 
                            $jump++;
							$rs_pensyarah->movenext();
						}
					} else { 
						$sql_det = "SELECT A.*, B.f_penilaian_desc, C.f_penilaian FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B, _ref_penilaian_kategori C
						WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND B.f_penilaianid=C.f_penilaianid AND A.nilaib_id=".tosql($id_bhg);
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
							?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td align="center"><input type="text" size="4" value="<?=$nilai1;?>" style="text-align:center" /></td>
                                <td align="center"><input type="text" size="4" value="<?=$nilai2;?>" style="text-align:center" /></td>
                                <td align="center"><input type="text" size="4" value="<?=$nilai3;?>" style="text-align:center" /></td>
                                <td align="center"><input type="text" size="4" value="<?=$nilai4;?>" style="text-align:center" /></td>
                                <td align="center"><input type="text" size="4" value="<?=$nilai5;?>" style="text-align:center" /></td>
                            </tr>
							<?
							$cnt = $cnt + 1;
						   // $bil = $bil + 1;
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
    <br />Sila klik untuk serahan maklumat penilaian.
</td></td>
</table> 
</form>
