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
	var sijil = document.ilim.inpakar_bidang.value;
	var kursus = document.ilim.inpakar_pengkhususan.value;
	if(sijil==''){
		alert("Sila masukkan bidang terlebih dahulu.");
		document.ilim.inpakar_bidang.focus();
		return true;
	/*} else if(kursus==''){
		alert("Sila masukkan pengkhususan terlebih dahulu.");
		document.ilim.inpakar_pengkhususan.focus();
		return true;*/
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
	$sSQL="SELECT * FROM _tbl_instructor_kepakaran WHERE inpakar_id = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>

<form name="ilim" method="post">
<div class="card">
	<div class="card-header" >
		<h4>SELENGGARA MAKLUMAT KEPAKARAN PENCERAMAH</h4>
	</div>

    <div class="card-body">
		<?php if(!empty($msg)){ ?>
		<tr>
			<td align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
		</tr>
            <?php } ?>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Bidang :</b></label>
                <div class="col-sm-12 col-md-7">
                	<select class="form-control" name="inpakar_bidang">
					<?php 
					//$r_gred = dlookupList('_ref_kepakaran', 'f_pakar_code,f_pakar_nama', '', 'f_pakar_nama');
					$r_gred = &$conn->execute("SELECT * FROM _ref_kepakaran ORDER BY f_pakar_nama");
					while (!$r_gred->EOF){ ?>
					<option value="<?=$r_gred->fields['f_pakar_code'] ?>" <?php if($rs->fields['inpakar_bidang'] == $r_gred->fields['f_pakar_code']) echo "selected"; ?> >
					<?=$r_gred->fields['f_pakar_nama']?></option>
					<?php $r_gred->movenext(); }?>        
                   </select>
				</div>
            </div>

			<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pengkhususan :</b></label>
                <div class="col-sm-12 col-md-7">
					<input type="text" class="form-control" name="inpakar_pengkhususan" value="<?php print $rs->fields['inpakar_pengkhususan'];?>" />
				</div>
            </div>

           <hr />
            <div>
                <div colspan="3" align="center">
                    <button class="btn btn-success" value="Simpan" style="cursor:pointer; padding:8px;" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" ><i class="fas fa-save"></i> Simpan</button>
                    <button class="btn btn-secondary" value="Kembali" style="cursor:pointer; padding:8px;" class="button_disp" title="Sila klik untuk kembali ke maklumat penceramah" onClick="form_back()" ><i class="fas fa-undo"></i> Kembali</button>
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />                
                </div>
            </div>
   </div>
</div>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.inpakar_bidang.focus();
</script>
<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$inpakar_bidang=isset($_REQUEST["inpakar_bidang"])?$_REQUEST["inpakar_bidang"]:"";
	$inpakar_pengkhususan=isset($_REQUEST["inpakar_pengkhususan"])?$_REQUEST["inpakar_pengkhususan"]:"";

	if(empty($id)){
		$sql = "INSERT INTO _tbl_instructor_kepakaran(ingenid,inpakar_bidang,inpakar_pengkhususan) 
		VALUES(".tosql($_SESSION['ingenid']).", ".tosql(strtoupper($inpakar_bidang),"Text").", ".tosql(strtoupper($inpakar_pengkhususan),"Text").")";
		$rs = &$conn->Execute($sql);
		audit_trail($sql,"");
	} else {
		$sql = "UPDATE _tbl_instructor_kepakaran SET 
			inpakar_bidang=".tosql(strtoupper($inpakar_bidang),"Text").",
			inpakar_pengkhususan=".tosql(strtoupper($inpakar_pengkhususan),"Text")."
			WHERE inpakar_id=".tosql($id,"Text");
		$rs = &$conn->Execute($sql);
		audit_trail($sql,"");
	}

	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		parent.emailwindow.hide()
		//exit();
		</script>";
}
?>