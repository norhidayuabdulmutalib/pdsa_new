<?php
//$conn->debug=true;
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$sSQL="SELECT A.*, B.kampus_kod FROM _ref_template_sijil A, _ref_kampus B 
	WHERE A.kampus_id=B.kampus_id AND A.ref_ts_delete=0 ";
if(!empty($search)){ $sSQL.=" AND A.categorytype LIKE '%".$search."%' "; } 
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL .= " AND A.kampus_id=".$kampus_id; }
$sSQL .= " ORDER BY A.kampus_id, A.ref_ts_id";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode($userid.';kursus/ref_template_sijil.php;kursus;sijil_list');
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
                                    <select name="kampus_id" class="form-control" onchange="do_page('<?=$href_search;?>')">
                                        <option value="">-- Sila pilih kampus --</option>
                                        <?php while(!$rskks->EOF){ ?>
                                            <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus_id==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                                        <?php $rskks->movenext(); } ?>
                                    </select>
                                </div>
                            </div>
                            </div>
					</form>
				</div>
			</div>
		</div>
	</div>
    <?php } ?>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Senarai Maklumat Contoh Sijil</h4>
                    </div>
                    <div class="card-body">
                    <table width="100%" cellpadding="3" cellspacing="0" border="0">
                        <tr class="title" >
                            <td colspan="3" align="right">
                                <?php if($_SESSION["s_level"]=='99' || $_SESSION["s_level"]=='1'){ ?>
                                <?php $new_page = "modal_form.php?win=".base64_encode('kursus/ref_template_sijil_form1.php;');?>
                                    <button class="btn btn-success" title="Sila klik untuk menyimpan maklumat peserta" 
                                    onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Contoh Sijil',80,80)">&nbsp;&nbsp; 
                                    <i class="fas fa-plus"></i> Tambah Maklumat Contoh Sijil </button>
                                <?php } ?>
                            </td>
                        </tr>

                    <?php include_once 'include/page_list.php'; ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
                            <thead>
                            <tr>
                                <th width="5%" align="center"><b>Bil</b></th>
                                <th width="25%" align="center"><b>Tajuk Template</b></th>
                                <th width="50%" align="center"><b>Template</b></th>
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
                                        $href_link = "modal_form.php?win=".base64_encode('kursus/ref_template_sijil_form1.php;'.$rs->fields['ref_ts_id']);
                                        ?>
                                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                            <td valign="top" align="right"><?=$bil;?>.</td>
                                            <td valign="top" align="center"><?php echo $rs->fields['ref_tajuk_sijil'];?><br /><br />
                                                <?php print $rs->fields['kampus_kod'];?></td>
                                            <td valign="top" align="center"><?php echo stripslashes(nl2br($rs->fields['ref_ts_head1']));?><br />
                                            <?php echo stripslashes(nl2br($rs->fields['ref_ts_head2']));?><br />
                                            <?php echo stripslashes(nl2br($rs->fields['ref_ts_head3']));?>&nbsp;</td>
                                            <td valign="top" align="center">
                                                <?php if($rs->fields['ref_ts_status']=='0'){ print 'Aktif'; }
                                                    else if($rs->fields['ref_ts_status']=='1'){ print 'Tidak Aktif'; } 
                                                    else { print '&nbsp;'; }
                                                ?>
                                            </td>
                                            <td align="center">
                                                <button class="btn btn-warning" style="cursor:pointer;padding:8px;" title="Sila klik untuk pengemaskinian data" 
                                                    onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Contoh Sijil',1,1)"><i class="fas fa-edit"></i>
                                                    </button>
                                                    <?php if($cntk==0){ ?>
                                                    <!--<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                                                    onclick="do_hapus('_ref_template_sijil','<?=$rs->fields['id'];?>')" />
                                                    <?php } ?>-->
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
                    <tr><td colspan="5">	
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
</section>
