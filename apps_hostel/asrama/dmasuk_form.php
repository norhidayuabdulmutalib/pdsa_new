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
$date_yestarday = date("Y-m-d", time() - 60 * 60 * 24);

//$conn->debug=true;
$types = $_GET['tab'];        
if(empty($types)){ $types=$_POST['types']; }
//if(empty($id)){ $id = $_GET['ids']; }                    
$href_search = "modal_form.php?win=".base64_encode('asrama/dmasuk_form.php;'.$id);
$blok_search = $_POST['blok_search'];

if($types=='peserta'){
	$asrama_type='P';
	$sSQL="SELECT A.f_peserta_nama AS daftar_nama, A.f_peserta_noic AS NOKP, 
	A.f_peserta_hp AS mobile, A.f_peserta_tel_pejabat AS tel, A.f_peserta_email AS emel, 
	E.f_tempat_nama AS agensi, C.startdate, C.enddate, F.coursename, 
	B.EventId AS EVENT, A.f_peserta_jantina as jantina  
	FROM _tbl_peserta A, _tbl_kursus_jadual_peserta B, _tbl_kursus_jadual C, _ref_tempatbertugas E, _tbl_kursus F
	WHERE A.f_peserta_noic=B.peserta_icno AND B.EventId=C.id AND A.is_deleted=0 AND A.BranchCd=E.f_tbcode AND C.courseid=F.id";
	//$sSQL.="AND ".tosql($date_yestarday)." BETWEEN C.startdate AND C.enddate ";  //C.enddate>=".tosql(date("Y-m-d"));
	//AND B.InternalStudentAccepted=1 
	//if(!empty($search)){ $sSQL .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.f_peserta_noic LIKE '%".$search."%' OR D.no_bilik LIKE '%".$search."%')"; }
	$sSQL .= " AND B.peserta_icno=".tosql($id);
	$sSQL .= " ORDER BY C.startdate, A.f_peserta_nama";
	$rs = &$conn->Execute($sSQL);
	$cnt = $rs->recordcount();
} else {
	$asrama_type='I';
	$sSQL="SELECT A.insname AS daftar_nama, A.insid AS NOKP, A.insorganization AS agensi, 
	A.insmobiletel AS mobile, A.inshometel AS tel, A.insemail AS emel, 
	C.startdate, C.enddate, F.coursename, B.event_id AS EVENT, A.p_jantina AS jantina 
	FROM _tbl_instructor A, _tbl_kursus_jadual_det B, _tbl_kursus_jadual C, _tbl_kursus F
	WHERE A.is_deleted=0 AND A.ingenid=B.instruct_id AND B.event_id=C.id AND C.courseid=F.id AND ".tosql($date_yestarday)." BETWEEN C.startdate AND C.enddate "; 
	//C.enddate>=".tosql(date("Y-m-d"));
	//if(!empty($search)){ $sSQL .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.insid LIKE '%".$search."%' OR D.no_bilik LIKE '%".$search."%')"; }
	$sSQL .= " AND A.insid=".tosql($id);
	$sSQL .= $sql_search . " ORDER BY C.startdate, A.insname";
	$rs = &$conn->Execute($sSQL);
	$cnt = $rs->recordcount();
}

