<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td width="100%" height="150px" bgcolor="#FFFFFF">
<?php
//$conn->debug=true;
include 'loading.php';
$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";

$doc_id=isset($_REQUEST["doc_id"])?$_REQUEST["doc_id"]:"";
$dokumen_tajuk=isset($_REQUEST["dokumen_tajuk"])?$_REQUEST["dokumen_tajuk"]:"";
$dokumen=isset($_REQUEST["dokumen"])?$_REQUEST["dokumen"]:"";
$doc_status=isset($_REQUEST["doc_status"])?$_REQUEST["doc_status"]:"";
$is_doc=isset($_REQUEST["is_doc"])?$_REQUEST["is_doc"]:"";


// proses penghapusan data
if($actions=='DELETE'){
	$sql = "DELETE FROM doc_rujukan WHERE doc_id=".tosql($doc_id,"Text");
	$result = &$conn->Execute($sql);
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	//echo $sql;
	//ecit;
	$url = base64_encode('4;utiliti/doc_rujukan.php;');
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	//echo '<meta http-equiv="refresh" content="1; URL=kategori.php">';
} else {
	//print "DOC:".$doc_id; exit;
	if(!empty($dokumen)){
		if(empty($doc_id)){
			// proses kemasukan data
			$doc_id = date("Ymd"). uniqid();
			$sql = "INSERT INTO doc_rujukan(doc_id, dokumen_tajuk, dokumen, doc_status, is_doc, create_dt, update_dt)
			VALUES(".tosql($doc_id,"Text").", ".tosql(strtoupper($dokumen_tajuk),"Text").", ".tosql($dokumen,"Text").", ".
			tosql($doc_status,"Text").", ".tosql($is_doc,"Text").", ".tosql(date("Y-m-d H:i:s"),"Text").", ".tosql(date("Y-m-d H:i:s"),"Text").")";
			$result = &$conn->Execute($sql);
			//if(!$result){ echo "Invalid query : " . mysql_error(); }
			$id_kategori = mysql_insert_id();
			$url = base64_encode('4;utiliti/doc_rujukan_form.php;'.$doc_id);
			//$url = base64_encode('utiliti/doc_rujukan.php;');
			echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
			//echo '<meta http-equiv="refresh" content="1; URL=kategori_form.php?id='.$id_kategori.'&PageNo='.$PageNo.'">';
		
		} else if(!empty($doc_id)){
			// proses kemaskini data
			$sql = "UPDATE doc_rujukan SET dokumen_tajuk=".tosql(strtoupper($dokumen_tajuk),"Text").", dokumen=".tosql($dokumen,"Text").", 
			doc_status=".tosql($doc_status,"Text").", update_dt=".tosql(date("Y-m-d H:i:s"),"Text");
			$sql .= ", is_doc=".tosql($is_doc,"Number");
			$sql .= " WHERE doc_id=".tosql($doc_id,"Text");
			$result = &$conn->Execute($sql);
			//print $sql; exit;
			//if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
			//$url = base64_encode('utiliti/doc_rujukan_form.php;'.$doc_id);
			$url = base64_encode('4;utiliti/doc_rujukan_form.php;'.$doc_id);
			echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
		} 
	} else {
		print '<script language="javascript">alert("Sila pastikan maklumat dokumendilengkapkan");</script>';
		$url = base64_encode('4;utiliti/doc_rujukan_form.php;'.$doc_id);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
		exit;
	}
}
//exit;
?>
&nbsp;</td></tr>
</table>
