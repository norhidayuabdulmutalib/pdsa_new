<?php 
include_once '../../common.php';
//$conn->debug=true;
//$proses = $_GET['pro'];
$pids=$_GET['pids'];
$nama=$_GET['nama'];
$nokp=$_GET['nokp'];
$sql = "UPDATE _tbl_kursus_luarpeserta SET nama_peserta=".tosql($nama).", no_kp=".tosql($nokp)." 
	WHERE pids=".tosql($pids);
$rs = &$conn->Execute($sql); //exit;
?>