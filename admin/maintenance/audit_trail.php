<?php
//$conn->debug=true;
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";

if(!empty($proses) && $proses=='DEL'){
	$sql=isset($_REQUEST["sql"])?$_REQUEST["sql"]:"";
	$sqldel = "DELETE FROM auditrail ".$sql;
	//print $sqldel;
	$conn->Execute($sqldel);
	print '<script language=javascript>alert("Maklumat telah dihapuskan");</script>';
}
//if(!empty($kampus_id)){
//	$sSQL="SELECT A.* FROM auditrail A, _tbl_user B WHERE A.aid<>0 AND A.id_user=B.id_user "; 
//} else {
	$sSQL="SELECT A.* FROM auditrail A WHERE A.aid<>0 "; 
//}
if(!empty($tkh_mula) && empty($tkh_tamat)){ $sSQL1.=" AND A.trans_date>=".tosql(DBDate($tkh_mula)." 00:00:00"); } 
if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sSQL1.=" AND A.trans_date BETWEEN ".tosql(DBDate($tkh_mula)." 00:00:00")." 
	AND ".tosql(DBDate($tkh_tamat)." 00:00:00"); } 
if(!empty($search)){ $sSQL1.=" AND ( A.log_user LIKE '%".$search."%' OR A.id_user LIKE '%".$search."%' 
	OR A.remarks LIKE '%".$search."%' )"; } 
if($_SESSION["s_level"]<>'99'){ $sSQL1 .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL1.=" AND kampus_id=".$kampus_id; }
$sSQL .= $sSQL1." ORDER BY A.trans_date DESC";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode($userid.';maintenance/audit_trail.php;admin;audit');
?>
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar2.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
	function do_hapus(URL){
		var rec = document.ilim.jum_rec.value;
		if(confirm("Sebanyak "+rec+" rekod tersenarai dalam carian anda.\nAdakah anda pasti untuk menghapuskan kesemua "+rec+" rekod ini daripada senarai?")){
			document.ilim.action = URL;
			document.ilim.target = '_self';
			document.ilim.submit();
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

                            <!-- <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tarikh Transaksi : </b></label>
								<div class="col-sm-12 col-md-7">
                                    <label> Mula : </label>
                                        <input class="form-control" type="date" width="40%" name="tkh_mula" value="<?php// echo $tkh_mula;?>">
                                    <alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                                        onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
                                    <label> Tamat : </label> 
                                        <input class="form-control" type="date" width="40%" name="tkh_tamat" value="<?php//echo $tkh_tamat;?>">
                                    <alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                                        onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/>
                                </div>
                            </div> -->
                            <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tarikh Mula Transaksi : </b></label>
                                    <div class="col-sm-12 col-md-3">
                                        <input class="form-control" type="date" width="40%" name="tkh_mula" value="<?php echo $tkh_mula;?>">
                                        <alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                                            onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
                                    </div>
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-2"><b>Tarikh Tamat Transaksi : </b></label>
                                    <div class="col-sm-12 col-md-3">
                                        <input class="form-control" type="date" width="40%" name="tkh_tamat" value="<?php echo $tkh_tamat;?>">
                                        <alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                                            onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/>
                                    </div>
                                </div>

                            <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Maklumat Carian : </b></label>
								<div class="col-sm-12 col-md-5">
			                        <input class="form-control" type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <button class="btn" style="background-color:#fed136;" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')"><i class="fas fa-search"></i><b> Cari</b></button>
                               
                                    <button class="btn" style="background-color:#fed136;" name="Hapus" value="  Hapus  " onClick="do_hapus('<?=$href_search;?>&pro=DEL')"><i class="fas fa-trash"></i><b> Hapus</b></button>
                                </div>
                                    <input type="hidden" name="sql" value="<?=$sSQL1;?>" size="100" />
                                    <input type="hidden" name="jum_rec" value="<?=$RecordCount;?>" />
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
						<h4>Senarai Maklumat Audit Trail</h4>
					</div>
					<div class="card-body">
                        <table width="100%" cellpadding="3" cellspacing="0" border="0">
                            <tr class="title" >
                                <td colspan="3" align="right">
                                </td>
                            </tr>
                        
	                    <?php include_once 'include/page_list.php'; ?>
                            <div class="table-responsive">
								<table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
									<thead>
                                    <tr>
                                        <th width="5%" align="center"><b>Bil</b></th>
                                        <th width="60%" align="center"><b>Maklumat Proses</b></th>
                                        <th width="20%" align="center"><b>Pengguna & Masa</b></th>
                                        <th width="10%" align="center"><b>IP</b></th>
                                        <!--<th width="5%" align="center"><b>&nbsp;</b></th>-->
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(!$rs->EOF) {
                                            $cnt = 1;
                                            $bil = $StartRec;
                                            while(!$rs->EOF  && $cnt <= $pg) {
                                                $bil = $cnt + ($PageNo-1)*$PageSize;
                                                ?>
                                                <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                                    <td valign="top" align="right"><?=$bil;?>.</td>
                                                    <td valign="top" align="left"><?php echo stripslashes($rs->fields['remarks']);?>&nbsp;</td>
                                                    <td valign="top" align="center"><?php echo stripslashes($rs->fields['log_user']);?><br />
                                                    <i><?php echo stripslashes($rs->fields['trans_date']);?></i>&nbsp;</td>
                                                    <td valign="top" align="center"><?php echo stripslashes($rs->fields['ip']);?>&nbsp;</td>
                                                    <!--<td align="center">
                                                        <img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data" />
                                                    </td>-->
                                                </tr>
                                                <?php
                                                $cnt = $cnt + 1;
                                                $bil = $bil + 1;
                                                $rs->movenext();
                                            } 
                                        } else {
                                        ?>
                                            <tr><td colspan="4" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                                        <?php } ?>                   
                                    </table> 
                                </tbody>
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
