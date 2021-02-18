
<?php
//$conn->debug=true;
$enddate = date("Y-m-d");
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
$tlaksana=isset($_REQUEST["tlaksana"])?$_REQUEST["tlaksana"]:"";
$blaksana=isset($_REQUEST["blaksana"])?$_REQUEST["blaksana"]:"";
$varSort=isset($_REQUEST["sb"])?$_REQUEST["sb"]:"startdate";
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$bidang_id=isset($_REQUEST["bidang_id"])?$_REQUEST["bidang_id"]:"";

//print $_REQUEST["tlaksana"];
$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd AS SUB, B.subcategory_code, B.bidang_id, B.kampus_id AS KID 
FROM _tbl_kursus_jadual A, _tbl_kursus B 
WHERE A.courseid=B.id AND B.is_deleted=0";
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL.=" AND B.kampus_id=".$kampus_id; }
if(!empty($search)){ $sSQL.=" AND (B.coursename LIKE '%".$search."%' OR B.courseid  LIKE '%".$search."%')"; } 
if(!empty($kategori)){ $sSQL.=" AND B.category_code=".tosql($kategori,"Text"); } 
if(!empty($subkategori)){ $sSQL.=" AND B.subcategory_code=".tosql($subkategori,"Text"); } 
if(!empty($tlaksana) && empty($blaksana)){ $sSQL.=" AND A.enddate<=".tosql($enddate,"Text"); } 
if(!empty($blaksana) && empty($tlaksana)){ $sSQL.=" AND A.enddate>=".tosql($enddate,"Text"); } 
if(!empty($tkh_mula) && empty($tkh_tamat)){ $sSQL.=" AND A.startdate>=".tosql(DBDate($tkh_mula),"Text"); } 
if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sSQL.=" AND A.startdate BETWEEN ".tosql(DBDate($tkh_mula),"Text")." AND ".tosql(DBDate($tkh_tamat),"Text"); } 
if(!empty($bidang_id)){ $sSQL.=" AND B.bidang_id=".tosql($bidang_id); }
//$strSort=((strlen($varSort)>0)?"ORDER BY $varSort ":"ORDER BY coursename ");
if($varSort=='coursename'){ 
	$strSort=((strlen($varSort)>0)?" ORDER BY $varSort ASC":" ORDER BY startdate DESC");
} else {
	$strSort=((strlen($varSort)>0)?" ORDER BY $varSort DESC":" ORDER BY startdate DESC");
}
// var_dump($sSQL);exit();
//$strSort=((strlen($varSort)>0)?"ORDER BY $enddate ":"ORDER BY enddate ");
$sSQL .= $strSort; //"ORDER BY B.coursename";
$rs = $conn->query($sSQL);

$cnt = $rs->recordcount();
$conn->debug=false;

$href_search = "index.php?data=".base64_encode($userid.';kursus/jadual_kursus.php;kursus;jkursus');
?>
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar2.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
function do_cetak(id){
	document.ilim.action = 'kursus/cetak_buku_aturcara.php?id='+id;
	document.ilim.target = '_blank';
	document.ilim.submit();
}
function open_windows(URL){
	window.open (URL, "mywindow","location=1,status=1,scrollbars=1, width=100,height=100");
} //End "opennewsletter" function
function openModal(URL){
	//alert(URL);
	var height=screen.height-150;
	var width=screen.width-200;

	var returnValue = window.showModalDialog(URL, 'e-Visa','help:no;status:yes;scroll:yes;resize:yes;toolbar=yes;dialogHeight:'+height+'px;dialogWidth:'+width+'px');
} 
function open_windows1(URL){
	window.open (URL, "mywindow","location=1,status=1,scrollbars=1, width=90%,height=90%");
} //End "opennewsletter" function

function add_new(URL){
	var kid = document.ilim.kampus_id.value;
	if(kid==''){
		alert("Sila pilih maklumat kampus terlebih dahulu");
	} else {
		open_modal(URL+'&kampus_id='+kid,'Penambahan Maklumat Jadual Kursus',1,1)
	}
} //End "opennewsletter" function

</script>

