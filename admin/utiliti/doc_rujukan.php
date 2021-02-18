<script language="javascript">
	function do_submit(URL){
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
</script>
<?php
$cari=isset($_REQUEST["cari"])?$_REQUEST["cari"]:"";

$sorder = " ORDER BY update_dt DESC";
//if(!empty($cari)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
if(!empty($cari)){ $scari = " AND dokumen_tajuk LIKE '%" . addslashes($cari) ."%' "; } else { $scari = " "; }
$sSQL = "SELECT * FROM doc_rujukan WHERE doc_type='DOC' " . $scari . $sorder;
$rs = &$conn->execute($sSQL);

$pagepaparan = 'index.php?data='.base64_encode('4;utiliti/doc_rujukan.php');
?>
<div><h2>SENARAI DOKUMEN RUJUKAN</h2></div>
<table width="100%" cellpadding="0" cellspacing="0" align="center">
	<tr><td width="100%">
      <?php include 'include/pageconf.inc.php'; // execute query
		include_once 'include/pagepaparan.inc.php';// display record count and list?>
  <table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr class="table_head">
      <td width="7%" align="center"><b>Bil</b></td>
      <td width="70%" align="center"><b>Nama Dokumen</b></td>
      <td width="13%" align="center"><b>Tarikh Kemaskini</b></td>
      <td width="10%" align="center"><b>Status</b></td>
    </tr>
<?php
if(!$rs->EOF){
	$cnt = 1;
	$bil = $StartRec;
	while(!$rs->EOF  && $cnt <= $pg) {
		$bil = $cnt + ($PageNo-1)*$PageSize;
		$i++;
?>
    <tr >
      	<td align="right"><?=$bil;?>.</td>
      	<td align="left"><a href="index.php?data=<?=base64_encode('4;utiliti/doc_rujukan_form.php;'.$rs->fields['doc_id']);?>&PageNo=<?php echo $PageNo;?>"><?php echo $rs->fields['dokumen_tajuk']?></a></td>
    	<td align="center"><?php print $rs->fields['update_dt']; ?></td>
    	<td align="center"><?php if($rs->fields['doc_status']=='0'){ print 'Aktif'; } else { print 'Tidak Aktif'; } ?></td>
    </tr>
<?php
		$cnt = $cnt + 1;
		$bil = $bil + 1;
		$rs->movenext();
	}
}
?>
  </table>
<br />
<?php
$namafail =  $pagepaparan;  
$syarat = "pglst=$PageQUERY&cari=$cari"; 
include_once 'include/paging.inc.php';
?>
<div align="center"><input type="button" id="button" value="Tambah" onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/doc_rujukan_form.php;');?>')" /></div>
</td></tr>
</table>
