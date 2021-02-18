<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
//$proses = $_GET['pro'];
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$msg='';
if(!empty($proses) && empty($_POST['id'])){
	//$category_code 	= strtoupper($_POST['category_code']);
	$f_tbcode=isset($_REQUEST["ref_kt_kod"])?$_REQUEST["ref_kt_kod"]:"";
	$sql = "SELECT * FROM _ref_tempat_kategori WHERE ref_kt_kod=".tosql($f_tbcode,"Text"); 
	$rs_get = &$conn->Execute($sql);
	if($rs_get->recordcount()==0){
		
	} else {
		$proses=''; $msg = 'Rekod telah ada dalam pangkalan data anda.';
	}
}

if(empty($proses)){ 
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var ref_kt_kod = document.ilim.ref_kt_kod.value;
	var ref_kt_nama = document.ilim.ref_kt_nama.value;
	if(ref_kt_kod==''){
		alert("Sila masukkan Kod Agensi tempat bertugas terlebih dahulu.");
		document.ilim.f_tbcode.focus();
		return true;
	} else if(ref_kt_nama==''){
		alert("Sila masukkan Nama Agensi tempat bertugas terlebih dahulu.");
		document.ilim.f_tbcode.focus();
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
//$conn->debug=true;
//print $_SERVER['HTTP_ACCEPT'];
if(!empty($id)){
	$sSQL="SELECT * FROM _ref_tempat_kategori WHERE ref_ktid = ".tosql($id,"Text");
	$rs = &$conn->Execute($sSQL);
	$f_tbcode = $id;
	
}
//if(empty($id)){ $f_tbcode = dlookup("_ref_tempatbertugas","lpad(max(f_tbcode+1),3,'0')","1"); }
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">SELENGGARA MAKLUMAT TEMPAT BERTUGAS</td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
        	<?php if(!empty($msg)){ ?>
            <tr>
                <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <? } ?>
            <tr>
                <td width="30%"><b>Kod Agensi : </b></td>
                <td width="50%" colspan="2"><input type="text" size="60" name="ref_kt_kod" value="<?php print $rs->fields['ref_kt_kod'];?>" /> <i>Cth: JPM</i></td>
            </tr>
            <tr>
                <td width="30%"><b>Agensi : </b></td>
                <td width="50%" colspan="2"><input type="text" size="60" name="ref_kt_nama" value="<?php print $rs->fields['ref_kt_nama'];?>" /></td>
            </tr>
            <tr>
                <td width="20%"><b>Status : </b></td>
                <td width="50%" colspan="2">
                	<select name="ref_kt_status">
                    	<option value="0" <? if($rs->fields['ref_kt_status']=='0'){ print 'selected'; }?>>Aktif</option>
                    	<option value="1" <? if($rs->fields['ref_kt_status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                    </select>
                </td>
            </tr>
            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')" >
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
	document.ilim.ref_kt_kod.focus();
</script>
<?php } else {
	//print 'simpan';
	//$conn->debug=true;
	include '../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$ref_kt_kod=isset($_REQUEST["ref_kt_kod"])?$_REQUEST["ref_kt_kod"]:"";
	$ref_kt_nama=isset($_REQUEST["ref_kt_nama"])?$_REQUEST["ref_kt_nama"]:"";
	$ref_kt_status=isset($_REQUEST["ref_kt_status"])?$_REQUEST["ref_kt_status"]:"";

	/*$id 			= $_POST['id'];
	$category_code 	= strtoupper($_POST['category_code']);
	$categorytype 	= $_POST['categorytype'];
	$status 		= $_POST['status'];*/
	
	if(empty($id)){
		$sql = "INSERT INTO _ref_tempat_kategori(ref_kt_kod, ref_kt_nama, ref_kt_status) 
		VALUES(".tosql(strtoupper($ref_kt_kod),"Text").", ".tosql(strtoupper($ref_kt_nama),"Text").", ".tosql($ref_kt_status,"Number").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _ref_tempat_kategori SET 
			ref_kt_kod=".tosql(strtoupper($ref_kt_kod),"Text").",
			ref_kt_nama=".tosql(strtoupper($ref_kt_nama),"Text").",
			ref_kt_status=".tosql($ref_kt_status,"Number")."
			WHERE ref_ktid=".tosql($id,"Text");
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