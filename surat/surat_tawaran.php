<?php
include '../common.php';
//$conn->debug=true;
$ic=isset($_REQUEST["ic"])?$_REQUEST["ic"]:"";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";

$kandungan_surat = dlookup("_tbl_kursus_jadual_peserta","surat_tawaran","peserta_icno=".tosql($ic,"Text"). " AND EventId=".tosql($id));
//$kandungan_surat = dlookup("_tbl_surat","surat","surat_jenis='T' AND peserta_icno=".tosql($ic,"Text"). " AND EventId=".tosql($id));
print stripcslashes($kandungan_surat);
?>