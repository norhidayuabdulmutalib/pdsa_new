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
// var_dump(($_SESSION['SESS_KAMPUS']));
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

<?php include_once 'include/list_head.php'; ?>
<section class="section">
	<div class="section-body">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header" >
						<h4>Carian Maklumat Kursus</h4>
					</div>
					<form name="ilim" method="post">
						<div class="card-body">
						
						<?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
							$rskk = &$conn->Execute($sqlkk);
						?>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori Kursus :</b></label>
							<div class="col-sm-12 col-md-7">
								<select class="form-control" name="kategori"  onchange="do_page('<?=$href_search;?>')">
									<option value="">-- Sila pilih kategori --</option>
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
									<button class="btn" style="background-color:#fed136;" name="Cari"  onClick="do_page('<?=$href_search;?>')">
									<i class="fas fa-search"></i><b> Cari</b></button>
								</div>
						</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
					<div class="card-header">
						<h4>Senarai Maklumat Kursus</h4>
					</div>
					<div class="card-body">
					<table width="100%" cellpadding="3" cellspacing="0" border="0">
                            
						<?php include_once 'include/page_list.php'; ?>
							<div class="table-responsive">
								<table class="table table-bordered">
								<thead>
									<tr>
										<th width="5%" align="center"><b>Bil</b></th>
										<th width="10%" align="center"><b>Kod Kursus</b></th>
										<th width="35%" align="center"><b>Diskripsi Kursus</b></th>
										<th width="15%" align="center"><b>Kategori Kursus</b></th>
										<th width="25%" align="center"><b>Pusat / Unit</b></th>
										<th width="5%" align="center"><b>Jumlah Pemohon</b></th>
										<th width="5%" align="center"><b>Tindakan</b></th>
									</tr>
								</thead>
								<tbody>
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
													<button class="btn btn-warning" title="Sila klik untuk pengemaskinian data" style="cursor:pointer;padding:8px;"
														onclick="open_modal('<?=$href_link;?>','Paparan maklumat permohonan peserta kursus',1,1)" ><i class="fas fa-edit"></i>
													</button>
														<!-- <a href="<?//=$href_link;?>">
														<button class="btn btn-warning" title="Sila klik untuk pengemaskinian data" style="cursor:pointer;padding:8px;"><i class="fas fa-edit"></i>
														</button>
													</a> -->
												</td>
											</tr>
											<?php
											$cnt = $cnt + 1;
											$bil = $bil + 1;
											$rs->movenext();
										} 
									} else {
									?>
									<tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
									<?php } ?>                   
								</tbody>
								</table>
        					</div>
							<?php
							if($cnt<>0){
								$sFileName=$href_search;
								include_once 'include/list_footer.php'; 
							}
							?> 
					</table>
					</div>
                </div>
            </div>
        </div>
	</div>
</section>
