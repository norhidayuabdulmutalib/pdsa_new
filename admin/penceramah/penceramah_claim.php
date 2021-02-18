<?php
$j=$_POST['j'];
$search=$_POST['search'];
$bidang=$_POST['bidang'];
$subjek=$_POST['subjek'];
//print "BIDANG:".$_POST['bidang'];
//$subjek=isset($_REQUEST["subjek"])?$_REQUEST["subjek"]:"";
$inskategori=isset($_REQUEST["inskategori"])?$_REQUEST["inskategori"]:"";

//$conn->debug=true;
$sSQL="SELECT A.*, D.cl_id, D.cl_month, D.cl_year, D.is_process FROM _tbl_instructor A, _tbl_claim D ";
if(!empty($subjek)){ $sSQL .= ", _tbl_kursus_jadual_det B, _tbl_kursus_jadual C"; }
if(!empty($bidang)){ $sSQL .= ", _tbl_instructor_kepakaran E"; }
$sSQL .= " WHERE A.is_deleted=0 AND A.instypecd ='01' AND A.ingenid=D.cl_ins_id AND D.is_process!=2 AND D.is_deleted=0 ";
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND D.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($subjek)){ $sSQL .= " AND A.ingenid=B.instruct_id AND B.event_id=C.id AND C.courseid=".tosql($subjek); }
if(!empty($bidang)){ $sSQL .= " AND A.ingenid=E.ingenid AND E.inpakar_bidang=".tosql($bidang); }
if(!empty($inskategori)){ $sSQL .= " AND A.inskategori=".tosql($inskategori); }
if(!empty($search)){ $sSQL.=" AND (A.insname LIKE '%".$search."%' OR A.insid LIKE '%".$search."%') "; }
$sSQL .= " ORDER BY A.insname, D.cl_year, D.cl_month";
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;
//print $sSQL;

