<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="../modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="../modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../modalwindow/dhtmlwindow.js">
/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<script type="text/javascript" src="../modalwindow/modal.js"></script>
<script language="javascript" type="text/javascript">	
function open_modal1(URL,title,width,height){
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, title, 'width='+width+'px,height='+height+'px,center=1,resize=1,scrolling=0')
} //End "opennewsletter" function
</script>
</head>
<body>
<?php
$currdate = date("Y-m-d");
$sSQL="SELECT A.courseid, A.coursename, A.kampus_id, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Next");
$rs = &$conn->Execute($sSQL);
//print $sSQL;

$href_link_add = "modal_form.php?win=".base64_encode('kursus/jadual_penceramah_list.php;'.$id);
$sql_det = "SELECT A.*, B.insname, B.insorganization FROM _tbl_kursus_jadual_det A, _tbl_instructor B WHERE A.instruct_id=B.ingenid AND A.event_id=".tosql($id,"Text");
$rs_det = $conn->execute($sql_det);
$bil=0;
//print $sql_det;
?>

<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat Latihan @ Tempat Kursus : </b></label>
        <div class="col-sm-12 col-md-7">
        <font color="#0033FF" style="font-weight:bold">
            <?php print dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rs->fields['kampus_id'])); ?></font>
        </div>
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kursus : </b></label>
        <div class="col-sm-12 col-md-7">
            <?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?>
        </div>                
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori : </b></label>
        <div class="col-sm-12 col-md-7">
            <?php print $rs->fields['categorytype'];?>
        </div>                
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat : </b></label>
        <div class="col-sm-12 col-md-7">
            <?php print $rs->fields['SubCategoryNm'];?>
        </div>                
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tarikh Kursus : </b></label>
        <div class="col-sm-12 col-md-7">
            <?php echo date('d-m-Y', strtotime($rs->fields['startdate'])) ?> - <?php echo date('d-m-Y', strtotime($rs->fields['enddate'])) ?>
            <!-- <?php //print DisplayDate($rs->fields['startdate']);?> - <?php// print DisplayDate($rs->fields['enddate']);?> -->
        </div>
    </div>


    <tr><td colspan="3"><hr /></td></tr>
    
    <div class="card">
        <div class="card-header" >
            <h4>Senarai penceramah & fasilatitor bagi kursus : <?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%" align="center"><b>Bil</b></th>
                        <th width="40%" align="center"><b>Nama Penceramah / Fasilitator</b></th>
                        <th width="35%" align="center"><b>Agensi/Jabatan/Unit</b></th>
                        <th width="10%" align="center"><b>Bidang Tugas</b></th>
                        <th width="10%" align="center"><b>Tindakan</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while(!$rs_det->EOF){ $bil++; 
                        $idh=$rs_det->fields['kur_eve_id'];
                        $href_surat_penceramah = "modal_form.php?win=".base64_encode('kursus/surat_penceramah.php;'.$rs_det->fields['kur_eve_id']);
                    ?>
                    <tr>
                        <td align="right"><?php print $bil;?>.&nbsp;</td>
                        <td align="left"><?php print $rs_det->fields['insname'];?>&nbsp;</td>
                        <td align="left"><?php print $rs_det->fields['insorganization'];?>&nbsp;</td>
                        <td align="left"><?php if($rs_det->fields['instruct_type']=='PE'){ print 'Penceramah'; } else if($rs_det->fields['instruct_type']=='FA'){ print 'Fasilitator'; }?>&nbsp;</td>
                        <td align="center">
                    <?php if($btn_display==1){ ?>
                            <img src="../img/delete_btn1.jpg" border="0" width="20" height="20" style="cursor:pointer" onclick="do_hapus('jadual_kursus_ceramah','<?=$idh;?>')" />
                            &nbsp;
                            <img src="../img/printer_icon1.jpg" width="23" height="23" style="cursor:pointer" 
                            title="Sila klik untuk mencetak Cetak surat jemputan kepada Penceramah @ Pensyarah" 
                            onclick="openModal('<?=$href_surat_penceramah;?>','Cetak surat jemputan kepada Penceramah @ Pensyarah',1,1)" />
                        <?php } ?>
                        &nbsp;</td>
                    </tr>
                    <?php $rs_det->movenext(); } ?>
                </tbody>
                </table>
            </div>
            <div>
                <div colspan="5" align="right">
                    <?php if($btn_display==1){ ?>
                        <button type="button" class="btn btn-success" value="Tambah Maklumat Penceramah" style="cursor:pointer" 
                        onclick="open_modal1('<?php print $href_link_add;?>&ty=PE','Penambahan Maklumat Penceramah',80,80)" ><i class="fas fa-plus"></i><b> Tambah Maklumat Penceramah</b></button>
                        <button type="button" class="btn btn-success" value="Tambah Maklumat Fasilitator" style="cursor:pointer" 
                        onclick="open_modal1('<?php print $href_link_add;?>&ty=FA','Penambahan Maklumat Fasilitator',80,80)" ><i class="fas fa-plus"></i><b> Tambah Maklumat Fasilitator</b>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</table>
</body>
</html>
