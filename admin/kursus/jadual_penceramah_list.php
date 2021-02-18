<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
$uri = explode("?",$_SERVER['REQUEST_URI']);
$actual_link = 'http://'.$_SERVER['HTTP_HOST']; //.$_SERVER['PHP_SELF'];
$URLs = $uri[1];
$proses=isset($_REQUEST["proses"])?$_REQUEST["proses"]:"";
$ty=isset($_REQUEST["ty"])?$_REQUEST["ty"]:"";
$ruri = $actual_link.$_SERVER['REQUEST_URI'];
//print $ruri;
//print $actual_link;

$ruri = str_replace("jakim","islam",$ruri);
$actual_link = str_replace("jakim","islam",$actual_link);


if(empty($proses)){
	$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
	if($ty=='PE'){ $title = 'Penceramah'; } else { $title = "Fasilaitior"; }
?>
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
$sSQL .= " AND ingenid NOT IN (SELECT instruct_id FROM _tbl_kursus_jadual_det WHERE event_id=".tosql($id).")";
$sSQL .= " ORDER BY insname";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;
$bil=0;
?>

<form name="ilim" method="post">
	<table width="95%" cellpadding="5" cellspacing="1" border="0" align="center">

		<div class="form-group row mb-4">
			<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Maklumat carian <?=$title;?> :  </b></label>
			<div class="col-sm-12 col-md-4">
				<input type="text" class="form-control" name="search" value="<?php print $search;?>" />
			</div>
			<div class="col-sm-12 col-md-1">
				<button class="btn btn-warning" value="Cari" onclick="do_open('<?=$ruri;?>')" style="cursor:pointer"><b> Cari</b></button>
			</div>
			<div class="col-sm-12 col-md-1">
				<button class="btn btn-secondary" value="Tutup" onclick="form_back()" style="cursor:pointer"><b> Tutup</b></button>
			</div>
			<div class="col-sm-12 col-md-3">
				<button class="btn btn-primary" name="Cari" value=" Proses Pemilihan" onClick="do_pilih('<?=$ruri;?>')"><b> Proses Pemilihan</b></button>
			</div>
				<input type="hidden" name="event_id" value="<?php print $id;?>" />
				<input type="hidden" name="ty" value="<?php print $ty;?>" />
				<input type="hidden" name="proses" value="" />
			</div>
		</div>
	</table>

	<div class="table-responsive">
		<table class="table table-bordered">
		<thead>
			<tr>
				<th colspan="8"><b>Senarai Maklumat <?=$title;?></b></th>
			</tr>
			<tr>
				<th align="center" width="5%"><b>Bil</b></th>
				<th align="center" width="5%"><b>Pilih</b></th>
				<th align="center" width="40%"><b>Nama <?=$title;?></b></th>
				<th align="center" width="50%"><b>Agensi/Jabatan/Unit</b></th>
			</tr>
		</thead>
		<tbody>
			<?php while(!$rs->EOF){ $bil++; ?>
			<tr>
				<td align="right"><?php print $bil; ?>.&nbsp;</td>
				<td align="center"><input type="checkbox" name="chbCheck[]" value="<?php print $rs->fields['ingenid'];?>" /></td>
				<td align="left"><?php print $rs->fields['insname'];?></td>
				<td align="left"><?php print $rs->fields['insorganization'];?></td>
			</tr>
			<?php $rs->movenext(); } ?>
			<tr>
				<td colspan="4" align="center">
					<input type="button" class="btn btn-secondary" value="Tutup" onclick="form_back()" style="cursor:pointer" />
				</td>
			</tr>
		</tbody>
		</table>
	</div>
</form>

<?php } else {
	//$conn->debug=true;
	//print 'simpan';
	include '../loading_pro.php';
	$event_id=$_POST['event_id'];
	$ty=isset($_REQUEST["ty"])?$_REQUEST["ty"]:"";

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
		audit_trail($sqlu,'INSERT');
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