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

function chk_pilih(URL,ids,pro){
	//alert(URL);
	if(confirm("Adakah anda pasti untuk membuat proses ini?")){
		document.ilim.ids.value=ids;
		document.ilim.pro.value=pro;
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
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
//$conn->debug=true;

$ids=isset($_REQUEST["ids"])?$_REQUEST["ids"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
if(!empty($ids) && !empty($pro)){
	if($pro=='DEL'){
		$sql = 'UPDATE _tbl_kursus_jadual_peserta SET is_selected=9 WHERE InternalStudentId='.tosql($ids);
	} else {
		$sql = 'UPDATE _tbl_kursus_jadual_peserta SET is_selected=0 WHERE InternalStudentId='.tosql($ids);
	}
	//print $sql;
	$conn->execute($sql);
}

$conn->debug=false;

$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Text");
$rsk = &$conn->Execute($sSQL);
$kursus = $rsk->fields['courseid'] . " - " .$rsk->fields['coursename'];
$tkh = DisplayDate($rsk->fields['startdate']).' - '. DisplayDate($rsk->fields['enddate']);
//$sdate = $rsk->fields['startdate'];
//$edate = $rsk->fields['enddate'];
$theDate = $rsk->fields['startdate'];

//$theDate = '2008-02-01';
$timeStamp = StrToTime($theDate);
// UNTUK TUJUAN PEMILIHAN SEMASA
$in6days = StrToTime('-7 days', $timeStamp);
$pls6days = StrToTime('+7 days', $timeStamp);
// KEADAAN SEBENAR
//$in6days = StrToTime('-30 days', $timeStamp);
//$pls6days = StrToTime('+30 days', $timeStamp);
//echo "{$theDate} + 30 days = ". date('Y-m-d', $in6days); 
$edate = date('Y-m-d', $in6days); 
$sdate = date('Y-m-d', $pls6days); 

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
$sSQL .= " AND f_peserta_noic NOT IN (SELECT peserta_icno FROM _tbl_kursus_jadual_peserta WHERE EventId=".tosql($id).")";
$sSQL .= " ORDER BY f_peserta_nama";
//print $sSQL; exit; 
$sSQL = "SELECT DISTINCT(B.f_peserta_noic), A.*, B.f_peserta_nama, B.BranchCd, B.f_title_grade 
FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
WHERE A.peserta_icno=B.f_peserta_noic AND A.is_deleted=0 AND A.is_selected in (0,9) AND A.EventId=".tosql($id);
$sSQL .= " GROUP BY B.f_peserta_noic ORDER BY A.is_selected, B.f_peserta_nama";

$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;
$bil=0;
?>
<form name="ilim" method="post">
<div style="float:inherit">
<table width="96%" border="0" cellpadding="1" cellspacing="0" align="center">
	<tr>
        <td align="left">
        	<div>
            <div style="float:left">
            <input type="button" name="Cari" value="  Proses Pemilihan  " onClick="do_pilih('<?=$ruri;?>')">&nbsp;
            <input type="button" value="Tutup" onclick="form_back()" style="cursor:pointer" />
        	</div>
            <div style="float:right">
            	<table width="400px" align="right" cellpadding="3" cellspacing="0">
                	<tr>
                    	<td width="200px"><strong>TJ</strong> = Tiada Jawapan</td>
                        <td width="200px"><strong>H</strong> = Hadir</td>
                    </tr>
                	<tr>
                    	<td><strong>TH</strong> = Tidak Hadir</td>
                        <td><strong>DP</strong> = Dalam Proses</td>
                    </tr>
				</table>
            </div>
        	</div>
        </td>
    </tr>
</table>
</div>
<div style="position:absolute; left:-1px; top:84px; width:100%; height:90%; background-color:#ffffff; overflow:auto;">
<table width="96%" border="1" cellpadding="3" cellspacing="0" align="center">
	<tr bgcolor="#CCCCCC"><td colspan="10"><b>Senarai Permohonan Bagi <?=$kursus;?> pada <i>[<?=$tkh;?>]</i></b></td></tr>
	<tr bgcolor="#CCCCCC">
    	<td align="center" width="3%" rowspan="2"><b>Bil</b></td>
    	<td align="center" width="3%" rowspan="2"><b>Pilih</b></td>
    	<td align="center" width="45%" rowspan="2"><b>Nama</b></td>
    	<td align="center" width="9%" rowspan="2"><b>Gred</b></td>
    	<td align="center" width="31%" rowspan="2"><b>Agensi/Jabatan/Unit</b></td>
        <td align="center" colspan="4" width="12%">Maklumat Permohonan</td>
    	<td align="center" width="5%" rowspan="2">Status</td>
    </tr>
    <tr bgcolor="#CCCCCC">
    	<td align="center" width="3%">TJ</td>
    	<td align="center" width="3%">H</td>
    	<td align="center" width="3%">TH</td>
    	<td align="center" width="3%">DP</td>
    </tr>
	<?php while(!$rs->EOF){ $bil++; 
		/*$sqlss = "SELECT count(*) AS cnts, InternalStudentAccepted FROM _tbl_kursus_jadual_peserta 
		WHERE peserta_icno=".tosql($rs->fields['f_peserta_noic']);
		$sqlss .= " GROUP BY InternalStudentAccepted";
		//if($rs->fields['f_peserta_noic']=='3007958'){ print $sqlss; }
		//print $sqlss;
		$rscnt = &$conn->execute($sqlss);*/
		$ic=$rs->fields['f_peserta_noic'];
		$ids=$rs->fields['InternalStudentId'];
		$sel = $rs->fields['is_selected'];
		$bgcolor='#FFFFFF'; $tjawab=''; $datang=''; $xdatang=''; $dp='';
		
		$tjawab = dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted IS NULL AND is_selected=1 AND peserta_icno=".tosql($rs->fields['f_peserta_noic']));
		$datang = dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted=1 AND is_selected=1 AND peserta_icno=".tosql($rs->fields['f_peserta_noic']));
		$xdatang = dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted=2 AND is_selected=1 AND peserta_icno=".tosql($rs->fields['f_peserta_noic']));
		$dp = dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted IS NULL AND is_selected=0 AND peserta_icno=".tosql($rs->fields['f_peserta_noic']));
		
		/*while(!$rscnt->EOF){
			if($rscnt->fields['InternalStudentAccepted']=='0'){ $tjawab = $rscnt->fields['cnts']; $bgcolor = "#FF0000"; }
			if($rscnt->fields['InternalStudentAccepted']=='1'){ $datang = $rscnt->fields['cnts']; $bgcolor = "#FF00DD"; }
			if($rscnt->fields['InternalStudentAccepted']=='2'){ $xdatang = $rscnt->fields['cnts']; $bgcolor = "#FFDD00"; }
			if($rscnt->fields['InternalStudentAccepted']==''){ $dp += $rscnt->fields['cnts']; $bgcolor = "#FFDD00"; }
			$rscnt->movenext();
		}*/
		
		$sql_k = "SELECT * FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B 
			WHERE A.EventId=B.id AND A.is_selected=1 AND A.peserta_icno=".tosql($rs->fields['f_peserta_noic'])." 
			AND (B.startdate BETWEEN '".$edate."' AND '".$sdate."')"; // OR (B.enddate BETWEEN '".$sdate."' AND '".$edate."')
			//AND (('".$sdate."'>=B.startdate) OR ('".$edate."'<=B.startdate))";
			//AND (( '".$theDate."' BETWEEN B.startdate  AND B.enddate ) OR ( '".$edate."' BETWEEN B.startdate  AND B.enddate )) "; // OR (B.enddate BETWEEN '".$sdate."' AND '".$edate."')
		$rs_data = &$conn->execute($sql_k); //print $sql_k;
		if(!$rs_data->EOF){ 
			$ada = 'A'; $sel=9; 
			$masa = $rs_data->fields['startdate'];
			$kursus = dlookup("_tbl_kursus","coursename","id=".tosql($rs_data->fields['courseid']));
			$tada='<br>Peserta telah terpilih untuk mengikuti kursus lain @ Peserta pernah mengikuti kursus dalam tempoh 60 hari.<br>'.$kursus." (".DisplayDate($masa).")"; 
		} else { 
			$ada='T'; 
		}
		
		if($tjawab>$datang || $tjawab>$xdatang){ $bgcolor = "#FF0000"; }
		else if($datang>$tjawab || $datang>$xdatang){ $bgcolor = "#FF00DD"; }
		else if($xdatang>$datang || $xdatang>$tjawab){ $bgcolor = "#FFDD00"; }
		else { $bgcolor = "#FFFFFF"; }
	?>
	<tr bgcolor="<?=$bgcolor;?>">
    	<td align="right"><?php print $bil; ?>.&nbsp;</td>
        <td align="center" valign="top"><input type="checkbox" name="chbCheck[]" value="<?php print $rs->fields['f_peserta_noic'];?>" 
        <?php if($sel==9){ ?> disabled="disabled" <?php } ?> /></td>
        <td align="left"><a href="#" onclick="openModal('peserta/view_peserta.php?id=<?=$ids;?>&ic=<?=$ic;?>')"><?php print $rs->fields['f_peserta_nama'];?></a><?=$tada;?></td>
        <td align="center"><?php print dlookup("_ref_titlegred","f_gred_code","f_gred_id=".tosql($rs->fields['f_title_grade']));?>&nbsp;</td>
        <td align="left"><?php print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs->fields['BranchCd']));?></td>
        <td align="center"><?=$tjawab;?></td>
        <td align="center"><?=$datang;?></td>
        <td align="center"><?=$xdatang;?></td>
        <td align="center"><?=$dp;?></td>
        <td align="center" bgcolor="#FFFFFF">
        <?php if($rs->fields['is_selected']==9){ ?>
        	<img src="../img/close.gif" width="15" height="15" style="cursor:pointer" onclick="chk_pilih('modal_form.php?<?=$URLs;?>','<?=$ids;?>','SEL')" />
        <?php } else { ?>
        	<img src="../img/check.gif" width="15" height="15" style="cursor:pointer" onclick="chk_pilih('modal_form.php?<?=$URLs;?>','<?=$ids;?>','DEL')" />
        <?php } ?>
        
        <?//=$ada;?>
        </td>
    </tr>
    <?php $rs->movenext(); } ?>
    <tr>
    	<td colspan="10">
        	<input type="button" name="Cari" value="  Proses Pemilihan  " onClick="do_pilih('<?=$ruri;?>')">
        	<input type="hidden" name="event_id" value="<?php print $id;?>" />
        	<input type="hidden" name="ty" value="<?php print $ty;?>" />
        	<input type="hidden" name="proses" value="" />
            &nbsp;<input type="button" value="Tutup" onclick="form_back()" style="cursor:pointer" />
            <input type="hidden" name="bilangan" value="<?=$bil;?>" />
            <input type="hidden" name="pro" value="" />
            <input type="hidden" name="ids" value="" />
            <div style="float:right">
                Sila klik <img src="../img/check.gif" width="15" height="15" style="cursor:pointer" /> bagi tujuan penandaan tidak berjaya<br />
                Sila klik <img src="../img/close.gif" width="15" height="15" style="cursor:pointer" /> bagi tujuan pemilihan semula
            </div>
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
		if(!$rs_get->EOF){
			$idstud = $rs_get->fields['InternalStudentId'];  
			$sqlu = "UPDATE _tbl_kursus_jadual_peserta SET is_selected=1 WHERE InternalStudentId=".tosql($idstud)." AND EventId=".tosql($event_id)." AND peserta_icno=".tosql($icno); 
			//print $sqlu."<br>";
			$result = $conn->Execute($sqlu);
			if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
			audit_trail("Tambah maklumat peserta");
		}
	}
	
	
	//exit;
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		</script>";
}
?>