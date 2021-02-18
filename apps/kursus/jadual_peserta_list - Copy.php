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
	if(document.ilim.elements['chbCheck[]'].checked == true){
		intNo = intNo + 1;
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
$theDate = dlookup("_tbl_kursus_jadual","startdate","id=".tosql($id));
//$theDate = $rsk->fields['startdate'];
//$theDate = '2008-02-01';
$timeStamp = StrToTime($theDate);
// UNTUK TUJUAN PEMILIHAN SEMASA
$in6days = StrToTime('-7 days', $timeStamp);
$pls6days = StrToTime('+7 days', $timeStamp);
// KEADAAN SEBENAR
//$in6days = StrToTime('-30 days', $timeStamp);
//$pls6days = StrToTime('+30 days', $timeStamp);
$edate = date('Y-m-d', $in6days); 
$sdate = date('Y-m-d', $pls6days); 

//$conn->debug=true;
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
if(!empty($search)){ $sSQL.=" AND (f_peserta_nama LIKE '%".$search."%' OR f_peserta_noic LIKE '%".$search."%') "; }
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
<div style="float:inherit">
<table width="96%" border="0" cellpadding="1" cellspacing="0" align="center">
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
        <td rowspan="3">
        <b>
        H &nbsp;&nbsp;: <label style="color:#FF00DD">Hadir</label><br />
        TH&nbsp;: <label style="color:#FFDD00">Tidak Hadir</label><br />
        DP&nbsp;: <label style="color:#FF0000">Tiada Jawapan</label><br />
        </b>
        </td>
    </tr>
	<?php
    $sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
    $rspu = &$conn->execute($sqlp);
    ?>
    <tr>
        <td align="right"><b>Jabatan/Agensi/Unit : </b></td>
        <td align="left" colspan="3">
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
        <td align="left" colspan="3">
        	<input type="text" size="40" name="search" value="<?php print $search;?>" />
        	<input type="button" value="Cari" onclick="do_open('<?=$ruri;?>')" style="cursor:pointer" />&nbsp;
            <input type="button" name="Cari" value="  Proses Pemilihan  " onClick="do_pilih('<?=$ruri;?>')">&nbsp;
            <input type="button" value="Tutup" onclick="form_back()" style="cursor:pointer" />
        </td>
    </tr>
</table>
</div>
<br />
<div style="position:absolute; left:0px; top:100px; width:100%; height:75%; background-color:#ffffff; overflow:auto;">
<table width="96%" border="1" cellpadding="3" cellspacing="0" align="center">
	<tr bgcolor="#CCCCCC"><td colspan="8"><b>Senarai Maklumat <?=$title;?></b></td></tr>
	<tr bgcolor="#CCCCCC">
    	<td align="center" width="3%" rowspan="2"><b>Bil</b></td>
    	<td align="center" width="3%" rowspan="2"><b>Pilih</b></td>
    	<td align="center" width="44%" rowspan="2"><b>Nama</b></td>
    	<td align="center" width="10%" rowspan="2"><b>Gred</b></td>
    	<td align="center" width="31%" rowspan="2"><b>Agensi/Jabatan/Unit</b></td>
        <td align="center" colspan="3" width="9%">Maklumat Permohonan</td>
    </tr>
    <tr bgcolor="#CCCCCC">
    	<td align="center" width="3%">H</td>
    	<td align="center" width="3%">TH</td>
    	<td align="center" width="3%">DP</td>
    </tr>
	<?php while(!$rs->EOF){ $bil++; 
		$sqlss = "SELECT count(*) AS cnts, InternalStudentAccepted FROM _tbl_kursus_jadual_peserta 
		WHERE peserta_icno=".tosql($rs->fields['f_peserta_noic']);
		$sqlss .= " GROUP BY InternalStudentAccepted";
		//if($rs->fields['f_peserta_noic']=='3007958'){ print $sqlss; }
		// print $sqlss;
		$ic=$rs->fields['f_peserta_noic'];
		$rscnt = &$conn->execute($sqlss);
		$bgcolor='#FFFFFF'; $tjawab=''; $datang=''; $xdatang='';
		while(!$rscnt->EOF){
			if($rscnt->fields['InternalStudentAccepted']=='0'){ $tjawab = $rscnt->fields['cnts']; }//$bgcolor = "#FF0000"; }
			if($rscnt->fields['InternalStudentAccepted']=='1'){ $datang = $rscnt->fields['cnts']; }//$bgcolor = "#FF00DD"; }
			if($rscnt->fields['InternalStudentAccepted']=='2'){ $xdatang += $rscnt->fields['cnts']; }//$bgcolor = "#FFDD00"; }
			if($rscnt->fields['InternalStudentAccepted']==''){ $xdatang += $rscnt->fields['cnts']; }//$bgcolor = "#FFFFFF"; }
			$rscnt->movenext();
		}
		
		$sql_k = "SELECT * FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B 
			WHERE A.EventId=B.id AND A.is_selected=1 AND A.peserta_icno=".tosql($rs->fields['f_peserta_noic'])." 
			AND (B.startdate BETWEEN '".$edate."' AND '".$sdate."')"; // OR (B.enddate BETWEEN '".$sdate."' AND '".$edate."')
			//AND (('".$sdate."'>=B.startdate) OR ('".$edate."'<=B.startdate))";
			//AND (( '".$theDate."' BETWEEN B.startdate  AND B.enddate ) OR ( '".$edate."' BETWEEN B.startdate  AND B.enddate )) "; // OR 
			//(B.enddate BETWEEN '".$sdate."' AND '".$edate."')
		$rs_data = &$conn->execute($sql_k); //print $sql_k;
		if(!$rs_data->EOF){ 
			$ada = 'A'; $sel=9; 
			$masa = $rs_data->fields['startdate'];
			$kursus = dlookup("_tbl_kursus","coursename","id=".tosql($rs_data->fields['courseid']));
			$tada='<br>Peserta telah terpilih untuk mengikuti kursus lain @ Peserta pernah mengikuti kursus dalam tempoh 60 hari.<br>'.$kursus." (".DisplayDate($masa).")"; 
		} else { 
			$ada='T'; $sel=0; $tada='';
		}

		if($xdatang>$datang){ $bgcolor = "#FFDD00"; }
		if($tjawab>$datang){ $bgcolor = "#FF0000"; }
		if($tjawab==$xdatang){ $bgcolor = "#FF00DD"; }
		else { $bgcolor = "#FFFFFF"; }
	?>
	<tr bgcolor="<?=$bgcolor;?>">
    	<td align="right"><?php print $bil; ?>.&nbsp;<?=$xnts;?></td>
        <td align="center" valign="top"><input type="checkbox" name="chbCheck[]" value="<?php print $rs->fields['f_peserta_noic'];?>" 
			<?php if($sel==9){ ?> disabled="disabled" <?php } else { ?> style="cursor:pointer"<?php } ?>/></td>
        <td align="left"><a href="#" onclick="openModal('peserta/view_peserta.php?id=<?=$ids;?>&ic=<?=$ic;?>')"><?php print $rs->fields['f_peserta_nama'];?></a><?=$tada;?></td>
        <td align="center"><?php print dlookup("_ref_titlegred","f_gred_code","f_gred_id=".tosql($rs->fields['f_title_grade']));?>&nbsp;</td>
        <td align="left"><?php print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs->fields['BranchCd']));?></td>
        <td align="center"><?=$datang;?></td>
        <td align="center"><?=$xdatang;?></td>
        <td align="center"><?=$tjawab;?></td>
    </tr>
    <?php $rs->movenext(); } ?>
    <tr>
    	<td colspan="8">
        	<input type="button" name="Cari" value="  Proses Pemilihan  " onClick="do_pilih('<?=$ruri;?>')">
        	<input type="hidden" name="event_id" value="<?php print $id;?>" />
        	<input type="hidden" name="ty" value="<?php print $ty;?>" />
        	<input type="hidden" name="proses" value="" />
            &nbsp;<input type="button" value="Tutup" onclick="form_back()" style="cursor:pointer" />
            <input type="hidden" name="bilangan" value="<?=$bil;?>" />
    	</td>
    </tr>
</table>
</div>
</form>
</body>
</html>
<?php } else {
	//$conn->debug=true;
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
		$icno = $pilih[$i];
		$sql_sel = "SELECT * FROM _tbl_kursus_jadual_peserta WHERE EventId=".tosql($event_id)." AND peserta_icno=".tosql($icno);
		$rs_get = &$conn->Execute($sql_sel);
		if($rs_get->EOF){
			$sqlu = "INSERT INTO _tbl_kursus_jadual_peserta(EventId, peserta_icno, InternalStudentSelectedDt, InternalStudentAccepted, 
			InternalStudentInputDt, InternalStudentInputBy, is_selected) 
			VALUES(".tosql($event_id).", ".tosql($icno,"Text").", ".tosql(date("Y-m-d H:i:s")).",0, 
			".tosql(date("Y-m-d H:i:s")).", ".tosql($_SESSION["s_logid"]).",1)";
			//print $sqlu."<br>";
			$result = $conn->Execute($sqlu);
			if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		}
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