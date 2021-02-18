<?
include "../top/top.php";
?>
<script language="javascript">
	function do_submit(URL){
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
</script>
<?
$sort = $_GET['sort'];
$cari = $_POST['cari'];
if(!empty($_GET['cari'])){ $cari = $_GET['cari']; }

if($sort=='nama'){
	$sorder = " ORDER BY nama_kakitangan";
} else if($sort=='ic'){
	$sorder = " ORDER BY no_kp_kakitangan";
} else {
	$sorder = " ORDER BY nama_kakitangan";
}

//if(!empty($cari)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
if(!empty($cari)){ $scari = " WHERE nama_kakitangan LIKE '%" . addslashes($cari) ."%' "; } else { $scari = " "; }

$sSQL = "SELECT * FROM kakitangan " . $scari . $sorder;

//echo $sSQL;

include '../include/pageconf.inc.php'; // execute query
//echo $strSQL;
//$result = &$conn->Execute($sql);
//if(!$result){ echo "Invalid query : " . mysql_errno(); }
$pagepaparan = 'kakitangan1.php';
?>
<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
<form name="cari" method="post" action="kakitangan.php">
<table width="100%" cellpadding="5" cellspacing="1">
	<tr>
    	<td width="100%">Maklumat Carian : 
        <input type="text" name="cari" value="<?php echo $cari;?>" />
        &nbsp;&nbsp;
        <input type="submit" value="Cari" />
        </td>
    </tr>
</table>
</form>
<?php include_once '../include/pagepaparan.inc.php';// display record count and list?>
<form name="frm" method="post">
<table width="100%" border="1" cellspacing="1" cellpadding="5">
  <tr class="listhead">
    <td width="5%">Bil</td>
    <td width="30%"><a href="<?=$pagepaparan?>?sort=nama">Nama Kakitangan</a></td>
    <td width="10%"><a href="<?=$pagepaparan?>?sort=ic">NO KP</a></td>
    <td width="20%">Jawatan</td>
    <td width="30%">Bahagian</td>
    <td width="5%">Gred</td>
    <td width="5%">Kelas</td>
  </tr>
<?
$i = 1;
$bil = 0;
while ($row=mysql_fetch_array($result,MYSQL_BOTH)){
	$bil = $i + ($PageNo-1)*$PageSize;
	$i++;
?>
  <tr class="list" bgcolor="<?php if ($i%2 == 1) echo $bg1; else echo $bg2 ?>">
    <td><?=$bil;?></td>
    <td><a href="kakitangan1_form.php?id=<?php echo $row['id_kakitangan']?>&PageNo=<?php echo $PageNo;?>"><?php echo $row['nama_kakitangan']?></a></td>
    <td><?=$row['no_kp_kakitangan']?></td>
    <td><?php print $row['jawatan_kakitangan']?></td>
    <td><?php print dlookup("bahagian","nama_bahagian","id_bahagian=".tosql($row['id_bahagian'],"Number"))?></td>
    <td><?php print $row['gred']?></td>
    <td><?php print $row['kelas']?></td>
  </tr>
<?
} // end loop
?>
</table>
<?php 
$syarat = "pglst=$PageQUERY&cari=$cari"; 
include_once '../include/paging.inc.php';
?>
<div align="center"><input type="button" value="Tambah" onclick="do_submit('kakitangan1_form.php')" /></div>
</form>
</td></tr>
</table>
<?php include "../top/footer.php"; ?>
