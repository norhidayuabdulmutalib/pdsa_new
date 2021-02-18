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
	var nama = document.ilim.f_penilaian.value;
	if(nama==''){
		alert("Sila masukkan rujukan kategori penilaian terlebih dahulu.");
		document.ilim.f_penilaian.focus();
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
//if(!empty($id)){
	$sSQL="SELECT * FROM _ref_penilaian_kategori WHERE f_penilaianid = ".tosql($id);
	$rs = $conn->query($sSQL);
	//print $rs->recordcount();
	//print "P".tohtml($rs->fields['f_penilaian']);
//}
?>
<form name="ilim" method="post">
<div class="card">
	<div class="card-header" >
		<h4>SELENGGARA MAKLUMAT RUJUKAN KATEGORI PENILAIAN</h4>
	</div>
		<div class="card-body">

        	<?php if(!empty($msg)){ ?>
            <tr>
                <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <?php } ?>

			<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori Penilaian :</b></label>
                <div class="col-sm-12 col-md-7">
               		<input type="text" class="form-control" name="f_penilaian" value="<?php print $rs->fields['f_penilaian'];?>" />
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
                </td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.f_penilaian.focus();
</script>
<?php } else {
	//print 'simpan';
	//$conn->debug=true;
	include '../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$f_penilaian_status=isset($_REQUEST["f_penilaian_status"])?$_REQUEST["f_penilaian_status"]:"";
	$f_penilaian=isset($_REQUEST["f_penilaian"])?$_REQUEST["f_penilaian"]:"";
	
	if(empty($id)){
		$sql = "INSERT INTO _ref_penilaian_kategori(kampus_id, f_penilaian, f_penilaian_status) 
		VALUES(".tosql($_SESSION['SESS_KAMPUS']).", ".tosql($f_penilaian,"Text").", ".tosql($f_penilaian_status,"Number").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _ref_penilaian_kategori SET 
			f_penilaian=".tosql($f_penilaian,"Text").",
			f_penilaian_status=".tosql($f_penilaian_status,"Number")."
			WHERE f_penilaianid=".tosql($id,"Text");
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