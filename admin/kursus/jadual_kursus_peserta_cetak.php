<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetakan Jadual</title>
<script language="javascript" type="text/javascript">	
function do_close(){
	parent.emailwindow.hide();
	//window.close();
}
function handleprint(){
	window.print();
}
</script>
<style type="text/css" media="all">@import"../../css/print_style.css";</style>
<style media="print" type="text/css">
	body{FONT-SIZE: 10px;FONT-FAMILY: Arial;COLOR: #000000}
	.printButton { display: none; }

@media all{
 .page-break { display:none; }
}

@media print{
 .page-break { display:block; page-break-before:always; }
}
</style>
</head>
<body>
<?php
//$conn->debug=true;
$id = $_GET['eventid'];
$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
//print $sSQL;

$sql_det = "SELECT A.*, B.f_peserta_nama, B.BranchCd, B.f_peserta_noic, B.f_title_grade, B.f_peserta_tel_pejabat, B.f_peserta_faks 
FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B WHERE A.peserta_icno=B.f_peserta_noic AND A.is_selected IN (1) AND A.EventId=".tosql($id);
//$sql_det .= " ORDER BY B.f_peserta_nama"; //AND A.is_selected IN (1,9)
$sql_det .= " GROUP BY B.f_peserta_noic ORDER BY B.f_peserta_nama";
$rs_det = $conn->execute($sql_det);
//print $sql_det;
$bil=0;
?>

<div class="card">
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="8">
                        <b>Senarai peserta bagi kursus :<br /><?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></b>
                        <br>Kategori : <?php print $rs->fields['categorytype'];?>
                        <br>Tarikh : <?php echo date('d-m-Y', strtotime($rs->fields['startdate'])) ?> - <?php echo date('d-m-Y', strtotime($rs->fields['enddate'])) ?>
                        <!-- <?php //print DisplayDate($rs->fields['startdate']);?> - <?php //print DisplayDate($rs->fields['enddate']);?> -->
                    </th>
                </tr>
                <tr class="text-right">
                    <th colspan="8">
                    <?php if($btn_display==1){ ?>
                        <img src="../img/printer_icon1.jpg" width="40" height="30" title="Sila klik untuk cetakan senarai nama peserta kursus" style="cursor:pointer"
                        onclick="open_modal1('<?php print $href_link_add;?>&ty=PE','Cetakan Senarai Nama Peserta',1,1)" />&nbsp;
                        <input type="button" value="Tambah Maklumat Peserta" style="cursor:pointer"
                        onclick="open_modal1('<?php print $href_link_add;?>&ty=PE','Penambahan Maklumat Peserta',85,85)" />
                        <?php } ?>
                    </th>
                </tr>

                <!-- <div style="float:right">
                    <?php if($btn_display==1){ ?>
                        <img src="../img/printer_icon1.jpg" width="40" height="30" title="Sila klik untuk cetakan senarai nama peserta kursus" style="cursor:pointer"
                        onclick="open_modal1('<?php print $href_link_add;?>&ty=PE','Cetakan Senarai Nama Peserta',1,1)" />&nbsp;
                        <input type="button" value="Tambah Maklumat Peserta" style="cursor:pointer"
                        onclick="open_modal1('<?php print $href_link_add;?>&ty=PE','Penambahan Maklumat Peserta',85,85)" />
                    <?php } ?>
                    </div>
                </td>
                </tr> -->

                <tr>
                    <th width="5%" align="center"><b>Bil</b></th>
                    <th width="40%" align="center"><b>Nama Peserta</b></th>
                    <th width="10%" align="center"><b>Gred</b></th>
                    <th width="40%" align="center"><b>Agensi/Jabatan/Unit</b></th>
                    <th width="10%" align="center"><b>No. Tel/Faks</b></th>
                </tr>
            </thead>
            <tbody>
                <?php while(!$rs_det->EOF){ $bil++; 
                    $idh=$rs_det->fields['InternalStudentId'];
                ?>
                <tr>
                    <td align="right"><?php print $bil;?>.&nbsp;</td>
                    <td align="left"><?php print $rs_det->fields['f_peserta_nama'];?>
                    <!--<br /><i>No. KP: <?php //print $rs_det->fields['f_peserta_noic'];?></i>-->&nbsp;</td>
                    <td align="center"><?php print dlookup("_ref_titlegred","f_gred_code","f_gred_id=".tosql($rs_det->fields['f_title_grade']));?>&nbsp;</td>
                    <td align="left"><?php print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs_det->fields['BranchCd']));?>&nbsp;</td>
                    <td><?php print "Tel:".$rs_det->fields['f_peserta_tel_pejabat']."<br>Faks:".$rs_det->fields['f_peserta_faks'];?></td>
                </tr>
                <?php $rs_det->movenext(); } ?>
                <tr>
                <div class="printButton" align="center">
                    <br>
                    <table width="100%"><tr><td width="100%" align="center">
                        <input type="button" class="btn btn-info"value="Print" onClick="handleprint()" style="cursor:pointer" />
                        <input type="button" class="btn btn-secondary" value="Close" onClick="do_close()" title="Please click to close window" style="cursor:pointer">
                        <br>Please change the printing Orientation to <b>Landscape</b> before printing.
                        <br /><br />
                        </td></tr>
                    </table>
                </div>
            </tbody>
        </table>      
    </div>          
</div>
</div>
