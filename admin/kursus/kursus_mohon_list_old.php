<?php
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
//$sSQL="SELECT * FROM _tbl_kursus WHERE is_deleted=0 ";
$sSQL="SELECT A.*, B.startdate, B.enddate, C.coursename, C.courseid, C.SubCategoryCd, C.category_code, C.subcategory_code, B.id 
FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B, _tbl_kursus C 
WHERE A.EventId=B.id AND B.courseid=C.id AND C.id=B.courseid AND A.approve_ilim=0 ";
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND C.kampus_id=".tosql($_SESSION['SESS_KAMPUS']); }
if(!empty($search)){ $sSQL.=" AND (C.coursename LIKE '%".$search."%' OR C.courseid  LIKE '%".$search."%') "; } 
if(!empty($kategori)){ $sSQL.=" AND C.category_code=".tosql($kategori,"Text"); } 
if(!empty($subkategori)){ $sSQL.=" AND C.subcategory_code=".tosql($subkategori,"Text"); } 
$sSQL .= " GROUP BY C.courseid ORDER BY coursename";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;
$href_search = "index.php?data=".base64_encode($userid.';kursus/kursus_mohon_list.php;kursus;peserta');
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}

function do_hapus(jenis,idh){
	var URL = 'include/proses_hapus.php?jenis='+jenis+'&idh='+idh;
	if(confirm("Adakah anda pasti untuk menghapuskan data yang dipilih daripada senarai?")){
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Hapus Maklumat', 'width=200px,height=200px,center=1,resize=1,scrolling=0')
	}
}
</script>


	<h1>
		Maklumat Permohonan Kursus
	</h1>
