<?php
$uri = explode("?",$_SERVER['REQUEST_URI']);
$ruri = $_SERVER['REQUEST_URI'];
$URLs = $uri[1];
$proses = $_POST['proses'];
$ty = $_GET['ty'];
//print_r($uri);
if(empty($proses)){
	$search = $_POST['search'];
	if($ty=='PE'){ $title = 'Penceramah'; } else { $title = "Fasilaitior"; }
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
function form_back(URL){
	parent.emailwindow.hide();
}
</script>
</head>

<body>
<?php
$sSQL="SELECT * FROM _tbl_instructor WHERE ingenid <> '' AND is_deleted=0 AND instypecd ='01' ";
//if(!empty($j)){ $sSQL.=" AND fld_jawatan='P' "; } 
if(!empty($search)){ $sSQL.=" AND insname LIKE '%".$search."%' "; }
$sSQL .= " AND ingenid NOT IN (SELECT instruct_id FROM _tbl_kursus_jadual_det)";
$sSQL .= " ORDER BY insname";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;
$bil=0;
?>
<form name="ilim" method="post">
<table width="96%" border="0" cellpadding="3" cellspacing="0" align="center">
	<tr>
    	<td align="right"><b>Maklumat carian <?=$title;?> : </b></td>
        <td align="left">
        	<input type="text" size="40" name="search" value="<?php print $search;?>" />
        	<input type="button" value="Cari" onclick="do_open('<?=$ruri;?>')" style="cursor:pointer" />
            &nbsp;&nbsp;<input type="button" value="Tutup" onclick="form_back()" style="cursor:pointer" />

        </td>
    </tr>
</table>
<br />
<table width="96%" border="1" cellpadding="3" cellspacing="0" align="center">
	<tr bgcolor="#CCCCCC"><td colspan="4"><b>Senarai Maklumat <?=$title;?></b></td></tr>
	<tr>
    	<td align="center" width="5%"><b>Bil</b></td>
    	<td align="center" width="5%"><b>Pilih</b></td>
    	<td align="center" width="40%"><b>Nama <?=$title;?></b></td>
    	<td align="center" width="50%"><b>Agensi/Jabatan/Unit</b></td>
    </tr>
	<?php while(!$rs->EOF){ $bil++; ?>
	<tr>
    	<td align="right"><?php print $bil; ?>.&nbsp;</td>
        <td align="center"><input type="checkbox" name="chbCheck[]" value="<?php print $rs->fields['ingenid'];?>" /></td>
        <td align="left"><?php print $rs->fields['insname'];?></td>
        <td align="left"><?php print $rs->fields['insorganization'];?></td>
    </tr>
    <?php $rs->movenext(); } ?>
    <tr>
    	<td colspan="4">
        	<input type="button" name="Cari" value="  Proses Pemilihan  " onClick="do_pilih('<?=$ruri;?>')">
        	<input type="text" name="event_id" value="<?php print $id;?>" />
        	<input type="text" name="ty" value="<?php print $ty;?>" />
        	<input type="text" name="proses" value="" />
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
		$sqlu = "INSERT INTO _tbl_kursus_jadual_det(event_id, instruct_id, instruct_type) 
		VALUES(".tosql($event_id,"Text").", ".tosql($pilih[$i],"Text").", ".tosql($ty,"Text").")";
		//print $sqlu."<br>";
		$result = $conn->Execute($sqlu);
		audit_trail($sqlu);
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
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