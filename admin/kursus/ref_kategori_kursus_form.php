<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
//$proses = $_GET['pro'];
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$msg='';
if(!empty($proses) && empty($_POST['id'])){
	//$category_code 	= strtoupper($_POST['category_code']);
	$category_code=isset($_REQUEST["category_code"])?$_REQUEST["category_code"]:"";
	$sql = "SELECT * FROM _tbl_kursus_cat WHERE category_code=".tosql($category_code,"Text"); 
	$rs = &$conn->Execute($sql);
	if($rs->recordcount()==0){
		
	} else {
		$proses=''; $msg = 'Rekod telah ada dalam pangkalan data anda.';
	}
}

if(empty($proses)){ 
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var kod = document.ilim.category_code.value;
	var desc = document.ilim.categorytype.value;
	if(kod==''){
		alert("Sila masukkan kod kategori kursus terlebih dahulu.");
		document.ilim.category_code.focus();
		return true;
	} else if(desc==''){
		alert("Sila masukkan diskripsi kategori kursus terlebih dahulu.");
		document.ilim.categorytype.focus();
		return true;
	} else {
		if(kod.length!=5){
			alert("Sila pastikan kod anda mempunyai 5 aksara.");
			document.ilim.category_code.focus();
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
//print $_SERVER['HTTP_ACCEPT'];
if(!empty($id)){
	$sSQL="SELECT * FROM _tbl_kursus_cat WHERE id = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">SELENGGARA MAKLUMAT KATEGORI KURSUS</td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
        	<?php if(!empty($msg)){ ?>
            <tr>
                <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <?php } ?>
            <tr>
                <td width="30%"><b>Kod Kategori : </b></td>
                <td width="50%" colspan="2"><input type="text" size="10" name="category_code" maxlength="5" value="<?php print $rs->fields['category_code'];?>"/> <i>Cth: C0001</i></td>
            </tr>
            <tr>
                <td width="30%"><b>Kategori Kursus : </b></td>
                <td width="50%" colspan="2"><input type="text" size="60" name="categorytype" value="<?php print $rs->fields['categorytype'];?>" /></td>
            </tr>
            <tr>
                <td width="20%"><b>Status : </b></td>
                <td width="50%" colspan="2">
                	<select name="status">
                    	<option value="0" <?php if($rs->fields['status']=='0'){ print 'selected'; }?>>Aktif</option>
                    	<option value="1" <?php if($rs->fields['status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                    </select>
                </td>
            </tr>
            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" >
                    <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back()" >
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
	document.ilim.category_code.focus();
</script>
<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$category_code=isset($_REQUEST["category_code"])?$_REQUEST["category_code"]:"";
	$categorytype=isset($_REQUEST["categorytype"])?$_REQUEST["categorytype"]:"";
	$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";

	/*$id 			= $_POST['id'];
	$category_code 	= strtoupper($_POST['category_code']);
	$categorytype 	= $_POST['categorytype'];
	$status 		= $_POST['status'];*/
	
	if(empty($id)){
		$sql = "INSERT INTO _tbl_kursus_cat(category_code, categorytype, status) 
		VALUES(".tosql(strtoupper($category_code),"Text").", ".tosql($categorytype,"Text").", ".tosql($status,"Number").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _tbl_kursus_cat SET 
			category_code=".tosql(strtoupper($category_code),"Text").",
			categorytype=".tosql($categorytype,"Text").",
			status=".tosql($status,"Number")."
			WHERE id=".tosql($id,"Text");
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