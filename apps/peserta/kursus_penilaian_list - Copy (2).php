<script language="javascript" type="text/javascript">	
function do_pro(pp_id,id,ppset_id,mark,event_id,ingenid){
	var remarks='';
	if(event_id==99){ 
		remarks = document.ilim.remarks.value;
	}
	var URL = 'peserta/kursus_penilaian_upd.php?pp_id='+pp_id+'&id='+id+'&ppset_id='+ppset_id+'&mark='+mark+'&event_id='+event_id+'&ingenid='+ingenid+'&remarks='+remarks;
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
/*$sSQL="SELECT * FROM _tbl_nilai_bahagian WHERE pset_id=".tosql($kursus_id);
$sSQL .= " ORDER BY nilai_sort";*/

$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($kursus_id,"Next");

//$id=isset($_REQUEST["pset_id"])?$_REQUEST["pset_id"]:"";
$sSQL="SELECT * FROM _tbl_nilai_bahagian WHERE pset_id=".tosql($kursus_id);
$sSQL .= " ORDER BY nilai_sort";

$rs = &$conn->Execute($sSQL);
//$cnt = $rs->recordcount();

?>
<form name="ilim" method="post">
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
        <td width="3%"><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
        <td width="7%">&nbsp;</td>
        <td width="11%">2. Jantina :</td>
        <td width="8%">Lelaki</td>
        <td width="2%"><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
        <td width="3%">&nbsp;</td>
        <td width="21%">3.Kumpulan Jawatan :</td>
        <td width="12%">JUSA</td>
        <td width="5%"><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>20-29 tahun</td>
        <td><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Perempuan</td>
        <td><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>P&amp;P</td>
        <td><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>30-39 tahun</td>
        <td><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Sokongan</td>
        <td><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>40-49 tahun</td>
        <td><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
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
        <td><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
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
        <td><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
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
        <td><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
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
        <td><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
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
            <select name="f_title_grade">
                <?php while(!$rspg->EOF){ ?>
                <option value="<?php print $rspg->fields['f_gred_id'];?>" <?php if($rspg->fields['f_gred_id']==$rs->fields['f_title_grade']){ print 'selected'; }
                ?>><?php print $rspg->fields['f_gred_code'] ." - ". $rspg->fields['f_gred_name'];?></option>
                <? $rspg->movenext(); } ?>
           </select>
           <input type="text" size="30" name="gred_jawatan" value="" /></td>
        <td colspan="2">(sila nyatakan)</td>
      </tr>
      <tr>
        <td colspan="2">6. Jabatan/Agensi tempat bertugas :</td>
        <td colspan="7" style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td colspan="2">7. Negeri tempat bertugas :</td>
        <td colspan="7" style="border-bottom:thin;border-bottom-style:dotted;">
        	<select name="f_peserta_negeri">
                <?php 
				$r_country = listLookup('ref_negeri', 'kod_negeri, negeri', '1', 'kod_negeri');
				while(!$r_country->EOF){ ?>
				<option value="<?=$r_country->fields['kod_negeri'] ?>" 
					<?php if($rs->fields['f_peserta_negeri']==$r_country->fields['kod_negeri']) echo "selected"; ?>><?=$r_country->fields['negeri']?></option>
                <?php $r_country->movenext(); }?>        
           </select>
           <input type="text" size="30" name="negeri_bertugas" value="" />
               &nbsp;</td>
        <td colspan="2">(sila nyatakan)</td>
      </tr>
    </table><br /></td></tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="2"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="35%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>
                <tr bgcolor="#CCCCCC">
                    <td width="7%" align="center" valign="bottom"><b>Amat Tidak Setuju</b></td>
                    <td width="7%" align="center" valign="bottom"><b>Tidak Setuju<br />
                    </b></td>
                    <td width="7%" align="center" valign="bottom"><b>Kurang Setuju<br />
                    </b></td>
                    <td width="7%" align="center" valign="bottom"><b>Setuju<br />
                    </b></td>
                    <td width="7%" align="center" valign="bottom"><b>Sangat Setuju<br />
                    </b></td>
                </tr>
            <?
            if(!$rs->EOF) {
                while(!$rs->EOF) {
					 $id_bhg = $rs->fields['nilaib_id'];
					 $is_pensyarah = $rs->fields['is_pensyarah'];
					 $jump=0;
            ?>
                    <tr height="25px" bgcolor="#666666">
                        <td colspan="7" align="left">&nbsp;&nbsp;<b><label><? echo stripslashes($rs->fields['nilai_keterangan']);?></label></b></td>
                    </tr>
                    <?php
                    if($is_pensyarah==1){ // JIKA MELIBATKAN PENSYARAH
                        $sql_p = "SELECT A.tajuk, B.insname, B.ingenid FROM _tbl_kursus_jadual_masa A, _tbl_instructor B WHERE A.event_id=".tosql($kursus_id)." AND A.id_pensyarah=B.ingenid";
                        $rs_pensyarah = $conn->execute($sql_p);
                        //print $sql_p;
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
                                //$jum_nilai++;
                                $ppset_id 	= $rs_det->fields['pset_detailid'];
                                $sql_p = "SELECT * FROM _tbl_penilaian_peserta WHERE pp_peserta_id=".tosql($id)." AND pset_detailid=".tosql($rs_det->fields['pset_detailid']).
								" AND id_pensyarah=".tosql($ingenid);
                                $rs_dp = &$conn->execute($sql_p);
                                if(!$rs_dp->EOF){
                                    $jum_nilai++;
                                    $nilai = $rs_dp->fields['pp_marks']; 
                                    $pp_id = $rs_dp->fields['pp_id'];
                                }
                        ?>
                                <tr bgcolor="#FFFFFF">
                                    <td valign="top" align="right"><?=$bil;?>.</td>
                                    <td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                    <td align="center"><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
                                    <td align="center"><input type="radio" value="2" name="chk_val[<?=$cnt;?>]" <?php if($nilai==2){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',2,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
                                    <td align="center"><input type="radio" value="3" name="chk_val[<?=$cnt;?>]" <?php if($nilai==3){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',3,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
                                    <td align="center"><input type="radio" value="4" name="chk_val[<?=$cnt;?>]" <?php if($nilai==4){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',4,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
                                    <td align="center"><input type="radio" value="5" name="chk_val[<?=$cnt;?>]" <?php if($nilai==5){ print 'checked="checked"'; }?> 
                                        onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',5,'<?=$kursus_id;?>','<?=$ingenid;?>')" /></td>
                                </tr>
                                <?
                                $cnt = $cnt + 1;
                               // $bil = $bil + 1;
                                $rs_det->movenext();
                            } 
                            $jump++;
                            $rs_pensyarah->movenext();
							print '<tr bgcolor="#FFFFFF">
								<td valign="top" align="left" colspan="7"><br /><div style="border-bottom:thin;border-bottom-style:dotted;">Ulasan : </div><br></td>
							</tr>';
                        }
                    } else { // PENILAIAN SELAIN PENSYARAH
                        /*$sql_det = "SELECT A.*, B.f_penilaian_desc, C.f_penilaian FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B, _ref_penilaian_kategori C
                        WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND B.f_penilaianid=C.f_penilaianid AND A.nilaib_id=".tosql($id_bhg);*/
                        $sql_det = "SELECT A.*, B.f_penilaian_desc, B.f_penilaian_jawab FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B
                        WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.nilaib_id=".tosql($id_bhg);
                        $rs_det = &$conn->Execute($sql_det);
                        $bil=0;
                        while(!$rs_det->EOF){ 
                            $bil++; $nilai=0; $pp_id='';
                            //$jum_nilai++;
                            $ppset_id 	= $rs_det->fields['pset_detailid'];
                            $sql_p = "SELECT * FROM _tbl_penilaian_peserta WHERE pp_peserta_id=".tosql($id)." AND pset_detailid=".tosql($rs_det->fields['pset_detailid']);
                            $rs_dp = &$conn->execute($sql_p);
                            if(!$rs_dp->EOF){
                                $jum_nilai++;
                                $nilai = $rs_dp->fields['pp_marks']; 
                                $pp_id = $rs_dp->fields['pp_id'];
                                $pp_remarks = $rs_dp->fields['pp_remarks']; 
                            }
							if($rs_det->fields['f_penilaian_jawab']=='1'){
                    ?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td align="center"><input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                    onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','')" /></td>
                                <td align="center"><input type="radio" value="2" name="chk_val[<?=$cnt;?>]" <?php if($nilai==2){ print 'checked="checked"'; }?> 
                                    onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',2,'<?=$kursus_id;?>','')" /></td>
                                <td align="center"><input type="radio" value="3" name="chk_val[<?=$cnt;?>]" <?php if($nilai==3){ print 'checked="checked"'; }?> 
                                    onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',3,'<?=$kursus_id;?>','')" /></td>
                                <td align="center"><input type="radio" value="4" name="chk_val[<?=$cnt;?>]" <?php if($nilai==4){ print 'checked="checked"'; }?> 
                                    onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',4,'<?=$kursus_id;?>','')" /></td>
                                <td align="center"><input type="radio" value="5" name="chk_val[<?=$cnt;?>]" <?php if($nilai==5){ print 'checked="checked"'; }?> 
                                    onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',5,'<?=$kursus_id;?>','')" /></td>
                            </tr>
							<?php } else if($rs_det->fields['f_penilaian_jawab']=='2'){ ?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td align="center" colspan="2"> Ya <input type="radio" value="1" name="chk_val[<?=$cnt;?>]" <?php if($nilai==1){ print 'checked="checked"'; }?> 
                                    onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',1,'<?=$kursus_id;?>','')" /></td>
                                <td align="center" colspan="3"> Tidak <input type="radio" value="2" name="chk_val[<?=$cnt;?>]" <?php if($nilai==2){ print 'checked="checked"'; }?> 
                                    onclick="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',2,'<?=$kursus_id;?>','')" /></td>
                            </tr>
							<?php } else if($rs_det->fields['f_penilaian_jawab']=='3'){ ?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left" colspan="6">
									<? echo stripslashes($rs_det->fields['f_penilaian_desc']);?><br />
                                    <textarea rows="10" cols="100" name="remarks" onchange="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',99,'<?=$kursus_id;?>','')"><?php print $pp_remarks;?></textarea>&nbsp;</td>
                            </tr>
                            <?php
							}
                            $cnt = $cnt + 1;
                           // $bil = $bil + 1;
                            $rs_det->movenext();
                        } 
                        $bil = $bil + 1;
					}
                    $rs->movenext();
                } 
            } ?>                   
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
