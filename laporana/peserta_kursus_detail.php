<? include '../common.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/template-css.css" rel="stylesheet" type="text/css" media="screen">
<title>Sistem Maklumat Latihan Bersepadu ILIM</title>
<script language="javascript" type="text/javascript">	
function do_close(){
	//parent.emailwindow.hide();
	window.close();
}
function handleprint(){
	window.print();
}
function do_open(URL){
	document.ilim.action = URL;
	document.ilim.target = '_blank';
	document.ilim.submit();
}
</script>
<style type="text/css" media="all">@import"css/print_style.css";</style>
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
$id=isset($_REQUEST["eventid"])?$_REQUEST["eventid"]:"";
$hadir=isset($_REQUEST["hadir"])?$_REQUEST["hadir"]:"";
$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
//print $sSQL;

$sql_det = "SELECT DISTINCT A.*, B.f_peserta_nama, B.BranchCd, B.f_peserta_noic, B.f_title_grade 
FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
WHERE A.is_selected=1 AND A.peserta_icno=B.f_peserta_noic AND B.is_deleted=0 AND A.EventId=".tosql($id);
if(!empty($hadir) && $hadir=='hadir'){ $sql_det .= " AND A.InternalStudentAccepted=1"; }
if(!empty($hadir) && $hadir=='xhadir'){ $sql_det .= " AND A.InternalStudentAccepted=0"; }
$sql_det .= " GROUP BY B.f_peserta_noic ORDER BY B.f_peserta_nama";
$rs_det = $conn->execute($sql_det);
//print $sql_det;
$bil=0;
$conn->debug=false;
?>
<table width="100%">
    <tr><td width="100%">
        <table width="100%" align="center">
            <tr>
              <td align="center" width="15%">
                <div style="float:left"><img src="../images/crestmalaysia.gif" border="0" width="90" height="68" /></div>
              </td>
              <td align="center" width="70%">
                <div><h3><I><B>INSTITUT LATIHAN ISLAM MALAYSIA<BR>JABATAN KEMAJUAN ISLAM MALAYSIA</B></I></h3></div>
              </td>
              <td align="center" width="15%">
                <div style="float:right">&nbsp;</div>
              </td>
            </tr>
        </table>
    </td></tr>
</table>
<table width="96%" cellpadding="4" cellspacing="0" border="0" align="center" class="data">
    <tr>
        <td valign="top" width="25%"><b>Kategori Kursus :</b></td>
        <td width="75%"><?php print $rs->fields['categorytype'];?></td>
    </tr>
    <tr>
        <td valign="top"><b>Sub Kategori :</b></td>
        <td><?php print $rs->fields['SubCategoryNm'];?></td>
    </tr>
    <tr>
        <td valign="top"><b>Subjek :</b></td>
        <td><?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></td>
    </tr>
    <tr>
        <td valign="top"><b>Tarikh :</b></td>
        <td><?php print DisplayDate($rs->fields['startdate']);?> - <?php print DisplayDate($rs->fields['enddate']);?></td>
    </tr>
</table>
<table width="96%" cellpadding="4" cellspacing="0" border="1" align="center" class="data">
    <tr bgcolor="#CCCCCC">
        <td width="5%" align="center"><b>Bil</b></td>
        <td width="10%" align="center"><b>No KP</b></td>
        <td width="45%" align="center"><b>Nama Peserta</b></td>
        <td width="5%" align="center"><b>Gred</b></td>
        <td width="35%" align="center"><b>Agensi/Jabatan/Unit</b></td>
        <?php if($hadir=='hadir'){ ?>
        <td width="5%">Kehadiran</td>
        <td width="5%">Sijil</td>
        <?php } ?>
    </tr>
    <?php while(!$rs_det->EOF){ $bil++; 
        $idh=$rs_det->fields['InternalStudentId'];
		if($rs_det->fields['InternalStudentAccepted']==1){ $kehadiran='Hadir'; } else { $kehadiran='-'; }
		if($rs_det->fields['is_sijil']==1){ $sijil='Ada'; } else { $sijil='-'; }
    ?>
    <tr>
        <td align="right"><?php print $bil;?>.&nbsp;</td>
        <td align="left"><?php print $rs_det->fields['f_peserta_noic'];?>&nbsp;</td>
        <td align="left"><?php print $rs_det->fields['f_peserta_nama'];?>&nbsp;</td>
        <td align="center"><?php print dlookup("_ref_titlegred","f_gred_code","f_gred_id=".tosql($rs_det->fields['f_title_grade']));?>&nbsp;</td>
        <td align="left"><?php print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs_det->fields['BranchCd']));?>&nbsp;</td>
        <?php if($hadir=='hadir'){ ?>
        <td align="center"><?php print $kehadiran;?></td>
        <td align="center"><?php print $sijil;?></td>
        <?php } ?>
    </tr>
    <?php $rs_det->movenext(); } ?>
</table>
<div class="printButton" align="center">
	<form name="ilim" method="post" action="">
	<br>
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
    <input type="button" value="Salin Ke Excel" onClick="do_open('../laporana/peserta_kursus_detail_excel.php?eventid=<?=$id;?>&hadir=<?=$hadir;?>')" style="cursor:pointer" />
   	<input type="button" value="Print" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Close" onClick="do_close()" title="Please click to close window" style="cursor:pointer">
    <br>Please change the printing Orientation to <b>Landscape</b> before printing.
	<br /><br />
    </td></tr></table>
    </form>
</div>
</body>
</html>
