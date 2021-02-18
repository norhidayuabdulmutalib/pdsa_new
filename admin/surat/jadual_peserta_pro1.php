<?php //include_once '../../common.php'; ?>
<script language="javascript" type="text/javascript">
function form_back(){
	parent.emailwindow.hide();
}
</script>
<?php
//if($_SESSION['session_userid']=='admin'){ $conn->debug=true; }
$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate, 
D.bilik_kuliah, D.penyelaras, D.timestart, D.timeend, D.ref_surat_peserta, D.penyelaras_notel, D.penyelaras_email, 
D.masa_daftar, D.masa_taklimat, D.no_rujukan_surat, A.kampus_id   
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Text");
$rs_kursus = &$conn->query($sSQL);
//print $sSQL;
//$conn->debug=false;
$kampus_id = $rs_kursus->fields['kampus_id'];
$kursus = $rs_kursus->fields['coursename'];
$surat_tawaran = $rs_kursus->fields['ref_surat_peserta'];
$tarikh_kursus = DisplayDate($rs_kursus->fields['startdate'])." hingga ".DisplayDate($rs_kursus->fields['enddate']);
$masa_kursus = $rs_kursus->fields['timestart']." - ".$rs_kursus->fields['timeend'];
$masa_daftar = $rs_kursus->fields['masa_daftar'];
$masa_takimat = $rs_kursus->fields['masa_taklimat'];
$penyelia_nama = $rs_kursus->fields['penyelaras'];
$penyelia_notel = $rs_kursus->fields['penyelaras_notel'];
$penyelia_email = $rs_kursus->fields['penyelaras_email'];
$no_rujukan_surat = $rs_kursus->fields['no_rujukan_surat'];

$sqltempat = "SELECT A.f_bilik_nama, B.f_bb_desc  
FROM _tbl_bilikkuliah A, _ref_blok_bangunan B 
WHERE A.f_bb_id=B.f_bb_id AND A.f_bilikid=".tosql($rs_kursus->fields['bilik_kuliah']);
$rs_tempat = &$conn->query($sqltempat);
$nama_tempat = $rs_tempat->fields['f_bilik_nama'];
$nama_blok = $rs_tempat->fields['f_bb_desc'];
//$conn->debug=false;
if(!empty($nama_tempat)){ $nama_tempat = "( ".$nama_tempat." )"; } else { $nama_tempat=''; }

//$sqls = "SELECT * FROM "

$sqlk = "SELECT * FROM _ref_kampus WHERE kampus_id='{$kampus_id}'";
$kampus = &$conn->query($sqlk);
$kod_kampus = $kampus->fields['kampus_kod'];


$sqlu = "SELECT * FROM tbl_ilim WHERE 1";
$rsilim = &$conn->query($sqlu);
$pengarah = $rsilim->fields['nama_pengarah'];
$jawatan = $rsilim->fields['jawatan_pengarah'];
$nama_inst = $rsilim->fields['nama'];

$uid=$_SESSION["s_logid"];
$ip = $_SERVER['REMOTE_ADDR'];
$dt=date("Y-m-d H:i:s");

$sqlaudit = "INSERT INTO auditrail(kampus_id, log_user, ip, remarks, actions, trans_date) 
VALUES('{$kampus_id}', '{$uid}', '{$ip}', '{$kursus}', 'SURAT', '{$dt}')";
$conn->execute($sqlaudit);


//$conn->debug=true;
$sSQL = "SELECT A.*, B.f_peserta_nama, B.BranchCd, B.f_peserta_noic, B.f_peserta_alamat1 
FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
WHERE A.peserta_icno=B.f_peserta_noic AND A.is_deleted=0 AND A.is_selected IN (1) AND A.EventId=".tosql($id);
//print $sSQL."<br><br>"; //exit; 
$rs = &$conn->query($sSQL);
//$cnt = $rs->recordcount();
$bil=0;
print "KAMPUS:".$kampus_id;
if($_SESSION['session_userid']=='admin'){ exit; } exit;

while(!$rs->EOF){ $bil++; 
	
	$p_ic = $rs->fields['f_peserta_noic'];
	//print "<br>".$p_ic;
	
	if($kampus_id==1){
		//PROSES SURAT TAWARAN KEPADA PESERTA
		include 'jadual_peserta_pro_tawaran.php';
		// PROSES SURAT MAKLUMAN KEPADA MAJIKAN 
		include 'jadual_peserta_pro_majikan.php';
		// PROSES MAKLUMAT JAWAPAN KEHADIRAN
		include 'jadual_peserta_pro_kehadiran.php';
	} else if($kampus_id==2){
		//PROSES SURAT TAWARAN KEPADA PESERTA
		include 'jadual_peserta_pro_tawaran_iltim.php';
		// PROSES SURAT MAKLUMAN KEPADA MAJIKAN 
		include 'jadual_peserta_pro_majikan_iltim.php';
		// PROSES MAKLUMAT JAWAPAN KEHADIRAN
		include 'jadual_peserta_pro_kehadiran_iltim.php';
	}
	//exit;
	$rs->movenext();
	
}
//exit;
?>
<form name="ilim" method="post">
<table width="96%" border="1" cellpadding="3" cellspacing="0" align="center">
	<tr><td height="200px" align="center">
		Proses jana surat panggilan kursus telah dijalankan.
		<br /><br />
		<input type="button" value="OK" style="cursor:pointer" onclick="form_back()" />
	</td></tr>
</table>
</form>
