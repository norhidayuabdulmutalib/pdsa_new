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
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">SELENGGARA MAKLUMAT BILIK KULIAH</td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
        	<?php if(!empty($msg)){ ?>
            <tr>
                <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <?php } ?>
            <tr>
                <td width="30%"><b>Nama Bilik Kuliah : </b></td>
                <td width="50%" colspan="2"><input type="text" size="50" name="f_bilik_nama" 
                value="<?php print $rs->fields['f_bilik_nama'];?>" /></td>
            </tr>
            <?php $sqlb = "SELECT A.*, B.kampus_kod FROM _ref_blok_bangunan A, _ref_kampus B 
				WHERE A.kampus_id=B.kampus_id AND A.is_deleted=0 AND A.f_bb_status=0";
			if(!empty($sql_kampus)){ $sqlb .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
			$sqlb .= $sql_filter;
			$sqlb .= " ORDER BY B.kampus_id";
			$rs_kb = &$conn->Execute($sqlb);
			?>
            <tr>
                <td width="30%"><b>Blok Bangunan : </b></td>
                <td width="50%" colspan="2">
                	<select name="f_bb_id" style="width:100%">
                    <?php while(!$rs_kb->EOF){ ?>
                    	<option value="<?php print $rs_kb->fields['f_bb_id'];?>" <?php if($rs_kb->fields['f_bb_id']==$rs->fields['f_bb_id']){ print 'selected="selected"';}?>><?php print $rs_kb->fields['kampus_kod']." - ".$rs_kb->fields['f_bb_desc'];?></option>
                    <?php $rs_kb->movenext(); } ?>
                    </select>
                </td>
            </tr>
            <?php $sqlab = "SELECT * FROM _ref_aras_bangunan WHERE is_deleted=0 AND f_ab_status=0";
			$rs_ab = &$conn->Execute($sqlab);
			?>
            <tr>
                <td width="30%"><b>Aras Bangunan : </b></td>
                <td width="50%" colspan="2">
                	<select name="f_ab_id">
                    <?php while(!$rs_ab->EOF){ ?>
                    	<option value="<?php print $rs_ab->fields['f_ab_id'];?>" <?php if($rs_ab->fields['f_ab_id']==$rs->fields['f_ab_id']){ print 'selected="selected"';}?>><?php print $rs_ab->fields['f_ab_desc'];?></option>
                    <?php $rs_ab->movenext(); } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="30%"><b>Kapasiti Pelajar : </b></td>
                <td width="50%" colspan="2"><input type="text" size="5" name="f_bilik_kapasiti" value="<?php print $rs->fields['f_bilik_kapasiti'];?>" /></td>
            </tr>
            <tr>
                <td width="20%"><b>Status : </b></td>
                <td width="50%" colspan="2">
                	<select name="f_status">
                    	<option value="0" <? if($rs->fields['f_status']=='0'){ print 'selected'; }?>>Boleh Digunakan</option>
                    	<option value="1" <? if($rs->fields['f_status']=='1'){ print 'selected'; }?>>Dalam Penyelengaraan</option>
                    </select>
                </td>
            </tr>
            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')" >
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