<script LANGUAGE="JavaScript">
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
$EID=isset($_REQUEST["EID"])?$_REQUEST["EID"]:"";

$href_search = "modal_form.php?win=".base64_encode('asrama/dpindah_form.php;'.$id);
$blok_search = $_POST['blok_search'];

//$conn->debug=true;
$types = $_GET['tab'];        
//if(empty($id)){ $id = $_GET['ids']; }                    
$sql_l = "SELECT A.*, B.no_bilik, B.tingkat_id, C.f_bb_desc FROM _sis_a_tblasrama A, _sis_a_tblbilik B, _ref_blok_bangunan C
	WHERE A.bilik_id=B.bilik_id AND B.blok_id=C.f_bb_id AND A.daftar_id=".tosql($id);
$rs_asrama = &$conn->Execute($sql_l); 
$noic = $rs_asrama->fields['peserta_id'];

//print $rs_asrama->fields['kursus_type']."/".$types;
if($rs_asrama->fields['kursus_type']=='I'){
	if($types=='peserta'){
		$sSQL="SELECT A.f_peserta_nama AS daftar_nama, A.f_peserta_noic AS NOKP, E.f_tempat_nama AS agensi, 
		A.f_peserta_hp AS mobile, A.f_peserta_tel_pejabat AS tel, A.f_peserta_email AS emel,
		C.startdate, C.enddate, F.coursename, B.EventId AS EVENT  
		FROM _tbl_peserta A, _tbl_kursus_jadual_peserta B, _tbl_kursus_jadual C, _ref_tempatbertugas E, _tbl_kursus F
		WHERE A.f_peserta_noic=B.peserta_icno AND B.EventId=C.id AND A.is_deleted=0 AND A.BranchCd=E.f_tbcode AND C.courseid=F.id";  //C.enddate>=".tosql(date("Y-m-d")); 
		//AND B.InternalStudentAccepted=1 
		$sSQL .= " AND B.peserta_icno=".tosql($noic);
		if(!empty($EID)){ $sSQL .= " AND B.EventId=".tosql($EID); }
		$sSQL .= " ORDER BY C.startdate, A.f_peserta_nama";
		$rs = &$conn->Execute($sSQL);
		//$cnt = $rs->recordcount();
		$nama_peserta = $rs->fields['daftar_nama'];
		$kursus = $rs->fields['coursename'];
		$mula = DisplayDate($rs->fields['startdate']);
		$tamat = DisplayDate($rs->fields['enddate']);
		$mobile = $rs->fields['mobile'];
		$tel = $rs->fields['tel'];
		$emel = $rs->fields['emel'];
		$agensi = $rs->fields['agensi'];
		$asrama_type = 'P';

	} else {
		$sSQL="SELECT A.insname AS daftar_nama, A.insid AS NOKP, A.insorganization AS agensi,  
		A.insmobiletel AS mobile, A.inshometel AS tel, A.insemail AS emel,  
		C.bilik_id, C.daftar_id, D.no_bilik, C.asrama_type, C.event_id 
		FROM _tbl_instructor A, _sis_a_tblasrama C, _sis_a_tblbilik D
		WHERE A.insid=C.peserta_id AND A.is_deleted=0 AND C.is_daftar=1 AND C.bilik_id=D.bilik_id AND C.asrama_type='I'
		AND C.peserta_id=".tosql($noic,"Text");
		if(!empty($EID)){ $sSQL .= " AND C.event_id=".tosql($EID); }
		$rsn = &$conn->Execute($sSQL);
		$nama_peserta = $rsn->fields['daftar_nama'];
		$mobile = $rsn->fields['mobile'];
		$tel = $rsn->fields['tel'];
		$emel = $rsn->fields['emel'];
		$agensi = $rsn->fields['agensi'];
		$asrama_type = 'I';

		$sql_k = "SELECT coursename AS kursus, B.startdate AS mula, B.enddate AS tamat, C.nama_peserta 
			FROM _tbl_kursus A, _tbl_kursus_jadual B, _sis_a_tblasrama C 
			WHERE A.id=B.courseid AND B.id=C.event_id AND C.peserta_id=".tosql($noic,"Text")." AND B.id=".tosql($EID);
		$rs_kursus = $conn->execute($sql_k);
		//print $sql_k;
		$kursus = $rs_kursus->fields['kursus']; 
		$mula = DisplayDate($rs_kursus->fields['mula']);
		$tamat = DisplayDate($rs_kursus->fields['tamat']);
	}
} else {
	$nama_peserta = $rs_asrama->fields['nama_peserta'];
	$agensi= 'Peserta Kursus Luar';
	$sql_k = "SELECT acourse_name AS kursus, startdate AS mula, enddate AS tamat FROM _tbl_kursus_jadual  
	WHERE id=".tosql($rs_asrama->fields['event_id'],"Text");
	$rs_kursus = $conn->execute($sql_k);
	$kursus = $rs_kursus->fields['kursus'];
	$mula = DisplayDate($rs_kursus->fields['mula']);
	$tamat = DisplayDate($rs_kursus->fields['tamat']);
	$asrama_type = 'P';
}
$conn->debug=false;
if(empty($proses)){ 
//print $rs->fields['daftar_nama'];
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="3" cellspacing="1" border="0">
	<tr>
    	<td colspan="4" height="30" bgcolor="#999999">&nbsp;<b>DAFTAR PINDAH MASUK ASRAMA</b></td>
    </tr>
    <tr>
        <td align="left"><b>Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><b><?php print $kursus;?></b>
        <input type="hidden" name="kursus" value="<?php print $kursus;?>" />
        <input type="hidden" name="EID" value="<?php print $EID;?>" />
        </td>
    </tr>
    <tr>
        <td align="left"><b>Tarikh Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><b><?php print $mula;?> hingga <?php print $tamat;?></b>
        <input type="hidden" name="tarikh" value="<?php print $mula . " hingga " . $tamat;?>" /></td>
    </tr>
    <tr>
        <td width="25%" align="left"><b>Nama Penghuni</b></td>
        <td width="2%" align="left"><b>:</b></td>
        <td width="75%" colspan="2" align="left"><?php print $nama_peserta;?>
        <input type="hidden" name="nama" value="<?php print $nama_peserta;?>" /></td>
    </tr>
    <tr>
        <td align="left"><b>No. HP</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $mobile;?></td>
    </tr>
    <tr>
        <td align="left"><b>No. Tel (P)</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $tel;?></td>
    </tr>
    <tr>
        <td align="left"><b>e-mel</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $emel;?></td>
    </tr>
    <tr>
        <td align="left"><b>Jabatan</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $agensi;?></td>
    </tr>

   <tr>
     <td colspan="4" bgcolor="#CCCCCC"><b>MAKLUMAT BILIK</b></td>
   </tr>
   <tr>
     <td align="left"><b>Blok</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><?php print $rs_asrama->fields['f_bb_desc'];?></td>
   </tr>
   <tr>
     <td align="left"><b>Aras Bangunan</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><?php print dlookup("_ref_aras_bangunan","f_ab_desc","f_ab_id=".tosql($rs_asrama->fields['tingkat_id'],"Number"));?></td>
   </tr>
   <tr>
     <td align="left"><b>No. Bilik</b><hr /></td>
     <td align="left"><b>:</b><hr /></td>
     <td colspan="2" align="left"><?php print $rs_asrama->fields['no_bilik'];?><hr /></td>
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
    <?  $sql_l = "SELECT * FROM _sis_a_tblbilik  WHERE status_bilik = 0 AND keadaan_bilik = 1 AND is_deleted = 0 AND blok_id=".tosql($blok_search,"Number")." ORDER BY no_bilik";
        $rs_l = $conn->Execute($sql_l); 
        //echo $sql_l;
    ?>
   <tr>
     <td align="left"><b>No. Bilik</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left">
         <select name="new_bilik_id">
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
 <tr>
 	<td colspan="4" align="center"><br><input type="button" value="Daftar Masuk" class="button_disp" title="Sila klik untuk menyimpan maklumat" 
            onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')">
            <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai peserta/penceramah" 
            onClick="do_back()">
            <input type="hidden" name="id" value="<?=$id?>" />
            <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
            <input type="hidden" name="EVENT" value="<?php print $EID;?>" />
            <input type="hidden" name="asrama_type" value="<?php print $asrama_type;?>" />
            <input type="hidden" name="bilik_id" value="<?php print $rs_asrama->fields['bilik_id'];?>" />
            <input type="hidden" name="kursus_type" value="<?php print $rs_asrama->fields['kursus_type'];?>" />
   	</td>
    </tr>
</table>
</form>
<script language="javascript">
	document.ilim.blok_search.focus();
</script>
<?php } else { 
	//$conn->debug=true;
	$bilik_id = $_POST['bilik_id'];
	$new_bilik_id = $_POST['new_bilik_id'];
	$id = $_POST['id'];
	$EVENT = $_POST['EVENT'];
	$asrama_type = $_POST['asrama_type'];
	$kursus_type = $_POST['kursus_type'];
	$nama = $_POST['nama'];
	$kursus = $_POST['kursus'];
	$tarikh = $_POST['tarikh'];

	// DAFTAR KELUAR DAHULU
	$sql = "UPDATE _sis_a_tblasrama SET is_daftar=0, is_keluar=1, update_dt=now(), update_by='".$_SESSION["s_UserID"]."' WHERE daftar_id=".tosql($id,"Text");
	$conn->Execute($sql);
	audit_trail($sql);
	echo "Set Status Bilik Kepada KOSONG";
	$sql = "UPDATE _sis_a_tblbilik SET status_bilik=0 WHERE bilik_id=".tosql($bilik_id,"Number");
	$conn->Execute($sql);
	

	//DAFTAR PERPINDAHAN
	$daftar_id = date("Ymd")."-".uniqid();
	if($kursus_type=='I'){
		$sql = "INSERT INTO _sis_a_tblasrama(daftar_id, bilik_id, peserta_id, event_id, create_dt, tkh_masuk, create_by, is_daftar, is_keluar, asrama_type, kursus_type)
		VALUES(".tosql($daftar_id).", ".tosql($new_bilik_id,"Number").", ".tosql($noic).", ".tosql($EVENT).", ".tosql(date("Y-m-d")).", now(),
		".tosql($_SESSION["s_UserID"]).",1,0,".tosql($asrama_type).", 'I')";
	} else if($kursus_type=='L'){
		$sqls = "SELECT * FROM _sis_a_tblasrama WHERE daftar_id=".tosql($id);
		$rss = $conn->execute($sqls);
		$sql = "INSERT INTO _sis_a_tblasrama(daftar_id, bilik_id, peserta_id, event_id, create_dt, tkh_masuk, create_by, is_daftar, is_keluar, asrama_type, kursus_type,
		nama_peserta, no_kp, no_tel, nama_waris, no_tel_waris)
		VALUES(".tosql($daftar_id).", ".tosql($new_bilik_id,"Number").", ".tosql($noic).", ".tosql($rss->fields['event_id']).", ".tosql(date("Y-m-d")).", now(),
		".tosql($_SESSION["s_UserID"]).",1,0,".tosql($asrama_type).", 'L',
		".tosql($rss->fields['nama_peserta']).", ".tosql($rss->fields['no_kp']).", ".tosql($rss->fields['no_tel']).", ".tosql($rss->fields['nama_waris']).", 
		".tosql($rss->fields['no_tel_waris']).")";
	}
	$conn->Execute($sql);
	audit_trail($sql);
	//$new_id = mysql_insert_id();
	
	$jenis_bilik = dlookup("_sis_a_tblbilik", "jenis_bilik", "bilik_id = ".$new_bilik_id." ");
	$jumlah_penghuni = dlookup("_sis_a_tblasrama", "count(daftar_id)", "bilik_id = ".$new_bilik_id." AND is_daftar = 1");
	if($jenis_bilik == $jumlah_penghuni) {
		echo "Set Status Bilik Kepada PENUH";
		$sql = "UPDATE _sis_a_tblbilik SET status_bilik=1 WHERE bilik_id=".tosql($new_bilik_id,"Number");
		$conn->Execute($sql);
	}
	
	//exit;
	
	/*print "<script language=\"javascript\">
		alert('Telah didaftarkan');
		parent.location.reload();
		</script>";*/
