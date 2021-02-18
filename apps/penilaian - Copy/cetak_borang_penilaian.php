<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?
//$conn->debug=true;
$id=isset($_REQUEST["pset_id"])?$_REQUEST["pset_id"]:"";
$sSQL="SELECT * FROM _tbl_nilai_bahagian WHERE pset_id=".tosql($id);
$sSQL .= " ORDER BY nilai_sort";
/*$sSQL="SELECT A.*, B.f_penilaian, C.pset_detailid FROM _ref_penilaian_maklumat A, _ref_penilaian_kategori B, _tbl_penilaian_det_detail C 
WHERE A.f_penilaianid=B.f_penilaianid AND A.is_deleted=0 AND A.f_penilaian_detailid=C.f_penilaian_detailid AND C.pset_id=".tosql($id_set);
$sSQL .= " ORDER BY A.f_penilaianid, A.f_penilaian_desc";*/
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
        <td height="30" colspan="5" valign="middle" align="center" width="100%">
	        <img src="../images/crestmalaysia.gif" width="50" height="35" border="0" /><br /><br />
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
                    <td width="50%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="40%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>
                <tr bgcolor="#CCCCCC">
                    <td width="8%" align="center" valign="bottom"><b>Amat Tidak setuju</b></td>
                    <td width="8%" align="center" valign="bottom"><b>Tidak setuju</b></td>
                    <td width="8%" align="center" valign="bottom"><b>Kurang Setuju</b></td>
                    <td width="8%" align="center" valign="bottom"><b>Setuju</b></td>
                    <td width="8%" align="center" valign="bottom"><b>Sangat Setuju</b></td>
                </tr>
            <?
            if(!$rs->EOF) {
                while(!$rs->EOF) {
					 $id_bhg = $rs->fields['nilaib_id'];
					 $is_pensyarah = $rs->fields['is_pensyarah'];
					 $nilai_sort = $rs->fields['nilai_sort'];
					 $jump=0;
            ?>
	            <tr height="25px" bgcolor="#666666">
                    <td colspan="7">&nbsp;&nbsp;<b><label><? echo stripslashes($rs->fields['nilai_keterangan']);?></label></b></td>
                </tr>
                <?php
                    if($is_pensyarah==1){
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
							}

                            print '<tr height="25px" bgcolor="#CCCCCC">
                                <td colspan="7" align="left"><b><div style="border-bottom:thin;border-bottom-style:dotted;">Penceramah : '.$bil_pensyarah.'</div></b>
								<b>Nama Penceramah : '.stripslashes($rs_pensyarah->fields['insname']).'
                                <br>Tajuk : '.stripslashes($rs_pensyarah->fields['tajuk']).'</b></td>
                            </tr>';
							print '<tr bgcolor="#CCCCCC">
									<td width="5%" align="center" rowspan="2"><b>Bil</b></td>
									<td width="40%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
								</tr>
								<tr bgcolor="#CCCCCC">
									<td width="10%" align="center" valign="bottom"><b>Amat Tidak setuju</b></td>
									<td width="9%" align="center" valign="bottom"><b>Tidak setuju</b></td>
									<td width="9%" align="center" valign="bottom"><b>Kurang Setuju</b></td>
									<td width="9%" align="center" valign="bottom"><b>Setuju</b></td>
									<td width="9%" align="center" valign="bottom"><b>Sangat Setuju</b></td>
								</tr>';
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

								?>
								<tr bgcolor="#FFFFFF">
									<td valign="top" align="right"><?=$bil;?>.</td>
									<td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
									<td align="center"> 1 </td>
									<td align="center"> 2 </td>
									<td align="center"> 3 </td>
									<td align="center"> 4 </td>
									<td align="center"> 5 </td>
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

							if($rs_det->fields['f_penilaian_jawab']=='1'){
							?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td align="center"> 1 </td>
                                <td align="center"> 2 </td>
                                <td align="center"> 3 </td>
                                <td align="center"> 4 </td>
                                <td align="center"> 5 </td>
                            </tr>
							<?php } else if($rs_det->fields['f_penilaian_jawab']=='2'){ ?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td align="center" colspan="2"> Ya <input type="checkbox" /></td>
                                <td align="center" colspan="3"> Tidak  <input type="checkbox" /></td>
                            </tr>
							<?php } else if($rs_det->fields['f_penilaian_jawab']=='3'){ ?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left" colspan="6">
									<? echo stripslashes($rs_det->fields['f_penilaian_desc']);?><br />
                                    <textarea rows="10" cols="100"></textarea>&nbsp;</td>
                            </tr>
							<?php } else { ?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td align="center"> 1 </td>
                                <td align="center"> 2 </td>
                                <td align="center"> 3 </td>
                                <td align="center"> 4 </td>
                                <td align="center"> 5 </td>
                            </tr>
							<?php }
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
    <br />
    <b>Sila berikan cadangan bagi meningkatkan mutu kursus ini :</b><br />
    <br /><div style="border-bottom:thin;border-bottom-style:dotted;">1. </div>
    <br /><div style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</div>
    <br /><div style="border-bottom:thin;border-bottom-style:dotted;">2. </div>
    <br /><div style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</div>
    <br /><div style="border-bottom:thin;border-bottom-style:dotted;">3. </div>
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
