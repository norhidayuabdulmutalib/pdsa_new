<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

<script type="text/javascript" src="../script/jquery.js"></script>
<script type='text/javascript' src='../script/jquery.autocomplete.pack.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" />
<script type="text/javascript">
$().ready(function() {
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
	
	$("#senarainama").focus().autocomplete(namas);
	$("#senaraikp").focus().autocomplete(kps);
	
	$("#clear").click(function() {
		$(":input").unautocomplete();
	});
});
</script>
<script LANGUAGE="JavaScript">
function Func1(){
alert("Delayed 3 seconds");
}
function do_changes(URL,vals){
	//setTimeout('alert(\'Surprise!\')', 5000)
	document.ilim.action = "modal_form.php?"+URL+"&act=select";
	document.ilim.submit();
}

function form_hantar(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}

function do_page(URL){
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}

function do_back(URL){
	parent.emailwindow.hide();
}
function do_refresh(){
	//parent.location.reload();	
	refresh = parent.location; 
	parent.location = refresh;
}
</script>
<?
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
$proses = $_GET['pro'];

//$conn->debug=true;
$types = $_GET['tab'];        
//if(empty($id)){ $id = $_GET['ids']; }                    
$href_search = "modal_form.php?win=".base64_encode('asrama/dmasuk_form.php;'.$id);
$blok_search = $_POST['blok_search'];

$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";

