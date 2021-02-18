<?php
$j=$_POST['j'];
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$f_level=isset($_REQUEST["f_level"])?$_REQUEST["f_level"]:"";
//$conn->debug=true;
$sSQL="SELECT A.*, B.kampus_kod FROM _tbl_user A, _ref_kampus B 
WHERE A.kampus_id=B.kampus_id AND f_isdeleted=0 AND id_user<>'su' "; //f_staffid <> '' AND 
//if(!empty($j)){ $sSQL.=" AND f_jawatan='P' "; } 
$sSQL .= $sql_filter;
if(!empty($search)){ $sSQL.=" AND f_name LIKE '%".$search."%' "; } else { $sSQL.=" AND 	f_userid <>'1' "; }
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL.=" AND B.kampus_id=".$kampus_id; }
if(!empty($f_level)){ $sSQL.=" AND A.f_level=".$f_level; }
$sSQL .= " ORDER BY f_name";
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;

$href_search = "index.php?data=".base64_encode($userid.';staff/staff_list.php;admin;staff');
?>
<link rel="stylesheet" href="modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="modalwindow/dhtmlwindow.js">

/***********************************************
* DHTML Window Widget- � Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<script type="text/javascript" src="modalwindow/modal.js"></script>
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
function reset_pass(kid, staff){
	var URL = "staff/staff_reset_pwd.php";
	URL = URL + '?kid=' + kid;
	if(confirm("Adakah anda pasti untuk 'RESET' katalaluan baru kepada pengguna ini " + staff )){
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Menjana katalaluan baru - ' + staff, 'width=750px,height=500px,center=1,resize=0,scrolling=1')
	}
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
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori Pengguna : </b></label>
								<div class="col-sm-12 col-md-7">
                                <select class="form-control" name="f_level">
                                    <option value="">-- Sila pilih --</option>
                                    <option value="99" <?php if($f_level=='99'){ print 'selected';} ?>>Administrator Sistem Utama</option>
                                    <option value="1" <?php if($f_level=='1'){ print 'selected';} ?>>Administrator Pusat Latihan</option>
                                    <option value="2" <?php if($f_level=='2'){ print 'selected';} ?>>Pengguna Pengurusan</option>
                                    <option value="3" <?php if($f_level=='3'){ print 'selected';} ?>>Pengguna Domestik</option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Maklumat Carian : </b></label>
								<div class="col-sm-12 col-md-7">
                                    <input class="form-control" type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
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

	<!-- <tr>
		<td align="right"><b>Maklumat Carian : </b></td>
        <td align="left">
			<input type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
			&nbsp;&nbsp;&nbsp;&nbsp;
            <b>Kategori Pengguna : </b>
            <select name="f_level">
                <option value="99" <?php if($f_level=='99'){ print 'selected';} ?>>Administrator Sistem Utama</option>
                <option value="1" <?php if($f_level=='1'){ print 'selected';} ?>>Administrator Pusat Latihan</option>
                <option value="2" <?php if($f_level=='2'){ print 'selected';} ?>>Pengguna Pengurusan</option>
                <option value="3" <?php if($f_level=='3'){ print 'selected';} ?>>Pengguna Domestik</option>
            </select>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr> -->

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
					<div class="card-header">
						<h4>Senarai Maklumat Staf / Kakitangan </h4>
					</div>
					<div class="card-body">
                        <table width="100%" cellpadding="3" cellspacing="0" border="0">
                            <tr class="title" >
                                <td colspan="3" align="right">
                                    <?php $new_page = "index.php?data=".base64_encode($userid.';staff/staff_form.php;admin;staff;');?>
                                    <button class="btn btn-success" value="Tambah Maklumat Kakitangan" style="cursor:pointer" onclick="do_page('<?=$new_page;?>')" />&nbsp;&nbsp;
                                    <i class="fas fa-plus"></i> Tambah Maklumat Unit / Pusat Kursus</button> 
                                </td>
                            </tr>

	                        <?php include_once 'include/page_list.php'; ?>
                            <div class="table-responsive">
								<table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
									<thead>
                                    <tr>
                                        <th width="5%" align="center"><b>Bil</b></th>
                                        <th width="20%" align="center"><b>Nama Kakitangan</b></th>
                                        <th width="10%" align="center"><b>No. K/P</b></th>
                                        <th width="5%" align="center"><b>Kampus</b></th>
                                        <th width="10%" align="center"><b>Pusat</b></th>
                                        <th width="10%" align="center"><b>ID Pengguna</b></th>
                                        <th width="10%" align="center"><b>Peranan</b></th>
                                        <th width="10%" align="center"><b>Status</b></th>
                                        <th width="20%" align="center"><b>Menu</b></th>
                                    </tr>
                                    <?php
                                    if(!$rs->EOF) {
                                        $cnt = 1;
                                        $bil = $StartRec;
                                        while(!$rs->EOF  && $cnt <= $pg) {
                                        //while(!$rs->EOF) {
                                            //$bil = $cnt + ($PageNo-1)*$PageSize;
                                            $href_link = "index.php?data=".base64_encode($userid.';staff/staff_form.php;admin;staff;'.$rs->fields['id_user']);
                                            $unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['f_jabatan'],"Text"));
                                            $pwd=md5("Password@123");
                                            if($rs->fields['f_level']=='99'){ $peranan = 'Administrator Sistem Utama'; }
                                            else if($rs->fields['f_level']=='1'){ $peranan = 'Administrator Pusat Latihan'; }
                                            else if($rs->fields['f_level']=='2'){ $peranan = 'Pengguna Pengurusan'; }
                                            else if($rs->fields['f_level']=='3'){ $peranan = 'Pengguna Domestik'; }
                                            
                                            if($rs->fields['f_aktif']=='1'){ $status = 'Aktif'; }
                                            else { $status = '<font color="#FF0000">Tidak Aktif</font>'; }
                                            ?>
                                            <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                                <td valign="top" align="right"><?=$bil;?>.</td>
                                                <td align="left" valign="top"><a href="<?=$href_link;?>"><?php echo stripslashes($rs->fields['f_name']);?></a>&nbsp;</td>
                                                <td valign="top" align="center"><?php echo $rs->fields['f_noic'];?>&nbsp;</td>
                                                <td valign="top" align="center"><?php echo $rs->fields['kampus_kod'];?>&nbsp;</td>
                                                <td valign="top" align="center"><?php echo stripslashes($unit);?>&nbsp;</td>
                                                <td valign="top" align="center"><?php echo $rs->fields['f_userid'];?>&nbsp;</td>
                                                <td valign="top" align="center"><?php echo $peranan;?>&nbsp;</td>
                                                <td valign="top" align="center"><?php echo $status;?>&nbsp;</td>
                                                <td align="center">
                                                    <img src="../images/btn_file-manager_bg.gif" border="0" style="cursor:pointer" 
                                                    onclick="opennewsletter('<?=$rs->fields['id_user'];?>','<?php print addslashes($rs->fields['f_name']);?>'); return false"  />
                                                <?php if($rs->fields['f_password']==$pwd){ print 'PWD Asal'; } else { ?>
                                                    <img src="../img/s_pass.gif" border="0" style="cursor:pointer" title="Sila klik untuk reset password" 
                                                    onclick="reset_pass('<?php print $rs->fields['id_user'];?>','<?php print $rs->fields['f_name'];?>'); return false"  />
                                                <?php } ?>
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
