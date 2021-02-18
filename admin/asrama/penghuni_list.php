<?php
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$PageNo = $_GET['page'];
if(!empty($_POST['search'])){ $search=$_POST['search']; $_SESSION['s_search']=$search;
} else if($_POST['search']==''){ $search='';
} else { $search=$_SESSION['s_search']; }
if(!empty($_POST['linepage'])){ $_SESSION['linepage'] = $_POST['linepage']; }
$kursus = $_POST['kursus'];
//$conn->debug=true;
if(empty($sub_tab)){ $sub_tab='peserta'; }
if($sub_tab=='peserta'){
	/*$sSQL="SELECT A.f_peserta_nama AS daftar_nama, A.f_peserta_noic AS NOKP, E.f_tempat_nama AS agensi, 
	C.bilik_id, C.daftar_id, D.no_bilik 
	FROM _tbl_peserta A, _sis_a_tblasrama C, _sis_a_tblbilik D, _ref_tempatbertugas E
	WHERE A.f_peserta_noic=C.peserta_id AND A.is_deleted=0 AND C.is_daftar=1 AND C.bilik_id=D.bilik_id AND A.BranchCd=E.f_tbcode ";
	if(!empty($kursus)){ $sSQL .= " AND C.event_id=".tosql($kursus); }
	if(!empty($search)){ $sSQL .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.f_peserta_noic LIKE '%".$search."%' OR D.no_bilik LIKE '%".$search."%')"; }
	$sSQL .= " ORDER BY C.event_id, D.no_bilik, A.f_peserta_nama";*/

	$sSQL="SELECT C.*, D.no_bilik, C.peserta_id AS NOKP 
	FROM _sis_a_tblasrama C, _sis_a_tblbilik D
	WHERE C.is_daftar=1 AND C.bilik_id=D.bilik_id ";
	if(!empty($kursus)){ $sSQL .= " AND C.event_id=".tosql($kursus); }
	if(!empty($search)){ $sSQL .= " AND C.peserta_id LIKE '%".$search."%' "; }
	$sSQL .= " ORDER BY C.event_id, D.no_bilik";
	$rs = &$conn->Execute($sSQL);
	$cnt = $rs->recordcount();

} else {
	$sSQL="SELECT A.insname AS daftar_nama, A.insid AS NOKP, A.insorganization AS agensi, 
	C.bilik_id, C.daftar_id, D.no_bilik 
	FROM _tbl_instructor A, _sis_a_tblasrama C, _sis_a_tblbilik D
	WHERE A.insid=C.peserta_id AND A.is_deleted=0 AND C.is_daftar=1 AND C.bilik_id=D.bilik_id";
	if(!empty($kursus)){ $sSQL .= " AND C.event_id=".tosql($kursus); }
	if(!empty($search)){ $sSQL .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.insid LIKE '%".$search."%' OR D.no_bilik LIKE '%".$search."%')"; }
	$sSQL .= $sql_search . " ORDER BY C.event_id, D.no_bilik, A.insname";
	$rs = &$conn->Execute($sSQL);
	$cnt = $rs->recordcount();
}
$conn->debug=false;
//if(!empty($get_jantina)){ $sSQL.=" AND A.p_jantina= '".$get_jantina."' "; } 
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 

$href_search = "index.php?data=".base64_encode('user;asrama/penghuni_list.php;asrama;penghuni');
?>
<? include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<br />
<script language="JavaScript1.2" type="text/javascript">
function do_page(URL){
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}
function do_post(){
	var data = document.ilim.data.value;
	document.ilim.action = "index.php?data="+data;
	document.ilim.target = '_self';
	document.ilim.submit();
}
</script>

<?php
$data = $_GET['data'];
$kategori = $_POST['kategori'];
?>