if(empty($proses)){
//print "ID: ".$id;
$sSQL="SELECT A.*, B.id, B.acourse_name, B.startdate, B.enddate, C.no_bilik, C.blok_id 
FROM _sis_a_tblasrama_tempah A, _tbl_kursus_jadual B, _sis_a_tblbilik C 
WHERE A.event_id=B.id AND A.bilik_id=C.bilik_id AND A.tempahan_id=".tosql($id);
$rs = &$conn->execute($sSQL);

//$conn->debug=true;
//$sql = "SELECT * FROM _tbl_kursus_luarpeserta WHERE nama_peserta IS NOT NULL AND event_id=".tosql($rs->fields['id']);
$sql = "SELECT * FROM _tbl_kursus_luarpeserta WHERE nama_peserta IS NOT NULL";
$rsd = $conn->execute($sql);
$bils=0; $data=''; $kp='';
while(!$rsd->EOF){
	if($bils==0){ 
		$data .= '"'.$rsd->fields['nama_peserta'].'"'; 
		$kp .= '"'.$rsd->fields['no_kp'].'"'; 
	} else { 
		$data .= ', "'.$rsd->fields['nama_peserta'].'"'; 
		$kp .= ', "'.$rsd->fields['no_kp'].'"'; 
	}
	$bils++;
	$rsd->movenext();
}
//print "D:".$data;

if($_GET['act']=='select'){
	$inama = $_POST['nama_peserta'];
	$ikp = $_POST['no_kp'];
	if(!empty($inama)){
		$sqlg = "SELECT * FROM _tbl_kursus_luarpeserta WHERE nama_peserta=".tosql($inama);
	} else {
		$sqlg = "SELECT * FROM _tbl_kursus_luarpeserta WHERE no_kp=".tosql($ikp);
	}
	$rs_get = $conn->execute($sqlg);
	if(!$rs_get->EOF){
		$gnama 	= $rs_get->fields['nama_peserta'];
		$gkp 	= $rs_get->fields['no_kp'];
	} else {
		$gnama 	= $inama;
		$gkp 	= $ikp;
	}
}
?>
<script language="javascript">
var namas = [
	<?=$data;?>
];
var kps = [
	<?=$kp;?>
];

</script>	
	
</head>

<body>
<div id="content">
<form name="ilim" method="post" autocomplete="off">
<table width="100%" align="center" cellpadding="3" cellspacing="0" border="0">
	<tr>
    	<td colspan="4" height="30" bgcolor="#999999">&nbsp;<b>DAFTAR MASUK ASRAMA</b></td>
    </tr>
    <tr>
        <td width="25%" align="left"><b>Blok</b></td>
        <td width="2%" align="left"><b>:</b></td>
        <td width="75%" colspan="2" align="left"><?php print dlookup("_ref_blok_bangunan","f_bb_desc","f_bb_id=".tosql($rs->fields['blok_id']));?></td>
    </tr>
    <tr>
        <td align="left"><b>No. Bilik</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $rs->fields['no_bilik'];?></td>
    </tr>
    <tr>
        <td align="left"><b>Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $rs->fields['acourse_name'];?></td>
    </tr>
    <tr>
        <td align="left"><b>Tarikh Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print DisplayDate($rs->fields['startdate']);?> hingga <?php print DisplayDate($rs->fields['enddate']);?></td>
    </tr>

   <tr>
     <td colspan="4" bgcolor="#CCCCCC"><b>MAKLUMAT PESERTA</b></td>
   </tr>
   <tr>
     <td align="left"><b>Nama Peserta</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><input type="text" name="nama_peserta" size="70"  id="senarainama" value="<?=$gnama;?>"  /></td>
   </tr>
   <tr>
     <td align="left"><b>No. KP</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><input type="text" name="no_kp" size="20"   id="senaraikp" value="<?=$gkp;?>"/>
     &nbsp;&nbsp;
     <input type="button" value="Go" onClick="do_changes('<?=$URLs;?>',this.value)">
     </td>
   </tr>
    <tr>
        <td align="left"><b>Jantina </b></td>
     	<td align="left"><b>:</b></td>
        <td align="left" colspan="2">
            <select name="jantina">
                <option value="L" <? if($rs->fields['f_peserta_jantina']=='L'){ print 'selected'; }?>>Lelaki</option>
                <option value="P" <? if($rs->fields['f_peserta_jantina']=='P'){ print 'selected'; }?>>Perempuan</option>
            </select>
        </td>
    </tr>
   <tr>
     <td align="left"><b>No. Tel/HP</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><input type="text" name="no_tel" size="20" /></td>
   </tr>
   <tr>
     <td align="left"><b>Nama Waris</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><input type="text" name="nama_waris" size="70" /></td>
   </tr>
   <tr>
     <td align="left"><b>No. Tel Waris</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><input type="text" name="no_tel_waris" size="20" /></td>
   </tr>
 <tr>
 	<td colspan="4" align="center"><br><input type="button" value="Daftar Masuk" class="button_disp" title="Sila klik untuk menyimpan maklumat" 
            onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')">
            <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai peserta/penceramah" 
            onClick="do_back()">
            <input type="hidden" name="id" value="<?=$id?>" />
            <input type="hidden" name="bilik_id" value="<?php print $rs->fields['bilik_id'];?>" />
            <input type="hidden" name="event_id" value="<?php print $rs->fields['event_id'];?>" />
            <input type="hidden" name="asrama_type" value="P" />
            <input type="hidden" name="kursus_type" value="L" />
   	</td>
    </tr>
</table>
</form>
</div>
</body>
</html>
<script language="javascript">
	document.ilim.nama_peserta.focus();
</script>
<?php } else {
	//$conn->debug=true;
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$bilik_id=isset($_REQUEST["bilik_id"])?$_REQUEST["bilik_id"]:"";
	$event_id=isset($_REQUEST["event_id"])?$_REQUEST["event_id"]:"";
	$asrama_type=isset($_REQUEST["asrama_type"])?$_REQUEST["asrama_type"]:"";
	$kursus_type=isset($_REQUEST["kursus_type"])?$_REQUEST["kursus_type"]:"";
	$nama_peserta=isset($_REQUEST["nama_peserta"])?$_REQUEST["nama_peserta"]:"";
	$jantina=isset($_REQUEST["jantina"])?$_REQUEST["jantina"]:"";
	$no_kp=isset($_REQUEST["no_kp"])?$_REQUEST["no_kp"]:"";
	$no_tel=isset($_REQUEST["no_tel"])?$_REQUEST["no_tel"]:"";
	$nama_waris=isset($_REQUEST["nama_waris"])?$_REQUEST["nama_waris"]:"";
	$no_tel_waris=isset($_REQUEST["no_tel_waris"])?$_REQUEST["no_tel_waris"]:"";

	$daftarid=date("Ymd")."-".uniqid();
	$sqli = "INSERT INTO _sis_a_tblasrama(daftar_id, peserta_id, event_id, bilik_id, is_daftar, 
	is_keluar, tkh_masuk, asrama_type, kursus_type, 
	nama_peserta, no_kp, no_tel, nama_waris, no_tel_waris, jantina)
	VALUES(".tosql($daftarid).", ".tosql($no_kp).", ".tosql($event_id).", ".tosql($bilik_id).", 1, 0, ".tosql(date("Y-m-d")).", 'P', 'L', 
	".tosql($nama_peserta).", ".tosql($no_kp).", ".tosql($no_tel).", ".tosql($nama_waris).", ".tosql($no_tel_waris).", ".tosql($jantina).")";
	$rs = $conn->execute($sqli);
	if($rs){
		$conn->execute("DELETE FROM _sis_a_tblasrama_tempah WHERE tempahan_id=".tosql($id));
	}
	//exit;
	$jenis_bilik = dlookup("_sis_a_tblbilik", "jenis_bilik", "bilik_id = ".$bilik_id." ");
	$jumlah_penghuni = dlookup("_sis_a_tblasrama", "count(daftar_id)", "bilik_id = ".$bilik_id." AND is_daftar = 1");
	if($jumlah_penghuni==$jenis_bilik) {
		echo "Set Status Bilik Kepada PENUH";
		$sql = "UPDATE _sis_a_tblbilik SET status_bilik=1 WHERE bilik_id=".tosql($bilik_id,"Number");
		$conn->Execute($sql);
	}
	/*print '<script language="javascript">
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
	</script>';*/
	//exit;
	/*print '<script language="javascript">
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
	</script>';*/
	$sql = "SELECT C.*, D.no_bilik, C.peserta_id AS NOKP FROM _sis_a_tblasrama C, _sis_a_tblbilik D 
	WHERE C.bilik_id=D.bilik_id AND C.daftar_id=".tosql($daftarid);
	$rs = &$conn->execute($sql);
	$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE id=".tosql($rs->fields['event_id']);
	$rsk = &$conn->execute($sqlk);
