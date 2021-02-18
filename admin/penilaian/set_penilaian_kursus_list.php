<?php
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$sSQL="SELECT A.courseid, A.coursename, A.kampus_id, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Text");
$rs_kursus = &$conn->Execute($sSQL);

//$sSQL="SELECT * FROM _tbl_nilai_bahagian WHERE pset_id=".tosql($id);
$sSQL="SELECT B.* FROM _tbl_penilaian_set A, _tbl_nilai_bahagian B WHERE A.pset_id=B.pset_id AND A.pset_status=0";
$sSQL .= " ORDER BY B.nilai_sort ASC, B.nilaib_id ASC";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$href_bahagian = "modal_form.php?win=".base64_encode('penilaian/set_penilaian_kursus_bahagian.php;')."&pset_id=".$id;
$href_borang = "modal_form.php?win=".base64_encode('penilaian/cetak_borang_penilaian.php;')."&pset_id=".$id;
?>
<?php include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="4" cellspacing="0" border="1">
    <tr><td colspan="3">
        <table width="96%" cellpadding="4" cellspacing="0" border="0" align="center">
			<tr>
                <td width="25%" align="right"><b>Pusat Latihan @ Tempat Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td align="left"><font color="#0033FF" style="font-weight:bold">
                    <?php print dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rs_kursus->fields['kampus_id'])); ?></font>
                </td>	        
            </tr>
	        <tr>
                <td width="20%" align="right"><b>Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="69%" align="left" colspan="2"><?php print $rs_kursus->fields['courseid'] . " - " .$rs_kursus->fields['coursename'];?></td>                
                <td rowspan="3" width="10%" align="right">
                <!--<img src="../images/printer_icon1.jpg" width="50" height="50" style="cursor:pointer" 
                onclick="open_modal('<?=$href_borang;?>','Cetak borang penilian kursus',1,1)" title="Cetak borang penilaian kursus" />-->
                <!--<img src="../images/printer_icon1.jpg" width="50" height="50" style="cursor:pointer" 
                onclick="open_windows('<?=$href_borang;?>');" title="Cetak borang penilaian kursus" />-->
                <!--<img src="../images/printer_icon1.jpg" width="50" height="50" style="cursor:pointer" 
                onclick="open_modal('<?=$href_borang;?>','Cetak',90,90);" title="Cetak borang penilaian kursus" />-->
                <a href="<?=$href_borang;?>" target="_blank"><img src="../images/printer_icon1.jpg" width="50" height="50" style="cursor:pointer" /></a>
                
                </td>
            </tr>
            <tr>
                <td align="right"><b>Kategori</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rs_kursus->fields['categorytype'];?></td> 
            </tr>
            <tr>
                <td align="right"><b>Pusat</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rs_kursus->fields['SubCategoryNm'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Tarikh Kursus</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print DisplayDate($rs_kursus->fields['startdate']);?> - <?php print DisplayDate($rs_kursus->fields['enddate']);?></td>                
            </tr>
		</table>
    </td></tr>
	<tr><td colspan="3">
        <table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
            <tr valign="top" bgcolor="#80ABF2"> 
                <td height="25" colspan="4" valign="middle" width="80%">
                <font size="2" face="Arial, Helvetica, sans-serif">
                    &nbsp;&nbsp;<strong>SENARAI MAKLUMAT RUJUKAN PENILAIAN KURSUS</strong></font>
                </td>
                <td width="20%" align="right" valign="middle">
                <?php if($btn_display==1){ ?>
                  <!--<input type="button" value="Tambah Maklumat Bahagian" style="cursor:pointer" 
                    onclick="open_modal('<?=$href_bahagian;?>','Penambahan Maklumat Bahagian',70,70)" />-->
                <?php } ?>&nbsp;&nbsp;
                </td>
            </tr>
            <?
			$href_link = "modal_form.php?win=".base64_encode('penilaian/set_pilih.php;')."&id=".$id;
            if(!$rs->EOF) {
                while(!$rs->EOF) {
                    $id_bhg = $rs->fields['nilaib_id'];
            ?>
            <tr><td colspan="5">&nbsp;</td></tr>
                <tr height="25px" bgcolor="#666666">
                    <td colspan="4">&nbsp;&nbsp;<b><label style="cursor:pointer" 
                    <?php if($btn_display==1){ ?>
                    	onclick="open_modal('<?=$href_bahagian;?>&id_bhg=<?=$id_bhg;?>&pset_id=<?=$pset_id;?>','Penambahan Maklumat bahagian',70,70)"
                    <?php } ?>>
                    <u><?php echo stripslashes($rs->fields['nilai_keterangan']);?></u></label></b></td>
                    <td align="right">
                    <?php if($btn_display==1){ ?>
                    <!--<input type="button" value="Tambah Maklumat" style="cursor:pointer" 
                    onclick="open_modal('<?=$href_link;?>&id_bhg=<?=$id_bhg;?>','Penambahan Maklumat Bahagian',80,80)" />-->
                    <?php } ?>
                    &nbsp;</td>
                </tr>
                <?php
                /*$sql_det = "SELECT A.*, B.f_penilaian_desc, C.f_penilaian FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B, _ref_penilaian_kategori C
                WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND B.f_penilaianid=C.f_penilaianid AND A.nilaib_id=".tosql($id_bhg);*/
                $sql_det = "SELECT A.*, B.f_penilaian_desc, B.f_penilaianid, B.f_penilaian_jawab FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B
                WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.nilaib_id=".tosql($id_bhg);
                $rs_det = &$conn->Execute($sql_det);
                $bil=0;
                ?>
                <tr>
                    <td colspan="5" align="center">
                        <table width="100%" border="1" cellpadding="5" cellspacing="0">
                            <tr bgcolor="#CCCCCC">
                                <td width="5%" align="center"><b>Bil</b></td>
                                <td width="65%" align="center"><b>Maklumat Penilaian</b></td>
                                <td width="25%" align="center"><b>Kategori Penilaian</b></td>
                               <!-- <td width="5%" align="center"><b>&nbsp;</b></td>-->
                            </tr>
                        <?php while(!$rs_det->EOF){ 
                                $bil++;
								$kat_penilaian = dlookup("_ref_penilaian_kategori","f_penilaian","f_penilaianid=".tosql($rs_det->fields['f_penilaianid']));
								if($rs_det->fields['f_penilaianid']=='A'){ $kat_penilaian='Keseluruhan Kursus'; }
								else if($rs_det->fields['f_penilaianid']=='B'){ $kat_penilaian='Cadangan Penambahbaikan'; }
							
								//$kat_penilaian = dlookup("_ref_penilaian_kategori","f_penilaian","f_penilaianid=".tosql($rs_det->fields['f_penilaianid']));
								if($rs_det->fields['f_penilaian_jawab']=='1'){ $set = 'Set 5 Pilihan'; }
								else if($rs_det->fields['f_penilaian_jawab']=='2'){ $set = 'Set Ya / Tidak'; } 
								else if($rs_det->fields['f_penilaian_jawab']=='3'){ $set = 'Set Jawapan Bertulis'; } 
								else { $set = '&nbsp;'; }
                                ?>
                                <tr>
                                    <td valign="top" align="right"><?=$bil;?>.</td>
                                    <td valign="top" align="left"><?php echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                    <td valign="top" align="center"><?php echo stripslashes($kat_penilaian);?><br /><i><?php print $set;?></i>&nbsp;</td>
                                    <!-- <td align="center">
                                   <?php if($btn_display==1){ ?>
                                    <img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                                    onclick="open_modal('<?=$href_link;?>&iddel=<?=$rs_det->fields['pset_detailid'];?>&proses=DEL&pset_id=<?=$id;?>','Hapus Maklumat Penilaian',200,200)" />
                                    <?php } ?>
                                    </td>-->
                                </tr>
                                <?
                                $cnt = $cnt + 1;
                               // $bil = $bil + 1;
                                $rs_det->movenext();
                                } ?>
                        </table> 
                    </td>
                </tr>
                <?
                    $cnt = $cnt + 1;
                    $bil = $bil + 1;
                    $rs->movenext();
                } 
            } ?>                   
		</table>
     </td></tr>
</table> 
</form>
