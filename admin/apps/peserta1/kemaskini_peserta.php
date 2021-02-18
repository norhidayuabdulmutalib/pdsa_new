<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$f_peserta_noic=isset($_REQUEST["f_peserta_noic"])?$_REQUEST["f_peserta_noic"]:"";
$pass=isset($_REQUEST["pass"])?$_REQUEST["pass"]:"";
$idk=isset($_REQUEST["idk"])?$_REQUEST["idk"]:"";
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
//$proses = $_GET['pro'];
if(!empty($proses) && $proses=='UPDATE'){
	extract($_POST);
	$pass_check = $_POST['pass_check'];
	//$conn->debug=true;
	//exit;
	$proses='DAFTAR';
	include '../../katalog/katalog/mohon_daftar.php';
	print '<script language="javascript">
		parent.emailwindow.hide();
	</script>';
}
$msg='';
?>
<script LANGUAGE="JavaScript">
function do_pages(URL){
	//alert(URL);
	document.ilim.action = URL;
	document.ilim.submit();
}
function do_mohon(URL){
	if(document.ilim.f_peserta_noic.value==''){
		alert("Sila masukkan No. Kad Pengenalan peserta terlebih dahulu.");
		document.ilim.f_peserta_noic.focus();
		return true;
	} else if(document.ilim.f_peserta_nama.value==''){
		alert("Sila masukkan Nama Peserta terlebih dahulu.");
		document.ilim.f_peserta_nama.focus();
		return true;
	} else if (document.ilim.f_peserta_lahir.value == ''){
		alert("Sila masukkan tarikh lahir peserta.");
		document.ilim.f_peserta_lahir.focus();
		return true;
	} else if (document.ilim.insnationality.value == ''){
		alert("Sila pilih warganegara.");
		document.ilim.insnationality.focus();
		return true;
	} else if (document.ilim.f_peserta_tel_rumah.value == ''){
		alert("Sila masukkan no. telefon rumah.");
		document.ilim.f_peserta_tel_rumah.focus();
		return true;
	} else if (document.ilim.f_peserta_hp.value == ''){
		alert("Sila masukkan no. telefon bimbit (HP).");
		document.ilim.f_peserta_hp.focus();
		return true;
	} else if (document.ilim.f_peserta_email.value == ''){
		alert("Sila masukkan alamat e-mel.");
		document.ilim.f_peserta_email.focus();
		return true;
	} else if (document.ilim.f_peserta_grp.value == ''){
		alert("Sila masukkan kumpulan jawatan.");
		document.ilim.f_peserta_grp.focus();
		return true;
	} else if (document.ilim.f_title_grade.value == ''){
		alert("Sila masukkan gred jawatan.");
		document.ilim.f_title_grade.focus();
		return true;
	} else if (document.ilim.nama_ketuajabatan.value == ''){
		alert("Sila masukkan nama penyelia");
		document.ilim.nama_ketuajabatan.focus();
		return true;
	} else if (document.ilim.jawatan_ketuajabatan.value == ''){
		alert("Sila masukkan jawatan penyelia");
		document.ilim.jawatan_ketuajabatan.focus();
		return true;
	} else if (document.ilim.email_ketuajabatan.value == ''){
		alert("Sila masukkan alamat e-mel penyelia");
		document.ilim.email_ketuajabatan.focus();
		return true;
	} else if (document.ilim.BranchCd.value == ''){
		alert("Sila masukkan Jabatan/Agensi/Unit.");
		document.ilim.BranchCd.focus();
		return true;
	} else if (document.ilim.f_peserta_alamat1.value == ''){
		alert("Sila masukkan alamat tempat bertugas");
		document.ilim.f_peserta_alamat1.focus();
		return true;
	} else if (document.ilim.f_peserta_poskod.value == ''){
		alert("Sila masukkan poskod tempat bertugas");
		document.ilim.f_peserta_poskod.focus();
		return true;
	} else if (document.ilim.f_peserta_negeri.value == ''){
		alert("Sila pilih maklumat negeri");
		document.ilim.f_peserta_negeri.focus();
		return true;

	} else if (document.ilim.f_pass.value == ''){
		alert("Sila masukkan kata laluan anda (Tidak melebihi 20 abjad @ nombor).");
		document.ilim.f_pass.focus();
		return true;
	} else if (document.ilim.email_ketuajabatan.value==document.ilim.f_peserta_email.value){
		alert("Maklumat email peserta dan penyelia sama. Sila pastikan ianya berbeza.");
		document.ilim.f_penyelia_emel.focus();
		return true;
	} else {
		//document.ilim.proses.value='PROSES';
		document.ilim.action = URL;
		document.ilim.submit();
	}
}
function form_back(URL){
	parent.emailwindow.hide();
}

function do_daftar(URL){
	if(document.ilim.f_penyelia.value==''){
		alert("Sila masukkan nama penyelia terlebih dahulu.");
		document.ilim.f_penyelia.focus();
		return true;
	} else if(document.ilim.f_penyelia_jawatan.value==''){
		alert("Sila masukkan jawatan penyelia terlebih dahulu.");
		document.ilim.f_penyelia_jawatan.focus();
		return true;
	} else if (document.ilim.f_penyelia_emel.value == ''){
		alert("Sila masukkan emel penyelai terlebih dahulu.");
		document.ilim.f_penyelia_emel.focus();
		return true;
	} else if (document.ilim.f_penyelia_emel.value==document.ilim.f_peserta_email.value){
		alert("Maklumat email peserta dan penyelia sama. Sila pastikan ianya berbeza.");
		document.ilim.f_penyelia_emel.focus();
		return true;
	} else {
		//document.ilim.proses.value='PROSES';
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

</script>
<form name="ilim" method="post">
<br />
<br />
<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
	<tr><td colspan="3" height="30px" align="center" valign="middle">
		
        <?php include 'biodata_update.php';?>
        <br />
        <input type="hidden" size="15" name="pass" value="<?=$pass;?>"  />
        <input type="button" value="Kemaskini" style="cursor:pointer" 
        onclick="do_mohon('modal_form.php?win=<?=base64_encode('katalog/mohon.php;');?>&pro=UPDATE')" />
	</td></tr>
</table>
</form>