?>
<table width="100%" align="center" cellpadding="5" cellspacing="1" border="0">
	<tr>
    	<td colspan="4" height="30" bgcolor="#999999">&nbsp;<b>DAFTAR MASUK ASRAMA</b></td>
    </tr>
    <tr>
        <td width="25%" align="left"><b>Nama Penghuni</b></td>
        <td width="2%" align="left"><b>:</b></td>
        <td width="75%" colspan="2" align="left"><?php print $rs->fields['nama_peserta'];?></td>
    </tr>
    <tr>
        <td align="left"><b>Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $rsk->fields['acourse_name'];?></td>
    </tr>
    <tr>
        <td align="left"><b>Tarikh Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print DisplayDate($rsk->fields['startdate']);?> hingga <?php print DisplayDate($rsk->fields['enddate']);?></td>
    </tr>

   <tr>
     <td colspan="4" bgcolor="#CCCCCC"><b>MAKLUMAT BILIK</b></td>
   </tr>
    <? $sql_l = "SELECT A.*, B.no_bilik, B.tingkat_id, C.f_bb_desc FROM _sis_a_tblasrama A, _sis_a_tblbilik B, _ref_blok_bangunan C
		WHERE A.bilik_id=B.bilik_id AND B.blok_id=C.f_bb_id AND A.daftar_id=".tosql($daftarid);
       //$conn->debug=true;
	   $rs_l = &$conn->Execute($sql_l); 
    ?>
   <tr>
     <td align="left"><b>Blok</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><?php print $rs_l->fields['f_bb_desc'];?></td>
   </tr>
   <tr>
     <td align="left"><b>Aras Bangunan</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><?php print dlookup("_ref_aras_bangunan","f_ab_desc","f_ab_id=".tosql($rs_l->fields['tingkat_id'],"Number"));?></td>
   </tr>
   <tr>
     <td align="left"><b>No. Bilik</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><?php print $rs_l->fields['no_bilik'];?></td>
   </tr>
 <tr>
 	<td colspan="4" align="center"><br>
            <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai peserta/penceramah" onClick="do_refresh()">
   	</td>
    </tr>
</table>

<?php } ?>
