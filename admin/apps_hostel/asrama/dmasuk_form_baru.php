<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(document.ilim.f_peserta_noic.value==''){
		alert('Sila isikan maklumat No Kad Pengenalan');
		document.ilim.f_peserta_noic.focus();
	} else if(document.ilim.f_peserta_nama.value==''){
		alert('Sila isikan maklumat nama peserta');
		document.ilim.f_peserta_nama.focus();
	} else if(document.ilim.f_title_grade.value==''){
		alert('Sila pilih gred jawatan');
		document.ilim.f_title_grade.focus();
	} else if(document.ilim.BranchCd.value==''){
		alert('Sila pilih Jabatan/Agensi/Unit');
		document.ilim.BranchCd.focus();
	} else if(document.ilim.f_peserta_hp.value==''){
		alert('Sila isikan maklumat No. Telefon Bimbit');
		document.ilim.f_peserta_hp.focus();
	} else if(document.ilim.f_waris_nama.value==''){
		alert('Sila masukkan nama waris bagi peserta');
		document.ilim.f_waris_nama.focus();
	} else if(document.ilim.f_waris_tel.value==''){
		alert('Sila masukkan no telefon waris');
		document.ilim.f_waris_tel.focus();
	} else if(document.ilim.kursus.value==''){
		alert('Sila pilih maklumat kursus');
		document.ilim.kursus.focus();
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
function do_search(URL){
	var insid = document.ilim.f_peserta_noic.value;
	var kp1=''; var kp2=''; var kp3='';
	insid = cleanIcNum(insid);

	document.ilim.action = URL+"&pro=SEARCH&kp="+insid;
	document.ilim.submit();
}
function cleanIcNum(icValue) {
	//  var icValue = ic.value;
	var sepArr = new Array("-"," ");
	for (i = 0; i < sepArr.length; i++) {
		if (icValue.indexOf(sepArr[i]) != -1) 
		var repStr = eval("/" + sepArr[i] + "/g");
		var myNewIc = icValue.replace(repStr,"");
	}  
	//  ic.value = myNewIc;
	return myNewIc;
}

</script>
<?
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
$proses = $_GET['pro'];
$ref = $_GET['ref'];
$id_peserta = $_POST['id_peserta'];
$f_peserta_noic = $_POST['f_peserta_noic'];
$blok_search = $_POST['blok_search'];
$kursus = $_POST['kursus'];
$stat='SAVE';
$types = $_GET['tab'];        
if(empty($types)){ $types=$_POST['types']; }

if($proses<>'UPDATE'){
if($proses=='SAVE' && empty($id_peserta)){
	extract($_POST);
	//print date("Ymd")."-".uniqid(date("Ymd"));
	//TAMBAH MAKLUMAT PESERTA
	//$conn->debug=true;
	$sqls = "SELECT * FROM _tbl_peserta WHERE is_deleted=0 AND f_peserta_noic=".tosql($f_peserta_noic);
	$rsp = &$conn->query($sqls);
	if($rsp->EOF){
		$id_peserta = date("Ymd")."-". uniqid();
		$sql = "INSERT INTO _tbl_peserta(id_peserta, f_peserta_noic, f_peserta_nama, f_title_grade, 
		f_peserta_jantina, BranchCd, f_peserta_hp, 
		f_waris_nama, f_waris_tel) 
		VALUES(".tosql($id_peserta,"Text").", ".tosql($f_peserta_noic,"Text").", ".tosql(strtoupper($f_peserta_nama),"Text").", 
		".tosql($f_title_grade,"Text").", 
		".tosql($f_peserta_jantina,"Text").", ".tosql($BranchCd,"Text").", ".tosql($f_peserta_hp,"Text").", 
		".tosql($f_waris_nama,"Text").", ".tosql($f_waris_tel,"Text").")"; 
		$result = $conn->Execute($sql);
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }	
	}
	
	//TAMBAH MAKLUMAT PESERTA & KURSUS
	$sqlu = "INSERT INTO _tbl_kursus_jadual_peserta(EventId, peserta_icno, InternalStudentSelectedDt, InternalStudentAccepted, 
	InternalStudentInputDt, InternalStudentInputBy) 
	VALUES(".tosql($kursus).", ".tosql($f_peserta_noic,"Text").", ".tosql(date("Y-m-d H:i:s")).",1, ".tosql(date("Y-m-d H:i:s")).", 
	".tosql($_SESSION["s_logid"]).")";
	//print $sqlu."<br>";
	$result = $conn->Execute($sqlu);
	if(!$result){ echo "Invalid query : " . mysql_error(); exit; }

	//DAPATKAN MAKLUMAT PESERTA
	$sSQL="SELECT * FROM _tbl_peserta  WHERE id_peserta = ".tosql($id_peserta,"Text");
	$rs = &$conn->Execute($sSQL);
	if(!$rs->EOF){ 
		$f_peserta_noic = $rs->fields['f_peserta_noic']; 
		$id = $rs->fields['id_peserta'];
	}
	$stat='UPDATE';
	//$conn->debug=false;
} else {
	//$conn->debug=true;
	$types = $_GET['tab'];        
	//print $rs->fields['daftar_nama'];
	if(!empty($_GET['kp'])){ 
		$sSQL="SELECT * FROM _tbl_peserta  WHERE is_deleted=0 AND f_peserta_noic = ".tosql($_GET['kp'],"Text");
	} else {
		$sSQL="SELECT * FROM _tbl_peserta  WHERE id_peserta = ".tosql($id,"Text");
	}
	$rs = &$conn->Execute($sSQL);
	if(!$rs->EOF){ 
		$f_peserta_noic = $rs->fields['f_peserta_noic']; 
		$negara = $rs->fields['f_peserta_negara'];
		if(!empty($_GET['kp'])){
			print '<script language="javascript">
				alert("Nama peserta telah ada dalam pangkalan data.");
			</script>';
			$id = $rs->fields['id_peserta'];
			$types = $_POST['types'];
		}
		$stat='UPDATE';
	} else { 
		//$stat='SAVE';
		$insid=$_GET['kp']; 
		$negara = 'MY';
	}
}
if(!empty($_POST['types'])){ $types = $_POST['types']; }
if(!empty($ref) && $ref=='BLOK'){
	if(!empty($_POST['f_peserta_hp'])){ $f_peserta_hp = $_POST['f_peserta_hp']; } else { $f_peserta_hp = $rs->fields['f_peserta_hp']; }
	if(!empty($_POST['f_waris_nama'])){ $f_waris_nama = $_POST['f_waris_nama']; } else { $f_waris_nama = $rs->fields['f_waris_nama']; }
	if(!empty($_POST['f_waris_tel'])){ $f_waris_tel = $_POST['f_waris_tel']; } else { $f_waris_tel = $rs->fields['f_waris_tel']; }
}
$href_search = "modal_form.php?win=".base64_encode('asrama/dmasuk_form_baru.php;'.$id);
if($pro=='SEARCH'){ $f_peserta_noic=$_GET['kp']; }
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="1" cellspacing="0" border="0">
	<tr>
    	<td colspan="4" height="30" bgcolor="#999999">&nbsp;<b>DAFTAR PESERTA BARU</b></td>
    </tr>
    <tr>
        <td width="25%" align="left"><b>No. K/P Peserta</b></td>
        <td width="2%" align="left"><b>:</b></td>
        <td width="75%" colspan="2" align="left"> 
        	<input type="hidden" name="id_peserta"  value="<? print $rs->fields['id_peserta'];?>" />
        	<input type="text" name="f_peserta_noic"  value="<? print $f_peserta_noic;?>" maxlength="20"  
            <?php if(empty($pro)){ ?>onchange="do_search('modal_form.php?win=<?php print base64_encode('asrama/dmasuk_form_baru.php;');?>')" <?php } ?>/> cth: 700104102478
        </td>
    </tr>
    <tr>
        <td width="25%" align="left"><b>Nama Peserta</b></td>
        <td width="2%" align="left"><b>:</b></td>
        <td width="75%" colspan="2" align="left"><input type="text" size="65" name="f_peserta_nama" value="<? print $rs->fields['f_peserta_nama'];?>" /></td>
    </tr>
	<?php
    $sqlp = "SELECT * FROM _ref_titlegred WHERE is_deleted=0 AND f_status=0 ORDER BY f_gred_code";
    $rspg = &$conn->execute($sqlp);
    ?>
    <tr>
        <td align="left"><b>Gred Jawatan</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left">
			<select name="f_title_grade">
				<?php while(!$rspg->EOF){ ?>
                <option value="<?php print $rspg->fields['f_gred_id'];?>" <?php if($rspg->fields['f_gred_id']==$rs->fields['f_title_grade']){ print 'selected'; }?>><?php print $rspg->fields['f_gred_code'] ." - ". $rspg->fields['f_gred_name'];?></option>
                <? $rspg->movenext(); } ?>
           </select> 
        </td>
    </tr>
	<?php
    $sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
    $rspu = &$conn->execute($sqlp);
    ?>
    <tr>
        <td align="left"><b>Jabatan/Agensi/Unit</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left">
			<select name="BranchCd">
                    <option value="">-- Sila pilih --</option>
                    <?php while(!$rspu->EOF){ ?>
                    <option value="<?php print $rspu->fields['f_tbcode'];?>" <?php if($rspu->fields['f_tbcode']==$rs->fields['BranchCd']){ print 'selected'; }?>><?php print $rspu->fields['f_tempat_nama'];?></option>
                    <? $rspu->movenext(); } ?>
                </select> 
        </td>
    </tr>
    <tr>
        <td align="left"><b>Jantina</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left">
            <select name="f_peserta_jantina">
                <option value="L" <? if($rs->fields['f_peserta_jantina']=='L'){ print 'selected'; }?>>Lelaki</option>
                <option value="P" <? if($rs->fields['f_peserta_jantina']=='P'){ print 'selected'; }?>>Perempuan</option>
            </select>
        </td>
    </tr>
    <tr>
        <td align="left"><b>No. Telefon Bimbit</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><input type="text" name="f_peserta_hp" size="20" maxlength="15" value="<? print $f_peserta_hp;?>"></td>
    </tr>
   <tr>
     <td align="left"><b>Nama Waris</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><input type="text" name="f_waris_nama" size="70" value="<? print $f_waris_nama;?>" /></td>
   </tr>
   <tr>
     <td align="left"><b>No. Tel Waris</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left"><input type="text" name="f_waris_tel" size="20" value="<? print $f_waris_tel;?>" /></td>
   </tr>



	<?php
	$sqlk = "SELECT A.*, B.id AS JID, B.startdate, B.enddate FROM _tbl_kursus A, _tbl_kursus_jadual B 
	WHERE A.id=B.courseid AND ".tosql(date("Y-m-d"))." BETWEEN B.startdate AND B.enddate ";
	if($_SESSION["s_level"]<>'99'){ $sqlk .= " AND C.kampus_id=".$_SESSION['SESS_KAMPUS']; }
	if(!empty($kampus_id)){ $sqlk.=" AND C.kampus_id=".$kampus_id; }
	$sqlk .= " ORDER BY B.startdate";
	$rsku = &$conn->execute($sqlk);
	?>
	<tr>
        <td align="left"><b>Nama Kursus</b></td>
        <td align="left"><b>:</b></td>
		<td colspan="2" align="left">
        	<select name="kursus">
            	<option value="">-- Sila pilih --</option>
            <?php while(!$rsku->EOF){ ?>
            	<option value="<?=$rsku->fields['JID'];?>" <?php if($rsku->fields['JID']==$kursus){ print 'selected'; }?>><?=$rsku->fields['coursename'].
				"&nbsp; [".DisplayDate($rsku->fields['startdate'])." - " .displayDate($rsku->fields['enddate'])."]";?></option>
            <?php $rsku->movenext(); } ?>
            </select>
		</td>
	</tr>

