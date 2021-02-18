<?php
$uri = explode("?",$_SERVER['REQUEST_URI']);
$ruri = $_SERVER['REQUEST_URI'];
$URLs = $uri[1];
$prn=isset($_REQUEST["prn"])?$_REQUEST["prn"]:"";
if($prn=='WORD'){
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	include_once '../../common_prn.php';
	header("Content-Type: application/vnd.ms-word");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=surat_penceramah.doc");
}
$proses = $_POST['proses'];
$ty = $_GET['ty'];
//print_r($uri);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<!--<style type="text/css" media="all">@import"../../css/print_style.css";</style>-->
<style media="print" type="text/css">
/*body{FONT-SIZE: 14px;FONT-FAMILY: Arial;COLOR: #000000}*/
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
function form_back(){
	//parent.emailwindow.hide();
	window.close();
}
</script>
</head>
<body>
<?
$evid=isset($_REQUEST["evid"])?$_REQUEST["evid"]:"";
$href_surat = "modal_print.php?win=".base64_encode('kursus/surat_penceramah.php;'.$rs->fields['id']);
?>
<?php if($prn==''){ ?>
<div class="printButton" align="center">
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
   	<input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Salin Ke MS Word" onClick="do_pages('<?=$href_surat;?>&prn=WORD&evid=<?=$evid;?>')" style="cursor:pointer" />
    <input type="button" value="Tutup" onClick="form_back()" title="Please click to close window" style="cursor:pointer">
    <br>Please change the printing Orientation to <b>Potrait</b> before printing.
	<br />
    </td></tr></table>
</div>
<?php } ?>
<?php
//$conn->debug=true;

$sql_det = "SELECT A.*, B.insname, B.insorganization FROM _tbl_kursus_jadual_det A, _tbl_instructor B WHERE A.instruct_id=B.ingenid";
if(!empty($evid)){ $sql_det .= " AND A.event_id=".tosql($evid,"Text"); }
else { $sql_det .= " AND A.kur_eve_id=".tosql($id,"Text"); }
$rs_det = $conn->execute($sql_det);
while(!$rs_det->EOF){ $bil++; 
	//$idh=$rs_det->fields['kur_eve_id'];
	$ins = $rs_det->fields['instruct_id'];
	$event_id = $rs_det->fields['event_id'];
	$surat = stripslashes($rs_det->fields['surat_jemputan']);
	$sql_masa = "SELECT * FROM _tbl_kursus_jadual_masa WHERE event_id=".tosql($event_id,"Text")." AND id_pensyarah=".tosql($ins)." ORDER BY tarikh, masa_mula";
	$rs_masa = $conn->execute($sql_masa);

?>
<table width="96%" cellpadding="4" cellspacing="0" border="0" align="center">
	<tr><td height="30px">&nbsp;</td></tr>
    <tr><td>
	<?php print $surat; ?>
    <?php
	while(!$rs_masa->EOF){
		print '<table width=100% cellpading=3 cellspacing=0 border=0>';
		print "<tr><td width=10% valign=top>Tajuk : </td><td width=90%>".$rs_masa->fields['tajuk'].'</td></tr>';
		print "<tr><td valign=top>Tarikh : </td><td>".DisplayDate($rs_masa->fields['tarikh']).'</td></tr>';
		print "<tr><td valign=top>Masa : </td><td>".$rs_masa->fields['masa_mula']." - " . $rs_masa->fields['masa_tamat'].'</td></tr>';
		print "<tr><td>&nbsp;</td></tr></table>";
		$rs_masa->movenext();
	}
	?>
	</td></tr>
</table>
<table width="100%">
	<div style="page-break-after:always;">&nbsp;</div>
</table>
<?php $rs_det->movenext(); } ?>

<?php if($prn==''){ ?>
<form name="ilim" method="post">
<table width="96%" border="1" cellpadding="3" cellspacing="0" align="center">
</table>
</form>
<div class="printButton" align="center">
	<br>
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
   	<input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Salin Ke MS Word" onClick="do_pages('<?=$href_surat;?>&prn=WORD&evid=<?=$evid;?>')" style="cursor:pointer" />
    <input type="button" value="Tutup" onClick="form_back()" title="Please click to close window" style="cursor:pointer">
    <br>Please change the printing Orientation to <b>Potrait</b> before printing.
	<br /><br />
    </td></tr></table>
</div>
<?php } ?>
</body>
</html>