?>
<table width="100%" align="center" cellpadding="5" cellspacing="1" border="0">
	<tr>
    	<td colspan="4" height="30" bgcolor="#999999">&nbsp;<b>DAFTAR MASUK ASRAMA</b></td>
    </tr>
    <tr>
        <td width="25%" align="left"><b>Nama Penghuni</b></td>
        <td width="2%" align="left"><b>:</b></td>
        <td width="75%" colspan="2" align="left"><?php print $nama;?></td>
    </tr>
    <tr>
        <td align="left"><b>No. HP</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $mobile;?></td>
    </tr>
    <tr>
        <td align="left"><b>No. Tel (P)</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $tel;?></td>
    </tr>
    <tr>
        <td align="left"><b>e-mel</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $emel;?></td>
    </tr>
    <tr>
        <td align="left"><b>Jabatan</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $agensi;?></td>
    </tr>
    <tr><td colspan="3"><hr></td></tr>
    <tr>
        <td align="left"><b>Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $kursus;?></td>
    </tr>
    <tr>
        <td align="left"><b>Tarikh Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $tarikh;?></td>
    </tr>

   <tr>
     <td colspan="4" bgcolor="#CCCCCC"><b>MAKLUMAT BILIK</b></td>
   </tr>
    <? $sql_l = "SELECT A.*, B.no_bilik, B.tingkat_id, C.f_bb_desc FROM _sis_a_tblasrama A, _sis_a_tblbilik B, _ref_blok_bangunan C
		WHERE A.bilik_id=B.bilik_id AND B.blok_id=C.f_bb_id AND A.daftar_id=".tosql($daftar_id);
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