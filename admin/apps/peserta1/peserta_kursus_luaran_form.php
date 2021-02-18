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
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var nama_kursus = document.ilim.nama_kursus.value;
	var tempat_kursus = document.ilim.tempat_kursus.value;
	var tarikh_mula = document.ilim.tarikh_mula.value;
	var tarikh_tamat = document.ilim.tarikh_tamat.value;
	if(nama_kursus==''){
		alert("Sila masukkan nama kursus terlebih dahulu.");
		document.ilim.nama_kursus.focus();
		return true;
	} else if(tempat_kursus==''){
		alert("Sila masukkan tempat kursus terlebih dahulu.");
		document.ilim.tempat_kursus.focus();
		return true;
     } else if(tarikh_mula==''){
		alert("Sila masukkan tarikh mula kursus terlebih dahulu.");
		document.ilim.tarikh_mula.focus();
		return true;
	} else if(tarikh_tamat==''){
		alert("Sila masukkan tarikh tamat kursus terlebih dahulu.");
		document.ilim.tarikh_tamat.focus();
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
	$sSQL="SELECT * FROM _tbl_peserta_kursusluar WHERE klp_id = ".tosql($idp,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    <td colspan="2" class="title" height="25">SELENGGARA MAKLUMAT KURSUS LUARAN PESERTA</td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
        	<?php if(!empty($msg)){ ?>
            <tr>
                <td align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <?php } ?>
			<tr>
 				<td width="30%"><b>Nama Kursus : </b></td>
 				<td width="70%" colspan="2"><input type="text" size="70" maxlength="120" name="nama_kursus" value="<?php print $rs->fields['nama_kursus'];?>" /></td>
            </tr>
			<tr>
 				<td width="30%"><b>Tempat Kursus : </b></td>
 				<td width="70%" colspan="2"><input type="text" size="70" maxlength="120" name="tempat_kursus" value="<?php print $rs->fields['tempat_kursus'];?>" /></td>
            </tr>
			<tr>
 				<td width="30%"><b>Anjuran : </b></td>
 				<td width="70%" colspan="2"><input type="text" size="70" maxlength="120" name="anjuran" value="<?php print $rs->fields['anjuran'];?>" /></td>
            </tr>
            <tr>
              <td><b>Tarikh Mula : </b></td>
              <td colspan="2"><input type="text" size="10" name="tarikh_mula" value="<?php print DisplayDate($rs->fields['startdate']);?>" readonly="readonly"/>
                <img src="../cal/img/screenshot.gif" alt="Sila klik untuk pilih tarikh" width="18" height="19" 
                onclick="displayCalendar(document.ilim.tarikh_mula,'dd/mm/yyyy',this)"  onmouseover="this.style.cursor='pointer'" /> 
              </td>
            </tr>
            <tr>
              <td><b>Tarikh Tamat : </b></td>
              <td colspan="2"><input type="text" size="10" name="tarikh_tamat" value="<?php print DisplayDate($rs->fields['enddate']);?>" readonly="readonly"/>
                <img src="../cal/img/screenshot.gif" alt="Sila klik untuk pilih tarikh" width="18" height="19" 
                onclick="displayCalendar(document.ilim.tarikh_tamat,'dd/mm/yyyy',this)"  onmouseover="this.style.cursor='pointer'" /> 
              </td>
            </tr>

            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" >
                    <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke maklumat peserta" onClick="form_back()" >
                    <input type="hidden" name="id_peserta" value="<?=$id?>" />
                    <input type="hidden" name="idp" value="<?=$idp?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />                
                </td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.nama_kursus.focus();
</script>
<?php } else {
	//print 'simpan';
	//$conn->debug=true;
	include '../loading_pro.php';
	$idp=isset($_REQUEST["idp"])?$_REQUEST["idp"]:"";
	$id_peserta=isset($_REQUEST["id_peserta"])?$_REQUEST["id_peserta"]:"";
	$nama_kursus=isset($_REQUEST["nama_kursus"])?$_REQUEST["nama_kursus"]:"";
	$tempat_kursus=isset($_REQUEST["tempat_kursus"])?$_REQUEST["tempat_kursus"]:"";
	$anjuran=isset($_REQUEST["anjuran"])?$_REQUEST["anjuran"]:"";
	$tarikh_mula=isset($_REQUEST["tarikh_mula"])?$_REQUEST["tarikh_mula"]:"";
	$tarikh_tamat=isset($_REQUEST["tarikh_tamat"])?$_REQUEST["tarikh_tamat"]:"";

	if(empty($idp)){
		$sql = "INSERT INTO _tbl_peserta_kursusluar(id_peserta, nama_kursus, tempat_kursus, anjuran, 
		startdate, enddate, create_by, create_dt) 
		VALUES(".tosql($id_peserta).", ".tosql(strtoupper($nama_kursus)).", ".tosql(strtoupper($tempat_kursus)).", ".tosql(strtoupper($anjuran)).",
		".tosql(DBDate($tarikh_mula),"Text").", ".tosql(DBDate($tarikh_tamat),"Text").", ".tosql($_SESSION["s_userid"]).",".tosql(date("Y-m-d H:i:s"),"Text").")";
		$rs = &$conn->Execute($sql);
	} else {
		if($proses=='DEL'){
			$sql = "DELETE FROM _tbl_peserta_kursusluar WHERE klp_id=".tosql($idp,"Text");
		} else {
			$sql = "UPDATE _tbl_peserta_kursusluar SET 
				nama_kursus=".tosql(strtoupper($nama_kursus),"Text").",
				tempat_kursus=".tosql(strtoupper($tempat_kursus),"Text").",
				anjuran=".tosql(strtoupper($anjuran),"Text").",
				startdate=".tosql(DBDate($tarikh_mula),"Text").",
				enddate=".tosql(DBDate($tarikh_tamat),"Text").",
				update_by=".tosql($_SESSION["s_userid"],"Text").",
				update_dt=".tosql(date("Y-m-d H:i:s"),"Text")."
				WHERE klp_id=".tosql($idp,"Text");
		}
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