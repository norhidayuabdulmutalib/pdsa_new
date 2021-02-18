<?php
//$conn->debug=true;
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT A.*, B.kampus_kod FROM ref_surat A, _ref_kampus B WHERE A.kampus_id=B.kampus_id AND A.is_delete=0 ";
if(!empty($search)){ $sSQL.=" AND surat_tajuk LIKE '%".$search."%' "; } 
if(!empty($sql_kampus)){ $sSQL .= " AND B.kampus_id=".tosql($_SESSION['SESS_KAMPUS']); }
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL.=" AND B.kampus_id=".$kampus_id; }
$sSQL .= " ORDER BY surat_tajuk";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode($userid.';maintenance/surat_list.php;admin;surat');
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
                        <?php } ?>
	
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
						<h4>Senarai Maklumat Rujukan Surat</h4>
					</div>
					<div class="card-body">
                        <table width="100%" cellpadding="3" cellspacing="0" border="0">
                            <tr class="title" >
                                <td colspan="3" align="right">
                            
                            <!-- <tr valign="top" bgcolor="#80ABF2"> 
                                <td height="30" colspan="3" valign="middle">
                                    <font size="2" face="Arial, Helvetica, sans-serif">
                                    &nbsp;&nbsp;<strong>SENARAI MAKLUMAT RUJUKAN SURAT</strong></font>
                                    <div style="float:right">
                                    <?php $new_page = "modal_form.php?win=".base64_encode($href_directory.'maintenance/surat_form.php;');?>
                                    <input type="button" value="Tambah Rujukan Aras Bangunan" style="cursor:pointer" 
                                    onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Rujukan Aras Bangunan',700,400)" />&nbsp;&nbsp;</div>-->
                                </td>
                            </tr>
                        
                            <?php include_once 'include/page_list.php'; ?>
                            <div class="table-responsive">
								<table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
									<thead>
                                    <tr>
                                        <th width="5%" align="center"><b>Bil</b></th>
                                        <th width="10%" align="center"><b>Pusat Latihan</b></th>
                                        <th width="50%" align="center"><b>Tajuk</b></th>
                                        <th width="25%" align="center"><b>No. Rujukan</b></th>
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
                                                $href_link = "modal_form.php?win=".base64_encode($href_directory.'maintenance/surat_form.php;'.$rs->fields['surat_id']);
                                                ?>
                                                <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                                    <td valign="top" align="right"><?=$bil;?>.</td>
                                                    <td valign="top" align="center"><?php echo stripslashes($rs->fields['kampus_kod']);?>&nbsp;</td>
                                                    <td valign="top" align="left"><?php echo stripslashes($rs->fields['surat_tajuk']);?>&nbsp;</td>
                                                    <td valign="top" align="left"><?php echo $rs->fields['surat_ruj_fail'];?>&nbsp;</td>
                                                    <td align="center">
                                                        <button class="btn btn-warning" title="Sila klik untuk pengemaskinian data" style="cursor:pointer;padding:8px;"
                                                        onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Surat',1,1)"><i class="fas fa-edit"></i>
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
