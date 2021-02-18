
<script language="javascript" type="text/javascript">
	function openModal(URL){
		var returnValue = window.showModalDialog(URL, 'ILIM','help:no;status:no;scroll:yes;resize:yes;tools:yes;dialogHeight:500px;dialogWidth:800px');
		//window.open(URL,'name','height=255,width=250,toolbar=yes,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
	} 
</script>


	<div class="col-md-12" style="padding:0px;">
		<div class="card card-statistic-1" style="background-color:#fed136;">
			<div class="card-wrap">
				<div class="card-body">
					<table width="95%" cellpadding="0" cellspacing="0">
						<tr> 
							<td height="20"> <!--<STRONG>Thoughts of the day:</STRONG>&nbsp;-->
							<MARQUEE HEIGHT=20 SCROLLAMOUNT=3 SCROLLDELAY=150 WIDTH=900px>
							<font color="#000033" size="2" face="Verdana, Arial, Helvetica, sans-serif">Selamat Datang ke Sistem Maklumat Latihan Jakim. </font>
							</MARQUEE></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- statistik maklumat kursus -->
	<?php $href_link = "modal_form.php?win=".base64_encode('kursus/senarai_kursus.php;'.$rs->fields['id']); ?>
	<?php $this_mth = date("m"); $this_year=date("Y"); ?>
	<div class="row">
		<div class="col-lg-4 col-md-6 col-sm-6 col-12">
			<?php
				$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd 
				FROM _tbl_kursus_jadual A, _tbl_kursus B, _tbl_kursus_catsub D 
				WHERE A.courseid=B.id AND B.is_deleted=0"; 
				$sSQL.=" AND B.subcategory_code=D.id AND D.f_status=0 AND D.is_deleted=0";
				$sSQL.=" AND A.status NOT IN (1,2) AND month(A.startdate)='$this_mth' AND year(A.startdate)='$this_year'";
				if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".$_SESSION['SESS_KAMPUS']; }

				$rsbln = $conn->query($sSQL);
				$jum_bln_ini = $rsbln->recordcount();
			?>
			
			<div class="card card-statistic-1" onclick="open_modal('<?=$href_link;?>&types=NOW','Senarai kursus yang dijalankan pada bulan ini',70,70)" style="cursor:pointer">
				<div class="card-icon bg-primary">
					<i class="far fa-user"></i>
				</div>
				<div class="card-wrap">
					<div class="card-header" style="background-color: #ffffff;">
					<h4>Kursus Bulan Ini</h4>
					</div>
					<div class="card-body">
						<?php print $jum_bln_ini;?>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-6 col-sm-6 col-12">
			<?php  
				$next_mth_start = date("m",strtotime("+1 months")); $next_year_start = date("Y",strtotime("+1 months"));
				$next_mth_end = date("m",strtotime("+2 months")); $next_year_end = date("Y",strtotime("+2 months"));
				$start_date=$next_year_start."-".$next_mth_start."-01";
				$end_date=$next_year_end."-".$next_mth_end."-31";
				$sqlc = "status NOT IN (1,2) AND startdate BETWEEN ".tosql($start_date)." AND ".tosql($end_date);
				if($_SESSION["s_level"]<>'99'){ $sqlc .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }

				$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd 
				FROM _tbl_kursus_jadual A, _tbl_kursus B, _tbl_kursus_catsub D 
				WHERE A.courseid=B.id AND B.is_deleted=0"; 
				$sSQL.= " AND B.subcategory_code=D.id AND D.f_status=0 AND D.is_deleted=0";
				$sSQL.= " AND A.status NOT IN (1,2) AND A.startdate BETWEEN ".tosql($start_date)." AND ".tosql($end_date);
				if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".$_SESSION['SESS_KAMPUS']; }

				$rsbln = $conn->query($sSQL);
				$jum_bln_depan = $rsbln->recordcount();
				$conn->debug=false;
			?>

			<div class="card card-statistic-1" onclick="open_modal('<?=$href_link;?>&types=NEXT','Senarai kursus yang dijalankan pada bulan hadapan',70,70)" style="cursor:pointer">
				<div class="card-icon bg-danger">
					<i class="far fa-newspaper"></i>
				</div>
				<div class="card-wrap">
					<div class="card-header" style="background-color: #ffffff;">
						<h4>Kursus Bulan Depan</h4>
					</div>
					<div class="card-body">
						<?php print $jum_bln_depan;?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-6 col-12">
			<div class="card card-statistic-1">
			<div class="card-icon bg-warning">
				<i class="far fa-file"></i>
			</div>
			<div class="card-wrap">
				<div class="card-header" style="background-color: #ffffff;">
				<h4>Kursus Yang Sedang Dijalankan</h4>
				</div>
				<div class="card-body">
				0
				</div>
			</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12 col-md-6 col-lg-6">
			<div class="card">
				<div class="card-header">
					<h4>Jadual Kursus</h4>
				</div>
				<div class="card-body">
				<?php
					$start = date("Y-m-d");
					$end = date("Y-m-d",strtotime("+3 months"));
					
					if($_SESSION["s_level"]=='PESERTA'){
						$select = "SELECT A.courseid, A.coursename, B.startdate, B.enddate  
						FROM _tbl_kursus A, _tbl_kursus_jadual B, _tbl_kursus_jadual_peserta C, _tbl_kursus_catsub D 
						WHERE A.id=B.courseid AND B.id=C.EventId AND A.is_deleted=0 AND 
						B.startdate>=".tosql($start,"Text")." AND B.enddate<=".tosql($end,"Text");
						$select.=" AND A.subcategory_code=D.id AND D.f_status=0 AND D.is_deleted=0";
						$select .= " AND C.peserta_icno=".tosql($_SESSION["s_logid"],"Text");
						if($_SESSION["s_level"]<>'99'){ $select .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
						$select .= " ORDER BY B.startdate"; 
					} else {
						$select = "SELECT A.courseid, A.coursename, B.startdate , B.enddate, B.bilik_kuliah 
						FROM _tbl_kursus A, _tbl_kursus_jadual B, _tbl_kursus_catsub D 
						WHERE A.id=B.courseid AND A.is_deleted=0 AND 
						B.startdate>=".tosql($start,"Text")." AND B.enddate<=".tosql($end,"Text");
						$select.=" AND A.subcategory_code=D.id AND D.f_status=0 AND D.is_deleted=0";
						if($_SESSION["s_level"]<>'99'){ $select .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
						$select .= " ORDER BY B.startdate"; 
					}								
					
					//print $select;
					$rs_marque = &$conn->Execute($select);
				?>
					<marquee width="100%" height=250  scrolldelay="250" direction=up> 
					<?php 
					if(!$rs_marque->EOF) {
						while (!$rs_marque->EOF) {
						$bilik = strtoupper(dlookup("_tbl_bilikkuliah","f_bilik_nama","f_bilikid=".tosql($rs_marque->fields['bilik_kuliah'])))
					?>
							<p align="center"><strong><?php echo "[ ".$rs_marque->fields['courseid']." ] - ".$rs_marque->fields['coursename']."<br>". 
							"<i>".DisplayDate($rs_marque->fields['startdate'])." - " . DisplayDate($rs_marque->fields['enddate'])."</i>"; ?>
							<?php if(empty($bilik)){?><br /><font color="#FF0000">BILIK KULIAH BELUM DITETAPKAN</font><?php } ?>
							</strong></p>
					<?php
							$rs_marque->movenext();
						}
					} else {
					?>
						<p align="center"><strong>Tiada kursus yang didaftarkan untuk dijalankan.</strong></p>
					<?php
					}
					?>
					</marquee>  
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6 col-lg-6">
			<div class="card">
				<div class="card-header">
					<h4>Maklumat Kursus Yang Sedang Dijalankan</h4>
				</div>
				<div class="card-body">
					<?php 
						$this_dt = date('Y-m-d',strtotime("+1 days")); 
						$today_dt = date('Y-m-d'); 
						//$this_dt = date("Y-m-d");
						$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd 
						FROM _tbl_kursus_jadual A, _tbl_kursus B, _tbl_kursus_catsub D 
						WHERE A.courseid=B.id AND B.is_deleted=0"; 
						$sSQL.=" AND B.subcategory_code=D.id AND D.f_status=0 AND D.is_deleted=0";
						$sSQL .= " AND (('$this_dt' BETWEEN startdate AND enddate) OR enddate='$today_dt')";
						//$sSQL .= " AND startdate>='$this_dt' AND enddate='$today_dt'"; 
						if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".$_SESSION['SESS_KAMPUS']; }
						$sSQL .= " ORDER BY A.startdate, B.coursename";
						$sSQL .= $strSort; //"ORDER BY B.coursename";
						//print $_SESSION["s_level"].":".$sSQL;
						$rs_this = &$conn->Execute($sSQL);
						if(!$rs_this->EOF){
					?>
					<table cellpadding="5" cellspacing="0" border="0" width="100%">
						<?php while(!$rs_this->EOF){ 
						$href_link = "modal_form.php?win=".base64_encode('kursus/cetak_borang_kehadiran.php;'.$rs_this->fields['id']); 
						$href_link1 = "modal_form.php?win=".base64_encode('kursus/cetak_borang_kehadiran1.php;'.$rs_this->fields['id']); 
						$href_links = "modal_form.php?win=".base64_encode('kursus/cetak_borang_kehadiran_slot.php;'.$rs_this->fields['id']); 
						?>
						<tr>
							<?php if($_SESSION["s_usertype"]=='SYSTEM'){ ?>
							<td align="left" width="10%" valign="top">
							<img src="../images/ico-4.gif" border="0" style="cursor:pointer" title="Sila klik untuk mencetak kehadiran borang peserta" 
							onclick="open_modal('<?=$href_link;?>&types=NOW','Senarai peserta kursus pada hari ini <?=date("d/m/Y");?>',1,1)"/>
							<img src="../images/ico-4.gif" border="0" style="cursor:pointer" title="Sila klik untuk mencetak kehadiran borang peserta" 
							onclick="open_modal('<?=$href_link1;?>&types=NOW','Senarai peserta kursus pada hari ini <?=date("d/m/Y");?>',1,1)"/>&nbsp;&nbsp;
							<br /><img src="../images/ico-4.gif" border="0" style="cursor:pointer" title="Sila klik untuk mencetak kehadiran borang peserta" 
							onclick="do_open('<?=$href_links;?>&types=NOW')"/>
							</td>
							<?php } ?>
							<td width="90%" align="left" valign="top">
							<?php print $rs_this->fields['courseid']. " - ".$rs_this->fields['coursename'].
							" <i>[ ".Displaydate($rs_this->fields['startdate'])." - ".Displaydate($rs_this->fields['enddate'])." ]</i>";?>
						<br /></td></tr>
						<?php $rs_this->movenext(); } ?>
					</table>
					<?php } else { ?>
						<div><strong>Tiada Maklumat Kursus Yang Sedang Dijalankan.</strong> </div>
					<?php } ?>
					<hr>
					
					<?php if(!$rs_this->EOF){
					 if($_SESSION["s_usertype"]=='SYSTEM'){ ?>
						<br /><div style="float:left">&nbsp;<img src="../images/ico-4.gif" border="0"  /></div> Sila klik untuk mencetak borang kehadiran Peserta
					<?php } } ?>
				</div>
					
			</div>
		</div>
		</div>

						

