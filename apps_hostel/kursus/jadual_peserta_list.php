<?php
$uri = explode("?",$_SERVER['REQUEST_URI']);
$ruri = $_SERVER['REQUEST_URI'];
$URLs = $uri[1];
$proses = $_POST['proses'];
$ty = $_GET['ty'];
//print_r($uri);
if(empty($proses)){
	$search = $_POST['search'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script language="javascript" type="text/javascript">
function do_open(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}
function do_pilih(URL){
	var intNo=0;
	for(i=0;i<document.ilim.elements['chbCheck[]'].length;i++){
		if(document.ilim.elements['chbCheck[]'][i].checked == true){
			intNo = intNo + 1;
		}
	}	
	if(intNo==0){
		alert('Tiada rekod untuk diproses.');
		return false;
	} else {
		if(confirm("Adakah anda pasti untuk membuat proses ini?")){
			document.ilim.proses.value = 'PROSES';
			document.ilim.action = URL;
			document.ilim.target = '_self';
			document.ilim.submit();
		}
	}
}
function form_back(){
	parent.emailwindow.hide();
}
</script>
</head>

<body>
<?php
$sql_k = "SELECT * FROM _tbl_kursus_kriteria WHERE event_id=".tosql($id,"Text");
$rs_det = &$conn->execute($sql_k);
$sql='';
if(!empty($rs_det->fields['jtb1']) && !empty($rs_det->fields['jtb1'])){ $sql .= " AND ".date("Y")."-year(f_peserta_appoint_dt)".$rs_det->fields['jtb1'] . $rs_det->fields['jtb2']; }
if(!empty($rs_det->fields['grade1']) && !empty($rs_det->fields['grade1'])){ $sql .= " AND f_title_grade1 ".$rs_det->fields['grade1'] . tosql($rs_det->fields['grade2']); }
if(!empty($rs_det->fields['subjek'])){ $sql .= ""; }

//print $sql; exit; 
$gred=isset($_REQUEST["gred"])?$_REQUEST["gred"]:"";
$jabatan=isset($_REQUEST["jabatan"])?$_REQUEST["jabatan"]:"";

$sSQL="SELECT * FROM _tbl_peserta WHERE is_deleted=0 ";
if(!empty($gred)){ $sSQL.=" AND f_title_grade=".tosql($gred,"Number"); } 
if(!empty($jabatan)){ $sSQL.=" AND BranchCd=".tosql($jabatan); } 
if(!empty($search)){ $sSQL.=" AND f_peserta_nama LIKE '%".$search."%' "; }
$sSQL .= $sql;
$sSQL .= " AND f_peserta_noic NOT IN (SELECT peserta_icno FROM _tbl_kursus_jadual_peserta WHERE EventId=".tosql($id).")";
$sSQL .= " ORDER BY f_peserta_nama";
//print $sSQL; exit; 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;
$bil=0;
?>
<form name="ilim" method="post">
<table width="96%" border="0" cellpadding="3" cellspacing="0" align="center">
	<?php
    $sqlp = "SELECT * FROM _ref_titlegred WHERE is_deleted=0 AND f_status=0 ORDER BY f_gred_code";
    $rspg = &$conn->execute($sqlp);
    ?>
    <tr>
        <td align="right"><b>Gred Jawatan : </b></td>
        <td align="left" colspan="2">
        <select name="gred">
        	<option value="">-- Sila Pilih Gred --</option>
            <?php while(!$rspg->EOF){ ?>
            <option value="<?php print $rspg->fields['f_gred_id'];?>" <?php if($rspg->fields['f_gred_id']==$gred){ print 'selected'; }?>><?php print $rspg->fields['f_gred_code'] ." - ". $rspg->fields['f_gred_name'];?></option>
            <? $rspg->movenext(); } ?>
       </select>   
        </td>
    </tr>
	<?php
    $sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
    $rspu = &$conn->execute($sqlp);
    ?>
    <tr>
        <td align="right"><b>Jabatan/Agensi/Unit : </b></td>
        <td align="left" colspan="2">
        <select name="jabatan">
            <option value="">-- Sila pilih --</option>
            <?php while(!$rspu->EOF){ ?>
            <option value="<?php print $rspu->fields['f_tbcode'];?>" <?php if($rspu->fields['f_tbcode']==$jabatan){ print 'selected'; }?>><?php print $rspu->fields['f_tempat_nama'];?></option>
            <? $rspu->movenext(); } ?>
        </select>
        </td>
    </tr>
	<tr>
    	<td align="right"><b>Maklumat carian : </b></td>
        <td align="left">
        	<input type="text" size="40" name="search" value="<?php print $search;?>" />
        	<input type="button" value="Cari" onclick="do_open('<?=$ruri;?>')" style="cursor:pointer" />
            &nbsp;&nbsp;<input type="button" value="Tutup" onclick="form_back()" style="cursor:pointer" />
        </td>
    </tr>
</table>
<br />
<table width="96%" border="1" cellpadding="3" cellspacing="0" align="center">
	<tr bgcolor="#CCCCCC"><td colspan="5"><b>Senarai Maklumat <?=$title;?></b></td></tr>
	<tr>
    	<td align="center" width="5%"><b>Bil</b></td>
    	<td align="center" width="5%"><b>Pilih</b></td>
    	<td align="center" width="45%"><b>Nama</b></td>
    	<td align="center" width="10%"><b>Gred</b></td>
    	<td align="center" width="35%"><b>Agensi/Jabatan/Unit</b></td>
    </tr>
	<?php while(!$rs->EOF){ $bil++; ?>
	<tr>
    	<td align="right"><?php print $bil; ?>.&nbsp;</td>
        <td align="center"><input type="checkbox" name="chbCheck[]" value="<?php print $rs->fields['f_peserta_noic'];?>" /></td>
        <td align="left"><?php print $rs->fields['f_peserta_nama'];?></td>
        <td align="center"><?php print dlookup("_ref_titlegred","f_gred_code","f_gred_id=".tosql($rs->fields['f_title_grade']));?>&nbsp;</td>
        <td align="left"><?php print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs->fields['BranchCd']));?></td>
    </tr>
    <?php $rs->movenext(); } ?>
    <tr>
    	<td colspan="5">
        	<input type="button" name="Cari" value="  Proses Pemilihan  " onClick="do_pilih('<?=$ruri;?>')">
        	<input type="hidden" name="event_id" value="<?php print $id;?>" />
        	<input type="hidden" name="ty" value="<?php print $ty;?>" />
        	<input type="hidden" name="proses" value="" />
            &nbsp;<input type="button" value="Tutup" onclick="form_back()" style="cursor:pointer" />
    	</td>
    </tr>
