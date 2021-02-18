<?php
$uri = explode("?",$_SERVER['REQUEST_URI']);
$ruri = $_SERVER['REQUEST_URI'];
$URLs = $uri[1];
$proses = $_POST['proses'];
$ty = $_GET['ty'];
//print_r($uri);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
<script language="javascript" type="text/javascript">
function form_save(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}
function form_back(){
	parent.emailwindow.hide();
}
</script>
</head>
<body>
<?php
//$conn->debug=true;
if(!empty($_GET['pro']) && $_GET['pro']=='SAVE'){
	$idp = $_POST['idp'];
	$sqlu = "UPDATE _tbl_kursus_jadual_peserta SET surat_tawaran=".tosql($_POST['surat']). " WHERE InternalStudentId=".tosql($idp);
	$conn->execute($sqlu);
	print '<script language=javascript>parent.emailwindow.hide();</script>';
	exit;
}
$dir='';
$pathtoscript='../editor/';
include_once($dir."../editor/config.inc.php");
include_once($dir."../editor/FCKeditor/fckeditor.php") ;
$href_edit = "modal_form.php?win=".base64_encode('kursus/jadual_peserta_surat_edit.php;'.$rs_det->fields['InternalStudentId']);
$sSQL = "SELECT A.*, B.f_peserta_nama, B.BranchCd, B.f_peserta_noic, B.f_peserta_alamat1 
FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B WHERE A.peserta_icno=B.f_peserta_noic AND A.InternalStudentId=".tosql($id);
//print $sSQL; exit; 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
//$conn->debug=false;
$bil=0;
$surat='';
while(!$rs->EOF){ $bil++; 
	$surat = stripslashes($rs->fields['surat_tawaran']);
	//print $surat;
	$rs->movenext();
} 
if(empty($surat)){
	print "Sila pastikan anda telah melakukan proses jana surat tawaran";
}
?>
<form name="ilim" method="post">
<div class="printButton" align="center">
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="right">
    <input type="button" value="Simpan" onClick="form_save('<?=$href_edit;?>&pro=SAVE')" title="Please click to close window" style="cursor:pointer">
    <input type="button" value="Tutup" onClick="form_back()" title="Please click to close window" style="cursor:pointer">
    <input type="hidden" name="idp" value="<?=$id;?>" />
    </td></tr></table>
</div>
<table width="100%" border="1" cellpadding="3" cellspacing="0" align="center">
	<tr>
		<td align="left" valign="top" colspan="2"> <div class="rte"> 
		  <?  if ($wysiwyg===true){ 
                $oFCKeditor = new FCKeditor('surat_tawaran') ;
                $oFCKeditor->BasePath = $pathtoscript.'../editor/FCKeditor/';
                $oFCKeditor->Value = $surat;
                $oFCKeditor->Width = "100%";
                $oFCKeditor->Height = 450;
                $oFCKeditor->Create() ;
             } else {
              ?>
                  <textarea name="surat" cols="60" rows="5"><?php print $surat; ?></textarea>
             <? }?>
                </div>
            </td>    
    </tr>
</table>
</form>
</body>
</html>