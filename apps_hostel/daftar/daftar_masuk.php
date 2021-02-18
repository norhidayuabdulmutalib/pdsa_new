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
</script>
<?
$proses = $_GET['pro'];
$nokp = $_POST['nokp'];
if($proses=='CLS'){ $nokp=''; $proses=''; }

//$conn->debug=true;
//$types = $_GET['tab'];        
//if(empty($id)){ $id = $_GET['ids']; }                    
$href_url = "index.php?data=".base64_encode('user;daftar/daftar_masuk.php;masuk;masuk');
//$blok_search = $_POST['blok_search'];
$disp_type='text';
//if(empty($id)){ $id = $_GET['ids']; }                    
$blok_search = $_POST['blok_search'];
$disp_type=''; $disp_asrama=''; $telah_daftar='';
if(!empty($nokp)){
	$sSQL="SELECT A.f_peserta_nama AS daftar_nama, A.f_peserta_noic AS NOKP, E.f_tempat_nama AS agensi, C.startdate, C.enddate, F.coursename, B.EventId AS EVENT  
	FROM _tbl_peserta A, _tbl_kursus_jadual_peserta B, _tbl_kursus_jadual C, _ref_tempatbertugas E, _tbl_kursus F
	WHERE A.f_peserta_noic=B.peserta_icno AND B.EventId=C.id AND A.is_deleted=0 AND A.BranchCd=E.f_tbcode AND C.courseid=F.id
	AND B.InternalStudentAccepted=1 AND ".tosql(date("Y-m-d"))." BETWEEN C.startdate AND C.enddate ";  //C.enddate>=".tosql(date("Y-m-d"));
	$sSQL .= " AND B.peserta_icno=".tosql($nokp);
	//$sSQL .= " AND B.peserta_icno NOT IN (SELECT peserta_id FROM _sis_a_tblasrama WHERE is_daftar=1)";
	$rs = &$conn->Execute($sSQL);
	$cnt = $rs->recordcount();
	if($cnt>0){ 
		$disp_type='hidden';
		$asrama_type='P'; $disp_asrama="<i>(PESERTA)</i>";
		$daftar_id = dlookup("_sis_a_tblasrama","daftar_id","is_daftar=1 AND peserta_id=".tosql($nokp));
		if(!empty($daftar_id)){ $telah_daftar='<font color=red><i> (Telah mendaftar masuk)</i></font>'; } 
	} else {	
		$sSQL="SELECT A.insname AS daftar_nama, A.insid AS NOKP, A.insorganization AS agensi, C.startdate, C.enddate, F.coursename, B.event_id AS EVENT 
		FROM _tbl_instructor A, _tbl_kursus_jadual_det B, _tbl_kursus_jadual C, _tbl_kursus F
		WHERE A.is_deleted=0 AND A.ingenid=B.instruct_id AND B.event_id=C.id AND C.courseid=F.id AND ".tosql(date("Y-m-d"))." BETWEEN C.startdate AND C.enddate "; 
		//C.enddate>=".tosql(date("Y-m-d"));
		//if(!empty($search)){ $sSQL .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.insid LIKE '%".$search."%' OR D.no_bilik LIKE '%".$search."%')"; }
		$sSQL .= " AND A.insid=".tosql($nokp);
		$sSQL .= $sql_search . " ORDER BY C.startdate, A.insname";
		$rs = &$conn->Execute($sSQL);
		$cnt = $rs->recordcount();
		if($cnt>0){ 
			$disp_type='hidden';
			$asrama_type='I';  $disp_asrama="<i>(PENCERAMAH)</i>";
			$daftar_id = dlookup("_sis_a_tblasrama","count(*)","is_daftar=1 AND peserta_id=".tosql($nokp));
			if(!empty($daftar_id)){ $telah_daftar='<font color=red><i> (Telah mendaftar masuk)</i></font>'; } 
		}
	}
	$disp_kp = $rs->fields['NOKP'];
}

