<?php 
//$uri = explode("?",$_SERVER['REQUEST_URI']);
//$URLs = $uri[1];
//$conn->debug=true;
//$proses = $_GET['pro'];
$data=isset($_REQUEST["data"])?$_REQUEST["data"]:"";
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$msg='';
if(!empty($proses)){ 
	//$conn->debug=true;

	if($proses=='SAVE'){
		//print 'simpan';
		//include '../loading_pro.php';
		$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
		$pset_status=isset($_REQUEST["pset_status"])?$_REQUEST["pset_status"]:"";
		$pset_tajuk=isset($_REQUEST["pset_tajuk"])?$_REQUEST["pset_tajuk"]:"";
		
		if($pset_status==0){ $conn->Execute("UPDATE _tbl_penilaian_set set pset_status=1"); }
		if(empty($id)){
			$id = date("Ymd").uniqid();
			$sql = "INSERT INTO _tbl_penilaian_set(pset_id, pset_tajuk, pset_status, create_dt, create_by) 
			VALUES(".tosql($id,"Text").",".tosql($pset_tajuk,"Text").", ".tosql($pset_status,"Number").",
			".tosql(date("Y-m-d H:i:s"),"Text").",".tosql($_SESSION["s_userid"],"Text").")";
			$rs = &$conn->Execute($sql);
			audit_trail($sql);
		} else {
			$sql = "UPDATE _tbl_penilaian_set SET 
				pset_tajuk=".tosql($pset_tajuk,"Text").",
				pset_status=".tosql($pset_status,"Number").",
				update_dt=".tosql(date("Y-m-d H:i:s"),"Text").",
				update_by=".tosql($_SESSION["s_userid"],"Text")."
				WHERE pset_id=".tosql($id,"Text");
			$rs = &$conn->Execute($sql);
			audit_trail($sql);
		}
		
	} else if($proses=='DELETE'){
		$conn->Execute("UPDATE _tbl_penilaian_set SET is_deleted=1 WHERE pset_id=".tosql($id,"Text"));
		print "<script language=\"javascript\">
			alert('Rekod telah dihapuskan');
			//parent.location.reload();	
			//refresh = parent.location; 
			//parent.location = refresh;
			window.location = \"index.php?data=dXNlcjtwZW5pbGFpYW4vc2V0X3BlbmlsYWlhbi5waHA7bmlsYWk7c2V0\";
			</script>";
	}
}

?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var nama = document.ilim.pset_tajuk.value;
	if(nama==''){
		alert("Sila masukkan maklumat tajuk set penilaian terlebih dahulu.");
		document.ilim.pset_tajuk.focus();
		return true;
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
}
function form_tutup(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}
function form_back(URL){
	parent.emailwindow.hide();
}

</script>
<?php
//print $_SERVER['HTTP_ACCEPT'];
if(!empty($id)){
	$sSQL="SELECT * FROM _tbl_penilaian_set WHERE pset_id = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
    	<td colspan="2" class="title" height="25">SELENGGARA MAKLUMAT SET PENILAIAN</td>
    </tr>
	<tr><td colspan="2">
    	<table width="80%" cellpadding="3" cellspacing="0" border="0" align="center">
        	<?php if(!empty($msg)){ ?>
            <tr>
                <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <? } ?>
            <tr>
                <td width="30%"><b>Kategori Penilaian : </b></td>
                <td width="50%" colspan="2"><textarea name="pset_tajuk" rows="2" cols="80"><?php print $rs->fields['pset_tajuk'];?></textarea></td>
            </tr>
            <tr>
                <td><b>Status : </b></td>
                <td colspan="2">
                	<select name="pset_status">
                    	<option value="0" <? if($rs->fields['pset_status']=='0'){ print 'selected'; }?>>Aktif</option>
                    	<option value="1" <? if($rs->fields['pset_status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Tarikh Jana : </b></td>
                <td colspan="2"><?php print DisplayDate($rs->fields['create_dt']);?></td>
			</tr>
            <tr>
                <td><b>Tarikh Kemaskini : </b></td>
                <td colspan="2"><?php print DisplayDate($rs->fields['update_dt']);?></td>
			</tr>
            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('index.php?data=<? print $data;?>&pro=SAVE')" >
                    <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan blok bangunan" 
                    onClick="form_tutup('index.php?data=<? print base64_encode('user;penilaian/set_penilaian.php;nilai;set;');?>')" >
                    <input type="hidden" name="id" value="<?=$id?>" />
                </td>
            </tr>
        </table>
      </td>
   </tr>
   <?php if(!empty($id)){ 
   $href_link = "modal_form.php?win=".base64_encode('penilaian/set_pilih.php;')."&id=".$id;?>
   <tr><td colspan="2" width="100%">&nbsp;</td></tr>
   <tr><td colspan="2" align="center">
   		<?php //include 'set_penilaian_list.php';?>
   		<?php include 'set_penilaian_list.php';?>
   </td></tr>
   <?php } ?>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.pset_tajuk.focus();
</script>
