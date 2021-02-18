<?php
$j=$_POST['j'];
$search=$_POST['search'];
$pusat=$_POST['pusat'];
//$conn->debug=true;
$sSQL="SELECT A.*, B.f_tempat_nama FROM _tbl_peserta A, _ref_tempatbertugas B WHERE A.BranchCd=B.f_tbcode AND A.is_deleted=0 ";
$sSQL .= " AND A.BranchCd='0016' ";
//if(!empty($pusat)){ $sSQL.=" AND A.BranchCd=".tosql($pusat,"Text"); } 
if(!empty($search)){ $sSQL.=" AND ( A.f_peserta_nama LIKE '%".$search."%' OR A.f_peserta_noic LIKE '%".$search."%') "; }
$sSQL .= " ORDER BY f_peserta_nama";
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;

$href_search = "index.php?data=".base64_encode($userid.';peserta/peserta_list_kluar.php;peserta;kluar');
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

<br>

<section class="section">
	<div class="section-body">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header" >
						<h4>Carian Maklumat Kursus</h4>
					</div>
					<?php include_once 'include/list_head.php'; ?>
					<form name="ilim" method="post">
						<div class="card-body">
							<div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Maklumat Carian : </b></label>
								<div class="col-sm-12 col-md-7">
									<input type="text" class="form-control" name="search" value="<?php echo stripslashes($search);?>">
								</div>
								<div class="col-sm-12 col-md-2">
									<button class="btn" style="background-color:#fed136;" name="Cari" onClick="do_page('<?=$href_search;?>')" title="Sila klik untuk membuat carian">
										<i class="fas fa-search"></i><b> Cari</b>
									</button>
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
						<h4>SENARAI MAKLUMAT PESERTA KURSUS</h4>
					</div>
					<div class="card-body">
						<?php include_once 'include/page_list.php'; ?>
							<div class="table-responsive">
								<table class="table table-striped" id="table-1">
									<thead>
									<tr>
										<th width="5%" align="center"><b>Bil</b></th>
										<th width="30%" align="center"><b>Nama Peserta</b></th>
										<th width="5%" align="center"><b>No. K/P</b></th>
										<th width="5%" align="center"><b>Gred</b></th>
										<th width="30%" align="center"><b>Jabatan/Unit/Pusat</b></th>
										<th width="20%" align="center"><b>Jumlah Kursus Tahunan</b></th>
										<th width="5%" align="center">&nbsp;</th>
									</tr>
									</thead>
									<tbody>
										<?php
										if(!$rs->EOF) {
											$cnt = 1;
											$bil = $StartRec;
											while(!$rs->EOF  && $cnt <= $pg) {
												$href_link = "index.php?data=".base64_encode($userid.';peserta/peserta_form_kluar.php;peserta;kluar;'.$rs->fields['id_peserta']);
												$lepas = date("Y")-1; $semasa = date("Y"); 
											?>
												<tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
													<td valign="top" align="right"><?=$bil;?>.</td>
													<td valign="top" align="left"><?php echo stripslashes($rs->fields['f_peserta_nama']);?></a>&nbsp;</td>
													<td valign="top" align="center"><?php echo $rs->fields['f_peserta_noic'];?>&nbsp;</td>
													<td valign="top" align="center"><?php print dlookup("_ref_titlegred","f_gred_code","f_gred_id=".tosql($rs->fields['f_title_grade']));?>&nbsp;</td>
													<td valign="top" align="left"><?php echo $rs->fields['f_tempat_nama'];?>&nbsp;</td>
													<td align="left" valign="top">
														<?php include 'view_kursus_calc_main.php'; ?>
													</td>
													<td align="center">

														<a href="<?=$href_link;?>">
															<button class="btn btn-warning" title="Sila klik untuk pengemaskinian data" style="cursor:pointer;padding:8px;"><i class="fas fa-edit"></i>
															</button>
														</a>
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