//print $proses."/".$disp_type;
if(empty($proses)){ 
//print $rs->fields['daftar_nama'];
?>
<form name="ilim" method="post">
<table width="60%" align="center" cellpadding="5" cellspacing="1" border="0">
	<tr>
    	<td colspan="4" height="30" bgcolor="#999999">&nbsp;<b>DAFTAR MASUK ASRAMA</b></td>
    </tr>
    <tr>
        <td width="25%" align="left"><b>No K/P</b></td>
        <td width="2%" align="left"><b>:</b></td>
        <td width="75%" colspan="2" align="left">
		<input type="<?=$disp_type;?>" size="20" name="nokp" value="<?=$nokp;?>" onblur="do_page('<?=$href_url;?>')" />
		<?php print $disp_kp;?></td>
    </tr>
    <tr>
        <td width="25%" align="left"><b>Nama Penghuni</b></td>
        <td width="2%" align="left"><b>:</b></td>
        <td width="75%" colspan="2" align="left"><?php print $rs->fields['daftar_nama'];?>&nbsp;<?php print $disp_asrama;?></td>
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
     <td colspan="4" bgcolor="#CCCCCC"><b>MAKLUMAT BILIK <?php if(!empty($telah_daftar)){ print $telah_daftar; } ?></b></td>
   </tr>
   <?php if(empty($telah_daftar)){ ?>
    <? $sql_l = "SELECT * FROM _ref_blok_bangunan WHERE f_kb_id=2 AND f_bb_status = 0 AND is_deleted=0 ORDER BY f_bb_desc";
       $rs_l = &$conn->Execute($sql_l); 
    ?>
   <tr>
     <td align="left"><b>Blok</b></td>
     <td align="left"><b>:</b></td>
     <td colspan="2" align="left">
          <select name="blok_search" onchange="do_page('<?=$href_url;?>&tab=<?=$types;?>')">
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
   <?php } else { ?>
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
   <?php } ?>
 <tr>
 	<td colspan="4" align="center"><br>
	<?php if($disp_type=='hidden' && empty($telah_daftar)){ ?>        
    	<input type="button" value="Daftar Masuk" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('<? print $href_url;?>&pro=SAVE')">
	<?php } ?>
        <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai peserta/penceramah" onClick="do_page('<?=$href_url;?>&pro=CLS')">
        <input type="hidden" name="id" value="<?=$id?>" />
        <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
        <input type="hidden" name="EVENT" value="<?php print $rs->fields['EVENT'];?>" />
        <input type="hidden" name="asrama_type" value="<?php print $asrama_type;?>" />
   	</td>
    </tr>
</table>
</form>
<script language="javascript">
	document.ilim.nokp.focus();
</script>
<?php } else { 
	//$conn->debug=true;
	$bilik_id = $_POST['bilik_id'];
	$id = $_POST['id'];
	$nokp = $_POST['nokp'];
	$EVENT = $_POST['EVENT'];
	$asrama_type = $_POST['asrama_type'];
	//echo "insert";
	$daftar_id = date("Ymd")."-".uniqid();
	$sql = "INSERT INTO _sis_a_tblasrama(daftar_id, bilik_id, peserta_id, event_id, create_dt, tkh_masuk, create_by, is_daftar, is_keluar, asrama_type )
	VALUES(".tosql($daftar_id).", ".tosql($bilik_id,"Number").", ".tosql($nokp).", ".tosql($EVENT).", ".tosql(date("Y-m-d")).", now(),
	".tosql($_SESSION["s_userid"]).",1,0,".tosql($asrama_type).")";
	
	$conn->Execute($sql);
	//$new_id = mysql_insert_id();
	
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
<form name="ilim" method="post">
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
       <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai peserta/penceramah" onClick="do_page('<?=$href_url;?>&pro=CLS')">
   	</td>
    </tr>
</table>
</form>
<?php } ?>