<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
//$proses = $_GET['pro'];
$pset_id=isset($_REQUEST["pset_id"])?$_REQUEST["pset_id"]:"";
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$msg='';
if(empty($proses)){ 
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var nama = document.ilim.nilai_keterangan.value;
	if(nama==''){
		alert("Sila masukkan maklumat bahagian terlebih dahulu.");
		document.ilim.nilai_keterangan.focus();
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
	$sSQL="SELECT * FROM _tbl_nilai_bahagian  WHERE nilaib_id = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">SET PENILAIAN KURSUS - MAKLUMAT BAHAGIAN</td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
        	<?php if(!empty($msg)){ ?>
            <tr>
                <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <? } ?>
            <tr>
                <td width="30%"><b>Maklumat Bahagian : </b></td>
                <td width="50%" colspan="2"><input type="text" size="50" name="nilai_keterangan" maxlength="120" value="<?php print $rs->fields['nilai_keterangan'];?>" /></td>
            </tr>
            <tr>
                <td width="20%"><b>Susunan : </b></td>
                <td width="50%" colspan="2">
                	<select name="nilai_sort">
                    	<option value="1" <? if($rs->fields['nilai_sort']=='1'){ print 'selected'; }?>> 1 </option>
                    	<option value="2" <? if($rs->fields['nilai_sort']=='2'){ print 'selected'; }?>> 2 </option>
                    	<option value="3" <? if($rs->fields['nilai_sort']=='2'){ print 'selected'; }?>> 3 </option>
                    	<option value="4" <? if($rs->fields['nilai_sort']=='3'){ print 'selected'; }?>> 4 </option>
                    	<option value="5" <? if($rs->fields['nilai_sort']=='5'){ print 'selected'; }?>> 5 </option>
                    </select>
                </td>
            </tr>
            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')" >
                    <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan kategori jawatan" onClick="form_back()" >
                    <input type="text" name="nilaib_id" value="<?=$nilaib_id?>" />
                    <input type="text" name="pset_id" value="<?=$pset_id?>" />
                </td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.nilai_keterangan.focus();
</script>
<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$pset_id=isset($_REQUEST["pset_id"])?$_REQUEST["pset_id"]:"";
	$nilaib_id=isset($_REQUEST["nilaib_id"])?$_REQUEST["nilaib_id"]:"";
	$nilai_keterangan=isset($_REQUEST["nilai_keterangan"])?$_REQUEST["nilai_keterangan"]:"";
	$nilai_sort=isset($_REQUEST["nilai_sort"])?$_REQUEST["nilai_sort"]:"";

	if(empty($nilaib_id)){
		$sql = "INSERT INTO _tbl_nilai_bahagian (pset_id, nilai_keterangan, nilai_sort) 
		VALUES(".tosql($pset_id,"Text").", ".tosql($nilai_keterangan,"Text").", ".tosql($nilai_sort,"Number").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _tbl_nilai_bahagian  SET 
			nilai_keterangan=".tosql($nilai_keterangan,"Text").",
			nilai_sort=".tosql($nilai_sort,"Number")."
			WHERE nilaib_id=".tosql($nilaib_id,"Text");
		$rs = &$conn->Execute($sql);
	}
	
	//print $sql; exit;
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		parent.location.reload();
		</script>";
}
?>