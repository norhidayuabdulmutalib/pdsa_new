<?php
//$conn->debug=true;
$kampus=isset($_REQUEST["kampus"])?$_REQUEST["kampus"]:"";
$skat=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
?>
<table width="900px" align="center" border="0" cellpadding="0" cellspacing="0">
<tbody>
	<tr><td width="100%">
    <?php $href_link = "modal_form.php?win=".base64_encode('katalog/semakan_permohonan.php;'); ?>
    	<div style="float:left;width:900px">
        	<div style="float:left;width:900px">
                <a href="index.php"><img src="images/btn-katalog.png"></a>&nbsp;&nbsp;
                <img src="images/btn-status.png" style="cursor:pointer" 
                onClick="open_modal('<?=$href_link;?>','Semakan Permohonan',70,70)">&nbsp;&nbsp;
                <a href="katalog/Taqwim-ILTIM-tahun2016.pdf" target="_blank"><img src="images/btn-iltim.png"></a>&nbsp;&nbsp;
             	<div align="right" style="float:right">
                <table width="100%" cellpadding="4" cellspacing="1" border="0">
					<?php 
                        $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
                        $rskks = &$conn->Execute($sqlkks);
                    ?>
                	<tr>
                    	<td width="30%"><b>Pusat Latihan : </b></td>
                        <td width="70%">
                            <select name="kampus" onchange="do_page('<?=$href_search;?>')" style="width:100%">
                                <option value="">-- Sila pilih kampus --</option>
                                <?php while(!$rskks->EOF){ ?>
                                <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                                <?php $rskks->movenext(); } ?>
                            </select>
                        </td>
                    </tr>
					<?php 
                        $sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 AND f_category_code=1 AND f_status=0 
						ORDER BY SubCategoryNm";
                        $rskks = &$conn->Execute($sqlkks);
                    ?>
                    <tr>
                    	<td><b>Bidang : </b></td>
                        <td>
                            <select name="subkategori" onchange="do_page('<?=$href_search;?>')" style="width:100%">
                                <option value="">-- Sila pilih sub-kategori --</option>
                                <?php while(!$rskks->EOF){ ?>
                                <option value="<?php print $rskks->fields['id'];?>" <?php if($skat==$rskks->fields['id']){ print 'selected'; }?>><?php print $rskks->fields['SubCategoryDesc'];?><?//=$subkategori."/".$rskks->fields['id'];?></option>
                                <?php $rskks->movenext(); } ?>
                            </select>
                        
                        </td>
                    </tr>
                    <div align="left">
                    Sila pilih pusat/unit bagi mendapatkan maklumat yang dikehendaki.</div>
                    <!--<b>Log Masuk Sebagai : </b>
                    <select name="logs" onChange="do_login(this)">
                        <option value=""></option>
                        <option value="login_staff">Kakitangan</option>
                        <option value="login_asrama">Domistik</option>
                        <option value="login_pensyarah">Pensyarah</option>
                        <option value="login_peserta">Peserta</option>
                    </select>-->
                    </div>
                 </table>
           </div>
        </div>
    </td></tr>
</tbody></table>
<?
//$conn->debug=true;
$href_search = "index.php";

$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd AS SUB, B.subcategory_code, C.kampus_kod  
FROM _tbl_kursus_jadual A, _tbl_kursus B, _ref_kampus C 
WHERE A.courseid=B.id AND A.kampus_id=C.kampus_id AND B.is_deleted=0 AND A.status<>1 "; //AND year(A.enddate)>=".tosql(date("Y"));
if(date("m")==12){
	$sSQL.= " AND A.enddate>=".tosql(date("Y-m-d"));
} else {
	$sSQL.= " AND month(A.enddate)>=".tosql(date("m")) ." AND A.enddate>=".tosql(date("Y-m-d"));
}
if(!empty($kampus)){ $sSQL.=" AND C.kampus_id=".tosql($kampus,"Text"); } 
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
			<input type="text" size="13" name="tkh_mula" value="<? echo $tkh_mula;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
            &nbsp;&nbsp;&nbsp;Tamat : 
			<input type="text" size="13" name="tkh_tamat" value="<? echo $tkh_tamat;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/> [dd/mm/yyyy]
		</td>
	</tr>-->
</table>	
<? include_once 'apps/include/list_head.php'; ?>
<table width="100%" align="center" cellpadding="2" cellspacing="0" border="0">
	<? include_once 'apps/include/page_list.php'; ?>
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
                    <td width="10%" align="center"><b>Tempat Kursus</b></td>
                    <td width="15%" align="center"><b>Tarikh Kursus</b></td>
                    <td width="15%" align="center"><b>Status</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$del='';
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode('katalog/view_katalog.php;'.$rs->fields['id']);
						/*$cntk = dlookup("_tbl_kursus_jadual","count(*)","courseid=".tosql($rs->fields['id'],"Text"));*/
						//$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['subcategory_code'],"Text"));
						//$unit = pusat_kursus();
						if($rs->fields['startdate']<=date("Y-m-d")){ $disp = '<font color="#FF0000">Tutup</font>'; } else { $disp='Buka'; }
						if($rs->fields['status']=='2'){ $disp = '<font color="#FF0000"><b>Telah Dibatalkan</b></font>'; }
						else if($rs->fields['status']=='9'){ $disp = '<font color="#FF0000">Tutup</font>'; }
						$pusat = dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rs->fields['kampus_id']))
                        ?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="center">
							<label onclick="open_modal('<?=$href_link;?>','Katalog Kursus',80,80)" style="cursor:pointer" 
                            	title="Kursus ini akan diadakan di <?=$pusat;?>">
                            <u><b><? echo stripslashes($rs->fields['courseid']);?></b></u></label>&nbsp;</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['coursename']);?>&nbsp;</td>
            				<td valign="top" align="center"><? echo stripslashes($rs->fields['kampus_kod']);?>&nbsp;</td>
            				<td valign="top" align="center"><? echo DisplayDate($rs->fields['startdate'])?><br />-<br />
                            <? echo DisplayDate($rs->fields['enddate'])?>&nbsp;</td>
                            <td valign="top" align="center"><? echo stripslashes($disp);?>&nbsp;</td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <? } ?>                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">	
<?
if($cnt<>0){
	$sFileName=$href_search;
	include_once 'apps/include/list_footer.php'; 
}
?> 
</td></tr>
<tr><td>        
</td></td>
</table> 