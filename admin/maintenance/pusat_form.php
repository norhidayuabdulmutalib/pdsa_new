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
	var nama = document.ilim.jabatan_nama.value;
	if(nama==''){
		alert("Sila masukkan rujukan pusat kursus terlebih dahulu.");
		document.ilim.jabatan_nama.focus();
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
	$sSQL="SELECT * FROM  _ref_jabatan  WHERE jabatan_id = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>
<form name="ilim" method="post">
<div class="card">
	<div class="card-header" >
		<h4>SELENGGARA MAKLUMAT RUJUKAN ARAS BANGUNAN</h4>
	</div>
		<div class="card-body">

        	<?php if(!empty($msg)){ ?>
            <tr>
                <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <?php } ?>
			<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Nama Aras Bangunan :</b></label>
                <div class="col-sm-12 col-md-7">
					<input type="text" class="form-control" name="jabatan_nama" value="<?php print $rs->fields['jabatan_nama'];?>" />
				</div>
            </div>

			<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Status :</b></label>
                <div class="col-sm-12 col-md-7">
                	<select class="form-control" name="jabatan_status">
                    	<option value="0" <?php if($rs->fields['jabatan_status']=='0'){ print 'selected'; }?>>Aktif</option>
                    	<option value="1" <?php if($rs->fields['jabatan_status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" class="btn btn-success" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" >
                    <input type="button" class="btn btn-secondary" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan kategori jawatan" onClick="form_back()" >
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
	document.ilim.jabatan_nama.focus();
</script>
<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$jabatan_nama=isset($_REQUEST["jabatan_nama"])?$_REQUEST["jabatan_nama"]:"";
	$jabatan_status=isset($_REQUEST["jabatan_status"])?$_REQUEST["jabatan_status"]:"";

	if(empty($id)){
		$sql = "INSERT INTO _ref_jabatan (jabatan_nama, jabatan_status) 
		VALUES(".tosql($jabatan_nama,"Text").", ".tosql($jabatan_status,"Number").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _ref_jabatan SET 
			jabatan_nama=".tosql($jabatan_nama,"Text").",
			jabatan_status=".tosql($jabatan_status,"Number")."
			WHERE jabatan_id=".tosql($id,"Text");
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