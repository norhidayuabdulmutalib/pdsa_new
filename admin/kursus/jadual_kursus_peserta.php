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
<script language='javascript1.2' src='../script/RemoteScriptServer.js'></Script>
<script language="javascript" type="text/javascript">
function do_terima1(ty,ids){
	var URL = 'kursus/jadual_kursus_peserta_hadir.php?ty=' + ty + '&ids=' + ids;
	/*alert(URL);
	document.hadir.action = URL;
	document.hadir.target = '_blank';
	document.hadir.submit();*/
	callToServer(URL);
	location.reload(true);

}
function do_terima(ty,ids){
	var URL = 'kursus/jadual_kursus_peserta_hadir.php?ty=' + ty + '&ids=' + ids;
	//if(confirm("Adakah anda pasti untuk menghapuskan data yang dipilih daripada senarai?")){
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Kemaskini Maklumat', 'width=200px,height=100px,center=1,resize=1,scrolling=0')
	//}
}

function open_windows1(URL){
	window.open (URL, "mywindow","location=1,status=1,scrollbars=1, width=90%,height=90%");
} //End "opennewsletter" function
function openModal(URL){
	//alert(URL);
	var height=screen.height-150;
	var width=screen.width-200;

	var returnValue = window.showModalDialog(URL, 'ILIM','help:no;status:yes;scroll:yes;resize:yes;toolbar=yes;dialogHeight:'+height+'px;dialogWidth:'+width+'px');
} 
function chk_pilih(URL,ids,pro){
	//alert(URL);
	if(confirm("Adakah anda pasti untuk membuat proses ini?")){
		document.hadir.ids.value=ids;
		document.hadir.pro.value=pro;
		document.hadir.action = URL;
		document.hadir.target = '_self';
		document.hadir.submit();
	}
}

</script>
</head>
<body>

<?php

$uri = explode("?",$_SERVER['REQUEST_URI']);
$ruri = $_SERVER['REQUEST_URI'];
$URLs = $uri[1];

$ids=isset($_REQUEST["ids"])?$_REQUEST["ids"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
if(!empty($ids) && !empty($pro)){
	if($pro=='DEL'){
		$sql = 'UPDATE _tbl_kursus_jadual_peserta SET is_selected=9 WHERE InternalStudentId='.tosql($ids);
	} else {
		$sql = 'UPDATE _tbl_kursus_jadual_peserta SET is_selected=1 WHERE InternalStudentId='.tosql($ids);
	}
	//print $sql;
	$conn->execute($sql);
}

//$conn->debug=true;
$sSQL="SELECT A.courseid, A.coursename, A.kampus_id, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Text");
$rs = $conn->query($sSQL);
//print $sSQL;

$href_link_mohon = "modal_form.php?win=".base64_encode('kursus/jadual_peserta_mohon.php;'.$id);
$href_link_add = "modal_form.php?win=".base64_encode('kursus/jadual_peserta_list.php;'.$id);
$href_peserta_add = "modal_form.php?win=".base64_encode('kursus/peserta_add.php;'.$id);
//$href_link_pro = "modal_form.php?win=".base64_encode('kursus/jadual_peserta_pro.php;'.$id);
$href_link_pro = "modal_form.php?win=".base64_encode('surat/jadual_peserta_pro1.php;'.$id);
$href_link_cetak = "modal_form.php?win=".base64_encode('kursus/jadual_kursus_peserta_cetak.php;');
//$sql_det = "SELECT A.*, B.insname, B.insorganization FROM _tbl_kursus_jadual_det A, _tbl_instructor B WHERE A.instruct_id=B.ingenid AND A.event_id=".tosql($id,"Number");

$sql_det = "SELECT DISTINCT(B.f_peserta_noic), A.*, B.f_peserta_nama, B.BranchCd, B.f_title_grade 
FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
WHERE A.peserta_icno=B.f_peserta_noic AND A.is_selected IN (1) AND A.EventId=".tosql($id);
//WHERE A.peserta_icno=B.f_peserta_noic AND A.is_selected IN (1,9) AND A.EventId=".tosql($id);
$sql_det .= " GROUP BY B.f_peserta_noic ORDER BY B.f_peserta_nama";
$rs_det = $conn->query($sql_det);
//print $sql_det;
$bil=0;
$conn->debug=false;
$curr_date = date("Y-m-d");
$end_date = $rs->fields['enddate'];
?>

