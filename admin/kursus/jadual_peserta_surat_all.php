<?php
$prn=isset($_REQUEST["prn"])?$_REQUEST["prn"]:"";
if($prn=='WORD'){
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	include_once '../../common_prn.php';
	header("Content-Type: application/vnd.ms-word");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=surat_tawaran.doc");
}
//$conn->debug=true;
$proses = $_POST['proses'];
$ty = $_GET['ty'];
//print_r($uri);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<!--<title>Untitled Document</title>
<style type="text/css" media="all">@import"../../css/printsurat.css";</style>-->
<style media="print" type="text/css">
body{FONT-SIZE: 14px;FONT-FAMILY: Arial;COLOR: #000000;
width:98%;}
.printButton { display: none; }

@media all{
 .page-break { display:none; }
}

@media print{
 .page-break { display:block; page-break-before:always; }
}
</style>
<script language="javascript" type="text/javascript">	
function do_pages(URL){
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}
function handleprint(){
	window.print();
}
</script>
</head>
<div class="printButton" align="center">
<form name="ilim" method="post">
<?
$href_surat = "modal_print.php?win=".base64_encode('kursus/jadual_peserta_surat_all.php;'.$rs->fields['id']);
?>
<table border="0" align="center" cellpadding="1" cellspacing="0">
	<tr><td>
    	<input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    	<!--<input type="button" value="Salin Ke MS Word" onClick="do_pages('kursus/jadual_peserta_surat_all.php?prn=WORD&id=<?=$id;?>')" style="cursor:pointer" />-->
    	<input type="button" value="Salin Ke MS Word" onClick="do_pages('<?=$href_surat;?>&prn=WORD&id=<?=$id;?>')" style="cursor:pointer" />
        <input type="button" value="Tutup" onClick="javascript:window.close();" style="cursor:pointer">
        <input type="hidden" name="n" value="<?=$n;?>" /><input type="hidden" name="a" value="<?=$a;?>" /><input type="hidden" name="t" value="<?=$t;?>" />
	</td></tr>
</table>
</form>
</div>
<!--<div class="printButton" align="center">
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
   	<input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Tutup" onClick="form_back()" title="Please click to close window" style="cursor:pointer">
    <br>Please change the printing Orientation to <b>Potrait</b> before printing.
	<br />
    </td></tr></table>
</div>-->
<table width="96%" cellpadding="4" cellspacing="0" border="0" align="center">
    <tr><td>
<?php
//$conn->debug=true;
$sSQL = "SELECT fld_surat FROM _tbl_kursus_jadual WHERE id=".tosql($id);
//print $sSQL; exit; 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
//$conn->debug=false;
$bil=0;
$surat='';
while(!$rs->EOF){ $bil++; 
	$surat = stripslashes($rs->fields['fld_surat']);
	print $surat;
	$rs->movenext();
} 
if(empty($surat)){
	print "Sila pastikan anda telah melakukan proses jana surat tawaran";
}
?>
<div class="page-break">&nbsp;</div>
<?
//$conn->debug=true;
//$id = $_GET['eventid'];
$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Text");
$rs = &$conn->execute($sSQL);

$sql_det = "SELECT A.*, B.f_peserta_nama, B.BranchCd, B.f_peserta_noic, B.f_title_grade 
FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
WHERE A.peserta_icno=B.f_peserta_noic AND A.is_selected IN (1,9) AND A.EventId=".tosql($id);
$sql_det .= " GROUP BY B.f_peserta_noic ORDER BY B.f_peserta_nama";
$rs_det = $conn->execute($sql_det);
//print $sql_det;
$bil=0;
?>
</td></tr></table>
<br />
<table width="96%" cellpadding="4" cellspacing="0" border="1" align="center">
    <tr bgcolor="#CCCCCC">
        <td colspan="3" valign="top">
            <div style="float:left">
            <b>Senarai peserta bagi kursus :<br /><?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></b>
            <br />Tarikh : <?php print DisplayDate($rs->fields['startdate']);?> - <?php print DisplayDate($rs->fields['enddate']);?>
            </div>
    	</td>
    </tr>
    <tr bgcolor="#CCCCCC">
        <td width="5%" align="center"><b>Bil</b></td>
        <td width="45%" align="center"><b>Nama Peserta</b></td>
        <td width="50%" align="center"><b>Agensi/Jabatan/Unit</b></td>
    </tr>
    <?php while(!$rs_det->EOF){ $bil++; 
        $idh=$rs_det->fields['InternalStudentId'];
    ?>
    <tr>
        <td align="right"><?php print $bil;?>.&nbsp;</td>
        <td align="left"><?php print $rs_det->fields['f_peserta_nama'];?>&nbsp;</td>
        <td align="left"><?php print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs_det->fields['BranchCd']));?>&nbsp;</td>
    </tr>
    <?php $rs_det->movenext(); } ?>
</table>

<div class="printButton" align="center">
	<br>
<table border="0" align="center" cellpadding="1" cellspacing="0">
	<tr><td>
    	<input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    	<!--<input type="button" value="Salin Ke MS Word" onClick="do_pages('kursus/jadual_peserta_surat_all.php?prn=WORD&id=<?=$id;?>')" style="cursor:pointer" />-->
    	<input type="button" value="Salin Ke MS Word" onClick="do_pages('<?=$href_surat;?>&prn=WORD&id=<?=$id;?>')" style="cursor:pointer" />
        <input type="button" value="Tutup" onClick="javascript:window.close();" style="cursor:pointer">
        <input type="hidden" name="n" value="<?=$n;?>" /><input type="hidden" name="a" value="<?=$a;?>" /><input type="hidden" name="t" value="<?=$t;?>" />
	</td></tr>
</table>
</div>
</body>
</html>