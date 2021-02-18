<script language="javascript" type="text/javascript">	
function do_pro(pp_id,id,ppset_id,mark,event_id){
	var URL = 'peserta/kursus_penilaian_upd.php?pp_id='+pp_id+'&id='+id+'&ppset_id='+ppset_id+'&mark='+mark+'&event_id='+event_id;
	callToServer(URL);
	//document.ilim.action=URL;
	//document.ilim.target='_blank';
	//document.ilim.submit();
}
function do_serah(id){
	var jum = document.ilim.jum_nilai.value;
	var cnt = document.ilim.cnt.value;
	if(cnt==jum){
		if(confirm("Adakah and apasti untuk membuat serahan")){
			var URL = 'peserta/kursus_penilaian_upd_det.php?id='+id;
			callToServer(URL);
		}
	} else {
		alert("Sila pilih kesemua maklumat markah penilaian.");
	}
}
</script>
<?
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kursus_id=isset($_REQUEST["kursus_id"])?$_REQUEST["kursus_id"]:"";
$id_set = dlookup("_tbl_kursus_jadual","set_penilaian","id=".tosql($kursus_id,"Text"));

$sSQL="SELECT DISTINCT B.f_penilaianid, B.f_penilaian FROM _ref_penilaian_maklumat A, _ref_penilaian_kategori B, _tbl_penilaian_det_detail C 
WHERE A.f_penilaianid=B.f_penilaianid AND A.is_deleted=0 AND A.f_penilaian_detailid=C.f_penilaian_detailid AND C.pset_id=".tosql($id_set);
$sSQL .= " ORDER BY A.f_penilaianid, A.f_penilaian_desc";

/*$sSQL="SELECT A.*, B.f_penilaian, C.pset_detailid FROM _ref_penilaian_maklumat A, _ref_penilaian_kategori B, _tbl_penilaian_det_detail C 
WHERE A.f_penilaianid=B.f_penilaianid AND A.is_deleted=0 AND A.f_penilaian_detailid=C.f_penilaian_detailid AND C.pset_id=".tosql($id_set);
$sSQL .= " ORDER BY A.f_penilaianid, A.f_penilaian_desc";*/

$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

?>
<form name="ilim" method="post">
<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr valign="top" bgcolosr="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT RUJUKAN PENILAIAN</strong></font>
        </td>
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
								$sql_p = "SELECT * FROM _tbl_penilaian_peserta WHERE pp_peserta_id=".tosql($id)." AND pset_detailid=".tosql($rs_det->fields['pset_detailid']);
								$rs_dp = &$conn->execute($sql_p);
								if(!$rs_dp->EOF){
									$jum_nilai++;
									$nilai = $rs_dp->fields['pp_marks']; 
									$pp_id = $rs_dp->fields['pp_id'];
									
								/*} else {
									$sqli = "INSERT INTO _tbl_penilaian_peserta(pp_peserta_id, pset_detailid, )"*/ 
								}
							?>
							<tr bgcolor="#FFFFFF">
								<td valign="top" align="right"><?=$bil;?>.<?=$bill;?>.</td>
								<td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
								<td align="center"><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                	onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>')" /></td>
								<td align="center"><input type="radio" value="2" name="chk_val[<?=$cnt;?>]" <?php if($nilai==2){ print 'checked="checked"'; }?> 
                                	onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',2,'<?=$kursus_id;?>')" /></td>
								<td align="center"><input type="radio" value="3" name="chk_val[<?=$cnt;?>]" <?php if($nilai==3){ print 'checked="checked"'; }?> 
                                	onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',3,'<?=$kursus_id;?>')" /></td>
								<td align="center"><input type="radio" value="4" name="chk_val[<?=$cnt;?>]" <?php if($nilai==4){ print 'checked="checked"'; }?> 
                                	onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',4,'<?=$kursus_id;?>')" /></td>
								<td align="center"><input type="radio" value="5" name="chk_val[<?=$cnt;?>]" <?php if($nilai==5){ print 'checked="checked"'; }?> 
                                	onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',5,'<?=$kursus_id;?>')" /></td>
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
<tr><td align="center" width="100%">
<hr />
	<?php //print $jum_nilai."/".$cnt; ?>
    <input type="hidden" name="jum_nilai" value="<?=$jum_nilai;?>" />
    <input type="hidden" name="cnt" value="<?=$cnt;?>" />
	<input type="button" value="Serah" style="cursor:pointer" onclick="do_serah('<?=$id;?>')" />
    <br />Sila klik untuk serahan maklumat penilaian.
</td></td>
</table> 
</form>
