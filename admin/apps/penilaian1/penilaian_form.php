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
		alert("Sila masukkan rujukan maklumat penilaian terlebih dahulu.");
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
<?php
//print $_SERVER['HTTP_ACCEPT'];
if(!empty($id)){
	$sSQL="SELECT * FROM _ref_penilaian_maklumat WHERE f_penilaian_detailid = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">SELENGGARA MAKLUMAT RUJUKAN PENILAIAN</td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
        	<?php if(!empty($msg)){ ?>
            <tr>
                <td align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
          </tr>
            <?php } ?>
            <tr>
                <td width="20%"><b>Maklumat Penilaian : </b></td>
              <td width="80%" colspan="2"><textarea rows="2" cols="80" name="f_penilaian_desc"><?php print stripslashes($rs->fields['f_penilaian_desc']);?></textarea></td>
          </tr>
            <?php $sqlb = "SELECT * FROM _ref_penilaian_kategori WHERE is_deleted=0";
			$rs_kb = &$conn->Execute($sqlb);
			?>
            <tr>
                <td width="20%"><b>Kategori Penilaian : </b></td>
          <td width="80%" colspan="2">
       	  <select name="f_penilaianid">
                    <?php while(!$rs_kb->EOF){ ?>
                    	<option value="<?php print $rs_kb->fields['f_penilaianid'];?>" <?php if($rs_kb->fields['f_penilaianid']==$rs->fields['f_penilaianid']){ print 'selected="selected"';}?>><?php print $rs_kb->fields['f_penilaian'];?></option>
                    <?php $rs_kb->movenext(); } ?>
                    	<option value="A" <?php if($rs->fields['f_penilaianid']=='A'){ print 'selected'; }?>>Keseluruhan Kursus</option>
                    	<option value="B" <?php if($rs->fields['f_penilaianid']=='B'){ print 'selected'; }?>>Cadangan Penambahbaikan</option>
                    </select>
                </td>
          </tr>
            <tr>
                <td width="20%"><b>Set Jawapan : </b></td>
                <td width="80%" colspan="2">
           	  <select name="f_penilaian_jawab">
                    	<option value="0" <?php if($rs->fields['f_penilaian_jawab']=='0'){ print 'selected'; }?>>-</option>
                    	<option value="1" <?php if($rs->fields['f_penilaian_jawab']=='1'){ print 'selected'; }?>>Set 5 Pilihan</option>
                    	<option value="2" <?php if($rs->fields['f_penilaian_jawab']=='2'){ print 'selected'; }?>>Set Ya / Tidak</option>
                    	<option value="3" <?php if($rs->fields['f_penilaian_jawab']=='3'){ print 'selected'; }?>>Set Jawapan Bertulis</option>
                    </select>
                </td>
          </tr>
            <tr>
                <td width="20%"><b>Status : </b></td>
                <td width="80%" colspan="2">
           	  <select name="f_penilaian_status">
                    	<option value="0" <?php if($rs->fields['f_penilaian_status']=='0'){ print 'selected'; }?>>Aktif</option>
                    	<option value="1" <?php if($rs->fields['f_penilaian_status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                    </select>
                </td>
          </tr>
            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" >
                    <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan blok bangunan" onClick="form_back()" >
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
		$sql = "INSERT INTO _ref_penilaian_maklumat(f_penilaian_desc, f_penilaianid, f_penilaian_status, f_penilaian_jawab) 
		VALUES(".tosql($f_penilaian_desc,"Text").", ".tosql($f_penilaianid,"Text").", ".tosql($f_penilaian_status,"Number").", ".tosql($f_penilaian_jawab,"Number").")";
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