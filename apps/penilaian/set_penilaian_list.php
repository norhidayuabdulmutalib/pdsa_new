<?
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$sSQL="SELECT * FROM _tbl_nilai_bahagian WHERE pset_id=".tosql($id);
$sSQL .= " ORDER BY nilai_sort";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_bahagian = "modal_form.php?win=".base64_encode('penilaian/set_penilaian_kursus_bahagian.php;')."&pset_id=".$id;
$href_borang = "modal_form.php?win=".base64_encode('penilaian/cetak_borang_penilaian.php;')."&pset_id=".$id;

?>
<? include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="96%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr><td colspan="3">
        <table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
            <tr valign="top" bgcolor="#80ABF2"> 
                <td height="22" colspan="4" valign="middle" width="80%">
                <font size="2" face="Arial, Helvetica, sans-serif">
                    &nbsp;&nbsp;<strong>SENARAI MAKLUMAT RUJUKAN PENILAIAN KURSUS</strong></font>
                </td>
                <td width="20%" align="right" valign="middle">
                  <input type="button" value="Tambah Maklumat Bahagian" style="cursor:pointer" 
                    onclick="open_modal('<?=$href_bahagian;?>','Penambahan Maklumat Bahagian',70,70)" />
                &nbsp;&nbsp;
                </td>
            </tr>
            <?
			$href_link = "modal_form.php?win=".base64_encode('penilaian/set_pilih.php;')."&id=".$id;
            if(!$rs->EOF) {
                while(!$rs->EOF) {
                    $id_bhg = $rs->fields['nilaib_id'];
            ?>
                <tr height="25px" bgcolor="#666666">
                    <td colspan="4">&nbsp;&nbsp;<b><label style="cursor:pointer" 
                    <?php //if($btn_display==1){ ?>
                    	onclick="open_modal('<?=$href_bahagian;?>&id_bhg=<?=$id_bhg;?>&pset_id=<?=$pset_id;?>','Penambahan Maklumat bahagian',70,70)"
                    <?php //} ?>>
                    <u><? echo stripslashes($rs->fields['nilai_keterangan']);?></u></label></b></td>
                    <td align="right">
                    <?php //if($btn_display==1){ ?>
                    <input type="button" value="Tambah Maklumat" style="cursor:pointer" 
                    onclick="open_modal('<?=$href_link;?>&id_bhg=<?=$id_bhg;?>','Penambahan Maklumat Bahagian',80,80)" />
                    <?php //} ?>
                    &nbsp;</td>
                </tr>
                <?php
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
                                <td width="60%" align="center"><b>Maklumat Penilaian</b></td>
                                <td width="30%" align="center"><b>Kategori Penilaian</b></td>
                                <td width="5%" align="center"><b>&nbsp;</b></td>
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
                                    <td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                    <td valign="top" align="center"><? echo stripslashes($kat_penilaian);?><br /><i><?php print $set;?></i>&nbsp;</td>
                                    <td align="center">
                                    <?php //if($btn_display==1){ ?>
                                    <img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                                    onclick="open_modal('<?=$href_link;?>&iddel=<?=$rs_det->fields['pset_detailid'];?>&proses=DEL&pset_id=<?=$id;?>','Hapus Maklumat Penilaian',200,200)" />
                                    <?php //} ?>
                                    </td>
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
    <tr><td colspan="5">	
<?
if($cnt<>0){
	$sFileName=$href_search;
	include_once 'include/list_footer.php'; 
}
?> 
</td></tr>
<tr><td>        
</td></td>
</table> 
</form>
