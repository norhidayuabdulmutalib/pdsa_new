<?php
//$conn->debug=true;
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
$varSort=isset($_REQUEST["sb"])?$_REQUEST["sb"]:"startdate";
$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd, B.subcategory_code, C.kampus_kod  
FROM _tbl_kursus_jadual A, _tbl_kursus B, _ref_kampus C 
WHERE A.courseid=B.id AND A.kampus_id=C.kampus_id AND B.is_deleted=0 AND A.status NOT IN (1,2) AND A.enddate<=".tosql(date("Y-m-d"));
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL.=" AND A.kampus_id=".$kampus_id; }
if(!empty($search)){ $sSQL.=" AND B.coursename LIKE '%".$search."%' "; } 
if(!empty($kategori)){ $sSQL.=" AND B.category_code=".tosql($kategori,"Text"); } 
if(!empty($subkategori)){ $sSQL.=" AND B.subcategory_code=".tosql($subkategori,"Text"); } 
if(!empty($tkh_mula) && empty($tkh_tamat)){ $sSQL.=" AND A.startdate>=".tosql(DBDate($tkh_mula),"Text"); } 
if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sSQL.=" AND A.startdate BETWEEN ".tosql(DBDate($tkh_mula),"Text")." AND ".tosql(DBDate($tkh_tamat),"Text"); } 
//$strSort=((strlen($varSort)>0)?"ORDER BY $varSort ":"ORDER BY coursename ");
if($varSort=='coursename'){ 
	$strSort=((strlen($varSort)>0)?" ORDER BY $varSort ASC":"ORDER BY startdate DESC");
} else {
	$strSort=((strlen($varSort)>0)?" ORDER BY $varSort DESC":"ORDER BY startdate DESC");
}
//$strSort=((strlen($varSort)>0)?"ORDER BY $enddate ":"ORDER BY enddate ");
$sSQL .= $strSort; //"ORDER BY B.coursename";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;

