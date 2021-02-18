<?php
//$conn->debug=true;
$kampus=isset($_REQUEST["kampus"])?$_REQUEST["kampus"]:"";
$skat=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
$bidang=isset($_REQUEST["bidang"])?$_REQUEST["bidang"]:"";
?>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tbody>
	<tr><td width="100%">
    <?php $href_link = "modal_form.php?win=".base64_encode('katalog/semakan_permohonan.php;'); ?>
    	<div style="float:left;width:100%">
        	<div style="float:left;width:100%">
                <a href="index.php"><img src="images/btn-katalog.png"></a>&nbsp;&nbsp;
                
                <!--<img src="images/btn-status.png" style="cursor:pointer" 
                onClick="open_modal('<?=$href_link;?>','Semakan Permohonan',70,70)">&nbsp;&nbsp;-->
                <a href="index.php?pages=katalog/semakan_permohonan"><img src="images/btn-status.png" style="cursor:pointer"></a>&nbsp;&nbsp;
                
                <!--<a href="katalog/Taqwim-ILTIM-tahun2016.pdf" target="_blank"><img src="images/btn-iltim.png"></a>&nbsp;&nbsp;-->
             	
                <div align="right" style="float:right">
                    <div align="left">
                    Sila pilih pusat/bidang bagi mendapatkan maklumat yang dikehendaki.</div>
                <table width="100%" cellpadding="4" cellspacing="1" border="0">
					<?php 
                        $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
                        $rskks = $conn->Execute($sqlkks);
                    ?>
                	<tr>
                    	<td width="30%"><b>Pusat Latihan : </b></td>
                        <td width="70%">
                            <select name="kampus" onchange="do_page('<?=$href_search;?>')" style="width:90%;cursor:pointer" >
                                <option value="">-- Sila pilih kampus --</option>
                                <?php while(!$rskks->EOF){ ?>
                                <option value="<?php print $rskks->fields['kampus_id'];?>" 
								<?php if($kampus==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                                <?php $rskks->movenext(); } ?>
                            </select>
                        </td>
                    </tr>
					<?php 
                        $sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 AND f_category_code=1 AND f_status=0 
						ORDER BY SubCategoryNm";
                        // $rskks = &$conn->Execute($sqlkks);
                    ?>
                    <tr>
                    	<td><b>Bidang : </b></td>
                        <td>
                            <select name="bidang" onchange="do_page('<?=$href_search;?>')" style="cursor:pointer;max-width:90%;min-width:90%" 
                            	title="Sila buat pilihan untuk senarai kursus">
                            <option value="" style="max-width:90%;min-width:90%" >-- Sila pilih bidang --</option>
                            <?php 
                            $r_gred = &$conn->execute("SELECT * FROM _ref_kepakaran ORDER BY f_pakar_nama");
                            while (!$r_gred->EOF){ ?>
                            <option value="<?=$r_gred->fields['f_pakar_code'] ?>" <?php if($bidang==$r_gred->fields['f_pakar_code']) print "selected"; ?> >
                            <?=$r_gred->fields['f_pakar_nama']?></option>
                            <?php $r_gred->movenext(); }?>        
                           </select>
                        </td>
                    </tr>


                 </table>
           </div>
        </div>
    </td></tr>
</tbody></table>
<?php
//$conn->debug=true;
$href_search = "index.php";

$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd AS SUB, B.subcategory_code, C.kampus_kod, B.kampus_id AS KID, B.bidang_id  
FROM _tbl_kursus_jadual A, _tbl_kursus B, _ref_kampus C";
$sSQL.= " , _tbl_kursus_catsub D";  
$sSQL.= " WHERE A.courseid=B.id AND B.kampus_id=C.kampus_id AND B.is_deleted=0 AND A.status<>1 "; //AND year(A.enddate)>=".tosql(date("Y"));
$sSQL.=" AND B.subcategory_code=D.id AND D.f_status=0 AND D.is_deleted=0";
if(date("m")==12){
	$sSQL.= " AND A.enddate>=".tosql(date("Y-m-d"));
} else {
	$sSQL.= " AND month(A.enddate)>=".tosql(date("m")) ." AND A.enddate>=".tosql(date("Y-m-d"));
}
if(!empty($kampus)){ $sSQL.=" AND C.kampus_id=".tosql($kampus,"Text"); } 
if(!empty($bidang)){ $sSQL.=" AND B.bidang_id=".tosql($bidang,"Text"); } 
if(!empty($search)){ $sSQL.=" AND B.coursename LIKE '%".$search."%' "; } 
if(!empty($kategori)){ $sSQL.=" AND B.category_code=".tosql($kategori,"Text"); } 
if(!empty($subkategori)){ $sSQL.=" AND B.subcategory_code=".tosql($subkategori,"Text"); } 
if(!empty($tkh_mula) && empty($tkh_tamat)){ $sSQL.=" AND A.startdate>=".tosql(DBDate($tkh_mula),"Text"); } 
if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sSQL.=" AND A.startdate BETWEEN ".tosql(DBDate($tkh_mula),"Text")." AND ".tosql(DBDate($tkh_tamat),"Text"); } 
//$strSort=((strlen($varSort)>0)?"ORDER BY $varSort ":"ORDER BY coursename ");
if($varSort=='coursename'){ 
	$strSort=((strlen($varSort)>0)?" ORDER BY $varSort ASC":" ORDER BY startdate ASC");
} else {
	$strSort=((strlen($varSort)>0)?" ORDER BY $varSort DESC":" ORDER BY startdate ASC");
}
$sSQL .= $strSort; //"ORDER BY B.coursename";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;
$href_search = "index.php?data=".base64_encode('user;senarai.php;kursus;');
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
</script>
<br />
<table width="99%" align="center" cellpadding="2" cellspacing="0" border="0">
	<!--<tr>
		<td width="30%" align="right"><b>Tarikh Kursus : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
        	Mula : 
			<input type="text" size="13" name="tkh_mula" value="<?php //echo $tkh_mula;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
            &nbsp;&nbsp;&nbsp;Tamat : 
			<input type="text" size="13" name="tkh_tamat" value="<?php //echo $tkh_tamat;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/> [dd/mm/yyyy]
		</td>
	</tr>-->
