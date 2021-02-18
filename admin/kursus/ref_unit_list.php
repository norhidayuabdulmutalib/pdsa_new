<?php
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
//print "K:".$_SESSION["s_level"];

$sSQL="SELECT A.*, B.categorytype, C.kampus_kod FROM _tbl_kursus_catsub A, _tbl_kursus_cat B, _ref_kampus C 
WHERE A.f_category_code=B.id AND A.kampus_id=C.kampus_id AND A.is_deleted=0 ";
$sSQL .= $sql_filter;
if(!empty($search)){ $sSQL.=" AND (A.SubCategoryNm LIKE '%".$search."%' OR A.SubCategoryDesc LIKE '%".$search."%') "; } 
if(!empty($kategori)){ $sSQL.=" AND A.f_category_code =".tosql($kategori); } 
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".tosql($_SESSION['SESS_KAMPUS']); }
if(!empty($kampus_id)){ $sSQL.=" AND A.kampus_id=".tosql($kampus_id); }
$sSQL .= " ORDER BY A.kampus_id, f_category_code";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode($userid.';kursus/ref_unit_list.php;kursus;unit');
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
                                $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0";
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
                            <?php } ?>

                            <?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ";
                                if($_SESSION["s_level"]<>'99'){ $sqlkk .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
                                if(!empty($kampus_id)){ $sqlkk.=" AND kampus_id=".$kampus_id; }
                                $sqlkk .= " ORDER BY category_code";
                                $rskk = &$conn->Execute($sqlkk);
                            ?>
                            <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori Kursus : </b></label>
								<div class="col-sm-12 col-md-7">
                                <select class="form-control" name="kategori" onchange="do_page('<?=$href_search;?>')">
                                    <option value="">-- Sila pilih kategori --</option>
                                        <?php while(!$rskk->EOF){ ?>
                                            <option value="<?php print $rskk->fields['id'];?>" <?php if($kategori==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                                        <?php $rskk->movenext(); } ?>
                                </select>
                                </div>
                            </div>
                            
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

    <!-- <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT PUSAT / UNIT KURSUS</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<?php //$new_page = "modal_form.php?win=".base64_encode('kursus/ref_unit_form.php;');?>
        	<input type="button" value="Tambah Maklumat Unit / Pusat Kursus" style="cursor:pointer" 
            onclick="open_modal('<?//=$new_page;?>','Penambahan Maklumat Unit / Pusat Kursus',700,400)" />&nbsp;&nbsp;
        </td> 
    </tr>
    <tr>-->


    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
					<div class="card-header">
						<h4>Senarai Maklumat Pusat / Unit Kursus</h4>
					</div>
					<div class="card-body">
                        <table width="100%" cellpadding="3" cellspacing="0" border="0">
                            <tr class="title" >
                                <td colspan="3" align="right">
                                    <?php $new_page = "modal_form.php?win=".base64_encode('kursus/ref_unit_form.php;');?>
                                        <button class="btn btn-success" title="Sila klik untuk menyimpan maklumat peserta" 
                                        onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Unit / Pusat Kursus',700,400)">&nbsp;&nbsp; 
                                        <i class="fas fa-plus"></i> Tambah Maklumat Unit / Pusat Kursus</button> 
                                </td>
                            </tr>
                       
                        <?php include_once 'include/page_list.php'; ?>
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
                                    <tr>
                                        <th width="5%" align="center"><b>Bil</b></th>
                                        <th width="15%" align="center"><b>Kategori Kursus</b></th>
                                        <th width="15%" align="center"><b>Kod Pusat / Unit Kursus</b></th>
                                        <th width="30%" align="center"><b>Diskripsi Pusat / Unit Kursus</b></th>
                                        <th width="10%" align="center"><b>Pusat</b></th>
                                        <th width="10%" align="center"><b>Status</b></th>
                                        <th width="15%" align="center"><b>Tindakan</b></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(!$rs->EOF) {
                                        $cnt = 1;
                                        $bil = $StartRec;
                                        while(!$rs->EOF  && $cnt <= $pg) {
                                            $bil = $cnt + ($PageNo-1)*$PageSize;
                                            $href_link = "modal_form.php?win=".base64_encode('kursus/ref_unit_form.php;'.$rs->fields['id']);
                                            //$conn->debug=true;
                                            $cntk = dlookup("_tbl_kursus_jadual","count(*)","sub_category_code=".tosql($rs->fields['id'],"Number"));
                                            $conn->debug=false;
                                            ?>
                                            <tr bgcolor="#FFFFFF">
                                                <td valign="top" align="right"><?=$bil;?></td>
                                                <td valign="top" align="left"><?php echo stripslashes($rs->fields['categorytype']);?>&nbsp;</td>
                                                <td valign="top" align="left"><?php echo stripslashes($rs->fields['SubCategoryNm']);?>&nbsp;</td>
                                                <td valign="top" align="left"><?php echo stripslashes($rs->fields['SubCategoryDesc']);?>&nbsp;</td>
                                                <td valign="top" align="center"><?php print $rs->fields['kampus_kod'];?>&nbsp;</td>
                                                <td valign="top" align="center">
                                                    <?php if($rs->fields['f_status']=='0'){ print 'Aktif'; }
                                                        else if($rs->fields['f_status']=='1'){ print 'Tidak Aktif'; } 
                                                        else { print '&nbsp;'; }
                                                    ?>
                                                </td>
                                                <td align="center">
                                                    <button class="btn btn-warning" title="Sila klik untuk pengemaskinian data" style="cursor:pointer;padding:8px;" 
                                                    onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Kategori Kursus',700,400)"><i class="fas fa-edit"></i>
                                                    </button>
                                                    <?php if($cntk==0){ ?>
                                                    <button class="btn btn-danger" title="Sila klik untuk hapus data" style="cursor:pointer;padding:8px;"
                                                    onclick="do_hapus('tbl_kursus_catsub','<?=$rs->fields['id'];?>')"><i class="fas fa-trash"></i>
                                                    </button>
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



