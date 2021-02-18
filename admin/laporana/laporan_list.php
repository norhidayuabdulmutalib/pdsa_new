<script language="JavaScript1.2" type="text/javascript">
function do_page(URL){
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}

function do_page1(URL,targets){
	document.ilim.action = URL;
	document.ilim.target = targets;
	document.ilim.submit();
}

function do_post(){
	var data = document.ilim.data.value;
	document.ilim.action = "index.php?data="+data;
	document.ilim.target = '_self';
	document.ilim.submit();
}
</script>
<br /><br />
<?php
$data = $_GET['data'];
$kategori = $_POST['kategori'];
$sesi = $_POST['sesi'];
$semester = $_POST['semester'];
$ref_sukbah_id = $_POST['ref_sukbah_id'];
//$conn->debug=true;
$sql = "SELECT * FROM _ref_laporan WHERE status=0"; //WHERE types='A'
$rslaporan = $conn->execute($sql);

//print $_SESSION["s_level"];
if($_SESSION["s_level"]<>'99'){
	$kampus = "<br>".strtoupper(dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($_SESSION['SESS_KAMPUS'])));
	$_SESSION['KAMPUS_PRINT']=$_SESSION['SESS_KAMPUS'];
}
?>

<section class="section">
	<div class="section-body">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header" >
						<h4></h4>
					</div>
					<div class="card-body">
						<h5 align="center">PROSES CETAKAN LAPORAN<?=$kampus;?></h5>
						<?php if($_SESSION["s_level"]=='99'){
						//$conn->debug=true;
							$sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
							$rskks = &$conn->Execute($sqlkks);
						?>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat Latihan :</b></label>
							<div class="col-sm-12 col-md-8">
								<select class="form-control" name="kampus_id" style="width:60%">
									<option value="">-- Sila pilih kampus --</option>
									<?php while(!$rskks->EOF){ ?>
									<option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus_id==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
									<?php $rskks->movenext(); } ?>
								</select>
							</div>
						</div>
							<?php } else { ?>
							<input type="hidden" name="kampus_id" value="<?=$_SESSION['SESS_KAMPUS'];?>" />
							<?php } ?>

    						<?php while(!$rslaporan->EOF){ ?>
						<tr>
							<td width="100%" align="center" colspan="2">
								<?php
								if($rslaporan->fields['targets']=='_self'){
									$href = "index.php?data=".base64_encode('user;'.$rslaporan->fields['href'].';laporan;laporan');
								} else {
									//$href = "../".$rslaporan->fields['href'];
									$href = $rslaporan->fields['href'];
								}
								?>
								<a href="<?=$href;?>" target="<?php print $rslaporan->fields['targets'];?>">
								<input type="button" name="" value="<?php print $rslaporan->fields['tajuk'];?>" 
								style="width:400px; text-align:left; cursor:pointer;"></a><?//=$rslaporan->fields['href'];?>
								
								
								<?php $rslaporan->movenext(); 
								if($rslaporan->fields['targets']=='_self'){
									$href = "index.php?data=".base64_encode('user;'.$rslaporan->fields['href'].';laporan;laporan');
								} else {
									//$href = "../".$rslaporan->fields['href'];
									$href = $rslaporan->fields['href'];
								}
								?>
								<a href="<?=$href;?>" target="<?php print $rslaporan->fields['targets'];?>">
								<input type="button" name="" value="<?php print $rslaporan->fields['tajuk'];?>" 
								style="width:400px; text-align:left; cursor:pointer;"></a><?//=$rslaporan->fields['href'];?>
							</td>
						</tr>
						<?php $rslaporan->movenext(); } ?>
						<tr> 
						<td><input type="hidden" name="data" value="<?=$data;?>" /></td>
						</tr>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