<?php if(!empty($id)){ ?>
   <tr>
     <td colspan="4" bgcolor="#CCCCCC"><b>MAKLUMAT BILIK</b></td>
   </tr>
    <?php 
	   $sql_l = "SELECT * FROM _ref_blok_bangunan WHERE f_kb_id=1 AND f_bb_status = 0 AND is_deleted=0 ";
		if($_SESSION["s_level"]<>'99'){ $sql_l .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
		if(!empty($kampus_id)){ $sql_l.=" AND kampus_id=".$kampus_id; }
		$sql_l .= " ORDER BY f_bb_desc "; 
       $rs_l = &$conn->Execute($sql_l); 
    ?>
   <tr>
     <td align="left"><b>Blok</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left">
          <select name="blok_search" onchange="do_page('<?=$href_search;?>&tab=<?=$types;?>&ref=BLOK')">
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
         <td align="left"><b>No. Bilik</b></td>
         <td align="left"><b>:</b></td>
         <td colspan="2" align="left">
             <select name="tempahan_id">
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
     <td colspan="2" align="left">
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
<?php } ?>
 	<tr>
        <td colspan="4" align="center"><br><input type="button" value="Daftar" class="button_disp" title="Sila klik untuk menyimpan maklumat" 
                onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=<?=$stat;?>')"><?//=$stat;?>
                <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai peserta/penceramah" 
                onClick="do_back()">
                <input type="hidden" name="id" value="<?=$id?>" />
                <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                <input type="hidden" name="EVENT" value="<?php print $rs->fields['EVENT'];?>" />
                <input type="hidden" name="asrama_type" value="<?php print $asrama_type;?>" />
                <input type="hidden" name="tempahan" value="<?php print $asrama_type;?>" />
           		<input type="hidden" name="types" value="<?php print $types;?>" />
        </td>
    </tr>
</table>
</form>
<script language="javascript">
	document.ilim.f_peserta_noic.focus();
</script>

<?php } else { 
	//$conn->debug=true;
	$types = $_POST['types'];
	$f_peserta_noic = $_POST['f_peserta_noic'];
	$bilik_id = $_POST['bilik_id'];
	$tempahan_id = $_POST['tempahan_id'];
	$id = $_POST['id'];
	$EVENT = $_POST['EVENT'];
	$asrama_type = $_POST['asrama_type'];
	$tempahan = $_POST['tempahan'];
	$jantina = $_POST['jantina'];
	$kursus = $_POST['kursus'];
	//echo "insert";
	$f_waris_nama = $_POST['f_waris_nama'];
	$f_waris_tel = $_POST['f_waris_tel'];
	$f_peserta_hp = $_POST['f_peserta_hp'];
	$f_title_grade = $_POST['f_title_grade'];
	$BranchCd = $_POST['BranchCd'];
	$f_peserta_jantina = $_POST['f_peserta_jantina'];

	$sqlu = "UPDATE _tbl_peserta SET
	f_title_grade=".tosql($f_title_grade).",
	BranchCd=".tosql($BranchCd).",
	f_peserta_jantina=".tosql($f_peserta_jantina).",
	f_waris_nama=".tosql($f_waris_nama).",
	f_waris_tel=".tosql($f_waris_tel).",
	f_peserta_hp=".tosql($f_peserta_hp)."
	WHERE id_peserta=".tosql($id);
	$conn->Execute($sqlu);
	
	$sqlget = "SELECT * FROM _sis_a_tblasrama WHERE peserta_id=".tosql($f_peserta_noic)." AND event_id=".tosql($kursus);
	$rsasrama = &$conn->Execute($sqlget);
	if($rsasrama->EOF){
		//UPDATE PESERTA & KURSUS
		$sqlg = "SELECT * FROM _tbl_kursus_jadual_peserta WHERE peserta_icno=".tosql($f_peserta_noic)." AND EventId=".tosql($kursus);
		$rsget = &$conn->Execute($sqlg);
		if(!$rsget->EOF){
			$sqlu = "UPDATE _tbl_kursus_jadual_peserta SET InternalStudentAccepted=1 WHERE peserta_icno=".tosql($f_peserta_noic)." AND EventId=".tosql($kursus);
			//print $sqlu."<br>";
		} else {
			$sqlu = "INSERT INTO _tbl_kursus_jadual_peserta(EventId, peserta_icno, InternalStudentSelectedDt, InternalStudentAccepted, InternalStudentInputDt, InternalStudentInputBy) 
			VALUES(".tosql($kursus).", ".tosql($f_peserta_noic,"Text").", ".tosql(date("Y-m-d H:i:s")).",1, ".tosql(date("Y-m-d H:i:s")).", ".tosql($_SESSION["s_logid"]).")";
		}
	
		$result = $conn->Execute($sqlu);
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
	
		// INSERT INFORMATION TO ASRAMA
		if(!empty($tempahan_id)){ $bilik_id = dlookup("_sis_a_tblasrama_tempah", "bilik_id", "tempahan_id=".tosql($tempahan_id)); }
		
		$daftar_id = date("Ymd")."-".uniqid();
		$sql = "INSERT INTO _sis_a_tblasrama(daftar_id, bilik_id, peserta_id, event_id, create_dt, tkh_masuk, create_by, is_daftar, is_keluar, asrama_type, jantina )
		VALUES(".tosql($daftar_id).", ".tosql($bilik_id,"Number").", ".tosql($f_peserta_noic).", ".tosql($kursus).", ".tosql(date("Y-m-d")).", now(),
		".tosql($_SESSION["s_UserID"]).",1,0,".tosql($asrama_type).",".tosql($jantina).")";
		
		$conn->Execute($sql);
		//$new_id = mysql_insert_id();
		
		if(!empty($tempahan_id)){
			$conn->Execute("DELETE FROM _sis_a_tblasrama_tempah WHERE tempahan_id=".tosql($tempahan_id));
		}
		$jenis_bilik = dlookup("_sis_a_tblbilik", "jenis_bilik", "bilik_id = ".$bilik_id." ");
		$jumlah_penghuni = dlookup("_sis_a_tblasrama", "count(daftar_id)", "bilik_id = ".$bilik_id." AND is_daftar = 1");
		if($jenis_bilik == $jumlah_penghuni) {
			echo "Set Status Bilik Kepada PENUH";
			$sql = "UPDATE _sis_a_tblbilik SET status_bilik=1 WHERE bilik_id=".tosql($bilik_id,"Number");
			$conn->Execute($sql);
		}
	} else {
		$daftar_id=$rsasrama->fields['daftar_id'];
		print "<script language=javascript>
			alert('Telah mendaftar di asrama');
		</script>";
	}

	if($types=='peserta'){
		$asrama_type='P';
		$sSQL="SELECT A.f_peserta_nama AS daftar_nama, A.f_peserta_noic AS NOKP, E.f_tempat_nama AS agensi, C.startdate, C.enddate, F.coursename, 
		B.EventId AS EVENT, A.f_peserta_jantina as jantina  
		FROM _tbl_peserta A, _tbl_kursus_jadual_peserta B, _tbl_kursus_jadual C, _ref_tempatbertugas E, _tbl_kursus F
		WHERE A.f_peserta_noic=B.peserta_icno AND B.EventId=C.id AND A.is_deleted=0 AND A.BranchCd=E.f_tbcode AND C.courseid=F.id
		AND ".tosql(date("Y-m-d"))." BETWEEN C.startdate AND C.enddate ";  //C.enddate>=".tosql(date("Y-m-d"));
		//AND B.InternalStudentAccepted=1 
		//if(!empty($search)){ $sSQL .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.f_peserta_noic LIKE '%".$search."%' OR D.no_bilik LIKE '%".$search."%')"; }
		$sSQL .= " AND B.peserta_icno=".tosql($f_peserta_noic);
		$sSQL .= " ORDER BY C.startdate, A.f_peserta_nama";
		$rs = &$conn->Execute($sSQL);
		$cnt = $rs->recordcount();
	} else {
		$asrama_type='I';
		$sSQL="SELECT A.insname AS daftar_nama, A.insid AS NOKP, A.insorganization AS agensi, C.startdate, C.enddate, F.coursename, B.event_id AS EVENT, A.p_jantina AS jantina 
		FROM _tbl_instructor A, _tbl_kursus_jadual_det B, _tbl_kursus_jadual C, _tbl_kursus F
		WHERE A.is_deleted=0 AND A.ingenid=B.instruct_id AND B.event_id=C.id AND C.courseid=F.id AND ".tosql(date("Y-m-d"))." BETWEEN C.startdate AND C.enddate "; 
		//C.enddate>=".tosql(date("Y-m-d"));
		//if(!empty($search)){ $sSQL .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.insid LIKE '%".$search."%' OR D.no_bilik LIKE '%".$search."%')"; }
		$sSQL .= " AND A.insid=".tosql($f_peserta_noic);
		$sSQL .= $sql_search . " ORDER BY C.startdate, A.insname";
		$rs = &$conn->Execute($sSQL);
		$cnt = $rs->recordcount();
	}
?>
<table width="100%" align="center" cellpadding="5" cellspacing="1" border="0">
	<tr>
    	<td colspan="4" height="30" bgcolor="#999999">&nbsp;<b>DAFTAR MASUK ASRAMA</b></td>
    </tr>
    <tr>
        <td width="25%" align="left"><b>Nama Penghuni</b></td>
        <td width="2%" align="left"><b>:</b></td>
        <td width="75%" colspan="2" align="left"><?php print $rs->fields['daftar_nama'];?></td>
    </tr>
    <tr>
        <td align="left"><b>Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $rs->fields['coursename'];?></td>
    </tr>
    <tr>
        <td align="left"><b>Tarikh Kursus</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print DisplayDate($rs->fields['startdate']);?> hingga <?php print DisplayDate($rs->fields['enddate']);?></td>
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
            <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai peserta/penceramah" onClick="javascript:parent.emailwindow.hide();">
   	</td>
    </tr>
</table>

<?php } ?>