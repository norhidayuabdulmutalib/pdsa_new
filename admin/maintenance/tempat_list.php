<?php
//$conn->debug=true;
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 ";
if(!empty($kategori)){ $sSQL.=" AND ref_ktid =".tosql($kategori); } 
if(!empty($search)){ $sSQL.=" AND f_tempat_nama LIKE '%".$search."%' OR f_tbcode LIKE '%".$search."%' "; } 
$sSQL .= "ORDER BY f_tbcode";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode($userid.';maintenance/tempat_list.php;admin;tempat');
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

                            <?php $sqlkk = "SELECT * FROM _ref_tempat_kategori WHERE ref_kt_status=0 ORDER BY ref_ktid";
                                $rskk = &$conn->Execute($sqlkk);
                            ?>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori Agensi :</b></label>
                                <div class="col-sm-12 col-md-7">
                                    <select class="form-control" name="kategori" onchange="do_page('<?=$href_search;?>')">
                                        <option value="">-- Sila pilih kategori --</option>
                                        <?php while(!$rskk->EOF){ ?>
                                        <option value="<?php print $rskk->fields['ref_ktid'];?>" <?php if($kategori==$rskk->fields['ref_ktid']){ print 'selected'; }?>><?php print $rskk->fields['ref_kt_nama'];?></option>
                                        <?php $rskk->movenext(); } ?>
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
						<h4>Senarai Maklumat Tempat Bertugas</h4>
					</div>
					<div class="card-body">
                        <table width="100%" cellpadding="3" cellspacing="0" border="0">
                            <tr class="title" >
                                <td colspan="3" align="right">
                                <?php $new_page = "modal_form.php?win=".base64_encode('maintenance/tempat_form.php;');?>
                                    <button class="btn btn-success" value="Tambah Maklumat Tempat Bertugas" 
                                    onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Tempat Bertugas',700,400)">
                                    <i class="fas fa-plus"></i> Tambah Maklumat Tempat Bertugas</button> 
                                </td>
                            </tr>
                        
                        <?php include_once 'include/page_list.php'; ?>
                        <div class="table-responsive">
								<table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
									<thead>
                                    <tr>
                                        <th width="5%" align="center"><b>Bil</b></th>
                                        <th width="10%" align="center"><b>Kod Tempat</b></th>
                                        <th width="40%" align="center"><b>Tempat Bertugas</b></th>
                                        <th width="25%" align="center"><b>Kategori Agensi</b></th>
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
                                            $href_link = "modal_form.php?win=".base64_encode('maintenance/tempat_form.php;'.$rs->fields['f_tbcode']);
                                            $cntk = dlookup("_tbl_peserta","count(*)","BranchCd=".tosql($rs->fields['f_tbcode'],"Number"));
                                            ?>
                                            <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                                <td valign="top" align="right"><?=$bil;?>.</td>
                                                <td valign="top" align="center"><?php echo stripslashes($rs->fields['f_tbcode']);?>&nbsp;</td>
                                                <td valign="top" align="left"><?php echo stripslashes($rs->fields['f_tempat_nama']);?>&nbsp;</td>
                                                <td valign="top" align="left"><?php echo stripslashes(dlookup("_ref_tempat_kategori","ref_kt_nama","ref_ktid=".tosql($rs->fields['ref_ktid'])));?>&nbsp;</td>
                                                <td valign="top" align="center">
                                                    <?php if($rs->fields['f_status']=='0'){ print 'Aktif'; }
                                                        else if($rs->fields['f_status']=='1'){ print 'Tidak Aktif'; } 
                                                        else { print '&nbsp;'; }
                                                    ?>
                                                </td>
                                                <td align="center">
                                                    <button class="btn btn-warning" title="Sila klik untuk pengemaskinian data" style="cursor:pointer;padding:8px;" 
                                                    onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Tempat Bertugas',700,400)"><i class="fas fa-edit"></i>
													</button>
                                                    <?php if($cntk==0){ ?>
                                                    <button class="btn btn-danger" title="Sila klik untuk penghapusan data" style="cursor:pointer;padding:8px;"
                                                    onclick="do_hapus('_ref_tempatbertugas','<?=$rs->fields['f_tbcode'];?>')"><i class="fas fa-trash"></i>
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
