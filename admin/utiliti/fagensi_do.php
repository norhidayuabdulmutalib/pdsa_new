<?
include 'loading.php';
include_once '../common.php';
include_once '../include/dateformat.php';

$actions = $_POST['actions'];
$PageNo = $_POST['PageNo'];

$id_agensi= $_POST['id_agensi'];
$nama_agensi = $_POST['nama_agensi'];
$no_pendaftaran = $_POST['no_pendaftaran'];
$alamat1 = $_POST['alamat1'];
$bandar = $_POST['bandar'];
$poskod = $_POST['poskod'];
$negeri = $_POST['negeri'];
$no_tel = $_GET['no_tel'];
$status = $_POST['status'];
$level = $_GET['level'];
$pegawai_agensi = $_POST['pegawai_agensi'];
$no_handphone = $_GET['no_handphone'];


// proses penghapusan data
if($act=='DELETE'){
	$sql = "DELETE FROM agensi WHERE id_agensi=$id_agensi";
	$result = &$conn->Execute($sql);
	if(!$result){ echo "Invalid query : " . mysql_errno(); }
	echo '<meta http-equiv="refresh" content="1; URL=agensi1.php">';
} else {

	if($actions=='INSERT'){
		// proses kemasukan data
		$sql = "INSERT INTO agensi(nama_agensi, no_pendaftaran, alamat1, bandar, poskod, 
		negeri, no_tel, status, level, pegawai_agensi, no_handphone)
		VALUES('$nama_agensi', '$no_pendaftaran', '$alamat1', '$bandar', '$poskod', 
		'$negeri', '$no_tel', '$status', '$level','$pegawai_agensi', '$no_handphone' )";
		$result = &$conn->Execute($sql);
		if(!$result){ echo "Invalid query : " . mysql_error(); }
		$id_agensi = mysql_insert_id();
		echo '<meta http-equiv="refresh" content="1; URL=agensi_form.php?id='.$id_agensi.'&PageNo='.$PageNo.'">';
	
	} else if($actions=='UPDATE'){
		// proses kemaskini data
		$sql = "UPDATE agensi SET nama_agensi='$nama_agensi', no_pendaftaran='$no_pendaftaran', 
		alamat1='$alamat1',
		bandar='$bandar', poskod='$poskod', negeri='$negeri', no_tel='$no_tel', 
		status='$status', level='$level', pegawai_agensi='$pegawai_agensi', no_handphone='$no_handphone' ";
		$sql .= " WHERE id_agensi=$id_agensi";
		$result = &$conn->Execute($sql);
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		echo '<meta http-equiv="refresh" content="1; URL=agensi_form.php?id='.$id_agensi.'&PageNo='.$PageNo.'">';
	} 
}
?>
