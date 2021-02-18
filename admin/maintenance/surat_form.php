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
	var nama = document.ilim.surat_tajuk.value;
	if(nama==''){
		alert("Sila masukkan tajuk surat terlebih dahulu.");
		document.ilim.surat_tajuk.focus();
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
<script>
	// Remove advanced tabs for all editors.
	//CKEDITOR.config.removeDialogTabs = 'image:advanced;link:advanced;flash:advanced;creatediv:advanced;editdiv:advanced';
</script>
<?php
$dir='';
//$pathtoscript='../editor/';
//include_once($dir."../editor/config.inc.php");
//include_once($dir."../editor/FCKeditor/fckeditor.php") ;
//print $_SERVER['HTTP_ACCEPT'];
//if(!empty($id)){
$sSQL="SELECT * FROM ref_surat WHERE surat_id = ".tosql($id,"Number");
$rs = &$conn->Execute($sSQL);
//}
$kampus = dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rs->fields['kampus_id']));

?>

<form name="ilim" method="post">
<div class="card">
	<div class="card-header" >
		<h4>SELENGGARA MAKLUMAT RUJUKAN SURAT</h4>
	</div>
		<div class="card-body">

        	<?php if(!empty($msg)){ ?>
            <tr>
                <td align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
          </tr>
            <?php } ?>

            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat Latihan :</b></label>
              <div class="col-sm-12 col-md-7">
                <b style="color:#00F"><?php print $kampus; ?></b>
              </div>
            </div>

            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tajuk Surat :</b></label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control" name="surat_tajuk" value="<?php print $rs->fields['surat_tajuk'];?>" />
              </div>
            </div>

            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>No Rujukan Fail :</b></label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control" name="surat_ruj_fail" 
                value="<?php print $rs->fields['surat_ruj_fail'];?>" />
              </div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kandungan Surat :</b></label>
                <div class="col-sm-12 col-md-7">
                  <textarea name="surat_1" id="myform" style="form-control"><?php print $rs->fields['surat_1']; ?></textarea>
              </div>    
            </div>

           <!-- <tr>
                <td width="20%"><b></b></td>
                <td width="50%" colspan="2">
                      <textarea name="surat_2" cols="60" rows="5"><?php// print $rs->fields['surat_2']; ?></textarea>
                </td>    
            </tr>-->

            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="btn btn-success" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" >
                    <input type="button" value="Kembali" class="btn btn-secondary" title="Sila klik untuk kembali ke senarai rujukan kategori jawatan" onClick="form_back()" >
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                </td>
            </tr>
        </div>
</div>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.surat_tajuk.focus();
</script>
<script>
   CKEDITOR.replace( 'surat_1' );
   var dform = document.getElementById("myform");
   editor.config.height = dform.clientHeight - 10; 
   //editor.resize(editor.config.width, editor.config.height, true, true); 
</script>

<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$surat_id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$f_ab_desc=isset($_REQUEST["f_ab_desc"])?$_REQUEST["f_ab_desc"]:"";
	$surat_tajuk=isset($_REQUEST["surat_tajuk"])?$_REQUEST["surat_tajuk"]:"";
	$surat_ruj_fail=isset($_REQUEST["surat_ruj_fail"])?$_REQUEST["surat_ruj_fail"]:"";
	$surat_1=isset($_REQUEST["surat_1"])?$_REQUEST["surat_1"]:"";
	$surat_2=isset($_REQUEST["surat_2"])?$_REQUEST["surat_2"]:"";

	if(empty($id)){
		$sql = "INSERT INTO ref_surat (kampus_id, f_ab_desc, f_ab_status) 
		VALUES(".tosql($_SESSION['SESS_KAMPUS']).", ".tosql($f_ab_desc,"Text").", ".tosql($f_ab_status,"Number").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE ref_surat  SET 
			surat_tajuk=".tosql($surat_tajuk,"Text").",
			surat_ruj_fail=".tosql($surat_ruj_fail,"Text").",
			surat_1=".tosql($surat_1,"Text").",
			surat_2=".tosql($surat_2,"Text")."
			WHERE surat_id=".tosql($surat_id,"Text");
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