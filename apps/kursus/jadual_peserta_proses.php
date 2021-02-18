<?php
include_once '../../common.php'; 
//include_once '../common.php'; 
$conn->debug=true;
//$uri = explode("?",$_SERVER['REQUEST_URI']);
//$ruri = $_SERVER['REQUEST_URI'];
//$URLs = $uri[1];
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$proses=isset($_REQUEST["proses"])?$_REQUEST["proses"]:"";
//$ty=isset($_REQUEST["ty"])?$_REQUEST["ty"]:"";
//print_r($uri);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script language="javascript" type="text/javascript">
function do_proses(URL){
	alert(URL);
	document.ilim.action=URL;
	document.ilim.submit();
}
function form_back(){
	parent.emailwindow.hide();
}
</script>
</head>
<body>
<?php
$dir='';
$pathtoscript='../../editor/';
include_once($dir."../../editor/config.inc.php");
include_once($dir."../../editor/FCKeditor/fckeditor.php") ;

$href_link_pro = "modal_form.php?win=".base64_encode('kursus/jadual_peserta_pro.php;'.$id);
$save=$_GET['act'];
if(!empty($save) && $save=='SAVE'){
	$conn->execute("UPDATE ref_surat SET surat_1=".tosql($_POST['surat'])." WHERE kod_surat='SAH_HADIR'");
}
$rs = $conn->execute("SELECT * FROM ref_surat WHERE kod_surat='SAH_HADIR'");
if(!$rs->EOF){ $bil++; 
	$surat = stripslashes($rs->fields['surat_1']);
	//print $surat;
	$rs->movenext();
} 
?>
	<form name="ilim" method="post">
	<table width="98%" border="1" cellpadding="3" cellspacing="0" align="center">
		<tr><td height="20px" align="right">
			<input type="button" value="Proses Surat" style="cursor:pointer" onclick="do_proses('jadual_peserta_proses.php?id=<?=$id;?>&proses=PRO')" />&nbsp;&nbsp;
			<input type="button" value="Simpan" style="cursor:pointer" onclick="do_proses('../kursus/jadual_peserta_pros.php?id=<?=$id;?>')" />&nbsp;&nbsp;
			<!--<input type="button" value="Proses Surat" style="cursor:pointer" onclick="do_proses('<?=$href_link_pro;?>&proses=PRO')" />&nbsp;&nbsp;
			<input type="button" value="Simpan" style="cursor:pointer" onclick="do_proses('<?=$href_link_pro;?>&act=SAVE')" />&nbsp;&nbsp;-->
            <input type="button" value="Tutup" style="cursor:pointer" onclick="form_back()" />
		</td></tr>
        <tr>
            <td align="left" valign="top"> <div class="rte"> 
              <?  if ($wysiwyg===true){ 
                    $oFCKeditor = new FCKeditor('surat') ;
                    $oFCKeditor->BasePath = $pathtoscript.'../../editor/FCKeditor/';
                    $oFCKeditor->Value = $surat;
                    $oFCKeditor->Width = "100%";
                    $oFCKeditor->Height = 430;
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