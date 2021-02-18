<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td width="100%" height="150px" bgcolor="#FFFFFF">
<?php
include 'loading.php';
$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";

$id_sidang=isset($_REQUEST["id_sidang"])?$_REQUEST["id_sidang"]:"";
$j_dewan=isset($_REQUEST["j_dewan"])?$_REQUEST["j_dewan"]:"";
$persidangan=isset($_REQUEST["persidangan"])?$_REQUEST["persidangan"]:"";
$start_dt=isset($_REQUEST["start_dt"])?$_REQUEST["start_dt"]:"";
$end_dt=isset($_REQUEST["end_dt"])?$_REQUEST["end_dt"]:"";
$tahun=isset($_REQUEST["tahun"])?$_REQUEST["tahun"]:"";
$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";

$start = explode("-",$start_dt);
$startday = mktime(0, 0, 0, $start[1], $start[2], $start[0]); //sec,min,hr,mth,day,yr
$end = explode("-",$end_dt);
$endday =  mktime(0, 0, 0, $end[1], $end[2], $end[0]); //sec,min,hr,mth,day,yr
$diff = ($endday - $startday) / 86400;

$dewan = dlookup("kod_dewan","dewan","j_dewan=".tosql($j_dewan,"Number"));
//exit;

// proses penghapusan data
if($actions=='DELETE'){
	$sql = "DELETE FROM kod_sidang WHERE id_sidang=".tosql($id_sidang,"Number");
	$result = &$conn->Execute($sql);
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	$url = base64_encode('4;utiliti/sidang.php;');
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
} else {

	if($actions=='INSERT'){
		// proses kemasukan data
		$sql = "INSERT INTO kod_sidang(j_dewan, persidangan, tahun, status, start_dt, end_dt)
		VALUES(".tosql($j_dewan,"Number").", ".tosql($persidangan,"Text").", ".tosql($tahun,"Text").", 
		".tosql($status,"Number").", ".tosql(DBDate($start_dt),"Text").", ".tosql(DBDate($end_dt),"Text").")";
		$result = &$conn->Execute($sql);
		//if(!$result){ echo "Invalid query : " . mysql_error(); exit;}
		$id_sidang = mysql_insert_id();
		
		for($i=0;$i<=$diff;$i++){
			// hanya dari hari osnin ke khamis sahaja
			//$saat = 24 * 60 * 60 * $i;
			$dt = $startday + (86400*$i);
			//echo $dt . " : ";
			$tkh = date("Y-m-d", $dt); // ."<br>";
			$sql = "SELECT * FROM jadual_tugas WHERE jad_tkh=".tosql($tkh,"Text")." AND id_sidang=".tosql($id_sidang,"Number");
			$result = &$conn->Execute($sql);
			$num_row = $result->recordcount();
			if($num_row==0){
				$sql_ins = "INSERT INTO jadual_tugas(id_sidang, jad_tkh, dewan) 
				VALUES(".tosql($id_sidang,"Number").", ".tosql($tkh,"Text").", ".tosql($dewan,"Text").")";
				$conn->Execute($sql_ins);
			}
		}
		
		//$url = base64_encode('utiliti/sidang_form.php;'.$id_sidang);
		$url = base64_encode('4;utiliti/sidang.php;');
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	
	} else if($actions=='UPDATE'){
		// proses kemaskini data
		$sql = "UPDATE kod_sidang SET j_dewan=".tosql($j_dewan,"Number").", persidangan=".tosql($persidangan,"Text").", 
		tahun=".tosql($tahun,"Text").", status=".tosql($status,"Number").",
		start_dt=".tosql(DBDate($start_dt),"Text").", end_dt=".tosql(DBDate($end_dt),"Text");
		$sql .= " WHERE id_sidang=".tosql($id_sidang,"Number");
		$result = &$conn->Execute($sql);
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }

		$sqlq = " AND pegawai1=0 AND pegawai2=0 AND pegawai3=0 ";
		$sql = "DELETE FROM jadual_tugas WHERE jad_tkh>".tosql($end_dt)." AND id_sidang=".tosql($id_sidang,"Number").$sqlq;
		//print $sql."<br>";
		$conn->Execute($sql);
		
		$sql = "DELETE FROM jadual_tugas WHERE jad_tkh<".tosql($end_dt)." AND id_sidang=".tosql($id_sidang,"Number").$sqlq;
		//print $sql."<br>";
		$conn->Execute($sql);

		for($i=0;$i<=$diff;$i++){
			//$saat = 24 * 60 * 60 * $i;
			$dt = $startday + (86400*$i);
			//echo $dt . " : ";
			$tkh = date("Y-m-d", $dt); // ."<br>";
			$sql = "SELECT * FROM jadual_tugas WHERE jad_tkh=".tosql($tkh,"Text")." AND id_sidang=".tosql($id_sidang,"Number");
			$result = &$conn->Execute($sql);
			$num_row = $result->recordcount();
			if($num_row==0){
				$sql_ins = "INSERT INTO jadual_tugas(id_sidang, jad_tkh, dewan) 
				VALUES(".tosql($id_sidang,"Number").", ".tosql($tkh,"Text").", ".tosql($dewan,"Number").")";
				$conn->Execute($sql_ins);
			}
		}

		$url = base64_encode('4;utiliti/sidang.php;');
		//$url = base64_encode('utiliti/sidang_form.php;'.$id_sidang);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	} 
}
?>
&nbsp;</td></tr>
</table>
