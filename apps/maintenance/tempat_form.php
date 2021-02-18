<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
//$proses = $_GET['pro'];
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$msg='';
if(!empty($proses) && empty($_POST['id'])){
	//$category_code 	= strtoupper($_POST['category_code']);
	$f_tbcode=isset($_REQUEST["f_tbcode"])?$_REQUEST["f_tbcode"]:"";
	$sql = "SELECT * FROM _ref_tempatbertugas WHERE f_tbcode=".tosql($f_tbcode,"Text"); 
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
	var kod = document.ilim.f_tbcode.value;
	var nama = document.ilim.f_tempat_nama.value;
	var kategori = document.ilim.kategori.value;
	if(kod==''){
		alert("Sila masukkan kod tempat bertugas terlebih dahulu.");
		document.ilim.f_tbcode.focus();
		return true;
	} else if(nama==''){
		alert("Sila masukkan maklumat nama tempat bertigas terlebih dahulu.");
		document.ilim.f_tempat_nama.focus();
		return true;
	} else if(kategori==''){
		alert("Sila kategori agensi terlebih dahulu.");
		document.ilim.kategori.focus();
		return true;
	} else {
		if(kod.length!=4){
			alert("Sila pastikan kod anda mempunyai 4 aksara.");
			document.ilim.f_tbcode.focus();
			return true;
		} else {
			document.ilim.action = URL;
			document.ilim.submit();
		}
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
	$sSQL="SELECT * FROM _ref_tempatbertugas WHERE f_tbcode = ".tosql($id,"Text");
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
                <td width="30%"><b>Kod Tempat : </b></td>
                <td width="50%" colspan="2"><input type="text" size="10" name="f_tbcode" value="<?php print $f_tbcode;?>" maxlength="4" /></td>
            </tr>
            <tr>
                <td width="30%"><b>Tempat Bertugas : </b></td>
                <td width="50%" colspan="2"><input type="text" size="60" name="f_tempat_nama" value="<?php print $rs->fields['f_tempat_nama'];?>" /></td>
            </tr>
			<?php $sqlkk = "SELECT * FROM _ref_tempat_kategori WHERE ref_kt_status=0 ORDER BY ref_ktid";
                $rskk = &$conn->Execute($sqlkk);
            ?>
            <tr>
                <td align="left"><b>Kategori Agensi : </b></td> 
                <td align="left" colspan="2" >
                    <select name="kategori">
                        <option value="">-- Sila pilih kategori --</option>
                        <?php while(!$rskk->EOF){ ?>
                        <option value="<?php print $rskk->fields['ref_ktid'];?>" <?php if($rs->fields['ref_ktid']==$rskk->fields['ref_ktid']){ print 'selected'; }?>><?php print $rskk->fields['ref_kt_nama'];?></option>
                        <?php $rskk->movenext(); } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="20%"><b>Status : </b></td>
                <td width="50%" colspan="2">
                	<select name="f_status">
                    	<option value="0" <? if($rs->fields['f_status']=='0'){ print 'selected'; }?>>Aktif</option>
                    	<option value="1" <? if($rs->fields['f_status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
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
	document.ilim.f_tbcode.focus();
</script>
<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$f_tbcode=isset($_REQUEST["f_tbcode"])?$_REQUEST["f_tbcode"]:"";
	$f_tempat_nama=isset($_REQUEST["f_tempat_nama"])?$_REQUEST["f_tempat_nama"]:"";
	$f_gred_desc=isset($_REQUEST["f_gred_desc"])?$_REQUEST["f_gred_desc"]:"";
	$f_status=isset($_REQUEST["f_status"])?$_REQUEST["f_status"]:"";
	$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";

	/*$id 			= $_POST['id'];
	$category_code 	= strtoupper($_POST['category_code']);
	$categorytype 	= $_POST['categorytype'];
	$status 		= $_POST['status'];*/
	
	if(empty($id)){
		$sql = "INSERT INTO _ref_tempatbertugas(f_tbcode, f_tempat_nama, f_status, ref_ktid) 
		VALUES(".tosql(strtoupper($f_tbcode),"Text").", ".tosql(strtoupper($f_tempat_nama),"Text").", ".tosql($f_status,"Number").", ".tosql($kategori).")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _ref_tempatbertugas SET 
			f_tempat_nama=".tosql(strtoupper($f_tempat_nama),"Text").",
			ref_ktid=".tosql($kategori,"Number").",
			f_status=".tosql($f_status,"Number")."
			WHERE f_tbcode=".tosql($id,"Text");
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