$href_search = "index.php?data=".base64_encode($userid.';penceramah/penceramah_claim.php;penceramah;tuntutan');
?>
<script type="text/javascript">
function opennewsletter(kid, staff){
	var URL = "staff/staff_menu.php";
	//var id = document.ilim.mohon_id.value;
	//var tid = document.ilim.tid.value;
	URL = URL + '?kid=' + kid;
	//alert(URL);
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Maklumat Capaian Menu - ' + staff, 'width=750px,height=500px,center=1,resize=0,scrolling=1')

	/*emailwindow.onclose=function(){ //Define custom code to run when window is closed
		var theform=this.contentDoc.forms[0] //Access first form inside iframe just for your reference
		var theemail=this.contentDoc.getElementById("emailfield") //Access form field with id="emailfield" inside iframe
		if (theemail.value.indexOf("@")==-1){ //crude check for invalid email
			alert("Please enter a valid email address")
			return false //cancel closing of modal window
		}
		else{ //else if this is a valid email
			//alert("refresh");
			//document.getElementById("youremail").innerHTML=theemail.value //Assign the email to a span on the page
			//jah('./cal/calendar_akhbar.php?nextMonth='+mth+'&curYear='+yr+'&p=NEXT','calender');
			//document.ilim.reload();
			return true; //allow closing of window
		}
	}*/
} //End "opennewsletter" function
</script>
<script language="javascript" type="text/javascript">
function do_open(URL){
	document.ilim.action = URL;
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

                            <?php 
                                $sqlkks = "SELECT * FROM _tbl_kursus WHERE is_deleted=0 ";
                                if($_SESSION["s_level"]<>'99'){ $sqlkks .= " AND kampus_id=".tosql($_SESSION['SESS_KAMPUS']); }
                                $sqlkks .= " ORDER BY courseid";
                                $rskks = &$conn->Execute($sqlkks);
                            ?>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><font color="#FF0000">*</font><b>Subjek :</b></label>
                                <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="subjek"  onchange="do_page('<?=$href_search;?>')">
                                    <option value="">-- Sila pilih subjek --</option>
                                    <?php while(!$rskks->EOF){ ?>
                                        <option value="<?php print $rskks->fields['id'];?>" <?php if($subjek==$rskks->fields['id']){ print 'selected'; }?>
                                    ><?php print $rskks->fields['courseid'] . " - " . $rskks->fields['coursename'];?></option>
                                    <?php $rskks->movenext(); } ?>
                                </select>
                            </div>
                            </div>
                            

                            <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Bidang : </b></label>
								<div class="col-sm-12 col-md-7">
                                <select class="form-control" name="bidang"  onchange="do_page('<?=$href_search;?>')">
                                    <option value="">-- Sila pilih bidang --</option>
                                    <?php 
                                    //$r_gred = dlookupList('_ref_kepakaran', 'f_pakar_code,f_pakar_nama', '', 'f_pakar_nama');
                                    $r_gred = &$conn->execute("SELECT * FROM _ref_kepakaran ORDER BY f_pakar_nama");
                                    while (!$r_gred->EOF){ ?>
                                        <option value="<?=$r_gred->fields['f_pakar_code'] ?>" <?php if($bidang == $r_gred->fields['f_pakar_code']) echo "selected"; ?> >
                                    <?=$r_gred->fields['f_pakar_nama']?></option>
                                    <?php $r_gred->movenext(); }?>        
                                </select>
                                </div>
                            </div>


                            <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori Penceramah : </b></label>
								<div class="col-sm-12 col-md-7">
                                <select class="form-control" name="inskategori"  onchange="do_page('<?=$href_search;?>')">
        	                        <option value="">-- Semua kategori --</option>
                                        <?php	
                                            $r_kat = &$conn->execute("SELECT * FROM _ref_kategori_penceramah ORDER BY f_kp_sort");
                                            while (!$r_kat->EOF){ ?>
                                            <option value="<?=$r_kat->fields['f_kp_id'] ?>" <?php if($inskategori == $r_kat->fields['f_kp_id']) echo "selected"; ?> >
                                        <?=$r_kat->fields['f_kp_kenyataan']?></option>
                                         <?php $r_kat->movenext(); }?>        
                                </select>
                                </div>
                            </div>
	
                            <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Maklumat Carian : </b></label>
								<div class="col-sm-12 col-md-7">
			                        <input class="form-control" type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
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
						<h4>Senarai Maklumat Penceramah</h4>
					</div>
					<div class="card-body">
                        <table width="100%" cellpadding="3" cellspacing="0" border="0">
                            <tr class="title" >
                                <td colspan="3" align="right">
                                    <?php $new_page = "index.php?data=".base64_encode($userid.';penceramah/claim_form.php;penceramah;tuntutan;');?>
                                        <button class="btn btn-success" title="Sila klik untuk menyimpan maklumat peserta" value="Tambah Maklumat Tuntutan" style="cursor:pointer" onclick="do_page('<?=$new_page;?>')">&nbsp; 
                                        <i class="fas fa-plus"></i> Tambah Maklumat Tuntutan</button> 
                                </td>
                            </tr>
                        </table>
                        <?php include_once 'include/page_list.php'; ?>
                        <div class="table-responsive">
								<table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
									<thead>
                                    <tr>
                                        <th width="5%" align="center"><b>Bil</b></th>
                                        <th width="40%" align="center"><b>Nama Penceramah<br>Jabatan/Unit/Pusat</b></th>
                                        <th width="20%" align="center"><b>Kategori</b></th>
                                        <th width="12%" align="center"><b>No. HP</b></th>
                                        <th width="15%" align="center"><b>Bulan/Tahun</b><br /><i>Status</i></th>
                                        <th width="8%" align="center"><b>Tindakan</b></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(!$rs->EOF) {
                                            $cnt = 1;
                                            $bil = $StartRec;
                                            while(!$rs->EOF  && $cnt <= $pg) {
                                            //while(!$rs->EOF) {
                                                //$bil = $cnt + ($PageNo-1)*$PageSize;
                                                //$href_link = "index.php?data=".base64_encode($userid.';penceramah/claim_list.php;penceramah;tuntutan;'.$rs->fields['ingenid']);
                                                $href_link = "index.php?data=".base64_encode($userid.';penceramah/claim_form.php;penceramah;tuntutan;'.$rs->fields['cl_id']);
                                                $href_surat = "modal_form.php?win=".base64_encode('penceramah/claim_print.php;'.$rs->fields['cl_id']);
                                                ?>
                                                <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                                    <td valign="top" align="right"><?=$bil;?>.</td>
                                                    <td valign="top" align="left"><?php echo stripslashes($rs->fields['insname']);?><br />
                                                    <?php echo $rs->fields['insorganization'];?>&nbsp;</td>
                                                    <td valign="top" align="center"><?php echo dlookup("_ref_kategori_penceramah","f_kp_kenyataan","f_kp_id=".$rs->fields['inskategori']);?>&nbsp;</td>
                                                    <td valign="top" align="center"><?php echo $rs->fields['insmobiletel'];?>&nbsp;</td>
                                                    <td valign="top" align="center"><?php print month($rs->fields['cl_month']).", ".$rs->fields['cl_year']; ?>
                                                    <br /><i>
                                                    <?php
                                                    if($rs->fields['is_process']==0){ print '<font color=#FF0000>Baru</font>'; }
                                                    else if($rs->fields['is_process']==1){ print '<font color=#0000FF>Dalam Proses</font>'; }
                                                    ?></i>
                                                    &nbsp;</td>
                                                    <td align="center">
                                                        <a href="<?=$href_link;?>"><img src="../img/icon-info1.gif" width="22" height="22" style="cursor:pointer" 
                                                        title="Sila klik untuk pengemaskinian data" border="0"/></a>
                                                        <img src="../images/printicon.gif" style="cursor:pointer" title="Cetak Tuntutan" 
                                                        onClick="open_modal('<?=$href_surat;?>','Cetakan borang tuntutan penceramah',1,1)" />
                                                    </td>
                                                </tr>
                                                <?php
                                                $cnt = $cnt + 1;
                                                $bil = $bil + 1;
                                                $rs->movenext();
                                            } 
                                            $rs->Close();
                                        } else {
                                        ?>
                                        <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>No Record Found.</b></td></tr>
                                        <?php } ?>
                                    </table> 
                                </div>
                                <td colspan="5">	
                                <?php
                                $sFileName=$href_search;
                                ?>
                                <?php include_once 'include/list_footer.php'; ?> </td>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>