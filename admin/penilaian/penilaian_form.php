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
	var nama = document.ilim.f_penilaian_desc.value;
	if(nama==''){
		alert("Sila masukkan maklumat penilaian terlebih dahulu.");
		document.ilim.f_penilaian_desc.focus();
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
<script src="ckeditor/ckeditor.js"></script>
<?php
//print $_SERVER['HTTP_ACCEPT'];
if(!empty($id)){
	$sSQL="SELECT * FROM _ref_penilaian_maklumat WHERE f_penilaian_detailid = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
	$desc = $rs->fields['f_penilaian_desc'];
} else {
	$desc= " ";
}
?>
<form name="ilim" method="post" action="">
<div class="card">
	<div class="card-header" >
		<h4>SELENGGARA MAKLUMAT RUJUKAN PENILAIAN</h4>
	</div>
		<div class="card-body">

        	<?php if(!empty($msg)){ ?>
            <tr>
                <td align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
          </tr>
            <?php } ?>

			<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Maklumat Penilaian :</b></label>
                <div class="col-sm-12 col-md-7">
              		<textarea class="form-control" id="myform" name="f_penilaian_desc"><?php print $desc;?></textarea>
				</div>
          	</div>

            <?php $sqlb = "SELECT * FROM _ref_penilaian_kategori WHERE is_deleted=0";
				if($_SESSION["s_level"]<>'99'){ $sqlb .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
			$rs_kb = &$conn->Execute($sqlb);
			?>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori Penilaian :</b></label>
                <div class="col-sm-12 col-md-7">   
       	  			<select class="form-control" name="f_penilaianid">
						<?php while(!$rs_kb->EOF){ ?>
							<option value="<?php print $rs_kb->fields['f_penilaianid'];?>" <?php if($rs_kb->fields['f_penilaianid']==$rs->fields['f_penilaianid']){ print 'selected="selected"';}?>><?php print $rs_kb->fields['f_penilaian'];?></option>
						<?php $rs_kb->movenext(); } ?>
							<option value="A" <?php if($rs->fields['f_penilaianid']=='A'){ print 'selected'; }?>>Keseluruhan Kursus</option>
							<option value="B" <?php if($rs->fields['f_penilaianid']=='B'){ print 'selected'; }?>>Cadangan Penambahbaikan</option>
                    </select>
                </div>
          	</div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Set Jawapan :</b></label>
                <div class="col-sm-12 col-md-7">
           	  		<select class="form-control" name="f_penilaian_jawab">
                    	<option value="0" <?php if($rs->fields['f_penilaian_jawab']=='0'){ print 'selected'; }?>>-</option>
                    	<option value="1" <?php if($rs->fields['f_penilaian_jawab']=='1'){ print 'selected'; }?>>Set 5 Pilihan</option>
                    	<option value="2" <?php if($rs->fields['f_penilaian_jawab']=='2'){ print 'selected'; }?>>Set Ya / Tidak</option>
                    	<option value="3" <?php if($rs->fields['f_penilaian_jawab']=='3'){ print 'selected'; }?>>Set Jawapan Bertulis</option>
                    </select>
                </div>
         	</div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Status :</b></label>
                <div class="col-sm-12 col-md-7">
           	  		<select class="form-control" name="f_penilaian_status">
                    	<option value="0" <?php if($rs->fields['f_penilaian_status']=='0'){ print 'selected'; }?>>Aktif</option>
                    	<option value="1" <?php if($rs->fields['f_penilaian_status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
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
<script>
   CKEDITOR.replace( 'f_penilaian_desc' );
   var dform = document.getElementById("myform");
   editor.config.height = dform.clientHeight - 10; 
   //editor.resize(editor.config.width, editor.config.height, true, true); 
</script>
<script LANGUAGE="JavaScript">
	document.ilim.f_penilaian_desc.focus();
</script>
<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$f_penilaian_desc=isset($_REQUEST["f_penilaian_desc"])?$_REQUEST["f_penilaian_desc"]:"";
	$f_penilaianid=isset($_REQUEST["f_penilaianid"])?$_REQUEST["f_penilaianid"]:"";
	$f_penilaian_status=isset($_REQUEST["f_penilaian_status"])?$_REQUEST["f_penilaian_status"]:"";
	$f_penilaian_jawab=isset($_REQUEST["f_penilaian_jawab"])?$_REQUEST["f_penilaian_jawab"]:"";

	/*$id 			= $_POST['id']; f_penilaian_jawab
	$category_code 	= strtoupper($_POST['category_code']);
	$categorytype 	= $_POST['categorytype'];
	$status 		= $_POST['status'];*/
	
	if(empty($id)){
		$sql = "INSERT INTO _ref_penilaian_maklumat(kampus_id, f_penilaian_desc, f_penilaianid, f_penilaian_status, f_penilaian_jawab) 
		VALUES(".tosql($_SESSION['SESS_KAMPUS']).", ".tosql($f_penilaian_desc,"Text").", ".tosql($f_penilaianid,"Text").", ".tosql($f_penilaian_status,"Number").", ".tosql($f_penilaian_jawab,"Number").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _ref_penilaian_maklumat SET 
			f_penilaian_desc=".tosql($f_penilaian_desc,"Text").",
			f_penilaianid=".tosql($f_penilaianid,"Text").",
			f_penilaian_jawab=".tosql($f_penilaian_jawab,"Number").",
			f_penilaian_status=".tosql($f_penilaian_status,"Number")."
			WHERE f_penilaian_detailid=".tosql($id,"Text");
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