<? include '../../common.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetakan Jadual</title>
<script language="javascript" type="text/javascript">	
function do_close(){
	//parent.emailwindow.hide();
	window.close();
}
function handleprint(){
	window.print();
}
</script>
<style media="all" type="text/css">
	body{FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000}
</style>
<style media="print" type="text/css">
	body{FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000}
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
$id = $_GET['id'];
$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm , D.objektif, D.jadual_masa, D.kandungan, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Next");
$rs = &$conn->Execute($sSQL);
//print $sSQL;
$objektif = $rs->fields['objektif'];
$jadual_masa = $rs->fields['jadual_masa'];
$kandungan = $rs->fields['kandungan'];

$sql_det = "SELECT * FROM _tbl_kursus_jadual_masa WHERE event_id=".tosql($id,"Text")." ORDER BY tarikh, masa_mula";
$rs_det = $conn->execute($sql_det);
?>
<table width="100%" align="center" cellpadding="4" cellspacing="0" border="0">
    <?php while(!$rs_det->EOF){ $bil++; 
		$idh=$rs_det->fields['id_jadmasa'];
		if($tkh != $rs_det->fields['tarikh']){ $disp_tkh = DisplayDate($rs_det->fields['tarikh']); } else { $disp_tkh=''; }
	?>
    <tr>
        <td align="center" valign="top" width="15%"><?php print $disp_tkh;?></td>
        <td align="center" valign="top" width="15%"><?php print $rs_det->fields['masa_mula']." -<br>" . $rs_det->fields['masa_tamat'];?> &nbsp;</td>
        <td align="left" valign="top" width="70%">
		<?php
			if($rs_det->fields['id_pensyarah']=='0'){
				print 'REHAT';
			} else {
				print 'Penceramah : '.dlookup("_tbl_instructor","insname","ingenid=".tosql($rs_det->fields['id_pensyarah']));
				print '<br />';
				print 'Tajuk : '.$rs_det->fields['tajuk'];
			}
         ?>
        </td>
        <td align="center">
        	<?php if($btn_display==1){ ?>
			<img src="../img/delete_btn1.jpg" border="0" style="cursor:pointer" onclick="do_hapus('jadual_kursus_maklumat','<?=$idh;?>')" />
            <?php } ?>
        </td>
    </tr>
    <?php	$tkh = $rs_det->fields['tarikh']; 
		$rs_det->movenext(); } ?>
</table>
<br /><br />
<table width="100%" align="center" cellpadding="4" cellspacing="0" border="0">
	<tr><td><b><U>OBJEKTIF KURSUS</U></b></td></tr>
	<tr><td style="text-align:justify"><?php print  stripslashes($objektif);?></td></tr>
	<tr><td>&nbsp;<br /></td></tr>
	<tr><td><b><U>KANDUNGAN KURSUS</U></b></td></tr>
	<tr><td style="text-align:justify"><?php print  stripslashes($kandungan);?></td></tr>
</table>
<?php
$sSQL="SELECT * FROM _ref_kandungan WHERE idkandungan = 'TERMA'";
$rs = &$conn->Execute($sSQL);
?>
<br /><br />
<table width="100%" align="center" cellpadding="4" cellspacing="0" border="0">
	<tr><td><b><U>SYARAT_SYARAT KEHADIRAN</U></b></td></tr>
	<tr><td style="text-align:justify"><?php print  stripslashes($rs->fields['maklumat']);?></td></tr>
</table>

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
