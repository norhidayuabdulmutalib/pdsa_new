<?php
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$bidang_id=isset($_REQUEST["bidang_id"])?$_REQUEST["bidang_id"]:"";
//$conn->debug=true;
$sSQL="SELECT * FROM _tbl_kursus WHERE is_deleted=0 ";
if(!empty($search)){ $sSQL.=" AND (coursename LIKE '%".$search."%' OR courseid  LIKE '%".$search."%') "; } 
if(!empty($kategori)){ $sSQL.=" AND category_code=".tosql($kategori,"Text"); } 
if(!empty($subkategori)){ $sSQL.=" AND subcategory_code=".tosql($subkategori,"Text"); } 
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL.=" AND kampus_id=".$kampus_id; }
if(!empty($bidang_id)){ $sSQL.=" AND bidang_id=".tosql($bidang_id); }
$sSQL .= " ORDER BY courseid, coursename";
$rs = &$conn->query($sSQL);
$cnt = $rs->recordcount();
//print $sSQL;
$href_search = "index.php?data=".base64_encode($userid.';kursus/kursus_list.php;kursus;kursus');
?>
<script language="JavaScript1.2" type="text/javascript">
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
                            <?php if($_SESSION["s_level"]=='99'){
                            //$conn->debug=true;
                                $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
                                $rskks = &$conn->Execute($sqlkks);
                            ?>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat Latihan :</b></label>
                                <div class="col-sm-12 col-md-7">
                                    <select name="kampus_id" class="form-control" onchange="do_page('<?=$href_search;?>')">
                                        <option value="">-- Sila pilih kampus --</option>
                                        <?php while(!$rskks->EOF){ ?>
                                            <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus_id==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                                        <?php $rskks->movenext(); } ?>
                                    </select>
                                </div>
                            </div> 
                            <?php } ?>
                            
                            <!--<?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
                                $rskk = &$conn->Execute($sqlkk);
                            ?>
                            <tr>
                                <td width="30%" align="right"><b>Kategori Kursus : </b></td> 
                                <td width="60%" align="left">&nbsp;
                                    <select name="kategori"  onchange="do_page('<?=$href_search;?>')">
                                        <option value="">-- Sila pilih kategori --</option>
                                        <?php while(!$rskk->EOF){ ?>
                                        <option value="<?php print $rskk->fields['id'];?>" <?php if($kategori==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                                        <?php $rskk->movenext(); } ?>
                                    </select>
                                </td>
                            </tr>-->
 
                            <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Bidang : </b></label>
								<div class="col-sm-12 col-md-7">
                                <select name="bidang_id"class="form-control" onchange="do_page('<?=$href_search;?>')">
                                    <option value="">-- Sila pilih bidang --</option>
                                        <?php 
                                        $r_gred = &$conn->execute("SELECT * FROM _ref_kepakaran ORDER BY f_pakar_nama");
                                        while (!$r_gred->EOF){ ?>
                                            <option value="<?=$r_gred->fields['f_pakar_code'] ?>" 
                                        <?php if($bidang_id==$r_gred->fields['f_pakar_code']){ print "selected"; }?>><?=$r_gred->fields['f_pakar_nama']?></option>
                                        <?php $r_gred->movenext(); }?>        
                                </select>
                                </div>
                            </div>

                            <?php 
                                $sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 AND f_status=0 ";
                                if($_SESSION["s_level"]<>'99'){ $sqlkks .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
                                if(!empty($kampus_id)){ $sqlkks.=" AND kampus_id=".$kampus_id; }
                                $sqlkks .=" ORDER BY SubCategoryNm";
                                $rskks = &$conn->Execute($sqlkks);
                            ?>
                            <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat Unit : </b></label>
								<div class="col-sm-12 col-md-7">
                                <select name="subkategori" class="form-control" onchange="do_page('<?=$href_search;?>')">
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
                                    <button class="btn" style="background-color:#fed136;" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
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
                        <tr class="title" >
                            <td colspan="3" align="right">
                                <?php $new_page = "modal_form.php?win=".base64_encode('kursus/kursus_form.php;');?>
                                <button class="btn btn-success" title="Sila klik untuk tambah maklumat kursus" 
                                onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Kursus',1,1)">&nbsp;&nbsp;
                                <i class="fas fa-plus"></i> Tambah Maklumat Kursus</button> 
                            </td>
                        </tr>
                   

                    <!-- <tr valign="top" bgcolor="#80ABF2"> 
                        <td height="30" colspan="0" valign="middle">
                        <font size="2" face="Arial, Helvetica, sans-serif">
                            &nbsp;&nbsp;<strong>SENARAI MAKLUMAT KURSUS</strong></font>
                        </td>
                        <td colspan="2" valign="middle" align="right"> -->
        	
                    <?php include_once 'include/page_list.php'; ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="" name="">
                                <thead>
                                <tr>
                                    <th width="5%" align="center"><b>Bil</b></th>
                                    <th width="10%" align="center"><b>Kod Kursus</b></th>
                                    <th width="40%" align="center"><b>Diskripsi Kursus</b></th>
                                    <th width="15%" align="center"><b>Kategori Kursus</b></th>
                                    <th width="15%" align="center"><b>Bidang</b></th>
                                    <th width="5%" align="center"><b>Pusat / Unit</b></th>
                                    <th width="10%" align="center"><b>Status</b></th>
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
                                        $href_link = "modal_form.php?win=".base64_encode('kursus/kursus_form.php;'.$rs->fields['id']);
                                        $cntk = dlookup("_tbl_kursus_jadual","count(*)","courseid=".tosql($rs->fields['id'],"Text"));
                                        $unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['subcategory_code'],"Text"));
                                        $bidang = dlookup("_ref_kepakaran","f_pakar_nama","f_pakar_code=".tosql($rs->fields['bidang_id']));
                                        ?>
                                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                            <td valign="top" align="right"><?=$bil;?>.</td>
                                            <td valign="top" align="left"><?php echo stripslashes($rs->fields['courseid']);?>&nbsp;</td>
                                            <td valign="top" align="left"><?php echo stripslashes($rs->fields['coursename']);?>&nbsp;</td>
                                            <td valign="top" align="center"><?php echo dlookup("_tbl_kursus_cat","categorytype","id=".tosql($rs->fields['category_code'],"Number"));?>&nbsp;</td>
                                            <td valign="top" align="center"><?php echo $bidang;?>&nbsp;</td>
                                            <td valign="top" align="center"><?php echo stripslashes($unit);?>&nbsp;</td>
                                            <td valign="top" align="center">
                                                <?php 
                                                    if($rs->fields['status']=='0'){ print 'Aktif'; }
                                                    else if($rs->fields['status']=='1'){ print 'Tidak Aktif'; } 
                                                    else { print '&nbsp;'; }
                                                ?>
                                            </td>
                                            <td align="center">
                                                <?php if($_SESSION["s_jabatan"]==$rs->fields['subcategory_code'] || 
                                                $_SESSION["s_level"]==1 || $_SESSION["s_level"]==99){ ?>
                                                    <button class="btn btn-warning" title="Sila klik untuk pengemaskinian data" style="cursor:pointer;padding:8px;"  
                                                    onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Kursus',1,1)"><i class="fas fa-edit"></i>
                                                    </button>
                                                <?php } ?>
                                                <?php if($cntk==0){ ?>
                                                    <button class="btn btn-danger" title="Sila klik untuk penghapusan data" style="cursor:pointer;padding:8px;"
                                                    onclick="do_hapus('tbl_kursus','<?=$rs->fields['id'];?>')"><i class="fas fa-trash"></i>
                                                    </button>
                                                <?php } else { ?>
                                                    <!--<img src="../img/ico-cancel_x.gif" width="30" height="30" style="cursor:pointer" title="Data tidak boleh dihapuskan" />-->
                                                <?php } ?>
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