<form name="hadir" method="post" action="">
<table width="100%" align="center" cellpadding="4" cellspacing="0" border="1">

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
            <!-- <?php// print DisplayDate($rs->fields['startdate']);?> - <?php //print DisplayDate($rs->fields['enddate']);?> -->
        </div>                
    </div>


    <!-- <tr><td colspan="3"><hr /></td></tr> -->

    <div class="card">
	<div class="card-header" >
		<h4>Senarai peserta bagi kursus :<?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></h4>
	</div>
		<div class="card-body">
 
            <?php 
            $href_cetak = "modal_print.php?win=".base64_encode('kursus/jadual_peserta_surat.php;'.$rs_det->fields['InternalStudentId']); 
            //$href_cetak = "modal_print.php?win=".base64_encode('kursus/jadual_peserta_surat_all.php;'.$rs->fields['id']);
            ?>
            <?php if($btn_display==1){ ?>
                <?php //if($end_date>$curr_date){ ?>

                <div class="form-group row mb-12">
                    <div class="col-sm-12 col-md-6">
                        Klik
                        <input type="button" class="btn btn-light" value="Proses Surat" style="cursor:pointer" 
                        onclick="open_modal1('<?php print $href_link_pro;?>','Proses surat tawaran kursus',1,1)" /> 
                            untuk menjana surat pengesahan kehadiran kursus.</i>
                        <!--Sila klik <input type="button" value="Proses Surat" style="cursor:pointer" 
                        onclick="openModal('<?php //print 'kursus/jadual_peserta_proses.php?id='.$id;?>')" /><br />-->
                    </div>
                        <!--<img src="../img/printer_icon1.jpg" width="40" height="30" title="Sila klik untuk cetakan Surat Panggilan Kursus" style="cursor:pointer"
                        onclick="open_modal1('<?php //print $href_cetak;?>&eventid=<?=$id;?>','Cetakan Surat Panggilan Kursus',1,1)" />-->
                        <br></br>
                        <?php } ?>
                    <div class="col-sm-12 col-md-3">
                     Sila Klik
                        <button type="button" class="btn btn-primary" style="cursor:pointer; padding:9px;" title="Sila klik untuk cetakan Surat Panggilan Kursus" style="cursor:pointer"
                        onclick="open_windows('<?php print $href_cetak;?>&eventid=<?=$id;?>')" ><i class="fas fa-print"></i></button> 
                            untuk cetakan.</i>
                        <!-- <img src="../img/printer_icon1.jpg" width="40" height="30" title="Sila klik untuk cetakan Surat Panggilan Kursus" style="cursor:pointer"
                        onclick="open_windows('<?php //print $href_cetak;?>&eventid=<?//=$id;?>')" />untuk cetakan. -->
                        <br></br>
                        <?php //} ?>
                    </div>
                </div>

                <div class="form-group row mb-12">
                    <div class="col-sm-12 col-md-2">
                        <img src="../images/ok.gif" border="0" style="cursor:pointer" title="Sila klik untuk membatalkan kehadiran bagi peserta ini"  /> Peserta Hadir : <br></br>
                    </div>
                    <div class="col-sm-12 col-md-5">
                        Sila klik 
                        <img src="../images/ok.gif" border="0" style="cursor:pointer" title="Sila klik untuk membatalkan kehadiran bagi peserta ini"  />
                            untuk membatalkan dan 
                        <img src="../images/off.gif" border="0" style="cursor:pointer" title="Sila klik untuk mengesahkan kehadiran peserta ini"  />
                            mengesahkan kehadiran.</i>
                    </div>
                </div>

                <div class="form-group row mb-12">
                    <div class="col-form-label text-md-right col-12 col-md-2 col-lg-1"></div>
                    <div class="col-sm-12 col-md-12">
                        <img src="../img/check.gif" width="15" height="15" style="cursor:pointer" /> Peserta Berjaya
                        <img src="../img/close.gif" width="15" height="15" style="cursor:pointer" /> Peserta Tidak Berjaya
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-right">
                                <th colspan="8">
                                    <?php //if($btn_display==1){ ?>
                                        
                                        <button type="button" class="btn btn-info" style="cursor:pointer; padding:10px;" title="Sila klik untuk cetakan senarai nama peserta kursus" style="cursor:pointer"  onclick="open_modal1('<?php print $href_link_cetak;?>&eventid=<?=$id;?>','Cetakan Senarai Nama Peserta',1,1)" ><i class="fas fa-print"></i></button>
                                        <!-- <img src="../img/printer_icon1.jpg" width="40" height="30" title="Sila klik untuk cetakan senarai nama peserta kursus" style="cursor:pointer"
                                        onclick="open_modal1('<?php // print $href_link_cetak;?>&eventid=<?//=$id;?>','Cetakan Senarai Nama Peserta',1,1)" />&nbsp; -->
                                        <?php //if($end_date>$curr_date){ ?>
                                        <input type="button" class="btn btn-warning" value="Pilih Peserta (On-Line)" style="cursor:pointer"
                                        onclick="open_modal1('<?php print $href_link_mohon;?>&ty=PE','Pilih Maklumat Peserta Daripada Senarai',85,85)" 
                                        title="Pilih peserta daripada senarai permohonan peserta"/>
                                        <input type="button" class="btn btn-warning" value="Pilih Peserta" style="cursor:pointer"
                                        onclick="open_modal1('<?php print $href_link_add;?>&ty=PE','Pilih Maklumat Peserta Daripada Senarai',85,85)" 
                                        title="Pilih peserta daripada senarai nama maklumat peserta berdaftar"/>
                                        <input type="button" class="btn btn-warning" value="Tambah Peserta Baru" style="cursor:pointer"
                                        onclick="open_modal1('<?php print $href_peserta_add;?>&ty=PE','Tambah Maklumat Peserta Baru',85,85)" 
                                        title="Tambah maklumat peserta baru ke senarai peserta"/>
                                        <?php //} ?>
                                    <?php //} ?>
                                </th>
                            </tr>

                            <tr>
                                <th width="5%" align="center"><b>Bil</b></th>
                                <th width="35%" align="center"><b>Nama Peserta</b></th>
                                <th width="5%" align="center"><b>Gred</b></th>
                                <th width="30%" align="center"><b>Agensi/Jabatan/Unit</b></th>
                                <th width="10%" align="center"><b>Proses</b></th>
                                <th width="5%" align="center"><b>Hadir</b></th>
                                <th width="5%" align="center"></th>
                                <th width="5%" align="center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while(!$rs_det->EOF){ $bil++; 
                                    $href_surat = "modal_form.php?win=".base64_encode('surat/view_jadual_peserta_surat.php;'.$rs_det->fields['InternalStudentId']);
                                    $href_penyelia = "modal_form.php?win=".base64_encode('surat/view_jadual_peserta_surat_peny.php;'.$rs_det->fields['InternalStudentId']);
                                    $href_edit = "modal_form.php?win=".base64_encode('kursus/jadual_peserta_surat_edit.php;'.$rs_det->fields['InternalStudentId']);
                                    $idh=$rs_det->fields['InternalStudentId'];
                                    $surat = stripslashes($rs_det->fields['surat_tawaran']);
                            ?>
                            <tr>
                                <td align="right"><?php print $bil;?>.&nbsp;</td>
                                <td align="left"><?php print $rs_det->fields['f_peserta_nama'];?><br /><i>No. KP: <?php print $rs_det->fields['f_peserta_noic'];?></i>&nbsp;
                                <?php //print $rs_det->fields['is_selected'];?>
                                </td>
                                <td align="center"><?php print dlookup("_ref_titlegred","f_gred_code","f_gred_id=".tosql($rs_det->fields['f_title_grade']));?>&nbsp;</td>
                                <td align="left"><?php print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs_det->fields['BranchCd']));?>&nbsp;</td>
                                <td align="center">
                                    <?php if(!empty($surat)){ ?>
                                    <img src="../images/btn_mail_bg.gif" border="0" style="cursor:pointer" width="25" height="22" title="Hantar email kepada peserta & penyelia"
                                    onclick="open_modal1('surat/email_kursus.php?idk=<?=$rs_det->fields['InternalStudentId'];?>','Hantar email kepada peserta & penyelia',85,85)" />
                                    <img src="../images/printicon.gif" border="0" style="cursor:pointer" width="25" height="22" 
                                        onclick="open_modal1('<?php print $href_surat;?>','Cetak Surat Tawaran Kursus',1,1)" title="Cetak surat tawaran kursus" />
                                    <img src="../images/printicon.gif" border="0" style="cursor:pointer" width="25" height="22" 
                                        onclick="open_modal1('<?php print $href_penyelia;?>','Cetak Surat Kepada Penyelia',1,1)" title="Cetak surat kepada penyelia" />
                                    <img src="../images/edit.png" border="0" style="cursor:pointer" width="20" height="20" 
                                        onclick="open_modal1('<?php print $href_edit;?>','Cetak Surat Tawaran Kursus',1,1)" title="Kemaskini maklumat surat pengesahan kursus" />
                                    <?php } else { print 'Surat belum dijana.'; }?>
                                </td>
                                <td align="center">
                                    <?php if($rs_det->fields['is_selected']<>9){ ?>
                                    <?php //if($btn_display==1){ ?>
                                    <?php if($rs_det->fields['InternalStudentAccepted']=='0' || empty($rs_det->fields['InternalStudentAccepted'])){ ?>
                                        <?php //if($end_date>$curr_date){ ?>
                                        <img src="../images/off.gif" border="0" style="cursor:pointer" title="Sila klik untuk mengesahkan kehadiran bagi peserta ini" 
                                        onclick="do_terima('HADIR','<?=$idh;?>')" />
                                        <?php //} ?>
                                    <?php } else if($rs_det->fields['InternalStudentAccepted']=='1'){ ?>
                                        <img src="../images/ok.gif" border="0" style="cursor:pointer" title="Sila klik untuk membatalkan kehadiran peserta ini" 
                                        onclick="do_terima('XHADIR','<?=$idh;?>')" />
                                    <?php } ?>
                                    <?php } else { ?>
                                    <?php if($rs_det->fields['InternalStudentAccepted']=='0' || empty($rs_det->fields['InternalStudentAccepted'])){ ?>
                                        <?php //if($end_date>$curr_date){ ?>
                                        <img src="../images/off.gif" border="0" style="cursor:pointer" />
                                        <?php //} ?>
                                    <?php } else if($rs_det->fields['InternalStudentAccepted']=='1'){ ?>
                                        <img src="../images/ok.gif" border="0" style="cursor:pointer" />
                                    <?php } ?>
                                    <?php //} ?>
                                    <?php } ?>
                                </td>
                                <td align="center">
                                    <?php if($rs_det->fields['is_selected']<>9){ ?>
                                    <?php if($btn_display==1){ ?>
                                    <?php //if($rs_det->fields['InternalStudentAccepted']=='0'){ ?>
                                    <?php //if($end_date>$curr_date){ ?>
                                    <?php if($_SESSION["s_level"]==1 || $_SESSION["s_level"]==2){ ?>
                                    <img src="../img/delete_btn1.jpg" border="0" width="22" height="22" style="cursor:pointer" onclick="do_hapus('SENARAI_P','<?=$idh;?>')" />
                                    <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                </td>
                                <td align="center">
                                    <?php if($rs_det->fields['is_selected']==9){ ?>
                                        <img src="../img/close.gif" width="15" height="15" style="cursor:pointer" onclick="chk_pilih('modal_form.php?<?=$URLs;?>','<?=$idh;?>','SEL')" />
                                    <?php } else { ?>
                                        <img src="../img/check.gif" width="15" height="15" style="cursor:pointer" onclick="chk_pilih('modal_form.php?<?=$URLs;?>','<?=$idh;?>','DEL')" />
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php $rs_det->movenext(); } ?>
                            <tr>
                                <td colspan="8" align="right">
                                    <?php if($btn_display==1){ ?>
                                    <?php if($end_date>$curr_date){ ?>
                                    <input type="button" value="Pilih Peserta" style="cursor:pointer" 
                                    onclick="open_modal1('<?php print $href_link_add;?>&ty=PE','Pilih Maklumat Peserta Daripada Senarai',85,85)" />
                                    <button type="button" class="btn btn-success" value="Tambah Peserta Baru" style="cursor:pointer" 
                                    onclick="open_modal1('<?php print $href_peserta_add;?>&ty=PE','Penambahan Maklumat Peserta',85,85)" ><i class="fas fa-plus"></i><b> Tambah Peserta Baru</b>
                                    <?php } ?>
                                    <?php } ?>
                                </td>
                            </tr>
                            <input type="hidden" name="pro" value="" />
                            <input type="hidden" name="ids" value="" />
                        </tbody>
                    </table>
                </div>
        </div>
</table>
    
</form>
</body>
</html>
