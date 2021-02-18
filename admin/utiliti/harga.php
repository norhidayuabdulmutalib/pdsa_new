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
	$sorder = " ORDER BY destinasi";
/*} else if($sort=='ic'){
	$sorder = " ORDER BY no_kp_kakitangan";
} else {
	$sorder = " ORDER BY nama_kakitangan";*/
}

//if(!empty($cari)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
if(!empty($cari)){ $scari = " WHERE destinasi LIKE '%" . $cari ."%' "; } else { $scari = " "; }

$sSQL = "SELECT * FROM harga " . $scari . $sorder;

//echo $sSQL;

include '../include/pageconf.inc.php'; // execute query
//echo $strSQL;
//$result = &$conn->Execute($sql);
//if(!$result){ echo "Invalid query : " . mysql_errno(); }
$pagepaparan = 'harga.php';
?>
<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
<form name="cari" method="post" action="harga.php">
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
    <td width="30%"><a href="<?=$pagepaparan?>?sort=nama">Destinasi</a></td>
    <td width="30%">Kelas</td>
    <td width="20%">Sehala</td>
    <td width="20%">Dua Hala</td>
    <td width="5%">Cukai</td>
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
    <td><a href="harga_form.php?id=<?php echo $row['id_harga']?>&PageNo=<?php echo $PageNo;?>"><?php echo $row['destinasi']?></a></td>
    <td><?=$row['kelas']?></td>
    <td><?php print $row['sehala']?></td>
     <td><?php print $row['dua_hala']?></td>
    <td><?php print $row['cukai']?></td>
  </tr>
<?
} // end loop
?>
</table>
<?php 
$syarat = "pglst=$PageQUERY&cari=$cari"; 
include_once '../include/paging.inc.php';
?>
<div align="center"><input type="button" value="Tambah" onclick="do_submit('harga_form.php')" /></div>
</form>
</td></tr>
</table>
<?php include "../top/footer.php"; ?>
