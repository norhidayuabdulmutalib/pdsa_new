<?php
// $conn->debug=true;
$kid=isset($_REQUEST["kid"])?$_REQUEST["kid"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";

if(!empty($pro) && $pro=='PILIH'){
	if(empty($id)){ $id = $kid; }
	$bilikid=isset($_REQUEST["bilikid"])?$_REQUEST["bilikid"]:"";
	$sql = "UPDATE _tbl_kursus_jadual SET bilik_kuliah=".tosql($bilikid)." WHERE id=".tosql($id);
	//print $sql; print $kid;
	$conn->execute($sql);
	
	print '<script>		
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
	</script>';
	exit;
}

$sSQL="SELECT A.*, B.startdate, B.enddate, B.bilik_kuliah
FROM _tbl_kursus A, _tbl_kursus_jadual B WHERE A.id=B.courseid AND B.id = ".tosql($kid,"Text");
$rs = &$conn->Execute($sSQL);

$href_search = "modal_form.php?win=".base64_encode('kursus/jadual_bilik_kuliah.php;'.$kid);
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page1(URL){
		if(confirm("Adakah anda pasti untuk membuat pilihan ini?")){
			document.ilim.action = URL;
			document.ilim.target = '_self';
			document.ilim.submit();
		}
	}
</script>
<?php //include_once 'include/list_head.php'; ?>

<form name="ilim" method="post">
<div class="card">
	<div class="card-header" >
		<h4>MAKLUMAT BILIK KULIAH</h4>
	</div>
	<div class="card-body">

		<div class="form-group row mb-4">
			<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kursus :</b></label>
			<div class="col-sm-12 col-md-7">
				<?php print $rs->fields['coursename'];?>
			</div>
		</div>

		<div class="form-group row mb-4">
			<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tarikh 	Mula Kursus : </b></label>
				<div class="col-sm-12 col-md-2">
					<?php echo date('d-m-Y', strtotime($rs->fields['startdate'])) ?>
				</div>
			<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tarikh 	Mula Kursus : </b></label>
				<div class="col-sm-12 col-md-2">
					<?php echo date('d-m-Y', strtotime($rs->fields['enddate'])) ?>
				</div>
		</div>

		<div class="form-group row mb-4" style="float:right">
			<div>
				<button class="btn btn-danger" value="Kosongkan Bilik" style="cursor:pointer;padding:8px;" 
				onclick="do_page1('<?=$href_search;?>&pro=PILIH&bilikid=&kid=<?=$id;?>')" title="Sila klik untuk mengosongkan maklumat bilik kuliah" ><i class="fas fa-times-circle"></i> Kosongkan Bilik</button>
				<input type="button" class="btn btn-secondary" value="Tutup" onclick="javascript:parent.emailwindow.hide();" style="cursor:pointer;padding:8px;" />
			</div>
		</div>
	</div>
</div>

	<!-- <tr>
		<td align="right"><b>Tarikh Kursus : </b></td> 
		<td align="left">&nbsp;&nbsp;Mula : <?php// print DisplayDate($rs->fields['startdate']);?> 
        &nbsp;&nbsp;&nbsp;Tamat : <?php //print DisplayDate($rs->fields['enddate']);?></td>
	</tr> -->
	<!--<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="70%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<?php //echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?//=$href_search;?>')">
            <input type="hidden" name="kid" value="<?//=$kid;?>" />
		</td>
	</tr>-->

<?php
$days = get_datediff($rs->fields['startdate'],$rs->fields['enddate']);
//print "DAT:".$days;

$sSQL="SELECT * FROM _tbl_bilikkuliah  WHERE is_deleted=0 ";
if(!empty($search)){ $sSQL.=" AND f_bilik_nama LIKE '%".$search."%' "; } 
$sSQL .= "ORDER BY f_bilik_nama";
$rs_bilik = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

if(!$rs_bilik->EOF) {
	$cnt = 1;
	$bil = 0;
	while(!$rs_bilik->EOF) {
    	$bil++; $kosong=0;
		for($i=-1;$i<=$days;$i++){ 
			$ddate = DBDate(get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i));
			$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE bilik_kuliah=".tosql($rs_bilik->fields['f_bilikid'])." AND ".tosql($ddate)." BETWEEN startdate AND enddate";
			$rs_masa = $conn->execute($sqlk);
			if(!$rs_masa->EOF){ $kosong=1; }
		}
?>

<div class="table-responsive">
    <table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="8"><b><?php print strtoupper(stripslashes($rs_bilik->fields['f_bilik_nama']));?></b>
				<?php if(empty($kosong)){ ?>
					<input type="button" class="btn btn-success" value="Pilih Bilik Kuliah" style="cursor:pointer" 
				onclick="do_page1('<?=$href_search;?>&pro=PILIH&bilikid=<?=$rs_bilik->fields['f_bilikid'];?>&kid=<?=$id;?>')" 
				title="Sila klik untuk membuat pemilihan bilik kuliah" ><b><?php } ?>
			</th>
		</tr>

	<!-- <table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="100%" align="left" bgcolor="#999999" height="25" valign="middle">
			<div style="float:left;vertical-align:middle">&nbsp;&nbsp;
				<b><?php //print strtoupper(stripslashes($rs_bilik->fields['f_bilik_nama']));?></b>
			</div>
			<div style="float:right">
				<?php //if(empty($kosong)){ ?>
				<input type="button" value="Pilih Bilik Kuliah" style="cursor:pointer" 
				onclick="do_page1('<?//=$href_search;?>&pro=PILIH&bilikid=<?//=$rs_bilik->fields['f_bilikid'];?>&kid=<?//=$id;?>')" 
				title="Sila klik untuk membuat pemilihan bilik kuliah" /><?php// } ?>&nbsp;&nbsp;
			</div>
        </td>
    </tr>
    <tr><td width="100%">
    	<table width="100%" cellpadding="2" cellspacing="0" border="1">
        	<tr> -->
	<tbody>
		<tr>
			<?php for($i=-1;$i<=$days;$i++){ ?>	
				<td align="center"><?=get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i);?></td>
			<?php } ?>
		</tr>
		<tr>
			<td>
				<?php for($i=-1;$i<=$days;$i++){ 
					$ddate = DBDate(get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i));
					$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE bilik_kuliah=".tosql($rs_bilik->fields['f_bilikid'])." AND ".tosql($ddate)." BETWEEN startdate AND enddate";
					$rs_masa = $conn->execute($sqlk);
					$kur = ''; $bils=0;
					while(!$rs_masa->EOF){
						if($bils==0){ $kur .= $rs_masa->fields ['courseid1']; }
						else { $kur .= " , ".$rs_masa->fields ['courseid1']; }
						$bils++;
						$rs_masa->movenext();
					}
					if(!empty($kur)){ $bgk="#FF9900"; } else { $bgk='#FFFFFF'; }
					print '<td height=21px align=center bgcolor='.$bgk.'>'.$kur.'</td>';			
				}
				?>	
			</td>
		</tr>
    </tbody>
	</table>

<?php
		$rs_bilik->movenext();
	} 
} ?>                   
</form>
