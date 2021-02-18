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
function form_hantar(URL){
	if(document.ilim.blok_search.value==''){
		alert('Sila pilih maklumat blok');
		document.ilim.blok_search.focus();
	} else if(document.ilim.bilik_id.value==''){
		alert('Sila pilih maklumat no bilik');
		document.ilim.blok_search.focus();
	} else if(document.ilim.kursus.value==''){
		alert('Sila pilih maklumat kursus');
		document.ilim.kursus.focus();
	} else if(document.ilim.nama_peserta.value==''){
		alert('Sila masukkan nama peserta');
		document.ilim.nama_peserta.focus();
	} else if(document.ilim.no_kp.value==''){
		alert('Sila isikan maklumat No. KP peserta');
		document.ilim.no_kp.focus();
	} else if(document.ilim.no_tel.value==''){
		alert('Sila masukkan no telefon peserta');
		document.ilim.no_tel.focus();
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
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
$date_yestarday = date("Y-m-d", time() - 60 * 60 * 60);
$date_tomorrow = date("Y-m-d", time() + 60 * 60 * 60);
//$conn->debug=true;

$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$kp=isset($_REQUEST["kp"])?$_REQUEST["kp"]:"";
$nama=isset($_REQUEST["nama"])?$_REQUEST["nama"]:"";

//$conn->debug=true;
$types = $_GET['tab'];        
//if(empty($id)){ $id = $_GET['ids']; }                    
$href_search = "modal_form.php?win=".base64_encode('asrama/dmasuk_form_luar_baru.php;'.$id);
$blok_search = $_POST['blok_search'];

$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$kursus=isset($_REQUEST["kursus"])?$_REQUEST["kursus"]:"";

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
<form name="ilim" method="post" autocomplete="off">
<table width="100%" align="center" cellpadding="3" cellspacing="0" border="0">
   <tr>
     <td colspan="4" bgcolor="#CCCCCC"><b>MAKLUMAT BILIK</b></td>
   </tr>
	<?php
	//$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE ".tosql(date("Y-m-d"))." BETWEEN startdate AND enddate ORDER BY startdate";
	$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE (acourse_name IS NOT NULL OR acourse_name<>'' ) 
		AND asrama_perlu='ASRAMA' AND ".tosql($date_yestarday)." <= startdate ";
	//$sqlk .= " AND enddate <= ".tosql($date_tomorrow);
   	$sqlk .= " ORDER BY startdate";
	$rsku = &$conn->execute($sqlk);
	?>
	<tr>
    <td align="left"><b>Nama Kursus</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left">
        	<select name="kursus" onchange="do_page('<?=$href_search;?>&tab=<?=$types;?>')">
            	<option value="">-- Sila pilih --</option>
            <?php while(!$rsku->EOF){ ?>
            	<option value="<?=$rsku->fields['id'];?>" <?php if($rsku->fields['id']==$kursus){ print 'selected'; }?>><?=$rsku->fields['acourse_name'].
				"&nbsp; [ Tarikh Kursus : ".DisplayDate($rsku->fields['startdate'])." - " .displayDate($rsku->fields['enddate'])." ]";?></option>
            <?php $rsku->movenext(); } ?>
            </select>
		</td>
	</tr>
    <? $sql_l = "SELECT * FROM _ref_blok_bangunan WHERE f_kb_id=1 AND f_bb_status = 0 AND is_deleted=0 ORDER BY f_bb_desc";
       $rs_l = &$conn->Execute($sql_l); 
    ?>
   <tr>
     <td align="left"><b>Blok</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left">
          <select name="blok_search" onchange="do_page('<?=$href_search;?>&tab=<?=$types;?>')">
            <option value="">-- semua bilik --</option>
           <?  	//$conn->debug=true;
                while(!$rs_l->EOF){
                    print '<option value="'.$rs_l->fields['f_bb_id'].'"'; 
                    if($rs_l->fields['f_bb_id']==$blok_search){ print 'selected'; }
                    print '>'. $rs_l->fields['f_bb_desc'] .'</option>';
                    $rs_l->movenext();
                }
            ?>
         </select>         		
      </td>
   </tr>
    <?  $tempahan=0;
		//$conn->debug=true;
		$sql_l = "SELECT A.*, B.tempahan_id FROM _sis_a_tblbilik A, _sis_a_tblasrama_tempah B 
		WHERE A.bilik_id=B.bilik_id AND A.status_bilik = 0 AND A.keadaan_bilik = 1 AND A.is_deleted = 0 AND A.blok_id=".tosql($blok_search,"Number")." 
		AND B.event_id=".tosql($kursus)." ORDER BY A.no_bilik";
        $rs_l = $conn->Execute($sql_l); 
		$cnt_tempah = $rs_l->recordcount();
        //echo $sql_l;
    	if($cnt_tempah>0){
			$tempahan=1;
			//print "T:".$cnt_tempah;
	?>
       <tr>
         <td align="left"><b>No. Bilik (T)</b></td>
         <td align="left"><b>:</b></td>
         <td colspan="2" align="left"><input type="hidden" size="5" name="biliks" value="T">
             <select name="bilik_id">
             <?	while(!$rs_l->EOF){
                    print '<option value="'.$rs_l->fields['tempahan_id'].'"';
                    //if($rs_l->fields['bilik_id']==$blok_search){ print 'selected'; }
                    print '>'. $rs_l->fields['no_bilik'].'</option>';
                    $rs_l->movenext();
                }
             ?>
            </select>
         </td>
       </tr>
    <?  } else { 
			$sql_l = "SELECT * FROM _sis_a_tblbilik  WHERE status_bilik = 0 AND keadaan_bilik = 1 AND is_deleted = 0 AND blok_id=".tosql($blok_search,"Number")." ORDER BY no_bilik";
			$rs_l = $conn->Execute($sql_l); 
			//echo $sql_l;
	?>
   <tr>
     <td align="left"><b>No. Bilik</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><input type="hidden" size="5" name="biliks" value="">
         <select name="bilik_id">
         <?	while(!$rs_l->EOF){
				print '<option value="'.$rs_l->fields['bilik_id'].'"';
				//if($rs_l->fields['bilik_id']==$blok_search){ print 'selected'; }
				print '>'. $rs_l->fields['no_bilik'].'</option>';
                $rs_l->movenext();
            }
         ?>
        </select>
     </td>
   </tr>
	<?php } ?>
   <tr>
     <td colspan="4" bgcolor="#CCCCCC"><b>MAKLUMAT PESERTA</b></td>
   </tr>
   <tr>
     <td align="left"><b>Nama Peserta</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><input type="text" name="nama_peserta" size="70"  id="senarainama"  value="<?=$nama;?>" />
     	<input type="hidden" name="nama" value="<?=$nama;?>"></td>
   </tr>
   <tr>
     <td align="left"><b>No. KP</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><input type="text" name="no_kp" size="20"   id="senaraikp" value="<?=$kp;?>" />
     	<input type="hidden" name="kp" value="<?=$kp;?>"></td>
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
            <input type="hidden" name="asrama_type" value="P" />
            <input type="hidden" name="kursus_type" value="L" />
   	</td>
    </tr>
</table>
</form>
</body>
</html>
<script language="javascript">
	document.ilim.nama_peserta.focus();
</script>
<?php } else {
	//$conn->debug=true;
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$biliks=isset($_REQUEST["biliks"])?$_REQUEST["biliks"]:"";
	$bilik_id=isset($_REQUEST["bilik_id"])?$_REQUEST["bilik_id"]:"";
	$event_id=isset($_REQUEST["kursus"])?$_REQUEST["kursus"]:"";
	$asrama_type=isset($_REQUEST["asrama_type"])?$_REQUEST["asrama_type"]:"";
	$kursus_type=isset($_REQUEST["kursus_type"])?$_REQUEST["kursus_type"]:"";
	$nama_peserta=isset($_REQUEST["nama_peserta"])?$_REQUEST["nama_peserta"]:"";
	$jantina=isset($_REQUEST["jantina"])?$_REQUEST["jantina"]:"";
	$no_kp=isset($_REQUEST["no_kp"])?$_REQUEST["no_kp"]:"";
	$no_tel=isset($_REQUEST["no_tel"])?$_REQUEST["no_tel"]:"";
	$nama_waris=isset($_REQUEST["nama_waris"])?$_REQUEST["nama_waris"]:"";
	$no_tel_waris=isset($_REQUEST["no_tel_waris"])?$_REQUEST["no_tel_waris"]:"";

	if(!empty($biliks) && $biliks=='T'){ $tid=$bilik_id; $bilik_id = dlookup("_sis_a_tblasrama_tempah","bilik_id","tempahan_id=".tosql($tid)); }

	$daftarid=date("Ymd")."-".uniqid();
	$sqli = "INSERT INTO _sis_a_tblasrama(daftar_id, peserta_id, event_id, bilik_id, is_daftar, 
	is_keluar, tkh_masuk, asrama_type, kursus_type, 
	nama_peserta, no_kp, no_tel, nama_waris, no_tel_waris, jantina, create_dt)
	VALUES(".tosql($daftarid).", ".tosql($no_kp).", ".tosql($event_id).", ".tosql($bilik_id).", 1, 0, ".tosql(date("Y-m-d")).", 'P', 'L', 
	".tosql($nama_peserta).", ".tosql($no_kp).", ".tosql($no_tel).", ".tosql($nama_waris).", ".tosql($no_tel_waris).", ".tosql($jantina).", ".tosql(date("Y-m-d")).")";
	$rs = $conn->execute($sqli);
	if(!empty($tid)){
		$conn->execute("DELETE FROM _sis_a_tblasrama_tempah WHERE tempahan_id=".tosql($tid));
	}

	$jenis_bilik = dlookup("_sis_a_tblbilik", "jenis_bilik", "bilik_id = ".$bilik_id." ");
	$jumlah_penghuni = dlookup("_sis_a_tblasrama", "count(daftar_id)", "bilik_id = ".$bilik_id." AND is_daftar = 1");
	if($jumlah_penghuni >=$jenis_bilik) {
		echo '<b><font color="#FF0000">Set Status Bilik Kepada PENUH</font></b>';
		$sql = "UPDATE _sis_a_tblbilik SET status_bilik=1 WHERE bilik_id=".tosql($bilik_id,"Number");
		$conn->Execute($sql);
	}
	//exit;
	/*print '<script language="javascript">
		parent.location.reload();
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
     <td align="left"><b>No. KP</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><?php print $rs->fields['no_kp'];?></td>
   </tr>
    <tr>
        <td align="left"><b>Jantina </b></td>
     	<td align="left"><b>:</b></td>
        <td align="left" colspan="2"><?php print $rs->fields['jantina'];?></td>
    </tr>
   <tr>
     <td align="left"><b>No. Tel/HP</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><?php print $rs->fields['no_tel'];?></td>
   </tr>
   <tr>
     <td align="left"><b>Nama Waris</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><?php print $rs->fields['nama_waris'];?></td>
   </tr>
   <tr>
     <td align="left"><b>No. Tel Waris</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><?php print $rs->fields['no_tel_waris'];?></td>
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
   	<td colspan="3" align="center"><b><font color="#FF0000">PESERTA TELAH MENDAFTAR MASUK ASRAMA</font></b></td>
   </tr>
 <tr>
 	<td colspan="4" align="center"><br>
            <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai peserta/penceramah" onClick="do_refresh()">
   	</td>
    </tr>
</table>

<?php } ?>
