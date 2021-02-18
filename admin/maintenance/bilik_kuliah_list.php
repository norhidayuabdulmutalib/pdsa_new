<?php
//$conn->debug=true;
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$blok_id=isset($_REQUEST["blok_id"])?$_REQUEST["blok_id"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT A.*, B.f_bb_desc, C.f_ab_desc FROM _tbl_bilikkuliah A, _ref_blok_bangunan B, _ref_aras_bangunan C 
WHERE A.f_bb_id=B.f_bb_id AND A.f_ab_id=C.f_ab_id AND A.is_deleted=0 ";
$sSQL .= $sql_filter;
if(!empty($blok_id)){ $sSQL .= " AND B.f_bb_id=".tosql($blok_id); }
if($_SESSION['SESS_KAMPUS']<>'99'){ $sSQL .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($search)){ $sSQL.=" AND (A.f_bilik_nama LIKE '%".$search."%' OR B.f_bb_desc LIKE '%".$search."%' OR C.f_ab_desc LIKE '%".$search."%' )"; } 
$sSQL .= " ORDER BY B.f_bb_desc, C.f_ab_desc, A.f_bilik_nama";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

if(!empty($href_directory)){
	$href_search = "index.php?data=".base64_encode($userid.';apps/asrama/menu_asrama.php;asrama;bkuliah;;../maintenance/bilik_kuliah_list.php');
} else {
	$href_search = "index.php?data=".base64_encode($userid.';maintenance/bilik_kuliah_list.php;admin;bkuliah');
} 
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}

function do_hapus(jenis,idh,dir){
	var URL = dir+'include/proses_hapus.php?jenis='+jenis+'&idh='+idh;
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

                            <?php $sqlb = "SELECT A.*, B.kampus_kod FROM _ref_blok_bangunan A, _ref_kampus B 
                                WHERE A.kampus_id=B.kampus_id AND A.is_deleted=0 AND A.f_bb_status=0";
                            if($_SESSION["s_level"]<>'99'){ $sqlb .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
                            $sqlb .= $sql_filter;
                            $sqlb .= " ORDER BY B.kampus_id";
                            $rs_kb = &$conn->Execute($sqlb);
                            ?>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Blok Bangunan :</b></label>
                                <div class="col-sm-12 col-md-7">
                                    <select class="form-control" name="blok_id" onchange="do_page('<?=$href_search;?>')">
                                        <option value="">-- Semua blok bangunan --</option>
                                    <?php while(!$rs_kb->EOF){ ?>
                                        <option value="<?php print $rs_kb->fields['f_bb_id'];?>" <?php if($rs_kb->fields['f_bb_id']==$blok_id){ print 'selected="selected"';}?>><?php print $rs_kb->fields['kampus_kod']." - ".$rs_kb->fields['f_bb_desc'];?></option>
                                    <?php $rs_kb->movenext(); } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Maklumat Carian : </b></label>
								<div class="col-sm-12 col-md-7">
                                    <input class="form-control" type="text" name="search" value="<?php echo stripslashes($search);?>">
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <button class="btn" style="background-color:#fed136;" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')"><i class="fas fa-search"></i><b> Cari</b></button>
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
						<h4>Senarai Maklumat Bilik Kuliah</h4>
					</div>
					<div class="card-body">
                        <table width="100%" cellpadding="3" cellspacing="0" border="0">
                            <tr class="title" >
                                <td colspan="3" align="right">
                                <?php $new_page = "modal_form.php?win=".base64_encode($href_directory.'maintenance/bilik_kuliah_form.php;');?>
                                    <button class="btn btn-success" value="Tambah Maklumat Bilik Kuliah"
                                    onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Bilik Kuliah',700,400)">&nbsp;&nbsp;
                                    <i class="fas fa-plus"></i> Tambah Maklumat Bilik Kuliah</button>
                                </td>
                            </tr>
                        
	                    <?php include_once 'include/page_list.php'; ?>
                        <div class="table-responsive">
								<table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
									<thead>
                                    <tr>
                                        <th width="5%" align="center"><b>Bil</b></th>
                                        <th width="35%" align="center"><b>Maklumat Bilik Kuliah</b></th>
                                        <th width="20%" align="center"><b>Blok</b></th>
                                        <th width="15%" align="center"><b>Aras</b></th>
                                        <th width="15%" align="center"><b>Status</b></th>
                                        <th width="10%" align="center"><b>Tindakan</b></th>
                                    </tr>
                                        <?php
                                        if(!$rs->EOF) {
                                            $cnt = 1;
                                            $bil = $StartRec;
                                            while(!$rs->EOF  && $cnt <= $pg) {
                                                $bil = $cnt + ($PageNo-1)*$PageSize;
                                                $href_link = "modal_form.php?win=".base64_encode($href_directory.'maintenance/bilik_kuliah_form.php;'.$rs->fields['f_bilikid']);
                                                $cntk = dlookup("_tbl_kursus_jadual","count(*)","bilik_kuliah=".tosql($rs->fields['f_bilikid'],"Number"));
                                                ?>
                                                <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                                    <td valign="top" align="right"><?=$bil;?>.</td>
                                                    <td valign="top" align="left"><?php echo stripslashes($rs->fields['f_bilik_nama']);?>&nbsp;</td>
                                                    <td valign="top" align="center"><?php echo $rs->fields['f_bb_desc'];?>&nbsp;</td>
                                                    <td valign="top" align="center"><?php echo $rs->fields['f_ab_desc'];?>&nbsp;</td>
                                                    <td valign="top" align="center">
                                                        <?php if($rs->fields['f_status']=='0'){ print 'Boleh Digunakan'; }
                                                            else if($rs->fields['f_status']=='1'){ print 'Dalam penyelengaraan'; } 
                                                            else { print '&nbsp;'; }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <button class="btn btn-warning" title="Sila klik untuk pengemaskinian data" style="cursor:pointer;padding:8px;" 
                                                        onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Bilik Kuliah',700,400)"><i class="fas fa-edit"></i>
														</button>
                                                        <?php if($cntk==0){ ?>
                                                        <button class="btn btn-danger" title="Sila klik untuk penghapusan data" style="cursor:pointer;padding:8px;"
                                                        onclick="do_hapus('_tbl_bilikkuliah','<?=$rs->fields['f_bilikid'];?>','<?=$href_directory;?>')"><i class="fas fa-trash"></i>
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
