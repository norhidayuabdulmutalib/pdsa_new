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
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Kemaskini Katalaluan', 'width=50px,height=10px,center=1,resize=0,scrolling=1')
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
$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";
$sort = isset($_REQUEST['sort'])?$_REQUEST['sort']:"";
$bhg = isset($_REQUEST['bhg'])?$_REQUEST['bhg']:"";
$cari = isset($_REQUEST['cari'])?$_REQUEST['cari']:"";

//if(!empty($_POST['bhg'])){ $bhg = $_POST['bhg']; } else { $bhg = $_GET['bhg']; }
//$cari = $_POST['cari'];
//if(!empty($_POST['cari'])){ $cari = $_POST['cari']; } else { $cari = $_GET['cari']; }

if($sort=='nama'){
	$sorder = " ORDER BY nama_kakitangan";
} else if($sort=='ic'){
	$sorder = " ORDER BY no_kp_kakitangan";
} else {
	$sorder = " ORDER BY id_bahagian, nama_kakitangan";
}

$scari = " ";
//if(!empty($cari)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
if(!empty($status)){ $scari .= " AND type =" . tosql($status,"Text") ." "; } 
if(!empty($bhg)){ $scari .= " AND id_bahagian =" . tosql($bhg,"Number") ." "; } 
if(!empty($cari)){ $scari .= " AND ( nama_kakitangan LIKE '%" . addslashes($cari) ."%' OR no_kp_kakitangan LIKE '%" . addslashes($cari) ."%' ) "; } 

$sSQL = "SELECT * FROM kakitangan WHERE id_kakitangan<>0 AND status=0 AND is_delete = 0" . $scari . $sorder;
$rs = &$conn->execute($sSQL);

include 'include/pageconf.inc.php'; // execute query

$pagepaparan = 'index.php?data='.base64_encode('4;utiliti/kakitangan.php').'&cari='.$cari.'&bhg='.$bhg.'&sort='.$sort.'&status='.$status;
?>
<div><h2>SENARAI MAKLUMAT KAKITANGAN</h2></div>
<table width="100%" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
<table width="100%" cellpadding="2" cellspacing="1">
	  <?php
      $sqlb = "SELECT * FROM kod_bahagian order by nama_bahagian";
      $res_b = &$conn->Execute($sqlb);
      ?>
      <tr>
        <td align="right" width="20%"><b>Bahagian : </b></td>
        <td align="left" width="80%">
            <select name="bhg" onchange="do_submit('index.php?data=<?=base64_encode('4;utiliti/kakitangan.php;')?>')">
                <option value=""> -- Sila pilih bahagian -- </option>
            <?php while(!$res_b->EOF){ ?>
                <option value="<?=$res_b->fields['id_bahagian']?>" <?php if($bhg==$res_b->fields['id_bahagian']){ echo 'selected'; }?>><?=$res_b->fields['nama_bahagian'];?></option>
            <?php $res_b->movenext(); } ?>
            </select>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <b>Status : </b>
            <select name="status" id="status" onchange="do_submit('index.php?data=<?=base64_encode('4;utiliti/kakitangan.php;')?>')">
            	<option value="">-- Semua status --</option>
                <option value="A" <?php if($status=='A'){ echo 'selected'; }?>>Administrator</option>
                <option value="U" <?php if($status=='U'){ echo 'selected'; }?>>Urusetia Parlimen</option>
                <option value="B" <?php if($status=='B'){ echo 'selected'; }?>>Penyelaras Bahagian / Penyedia Jawapan</option>
                <option value="P" <?php if($status=='P'){ echo 'selected'; }?>>Pegawai Bertugas</option>
            </select>
        </td>
      </tr>
	<tr>
    	<td align="right"><b>Maklumat Carian : </b></td>
        <td align="left">
        <input type="text" name="cari" value="<?php echo $cari;?>" />
        &nbsp;&nbsp;
        <input type="button" id="button" value="Cari" onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/kakitangan.php;')?>')" />
        &nbsp;&nbsp;
        <input type="button" id="button" value="Tambah" onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/kakitangan_form.php;')?>')" />
        </td>
    </tr>
</table>
<br />
<?php include_once 'include/pagepaparan.inc.php';// display record count and list?>
  <table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr align="center" class="table_head">
    <td width="5%"><b>Bil</b></td>
    <td width="25%"><b>Nama Kakitangan</b></td>
    <td width="20%"><b>Jawatan</b></td>
    <td width="25%"><b>Bahagian</b></td>
    <td width="10%"><b>User Id</b></td>
    <td width="10%"><b>Status</b></td>
    <td width="5%">&nbsp;</td>
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
    <td align="left">
    <a href="index.php?data=<?=base64_encode('4;utiliti/kakitangan_form.php;'.$rs->fields['id_kakitangan']);?>&PageNo=<?php echo $PageNo;?>&status=<?php echo $status;?>&bhg=<?php echo $bhg;?>&sort=<?php echo $sort;?>&cari=<?php echo $cari;?>">
		<?php echo $rs->fields['nama_kakitangan']?></a></td>
    <td><?php print $rs->fields['jawatan_kakitangan']?></td>
    <td><?php print dlookup("kod_bahagian","nama_bahagian","id_bahagian=".tosql($rs->fields['id_bahagian'],"Number"))?></td>
    <td><?php print $rs->fields['userid']?></td>
    <td align="center">
	<?php 
	if($rs->fields['type']=='U'){
		print 'Urusetia Parlimen';
	} else if($rs->fields['type']=='P'){
		print 'Pegawai Bertugas';
	} else if($rs->fields['type']=='B'){
		print 'Pengguna Bahagian / Penyedia Jawapan';
	} else if($rs->fields['type']=='A'){
		print 'Administrator';
	} else {
		print '?';
	}
	?></td>
    <td align="center">
    <img src="img/d_tree.gif" border="0" style="cursor:pointer" onclick="opennewsletter('<?=$rs->fields['id_kakitangan'];?>'); return false" title="Kemaskini menu kegunaan kakitangan"/>&nbsp;&nbsp;
    <img src="img/key.png" width="18" height="18" border="0" style="cursor:pointer" onclick="opennewsletter1('<?=$rs->fields['id_kakitangan']."','".$rs->fields['no_kp_kakitangan'];?>'); return false" title="Reset katalaluan pengguna"  />    </td>
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
$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";
$sort = isset($_REQUEST['sort'])?$_REQUEST['sort']:"";
 
$syarat = "pglst=$PageQUERY&cari=$cari&bhg=$bhg&sort=$sort&status=$status"; 
include_once 'include/paging.inc.php';
?>
<div align="center"><input type="button" id="button" value="Tambah" onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/kakitangan_form.php;')?>')" /></div>
</td></tr>
</table>
