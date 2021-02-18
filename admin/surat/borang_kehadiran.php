<style type="text/css" media="all">
	table, tr, td, tbody, thead{
		border-collapse: collapse;
		font-family:Tahoma, Geneva, sans-serif;
		font-size: 10pt;
	}
</style>

<?php
include '../common.php';
//$conn->debug=true;
$ic=isset($_REQUEST["ic"])?$_REQUEST["ic"]:"";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";

$kandungan_surat = dlookup("_tbl_kursus_jadual_peserta","surat_jawapan","peserta_icno=".tosql($ic,"Text"). " AND EventId=".tosql($id));
//$kandungan_surat = dlookup("_tbl_surat","surat","surat_jenis='T' AND peserta_icno=".tosql($ic,"Text"). " AND EventId=".tosql($id));
print stripcslashes($kandungan_surat);
?>