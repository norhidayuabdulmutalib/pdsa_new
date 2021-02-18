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
//$id = 
$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate, D.penyelaras 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
//print $sSQL;

$sql_det = "SELECT * FROM _tbl_kursus_jadual_masa WHERE event_id=".tosql($id,"Text")." ORDER BY tarikh, masa_mula";
$rs_slot = $conn->execute($sql_det);
while(!$rs_slot->EOF){ $bil++; 
	$idh=$rs_slot->fields['id_jadmasa'];
	//$href_link_add = "modal_form.php?win=".base64_encode('kursus/jadual_peserta_list.php;'.$id);
	//$sql_det = "SELECT A.*, B.insname, B.insorganization FROM _tbl_kursus_jadual_det A, _tbl_instructor B WHERE A.instruct_id=B.ingenid AND A.event_id=".tosql($id,"Number");
	$sql_det = "SELECT DISTINCT A.*, B.f_peserta_nama, B.f_peserta_noic, B.BranchCd 
	FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B WHERE A.peserta_icno=B.f_peserta_noic AND A.is_selected=1 AND A.EventId=".tosql($id);
	$sql_det .= " GROUP BY B.f_peserta_noic";
	$sql_det .= " ORDER BY B.f_peserta_nama";
	$rs_det = $conn->execute($sql_det);
	//print $sql_det;
	$bil=0;
?>
<table width="100%" align="center" cellpadding="4" cellspacing="0" border="0">
    <tr><td colspan="3">
        <table width="96%" cellpadding="2" cellspacing="0" border="0" align="center">
	        <tr>
                <td width="25%" align="left"><b>Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="74%" align="left"><?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></td>                
            </tr>
            <tr>
                <td align="left"><b>Kategori</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rs->fields['categorytype'];?></td>                
            </tr>
            <tr>
                <td align="left"><b>Pusat</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rs->fields['SubCategoryNm'];?></td>                
            </tr>
            <tr>
                <td align="left"><b>Tarikh Kursus</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print DisplayDate($rs->fields['startdate']);?> hingga <?php print DisplayDate($rs->fields['enddate']);?></td>                
            </tr>
            <tr>
                <td align="left"><b>Penyelaras</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rs->fields['penyelaras'];?></td>                
            </tr>
		</table>
    </td>
	<tr><td colspan="3">
        <table width="100%" cellpadding="4" cellspacing="0" border="1" align="center">

            <tr bgcolor="#CCCCCC"><td colspan="5"><b>Senarai peserta bagi kursus : <?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></b></td></tr>
            <tr bgcolor="#CCCCCC"><td colspan="5">
            	<table width="100%" cellpadding="2" cellspacing="0" border="0">
                	<tr><td><b>Nama Penceramah : <?php print dlookup("_tbl_instructor","insname","ingenid=".tosql($rs_slot->fields['id_pensyarah']));?></b></td><td></td></tr>
                	<tr><td><b>Tajuk : <?php print $rs_slot->fields['tajuk'];?></b></td><td></td></tr>
                	<tr><td><b>Tarikh & Masa : <?php print DisplayDate($rs_det->fields['tarikh']);?> 
                    [ <?php print $rs_slot->fields['masa_mula']." - " . $rs_slot->fields['masa_tamat'];?> ]</b></td><td></td></tr>
                </table>
            </td></tr>
            <tr bgcolor="#CCCCCC">
                <td width="5%" align="center"><b>Bil</b></td>
                <td width="35%" align="center"><b>Nama Peserta</b></td>
                <td width="10%" align="center"><b>No. KP</b></td>
                <td width="35%" align="center"><b>Agensi/Jabatan/Unit</b></td>
                <td width="15%" align="center"><b>Tandatangan</b></td>
            </tr>
            <?php while(!$rs_det->EOF){ $bil++; ?>
            <tr>
                <td align="right"><?php print $bil;?>.&nbsp;</td>
                <td align="left"><?php print strtoupper($rs_det->fields['f_peserta_nama']);?>&nbsp;</td>
                <td align="left"><?php print $rs_det->fields['f_peserta_noic'];?>&nbsp;</td>
                <td align="left"><?php print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs_det->fields['BranchCd']));?>&nbsp;</td>
                <td align="center">&nbsp;</td>
            </tr>
            <?php $rs_det->movenext(); } ?>
        </table>
    </td></tr>
</table>
<div class="page-break">&nbsp;</div>
<?php $rs_slot->movenext(); } ?>
<div class="printButton" align="center">
	<br>
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
   	<input type="button" value="Print" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Close" onClick="do_close()" title="Please click to close window" style="cursor:pointer">
    <br>Please change the printing Orientation to <b>Landscape</b> before printing.
	<br /><br />
    </td></tr></table>
</div>
</body>
</html>
