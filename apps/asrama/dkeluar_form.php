<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(confirm("Adakah anda pasti untuk daftar keluar penghuni ini?")){
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
//$conn->debug=true;
$proses = $_GET['pro'];

//$conn->debug=true;
$types = $_GET['tab'];        
//if(empty($id)){ $id = $_GET['ids']; }                    
//$href_search = "modal_form.php?win=".base64_encode('asrama/dkeluar_form.php;'.$id);
//$blok_search = $_POST['blok_search'];

$sql_l = "SELECT A.*, B.no_bilik, B.tingkat_id, C.f_bb_desc FROM _sis_a_tblasrama A, _sis_a_tblbilik B, _ref_blok_bangunan C
	WHERE A.bilik_id=B.bilik_id AND B.blok_id=C.f_bb_id AND A.daftar_id=".tosql($id);
   //$conn->debug=true;
$rs_l = &$conn->Execute($sql_l); 
$noic = $rs_l->fields['peserta_id'];

if($types=='peserta'){
	$sSQL="SELECT A.f_peserta_nama AS daftar_nama, A.f_peserta_noic AS NOKP, E.f_tempat_nama AS agensi, C.startdate, C.enddate, F.coursename 
	FROM _tbl_peserta A, _tbl_kursus_jadual_peserta B, _tbl_kursus_jadual C, _ref_tempatbertugas E, _tbl_kursus F
	WHERE A.f_peserta_noic=B.peserta_icno AND B.EventId=C.id AND A.is_deleted=0 AND A.BranchCd=E.f_tbcode AND C.courseid=F.id
	AND B.InternalStudentAccepted=1 ";  //C.enddate>=".tosql(date("Y-m-d"));
	$sSQL .= " AND B.peserta_icno=".tosql($noic);
	$sSQL .= " ORDER BY C.startdate, A.f_peserta_nama";
	$rs = &$conn->Execute($sSQL);
	//$cnt = $rs->recordcount();
} else {
	$sSQL="SELECT A.insname AS daftar_nama, A.insid AS NOKP, A.insorganization AS agensi, C.startdate, C.enddate, F.coursename 
	FROM _tbl_instructor A, _tbl_kursus_jadual_det B, _tbl_kursus_jadual C, _tbl_kursus F
	WHERE A.is_deleted=0 AND A.ingenid=B.instruct_id AND B.event_id=C.id AND C.courseid=F.id "; 
	$sSQL .= " AND A.insid=".tosql($noic);
	$sSQL .= $sql_search . " ORDER BY C.startdate, A.insname";
	$rs = &$conn->Execute($sSQL);
	//$cnt = $rs->recordcount();
}

if(empty($proses)){ 
//print $rs->fields['daftar_nama'];
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="5" cellspacing="1" border="0">
	<tr>
    	<td colspan="4" height="30" bgcolor="#999999">&nbsp;<b>DAFTAR KELUAR ASRAMA</b></td>
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
    		<input type="button" value="Daftar Keluar" name="dkeluar" class="button_disp" title="Sila klik untuk menyimpan maklumat" 
            onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')">
            <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai peserta/penceramah" 
            onClick="do_back()">
            <input type="hidden" name="id" value="<?=$id?>" />
            <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
            <input type="hidden" name="bilik_id" value="<?php print $rs_l->fields['bilik_id'];?>" />
   	</td>
    </tr>
</table>
</form>
<script language="javascript">
	document.ilim.dkeluar.focus();
</script>
<?php } else { 
	//$conn->debug=true;
	$bilik_id = $_POST['bilik_id'];
	$id = $_POST['id'];
	//echo "insert";
	$sql = "UPDATE _sis_a_tblasrama SET is_daftar=0, is_keluar=1, update_dt=now(), update_by='".$_SESSION["s_userid"]."' WHERE daftar_id=".tosql($id,"Text");
	$conn->Execute($sql);
	audit_trail($sql);
	//print "<br>".$sql;
	echo "Set Status Bilik Kepada KOSONG";
	$sql = "UPDATE _sis_a_tblbilik SET status_bilik=0 WHERE bilik_id=".tosql($bilik_id,"Number");
	$conn->Execute($sql);

	/*$jenis_bilik = dlookup("_sis_a_tblbilik", "jenis_bilik", "bilik_id = ".$bilik_id." ");
	$jumlah_penghuni = dlookup("_sis_a_tblasrama", "count(daftar_id)", "bilik_id = ".$bilik_id." AND is_daftar = 0");
	if($jumlah_penghuni==0) {
		echo "Set Status Bilik Kepada KOSONG";
		$sql = "UPDATE _sis_a_tblbilik SET status_bilik=0 WHERE bilik_id=".tosql($bilik_id,"Number");
		//$conn->Execute($sql);
		print "<br>".$sql;
	}*/
	
	//exit;
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="5" cellspacing="1" border="0">
	<tr>
    	<td colspan="4" height="30" bgcolor="#999999" align="center">&nbsp;<b>PENGHUNI ASRAMA INI TELAH MENDAFTAR KELUAR</b></td>
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
        <td colspan="4" align="center"><br>
                <input type="button" value="Tutup" class="button_disp" title="Sila klik untuk menutup paparan" onClick="do_refresh()">
        </td>
    </tr>
</table>
</form>
<?php } ?>