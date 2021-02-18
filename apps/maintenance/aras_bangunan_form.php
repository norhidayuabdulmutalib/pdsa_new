<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
//$proses = $_GET['pro'];
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$msg='';
if(empty($proses)){ 
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var nama = document.ilim.f_ab_desc.value;
	if(nama==''){
		alert("Sila masukkan rujukan kategori aras bangunan terlebih dahulu.");
		document.ilim.f_ab_desc.focus();
		return true;
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
}
function form_back(URL){
	parent.emailwindow.hide();
}

</script>
<?php
//print $_SERVER['HTTP_ACCEPT'];
if(!empty($id)){
	$sSQL="SELECT * FROM _ref_aras_bangunan  WHERE f_ab_id = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">SELENGGARA MAKLUMAT RUJUKAN ARAS BANGUNAN</td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
        	<?php if(!empty($msg)){ ?>
            <tr>
                <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <? } ?>
            <tr>
                <td width="30%"><b>Nama Aras Bangunan: </b></td>
                <td width="50%" colspan="2"><input type="text" size="50" name="f_ab_desc" value="<?php print $rs->fields['f_ab_desc'];?>" /></td>
            </tr>
            <tr>
                <td width="20%"><b>Status : </b></td>
                <td width="50%" colspan="2">
                	<select name="f_ab_status">
                    	<option value="0" <? if($rs->fields['f_ab_status']=='0'){ print 'selected'; }?>>Aktif</option>
                    	<option value="1" <? if($rs->fields['f_ab_status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                    </select>
                </td>
            </tr>
            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')" >
                    <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan kategori jawatan" onClick="form_back()" >
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                </td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.f_ab_desc.focus();
</script>
<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$f_ab_desc=isset($_REQUEST["f_ab_desc"])?$_REQUEST["f_ab_desc"]:"";
	$f_ab_status=isset($_REQUEST["f_ab_status"])?$_REQUEST["f_ab_status"]:"";

	if(empty($id)){
		$sql = "INSERT INTO _ref_aras_bangunan (f_ab_desc, f_ab_status) 
		VALUES(".tosql($f_ab_desc,"Text").", ".tosql($f_ab_status,"Number").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _ref_aras_bangunan  SET 
			f_ab_desc=".tosql($f_ab_desc,"Text").",
			f_ab_status=".tosql($f_ab_status,"Number")."
			WHERE f_ab_id=".tosql($id,"Text");
		$rs = &$conn->Execute($sql);
	}
	
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		</script>";
}
?>