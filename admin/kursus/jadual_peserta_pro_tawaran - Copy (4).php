<?php
$surat = $surat_tawaran;

/*$surat = str_replace('!TARIKH!', date("d-m-Y"), $surat);
$surat = str_replace('!NAMA!', strtoupper($rs->fields['f_peserta_nama']), $surat);
$surat = str_replace('!ALAMAT!', strtoupper(nl2br($rs->fields['f_peserta_alamat1'])), $surat);
$surat = str_replace('!KURSUS!', strtoupper($rs->fields['course_name']), $surat);
$surat = str_replace('!tarikh_mula!', DisplayDate($rs_kursus->fields['startdate']), $surat);
*/
$surat = str_replace('!tkh_kini!', date("d-m-Y"), $surat);
$surat = str_replace('!tarikh_kursus!', date("d-m-Y"), $surat);
$surat = str_replace('!NAMA!', strtoupper($rs->fields['f_peserta_nama']), $surat);
$surat = str_replace('!nama_tempat!', strtoupper(nl2br($rs->fields['f_peserta_alamat1'])), $surat);
$surat = str_replace('!tajuk_kursus!', strtoupper($rs->fields['course_name']), $surat);
$surat = str_replace('!tarikh_mula!', DisplayDate($rs_kursus->fields['startdate']), $surat);

$surat = str_ireplace('"', '', $surat);
	
$sqlu_peserta = "UPDATE _tbl_kursus_jadual_peserta SET surat_tawaran=".tosql(addslashes($surat))."
WHERE InternalStudentId=".tosql($rs->fields['InternalStudentId']);
//print "<br>".$bil." : ".$sqlu_peserta."<br><br>";
//if($rs->fields['f_peserta_nama']=='FARALIZA BINTI MD. SALLEH'){ $conn->debug=true; }
$conn->execute($sqlu_peserta);
//$conn->debug=false;
?>