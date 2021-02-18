<?php
@session_start();
$prn=isset($_REQUEST["prn"])?$_REQUEST["prn"]:"";
$ty=isset($_REQUEST["ty"])?$_REQUEST["ty"]:"";
if($prn=='WORD'){
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	include_once '../common.php';
	header("Content-Type: application/vnd.ms-word");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=surat_tawaran.doc");
}
//$conn->debug=true;
$proses = $_POST['proses'];
$ty = $_GET['ty'];
//print_r($uri);
//print $ty;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
<head>
<title></title>
<style media="print" type="text/css">
body{FONT-SIZE: 14px;FONT-FAMILY: Arial;COLOR: #000000; width:100%;}
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
	parent.emailwindow.hide();
	//window.close();
}

function form_close(){
	window.close();
}
</script>
</head>
<body>
<form name="ilim" method="post">
<?php
//$href_surat = "modal_print.php?win=".base64_encode('kursus/jadual_peserta_surat.php;'.$rs->fields['id']);
//$href_surat = "modal_print.php?win=".base64_encode('surat/view_jadual_peserta_surat.php;'.$rs->fields['id']);
$href_surat = "surat/view_jadual_peserta_surat.php?prn=WORD&id=".$rs->fields['id'];
?>
<div class="printButton" align="center">
<?php if($prn<>'WORD'){ ?>
<table border="0" align="center" cellpadding="1" cellspacing="0">
	<tr><td>
    	<input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    	<!--<input type="button" value="Salin Ke MS Word" onClick="do_pages('kursus/jadual_peserta_surat.php?prn=WORD&id=<?=$id;?>')" style="cursor:pointer" />-->
    	<input type="button" value="Salin Ke MS Word" onClick="do_pages('<?=$href_surat;?>&prn=WORD&id=<?=$id;?>')" style="cursor:pointer" />
        <input type="button" value="Tutup" onClick="<?php if($ty=='S'){ ?>form_close();<?php } else { ?>form_back();<?php } ?>" style="cursor:pointer">
        <input type="hidden" name="n" value="<?=$n;?>" />
        <input type="hidden" name="a" value="<?=$a;?>" />
        <input type="hidden" name="t" value="<?=$t;?>" />
	</td></tr>
</table>
<?php } ?>
</div>
</form>
<?php
//$conn->debug=true;
$sSQL = "SELECT A.*, B.f_peserta_nama, B.BranchCd, B.f_peserta_noic, B.f_peserta_alamat1 
FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B WHERE A.peserta_icno=B.f_peserta_noic AND A.InternalStudentId=".tosql($id);
//print $sSQL; exit; 
$rs = &$conn->Execute($sSQL);
//$cnt = $rs->recordcount();
//$conn->debug=false;
$bil=0;
$surat='';
while(!$rs->EOF){ $bil++; 
	$surat = stripslashes($rs->fields['surat_tawaran']);
	print $surat;
	$rs->movenext();
} 
if(empty($surat)){
	print "Sila pastikan anda telah melakukan proses jana surat tawaran";
}
?>
<!--<div class="printButton" align="center">
	<br>
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
   	<input type="button" value="Print" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Close" onClick="do_close()" title="Please click to close window" style="cursor:pointer">
    <br>Please change the printing Orientation to <b>Potrait</b> before printing.
	<br /><br />
    </td></tr></table>
</div>-->
</body>
</html>