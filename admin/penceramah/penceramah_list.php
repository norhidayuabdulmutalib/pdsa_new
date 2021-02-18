<?php
$j=$_POST['j'];
$search=$_POST['search'];
$bidang=$_POST['bidang'];
$subjek=$_POST['subjek'];
//print "BIDANG:".$_POST['bidang'];
//$subjek=isset($_REQUEST["subjek"])?$_REQUEST["subjek"]:"";
$inskategori=isset($_REQUEST["inskategori"])?$_REQUEST["inskategori"]:"";

//$conn->debug=true;
$sSQL="SELECT A.* FROM _tbl_instructor A";
if(!empty($subjek)){ $sSQL .= ", _tbl_kursus_jadual_det B, _tbl_kursus_jadual C"; }
if(!empty($bidang)){ $sSQL .= ", _tbl_instructor_kepakaran D"; }
$sSQL .= " WHERE A.is_deleted=0 AND A.instypecd ='01' ";
if(!empty($subjek)){ $sSQL .= " AND A.ingenid=B.instruct_id AND B.event_id=C.id AND C.courseid=".tosql($subjek); }
if(!empty($bidang)){ $sSQL .= " AND A.ingenid=D.ingenid AND D.inpakar_bidang=".tosql($bidang); }
if(!empty($inskategori)){ $sSQL .= " AND A.inskategori=".tosql($inskategori); }
//if(!empty($j)){ $sSQL.=" AND fld_jawatan='P' "; } 
if(!empty($search)){ $sSQL.=" AND (A.insname LIKE '%".$search."%' OR A.insid LIKE '%".$search."%') "; }
$sSQL .= " ORDER BY A.insname";
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;
//print $sSQL;

$href_search = "index.php?data=".base64_encode($userid.';penceramah/penceramah_list.php;penceramah;daftar');
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
                        $sqlkks .= " ORDER BY courseid";
                        $rskks = &$conn->Execute($sqlkks);
                    ?>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font> Subjek :</b></label>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control" name="subjek" onchange="do_page('<?=$href_search;?>')" style="cursor:pointer" title="Sila buat pilihan untuk penyenaraian nama penceramah">
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
                                <select class="form-control" name="bidang" onchange="do_page('<?=$href_search;?>')" style="cursor:pointer" title="Sila buat pilihan untuk penyenaraian nama penceramah">
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
                            <select class="form-control" name="inskategori"  onchange="do_page('<?=$href_search;?>')" style="cursor:pointer" title="Sila buat pilihan untuk penyenaraian nama penceramah">
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
                                <button class="btn" style="background-color:#fed136;" name="Cari" onClick="do_page('<?=$href_search;?>')" style="cursor:pointer" title="Sila klik untuk penyenaraian nama penceramah">
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
                                <?php $new_page = "index.php?data=".base64_encode($userid.';penceramah/penceramah_form.php;penceramah;daftar;');?>
                                    <button class="btn btn-success" value="Tambah Maklumat Penceramah" style="cursor:pointer" onclick="do_page('<?=$new_page;?>')" 
                                    title="Sila klik untuk tambah maklumat penceramah">&nbsp;&nbsp;
                                    <i class="fas fa-plus"></i> Tambah Maklumat Penceramah</button>
                            </td>
                        </tr>
                        
                    <?php include_once 'include/page_list.php'; ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
                                <thead>
                                <tr>
                                    <th width="5%" align="center"><b>Bil</b></th>
                                    <th width="30%" align="center"><b>Nama Penceramah</b></th>
                                    <th width="15%" align="center"><b>Kategori</b></th>
                                    <th width="10%" align="center"><b>No. HP</b></th>
                                    <th width="35%" align="center"><b>Jabatan/Unit/Pusat</b></th>
                                    <th width="5%" align="center">&nbsp;</th>
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
                                            $href_link = "index.php?data=".base64_encode($userid.';penceramah/penceramah_form.php;penceramah;daftar;'.$rs->fields['ingenid']);
                                            ?>
                                            <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                                <td valign="top" align="right"><?=$bil;?>.</td>
                                                <td valign="top" align="left"><?php echo stripslashes($rs->fields['insname']);?></a>&nbsp;</td>
                                                <td valign="top" align="center"><?php echo dlookup("_ref_kategori_penceramah","f_kp_kenyataan","f_kp_id=".$rs->fields['inskategori']);?>&nbsp;</td>
                                                <td valign="top" align="center"><?php echo $rs->fields['insmobiletel'];?>&nbsp;</td>
                                                <td valign="top" align="left"><?php echo $rs->fields['insorganization'];?>&nbsp;</td>

                                                <td align="center">
                                                    <a href="<?=$href_link;?>" class="btn btn-warning" title="Sila klik untuk pengemaskinian data" style="cursor:pointer;padding:8px;" ><i class="fas fa-edit"></i></a>
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
                                </tbody>
                            </table>
                        </div> 
                        <td colspan="5">	
                            <?php
                            $sFileName=$href_search;
                            ?>
                            <?php include_once 'include/list_footer.php'; ?> </td></tr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>	
