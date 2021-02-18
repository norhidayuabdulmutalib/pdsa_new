<script language="javascript">
	function do_submit(URL){
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
</script>
<?php
$lj_dewan=isset($_REQUEST["lj_dewan"])?$_REQUEST["lj_dewan"]:"";
$sort=isset($_REQUEST["sort"])?$_REQUEST["sort"]:"";
$cari=isset($_REQUEST["cari"])?$_REQUEST["cari"]:"";

//if(!empty($cari)){ $cari = $_GET['cari']; }
//if(!empty($cari)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
if(!empty($lj_dewan)){ $scari = " WHERE j_dewan LIKE '%" . addslashes($lj_dewan) ."%' "; } else { $scari = " "; }
$sSQL = "SELECT * FROM kod_sidang " . $scari . " ORDER BY tahun DESC, start_dt DESC";
$rs = &$conn->execute($sSQL);
include 'include/pageconf.inc.php'; // execute query
$pagepaparan = 'index.php?data='.base64_encode('4;utiliti/sidang.php');
?>
<div><h2>SENARAI MAKLUMAT PERSIDANGAN</h2></div>

<table width="95%" cellpadding="0" cellspacing="0" align="center">
  <?
  $sqlkd = "SELECT * FROM kod_dewan";
  $rowkd = &$conn->Execute($sqlkd);
  ?>
  <tr>
    <td align="left"><b>Dewan : </b>
        <select name="lj_dewan"  onchange="do_page('<?=$pagepaparan;?>')">
            <option value="">-- Sila pilih --</option>
        <?php while(!$rowkd->EOF){ ?>
            <option value="<?=$rowkd->fields['j_dewan']?>" <?php if($lj_dewan==$rowkd->fields['j_dewan']){ echo 'selected'; }?>>
            <?=$rowkd->fields['dewan'];?></option>
        <?php $rowkd->movenext(); } ?>
        </select><br /><br />
    </td>
  </tr>
	<tr><td width="100%">
      <?php include_once 'include/pagepaparan.inc.php';// display record count and list?>
  <table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr align="center" class="table_head">
      <td width="5%"><strong>Bil</strong></td>
      <td width="45%"><strong>Maklumat Persidangan</strong></td>
      <td width="15%"><strong>Dewan Persidangan</strong></td>
      <td width="10%"><strong>Tarikh Mula</strong></td>
      <td width="10%"><strong>Tarikh Akhir</strong></td>
      <td width="7%"><strong>Tahun</strong></td>
      <td width="8%"><strong>Status</strong></td>
    </tr>
<?php
if(!$rs->EOF){
	$cnt = 1;
	$bil = $StartRec;
	while(!$rs->EOF  && $cnt <= $pg) {
		$bil = $cnt + ($PageNo-1)*$PageSize;
		$i++;
?>
    <tr>
      <td align="right"><?=$bil;?>.</td>
      <td align="left"><a href="index.php?data=<?=base64_encode('4;utiliti/sidang_form.php;'.$rs->fields['id_sidang']);?>&PageNo=<?php echo $PageNo;?>"><?php echo $rs->fields['persidangan']?></a></td>
      <td align="center"><?=dlookup("kod_dewan","dewan","j_dewan=".tosql($rs->fields['j_dewan'],"Number"));?></td>
      <td align="center"><?=DisplayDate($rs->fields['start_dt']);?></td>
      <td align="center"><?=DisplayDate($rs->fields['end_dt']);?></td>
      <td align="center"><?=$rs->fields['tahun'];?></td>
      <td  align="center"><?php if($rs->fields['status']==0){ print 'Aktif'; } else { print 'Tidak Aktif'; } ?></td>
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
<div align="center"><input type="button" id="button" value="Tambah" onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/sidang_form.php;');?>')" /></div>
</td></tr>
</table>
