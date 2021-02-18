<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
//$proses = $_GET['pro'];
$id_bhg=isset($_REQUEST["id_bhg"])?$_REQUEST["id_bhg"]:"";
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
function form_hapus(URL){
	if(confirm("Adakah anda pasti untuk menghapuskan rekod ini?")){
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
$sSQL="SELECT * FROM _tbl_nilai_bahagian  WHERE nilaib_id = ".tosql($id_bhg,"Number");
$rs = &$conn->Execute($sSQL);
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
                <td width="70%" colspan="2"><input type="text" size="70" name="nilai_keterangan" maxlength="120" value="<?php print $rs->fields['nilai_keterangan'];?>" /></td>
            </tr>
            <tr>
                <td><b>Susunan : </b></td>
                <td colspan="2">
                	<select name="nilai_sort">
                    	<option value="1" <? if($rs->fields['nilai_sort']=='1'){ print 'selected'; }?>> 1 </option>
                    	<option value="2" <? if($rs->fields['nilai_sort']=='2'){ print 'selected'; }?>> 2 </option>
                    	<option value="3" <? if($rs->fields['nilai_sort']=='2'){ print 'selected'; }?>> 3 </option>
                    	<option value="4" <? if($rs->fields['nilai_sort']=='3'){ print 'selected'; }?>> 4 </option>
                    	<option value="5" <? if($rs->fields['nilai_sort']=='5'){ print 'selected'; }?>> 5 </option>
                    	<option value="6" <? if($rs->fields['nilai_sort']=='6'){ print 'selected'; }?>> 6 </option>
                    	<option value="7" <? if($rs->fields['nilai_sort']=='7'){ print 'selected'; }?>> 7 </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Berdasarkan Pensyarah : </b></td>
                <td colspan="2">
                	<select name="is_pensyarah">
                    	<option value="0" <? if($rs->fields['is_pensyarah']=='0'){ print 'selected'; }?>> Tidak </option>
                    	<option value="1" <? if($rs->fields['is_pensyarah']=='1'){ print 'selected'; }?>> Ya </option>
                    </select>
                </td>
            </tr>
            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')" >
                    <input type="button" value="Hapus" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hapus('modal_form.php?<? print $URLs;?>&pro=DEL')" >
                    <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan kategori jawatan" onClick="form_back()" >
                    <input type="hidden" name="id_bhg" value="<?=$id_bhg?>" />
                    <input type="hidden" name="pset_id" value="<?=$pset_id?>" />
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
	$pset_id=isset($_REQUEST["pset_id"])?$_REQUEST["pset_id"]:"";
	$nilaib_id=isset($_REQUEST["id_bhg"])?$_REQUEST["id_bhg"]:"";
	$nilai_keterangan=isset($_REQUEST["nilai_keterangan"])?$_REQUEST["nilai_keterangan"]:"";
	$nilai_sort=isset($_REQUEST["nilai_sort"])?$_REQUEST["nilai_sort"]:"";
	$is_pensyarah=isset($_REQUEST["is_pensyarah"])?$_REQUEST["is_pensyarah"]:"";

	if(empty($id_bhg)){
		$sql = "INSERT INTO _tbl_nilai_bahagian (pset_id, nilai_keterangan, nilai_sort, is_pensyarah) 
		VALUES(".tosql($pset_id,"Text").", ".tosql($nilai_keterangan,"Text").", ".tosql($nilai_sort,"Number").", ".tosql($is_pensyarah,"Number").")";
		$rs = &$conn->Execute($sql);
	} else {
		if($proses=='DEL'){
			$sql = "DELETE FROM _tbl_nilai_bahagian_detail WHERE nilaib_id=".tosql($id_bhg,"Text");
			$rs = &$conn->Execute($sql);
			$sql = "DELETE FROM _tbl_nilai_bahagian WHERE nilaib_id=".tosql($id_bhg,"Text");
			$rs = &$conn->Execute($sql);
		} else {
			$sql = "UPDATE _tbl_nilai_bahagian  SET 
				nilai_keterangan=".tosql($nilai_keterangan,"Text").",
				nilai_sort=".tosql($nilai_sort,"Number").",
				is_pensyarah=".tosql($is_pensyarah,"Number")."
				WHERE nilaib_id=".tosql($id_bhg,"Text");
			$rs = &$conn->Execute($sql);
		}
	}
	
	//print $sql; exit;
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		</script>";
}
?>