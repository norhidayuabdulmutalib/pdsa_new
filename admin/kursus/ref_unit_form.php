<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
//$proses = $_GET['pro'];
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$msg='';
/*if(!empty($proses) && empty($_POST['id'])){
	//$category_code 	= strtoupper($_POST['category_code']);
	$category_code=isset($_REQUEST["category_code"])?$_REQUEST["category_code"]:"";
	$sql = "SELECT * FROM _tbl_kursus_cat WHERE category_code=".tosql($category_code,"Text"); 
	$rs = &$conn->Execute($sql);
	if($rs->recordcount()==0){
		
	} else {
		$proses=''; $msg = 'Rekod telah ada dalam pangkalan data anda.';
	}
}*/

if(empty($proses)){ 
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(document.ilim.kategori.value==''){
		alert("Sila pilih jenis kursus terlebih dahulu.");
		document.ilim.kategori.focus();
		return true;
	} else if(document.ilim.SubCategoryNm.value==''){
		alert("Sila masukkan kod unit / pusat terlebih dahulu.");
		document.ilim.SubCategoryNm.focus();
		return true;
	} else if(document.ilim.SubCategoryDesc.value==''){
		alert("Sila masukkan diskripsi unit / pusat terlebih dahulu.");
		document.ilim.SubCategoryDesc.focus();
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
	$sSQL="SELECT * FROM _tbl_kursus_catsub WHERE id = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>

<form name="ilim" method="post">
	<div class="card">
	<div class="card-header" >
		<h4>SELENGGARA MAKLUMAT KATEGORI KURSUS</h4>
	</div>
		<div class="card-body">

        	<?php if(!empty($msg)){ ?>
            <tr>
                <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <?php } ?>
			<?php $sqlb = "SELECT * FROM _ref_kampus WHERE kampus_status=0".$sql_kampus;
			
			$rs_kb = $conn->Execute($sqlb);
			?>
			<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat Latihan :</b></label>
                <div class="col-sm-12 col-md-7">
					<select class="form-control" name="kampus_id">
						<?php while(!$rs_kb->EOF){ ?>
							<option value="<?php print $rs_kb->fields['kampus_id'];?>" <?php if($rs_kb->fields['kampus_id']==$rs->fields['kod_jabatan']){ print 'selected="selected"';}?>><?php print $rs_kb->fields['kampus_nama'];?></option>
						<?php $rs_kb->movenext(); } ?>
					</select>
                </div>
            </div>

			<?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
                $rskk = &$conn->Execute($sqlkk);
            ?>
            <div class="form-group row mb-4">
				<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font>Kategori Kursus : </b></label>
				<div class="col-sm-12 col-md-7">
                    <select class="form-control" name="kategori" onchange="do_page('<?=$href_search;?>')">
                        <option value="">-- Sila pilih kategori --</option>
                        <?php while(!$rskk->EOF){ ?>
                        <option value="<?php print $rskk->fields['id'];?>" <?php if($rs->fields['f_category_code']==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                        <?php $rskk->movenext(); } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row mb-4">
				<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kod Unit / Pusat : </b></label>
				<div class="col-sm-12 col-md-7">
					<input class="form-control" type="text" size="30" name="SubCategoryNm" maxlength="20" value="<?php print $rs->fields['SubCategoryNm'];?>"/>
				</div>
            </div>
            
			<div class="form-group row mb-4">
				<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Diskripsi Unit / Pusat : </b></label>
				<div class="col-sm-12 col-md-7">
               		<input class="form-control" type="text" size="60" name="SubCategoryDesc" value="<?php print $rs->fields['SubCategoryDesc'];?>" />
				</div>
            </div>

            <div class="form-group row mb-4">
				<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Status : </b></label>
				<div class="col-sm-12 col-md-7">
                	<select class="form-control" name="f_status">
                    	<option value="0" <?php if($rs->fields['f_status']=='0'){ print 'selected'; }?>>Aktif</option>
                    	<option value="1" <?php if($rs->fields['f_status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <!--<tr><td colspan="3"><hr /></td></tr>-->
            <div>
                <div colspan="3" align="center">
                    <button class="btn btn-success" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" ><i class="far fa-save"></i><b> Simpan</b></button>
                    <button class="btn btn-secondary" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back()" ><b>Kembali</b></button>
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                </div>
            </div>
        </div>
    </div>
</form>

<script LANGUAGE="JavaScript">
	document.ilim.kategori.focus();
</script>
<?php } else {
	//print 'simpan';
	//$conn->debug=true;
	include 'loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
	$SubCategoryNm=isset($_REQUEST["SubCategoryNm"])?$_REQUEST["SubCategoryNm"]:"";
	$SubCategoryDesc=isset($_REQUEST["SubCategoryDesc"])?$_REQUEST["SubCategoryDesc"]:"";
	$status=isset($_REQUEST["f_status"])?$_REQUEST["f_status"]:"";
	$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";

	/*$id 			= $_POST['id'];
	$category_code 	= strtoupper($_POST['category_code']);
	$categorytype 	= $_POST['categorytype'];
	$status 		= $_POST['status'];*/
	
	if(empty($id)){
		$sql = "INSERT INTO _tbl_kursus_catsub(f_category_code, SubCategoryNm, 
			SubCategoryDesc, f_status, kampus_id) 
		VALUES(".tosql($kategori,"Text").", ".tosql($SubCategoryNm,"Text").", ".
			tosql($SubCategoryDesc,"Text").", ".tosql($status,"Number").", ".tosql($kampus_id,"Number").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _tbl_kursus_catsub SET 
			f_category_code=".tosql($kategori,"Text").",
			SubCategoryNm=".tosql($SubCategoryNm,"Text").",
			SubCategoryDesc=".tosql($SubCategoryDesc,"Text").",
			f_status=".tosql($status,"Number")."
			WHERE id=".tosql($id,"Text");
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