</div>
<br>
<section class="section">
	<div class="section-body">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4>Carian Maklumat Kursus</h4>
					</div>
					<?php include_once 'include/list_head.php'; ?>
					<form name="ilim" method="post">
						<div class="card-body">
							<?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
								$rskk = &$conn->Execute($sqlkk);
							?>
							<div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori Kursus :</b></label>
								<div class="col-sm-12 col-md-7">
									<select class="form-control" name="kategori"  onchange="do_page('<?=$href_search;?>')">
										<option>-- Sila pilih kategori --</option>
										<?php while(!$rskk->EOF){ ?>
											<option value="<?php print $rskk->fields['id'];?>" <?php if($kategori==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
										<?php $rskk->movenext(); } ?>
									</select>
								</div>
							</div>


							<?php 
								$sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 ORDER BY SubCategoryNm";
								$rskks = &$conn->Execute($sqlkks);
							?>
							<div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat / Unit : </b></label>
								<div class="col-sm-12 col-md-7">
								<select class="form-control" name="subkategori" onchange="do_page('<?=$href_search;?>')">
								<option value="">-- Sila pilih sub-kategori --</option>
									<?php while(!$rskks->EOF){ ?>
										<option value="<?php print $rskks->fields['id'];?>" <?php if($subkategori==$rskks->fields['id']){ print 'selected'; }?>><?php print pusat_list($rskks->fields['id']);?></option>
									<?php $rskks->movenext(); } ?>
								</select>
								</div>
							</div>
							<div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Nama Kursus : </b></label>
								<div class="col-sm-12 col-md-7">
									<input type="text" class="form-control" name="search" value="<?php echo stripslashes($search);?>">
								</div>
								<div class="col-sm-12 col-md-2">
									<button class="btn" style="background-color:#fed136;" name="Cari" onClick="do_page('<?=$href_search;?>')"><i class="fas fa-search"></i><b> Cari</b></button>
								</div>
							</div>
						</div>
					</form>

					<hr>


					<div class="row">
						<div class="col-12">
							<div class="card">
							<div class="card-header">
								<h4>Senarai Maklumat Kursus</h4>
							</div>
							<div class="card-body">
								<div class="table-responsive">
								<table class="table table-striped" id="table-1">
									<thead>
									<tr>
										<th class="text-center">
										#
										</th>
										<th>Task Name</th>
										<th>Progress</th>
										<th>Members</th>
										<th>Due Date</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<td>
										1
										</td>
										<td>Create a mobile app</td>
										<td class="align-middle">
										<div class="progress" data-height="4" data-toggle="tooltip" title="100%">
											<div class="progress-bar bg-success" data-width="100%"></div>
										</div>
										</td>
										<td>
										<img alt="image" src="../assets/img/avatar/avatar-5.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Wildan Ahdian">
										</td>
										<td>2018-01-20</td>
										<td><div class="badge badge-success">Completed</div></td>
										<td><a href="#" class="btn btn-secondary">Detail</a></td>
									</tr>
									<tr>
										<td>
										2
										</td>
										<td>Redesign homepage</td>
										<td class="align-middle">
										<div class="progress" data-height="4" data-toggle="tooltip" title="0%">
											<div class="progress-bar" data-width="0"></div>
										</div>
										</td>
										<td>
										<img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Nur Alpiana">
										<img alt="image" src="../assets/img/avatar/avatar-3.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Hariono Yusup">
										<img alt="image" src="../assets/img/avatar/avatar-4.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Bagus Dwi Cahya">
										</td>
										<td>2018-04-10</td>
										<td><div class="badge badge-info">Todo</div></td>
										<td><a href="#" class="btn btn-secondary">Detail</a></td>
									</tr>
									<tr>
										<td>
										3
										</td>
										<td>Backup database</td>
										<td class="align-middle">
										<div class="progress" data-height="4" data-toggle="tooltip" title="70%">
											<div class="progress-bar bg-warning" data-width="70%"></div>
										</div>
										</td>
										<td>
										<img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Rizal Fakhri">
										<img alt="image" src="../assets/img/avatar/avatar-2.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Hasan Basri">
										</td>
										<td>2018-01-29</td>
										<td><div class="badge badge-warning">In Progress</div></td>
										<td><a href="#" class="btn btn-secondary">Detail</a></td>
									</tr>
									<tr>
										<td>
										4
										</td>
										<td>Input data</td>
										<td class="align-middle">
										<div class="progress" data-height="4" data-toggle="tooltip" title="100%">
											<div class="progress-bar bg-success" data-width="100%"></div>
										</div>
										</td>
										<td>
										<img alt="image" src="../assets/img/avatar/avatar-2.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Rizal Fakhri">
										<img alt="image" src="../assets/img/avatar/avatar-5.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Isnap Kiswandi">
										<img alt="image" src="../assets/img/avatar/avatar-4.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Yudi Nawawi">
										<img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Khaerul Anwar">
										</td>
										<td>2018-01-16</td>
										<td><div class="badge badge-success">Completed</div></td>
										<td><a href="#" class="btn btn-secondary">Detail</a></td>
									</tr>
									</tbody>
								</table>
								</div>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include_once 'include/list_head.php'; ?> <!-- berapa list maklumat dlm satu table -->
<form name="ilim" method="post">
	<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
		<?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
			$rskk = &$conn->Execute($sqlkk);
		?>
		<tr>
			<td width="30%" align="right"><b>Kategori Kursus : <?php //var_dump($_SESSION); ?></b></td> 
			<td width="60%" align="left">
				<select name="kategori"  onchange="do_page('<?=$href_search;?>')">
					<option value="">-- Sila pilih kategori --</option>
					<?php while(!$rskk->EOF){ ?>
					<option value="<?php print $rskk->fields['id'];?>" <?php if($kategori==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
					<?php $rskk->movenext(); } ?>
				</select>
			</td>
		</tr>
		<?php 
			$sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 ORDER BY SubCategoryNm";
			$rskks = &$conn->Execute($sqlkks);
		?>
		<tr>
			<td align="right"><b>Pusat / Unit : </b></td> 
			<td align="left" colspan="2" >
				<select name="subkategori" onchange="do_page('<?=$href_search;?>')">
					<option value="">-- Sila pilih sub-kategori --</option>
					<?php while(!$rskks->EOF){ ?>
					<option value="<?php print $rskks->fields['id'];?>" <?php if($subkategori==$rskks->fields['id']){ print 'selected'; }?>><?php print pusat_list($rskks->fields['id']);?></option>
					<?php $rskks->movenext(); } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="30%" align="right"><b>Nama Kursus : </b></td> 
			<td width="60%" align="left">
				<input type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
				<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
			</td>
		</tr>
		<?php include_once 'include/page_list.php'; ?>
		<tr valign="top" bgcolor="#80ABF2"> 
			<td height="30" colspan="0" valign="middle">
			<font size="2" face="Arial, Helvetica, sans-serif">
				&nbsp;&nbsp;<strong>SENARAI MAKLUMAT KURSUS</strong></font>
			</td>
			<td colspan="2" valign="middle" align="right">&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5" align="center">
				<table width="100%" border="1" cellpadding="5" cellspacing="0">
					<tr bgcolor="#CCCCCC">
						<td width="5%" align="center"><b>Bil</b></td>
						<td width="10%" align="center"><b>Kod Kursus</b></td>
						<td width="35%" align="center"><b>Diskripsi Kursus</b></td>
						<td width="15%" align="center"><b>Kategori Kursus</b></td>
						<td width="25%" align="center"><b>Pusat / Unit</b></td>
						<td width="5%" align="center"><b>Jumlah Pemohon</b></td>
						<td width="5%" align="center"><b>&nbsp;</b></td>
					</tr>
					<?php
					if(!$rs->EOF) {
						$cnt = 1;
						$bil = $StartRec;
						while(!$rs->EOF  && $cnt <= $pg) {
							$del='';
							$bil = $cnt + ($PageNo-1)*$PageSize;
							$href_link = "modal_form.php?win=".base64_encode('kursus/kursus_mohon_form.php;'.$rs->fields['id']);
							//$href_link = "kursus/kursus_mohon_form.php?id=".$rs->fields['id'];
							//$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['subcategory_code'],"Text"));
							$unit = pusat_kursus($rs->fields['subcategory_code']);
							$jumlah = dlookup("_tbl_kursus_jadual_peserta","count(*)","EventId=".tosql($rs->fields['id']));
							?>
							<tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
								<td valign="top" align="right"><?=$bil;?>.</td>
								<td valign="top" align="left"><?php echo stripslashes($rs->fields['courseid']);?>&nbsp;</td>
								<td valign="top" align="left"><?php echo stripslashes($rs->fields['coursename']);?>&nbsp;</td>
								<td valign="top" align="center"><?php echo dlookup("_tbl_kursus_cat","categorytype",
									"id=".tosql($rs->fields['category_code'],"Number"));?>&nbsp;</td>
								<td valign="top" align="center"><?php echo stripslashes($unit);?>&nbsp;</td>
								<td valign="top" align="center"><?php echo number_format($jumlah,0);?>&nbsp;</td>
								<td align="center">
									<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
									onclick="open_modal('<?=$href_link;?>','Paparan maklumat permohonan peserta kursus',1,1)" />
								</td>
							</tr>
							<?
							$cnt = $cnt + 1;
							$bil = $bil + 1;
							$rs->movenext();
						} 
					} else {
					?>
					<tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
					<?php } ?>                   
				</table> 
			</td>
		</tr>
		<tr><td colspan="5">	
	<?php
	if($cnt<>0){
		$sFileName=$href_search;
		include_once 'include/list_footer.php'; 
	}
	?> 
	</td>
	</tr>
	<tr>
		<td>        
		</td>
	</td>
	</table> 
</form>
