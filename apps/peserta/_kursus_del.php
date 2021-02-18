<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
//$proses = $_GET['pro'];
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$idp=isset($_REQUEST["idp"])?$_REQUEST["idp"]:"";
$msg='Adakah anda pasti untuk memadam maklumat?';
if(empty($proses)){ 
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
		document.ilim.action = URL;
		document.ilim.submit();
}
function form_back(URL){
	parent.emailwindow.hide();
}
</script>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">PADAM MAKLUMAT AKADEMIK PESERTA</td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
        	<?php if(!empty($msg)){ ?>
            <tr>
                <td align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <? } ?>
            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Ya" class="button_disp" title="Sila klik untuk padam maklumat" onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=DEL')" >
                    <input type="button" value="Tidak" class="button_disp" title="Sila klik untuk kembali" onClick="form_back()" >
                    <input type="hidden" name="idp" value="<?=$idp?>" />
				</td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<?php } else {
	//print 'simpan';
	//$conn->debug=true;
	include '../loading_pro.php';
	$idp=$_POST["idp"];
	if(!empty($idp)){
		$sql = "DELETE FROM _tbl_kursus_jadual_peserta WHERE InternalStudentId=".tosql($idp,"Text");
		$rs = &$conn->Execute($sql);
	}
	//print $sql; exit;
	print "<script language=\"javascript\">
		alert('Rekod telah dipadam');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		</script>";
}
?>