<?php include_once 'include/list_head.php'; ?>
<!-- <form name="ilim" method="post" action=""> -->
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
                                    <div class="col-sm-12 col-md-8">
                                        <select class="form-control" name="kampus_id"  onchange="do_page('<?=$href_search;?>')">
                                            <option value="">-- Sila pilih kampus --</option>
                                            <?php while(!$rskks->EOF){ ?>
                                            <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus_id==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                                            <?php $rskks->movenext(); } ?>
                                        </select>
                                    </div>
                                </div>  
                                <?php } else { ?>

                                <input name="kampus_id" type="hidden" value="<?=$_SESSION['SESS_KAMPUS'];?>" />
                                <?php } ?>
                                <?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ";
                                    $sqlkk .= "  ORDER BY category_code";
                                    $rskk = &$conn->Execute($sqlkk);
                                ?>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori Kursus : </b></label>
                                    <div class="col-sm-12 col-md-8">
                                    <select class="form-control" name="kategori" onchange="do_page('<?=$href_search;?>')">
                                        <option value="">-- Sila pilih kategori --</option>
                                        <?php while(!$rskk->EOF){ ?>
                                        <option value="<?php print $rskk->fields['id'];?>" <?php if($kategori==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                                        <?php $rskk->movenext(); } ?>
                                    </select>
                                    <br>
                                    <label>
                                        <input type="checkbox" name="blaksana" value="1"<?php if($blaksana==1){ print 'checked="checked"'; }?> 
                                        onchange="do_page('<?=$href_search;?>')"/> Belum dilaksanakan</label>
                                    <label>
                                        <input type="checkbox" name="tlaksana" value="1"<?php if($tlaksana==1){ print 'checked="checked"'; }?> 
                                        onchange="do_page('<?=$href_search;?>')"/> Telah dilaksanakan</label>
                                    </div>
                                </div>
                                
                                <?php 
                                    $sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 "; //AND f_status=0 
                                    if($_SESSION["s_level"]<>'99'){ $sqlkks .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
                                    if(!empty($kampus_id)){ $sqlkks .= " AND kampus_id=".$kampus_id; }
                                    $sqlkks .=" ORDER BY f_status, f_category_code, SubCategoryNm";
                                    $rskks = &$conn->Execute($sqlkks);
                                ?>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat / Unit : </b></label>
                                    <div class="col-sm-12 col-md-8">
                                        <select class="form-control" name="subkategori" onchange="do_page('<?=$href_search;?>')">
                                            <option value="">-- Sila pilih sub-kategori --</option>
                                            <?php while(!$rskks->EOF){ 
                                                $stat = $rskks->fields['f_status'];
                                                $desc_stat='';
                                                if($stat==1){ $desc_stat=' (Tidak Aktif)'; }
                                            ?>
                                            <option value="<?php print $rskks->fields['id'];?>" <?php if($subkategori==$rskks->fields['id']){ print 'selected'; } 
                                            ?> <?php if($stat==1){ print 'style="text-decoration:line-through"'; }?>><?php print pusat_list($rskks->fields['id']);?><?=$desc_stat;?></option>
                                            <?php $rskks->movenext(); } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Bidang : </b></label>
                                    <div class="col-sm-12 col-md-8">
                                        <select class="form-control" name="bidang_id" onchange="do_page('<?=$href_search;?>')">
                                            <option value="">-- Sila pilih bidang --</option>
                                            <?php 
                                            $r_gred = &$conn->execute("SELECT * FROM _ref_kepakaran ORDER BY f_pakar_nama");
                                            while (!$r_gred->EOF){ ?>
                                            <option value="<?=$r_gred->fields['f_pakar_code'] ?>" 
                                            <?php if($bidang_id==$r_gred->fields['f_pakar_code']){ print "selected"; }?>><?=$r_gred->fields['f_pakar_nama']?></option>
                                            <?php $r_gred->movenext(); }?>        
                                        </select>
                                    </div>
                                </div>
    
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tarikh Mula Kursus : </b></label>
                                    <div class="col-sm-12 col-md-3">
                                        <input class="form-control" type="date" width="40%" name="tkh_mula" value="<?php echo $tkh_mula;?>">
                                        <alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                                            onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
                                    </div>
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-2"><b>Tarikh Tamat Kursus : </b></label>
                                    <div class="col-sm-12 col-md-3">
                                        <input class="form-control" type="date" width="40%" name="tkh_tamat" value="<?php echo $tkh_tamat;?>">
                                        <alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                                            onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/>
                                    </div>
                                </div>
                                <!-- ../cal/img/screenshot.gif -->

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Nama Kursus : </b></label>
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
                            <h4>Senarai Maklumat Kursus (Penjadualan)</h4>
                        </div>
                        <div class="card-body">
                            <table width="100%" cellpadding="3" cellspacing="0" border="0">
                                <tr class="title" >
                                    <td colspan="3" align="right">
                                        <?php $new_page = "modal_form.php?win=".base64_encode('kursus/jadual_kursus_form.php;');?>
                                            <button class="btn btn-success" title="Sila klik untuk menyimpan maklumat peserta" value="Tambah Maklumat Jadual Kursus" style="cursor:pointer" 
                                            onclick="add_new('<?=$new_page;?>')">&nbsp;&nbsp;
                                            <i class="fas fa-plus"></i> Tambah Maklumat Jadual Kursus </button> 
                                    </td>
                                </tr>

                                <?php include_once 'include/page_list.php'; ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table_kursusMohonList" name="table_kursusMohonList">
                                        <thead>
                                        <tr>
                                            <th width="2%" align="center"><b>Bil</b></th>
                                            <th width="3%" align="center"><b>Kod Kursus</b></th>
                                            <th width="22%" align="center">
                                            <a href="<?php echo $href_search."&sb=coursename&search=$search&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat"; ?>"><b>Diskripsi Kursus</b></a>&nbsp;
                                            <?php echo (($varSort=="coursename")?"<img src=\"../images/down_arrow.gif\">":"");?></th>
                                            <th width="2%" align="center"><b>Bidang</b></th>
                                            <th width="3%" align="center"><b>Pusat /Unit</b></th>
                                            <th width="20%" align="center"><a href="<?php echo $href_search."&sb=startdate&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat&search=$search"; ?>"><b>Tarikh Mula</b></a>&nbsp;
                                            <?php echo (($varSort=="startdate")?"<img src=\"../images/down_arrow.gif\">":"");?></th>
                                            <th width="20%" align="center"><a href="<?php echo $href_search."&sb=enddate&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat&search=$search"; ?>"><b>Tarikh Tamat</b></a>&nbsp;
                                            <?php echo (($varSort=="enddate")?"<img src=\"../images/down_arrow.gif\">":"");?></th>
                                            <th width="30%" align="center"><b>Tindakan</b></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(!$rs->EOF) { //$conn->debug=true;
                                            $cnt = 1;
                                            $bil = $StartRec;
                                            while(!$rs->EOF  && $cnt <= $pg) {
                                                $bil = $cnt + ($PageNo-1)*$PageSize;
                                                $href_link = "modal_form.php?win=".base64_encode('kursus/jadual_kursus_form.php;'.$rs->fields['id']);
                                                $href_surat = "modal_print.php?win=".base64_encode('kursus/jadual_peserta_surat_all.php;'.$rs->fields['id']);
                                                $href_surat_penceramah = "modal_form.php?win=".base64_encode('kursus/surat_penceramah.php;'.$rs->fields['id']);
                                                //$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['subcategory_code'],"Text"));
                                                $sqlsc = "SELECT SubCategoryNm, f_status FROM _tbl_kursus_catsub WHERE id=".tosql($rs->fields['subcategory_code'],"Text");
                                                $rssb = $conn->query($sqlsc);
                                                $unit = $rssb->fields['SubCategoryNm'];
                                                $f_status = $rssb->fields['f_status'];
                                                
                                                $kids=$rs->fields['KID'];
                                                if(empty($rs->fields['kampus_id'])){ 
                                                    $conn->execute("UPDATE _tbl_kursus_jadual SET kampus_id='{$kids}' WHERE id=".tosql($rs->fields['id']));
                                                }
                                                //$unit = pusat_kursus($rs->fields['subcategory_code']);
                                                //$stat_kursus = dlookup("_tbl_kursus_jadual_tukar","kat_perubahan","id_jadual_kursus=".tosql($rs->fields['id']));
                                                if($rs->fields['status']==2){ $status = '<br><font color="#FF0000"><b><i>Pembatalan Kursus</i></b></font>'; }
                                                else if($rs->fields['status']==3){ $status = '<br><font color="#FF0000"><b><i>Perubahan Tarikh Kursus</i></b></font>'; }
                                                else if($rs->fields['status']==1){ $status = '<br><font color="#FF0000"><b><i>Kursus Tidak Aktif</i></b></font>'; }
                                                else if($rs->fields['status']==9){ $status = '<br><font color="#FF0000"><b><i>Permohonan Kursus Ditutup</i></b></font>'; }
                                                else { $status=''; }
                                                $bidang = dlookup("_ref_kepakaran","f_pakar_nama","f_pakar_code=".tosql($rs->fields['bidang_id']));
                                                ?>
                                                <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                                                    <td valign="top" align="right"><?=$bil;?>.</td>
                                                    <td valign="top" align="left"><?php echo stripslashes($rs->fields['courseid']);?>
                                                        <br /><font style="font-size:9px"><?=$rs->fields['id'];?></font>
                                                    &nbsp;</td>
                                                    <td valign="top" align="left">
                                                        <?php if($f_status==1){ print '<div style="text-decoration:line-through">'; } ?>
                                                        <?php echo stripslashes($rs->fields['coursename']);?>
                                                        <?php if($f_status==1){ print '</div> <i>(Telah dihapuskan)</i>'; } ?>
                                                        <?php if(!empty($status)){ print $status; } ?>
                                                    &nbsp;</td>
                                                    <td valign="top" align="center"><?php echo stripslashes($bidang);?>&nbsp;</td>
                                                    <td valign="top" align="center"><?php echo stripslashes($unit);?>&nbsp;</td>
                                                    <td valign="top" align="center"><?php echo date('d-m-Y', strtotime($rs->fields['startdate']))?>&nbsp;</td>
                                                    <td valign="top" align="center"><?php echo date('d-m-Y', strtotime($rs->fields['enddate']))?>&nbsp;</td>
                                                    <!-- <td valign="top" align="center"><?//php echo DisplayDate($rs->fields['startdate'])?>&nbsp;</td> -->
                                                    <!-- <td valign="top" align="center"><?//php echo DisplayDate($rs->fields['enddate'])?>&nbsp;</td> -->
                                                    <td align="center">
                                                        <?php //if(empty($status)){ ?>
                                                            <?php //print $_SESSION["s_jabatan"]."/".$rs->fields['subcategory_code']."/".$_SESSION["s_level"];?>
                                                            <?php if($_SESSION["s_jabatan"]==$rs->fields['subcategory_code'] || 
                                                            $_SESSION["s_level"]==1 || $_SESSION["s_level"]==99){ ?>
                                                            <button class="btn btn-warning" style="cursor:pointer; padding:8px;" title="Sila klik untuk pengemaskinian data"  
                                                            onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Jadual Kursus',1,1)"><i class="fas fa-edit"></i></button>
                                                            <button class="btn btn-info" style="cursor:pointer; padding:9px;" title="Sila klik untuk mencetak surat pengesahan kehadiran" 
                                                            onclick="openModal('<?=$href_surat;?>')" ><i class="fas fa-print"></i></button>
                                                            <!-- <img src="../img/printer_icon4.jpg" width="23" height="23" style="cursor:pointer" title="Sila klik untuk mencetak surat pengesahan kehadiran" 
                                                            onclick="openModal('<?//=$href_surat;?>')" /> -->
                                                            <!--&nbsp;
                                                            <img src="../images/cert.gif" width="23" height="23" border="0" style="cursor:pointer" title="Sila klik untuk cetakan buku aturcara" 
                                                            onclick="do_cetak('<?=$rs->fields['id']?>')" />-->
                                                            &nbsp;
                                                            <button class="btn btn-secondary" style="cursor:pointer; padding:9px;" 
                                                            title="Sila klik untuk mencetak Cetak surat jemputan kepada Penceramah @ Pensyarah" 
                                                            onclick="openModal('<?=$href_surat_penceramah;?>&evid=<?=$rs->fields['id'];?>','Cetak surat jemputan kepada Penceramah @ Pensyarah',1,1)" ><i class="fas fa-print"></i></button>
                                                            <!-- <img src="../img/printer_icon1.jpg" width="23" height="23" style="cursor:pointer" 
                                                            title="Sila klik untuk mencetak Cetak surat jemputan kepada Penceramah @ Pensyarah" 
                                                            onclick="openModal('<?//=$href_surat_penceramah;?>&evid=<?//=$rs->fields['id'];?>','Cetak surat jemputan kepada Penceramah @ Pensyarah',1,1)" /> -->
                                                            <?php } ?>
                                                        <!--<?php //} else { ?>
                                                            <img src="../img/faq.gif" width="23" height="23" style="cursor:pointer" />
                                                        <?php //} ?>-->
                                                    &nbsp;</td>
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
<!-- </form> -->