$href_search = "index.php?data=".base64_encode($userid.';penilaian/peratusan_penilaian.php;kursus;peratus');
?>
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar2.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
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
                                <select name="kampus_id" class="form-control" onchange="do_page('<?=$href_search;?>')">
                                    <option value="">-- Sila pilih kampus --</option>
                                    <?php while(!$rskks->EOF){ ?>
                                    <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus_id==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                                    <?php $rskks->movenext(); } ?>
                                </select>
                            </div>
						</div>
                        <?php } ?>

                        <?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
                            $rskk = &$conn->Execute($sqlkk);
                        ?>
                        <div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori Kursus :</b></label>
							<div class="col-sm-12 col-md-7">
                                <select class="form-control" name="kategori" onchange="do_page('<?=$href_search;?>')">
                                    <option value="">-- Sila pilih kategori --</option>
                                    <?php while(!$rskk->EOF){ ?>
                                    <option value="<?php print $rskk->fields['id'];?>" <?php if($kategori==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                                    <?php $rskk->movenext(); } ?>
                                </select>
                            </div>
						</div>
			
                        <?php 
                            $sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 AND f_status=0 ORDER BY SubCategoryNm";
                            $rskks = &$conn->Execute($sqlkks);
                        ?>
                        <div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat / Unit :</b></label>
							<div class="col-sm-12 col-md-7">
                                <select class="form-control" name="subkategori" onchange="do_page('<?=$href_search;?>')">
                                    <option value="">-- Sila pilih sub-kategori --</option>
                                    <?php while(!$rskks->EOF){ ?>
                                        <option value="<?php print $rskks->fields['id'];?>" <?php if($subkategori==$rskks->fields['id']){ print 'selected'; }?>
                                    ><?php print $rskks->fields['SubCategoryDesc']." [".$rskks->fields['SubCategoryNm']."]";?></option>
                                    <?php $rskks->movenext(); } ?>
                                </select>
                            </div>
						</div>

                        <div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tarikh Kursus :</b></label>
							<div class="col-sm-12 col-md-7">
                                <label> Mula : </label>
                                    <input class="form-control" type="date" width="40%" name="tkh_mula" value="<?php echo $tkh_mula;?>">
                                <alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                                    onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
                                <label> Tamat : </label> 
                                    <input class="form-control" type="date" width="40%" name="tkh_tamat" value="<?php echo $tkh_tamat;?>">
                                <alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                                    onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/>
                            </div>
						</div>

                        <div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Nama Kursus : </b></label>
									<div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="search" value="<?php echo stripslashes($search);?>">
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
						<h4>Senarai Maklumat Kursus (Penilaian Kursus)</h4>
					</div>
					<div class="card-body">
                        <?php include_once 'include/page_list.php'; ?>
                        <div class="table-responsive">
								<table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
								<thead>
                                <tr>
                                    <th width="5%" align="center"><b>Bil</b></th>
                                    <th width="8%" align="center"><b>Kod Kursus</b></th>
                                    <th width="40%" align="center">
                                        <a href="<?php echo $href_search."&sb=coursename&search=$search&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat"; ?>"><b>Diskripsi Kursus</b></a>&nbsp;
                                        <?php echo (($varSort=="coursename")?"<img src=\"../images/down_arrow.gif\">":"");?></th>
                                    <th width="20%" align="center"><b>Pusat/Unit</b></td>
                                    <th width="8%" align="center">
                                        <a href="<?php echo $href_search."&sb=startdate&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat&search=$search"; ?>"><b>Tarikh Mula</b></a>&nbsp;
                                        <?php echo (($varSort=="startdate")?"<img src=\"../images/down_arrow.gif\">":"");?></th>
                                    <th width="8%" align="center">
                                        <a href="<?php echo $href_search."&sb=enddate&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat&search=$search"; ?>"><b>Tarikh Tamat</b></a>&nbsp;
                                        <?php echo (($varSort=="enddate")?"<img src=\"../images/down_arrow.gif\">":"");?></th>
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
                                            $href_link = "modal_form.php?win=".base64_encode('penilaian/peratusan_penilaian_list.php;'.$rs->fields['id']);
                                            //$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm", 
                                            //	"SubCategoryCd=".tosql($rs->fields['SubCategoryCd'],"Text")." OR id=".tosql($rs->fields['sub_category_code'],"Text"));
                                            $sqlsc = "SELECT SubCategoryNm, f_status FROM _tbl_kursus_catsub 
                                                WHERE SubCategoryCd=".tosql($rs->fields['SubCategoryCd'],"Text")." OR id=".tosql($rs->fields['subcategory_code'],"Text");
                                            $rssb = $conn->query($sqlsc);
                                            $unit = $rssb->fields['SubCategoryNm'];
                                            $f_status = $rssb->fields['f_status'];

                                            //$unit = pusat_kursus($rs->fields['subcategory_code']);
                                            $href_borang = "modal_form.php?win=".base64_encode('penilaian/cetak_peratusan_penilaian.php;'.$rs->fields['id']);
                                            ?>
                                            <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                                <td valign="top" align="right"><?=$bil;?>.</td>
                                                <td valign="top" align="left"><?php echo stripslashes($rs->fields['courseid']);?>&nbsp;</td>
                                                <td valign="top" align="left">
                                                    <?php if($f_status==1){ print '<div style="text-decoration:line-through">'; } ?>
                                                    <?php echo stripslashes($rs->fields['coursename']);?>
                                                    <?php if($f_status==1){ print '</div> <i><font color="red">(Telah dihapuskan)</font></i>'; } ?>
                                                    &nbsp;</td>
                                                <td valign="top" align="center"><?php print $rs->fields['kampus_kod'];?> - 
                                                    <?php echo stripslashes($unit);?>&nbsp;</td>
                                                <td valign="top" align="center"><?php echo DisplayDate($rs->fields['startdate'])?>&nbsp;</td>
                                                <td valign="top" align="center"><?php echo DisplayDate($rs->fields['enddate'])?>&nbsp;</td>
                                                <td align="center">
                                                <?php if($_SESSION["s_jabatan"]==$rs->fields['subcategory_code'] || 
                                                    $_SESSION["s_level"]==1 || $_SESSION["s_level"]==99){ ?>
                                                    <img src="../img/icon-info1.gif" width="25" height="25" style="cursor:pointer" 
                                                    title="Sila klik untuk paparan jumpah peratusan penilaian" 
                                                    onclick="open_modal('<?=$href_link;?>','Paparan maklumat peratusan penilaian',1,1)" />
                                                    <img src="../images/printer_icon1.jpg" width="25" height="25" style="cursor:pointer" 
                                                    onclick="open_modal('<?=$href_borang;?>','Cetak borang penilaian kursus',1,1)" title="Cetak borang penilaian kursus" />
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
                                    <tr><td colspan="7" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
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

