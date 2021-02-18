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
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var kehadiran = document.ilim.kehadiran.value;
	var sebab = document.ilim.sebab.value;
	if(kehadiran==''){
		alert("Sila pilih status pengesahan kehadiran terlebih dahulu.");
		document.ilim.kehadiran.focus();
		return true;
	} else {
		if(kehadiran=='2' && sebab==''){
			alert("Sila masukkan sebab kenapa anda tidak dapat hadir.");
			document.ilim.sebab.focus();
			return true;
		} else {
			if(document.ilim.nama_ketuajabatan.value==''){
				alert("Sila masukkan maklumat Nama Ketua Jabatan anda");
				document.ilim.nama_ketuajabatan.focus();
			} else if(document.ilim.email_ketuajabatan.value==''){
				alert("Sila masukkan maklumat Email Ketua Jabatan anda");
				document.ilim.email_ketuajabatan.focus();
			} else {
				document.ilim.action = URL;
				document.ilim.submit();
			}
		}
	}
}

function form_back(URL){
	parent.emailwindow.hide();
}

</script>
<?php
//print $_SERVER['HTTP_ACCEPT'];
$sSQL="SELECT B.startdate, B.enddate, C.coursename, C.courseid, A.*, C.SubCategoryCd 
FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B, _tbl_kursus C 
WHERE A.EventId=B.id AND B.courseid=C.id AND A.InternalStudentId=".$id." AND A.peserta_icno=".tosql($_SESSION["s_logid"],"Text");
//print $sSQL;
$rs = &$conn->Execute($sSQL);
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">PENGESAHAN KEHADIRAN KURSUS</td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
        	<?php if(!empty($msg)){ ?>
            <tr>
                <td align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <? } ?>
            <tr>
                <td width="30%"><b>Nama  : </b></td>
              	<td width="70%" colspan="2"><?php print dlookup("_tbl_peserta","f_peserta_nama","f_peserta_noic=".tosql($_SESSION["s_logid"]));?></td>
            </tr>
			<tr>
 				<td><b>Kursus : </b></td>
 				<td colspan="2"><?php print $rs->fields['courseid']. " - " .$rs->fields['coursename'];?></td>
            </tr>
            <tr>
              <td><b>Pengesahan Kehadiran : </b></td>
              <td colspan="2">
              	<select name="kehadiran">
                	<option value="0">-- Belum disahkan --</option>
                	<option value="1"<?php if($rs->fields['InternalStudentAccepted']==1){ print 'selected'; }?>>Hadir</option>
                	<option value="2"<?php if($rs->fields['InternalStudentAccepted']==2){ print 'selected'; }?>>Tidak Hadir</option>
                </select>
              </td>
            </tr>
			<tr>
 				<td><b>Nama Ketua Jabatan : </b></td>
 				<td colspan="2"><input type="text" size="80" maxlength="64" name="nama_ketuajabatan" value="<?php print $rs->fields['nama_ketuajabatan'];?>" /></td>
            </tr>
			<tr>
 				<td><b>email Ketua Jabatan : </b></td>
 				<td colspan="2"><input type="text" size="80" maxlength="64" name="email_ketuajabatan" value="<?php print $rs->fields['email_ketuajabatan'];?>" /></td>
            </tr>
            <tr>
              <td valign="top"><b>Sebab-sebab : </b></td>
              <td colspan="2"><textarea name="sebab" rows="4" cols="40"><?php print $rs->fields['InternalStudentReason'];?></textarea></td>
            </tr>

            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')" >
                    <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke maklumat peserta" onClick="form_back()" >
                    <input type="hidden" name="peserta_icno" value="<?=$_SESSION["s_logid"];?>" />
                    <input type="hidden" name="id" value="<?=$id;?>" />
                </td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.kehadiran.focus();
</script>
<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$peserta_icno=isset($_REQUEST["peserta_icno"])?$_REQUEST["peserta_icno"]:"";
	$kehadiran=isset($_REQUEST["kehadiran"])?$_REQUEST["kehadiran"]:"";
	$sebab=isset($_REQUEST["sebab"])?$_REQUEST["sebab"]:"";
	$nama_ketuajabatan=isset($_REQUEST["nama_ketuajabatan"])?$_REQUEST["nama_ketuajabatan"]:"";
	$email_ketuajabatan=isset($_REQUEST["email_ketuajabatan"])?$_REQUEST["email_ketuajabatan"]:"";

	$sql = "UPDATE _tbl_kursus_jadual_peserta SET 
		InternalStudentAccepted=".tosql($kehadiran,"Number").",
		InternalStudentReason=".tosql($sebab,"Text").",
		nama_ketuajabatan=".tosql($nama_ketuajabatan,"Text").",
		email_ketuajabatan=".tosql($email_ketuajabatan,"Text").",
		InternalStudentReplyDt=".tosql(date("Y-m-d H:i:s"),"Text").",
		InternalStudentLastUpdate=".tosql(date("Y-m-d H:i:s"),"Text").",
		InternalStudentLastUpdateBy=".tosql($peserta_icno,"Text")." 
		WHERE InternalStudentId=".tosql($id,"Text") ." AND peserta_icno=".tosql($peserta_icno,"Text");
	$rs = &$conn->Execute($sql);
	//print $sql; exit;
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		</script>";
}
?>