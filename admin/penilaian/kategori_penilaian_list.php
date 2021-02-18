<?php
//$conn->debug=true;
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT A.*, B.kampus_kod FROM _ref_penilaian_kategori A, _ref_kampus B WHERE A.is_deleted=0 AND A.kampus_id=B.kampus_id ";
if(!empty($search)){ $sSQL.=" AND f_penilaian LIKE '%".$search."%' "; } 
if(!empty($kampus_id)){ $sSQL.=" AND A.kampus_id=".$kampus_id; }
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".$_SESSION['SESS_KAMPUS']; }
$sSQL .= " ORDER BY A.kampus_id, A.f_penilaian";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode($userid.';penilaian/kategori_penilaian_list.php;nilai;:ref_kategori');
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

                            <?php if($_SESSION["s_level"]=='99'){
                            //$conn->debug=true;
                                $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
                                $rskks = &$conn->Execute($sqlkks);
                            ?>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat Latihan :</b></label>
                                <div class="col-sm-12 col-md-7">
                                    <select class="form-control" name="kampus_id" style="width:90%" onchange="do_page('<?=$href_search;?>')">
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
                                    <button class="btn" style="background-color:#fed136;"" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
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
						<h4>Senarai Maklumat Rujukan Kategori Penilaian</h4>
					</div>
					<div class="card-body">
                    <table width="100%" cellpadding="3" cellspacing="0" border="0">
                        <tr class="title" >
                            <td colspan="3" align="right">
                                <?php $new_page = "modal_form.php?win=".base64_encode('penilaian/kategori_penilaian.php;');?>
                                    <button class="btn btn-success" value="Tambah Maklumat Rujukan Kategori Penilaian" style="cursor:pointer" 
                                    onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Rujukan Kategori Penilaian',700,300)">&nbsp;&nbsp;
                                    <i class="fas fa-plus"></i> Tambah Maklumat Rujukan Kategori Penilaian </button>
                            </td>
                        </tr>
                   
                    <?php include_once 'include/page_list.php'; ?>
                    <div class="table-responsive">
								<table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
									<thead>
                                    <tr>
                                        <th width="5%" align="center"><b>Bil</b></th>
                                        <th width="65%" align="center"><b>Maklumat Rujukan Penilaian</b></th>
                                        <th width="10%" align="center"><b>Pusat Latihan</b></th>
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
                                                $href_link = "modal_form.php?win=".base64_encode('penilaian/kategori_penilaian.php;'.$rs->fields['f_penilaianid']);
                                                $cntk = dlookup("_ref_penilaian_maklumat","count(*)","f_penilaianid=".tosql($rs->fields['f_penilaianid'],"Number"));
                                                ?>
                                                <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                                    <td valign="top" align="right"><?=$bil;?>.</td>
                                                    <td valign="top" align="left"><?php echo stripslashes($rs->fields['f_penilaian']);?>&nbsp;</td>
                                                    <td valign="top" align="center"><?php echo stripslashes($rs->fields['kampus_kod']);?>&nbsp;</td>
                                                    <td valign="top" align="center">
                                                        <?php if($rs->fields['f_penilaian_status']=='0'){ print 'Aktif'; }
                                                            else if($rs->fields['f_penilaian_status']=='1'){ print 'Tidak Aktif'; } 
                                                            else { print '&nbsp;'; }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <button class="btn btn-warning" title="Sila klik untuk pengemaskinian data" style="cursor:pointer;padding:8px;"
                                                            onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Rujukan Kategori Penilaian',700,300)"><i class="fas fa-edit"></i>
													    </button>
                                                        <?php if($cntk==0){ ?>
                                                            <button class="btn btn-danger" title="Sila klik untuk penghapusan data" style="cursor:pointer;padding:8px;"
                                                            onclick="do_hapus('_ref_penilaian_kategori','<?=$rs->fields['f_penilaianid'];?>')"><i class="fas fa-trash"></i>
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
