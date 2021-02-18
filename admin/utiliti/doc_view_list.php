<script language="javascript">
	function do_submit(URL){
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
	function do_cetak(id){
		document.frm.doc_id.value = id;
		document.frm.action = 'laporan/doc_rujukan_cetak.php';
		document.frm.target = '_blank';
		document.frm.submit();
	}
</script>
<?php
$cari=isset($_REQUEST["cari"])?$_REQUEST["cari"]:"";
$sort=isset($_REQUEST["sort"])?$_REQUEST["sort"]:"";

if($sort=='nama'){
	$sorder = " ORDER BY dokumen_tajuk";
} else {
	$sorder = " ORDER BY dokumen_tajuk";
}

//if(!empty($cari)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
if(!empty($cari)){ $scari = " AND dokumen_tajuk LIKE '%" . addslashes($cari) ."%' "; } else { $scari = " "; }
$sSQL = "SELECT * FROM doc_rujukan WHERE doc_status=0 AND doc_type='DOC' " . $scari . $sorder;
$rs = &$conn->execute($sSQL);

include 'include/pageconf.inc.php'; // execute query
$pagepaparan = 'index.php?data='.base64_encode('rujukan;utiliti/doc_view_list.php');
?>
<div><h2>SENARAI DOKUMEN RUJUKAN</h2></div>
<table width="95%" cellpadding="0" cellspacing="0" align="center">
	<tr><td width="100%">
      <?php include_once 'include/pagepaparan.inc.php';// display record count and list?>
  <table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr align="center" class="table_head">
      <td width="7%"><strong>Bil</strong></td>
      <td width="83%"><strong>Nama Dokumen</strong></td>
      <td width="10%">&nbsp;</td>
    </tr>
<?php
if(!$rs->EOF){
	$cnt = 1;
	$bil = $StartRec;
	while(!$rs->EOF  && $cnt <= $pg) {
		$bil = $cnt + ($PageNo-1)*$PageSize;
		$i++;
		$is_doc = $rs->fields['is_doc'];
		if(!empty($is_doc)){
			$sql_doc = "SELECT * FROM tbl_attachment WHERE soalan_id=".tosql($rs->fields['doc_id'],"Text");
			$rs_doc = &$conn->Execute($sql_doc);
			//$bil = 0;
			$tajuk = $rs_doc->fields['file_tajuk'];
			$href = "doc/".$rs_doc->fields['file_name'];
		} else {
			$tajuk = $rs->fields['dokumen_tajuk'];
			$href = "index.php?data=".base64_encode('rujukan;utiliti/doc_view_rujukan.php;'.$rs->fields['doc_id']);
		}
?>
    <tr>
      <td align="right"><?=$bil;?>.</td>
      <td align="left"><a href="<?=$href;?>"><?php echo $tajuk;?></a></td>
      <td align="center">
      	<?php if(empty($is_doc)){ ?>
        <img src="img/printer.png" border="0" title="Cetak Dokumen Rujukan" style="cursor:pointer" onclick="do_cetak('<?=$rs->fields['doc_id']?>')" />
      	<?php } ?>
      </td>
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
  <input type="hidden" name="doc_id" />
<?php
$namafail =  $pagepaparan;  
$syarat = "pglst=$PageQUERY&cari=$cari"; 
include_once 'include/paging.inc.php';
?>
</td></tr>
</table>
