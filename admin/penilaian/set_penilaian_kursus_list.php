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
    <table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">

        <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat Latihan @ Tempat Kursus : </b></label>
            <div class="col-sm-12 col-md-7">
                <font color="#0033FF" style="font-weight:bold">
                    <?php print dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rs_kursus->fields['kampus_id'])); ?></font>
            </div>	        
        </div>

        <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kursus : </b></label>
            <div class="col-sm-12 col-md-7">
                <?php print $rs_kursus->fields['courseid'] . " - " .$rs_kursus->fields['coursename'];?></td>                
                <td rowspan="3" width="10%" align="right">
                <!--<img src="../images/printer_icon1.jpg" width="50" height="50" style="cursor:pointer" 
                onclick="open_modal('<?//=$href_borang;?>','Cetak borang penilian kursus',1,1)" title="Cetak borang penilaian kursus" />-->
                <!--<img src="../images/printer_icon1.jpg" width="50" height="50" style="cursor:pointer" 
                onclick="open_windows('<?//=$href_borang;?>');" title="Cetak borang penilaian kursus" />-->
                <!--<img src="../images/printer_icon1.jpg" width="50" height="50" style="cursor:pointer" 
                onclick="open_modal('<?//=$href_borang;?>','Cetak',90,90);" title="Cetak borang penilaian kursus" />-->
                
            </td>
        </div>

        <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori : </b></label>
            <div class="col-sm-12 col-md-7">
                    <?php print $rs_kursus->fields['categorytype'];?>
            </div>
        </div>

        <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat : </b></label>
            <div class="col-sm-12 col-md-7">
                <?php print $rs_kursus->fields['SubCategoryNm'];?>
            </div>                
        </div>

        <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tarikh Kursus : </b></label>
            <div class="col-sm-12 col-md-7">
                <?php echo date('d-m-Y', strtotime($rs->fields['startdate'])) ?> - <?php echo date('d-m-Y', strtotime($rs->fields['enddate'])) ?>
                <!-- <?php //print DisplayDate($rs_kursus->fields['startdate']);?> - <?php //print DisplayDate($rs_kursus->fields['enddate']);?></td>                 -->
            </div>
		</div>

        <div class="form-group row mb-4" style="float:right">
            <div>
            <a href="<?=$href_borang;?>" target="_blank"><button type="button" class="btn btn-primary" style="cursor:pointer; padding:9px;" ><i class="fas fa-print"></i></button></a>    
            </div>
        </div>

        <div class="card  col-md-12">
            <div class="card-header" >
                <h4>SENARAI MAKLUMAT RUJUKAN PENILAIAN KURSUS</h4>
            </div>
            <div class="card-body">
                <table width="100%" cellpadding="3" cellspacing="0" border="0">

                    <?php if($btn_display==1){ ?>
                        <!--<input type="button" value="Tambah Maklumat Bahagian" style="cursor:pointer" 
                        onclick="open_modal('<?//=$href_bahagian;?>','Penambahan Maklumat Bahagian',70,70)" />-->
                    <?php } ?>
                    </td>

                    <?php
                    $href_link = "modal_form.php?win=".base64_encode('penilaian/set_pilih.php;')."&id=".$id;
                    if(!$rs->EOF) {
                        while(!$rs->EOF) {
                            $id_bhg = $rs->fields['nilaib_id'];
                    ?>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="4">&nbsp;&nbsp;
                                    <b><label style="cursor:pointer" 
                                    <?php if($btn_display==1){ ?>
                                        onclick="open_modal('<?=$href_bahagian;?>&id_bhg=<?=$id_bhg;?>&pset_id=<?=$pset_id;?>','Penambahan Maklumat bahagian',70,70)"
                                    <?php } ?>>
                                    <u><?php echo stripslashes($rs->fields['nilai_keterangan']);?></u></label></b>
                                </th>
                                <th align="right">
                                    <?php if($btn_display==1){ ?>
                                    <!--<input type="button" value="Tambah Maklumat" style="cursor:pointer" 
                                    onclick="open_modal('<?=$href_link;?>&id_bhg=<?=$id_bhg;?>','Penambahan Maklumat Bahagian',80,80)" />-->
                                    <?php } ?>
                                </th>
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
                                <th width="5%" align="center"><b>Bil</b></th>
                                <th width="65%" align="center"><b>Maklumat Penilaian</b></th>
                                <th width="25%" align="center"><b>Kategori Penilaian</b></th>
                                <!-- <td width="5%" align="center"><b>&nbsp;</b></td>-->
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
                                    <!-- <td align="center">
                                    <?php if($btn_display==1){ ?>
                                    <img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                                    onclick="open_modal('<?=$href_link;?>&iddel=<?=$rs_det->fields['pset_detailid'];?>&proses=DEL&pset_id=<?=$id;?>','Hapus Maklumat Penilaian',200,200)" />
                                    <?php } ?>
                                    </td>-->
                                </tr>
                                <?php
                                $cnt = $cnt + 1;
                                // $bil = $bil + 1;
                                $rs_det->movenext();
                                } ?>
                        </tbody> 
                                <?php
                                    $cnt = $cnt + 1;
                                    $bil = $bil + 1;
                                    $rs->movenext();
                                } 
                            } ?>   
                        </table>                
                    </div>
                </table>
            </div>
        </div>
    </table>
</form>
