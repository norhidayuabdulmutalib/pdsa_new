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
	var nama = document.ilim.f_bilik_nama.value;
	if(nama==''){
		alert("Sila masukkan nama bilik kuliah terlebih dahulu.");
		document.ilim.f_bilik_nama.focus();
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
	$sSQL="SELECT * FROM _tbl_bilikkuliah WHERE f_bilikid = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>
<form name="ilim" method="post">
<div class="card">
	<div class="card-header" >
		<h4>SELENGGARA MAKLUMAT BILIK KULIAH</h4>
	</div>
		<div class="card-body">

        	<?php if(!empty($msg)){ ?>
            <tr>
                <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <?php } ?>

			<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Nama Bilik Kuliah :</b></label>
                <div class="col-sm-12 col-md-7">
					<input type="text" class="form-control" name="f_bilik_nama" 
                	value="<?php print $rs->fields['f_bilik_nama'];?>" />
				</div>
            </div>

            <?php $sqlb = "SELECT A.*, B.kampus_kod FROM _ref_blok_bangunan A, _ref_kampus B 
				WHERE A.kampus_id=B.kampus_id AND A.is_deleted=0 AND A.f_bb_status=0";
			if(!empty($sql_kampus)){ $sqlb .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
			$sqlb .= $sql_filter;
			$sqlb .= " ORDER BY B.kampus_id";
			$rs_kb = &$conn->Execute($sqlb);
			?>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Blok Bangunan :</b></label>
                <div class="col-sm-12 col-md-7">
                	<select class="form-control" name="f_bb_id" >
                    <?php while(!$rs_kb->EOF){ ?>
                    	<option value="<?php print $rs_kb->fields['f_bb_id'];?>" <?php if($rs_kb->fields['f_bb_id']==$rs->fields['f_bb_id']){ print 'selected="selected"';}?>><?php print $rs_kb->fields['kampus_kod']." - ".$rs_kb->fields['f_bb_desc'];?></option>
                    <?php $rs_kb->movenext(); } ?>
                    </select>
                </div>
            </div>

            <?php $sqlab = "SELECT * FROM _ref_aras_bangunan WHERE is_deleted=0 AND f_ab_status=0";
			$rs_ab = &$conn->Execute($sqlab);
			?>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Aras Bangunan :</b></label>
                <div class="col-sm-12 col-md-7">
                	<select class="form-control" name="f_ab_id">
                    <?php while(!$rs_ab->EOF){ ?>
                    	<option value="<?php print $rs_ab->fields['f_ab_id'];?>" <?php if($rs_ab->fields['f_ab_id']==$rs->fields['f_ab_id']){ print 'selected="selected"';}?>><?php print $rs_ab->fields['f_ab_desc'];?></option>
                    <?php $rs_ab->movenext(); } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kapasiti Pelajar :</b></label>
                <div class="col-sm-12 col-md-7">
					<input class="form-control" type="text" name="f_bilik_kapasiti" value="<?php print $rs->fields['f_bilik_kapasiti'];?>" />
				</div>
            </div>

			<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Status :</b></label>
                <div class="col-sm-12 col-md-7">
                	<select class="form-control" name="f_status">
                    	<option value="0" <?php if($rs->fields['f_status']=='0'){ print 'selected'; }?>>Boleh Digunakan</option>
                    	<option value="1" <?php if($rs->fields['f_status']=='1'){ print 'selected'; }?>>Dalam Penyelengaraan</option>
                    </select>
                </div>
            </div>

            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" class="btn btn-success" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" >
                    <input type="button" class="btn btn-secondary" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan blok bangunan" onClick="form_back()" >
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                </td>
            </tr>

        </div>
    </div>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.f_bilik_nama.focus();
</script>
<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$f_bilik_nama=isset($_REQUEST["f_bilik_nama"])?$_REQUEST["f_bilik_nama"]:"";
	$f_bb_id=isset($_REQUEST["f_bb_id"])?$_REQUEST["f_bb_id"]:"";
	$f_ab_id=isset($_REQUEST["f_ab_id"])?$_REQUEST["f_ab_id"]:"";
	$f_bilik_kapasiti=isset($_REQUEST["f_bilik_kapasiti"])?$_REQUEST["f_bilik_kapasiti"]:"";
	$f_status=isset($_REQUEST["f_status"])?$_REQUEST["f_status"]:"";

	/*$id 			= $_POST['id'];
	$category_code 	= strtoupper($_POST['category_code']);
	$categorytype 	= $_POST['categorytype'];
	$status 		= $_POST['status'];*/
	
	if(empty($id)){
		$sql = "INSERT INTO _tbl_bilikkuliah(f_bilik_nama, f_bb_id, f_ab_id, f_bilik_kapasiti, f_status, 
		create_by, create_dt) 
		VALUES(".tosql($f_bilik_nama,"Text").", ".tosql($f_bb_id,"Number").", ".tosql($f_ab_id,"Number").", ".tosql($f_bilik_kapasiti,"Number").", ".tosql($f_status,"Number").",
		".tosql($_SESSION["s_logid"],"Text").", ".tosql(date("Y-m-d H:i:s"),"Text").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _tbl_bilikkuliah SET 
			f_bilik_nama=".tosql($f_bilik_nama,"Text").",
			f_bb_id=".tosql($f_bb_id,"Number").",
			f_ab_id=".tosql($f_ab_id,"Number").",
			f_bilik_kapasiti=".tosql($f_bilik_kapasiti,"Number").",
			f_status=".tosql($f_status,"Number").",
			update_by=".tosql($_SESSION["s_logid"],"Text").",
			update_dt=".tosql(date("Y-m-d H:i:s"),"Text")."
			WHERE f_bilikid=".tosql($id,"Text");
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