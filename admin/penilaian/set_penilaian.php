<?php
//$conn->debug=true;
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT * FROM _tbl_penilaian_set A, _ref_kampus B WHERE A.is_deleted=0 AND A.kampus_id=B.kampus_id ";
if(!empty($search)){ $sSQL.=" AND A.pset_tajuk LIKE '%".$search."%' "; } 
if(!empty($kampus_id)){ $sSQL.=" AND B.kampus_id=".$kampus_id; }
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
$sSQL .= " ORDER BY A.create_dt DESC";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode($userid.';penilaian/set_penilaian.php;nilai;set');
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page_delete(URL){
		if(confirm("Adakah anda pasti untuk menghapuskan data ini?")){
			document.ilim.action = URL;
			document.ilim.target = '_self';
			document.ilim.submit();
		}
	}
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
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

                            <?php if($_SESSION["s_level"]=='99'){
                            //$conn->debug=true;
                                $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
                                $rskks = &$conn->Execute($sqlkks);
                            ?>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat Latihan :</b></label>
                                <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="kampus_id" onchange="do_page('<?=$href_search;?>')">
                                    <option value="">-- Sila pilih kampus --</option>
                                    <?php while(!$rskks->EOF){ ?>
                                        <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus_id==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                                    <?php $rskks->movenext(); } ?>
                                </select>
                                </div>
                            </div>
                            <?php } else { ?>
                                <input name="kampus_id" type="hidden" value="<?=$_SESSION['SESS_KAMPUS'];?>" />
                            <?php } ?>
                            <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Maklumat Carian : </b></label>
								<div class="col-sm-12 col-md-7">
			                        <input class="form-control" type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <button class="btn" style="background-color:#fed136;" name="Cari" onClick="do_page('<?=$href_search;?>')"><i class="fas fa-search"></i><b> Cari</b></button>
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
						<h4>Senarai Maklumat Set Penilaian</h4>
					</div>
					<div class="card-body">
                        <table width="100%" cellpadding="3" cellspacing="0" border="0">
                            <tr class="title" >
                                <td colspan="3" align="right">
        	                        <?php $new_page = "index.php?data=".base64_encode($userid.';penilaian/set_penilaian_form.php;nilai;set');?>
                                        <button class="btn btn-success" title="Sila klik untuk menyimpan maklumat peserta" value="Tambah Maklumat Set Penilaian" style="cursor:pointer" 
                                        onclick="do_page('<?=$new_page;?>')">&nbsp;&nbsp;
                                        <i class="fas fa-plus"></i> Tambah Maklumat Unit / Pusat Kursus</button> 
                                </td>
                            </tr>
                        
                        <?php include_once 'include/page_list.php'; ?>
                        <div class="table-responsive">
								<table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
									<thead>
                                    <tr>
                                        <th width="5%" align="center"><b>Bil</b></th>
                                        <th width="55%" align="center"><b>Tajuk Penilaian</b></th>
                                        <th width="10%" align="center"><b>Pusat Latihan</b></th>
                                        <th width="10%" align="center"><b>Tarikh Jana</b></th>
                                        <th width="10%" align="center"><b>Status</b></th>
                                        <th width="10%" align="center"><b>Tindakan</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!$rs->EOF) {
                                        $cnt = 1;
                                        $bil = $StartRec;
                                        while(!$rs->EOF  && $cnt <= $pg) {
                                            $bil = $cnt + ($PageNo-1)*$PageSize;
                                            $href_link = "index.php?data=".base64_encode($userid.';penilaian/set_penilaian_form.php;nilai;set;'.$rs->fields['pset_id']);
                                            ?>
                                            <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                                <td valign="top" align="right"><?=$bil;?>.</td>
                                                <td valign="top" align="left"><?php echo stripslashes($rs->fields['pset_tajuk']);?>&nbsp;</td>
                                                <td valign="top" align="center"><?php echo stripslashes($rs->fields['kampus_kod']);?>&nbsp;</td>
                                                <td valign="top" align="center"><?php echo stripslashes(DisplayDate($rs->fields['create_dt']));?>&nbsp;</td>
                                                <td valign="top" align="center">
                                                    <?php if($rs->fields['pset_status']=='0'){ print 'Aktif'; }
                                                        else if($rs->fields['pset_status']=='1'){ print 'Tidak Aktif'; } 
                                                        else { print '&nbsp;'; }
                                                    ?>
                                                </td>
                                                <td align="center">
                                                    <button class="btn btn-warning" title="Sila klik untuk pengemaskinian data" style="cursor:pointer;padding:8px;"
                                                    onclick="do_page('<?=$href_link;?>')"><i class="fas fa-edit"></i>
													</button>
                                                    <button class="btn btn-danger" title="Sila klik untuk penghapusan data" style="cursor:pointer;padding:8px;"
                                                    onclick="do_page_delete('<?=$href_link;?>&pro=DELETE')"><i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php
                                            $cnt = $cnt + 1;
                                            $bil = $bil + 1;
                                            $rs->movenext();
                                        } 
                                    } else {
                                    ?>
                                        <tr><td colspan="5" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                                        <?php } ?>                   
                                    </tbody>
                                </table>
							</div> 
                            <td colspan="5">	
                                <?php
                                if($cnt<>0){
                                    $sFileName=$href_search;
                                    include_once 'include/list_footer.php'; 
                                }
                                ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
