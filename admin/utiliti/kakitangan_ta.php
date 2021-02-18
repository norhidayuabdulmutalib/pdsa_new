<link rel="stylesheet" href="modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="modalwindow/dhtmlwindow.js">

/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<script type="text/javascript" src="modalwindow/modal.js"></script>
<script type="text/javascript">
function opennewsletter(kid){
	var URL = "utiliti/kakitangan_menu.php";
	URL = URL + '?kid=' + kid;
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Maklumat Capaian Menu', 'width=750px,height=500px,center=1,resize=0,scrolling=1')
} //End "opennewsletter" function
function opennewsletter1(kid, nokp){
	var URL = "utiliti/kakitangan_pass.php";
	URL = URL + '?kid=' + kid + '&nokp=' + nokp;
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Kemaskini Katalaluan', 'width=550px,height=200px,center=1,resize=0,scrolling=1')
} //End "opennewsletter" function
</script>
<script language="javascript">
	function do_submit(URL){
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
</script>
<?php
$sort = $_GET['sort'];
//$bahagian = $_POST['bahagian'];
if(!empty($_POST['bhg'])){ $bhg = $_POST['bhg']; } else { $bhg = $_GET['bhg']; }
//$cari = $_POST['cari'];
if(!empty($_POST['cari'])){ $cari = $_POST['cari']; } else { $cari = $_GET['cari']; }

if($sort=='nama'){
	$sorder = " ORDER BY nama_kakitangan";
} else if($sort=='ic'){
	$sorder = " ORDER BY no_kp_kakitangan";
} else {
	$sorder = " ORDER BY nama_kakitangan";
}

$scari = " ";
//if(!empty($cari)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
if(!empty($bhg)){ $scari = " AND id_bahagian =" . tosql($bhg,"Number") ." "; } 
if(!empty($cari)){ $scari = " AND ( nama_kakitangan LIKE '%" . addslashes($cari) ."%' OR no_kp_kakitangan LIKE '%" . addslashes($cari) ."%' ) "; } 

$sSQL = "SELECT * FROM kakitangan WHERE id_kakitangan<>0 AND status=1 AND (is_delete=1 OR is_delete=0)" . $scari . $sorder;
$rs = &$conn->execute($sSQL);
include 'include/pageconf.inc.php'; // execute query
$pagepaparan = 'index.php?data='.base64_encode('4;utiliti/kakitangan_ta.php');
?>
<div><h2>SENARAI MAKLUMAT NAMA KAKITANGAN - Tidak Aktif</h2></div>
<table width="95%" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
<table width="100%" cellpadding="3" cellspacing="0">
	  <?
      $sqlb = "SELECT * FROM kod_bahagian order by nama_bahagian";
      $rowb = &$conn->Execute($sqlb);
      ?>
      <tr>
        <td align="left" width="20%"><strong>Bahagian :</strong></td>
        <td align="left" width="80%">
            <select name="bhg" onchange="do_submit('index.php?data=<?=base64_encode('4;utiliti/kakitangan_ta.php;')?>')">
                <option value=""> -- Sila pilih bahagian -- </option>
            <?php while(!$rowb->EOF){ ?>
                <option value="<?=$rowb->fields['id_bahagian']?>" <?php if($bhg==$rowb->fields['id_bahagian']){ echo 'selected'; }?>><?=$rowb->fields['nama_bahagian'];?></option>
            <?php $rowb->movenext(); } ?>
            </select>
        </td>
      </tr>
	<tr>
    	<td align="left"><strong>Maklumat Carian : </strong></td>
        <td align="left">
        <input type="text" name="cari" value="<?php echo $cari;?>" />
        &nbsp;&nbsp;
        <input type="button" id="button" value="Cari" onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/kakitangan_ta.php;')?>')" />
        </td>
    </tr>
</table>
<br />
<?php include_once 'include/pagepaparan.inc.php';// display record count and list?>
  <table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr align="center" class="table_head">
    <td width="5%"><strong>Bil</strong></td>
    <td width="25%"><strong>Nama Kakitangan</strong></td>
    <td width="20%"><strong>Jawatan</strong></td>
    <td width="25%"><strong>Bahagian</strong></td>
    <td width="5%"><strong>Status</strong></td>
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
    <td align="left"><a href="index.php?data=<?=base64_encode('4;utiliti/kakitangan_form.php;'.$rs->fields['id_kakitangan']);?>&PageNo=<?php echo $PageNo;?>"><?php echo $rs->fields['nama_kakitangan']?></a></td>
    <td><?php print $rs->fields['jawatan_kakitangan']?></td>
    <td><?php print dlookup("kod_bahagian","nama_bahagian","id_bahagian=".tosql($rs->fields['id_bahagian'],"Number"))?></td>
    <td align="center">Tidak Aktif</td>
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
</td></tr>
</table>
