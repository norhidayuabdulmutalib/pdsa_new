<?php
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT * FROM _ref_kategori_blok WHERE is_deleted=0 ";
if(!empty($search)){ $sSQL.=" AND f_kb_desc LIKE '%".$search."%' "; } 
$sSQL .= "ORDER BY f_kb_desc";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

if(!empty($href_directory)){
	$href_search = "index.php?data=".base64_encode($userid.';asrama/menu_asrama.php;asrama;kblok;;../maintenance/kblok_list.php');
} else {
	$href_search = "index.php?data=".base64_encode($userid.';maintenance/kblok_list.php;admin;kblok');
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
						<h4>Senarai Maklumat Rujukan Kategori Blok Bangunan</h4>
					</div>
					<div class="card-body">
                        <table width="100%" cellpadding="3" cellspacing="0" border="0">
                            <tr class="title" >
                                <td colspan="3" align="right">
                                <?php $new_page = "modal_form.php?win=".base64_encode($href_directory.'maintenance/kblok_form.php;');?>
                                    <button class="btn btn-success" title="Sila klik untuk menyimpan maklumat peserta" 
                                    onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Rujukan Kategori Blok Bangunan',700,400)" />&nbsp;&nbsp;
                                    <i class="fas fa-plus"></i> Tambah Rujukan Kategori Blok Bangunan</button> 
                                </td>
                            </tr>

                            <?php include_once 'include/page_list.php'; ?>
                            <div class="table-responsive">
								<table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
									<thead>
                                    <tr>
                                        <th width="5%" align="center"><b>Bil</b></th>
                                        <th width="75%" align="center"><b>Maklumat Kategori Blok Bangunan</b></th>
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
                                            $href_link = "modal_form.php?win=".base64_encode($href_directory.'maintenance/kblok_form.php;'.$rs->fields['f_kb_id']);
                                            $cntk = dlookup("_ref_blok_bangunan","count(*)","f_kb_id=".tosql($rs->fields['f_kb_id'],"Number"));
                                            ?>
                                            <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                                <td valign="top" align="right"><?=$bil;?>.</td>
                                                <td valign="top" align="left"><?php echo stripslashes($rs->fields['f_kb_desc']);?>&nbsp;<?//=$cntk;?></td>
                                                <td valign="top" align="center">
                                                    <?php if($rs->fields['f_kb_status']=='0'){ print 'Aktif'; }
                                                        else if($rs->fields['f_kb_status']=='1'){ print 'Tidak Aktif'; } 
                                                        else { print '&nbsp;'; }
                                                    ?>
                                                </td>
                                                <td align="center">
                                                    <button class="btn btn-warning" title="Sila klik untuk pengemaskinian data" style="cursor:pointer;padding:8px;"
                                                    onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Rujukan Kategori Blok',700,400)"><i class="fas fa-edit"></i>
													</button>
                                                    <?php if($cntk==0){ ?>
                                                    <button class="btn btn-danger" title="Sila klik untuk penghapusan data" style="cursor:pointer;padding:8px;"
                                                    onclick="do_hapus('_ref_kategori_blok','<?=$rs->fields['f_kb_id'];?>','<?=$href_directory;?>')"><i class="fas fa-trash"></i>
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
