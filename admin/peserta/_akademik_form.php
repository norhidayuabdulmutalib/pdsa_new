<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
//$proses = $_GET['pro'];
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$idp=isset($_REQUEST["idp"])?$_REQUEST["idp"]:"";
$msg='';
if(empty($proses)){ 
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var sijil = document.ilim.inaka_sijil.value;
	var kursus = document.ilim.inaka_kursus.value;
	var ins = document.ilim.inaka_institusi.value;
	var tahun = document.ilim.inaka_tahun.value;
	if(sijil==''){
		alert("Sila masukkan kelulusan akademik terlebih dahulu.");
		document.ilim.inaka_sijil.focus();
		return true;
	} else if(kursus==''){
		alert("Sila masukkan nama kursus terlebih dahulu.");
		document.ilim.inaka_kursus.focus();
		return true;
     } else if(ins==''){
		alert("Sila masukkan nama institusi terlebih dahulu.");
		document.ilim.inaka_institusi.focus();
		return true;
	} else if(tahun==''){
		alert("Sila masukkan tahun terlebih dahulu.");
		document.ilim.inaka_tahun.focus();
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
	$sSQL="SELECT * FROM _tbl_peserta_akademik WHERE ingenid_akademik = ".tosql($idp,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>

<form name="ilim" method="post">
<div class="card">
	<div class="card-header" >
		<h4>SELENGGARA MAKLUMAT AKADEMIK PESERTA</h4>
	</div>

	<div class="card-body">
		<?php if(!empty($msg)){ ?>
            <tr>
                <td align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <?php } ?>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kelulusan :</b></label>
                <div class="col-sm-12 col-md-7">
					<select class="form-control" name="inaka_sijil">
						<?php 
						$r_gred = listLookup('_ref_akademik', '*', '1', 'f_akademik_id');
						while(!$r_gred->EOF){ ?>
						<option value="<?=$r_gred->fields['f_akademik_id'] ?>" <?php if($rs->fields['inaka_sijil'] == $r_gred->fields['f_akademik_id']) echo "selected"; ?> >
						<?=$r_gred->fields['f_akademik_nama']?></option>
						<?php $r_gred->movenext(); }?>        
                   </select>   
				</div>
            </div>

			<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Bidang Kursus :</b></label>
                <div class="col-sm-12 col-md-7">
					<input class="form-control" type="text" name="inaka_kursus" value="<?php print $rs->fields['inaka_kursus'];?>" />
				</div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Institusi :</b></label>
                <div class="col-sm-12 col-md-7">
			  		<input type="text" class="form-control" name="inaka_institusi" value="<?php print $rs->fields['inaka_institusi'];?>" />
				</div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tahun :</b></label>
                <div class="col-sm-12 col-md-7">
			  		<input type="text" class="form-control" name="inaka_tahun" maxlength="4" value="<?php print $rs->fields['inaka_tahun'];?>" />
			  	</div>
            </div>

            <tr>
                <td colspan="3" align="center">
                    <input type="button" class="btn btn-success" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" >
                    <input type="button" class="btn btn-secondary" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke maklumat peserta" onClick="form_back()" >
                    <input type="hidden" name="id_peserta" value="<?=$id?>" />
                    <input type="hidden" name="idp" value="<?=$idp?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />                
                </td>
            </tr>
		</div>
	</div>
</form>  

<script LANGUAGE="JavaScript">
	document.ilim.inaka_sijil.focus();
</script>
<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$idp=isset($_REQUEST["idp"])?$_REQUEST["idp"]:"";
	$id_peserta=isset($_REQUEST["id_peserta"])?$_REQUEST["id_peserta"]:"";
	$inaka_sijil=isset($_REQUEST["inaka_sijil"])?$_REQUEST["inaka_sijil"]:"";
	$inaka_kursus=isset($_REQUEST["inaka_kursus"])?$_REQUEST["inaka_kursus"]:"";
	$inaka_institusi=isset($_REQUEST["inaka_institusi"])?$_REQUEST["inaka_institusi"]:"";
	$inaka_tahun=isset($_REQUEST["inaka_tahun"])?$_REQUEST["inaka_tahun"]:"";

	/*$id 			= $_POST['id'];
	$category_code 	= strtoupper($_POST['category_code']);
	$categorytype 	= $_POST['categorytype'];
	$status 		= $_POST['status'];*/

	if(empty($idp)){
		$sql = "INSERT INTO _tbl_peserta_akademik(id_peserta,inaka_sijil, inaka_kursus, inaka_institusi, inaka_tahun) 
		VALUES(".tosql($id_peserta).", ".tosql(strtoupper($inaka_sijil),"Text").", ".tosql(strtoupper($inaka_kursus),"Text").", 
		".tosql(strtoupper($inaka_institusi),"Text").", ".tosql($inaka_tahun,"Number").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _tbl_peserta_akademik SET 
			inaka_sijil=".tosql(strtoupper($inaka_sijil),"Text").",
			inaka_kursus=".tosql(strtoupper($inaka_kursus),"Text").",
			inaka_institusi=".tosql($inaka_institusi,"Text").",
			inaka_tahun=".tosql($inaka_tahun,"Number")."
			WHERE ingenid_akademik=".tosql($idp,"Text");
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