if(empty($proses)){ 
//print $rs->fields['daftar_nama'];
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="5" cellspacing="1" border="0">
	<tr>
    	<td colspan="4" height="30" bgcolor="#999999">&nbsp;<b>DAFTAR MASUK ASRAMA</b></td>
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
	
    <tr><td colspan="3"><hr /></td></tr>

    <tr>
        <td width="25%" align="left"><b>Nama Penghuni</b></td>
        <td width="2%" align="left"><b>:</b></td>
        <td width="75%" colspan="2" align="left"><?php print $rs->fields['daftar_nama'];?>
        <input type="hidden" name="jantina" value="<?php print $rs->fields['jantina'];?>" />
        </td>
    </tr>
    <tr>
        <td align="left"><b>No. HP</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $rs->fields['mobile'];?></td>
    </tr>
    <tr>
        <td align="left"><b>No. Tel (P)</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $rs->fields['tel'];?></td>
    </tr>
    <tr>
        <td align="left"><b>e-mel</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $rs->fields['emel'];?></td>
    </tr>
    <tr>
        <td align="left"><b>Jabatan</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $rs->fields['agensi'];?></td>
    </tr>

    <?php
    $sql_m = "SELECT * FROM _sis_a_tblasrama WHERE status_keluar=2 AND peserta_id=".tosql($rs->fields['NOKP']);
	$rs_m = &$conn->execute($sql_m);
	if(!$rs_m->EOF){ $mbil=0;
		while(!$rs_m->EOF){
			$mbil++; if($mbil>1){ $masalah .= ", "; }
			$masalah .= $rs_m->fields['kenyataan'];
			$rs_m->movenext();
		}
	}
	if(!empty($masalah)){
	?>
    <tr>
        <td align="left"><font color="#FF0000"><b>Maklumat Masalah</b></font></td>
        <td align="left"><font color="#FF0000"><b>:</b></font></td>
        <td colspan="2" align="left"><font color="#FF0000"><b><?php print $masalah;?></b></font></td>
    </tr>
	<?php } ?>
    <tr><td>&nbsp;</td></tr>
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
		AND B.event_id=".tosql($rs->fields['EVENT'])." ORDER BY A.no_bilik";
        $rs_l = $conn->Execute($sql_l); 
		$cnt_tempah = $rs_l->recordcount();
        //echo $sql_l;
		$conn->debug=false;
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
			$sql_l = "SELECT * FROM _sis_a_tblbilik WHERE status_bilik = 0 AND keadaan_bilik = 1 AND is_deleted = 0 
			AND blok_id=".tosql($blok_search,"Number")." ORDER BY no_bilik";
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
 <tr>
 	<td colspan="4" align="center"><br><input type="button" value="Daftar Masuk" class="button_disp" title="Sila klik untuk menyimpan maklumat" 
            onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')">
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
	document.ilim.blok_search.focus();
</script>
<?php } else { 
	//$conn->debug=true;
	$bilik_id = $_POST['bilik_id'];
	$tempahan_id = $_POST['tempahan_id'];
	$id = $_POST['id'];
	$EVENT = $_POST['EVENT'];
	$asrama_type = $_POST['asrama_type'];
	$tempahan = $_POST['tempahan'];
	$jantina = $_POST['jantina'];
	//echo "insert";
	
	if(!empty($tempahan_id)){ $bilik_id = dlookup("_sis_a_tblasrama_tempah", "bilik_id", "tempahan_id=".tosql($tempahan_id)); }
	
	$daftar_id = date("Ymd")."-".uniqid();
	$sql = "INSERT INTO _sis_a_tblasrama(daftar_id, bilik_id, peserta_id, event_id, create_dt, tkh_masuk, create_by, is_daftar, is_keluar, asrama_type, jantina )
	VALUES(".tosql($daftar_id).", ".tosql($bilik_id,"Number").", ".tosql($id).", ".tosql($EVENT).", ".tosql(date("Y-m-d")).", now(),
	".tosql($_SESSION["s_UserID"]).",1,0,".tosql($asrama_type).",".tosql($jantina).")";
	//print $sql; exit;
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
	
	//exit;
	
	/*print "<script language=\"javascript\">
		alert('Telah didaftarkan');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		</script>";*/
?>
<table width="100%" align="center" cellpadding="5" cellspacing="1" border="0">
	<tr>
    	<td colspan="4" height="30" bgcolor="#999999">&nbsp;<b>DAFTAR MASUK ASRAMA</b></td>
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
        <td width="25%" align="left"><b>Nama Penghuni</b></td>
        <td width="2%" align="left"><b>:</b></td>
        <td width="75%" colspan="2" align="left"><?php print $rs->fields['daftar_nama'];?></td>
    </tr>
    <tr>
        <td align="left"><b>No. HP</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $rs->fields['mobile'];?></td>
    </tr>
    <tr>
        <td align="left"><b>No. Tel (P)</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $rs->fields['tel'];?></td>
    </tr>
    <tr>
        <td align="left"><b>e-mel</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $rs->fields['emel'];?></td>
    </tr>
    <tr>
        <td align="left"><b>Jabatan</b></td>
        <td align="left"><b>:</b></td>
        <td colspan="2" align="left"><?php print $rs->fields['agensi'];?></td>
    </tr>

    <tr><td>&nbsp;</td></tr>

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
   	<td colspan="3" align="center"><b><font color="#FF0000">PESERTA TELAH MENDAFTAR MASUK ASRAMA</font></b></td>
   </tr>
 <tr>
 	<td colspan="4" align="center"><br>
            <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai peserta/penceramah" onClick="do_refresh()">
   	</td>
    </tr>
</table>

<?php } ?>