</table>
</form>
</body>
</html>
<?php } else {
	$conn->debug=true;
	//print 'simpan';
	include '../loading_pro.php';
	$event_id=$_POST['event_id'];
	$ty=$_POST['ty'];

	$size=sizeof($_POST["chbCheck"]);
	$pilih = $_POST["chbCheck"];
	//print $size."<br>";
	for($i=0;$i<$size;$i++){
		//print $pilih[$i]."/";
		$m_update_dt 	= date("Y-m-d H:i:s");
		$update_by = $_SESSION["s_fld_user_id"];
		//$List = $_POST['chbCheck'];
		$sqlu = "INSERT INTO _tbl_kursus_jadual_peserta(EventId, peserta_icno, InternalStudentSelectedDt, InternalStudentAccepted, InternalStudentInputDt, InternalStudentInputBy) 
		VALUES(".tosql($event_id).", ".tosql($pilih[$i],"Text").", ".tosql(date("Y-m-d H:i:s")).",0, ".tosql(date("Y-m-d H:i:s")).", ".tosql($_SESSION["s_logid"]).")";
		//print $sqlu."<br>";
		$result = $conn->Execute($sqlu);
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
	}
	audit_trail("Tambah maklumat peserta");
	
	
	//exit;
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		</script>";
}
?>