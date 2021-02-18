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
$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd AS SUB, B.subcategory_code, B.bidang_id 
FROM _tbl_kursus_jadual A, _tbl_kursus B 
WHERE A.courseid=B.id AND B.is_deleted=0 ";
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
//$strSort=((strlen($varSort)>0)?"ORDER BY $enddate ":"ORDER BY enddate ");
$sSQL .= $strSort; //"ORDER BY B.coursename";
$rs = &$conn->Execute($sSQL);
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

</script>
<?php include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="2" cellspacing="0" border="0">
	<?php if($_SESSION["s_level"]=='99'){
	  //$conn->debug=true;
        $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td width="30%" align="right"><b>Pusat Latihan : </b></td>
        <td width="70%" align="left">&nbsp;&nbsp;
            <select name="kampus_id" style="width:90%" onchange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih kampus --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus_id==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </td>
    </tr>
    <?php } ?>
	<?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ";
		$sqlkk .= "  ORDER BY category_code";
		$rskk = &$conn->Execute($sqlkk);
	?>
	<tr>
		<td width="30%" align="right"><b>Kategori Kursus : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
        	<select name="kategori">
            	<option value="">-- Sila pilih kategori --</option>
                <?php while(!$rskk->EOF){ ?>
                <option value="<?php print $rskk->fields['id'];?>" <?php if($kategori==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                <?php $rskk->movenext(); } ?>
            </select>
			&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="blaksana" value="1"<?php if($blaksana==1){ print 'checked="checked"'; }?> 
            	onchange="do_page('<?=$href_search;?>')"/>Belum dilaksanakan&nbsp;&nbsp;
            <input type="checkbox" name="tlaksana" value="1"<?php if($tlaksana==1){ print 'checked="checked"'; }?> 
            	onchange="do_page('<?=$href_search;?>')"/>Telah dilaksanakan&nbsp;&nbsp;
		</td>
    </tr>
	<?php 
		$sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 AND f_status=0 ";
		if($_SESSION["s_level"]<>'99'){ $sqlkks .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
		if(!empty($kampus_id)){ $sqlkks .= " AND kampus_id=".$kampus_id; }
		$sqlkks .=" ORDER BY SubCategoryNm";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td align="right"><b>Pusat / Unit : </b></td> 
        <td align="left" colspan="2" >&nbsp;&nbsp;
            <select name="subkategori" style="width:90%" onchange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih sub-kategori --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['id'];?>" <?php if($subkategori==$rskks->fields['id']){ print 'selected'; }?>><?php print pusat_list($rskks->fields['id']);?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right"><b>Bidang : </b></td>
        <td>&nbsp;&nbsp;
            <select name="bidang_id" style="width:90%" onchange="do_page('<?=$href_search;?>')">
            <option value="">-- Sila pilih bidang --</option>
            <?php 
            $r_gred = &$conn->execute("SELECT * FROM _ref_kepakaran ORDER BY f_pakar_nama");
            while (!$r_gred->EOF){ ?>
            <option value="<?=$r_gred->fields['f_pakar_code'] ?>" 
            <?php if($bidang_id==$r_gred->fields['f_pakar_code']){ print "selected"; }?>><?=$r_gred->fields['f_pakar_nama']?></option>
            <?php $r_gred->movenext(); }?>        
           </select>
        </td>
    </tr>
	<tr>
		<td width="30%" align="right"><b>Tarikh Kursus : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
        	Mula : 
			<input type="text" size="13" name="tkh_mula" value="<? echo $tkh_mula;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
            &nbsp;&nbsp;&nbsp;Tamat : 
			<input type="text" size="13" name="tkh_tamat" value="<? echo $tkh_tamat;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/> [dd/mm/yyyy]
		</td>
	</tr>
	<tr>
		<td width="30%" align="right"><b>Nama Kursus : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
	<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT KURSUS (PENJADUALAN)</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<?php $new_page = "modal_form.php?win=".base64_encode('kursus/jadual_kursus_form.php;');?>
        	<input type="button" value="Tambah Maklumat Jadual Kursus" style="cursor:pointer" 
            onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Jadual Kursus',1,1)" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="1" cellpadding="5" cellspacing="0" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="8%" align="center"><b>Kod Kursus</b></td>
                    <td width="35%" align="center">
                    <a href="<?php echo $href_search."&sb=coursename&search=$search&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat"; ?>"><b>Diskripsi Kursus</b></a>&nbsp;
					<?php echo (($varSort=="coursename")?"<img src=\"../images/down_arrow.gif\">":"");?></td>
                    <td width="10%" align="center"><b>Bidang</b></td>
                    <td width="5%" align="center"><b>Pusat /Unit</b></td>
                    <td width="10%" align="center"><a href="<?php echo $href_search."&sb=startdate&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat&search=$search"; ?>"><b>Tarikh Mula</b></a>&nbsp;
					<?php echo (($varSort=="startdate")?"<img src=\"../images/down_arrow.gif\">":"");?></td>
                    <td width="10%" align="center"><a href="<?php echo $href_search."&sb=enddate&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat&search=$search"; ?>"><b>Tarikh Tamat</b></a>&nbsp;
					<?php echo (($varSort=="enddate")?"<img src=\"../images/down_arrow.gif\">":"");?></td>
                    <td width="10%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?php
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode('kursus/jadual_kursus_form.php;'.$rs->fields['id']);
						$href_surat = "modal_print.php?win=".base64_encode('kursus/jadual_peserta_surat_all.php;'.$rs->fields['id']);
						$href_surat_penceramah = "modal_form.php?win=".base64_encode('kursus/surat_penceramah.php;'.$rs->fields['id']);
						$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['subcategory_code'],"Text"));
						//$unit = pusat_kursus($rs->fields['subcategory_code']);
						//$stat_kursus = dlookup("_tbl_kursus_jadual_tukar","kat_perubahan","id_jadual_kursus=".tosql($rs->fields['id']));
						if($rs->fields['status']==2){ $status = '<br><font color="#FF0000"><b><i>Pembatalan Kursus</i></b></font>'; }
						else if($rs->fields['status']==3){ $status = '<br><font color="#FF0000"><b><i>Perubahan Tarikh Kursus</i></b></font>'; }
						else if($rs->fields['status']==1){ $status = '<br><font color="#FF0000"><b><i>Kursus Tidak Aktif</i></b></font>'; }
						else if($rs->fields['status']==9){ $status = '<br><font color="#FF0000"><b><i>Permohonan Kursus Ditutup</i></b></font>'; }
						else { $status=''; }
						$bidang = dlookup("_ref_kepakaran","f_pakar_nama","f_pakar_code=".tosql($rs->fields['bidang_id']));
                        ?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['courseid']);?>&nbsp;</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['coursename']);?>
                            	<?php if(!empty($status)){ print $status; } ?>
                            &nbsp;</td>
            				<td valign="top" align="center"><? echo stripslashes($bidang);?>&nbsp;</td>
            				<td valign="top" align="center"><? echo stripslashes($unit);?>&nbsp;</td>
            				<td valign="top" align="center"><? echo DisplayDate($rs->fields['startdate'])?>&nbsp;</td>
            				<td valign="top" align="center"><? echo DisplayDate($rs->fields['enddate'])?>&nbsp;</td>
                            <td align="center">
                            	<?php //if(empty($status)){ ?>
									<?php //print $_SESSION["s_jabatan"]."/".$rs->fields['subcategory_code']."/".$_SESSION["s_level"];?>
                                    <?php if($_SESSION["s_jabatan"]==$rs->fields['subcategory_code'] || 
									$_SESSION["s_level"]==1 || $_SESSION["s_level"]==99){ ?>
                                    <img src="../img/icon-info1.gif" width="23" height="23" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                    onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Jadual Kursus',1,1)" />
                                    &nbsp;
                                    <img src="../img/printer_icon4.jpg" width="23" height="23" style="cursor:pointer" title="Sila klik untuk mencetak surat pengesahan kehadiran" 
                                    onclick="openModal('<?=$href_surat;?>')" />
                                    <!--&nbsp;
                                    <img src="../images/cert.gif" width="23" height="23" border="0" style="cursor:pointer" title="Sila klik untuk cetakan buku aturcara" 
                                    onclick="do_cetak('<?=$rs->fields['id']?>')" />-->
                                    &nbsp;
                                    <img src="../img/printer_icon1.jpg" width="23" height="23" style="cursor:pointer" 
                                    title="Sila klik untuk mencetak Cetak surat jemputan kepada Penceramah @ Pensyarah" 
                                    onclick="openModal('<?=$href_surat_penceramah;?>&evid=<?=$rs->fields['id'];?>','Cetak surat jemputan kepada Penceramah @ Pensyarah',1,1)" />
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
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">	
<?php
if($cnt<>0){
	$sFileName=$href_search;
	include_once 'include/list_footer.php'; 
}
?> 
</td></tr>
<tr><td>        
</td></td>
</table> 
</form>
