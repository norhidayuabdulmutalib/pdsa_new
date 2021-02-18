<?php
//$conn->debug=true;
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
/*$sSQL="SELECT A.*, B.f_penilaian FROM _ref_penilaian_maklumat A, _ref_penilaian_kategori B WHERE A.f_penilaianid=B.f_penilaianid AND A.is_deleted=0 ";
if(!empty($kategori)){ $sSQL.=" AND A.f_penilaianid =".tosql($kategori,"Number"); } 
if(!empty($search)){ $sSQL.=" AND A.f_penilaian_desc LIKE '%".$search."%' "; } 
$sSQL .= " ORDER BY A.f_penilaianid, A.f_penilaian_desc";*/

$sSQL="SELECT * FROM _ref_penilaian_maklumat A 
WHERE A.is_deleted=0 ";
if(!empty($kategori)){ $sSQL.=" AND A.f_penilaianid =".tosql($kategori,"Text"); } 
if(!empty($search)){ $sSQL.=" AND A.f_penilaian_desc LIKE '%".$search."%' "; } 
if(!empty($kampus_id)){ $sSQL.=" AND A.kampus_id=".$kampus_id; }
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".$_SESSION['SESS_KAMPUS']; }
$sSQL .= " ORDER BY A.f_penilaianid, A.f_penilaian_desc";

$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode($userid.';penilaian/penilaian_list.php;nilai;penilaian');
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
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Hapus Maklumat Penilaian', 'width=200px,height=200px,center=1,resize=1,scrolling=0')
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
                                    <select class ="form-control" name="kampus_id" onchange="do_page('<?=$href_search;?>')">
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
                            
                            <?php $sqlb = "SELECT * FROM _ref_penilaian_kategori WHERE is_deleted=0";
                                if($_SESSION["s_level"]<>'99'){ $sqlb .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
                            $rs_kb = &$conn->Execute($sqlb);
                            ?>
                            <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori Penilaian : </b></label>
								<div class="col-sm-12 col-md-7">
                                    <select class ="form-control" name="kategori">
                                        <option value="">-- Sila pilih --</option>
                                    <?php while(!$rs_kb->EOF){ ?>
                                        <option value="<?php print $rs_kb->fields['f_penilaianid'];?>" <?php if($rs_kb->fields['f_penilaianid']==$kategori){ print 'selected="selected"';}?>><?php print $rs_kb->fields['f_penilaian'];?></option>
                                    <?php $rs_kb->movenext(); } ?>
                                        <option value="A" <?php if($rs->fields['f_penilaianid']=='A'){ print 'selected'; }?>>Keseluruhan Kursus</option>
                                        <option value="B" <?php if($rs->fields['f_penilaianid']=='B'){ print 'selected'; }?>>Cadangan Penambahbaikan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Maklumat Carian : </b></label>
								<div class="col-sm-12 col-md-7">
			                        <input class ="form-control"  type="text"  name="search" value="<?php echo stripslashes($search);?>">
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <button class="btn" style="background-color:#fed136;" name="Cari" onClick="do_page('<?=$href_search;?>')">
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
						<h4>Senarai Maklumat Rujukan Penilaian</h4>
					</div>
					<div class="card-body">
                        <table width="100%" cellpadding="3" cellspacing="0" border="0">
                            <tr class="title" >
                                <td colspan="3" align="right">
                                <?php $new_page = "modal_form.php?win=".base64_encode('penilaian/penilaian_form.php;');?>
                                    <button class="btn btn-success" value="Tambah Maklumat Rujukan Penilaian" style="cursor:pointer" 
                                    onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Rujukan Penilaian',80,80)">&nbsp;&nbsp;
                                    <i class="fas fa-plus"></i> Tambah Maklumat Rujukan Penilaian</button>
                                </td>
                            </tr>
                       
                        <?php include_once 'include/page_list.php'; ?>
                        <div class="table-responsive">
								<table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
									<thead>
                                    <tr>
                                        <th width="5%" align="center"><b>Bil</b></th>
                                        <th width="45%" align="center"><b>Maklumat Penilaian</b></th>
                                        <th width="20%" align="center"><b>Kategori Penilaian</b></th>
                                        <th width="15%" align="center"><b>Set Penilaian</b></th>
                                        <th width="6%" align="center"><b>Status</b></th>
                                        <th width="14%" align="center"><b>Tindakan</b></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(!$rs->EOF) {
                                        $cnt = 1;
                                        $bil = $StartRec;
                                        while(!$rs->EOF  && $cnt <= $pg) {
                                            $bil = $cnt + ($PageNo-1)*$PageSize;
                                            $href_link = "modal_form.php?win=".base64_encode('penilaian/penilaian_form.php;'.$rs->fields['f_penilaian_detailid']);
                                            $kat_penilaian = dlookup("_ref_penilaian_kategori","f_penilaian","f_penilaianid=".tosql($rs->fields['f_penilaianid']));
                                            $cntk = dlookup("_tbl_nilai_bahagian_detail","count(*)","f_penilaian_detailid=".tosql($rs->fields['f_penilaianid'],"Number"));
                                            $kampus='';
                                            if($_SESSION["s_level"]=='99'){
                                                $kampus = "<br>".dlookup("_ref_kampus","kampus_kod","kampus_id=".tosql($rs->fields['kampus_id'])); 
                                            }
                                            if($rs->fields['f_penilaianid']=='A'){ $kat_penilaian='Keseluruhan Kursus'; }
                                            else if($rs->fields['f_penilaianid']=='B'){ $kat_penilaian='Cadangan Penambahbaikan'; }
                                            
                                            ?>
                                            <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                                <td align="right"><?=$bil;?>.</td>
                                                <td valign="top" align="left"><?php echo stripslashes($rs->fields['f_penilaian_desc']);?></td>
                                                <td valign="top" align="center"><?php echo $kat_penilaian;?><?=$kampus;?>&nbsp;</td>
                                                <td valign="top" align="center">
                                                    <?php if($rs->fields['f_penilaian_jawab']=='1'){ print 'Set 5 Pilihan'; }
                                                        else if($rs->fields['f_penilaian_jawab']=='2'){ print 'Set Ya / Tidak'; } 
                                                        else if($rs->fields['f_penilaian_jawab']=='3'){ print 'Set Jawapan Bertulis '; } 
                                                        else { print '&nbsp;'; }
                                                    ?>
                                                </td>
                                                <td valign="top" align="center">
                                                    <?php if($rs->fields['f_penilaian_status']=='0'){ print 'Aktif'; }
                                                        else if($rs->fields['f_penilaian_status']=='1'){ print 'Tidak Aktif'; } 
                                                        else { print '&nbsp;'; }
                                                    ?>
                                                </td>
                                                <td align="center">
                                                    <button class="btn btn-warning" title="Sila klik untuk pengemaskinian data" style="cursor:pointer;padding:8px;" 
                                                        onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Rujukan Penilaian',80,80)">
                                                        <i class="fas fa-edit"></i>
													</button>
                                                    <?php if($cntk==0){ ?>
                                                        <button class="btn btn-danger" title="Sila klik untuk penghapusan data" style="cursor:pointer;padding:8px;"
                                                        onclick="do_hapus('_ref_penilaian_maklumat','<?=$rs->fields['f_penilaian_detailid'];?>')"><i class="fas fa-trash"></i>
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
                                    <td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                                    <?php } ?>                   
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