</table>	
<?php include_once 'include/list_head.php'; ?>
<table width="100%" align="center" cellpadding="2" cellspacing="0" border="0">
	<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="5" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT KATALOG KURSUS</strong></font>
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="10%" align="center"><b>Kod Kursus</b></td>
                    <td width="45%" align="center"><b>Diskripsi Kursus</b></td>
                    <td width="10%" align="center"><b>Bidang</b></td>
                    <td width="10%" align="center"><b>Tempat Kursus</b></td>
                    <td width="10%" align="center"><b>Tarikh Kursus</b></td>
                    <td width="10%" align="center"><b>Status</b></td>
                </tr>
				<?php
                if(!$rs->EOF) { 
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$del='';
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode('katalog/view_katalog.php;'.$rs->fields['id']);
                		$href_link1 = "index.php?pages=katalog/view_katalog1&id=".$rs->fields['id'];
						/*$cntk = dlookup("_tbl_kursus_jadual","count(*)","courseid=".tosql($rs->fields['id'],"Text"));*/
						//$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['subcategory_code'],"Text"));
						//$unit = pusat_kursus();
						if($rs->fields['startdate']<=date("Y-m-d")){ $disp = '<font color="#FF0000">Tutup</font>'; } else { $disp='Buka'; }
						if($rs->fields['status']=='2'){ $disp = '<font color="#FF0000"><b>Telah Dibatalkan</b></font>'; }
						else if($rs->fields['status']=='9'){ $disp = '<font color="#FF0000">Tutup</font>'; }
						$pusat = dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rs->fields['KID']));
						$bidang = dlookup("_ref_kepakaran","f_pakar_nama","f_pakar_code=".tosql($rs->fields['bidang_id']));
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="center">
							<!--<label onclick="open_modal('<?=$href_link;?>','Katalog Kursus',80,80)" style="cursor:pointer" 
                            	title="Kursus ini akan diadakan di <?=$pusat;?>">-->
                            <label onclick="do_page('<?=$href_link1;?>')" style="cursor:pointer" 
                            	title="Kursus ini akan diadakan di <?=$pusat;?>">    
                            <u><b><?php echo stripslashes($rs->fields['courseid']);?></b></u></label>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['coursename']);?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo stripslashes($bidang);?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo stripslashes($rs->fields['kampus_kod']);?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo DisplayDate($rs->fields['startdate'])?><br />-<br />
                            <?php echo DisplayDate($rs->fields['enddate'])?>&nbsp;</td>
                            <td valign="top" align="center"><?php echo stripslashes($disp);?>&nbsp;</td>
                        </tr>
                        <?php
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
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