<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
//$proses = $_GET['pro'];
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$msg='';
/*if(!empty($proses) && empty($_POST['id'])){
	//$category_code 	= strtoupper($_POST['category_code']);
	$f_gred_code=isset($_REQUEST["f_gred_code"])?$_REQUEST["f_gred_code"]:"";
	$sql = "SELECT * FROM _ref_titlegred WHERE f_gred_code=".tosql($f_gred_code,"Text"); 
	$rs_get = &$conn->Execute($sql);
	if($rs_get->recordcount()==0){
		
	} else {
		$proses=''; $msg = 'Rekod telah ada dalam pangkalan data anda.';
	}
}*/

if(empty($proses)){ 
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var kod = document.ilim.f_gred_code.value;
	var nama = document.ilim.f_gred_name.value;
	if(kod==''){
		alert("Sila masukkan kod gred jawatan terlebih dahulu.");
		document.ilim.f_gred_code.focus();
		return true;
	} else if(nama==''){
		alert("Sila masukkan nama jawatan terlebih dahulu.");
		document.ilim.f_gred_name.focus();
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
	$sSQL="SELECT * FROM _ref_titlegred WHERE f_gred_id = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">SELENGGARA MAKLUMAT GRED JAWATAN</td>
    </tr>
	<tr><td colspan="2">
    	<table width="96%" cellpadding="5" cellspacing="1" border="0" align="center">
        	<?php if(!empty($msg)){ ?>
            <tr>
                <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <?php } ?>
            <tr>
                <td width="30%"><b>Gred Jawatan : </b></td>
                <td width="50%" colspan="2"><input type="text" size="10" name="f_gred_code" value="<?php print $rs->fields['f_gred_code'];?>"/> <i>Cth: DG41</i></td>
            </tr>
            <tr>
                <td width="30%"><b>Diskripsi Gred Jawatan : </b></td>
                <td width="50%" colspan="2"><input type="text" size="60" name="f_gred_name" value="<?php print $rs->fields['f_gred_name'];?>" /></td>
            </tr>
            <!--<tr>
                <td width="30%"><b>Diskripsi Jawatan : </b></td>
                <td width="50%" colspan="2"><textarea name="f_gred_desc" rows="3" cols="50"><?php //print $rs->fields['f_gred_desc'];?></textarea></td>
            </tr>-->
            <tr>
                <td width="20%"><b>Kumpulan Jawatan : </b></td>
                <td width="50%" colspan="2">
                	<select name="f_jawatan">
                    	<option value="0" <?php if($rs->fields['f_jawatan']=='0'){ print 'selected'; }?>>-</option>
                    	<option value="1" <?php if($rs->fields['f_jawatan']=='1'){ print 'selected'; }?>>Sokongan</option>
                    	<option value="2" <?php if($rs->fields['f_jawatan']=='2'){ print 'selected'; }?>>P & P</option>
                    	<option value="3" <?php if($rs->fields['f_jawatan']=='3'){ print 'selected'; }?>>Jusa</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="20%"><b>Status : </b></td>
                <td width="50%" colspan="2">
                	<select name="f_status">
                    	<option value="0" <?php if($rs->fields['f_status']=='0'){ print 'selected'; }?>>Aktif</option>
                    	<option value="1" <?php if($rs->fields['f_status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                    </select>
                </td>
            </tr>
            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" >
                    <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai gred jawatan" onClick="form_back()" >
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
	document.ilim.f_gred_code.focus();
</script>
<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$f_gred_code=isset($_REQUEST["f_gred_code"])?$_REQUEST["f_gred_code"]:"";
	$f_gred_name=isset($_REQUEST["f_gred_name"])?$_REQUEST["f_gred_name"]:"";
	$f_gred_desc=isset($_REQUEST["f_gred_desc"])?$_REQUEST["f_gred_desc"]:"";
	$f_status=isset($_REQUEST["f_status"])?$_REQUEST["f_status"]:"";
	$f_jawatan=isset($_REQUEST["f_jawatan"])?$_REQUEST["f_jawatan"]:"";

	/*$id 			= $_POST['id'];
	$category_code 	= strtoupper($_POST['category_code']);
	$categorytype 	= $_POST['categorytype'];
	$status 		= $_POST['status'];*/
	//$conn->debug=true;
	if(empty($id)){
		$sql = "INSERT INTO _ref_titlegred(f_gred_code, f_gred_name, f_gred_desc, f_jawatan, f_status) 
		VALUES(".tosql(strtoupper($f_gred_code),"Text").", ".tosql(strtoupper($f_gred_name),"Text").", ".tosql($f_gred_desc,"Text").", 
		".tosql($f_jawatan,"Text").", ".tosql($f_status,"Number").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _ref_titlegred SET 
			f_gred_code=".tosql(strtoupper($f_gred_code),"Text").",
			f_gred_name=".tosql(strtoupper($f_gred_name),"Text").",
			f_gred_desc=".tosql($f_gred_desc,"Text").",
			f_jawatan=".tosql($f_jawatan,"Number").", 
			f_status=".tosql($f_status,"Number")."
			WHERE f_gred_id=".tosql($id,"Text");
		$rs = &$conn->Execute($sql);
	}
	//exit;
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		</script>";
}
?>