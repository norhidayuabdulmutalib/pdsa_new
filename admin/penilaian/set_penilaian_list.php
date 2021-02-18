<?php
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

<?php include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<div class="card">
	<div class="card-header" >
		<h4>SENARAI MAKLUMAT RUJUKAN PENILAIAN KURSUS</h4>
            <input type="button" class="btn btn-success" value="Tambah Maklumat Bahagian" style="cursor:pointer" 
            onclick="open_modal('<?=$href_bahagian;?>','Penambahan Maklumat Bahagian',70,70)" />
	</div>
		<div class="card-body">

            <?php
			$href_link = "modal_form.php?win=".base64_encode('penilaian/set_pilih.php;')."&id=".$id;
            if(!$rs->EOF) {
                while(!$rs->EOF) {
                    $id_bhg = $rs->fields['nilaib_id'];
            ?>
                <tr height="25px" bgcolor="#CCCC99">
                    <td colspan="4">&nbsp;&nbsp;<b>Bahagian : <label style="cursor:pointer" 
                    title="Sila klik untuk kemaskini maklumat tajuk bahagian" 
                    <?php //if($btn_display==1){ ?>
                    	onclick="open_modal('<?=$href_bahagian;?>&id_bhg=<?=$id_bhg;?>&pset_id=<?=$pset_id;?>','Penambahan Maklumat bahagian',70,70)"
                    <?php //} ?>>
                    <u><?php echo stripslashes($rs->fields['nilai_keterangan']);?></u></label></b></td>

                    <td align="right">
                    <?php //if($btn_display==1){ ?>
                    <input type="button" class="btn btn-success" value="Tambah Maklumat" style="cursor:pointer" 
                    onclick="open_modal('<?=$href_link;?>&id_bhg=<?=$id_bhg;?>','Penambahan Maklumat Bahagian',80,80)" />
                    <?php //} ?>
                    &nbsp;</td>
                </tr>
                        <br></br>
                <?php
                $sql_det = "SELECT A.*, B.f_penilaian_desc, B.f_penilaianid, B.f_penilaian_jawab FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B
                WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.nilaib_id=".tosql($id_bhg);
                $rs_det = &$conn->Execute($sql_det);
                $bil=0;
                ?>
                

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                        <thead>
                            <th width="5%" align="center"><b>Bil</b></th>
                            <th width="60%" align="center"><b>Maklumat Penilaian</b></th>
                            <th width="30%" align="center"><b>Kategori Penilaian</b></th>
                            <th width="5%" align="center"><b>Tindakan</b></th>
                        </tr>
                        </thead>
                        <tbody>
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
                                <td align="center">
                                <?php //if($btn_display==1){ ?>
                                <img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                                onclick="open_modal('<?=$href_link;?>&iddel=<?=$rs_det->fields['pset_detailid'];?>&proses=DEL&pset_id=<?=$id;?>','Hapus Maklumat Penilaian',200,200)" />
                                <?php //} ?>
                                </td>
                            </tr>
                            <?php
                            $cnt = $cnt + 1;
                        // $bil = $bil + 1;
                            $rs_det->movenext();
                            } ?>
                        </tbody> 
                    </table>
                </div>
                            
                <?php
                    $cnt = $cnt + 1;
                    $bil = $bil + 1;
                    $rs->movenext();
                } 
            } ?>                   

        <tr><td colspan="5">	
        <?php
        if($cnt<>0){
            $sFileName=$href_search;
            include_once 'include/list_footer.php'; 
        }
        ?> 
        </td></tr> 
</div>
</form>
