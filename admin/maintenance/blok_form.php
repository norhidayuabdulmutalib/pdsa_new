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
	var nama = document.ilim.f_bb_desc.value;
	if(nama==''){
		alert("Sila masukkan rujukan blok bangunan terlebih dahulu.");
		document.ilim.f_bb_desc.focus();
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
	$sSQL="SELECT * FROM _ref_blok_bangunan WHERE f_bb_id = ".tosql($id,"Number");
	$rs = &$conn->query($sSQL);
}
?>
<form name="ilim" method="post">
<div class="card">
	<div class="card-header" >
		<h4>SELENGGARA MAKLUMAT RUJUKAN BLOK BANGUNAN</h4>
	</div>
		<div class="card-body">

        	<?php if(!empty($msg)){ ?>
            <tr>
                <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <?php } ?>

            <?php 
			//$conn->debug=true;
			$sqlb = "SELECT * FROM _ref_kampus WHERE kampus_status=0".$sql_kampus;
			$rs_kb = $conn->query($sqlb);
			?>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat Latihan :</b></label>
                <div class="col-sm-12 col-md-7">
                	<select name="kampus_id" class="form-control">
                    <?php while(!$rs_kb->EOF){ ?>
                    	<option value="<?php print $rs_kb->fields['kampus_id'];?>" <?php if($rs_kb->fields['kampus_id']==$rs->fields['kampus_id']){ print 'selected="selected"';}?>><?php print $rs_kb->fields['kampus_nama'];?></option>
                    <?php $rs_kb->movenext(); } ?>
                    </select>
                </div>
            </div>
			
			<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Blok Bangunan :</b></label>
                <div class="col-sm-12 col-md-7">
					<input type="text" class="form-control" name="f_bb_desc" value="<?php print $rs->fields['f_bb_desc'];?>" />
				</div>
            </div>

            <?php $sqlb = "SELECT * FROM _ref_kategori_blok WHERE is_deleted=0";
			$rs_kb = &$conn->Execute($sqlb);
			?>
			<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori Blok :</b></label>
                <div class="col-sm-12 col-md-7">
                	<select class="form-control" name="f_kb_id">
                    <?php while(!$rs_kb->EOF){ ?>
                    	<option value="<?php print $rs_kb->fields['f_kb_id'];?>" <?php if($rs_kb->fields['f_kb_id']==$rs->fields['f_kb_id']){ print 'selected="selected"';}?>><?php print $rs_kb->fields['f_kb_desc'];?></option>
                    <?php $rs_kb->movenext(); } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Status :</b></label>
                <div class="col-sm-12 col-md-7">
                	<select class="form-control" name="f_bb_status">
                    	<option value="0" <?php if($rs->fields['f_bb_status']=='0'){ print 'selected'; }?>>Aktif</option>
                    	<option value="1" <?php if($rs->fields['f_bb_status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
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
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.f_bb_desc.focus();
</script>
<?php } else {
	//print 'simpan';
	//$conn->debug=true;
	include 'loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
	$kod_jabatan=isset($_REQUEST["kod_jabatan"])?$_REQUEST["kod_jabatan"]:"";
	$f_bb_desc=isset($_REQUEST["f_bb_desc"])?$_REQUEST["f_bb_desc"]:"";
	$f_kb_id=isset($_REQUEST["f_kb_id"])?$_REQUEST["f_kb_id"]:"";
	$f_bb_status=isset($_REQUEST["f_bb_status"])?$_REQUEST["f_bb_status"]:"";

	/*$id 			= $_POST['id'];
	$category_code 	= strtoupper($_POST['category_code']);
	$categorytype 	= $_POST['categorytype'];
	$status 		= $_POST['status'];*/
	
	if(empty($id)){
		$sql = "INSERT INTO _ref_blok_bangunan(kampus_id, f_bb_desc, f_kb_id, f_bb_status) 
		VALUES(".tosql($kampus_id,"Text").", ".tosql($f_bb_desc,"Text").", ".tosql($f_kb_id,"Number").", ".tosql($f_bb_status,"Number").")";
		//print $sql; exit;
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _ref_blok_bangunan SET 
			kampus_id=".tosql($kampus_id,"Text").",
			f_bb_desc=".tosql($f_bb_desc,"Text").",
			f_kb_id=".tosql($f_kb_id,"Text").",
			f_bb_status=".tosql($f_bb_status,"Number")."
			WHERE f_bb_id=".tosql($id,"Text");
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