<section class="section">
	<div class="section-body">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header" >
						<h4>Carian Maklumat Kursus</h4>
					</div>
					<div class="card-body">
						<?php
						//$conn->debug=true;
						$sqlk = "SELECT DISTINCT B.id AS JID, B.startdate, B.enddate, B.acourse_name, B.courseid 
						FROM _tbl_kursus_jadual B, _sis_a_tblasrama C 
						WHERE B.id=C.event_id AND C.is_daftar=1 ";
						if($_SESSION["s_level"]<>'99'){ $sqlk .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
						if(!empty($kampus_id)){ $sqlk.=" AND B.kampus_id=".$kampus_id; }
						$sqlk .= " ORDER BY B.startdate";
						$rsku = &$conn->execute($sqlk);
						?>

						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Nama Kursus :</b></label>
							<div class="col-sm-12 col-md-6">
								<select class="form-control" name="kursus"  onchange="do_page('<?=$href_search;?>')">
									<option value="">-- Sila pilih --</option>
									<?php while(!$rsku->EOF){ 
									$namakursus = $rsku->fields['acourse_name'];
									if(empty($namakursus)){ $namakursus = dlookup("_tbl_kursus","coursename","id=".tosql($rsku->fields['courseid'])); }
									?>
										<option value="<?=$rsku->fields['JID'];?>" <?php if($rsku->fields['JID']==$kursus){ print 'selected'; }?>><?//=$namakursus.
										// "&nbsp; [ Tarikh Kursus : ".DisplayDate($rsku->fields['startdate'])." - " .displayDate($rsku->fields['enddate'])." ]";?></option>
									<?php $rsku->movenext(); } ?>
								</select>
							</div>
							<div class="col-sm-12 col-md-3">
        						<div style="background-color:#FFCC00;width:30px;height:20px;float:left"></div> &nbsp;Peserta melebihi tempoh
        					</div>
						</div>
						<!--<tr>
							<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
							<td width="60%" align="left">&nbsp;&nbsp;
								<input type="text" size="30" name="search" value="<?// echo stripslashes($search);?>">
								<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?//=$href_search;?>')">
								<input type="hidden" name="data" value="<?//=$data;?>" />
							</td>
						</tr>-->

						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Jumlah Rekod :</b></label>
							<div class="col-sm-12 col-md-1">
								<?=$RecordCount;?>
							</div>
							<label class="col-form-label text-md-right col-12 col-md-2 col-lg-2"><b>Sebanyak</b></label>
							<div class="col-sm-12 col-md-2">
								<select class="form-control" name="linepage" onChange="do_page('<?=$href_search;?>')">
									<option value="10" <? if($PageSize==10){ echo 'selected'; }?>>10</option>
									<option value="20" <? if($PageSize==20){ echo 'selected'; }?>>20</option>
									<option value="50" <? if($PageSize==50){ echo 'selected'; }?>>50</option>
									<option value="100" <? if($PageSize==100){ echo 'selected'; }?>>100</option>
								</select>
							</div>
							<div class="col-sm-12 col-md-4">
								<label class="col-form-label text-md"><b>rekod dipaparkan bagi setiap halaman.</b></label>
							</div>
						</div>

						<?php
						$sSQL_p="SELECT C.*, C.daftar_id, D.no_bilik 
						FROM _sis_a_tblasrama C, _sis_a_tblbilik D
						WHERE C.is_daftar=1 AND C.bilik_id=D.bilik_id";
						if(!empty($kursus)){ $sSQL_p .= " AND C.event_id=".tosql($kursus); }
						$rsp = &$conn->Execute($sSQL_p);
						$cnt_peserta = $rsp->recordcount();
						//print '<br>';
						$sSQL_p="SELECT A.*, C.bilik_id, C.daftar_id, D.no_bilik 
						FROM _tbl_instructor A, _sis_a_tblasrama C, _sis_a_tblbilik D
						WHERE A.insid=C.peserta_id AND A.is_deleted=0 AND C.is_daftar=1 AND C.bilik_id=D.bilik_id";
						if(!empty($kursus)){ $sSQL_p .= " AND C.event_id=".tosql($kursus); }
						$rsp = &$conn->Execute($sSQL_p);
						$cnt_penceramah = $rsp->recordcount();
						//$conn->debug=false;
						?>

						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b></b></label>
							<div class="col-sm-12 col-md-7">
								<ul class="menu5">
									<li <? if($sub_tab=='peserta'){ print 'class="current"'; }?>>
										<a href="index.php?data=<? print base64_encode('user;asrama/penghuni_list.php;asrama;penghuni;'.$id.';peserta');?>">
										<b>Senarai Penserta Kursus <i>(<?php print $cnt_peserta;?> orang)</i> </b></a></li>
									<li <? if($sub_tab=='penceramah'){ print 'class="current"'; }?>>
										<a href="index.php?data=<? print base64_encode('user;asrama/penghuni_list.php;asrama;penghuni;'.$id.';penceramah');?>">
										<b>Senarai Penceramah @ Fasilatitor <i>(<?php print $cnt_penceramah;?> orang)</i> </b></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
					<div class="card-header">
						<h4>MAKLUMAT PENGHUNI ASRAMA</h4>
					</div>
					<div class="card-body">
					<table width="100%" cellpadding="3" cellspacing="0" border="0">

					<div class="table-responsive">
						<table class="table table-bordered">
						<thead>

							<tr> 
								<th width="5%" align="center"><b>Bil</b></th>
								<th width="30%" align="center"><b>Nama Peserta</b></th>
								<th width="20%" align="center"><b>Agensi</b></th>
								<th width="35%" align="center"><b>Kursus</b></th>
								<th width="5%" align="center"><b>No. Bilik</b></th>
								<th width="5%" align="center"><b>Daftar Keluar</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!$rs->EOF) {
								$cnt = 1;
								$bil = $StartRec;
								while(!$rs->EOF  && $cnt <= $pg) {
									//$href_link = "index.php?data=".base64_encode('user;asrama/penghuni_form.php;asrama;penghuni;'.$rs->fields['daftar_id']);
									$href_link = "modal_form.php?win=".base64_encode('asrama/dkeluar_form.php;'.$rs->fields['daftar_id']);
									if($sub_tab=='peserta'){
										$sql_k = "SELECT f_peserta_nama, BranchCd FROM _tbl_peserta WHERE f_peserta_noic=".tosql($rs->fields['NOKP'],"Text"); 
										$rs_peserta = $conn->execute($sql_k);
										$nama_peserta = $rs_peserta->fields['f_peserta_nama'];
										if(empty($nama_peserta)){ $nama_peserta=$rs->fields['nama_peserta']; }
										$agensi = dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".$rs_peserta->fields['BranchCd']);

										$sql_k = "SELECT coursename AS kursus, B.startdate AS mula, B.enddate AS tamat FROM _tbl_kursus A, _tbl_kursus_jadual B 
										WHERE A.id=B.courseid AND B.id=".tosql($rs->fields['event_id'],"Text");
										$rs_kursus = $conn->execute($sql_k);
										$kursus = $rs_kursus->fields['kursus'];

										if(empty($kursus)){ 
											$sql_k = "SELECT B.startdate AS mula, B.enddate AS tamat, B.acourse_name FROM _tbl_kursus_jadual B 
											WHERE B.id=".tosql($rs->fields['event_id'],"Text");
											$rs_kursus = $conn->execute($sql_k);
											$kursus = $rs_kursus->fields['acourse_name']; 
										}

									} else {
										$nama_peserta = $rs->fields['daftar_nama'];
										$sql_k = "SELECT coursename AS kursus, B.startdate AS mula, B.enddate AS tamat FROM _tbl_kursus A, _tbl_kursus_jadual B, _sis_a_tblasrama C 
										WHERE A.id=B.courseid AND B.id=C.event_id AND C.peserta_id=".tosql($rs->fields['NOKP'],"Text");
										$rs_kursus = $conn->execute($sql_k);
									}
									
									if($rs_kursus->fields['tamat']<date("Y-m-d")){ $bg="#FFCC00"; } else { $bg="#FFFFFF"; } 
									if(empty($agensi)){ $agensi='Peserta Kursus Luar'; }
								?>
							<tr bgcolor="<?php print $bg; ?>">
								<td align="right" valign="top"><? echo $bil;?>.&nbsp;<?//=$sub_tab;?></td>
								<td valign="top"><a onclick="open_modal('<?=$href_link;?>&tab=<?=$sub_tab;?>','Daftar Keluar Penghuni Asrama',700,350)" style="cursor:pointer"> 
									<? echo stripslashes($nama_peserta);?></a>
									<br /><i>[<? echo stripslashes($rs->fields['NOKP']);?>]</i>&nbsp;</td>
								<td align="center" valign="top"><? echo stripslashes($agensi);?>&nbsp;</td>
								<td align="center" valign="top"><? echo $kursus;?><br />
								<i>[<? echo DisplayDate($rs_kursus->fields['mula']);?> - <? echo DisplayDate($rs_kursus->fields['tamat']);?>]</i>&nbsp;</td>
								<td align="center"><? echo dlookup("_sis_a_tblbilik", "no_bilik", "bilik_id = '".stripslashes($rs->fields['bilik_id'])."'");?>&nbsp;</td>
								<td align="center">
									<img src="../images/btn_web-users_bg.gif" style="cursor:pointer" border="0" 
									onclick="open_modal('<?=$href_link;?>&tab=<?=$sub_tab;?>','Daftar Keluar Penghuni Asrama',700,350)" 
									title="Sila klik untuk daftar keluar penghuni asrama">
								</td>
							</tr>
						</tbody>
							<?php
									$cnt = $cnt + 1;
									$bil = $bil + 1;
									$rs->movenext();
								}
								$rs->Close();
							}
								?>
						</table>
					</div>

					<tr><td colspan="5">	
					<?php
					$sFileName=$href_search;
					?>
					<? include_once 'include/list_footer.php'; ?> </td></tr>
					<tr><td colspan="5" align="center">
						<!--<input type="button" value="Proses Penerimaan" style="cursor:pointer" />-->
					</td></tr>
				</div>
			</div>
		</div>
	</div>
</section>

<script language="javascript">
	document.ilim.kursus.focus();
</script>