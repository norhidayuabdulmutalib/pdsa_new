<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(confirm("Adakah anda pasti untuk proses ini?")){
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function do_page(URL){
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}

function do_back(URL){
	parent.emailwindow.hide();
}
function do_refresh(){
	//parent.location.reload();	
	refresh = parent.location; 
	parent.location = refresh;
}
</script>
<?
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses = $_GET['pro'];

//$conn->debug=true;
$types = $_GET['tab'];        
//if(empty($id)){ $id = $_GET['ids']; }                    
//$href_search = "modal_form.php?win=".base64_encode('asrama/dkeluar_form.php;'.$id);
//$blok_search = $_POST['blok_search'];

$sql_l = "SELECT A.*, B.no_bilik, B.tingkat_id, C.f_bb_desc FROM _sis_a_tblasrama A, _sis_a_tblbilik B, _ref_blok_bangunan C
	WHERE A.bilik_id=B.bilik_id AND B.blok_id=C.f_bb_id AND A.daftar_id=".tosql($id);
$rs_l = &$conn->Execute($sql_l); 
$noic = $rs_l->fields['peserta_id'];
$asrama_type = $rs_l->fields['asrama_type'];
$kursus_type = $rs_l->fields['kursus_type'];
$event_id = $rs_l->fields['event_id'];

if($kursus_type=='I'){
	if($asrama_type=='P'){
		$sql_k = "SELECT f_peserta_nama, f_waris_nama, f_waris_tel, f_waris_alamat1, f_waris_alamat2, f_waris_alamat3 FROM _tbl_peserta WHERE f_peserta_noic=".tosql($noic,"Text"); 
		$rs_peserta = $conn->execute($sql_k);
		$nama_peserta = $rs_peserta->fields['f_peserta_nama'];
		$f_waris_nama = $rs_peserta->fields['f_waris_nama'];
		$f_waris_tel = $rs_peserta->fields['f_waris_tel'];
		$f_waris_alamat1 = $rs_peserta->fields['f_waris_alamat1'].",<br>".$rs_peserta->fields['f_waris_alamat2'].",<br>".$rs_peserta->fields['f_waris_alamat3'];
	
		$sql_k = "SELECT coursename AS kursus, B.startdate AS mula, B.enddate AS tamat FROM _tbl_kursus A, _tbl_kursus_jadual B 
		WHERE A.id=B.courseid AND B.id=".tosql($event_id,"Text");
		$rs_kursus = $conn->execute($sql_k);
		$kursus = $rs_kursus->fields['kursus'];
		$kmula = DisplayDate($rs_kursus->fields['mula']);
		$ktamat = DisplayDate($rs_kursus->fields['tamat']);
	
	
	} else {
		$nama_peserta = $rs->fields['daftar_nama'];
		$sql_k = "SELECT coursename AS kursus, B.startdate AS mula, B.enddate AS tamat FROM _tbl_kursus A, _tbl_kursus_jadual B, _sis_a_tblasrama C 
		WHERE A.id=B.courseid AND B.id=C.event_id AND C.peserta_id=".tosql($noic,"Text");
		$rs_kursus = $conn->execute($sql_k);
	}
} else {
	if(empty($nama_peserta)){ $nama_peserta=$rs_l->fields['nama_peserta']; $f_waris_alamat1='Tiada alamat';}
	if(empty($f_waris_nama)){ $f_waris_nama=$rs_l->fields['nama_waris']; }
	if(empty($f_waris_tel)){ $f_waris_tel=$rs_l->fields['no_tel_waris']; }

	$sql_k = "SELECT B.startdate AS mula, B.enddate AS tamat, B.acourse_name FROM _tbl_kursus_jadual B 
	WHERE B.id=".tosql($event_id,"Text");
	$rs_kursus = $conn->execute($sql_k);
	$kursus = $rs_kursus->fields['acourse_name']; 
	$kmula = DisplayDate($rs_kursus->fields['mula']);
	$ktamat = DisplayDate($rs_kursus->fields['tamat']);
}
//$nama_peserta = $rs->fields['daftar_nama'];
if(empty($nama_peserta)){ $nama_peserta = $rs_l->fields['nama_peserta']; }
/*$nama_kursus = $rs->fields['coursename'];
if(empty($coursename)){ $coursename = $rs_l->fields['acourse_name']; }*/

if(empty($proses)){ 
//print $rs->fields['daftar_nama'];
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="3" cellspacing="0" border="0">
	<tr>
    	<td colspan="4" height="30" bgcolor="#999999">&nbsp;<b>DAFTAR KELUAR ASRAMA / PEMULANGAN KUNCI ASRAMA</b></td>
    </tr>
    <tr>
        <td width="25%" align="left"><b>Nama Penghuni</b></td>
        <td width="2%" align="left"><b>:</b></td>
        <td width="75%" colspan="2" align="left"><?php print $nama_peserta;?></td>
    </tr>
    <tr>
        <td align="left"><b>Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $kursus;?></td>
    </tr>
    <tr>
        <td align="left"><b>Tarikh Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $kmula;?> hingga <?php print $ktamat;?></td>
    </tr>
    <tr><td colspan="4"><hr /></td></tr>
    <tr>
        <td align="left"><b>Nama Waris</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $f_waris_nama;?></td>
    </tr>
    <tr>
        <td align="left"><b>No. Tel</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $f_waris_tel;?></td>
    </tr>
    <tr>
        <td align="left" valign="top"><b>Alamat</b></td>
        <td align="left" valign="top"><b>:</b></td>
        <td colspan="2" align="left"><?php print $f_waris_alamat1;?></td>
    </tr>

   <tr>
     <td colspan="4" bgcolor="#CCCCCC"><b>MAKLUMAT BILIK</b></td>
   </tr>
   <tr>
     <td align="left"><b>Blok</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><?php print $rs_l->fields['f_bb_desc'];?></td>
   </tr>
   <tr>
     <td align="left"><b>Aras Bangunan</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><?php print dlookup("_ref_aras_bangunan","f_ab_desc","f_ab_id=".tosql($rs_l->fields['tingkat_id'],"Number"));?></td>
   </tr>
   <tr>
     <td align="left"><b>No. Bilik</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><?php print $rs_l->fields['no_bilik'];?></td>
   </tr>
 <tr>
 	<td colspan="4" align="center"><br>
    		<input type="button" value="Proses" name="dkeluar" class="button_disp" title="Sila klik untuk menyimpan maklumat" 
            onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')">
            <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai peserta/penceramah" 
            onClick="do_back()">
            <input type="hidden" name="id" value="<?=$id?>" />
            <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
            <input type="hidden" name="bilik_id" value="<?php print $rs_l->fields['bilik_id'];?>" />
   	</td>
    </tr>
</table>
</form>
<script language="javascript">
	document.ilim.dkeluar.focus();
</script>
<?php } else { 
	//$conn->debug=true;
	$bilik_id = $_POST['bilik_id'];
	$id = $_POST['id'];

	$sql_l = "SELECT A.*, B.no_bilik, B.tingkat_id, C.f_bb_desc FROM _sis_a_tblasrama A, _sis_a_tblbilik B, _ref_blok_bangunan C
		WHERE A.bilik_id=B.bilik_id AND B.blok_id=C.f_bb_id AND A.daftar_id=".tosql($id);
	$rs_l = &$conn->Execute($sql_l); 
	$noic = $rs_l->fields['peserta_id'];
	$asrama_type = $rs_l->fields['asrama_type'];
	$event_id = $rs_l->fields['event_id'];
	
	
	if($asrama_type=='P'){
		$sql_k = "SELECT f_peserta_nama, f_waris_nama, f_waris_tel, f_waris_alamat1, f_waris_alamat2, f_waris_alamat3 FROM _tbl_peserta WHERE f_peserta_noic=".tosql($noic,"Text"); 
		$rs_peserta = $conn->execute($sql_k);
		$nama_peserta = $rs_peserta->fields['f_peserta_nama'];
		$f_waris_nama = $rs_peserta->fields['f_waris_nama'];
		$f_waris_tel = $rs_peserta->fields['f_waris_tel'];
		$f_waris_alamat1 = $rs_peserta->fields['f_waris_alamat1'].",<br>".$rs_peserta->fields['f_waris_alamat2'].",<br>".$rs_peserta->fields['f_waris_alamat3'];
		if(empty($nama_peserta)){ $nama_peserta=$rs_l->fields['nama_peserta']; $f_waris_alamat1='';}
		if(empty($f_waris_nama)){ $f_waris_nama=$rs_l->fields['nama_waris']; }
		if(empty($f_waris_tel)){ $f_waris_tel=$rs_l->fields['no_tel_waris']; }
	
		$sql_k = "SELECT coursename AS kursus, B.startdate AS mula, B.enddate AS tamat FROM _tbl_kursus A, _tbl_kursus_jadual B 
		WHERE A.id=B.courseid AND B.id=".tosql($event_id,"Text");
		$rs_kursus = $conn->execute($sql_k);
		$kursus = $rs_kursus->fields['kursus'];
		$kmula = DisplayDate($rs_kursus->fields['mula']);
		$ktamat = DisplayDate($rs_kursus->fields['tamat']);
	
		if(empty($kursus)){ 
			$sql_k = "SELECT B.startdate AS mula, B.enddate AS tamat, B.acourse_name FROM _tbl_kursus_jadual B 
			WHERE B.id=".tosql($event_id,"Text");
			$rs_kursus = $conn->execute($sql_k);
			$kursus = $rs_kursus->fields['acourse_name']; 
			$kmula = DisplayDate($rs_kursus->fields['mula']);
			$ktamat = DisplayDate($rs_kursus->fields['tamat']);
		}
	
	} else {
		$nama_peserta = $rs->fields['daftar_nama'];
		$sql_k = "SELECT coursename AS kursus, B.startdate AS mula, B.enddate AS tamat FROM _tbl_kursus A, _tbl_kursus_jadual B, _sis_a_tblasrama C 
		WHERE A.id=B.courseid AND B.id=C.event_id AND C.peserta_id=".tosql($noic,"Text");
		$rs_kursus = $conn->execute($sql_k);
	}
	
	//$nama_peserta = $rs->fields['daftar_nama'];
	if(empty($nama_peserta)){ $nama_peserta = $rs_l->fields['nama_peserta']; }

	//echo "insert";
	$sql = "UPDATE _sis_a_tblasrama SET is_daftar=0, is_keluar=1, status_keluar=0, tarikh_pulang=".tosql(date("Y-m-d H:i:s")).", 
		update_by='".$_SESSION["s_UserID"]."' WHERE daftar_id=".tosql($id,"Text");
	$conn->Execute($sql);
	//print "<br>".$sql;
	//echo "Set Status Bilik Kepada KOSONG";
	
	//exit;
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="5" cellspacing="1" border="0">
	<tr>
    	<td colspan="4" height="30" bgcolor="#999999" align="center">&nbsp;<b>PENGHUNI ASRAMA INI TELAH MENDAFTAR KELUAR</b></td>
    </tr>
    <tr>
        <td width="25%" align="left"><b>Nama Penghuni</b></td>
        <td width="2%" align="left"><b>:</b></td>
        <td width="75%" colspan="2" align="left"><?php print $nama_peserta;?></td>
    </tr>
    <tr>
        <td align="left"><b>Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $kursus;?></td>
    </tr>
    <tr>
        <td align="left"><b>Tarikh Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $kmula;?> hingga <?php print $ktamat;?></td>
    </tr>
    <tr>
        <td align="left"><b>Status Keluar</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left">Kunci Telah dipulangkan</td>
    </tr>
    <tr>
        <td colspan="4" align="center"><br>
                <input type="button" value="Tutup" class="button_disp" title="Sila klik untuk menutup paparan" onClick="do_refresh()">
        </td>
    </tr>
</table>
</form>
<?php } ?>